<!-- resources/views/faqs/create.blade.php -->
@extends('layouts.app')

@section('title', 'Yeni Soru Ekle')

@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-12">
                <h3>Yeni Soru Ekle</h3>
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

                <form action="{{ route('faqs.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="question">Soru</label>
                        <input type="text" name="question" id="question" class="form-control" value="{{ old('question') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="answer">Cevap</label>
                        <textarea name="answer" id="answer" rows="4">{{ old('answer') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">Kaydet</button>
                    <a href="{{ route('faqs') }}" class="btn btn-secondary btn-lg">Geri Dön</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#answer'))
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Error during initialization of the editor', error);
        });
</script>
@endsection
