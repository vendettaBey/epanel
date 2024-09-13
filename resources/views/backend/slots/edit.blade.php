@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <h3 class="mb-4">Randevu Slotu Düzenle</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('slots.update', $slot->id) }}" method="POST" class="p-4 border rounded">
        @csrf
        @method('PUT')

        <!-- Employee Selection -->
        <div class="mb-3">
            <label for="employee" class="form-label">Çalışan Seç</label>
            <select name="employee_id" id="employee" class="form-select" required>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $slot->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Work Days Selection -->
        <div class="mb-3">
            <label class="form-label">Mesai Günleri</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach(['pazartesi', 'salı', 'çarşamba', 'perşembe', 'cuma', 'cumartesi', 'pazar'] as $day)
                    <div class="form-check">
                        <input type="checkbox" name="work_days[]" value="{{ $day }}" class="btn-check" id="{{ $day }}" 
                        {{ in_array($day, $slot->work_days) ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="{{ $day }}">{{ ucfirst($day) }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Work Hours Start/End Time -->
        <div class="mb-3">
            <label for="start_time" class="form-label">Mesai Saatleri Başlama Saati</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $slot->start_time }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Bitiş Saati</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $slot->end_time }}" required>
        </div>

        <!-- Slot Interval -->
        <div class="mb-3">
            <label for="time_slot" class="form-label">Periyot</label>
            <select name="time_slot" id="time_slot" class="form-select">
                <option value="5" {{ $slot->time_slot == 5 ? 'selected' : '' }}>5 dk</option>
                <option value="10" {{ $slot->time_slot == 10 ? 'selected' : '' }}>10 dk</option>
                <option value="15" {{ $slot->time_slot == 15 ? 'selected' : '' }}>15 dk</option>
                <option value="30" {{ $slot->time_slot == 30 ? 'selected' : '' }}>30 dk</option>
                <option value="60" {{ $slot->time_slot == 60 ? 'selected' : '' }}>60 dk</option>
            </select>
        </div>

        <!-- Break Start/End Time -->
        <div class="mb-3">
            <label for="break_start_time" class="form-label">Öğle Arası Başlama</label>
            <input type="time" name="break_start_time" id="break_start_time" class="form-control" value="{{ $slot->break_start_time }}">
        </div>

        <div class="mb-3">
            <label for="break_end_time" class="form-label">Öğle Arası Bitiş</label>
            <input type="time" name="break_end_time" id="break_end_time" class="form-control" value="{{ $slot->break_end_time }}">
        </div>

        <!-- Apply Until Date -->
        <div class="mb-3">
            <label for="end_date" class="form-label">Aşağıdaki Tarihe Kadar Slotları Tanımla</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $slot->end_date }}" required>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-success">Güncelle</button>
        </div>
    </form>
</div>
@endsection
