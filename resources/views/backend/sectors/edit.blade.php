@extends('layouts.app')
@section('title', 'Sektör | Kategori Düzenle')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title fw-bold">Hizmeti Düzenle</h2>
                    </div>
                    <form action="{{ route('sectors.update', $sector->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Adı</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $sector->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Açıklama</label>
                                <textarea class="form-control" id="desc" name="desc">{!! $sector->description !!}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Resim</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($sector->image)
                                    <img src="{{ asset('storage/' . $sector->image) }}" alt="{{ $sector->name }}" class="img-thumbnail mt-2" style="width: 150px;">
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            <a href="{{ route('sectors') }}"><button type="button"
                                    class="btn btn-danger">Vazgeç</button></a>
                        </div>

                    </form>
                </div>
            </div>
            @if($sector->image)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Sektör Görseli
                    </div>
                    <div class="card-body">
                        <img src="{{ asset($sector->image) }}" alt="{{ $sector->name }}" class="img-fluid">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            ClassicEditor
        .create(document.querySelector('#desc'))
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('Error during initialization of the editor', error);
        });
        });
    </script>
@endsection
