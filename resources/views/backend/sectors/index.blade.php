@extends('layouts.app')

@section('title', 'serviceler')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sektörler | Kategoriler</h3>
                        <a href="{{ route('sectors.create') }}"><button type="button" class="btn btn-primary float-end">Yeni
                                Hizmet Ekle</button></a>
                    </div>
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
                                            <td>{{ $sector->description }}</td>
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
                                                <a href="{{ route('sectors.destroy', $sector->id) }}"
                                                    onclick="return confirm('Silmek istediğinize emin misiniz?')"><button
                                                        type="button" class="btn btn-danger btn-sm">Sil</button></a>
                                                <a href="{{ route('sectors.status', $sector->id) }}"><button type="button"
                                                        class="btn btn-info btn-sm"></button></a>
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
