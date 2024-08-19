<!-- resources/views/references/create.blade.php -->
@extends('layouts.app')
@section('title', 'Yeni Referans Ekle')

@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-12">
                <h3>Yeni Referans Ekle</h3>
            </div>
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('references.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="company_name">Firma Adı</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="logo">Firma Logosu</label>
                        <input type="file" name="logo" id="logo" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="note">Not (İsteğe bağlı)</label>
                        <textarea name="note" id="note" class="form-control" rows="4">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">Kaydet</button>
                    <a href="{{ route('references') }}" class="btn btn-secondary btn-lg">Geri Dön</a>
                </form>
            </div>
        </div>
    </div>
@endsection
