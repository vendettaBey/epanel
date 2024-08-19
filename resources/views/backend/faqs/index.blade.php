<!-- resources/views/faqs/index.blade.php -->
@extends('layouts.app')
@section('title', 'Sıkça Sorulan Sorular')
@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-12 d-flex justify-content-between">
                <h3>Sıkça Sorulan Sorular</h3>
                <a href="{{ route('faqs.create') }}" class="btn btn-primary btn-lg">Yeni Soru Ekle</a>
            </div>
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Soru</th>
                            <th>Cevap</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->answer }}</td>
                                <td>
                                    @if($faq->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-info btn-sm">Düzenle</a>
                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
