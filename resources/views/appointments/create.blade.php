<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Yeni Randevu Ekle</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
            @csrf
            <div class="form-group">
                <label>Müşteri Adı</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Müşteri Telefon</label>
                <input type="text" name="client_phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Randevu Notu</label>
                <textarea name="note" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Müşteri Email</label>
                <input type="email" name="client_email" class="form-control">
            </div>
            <div class="form-group">
                <label>Tarih Seç</label>
                <input type="date" name="date" id="appointment_date" class="form-control w-25" required>
            </div>
            <div class="form-group">
                <label>Randevu Saati Seç</label>
                <select name="start_time" id="available_slots" class="form-control w-25" required>
                    <option value="">Önce tarih seçin</option>
                </select>
            </div>
            <input type="hidden" name="day_of_week" id="day_of_week_hidden">
            <button type="submit" class="btn btn-success">Randevu Ekle</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.getElementById('appointment_date').addEventListener('change', function() {
            var selectedDate = new Date(this.value);
            var dayOfWeek = selectedDate.getDay(); // 0 = Pazar, 1 = Pazartesi, ... 6 = Cumartesi

            // Gün bilgisini Türkçe'ye çevirme
            var days = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
            var dayOfWeekName = days[dayOfWeek];

            // day_of_week hidden input alanını güncelle
            document.getElementById('day_of_week_hidden').value = dayOfWeekName;

            if (selectedDate) {
                $.ajax({
                    url: "{{ route('appointments.getAvailableSlots') }}",
                    type: 'GET',
                    data: {
                        day_of_week: dayOfWeekName,
                        date: this.value // 'YYYY-MM-DD' formatında tarih gönder
                    },
                    success: function(slots) {
                        console.log(slots);
                        var select = document.getElementById('available_slots');
                        select.innerHTML = ''; // Önceki seçenekleri temizle
                        if (slots.length > 0) {
                            slots.forEach(function(slot) {
                                var option = document.createElement('option');
                                option.value = slot.start_time;
                                option.textContent = slot.start_time + ' - ' + slot.end_time;
                                select.appendChild(option);
                            });
                        } else {
                            var option = document.createElement('option');
                            option.textContent = 'Bu gün için uygun randevu yok';
                            select.appendChild(option);
                        }
                    },
                    error: function() {
                        alert('Randevu saatleri getirilemedi');
                    }
                });
            } else {
                document.getElementById('available_slots').innerHTML = '<option value="">Önce tarih seçin</option>';
            }
        });
    </script>
@endsection
