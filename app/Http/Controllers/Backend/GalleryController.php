<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('backend.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        // Dosya yükleme doğrulama işlemi
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Yüklenen her dosya için işlemleri gerçekleştirin
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Dosyayı 'public/uploads/gallery' klasörüne manuel taşıma
                $filename = time() . '-' . $image->getClientOriginalName();
                $path = $image->move(public_path('uploads/gallery'), $filename);

                // Yeni bir galeri kaydı oluştur
                Gallery::create(['image_url' => 'uploads/gallery/' . $filename]);
            }
        }
        // Başarıyla yanıt gönder
        return response()->json(['message' => 'Fotoğraflar başarıyla yüklendi!'], 200);
    }


    public function destroy(Request $request)
    {
        // Seçilen fotoğrafların ID'lerini doğrulayın
        $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:galleries,id',
        ]);

        // Seçilen fotoğrafları alın ve silme işlemini gerçekleştirin
        $images = Gallery::whereIn('id', $request->selected_images)->get();

        foreach ($images as $image) {
            if(File::exists(public_path($image->image_url))) {
                File::delete(public_path($image->image_url));
            }
            // Fotoğraf kaydını veritabanından silin
            $image->delete();
        }

        // Başarı mesajı ile geri dön
        return redirect()->route('galleries')->with('success', 'Seçilen fotoğraflar başarıyla silindi.');
    }
}
