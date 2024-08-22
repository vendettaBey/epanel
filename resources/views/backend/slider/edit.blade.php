@extends('layouts.app')

@section('title', 'Slider Düzenle')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title fw-bold">Slider Düzenle</h2>
                    </div>
                    <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Başlık</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                                @if($errors->has('title'))
                                    <div class="text-danger">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Açıklama</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $slider->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Görsel</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label fw-bold">Link</label>
                                <input type="url" class="form-control" id="link" name="link" value="{{ old('link', $slider->link) }}">
                            </div>
                            <div class="mb-3">
                                <label for="order" class="form-label fw-bold">Sıra</label>
                                <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $slider->order) }}" min="0">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Durum</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" {{ old('status', $slider->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status', $slider->status) == '0' ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            <a href="{{ route('sliders') }}"><button type="button" class="btn btn-danger">Vazgeç</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Var Olan Görsel
                    </div>
                    <div class="card-body">
                        @if($slider->image)
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="img-thumbnail mt-2" style="width: 400px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error('Error during initialization of the editor', error);
            });
        });
    </script>
@endsection
