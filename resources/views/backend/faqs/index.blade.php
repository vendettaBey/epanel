@extends('layouts.app')
@section('title', 'Sıkça Sorulan Sorular')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <h3 class="fw-bold">Sıkça Sorulan Sorular</h3>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('faqs.create') }}" class="btn btn-primary float-end">Yeni Soru Ekle</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Soru</th>
                                    <th>Cevap</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->question }}</td>
                                        <td>{!! $faq->answer !!}</td>
                                        <td>
                                            @if ($faq->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('faqs.edit', $faq->id) }}"
                                                    class="btn btn-info">Düzenle</a>
                                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST"
                                                    style="display:inline;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger delete-button">Sil</button>
                                                </form>
                                                <a href="{{ route('faqs.status', $faq->id) }}"
                                                    class="btn @if ($faq->is_active) btn-danger @else btn-success @endif ">
                                                    @if ($faq->is_active)
                                                        Pasif
                                                    @else
                                                        Aktif
                                                    @endif
                                                </a>
                                            </div>
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
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu işlemi geri alamazsınız!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: 'Hayır, iptal et'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
