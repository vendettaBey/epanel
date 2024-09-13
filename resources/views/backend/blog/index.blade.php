@extends('layouts.app')

@section('title', 'Bloglar')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row">
            <h3 class="fw-bold">Bloglar</h3>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('blogs.create') }}">
                                <button type="button" class="btn btn-primary me-5 btn-lg">Yeni Blog Ekle</button>
                            </a>
                            <a href="{{ route('blog-categories') }}">
                                <button type="button" class="btn btn-success btn-lg">Blog Kategorileri</button>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="blogsTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Başlık</th>
                                        <th>Yazar</th>
                                        <th>Zaman</th>
                                        <th>Görsel</th>
                                        <th>Kategoriler</th>
                                        <th>İçerik</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr data-id="{{ $blog->id }}">
                                            <td>{{ $blog->id }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->author }}</td>
                                            <td>{{ $blog->time }}</td>
                                            <td>
                                                @if ($blog->image)
                                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->image }}"
                                                        class="img-thumbnail" style="width: 100px;">
                                                @endif
                                            </td>
                                            <td>

                                                @php
                                                    if ($blog->tags != null && $blog->tags != '') {
                                                        $categoryIds = explode(',', $blog->tags) ?? [];
                                                        if (!empty($categoryIds)) {
                                                            $categoryNames = \App\Models\BlogCategory::whereIn(
                                                                'id',
                                                                $categoryIds,
                                                            )
                                                                ->pluck('name')
                                                                ->toArray();
                                                            foreach ($categoryNames as $key => $value) {
                                                                echo '#' . $value . '<br>';
                                                            }
                                                        }
                                                    } else {
                                                        echo 'Kategori Bulunamadı';
                                                    }
                                                @endphp

                                            </td>
                                            <td>{!! Str::limit(strip_tags($blog->content), 50, '...') !!}</td>
                                            <td>
                                                <a href="{{ route('blogs.edit', $blog->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm">Düzenle</button>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteBlog({{ $blog->id }})">Sil</button>
                                                <button type="button" class="btn btn-info btn-sm"
                                                    onclick="toggleStatus({{ $blog->id }})">
                                                    @if ($blog->status)
                                                        Pasif Yap
                                                    @else
                                                        Aktif Yap
                                                    @endif
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Blog Silme İşlemi
        function deleteBlog(blogId) {
            Swal.fire({
                title: 'Silmek istediğinize emin misiniz?',
                text: "Bu işlemi geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/blogs/destroy/${blogId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Blog başarıyla silindi!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Blog silinirken bir hata oluştu.',
                            });
                        }
                    });
                }
            });
        }

        // Blog Durum Güncelleme İşlemi
        function toggleStatus(blogId) {
            $.ajax({
                url: `/blogs/${blogId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: 'Blog durumu güncellendi!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'Blog durumu güncellenirken bir hata oluştu.',
                    });
                }
            });
        }
    </script>

@endsection
