<!-- resources/views/appointments/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Randevular</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Yeni Randevu Ekle</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Müşteri Adı</th>
                <th>Başlangıç Saati</th>
                <th>Bitiş Saati</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->client_name }}</td>
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->end_time }}</td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Düzenle</a>
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu randevuyu silmek istediğinize emin misiniz?');">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Randevu Ayarları</h1>
    <a href="{{ route('appointments.settings') }}" class="btn btn-secondary mb-3">Ayarları Düzenle</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Gün</th>
                <th>Başlangıç Saati</th>
                <th>Bitiş Saati</th>
                <th>Randevu Aralığı (Dakika)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $setting)
                <tr>
                    <td>{{ $setting->day_of_week }}</td>
                    <td>{{ $setting->start_time }}</td>
                    <td>{{ $setting->end_time }}</td>
                    <td>{{ $setting->time_slot }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
