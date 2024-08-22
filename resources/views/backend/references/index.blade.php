<!-- resources/views/references/index.blade.php -->
@extends('layouts.app')
@section('title', 'Referanslar')
@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-12 d-flex justify-content-between">
                <h3>Referanslar</h3>
                <a href="{{ route('references.create') }}" class="btn btn-primary btn-lg">Yeni Referans Ekle</a>
            </div>
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Firma Adı</th>
                            <th>Logo</th>
                            <th>Not</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($references as $reference)
                            <tr>
                                <td><strong>{{ $reference->name }}</strong></td>
                                <td>
                                    @if($reference->logo)
                                        <img src="{{ asset($reference->logo) }}" alt="{{ $reference->company_name }} Logo" class="img-thumbnail" style="width: 100px;">
                                    @endif
                                </td>
                                <td>
                                    @if($reference->note)
                                        {{ $reference->note }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($reference->status == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('references.edit', $reference->id) }}" class="btn btn-info btn-sm">Düzenle</a>
                                    <form action="{{ route('references.destroy', $reference->id) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">Sil</button>
                                    </form>
                                    <a href="{{ route('references.status', $reference->id) }}" class="btn @if($reference->status == 1)btn-danger @else btn-success @endif btn-sm">@if($reference->status == 1)Pasif @else Aktif @endif</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(session('success'))
        <script>
            swal.fire({
                title: 'Başarılı!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Tamam'
            });
        </script>        
    @endif

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                let form = this.closest('.delete-form');
                swal.fire({
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
