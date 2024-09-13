@extends('layouts.app')

@section('title', 'Slider Listesi')
@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
@endsection
@section('content')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="fw-bold">Sliders</h3>
                <div class="card">
                    
                        <a href="{{ route('sliders.create') }}">
                            <button type="button" class="btn btn-primary float-end">Yeni Slider Ekle</button>
                        </a>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sliderTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>Görsel</th>
                                        <th>Link</th>
                                        <th>Sıra</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <tr data-id="{{ $slider->id }}">
                                            <td>{{ $slider->id }}</td>
                                            <td>{{ $slider->title }}</td>
                                            <td>{!! $slider->description !!}</td>
                                            <td>
                                                @if($slider->image)
                                                    <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="img-thumbnail" style="width: 100px;">
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->link)
                                                    <a href="{{ $slider->link }}" target="_blank">{{ $slider->link }}</a>
                                                @else
                                                    Yok
                                                @endif
                                            </td>
                                            <td>{{ $slider->order }}</td>
                                            <td>
                                                @if ($slider->status)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('sliders.edit', $slider->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm">Düzenle</button>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSlider({{ $slider->id }})">Sil</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')    
    <script>
        function deleteSlider(sliderId) {
            Swal.fire({
                title: 'Slider\'ı silmek istediğinize emin misiniz?',
                text: "Bu işlemi geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/sliders/destroy/' + sliderId;
                }
            })
        }

        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('sliderTable').getElementsByTagName('tbody')[0];
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    var order = [];
                    $('tbody tr').each(function (index, element) {
                        order.push({
                            id: $(element).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        url: '{{ route('sliders.updateOrder') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order: order
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sıralama güncellendi',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Sıralama güncellenirken bir hata oluştu.',
                            });
                        }
                    });
                }
            });
        });
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

@endsection
