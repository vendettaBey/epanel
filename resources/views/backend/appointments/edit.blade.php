@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Randevu Düzenle</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="client_name" class="form-label">Müşteri Adı</label>
            <input type="text" name="client_name" id="client_name" class="form-control" value="{{ $appointment->client_name }}" required>
        </div>

        <div class="mb-3">
            <label for="client_phone" class="form-label">Telefon Numarası</label>
            <input type="text" name="client_phone" id="client_phone" class="form-control" value="{{ $appointment->client_phone }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Açıklama (Opsiyonel)</label>
            <textarea name="description" id="description" class="form-control">{{ $appointment->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Randevuyu Güncelle</button>
    </form>
</div>
@endsection
