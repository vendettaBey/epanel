@extends('layouts.app')

@section('title', 'Blogu Düzenle')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blogu Düzenle</h3>
                    </div>
                    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                @if($errors->has('title'))
                                    <div class="text-danger">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="categories" class="form-label">Kategoriler</label>
                                <select class="form-select" id="categories" name="categories[]" multiple="multiple">
                                    @php
                                        $selectedCategories = explode(',',$blog->tags) ?? [];
                                    @endphp
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            @if(in_array($category->id, $selectedCategories)) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('categories'))
                                    <div class="text-danger">{{ $errors->first('categories') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Yazar</label>
                                <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $blog->author) }}" required>
                                @if($errors->has('author'))
                                    <div class="text-danger">{{ $errors->first('author') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Zaman</label>
                                <input type="text" class="form-control" id="time" name="time" value="{{ old('time', $blog->time) }}" required>
                                @if($errors->has('time'))
                                    <div class="text-danger">{{ $errors->first('time') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Görsel</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($errors->has('image'))
                                    <div class="text-danger">{{ $errors->first('image') }}</div>
                                @endif
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->image }}" class="img-thumbnail mt-2" style="width: 100px;">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">İçerik</label>
                                <textarea class="form-control" id="content" name="content">{{ old('content', $blog->content) }}</textarea>
                                @if($errors->has('content'))
                                    <div class="text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            <a href="{{ route('blogs') }}">
                                <button type="button" class="btn btn-danger">Vazgeç</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Blog Görseli
                    </div>
                    <div class="card-body">
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->image }}" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    
    <!-- Bootstrap Datepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        ClassicEditor
        .create(document.querySelector('#content'))
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Error during initialization of the editor', error);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#categories').select2({});

            // Initialize Bootstrap Datepicker for time field
            $('#time').datepicker({
                format: 'yyyy-mm-dd', // Tarih formatını dilediğiniz gibi değiştirebilirsiniz
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endsection
