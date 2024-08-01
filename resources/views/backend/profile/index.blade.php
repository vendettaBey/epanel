@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<div class="container-fluid">
    <div class="row g-4 p-4">
        <div class="col-md-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $user->name }}</div>
                </div>
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Kullanıcı Adı</label>
                            <input name="name" type="name" class="form-control" value="{{ $user->name }}" id="exampleInputName1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control" value="{{ $user->email }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Şifre</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            <div id="emailHelp" class="form-text text-danger">
                                Eski şifrenizi değiştirmek istemiyorsanız şifre alanlarını boş bırakınız.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword2" class="form-label">Şifre Tekrar</label>
                            <input type="password" class="form-control" name="password2" id="exampleInputPassword2">
                        </div>
                        <div class="input-group mb-3">
                            <label class="form-label w-100" for="inputGroupFile01">Profil Resmi</label>
                            <input type="file" class="form-control" id="inputGroupFile01">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                        <div id="emailHelp" class="form-text text-danger">
                            Var olan profil resminizi değiştirmek istemiyorsanız bu alanı boş bırakınız.
                        </div>
                    </div> <!--end::Body--> 
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div> <!--end::Footer-->
                </form> <!--end::Form-->
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        var password = document.getElementById('exampleInputPassword1').value;
        var confirmPassword = document.getElementById('exampleInputPassword2').value;

        if (password !== confirmPassword) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'Şifre ve Şifre Tekrar alanları eşleşmiyor!',
                confirmButtonText: 'Tamam'
            });
        }
    });
</script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon:'success',
                title: 'Başarılı',
                text: '{{ session('success') }}',
                confirmButtonText: 'Tamam'
            });
        </script>
    @endif

@endsection
