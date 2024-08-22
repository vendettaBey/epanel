 @extends('layouts.app')
 @section('title', 'Sektör | Kategori Ekle')

 @section('content')
     <div class="container-fluid">
         <div class="row">
             <div class="col-md-6">
                 <div class="card">
                     <div class="card-header">
                         <h2 class="card-title fw-bold">Hizmet Ekle</h2>
                     </div>
                     <form action="{{ route('sectors.store') }}" method="POST" enctype="multipart/form-data">
                         <div class="card-body">
                             @csrf

                             <div class="mb-3">
                                 <label for="name" class="form-label fw-bold">Adı</label>
                                 <input type="text" class="form-control" id="name" name="name" required>
                             </div>
                             <div class="mb-3">
                                 <label for="description" class="form-label fw-bold">Açıklama</label>
                                 <textarea class="form-control" id="desc" name="desc"></textarea>
                             </div>
                             <div class="mb-3">
                                 <label for="image" class="form-label fw-bold">Resim</label>
                                 <input type="file" class="form-control" id="image" name="image" accept="image/*">
                             </div>
                         </div>
                         <div class="card-footer">
                             <button type="submit" class="btn btn-primary">Kaydet</button>
                             <a href="{{ route('sectors') }}"><button type="button"
                                     class="btn btn-danger">Vazgeç</button></a>
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