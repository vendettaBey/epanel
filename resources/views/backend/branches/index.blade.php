@extends('layouts.app')

@section('title', 'Şubeler')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <h3 class="fw-bold">Şubeler</h3>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('branches.create') }}"><button type="button" class="btn btn-primary float-end">Yeni
                                Şube Ekle</button></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Adı</th>
                                        <th>Adres</th>
                                        <th>Telefon</th>
                                        <th>Email</th>
                                        <th>Durum</th>
                                        <th>Görsel</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($branches as $branch)
                                        <tr>
                                            <td>{{ $branch->id }}</td>
                                            <td>{{ $branch->name }}</td>
                                            <td>{!! $branch->address !!}</td>
                                            <td>{{ $branch->phone }}</td>
                                            <td>{{ $branch->email }}</td>
                                            <td>
                                                @if ($branch->status == 1)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <img src="{{ $branch->image }}" alt="{{ $branch->name }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('branches.edit', $branch->id) }}"><button type="button"
                                                        class="btn btn-primary btn-sm">Düzenle</button></a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteBranch({{ $branch->id }})">Sil</button>
                                                <a href="{{ route('branches.status', $branch->id) }}"><button type="button"
                                                        class="btn @if ($branch->status == 1) btn-danger @else btn-success @endif btn-sm">
                                                        @if ($branch->status == 1)
                                                            Pasif
                                                        @else
                                                            Aktif
                                                        @endif
                                                    </button></a>
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
        function deleteBranch(branchId) {
            Swal.fire({
                title: 'Şubeyi silmek istediğinize emin misiniz?',
                text: "Bu işlemi geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/branches/destroy/' + branchId;
                }
            })
        }
    </script>

    @if (session('success'))
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
