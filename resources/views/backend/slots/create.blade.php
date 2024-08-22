@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slot Oluştur</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('slots.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="start_date">Başlangıç Tarihi</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">Bitiş Tarihi</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="start_time">Başlangıç Saati</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_time">Bitiş Saati</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time_slot">Periyot (Dakika)</label>
            <input type="number" name="time_slot" id="time_slot" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="break_start_time">Mola Başlangıç Saati</label>
            <input type="time" name="break_start_time" id="break_start_time" class="form-control">
        </div>

        <div class="form-group">
            <label for="break_end_time">Mola Bitiş Saati</label>
            <input type="time" name="break_end_time" id="break_end_time" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Slotları Oluştur</button>
    </form>
</div>
@endsection
