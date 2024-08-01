@extends('layouts.app')
@section('title', 'Firma Bilgileri')
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>    
@endsection


@section('content')
<div class="container-fluid">
    <div class="row g-4 p-4">
        <div class="col-md-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Şirket Bilgileri</div>
                </div>
                <form action="{{ route('company.edit', $company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Şirket Adı</label>
                            <input name="company_name" type="text" class="form-control" id="company_name" value="{{ $company->company_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_description" class="form-label">Şirket Açıklaması</label>
                            <textarea name="company_description" class="form-control" id="company_description" rows="3">{{ $company->company_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone_numbers" class="form-label">Telefon Numaraları</label>
                            <div id="phone_numbers_container">
                                @if($company->phone_numbers)
                                    @foreach(json_decode($company->phone_numbers) as $phone_number)
                                        <div class="input-group mb-2">
                                            <input name="phone_numbers[]" type="text" class="form-control" value="{{ $phone_number }}">
                                            <button type="button" class="btn btn-danger remove-phone-number">Kaldır</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input name="phone_numbers[]" type="text" class="form-control">
                                        <button type="button" class="btn btn-danger remove-phone-number">Kaldır</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-success" id="add_phone_number">Telefon Numarası Ekle</button>
                        </div>
                        <div class="mb-3">
                            <label for="email_addresses" class="form-label">Email Adresleri</label>
                            <div id="email_addresses_container">
                                @if($company->email_addresses)
                                    @foreach(json_decode($company->email_addresses) as $email_address)
                                        <div class="input-group mb-2">
                                            <input name="email_addresses[]" type="email" class="form-control" value="{{ $email_address }}">
                                            <button type="button" class="btn btn-danger remove-email-address">Kaldır</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input name="email_addresses[]" type="email" class="form-control">
                                        <button type="button" class="btn btn-danger remove-email-address">Kaldır</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-success" id="add_email_address">Email Adresi Ekle</button>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Adres</label>
                            <textarea name="address" class="form-control" id="address" rows="3">{{ $company->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="whyus" class="form-label">Neden Biz</label>
                            <textarea name="whyus" class="form-control" id="whyus" rows="3">{{ $company->whyus }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="vision" class="form-label">Vizyon</label>
                            <textarea name="vision" class="form-control" id="vision" rows="3">{{ $company->vision }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="mission" class="form-label">Misyon</label>
                            <textarea name="mission" class="form-control" id="mission" rows="3">{{ $company->mission }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="apiKey" class="form-label">Api Key</label>
                            <input name="apiKey" type="text" class="form-control" id="apiKey" value="{{ $company->apiKey }}">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="w-50">
                                <label for="long">Longitude</label>
                                <input name="long" type="text" class="form-control" id="long" value="{{ $company->long }}">
                            </div>
                            <div class="w-50">
                                <label for="lat">Latitude</label>
                                <input name="lat" type="text" class="form-control" id="lat" value="{{ $company->lat }}">
                            </div>
                        </div>
                    </div> <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-25">Kaydet</button>
                    </div> <!--end::Footer-->
                </form> <!--end::Form-->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Şirket Fotoğrafları</div>
                </div>
                <form action="{{ route('company.photo',$company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="type">Fotoğraf Türü</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="gallery">Galeri</option>
                                <option value="cover">Kapak</option>
                                <option value="logo">Logo</option>
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Fotoğraf</label>
                            <input name="photo" type="file" class="form-control" id="logo" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-25">Kaydet</button>
                    </div>
                </form>
            </div>
            <div style="height: 50px!important;"></div>
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h4>Galeri</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tür</th>
                                <th>Fotoğraf</th>
                                <th>İşlem</th>
                                <th>Kapak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->photos as $photo)
                            <tr>
                                <td>{{ $photo->id }}</td>
                                <td>{{ $photo->type }}</td>
                                <td><img src="{{ asset($photo->image) }}" alt="" style="width: 100px;"></td>
                                <td class="d-flex">
                                    <a href="{{ route('company.photo.status',$photo->id) }}" class="btn btn-{{ ($photo->is_active) ? 'success' : 'danger' }}">
                                        {{ ($photo->is_active) ? 'Aktif' : 'Pasif' }}
                                    </a>
                                    <form action="{{ route('company.photo.delete', $photo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Sil</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('company.photo.cover',$photo->id) }}" class="btn btn-{{ ($photo->is_cover) ? 'primary' : 'secondary' }}">
                                        {{ ($photo->is_cover) ? 'Değil' : 'Kapak' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')


@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Başarılı!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif


<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneNumbersContainer = document.getElementById('phone_numbers_container');
    const addPhoneNumberButton = document.getElementById('add_phone_number');
    const emailAddressesContainer = document.getElementById('email_addresses_container');
    const addEmailAddressButton = document.getElementById('add_email_address');

    addPhoneNumberButton.addEventListener('click', function () {
        const newPhoneNumberInput = document.createElement('div');
        newPhoneNumberInput.classList.add('input-group', 'mb-2');
        newPhoneNumberInput.innerHTML = `
            <input name="phone_numbers[]" type="text" class="form-control" required>
            <button type="button" class="btn btn-danger remove-phone-number">Kaldır</button>
        `;
        phoneNumbersContainer.appendChild(newPhoneNumberInput);
        attachRemoveEvent(newPhoneNumberInput.querySelector('.remove-phone-number'));
    });

    addEmailAddressButton.addEventListener('click', function () {
        const newEmailAddressInput = document.createElement('div');
        newEmailAddressInput.classList.add('input-group', 'mb-2');
        newEmailAddressInput.innerHTML = `
            <input name="email_addresses[]" type="email" class="form-control" required>
            <button type="button" class="btn btn-danger remove-email-address">Kaldır</button>
        `;
        emailAddressesContainer.appendChild(newEmailAddressInput);
        attachRemoveEvent(newEmailAddressInput.querySelector('.remove-email-address'));
    });

    function attachRemoveEvent(button) {
        button.addEventListener('click', function () {
            button.parentElement.remove();
        });
    }

    document.querySelectorAll('.remove-phone-number').forEach(button => attachRemoveEvent(button));
    document.querySelectorAll('.remove-email-address').forEach(button => attachRemoveEvent(button));
});
</script>
@endsection
