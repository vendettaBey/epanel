@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <h3 class="mb-4">Randevu Slotları</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Left Side: Slot Generation Form -->
        <div class="col-md-5">
            <form action="{{ route('slots.store') }}" method="POST" class="p-4 border rounded">
                @csrf
                @method('POST')

                <!-- Employee Selection -->
                <div class="mb-3">
                    <label for="employee" class="form-label">Çalışan Seç</label>
                    <select name="employee_id" id="employee" class="form-select" required onchange="getEmployeeSlots(this.value)">
                        <option value="">Çalışan Seçin</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Work Days Selection -->
                <div class="mb-3">
                    <label class="form-label">Mesai Günleri</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['pazartesi', 'salı', 'çarşamba', 'perşembe', 'cuma', 'cumartesi', 'pazar'] as $day)
                            <div class="form-check">
                                <input type="checkbox" name="work_days[]" value="{{ $day }}" class="btn-check" id="{{ $day }}">
                                <label class="btn btn-outline-primary" for="{{ $day }}">{{ ucfirst($day) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Work Hours Start/End Time -->
                <div class="mb-3">
                    <label for="start_time" class="form-label">Mesai Saatleri Başlama Saati</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">Bitiş Saati</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                </div>

                <!-- Slot Interval -->
                <div class="mb-3">
                    <label for="time_slot" class="form-label">Periyot</label>
                    <select name="time_slot" id="time_slot" class="form-select">
                        <option value="5">5 dk</option>
                        <option value="10">10 dk</option>
                        <option value="15">15 dk</option>
                        <option value="30">30 dk</option>
                        <option value="60">60 dk</option>
                    </select>
                </div>

                <!-- Break Start/End Time -->
                <div class="mb-3">
                    <label for="break_start_time" class="form-label">Öğle Arası Başlama</label>
                    <input type="time" name="break_start_time" id="break_start_time" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="break_end_time" class="form-label">Öğle Arası Bitiş</label>
                    <input type="time" name="break_end_time" id="break_end_time" class="form-control">
                </div>

                <!-- Apply Until Date -->
                <div class="mb-3">
                    <label for="end_date" class="form-label">Aşağıdaki Tarihe Kadar Slotları Tanımla</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Slotları Ekle</button>
                </div>
            </form>
        </div>

        <!-- Right Side: Slot Display -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Randevu Slotları</h5>
                </div>
                <div class="card-body" id="slotList">
                    <!-- Dinamik olarak slotlar buraya yüklenecek -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getEmployeeSlots(employee_id) {
        if (employee_id) {
            fetch(`/slots/${employee_id}`)
                .then(response => response.json())
                .then(data => {
                    let slotList = document.getElementById('slotList');
                    slotList.innerHTML = ''; // Önceki slotları temizle

                    if (data.length > 0) {
                        // Slotları tarihe göre gruplama
                        const groupedSlots = groupSlotsByDate(data);

                        // Gün gün slotları listeleme
                        for (const [date, slots] of Object.entries(groupedSlots)) {
                            slotList.innerHTML += `<h5>${date} Randevuları</h5>`;
                            slots.forEach(slot => {
                                slotList.innerHTML += `
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="${slot.status == 0 ? 'text-success' : 'text-danger'}">
                                            ${slot.start_time} ${slot.status == 1 ? '(Dolu)' : ''}
                                        </div>
                                        <div>
                                            <button class="btn btn-sm ${slot.status == 1 ? 'disabled btn-danger' : 'btn-dark'}" onclick="window.location='/appointments/create/${slot.id}'">Randevu</button>
                                            <form action="/slots/${slot.id}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                            </form>
                                        </div>
                                    </div>
                                `;
                            });
                        }
                    } else {
                        slotList.innerHTML = '<p>Bu çalışan için mevcut slot yok.</p>';
                    }
                });
        } else {
            document.getElementById('slotList').innerHTML = '<p>Çalışan seçilmedi.</p>';
        }
    }

    // Slotları tarihe göre gruplama fonksiyonu
    function groupSlotsByDate(slots) {
        return slots.reduce((group, slot) => {
            const date = slot.end_date; // Slotun bitiş tarihini gruplamak için kullanıyoruz
            if (!group[date]) {
                group[date] = [];
            }
            group[date].push(slot);
            return group;
        }, {});
    }
</script>


@endsection
