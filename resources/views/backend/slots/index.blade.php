@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Slotlar</h1>
        <a href="{{ route('slots.create') }}" class="btn btn-primary mb-3">Yeni Slot Ekle</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Gün</th>
                    <th>Başlangıç Saati</th>
                    <th>Bitiş Saati</th>
                    <th>Randevu Aralığı (Dakika)</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slots as $slot)
                    <tr>
                        <td>{{ $slot->day_of_week }}</td>
                        <td>{{ $slot->start_time }}</td>
                        <td>{{ $slot->end_time }}</td>
                        <td>{{ $slot->interval }} dakika</td>
                        <td>
                            <button type="button" class="btn @if($slot->status) btn-success @else btn-danger @endif toggle-status"
                                    data-slot-id="{{ $slot->id }}">
                                @if($slot->status) Aktif @else Pasif @endif
                            </button>
                        </td>
                        <td>
                            <a href="{{ route('slots.edit', $slot->id) }}" class="btn btn-info">Düzenle</a>
                            <form action="{{ route('slots.destroy', $slot->id) }}" method="POST" style="display:inline;">
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

@section('scripts')
    <script>
        document.querySelectorAll('.toggle-status').forEach(function(button) {
            button.addEventListener('click', function() {
                var slotId = this.getAttribute('data-slot-id');
                var button = this;

                $.ajax({
                    url: `/slots/${slotId}/toggle-status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status) {
                            button.classList.remove('btn-danger');
                            button.classList.add('btn-success');
                            button.textContent = 'Aktif';
                        } else {
                            button.classList.remove('btn-success');
                            button.classList.add('btn-danger');
                            button.textContent = 'Pasif';
                        }
                    },
                    error: function() {
                        alert('Durum güncellenemedi.');
                    }
                });
            });
        });
    </script>
@endsection
