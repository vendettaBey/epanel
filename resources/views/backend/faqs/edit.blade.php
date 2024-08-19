<!-- resources/views/faqs/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Soruyu Düzenle')

@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-12">
                <h3>Soruyu Düzenle</h3>
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

                <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="question">Soru</label>
                        <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="answer">Cevap</label>
                        <textarea name="answer" id="answer" class="form-control" rows="4" required>{{ old('answer', $faq->answer) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">Güncelle</button>
                    <a href="{{ route('faqs') }}" class="btn btn-secondary btn-lg">Geri Dön</a>
                </form>
            </div>
        </div>
    </div>
@endsection
