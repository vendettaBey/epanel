@extends('layouts.app')

@section('title', 'Hizmet Düzenle')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title fw-bold">Hizmeti Düzenle</h2>
                    </div>
                    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @method('PUT') <!-- PUT metodunu belirtiyoruz çünkü bir güncelleme yapıyoruz -->

                            <div class="mb-3">
                                <label for="sector">Sektör</label>
                                <select class="form-select" id="sector" name="sector_id">
                                    <option value="">Seçiniz</option>  <!-- Default value -->
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ $service->sector_id == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Adı</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Açıklama</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3">{{ $service->desc }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Resim</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="img-thumbnail mt-2" style="width: 150px;">
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            <a href="{{ route('services') }}"><button type="button" class="btn btn-danger">Vazgeç</button></a>
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
