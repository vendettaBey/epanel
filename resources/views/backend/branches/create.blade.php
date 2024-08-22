@extends('layouts.app')

@section('title', 'Yeni Şube Ekle')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title fw-bold">Yeni Şube Ekle</h2>
                    </div>
                    <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Şube Adı</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">Adres</label>
                                <textarea class="form-control" id="address"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">Telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Görsel</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                            <a href="{{ route('branches') }}"><button type="button" class="btn btn-danger">Vazgeç</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            ClassicEditor
            .create(document.querySelector('#address'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error('Error during initialization of the editor', error);
            });
        });
    </script>

@endsection
