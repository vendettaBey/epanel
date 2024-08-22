@extends('layouts.app')

@section('title', 'Blog Kategoriler')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kategoriler</h3>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark me-5 btn-lg" href="{{ route('blogs') }}">Bloglar</a>
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#categoryModal">Yeni Kategori Ekle</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="categoryTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Adı</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr data-id="{{ $category->id }}">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if ($category->status)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm editCategoryBtn" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-status="{{ $category->status }}" data-bs-toggle="modal" data-bs-target="#categoryModal">Düzenle</button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory({{ $category->id }})">Sil</button>
                                                <button type="button" class="btn btn-info btn-sm" onclick="toggleStatus({{ $category->id }})">
                                                    @if($category->status) Pasif Yap @else Aktif Yap @endif
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

    <!-- Kategori Ekle/Düzenle Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Yeni Kategori Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm" action="{{ route('blog-categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Kategori Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        // Kategori Düzenleme İşlemi
        document.querySelectorAll('.editCategoryBtn').forEach(button => {
            button.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-id');
                const categoryName = this.getAttribute('data-name');
                const categoryStatus = this.getAttribute('data-status');

                document.getElementById('category_id').value = categoryId;
                document.getElementById('name').value = categoryName;

                // Modal başlığını "Kategori Düzenle" olarak değiştir
                document.getElementById('categoryModalLabel').innerText = 'Kategori Düzenle';

                // Formun action URL'sini ve methodunu güncelle
                const form = document.getElementById('categoryForm');
                form.action = `/blog-categories/${categoryId}`;
                form.method = 'POST';

                // Method spoofing için _method hidden input ekle
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            });
        });

        // Modal kapatıldığında formu sıfırla
        $('#categoryModal').on('hidden.bs.modal', function () {
            const form = document.getElementById('categoryForm');
            form.reset();
            document.getElementById('category_id').value = '';
            document.getElementById('categoryModalLabel').innerText = 'Yeni Kategori Ekle';
            form.action = '{{ route('blog-categories.store') }}';
            form.method = 'POST';

            // Eklenen _method hidden input'u kaldır
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
        });

        // Kategori Silme İşlemi
        function deleteCategory(categoryId) {
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
                        url: `/blog-categories/${categoryId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Kategori başarıyla silindi!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Kategori silinirken bir hata oluştu.',
                            });
                        }
                    });
                }
            });
        }

        // Kategori Durum Güncelleme İşlemi
        function toggleStatus(categoryId) {
            $.ajax({
                url: `/blog-categories/${categoryId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: 'Kategori durumu güncellendi!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'Kategori durumu güncellenirken bir hata oluştu.',
                    });
                }
            });
        }
    </script>

@endsection
