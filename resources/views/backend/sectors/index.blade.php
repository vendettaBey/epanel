@extends('layouts.app')

@section('title', 'Sektörler')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="fw-bold">Sektörler</h3>
                <br>
                <div class="card">
                    <a href="{{ route('sectors.create') }}">
                        <button type="button" class="btn btn-primary float-end">Yeni Sektör Ekle</button>
                    </a>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Adı</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectors as $sector)
                                        <tr>
                                            <td>{{ $sector->id }}</td>
                                            <td>{{ $sector->name }}</td>
                                            <td>{!! $sector->description !!}</td>
                                            <td>
                                                @if ($sector->status == 1)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('sectors.edit', $sector->id) }}"><button type="button"
                                                        class="btn btn-primary btn-sm">Düzenle</button></a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSector({{ $sector->id }})">Sil</button>
                                                <a href="{{ route('sectors.status', $sector->id) }}"><button type="button"
                                                        class="btn @if($sector->status == 1)btn-danger @else btn-success @endif btn-sm">@if($sector->status == 1)Pasif @else Aktif @endif</button></a>
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
        function deleteSector(sectorId) {
            Swal.fire({
                title: 'Silmek istediğinize emin misiniz?',
                text: "Bu işlemi geri alamazsınız! Bu sektöre ait hizmetlerde silinecektir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/sectors/destroy/' + sectorId;
                }
            })
        }
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif


@endsection
