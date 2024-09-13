@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <h3 class="mb-4">Randevu Listesi</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('appointments.createNoSlot') }}" class="btn btn-primary mb-3">Yeni Randevu Ekle</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Müşteri Adı</th>
                <th>Telefon Numarası</th>
                <th>Açıklama</th>
                <th>Çalışan</th>
                <th>Randevu Zamanı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->client_name }}</td>
                    <td>{{ $appointment->client_phone }}</td>
                    <td>{{ $appointment->description }}</td>
                    <td>{{ $appointment->slot->employee->name }}</td>
                    <td>{{ $appointment->slot->start_time }}</td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Düzenle</a>
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
