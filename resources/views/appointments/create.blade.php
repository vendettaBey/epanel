<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Yeni Randevu Ekle</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Müşteri Adı</label>
            <input type="text" name="client_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Gün Seç</label>
            <select name="day_of_week" class="form-control" id="day_of_week" required>
                @foreach($settings as $setting)
                    @if($setting->status)
                        <option value="{{ $setting->day_of_week }}">{{ $setting->day_of_week }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Başlangıç Saati</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Bitiş Saati</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Randevu Ekle</button>
    </form>
</div>
@endsection
