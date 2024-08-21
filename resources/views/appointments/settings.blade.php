<!-- resources/views/appointments/settings.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid p-5">
    <h1 class="mb-3">Randevu Ayarlarını Düzenle</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
            @foreach($settings as $setting)
                <tr>
                    <form action="{{ route('appointments.updateSettings') }}" method="POST">
                        @csrf
                        <td>{{ $setting->day_of_week }}</td>
                        @if($setting->status)
                            <td>
                                <input type="time" name="settings[{{ $setting->day_of_week }}][start_time]" value="{{ $setting->start_time }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="time" name="settings[{{ $setting->day_of_week }}][end_time]" value="{{ $setting->end_time }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="settings[{{ $setting->day_of_week }}][time_slot]" value="{{ $setting->time_slot }}" class="form-control" required>
                            </td>
                        @else
                            <td colspan="3" class="text-center">Bu gün pasif durumda</td>
                        @endif
                        <td>
                            <button type="button" class="btn @if($setting->status) btn-danger @else btn-success @endif toggle-status"
                                    data-day="{{ $setting->day_of_week }}">
                                @if($setting->status) Pasif Et @else Aktif Et @endif
                            </button>
                            <input type="hidden" name="settings[{{ $setting->day_of_week }}][status]" value="{{ $setting->status ? '1' : '0' }}">
                        </td>
                        @if($setting->status)
                            <td>
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </td>
                        @else
                            <td></td>
                        @endif
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')

@if(session('success'))
    <script>
        Swal.fire({
            title: 'Başarılı!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Tamam',
            timer:1500
        });
    </script>
@endif



<script>
    document.querySelectorAll('.toggle-status').forEach(function(button) {
        button.addEventListener('click', function() {
            var day = this.getAttribute('data-day');
            var button = this;

            $.ajax({
                url: "{{ url('/appointments/toggle-status/') }}/" + day,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status) {
                        button.classList.remove('btn-success');
                        button.classList.add('btn-danger');
                        button.textContent = 'Pasif Et';
                    } else {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-success');
                        button.textContent = 'Aktif Et';
                    }

                    Swal.fire({
                        title: 'Başarılı!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Tamam'
                    }).then(() => {
                        location.reload(); // Sayfa yenileme
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Hata!',
                        text: 'Durum güncellenemedi.',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });
    });
</script>
@endsection
