@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Randevular</h1>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Yeni Randevu Ekle</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Müşteri Adı</th>
                    <th>Müşteri Telefon</th>
                    <th>Tarih</th>
                    <th>Başlangıç Saati</th>
                    <th>Bitiş Saati</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->client_name }}</td>
                        <td>{{ $appointment->client_phone }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->slot->start_time }}</td>
                        <td>{{ $appointment->slot->end_time }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                        <td>
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-info">Düzenle</a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
