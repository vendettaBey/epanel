@extends('layouts.app')

@section('title', 'Hizmetler')

@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <h3 class="fw-bold">Hizmetler</h3>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('services.create') }}"><button type="button" class="btn btn-primary float-end">Yeni Hizmet Ekle</button></a>
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
                                    @foreach($services as $service)
                                        <tr>
                                            <td>{{ $service->id }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{!! $service->description !!}</td>
                                            <td>
                                                @if($service->status == 1)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('services.edit', $service->id) }}"><button type="button" class="btn btn-primary btn-sm">Düzenle</button></a>
                                                <a href="{{ route('services.destroy', $service->id) }}" onclick="return confirm('Silmek istediğinize emin misiniz?')"><button type="button" class="btn btn-danger btn-sm">Sil</button></a>
                                                <a href="{{ route('services.status', $service->id) }}"><button type="button" class="btn @if($service->status == 1)btn-danger @else btn-success @endif btn-sm">@if($service->status == 1)Pasif @else Aktif @endif</button></a>
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