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

        <form action="{{ route('appointments.store') }}" method="POST">
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
                <label>Tarih Seç</label>
                <input type="date" name="date" id="appointment_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Slot Seç</label>
                <select name="slot_id" id="slot_select" class="form-control" required>
                    <option value="">Önce tarih seçin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Randevu Ekle</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('appointment_date').addEventListener('change', function() {
            var selectedDate = this.value;

            if (selectedDate) {
                $.ajax({
                    url: '{{ url('/appointments/slots') }}',
                    type: 'GET',
                    data: {
                        date: selectedDate
                    },
                    success: function(slots) {
                        var select = document.getElementById('slot_select');
                        select.innerHTML = ''; // Önceki seçenekleri temizle
                        if (slots.length > 0) {
                            slots.forEach(function(slot) {
                                var option = document.createElement('option');
                                option.value = slot.id;
                                option.textContent = slot.start_time + ' - ' + slot.end_time;
                                select.appendChild(option);
                            });
                        } else {
                            var option = document.createElement('option');
                            option.textContent = 'Bu tarih için uygun slot yok';
                            select.appendChild(option);
                        }
                    },
                    error: function() {
                        alert('Slotlar getirilemedi');
                    }
                });
            } else {
                document.getElementById('slot_select').innerHTML = '<option value="">Önce tarih seçin</option>';
            }
        });
    </script>
@endsection
