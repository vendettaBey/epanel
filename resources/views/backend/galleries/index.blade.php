<!-- resources/views/galleries/index.blade.php -->
@extends('layouts.app')
@section('title', 'Galeri Yönetimi')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="fw-bold">Galeri Yönetimi</h3>
                <div class="card">

                    <div class="card-body">
                        <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data"
                            class="dropzone" id="gallery-dropzone">
                            @csrf
                        </form>

                        <div class="col-md-12">
                            <form action="{{ route('galleries.destroy') }}" method="POST" id="delete-form">
                                @csrf
                                @method('DELETE')
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Fotoğraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galleries as $gallery)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="image{{ $gallery->id }}"
                                                        name="selected_images[]" value="{{ $gallery->id }}">
                                                </td>
                                                <td>
                                                    <label for="image{{ $gallery->id }}">
                                                        <img src="{{ asset($gallery->image_url) }}" alt="Fotoğraf"
                                                            class="img-thumbnail" style="width: 150px;">
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-danger mt-2" id="delete-button">Seçili Fotoğrafları
                                    Sil</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fotoğraf Yükleme Formu -->
            <div class="col-md-12 mb-4">

            </div>

            <!-- Fotoğrafları Listesi ve Silme Seçenekleri -->

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.galleryDropzone = {
            paramName: "images[]",
            maxFilesize: 32, // MB cinsinden maksimum dosya boyutu
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            timeout: 180000, // Zaman aşımı süresi 3 dakika (180 saniye)
            success: function(file, response) {
                location.reload(); // Sayfayı yenileyerek yüklenen fotoğrafları göster
            }
        };

        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('input[name="selected_images[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

        document.getElementById('delete-button').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu işlemi geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Hayır, iptal et'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Başarılı!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Tamam',
                timer: 1500
            });
        </script>
    @endif
@endsection
