<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(){
        $categories = BlogCategory::all();
        return view('backend.blog.category', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();
        return redirect()->back()->with('success', 'Kategori başarıyla oluşturuldu');
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'));
        $category->save();
        return redirect()->route('blog-categories')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy($id){
        $category = BlogCategory::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Kategori başarıyla silindi');
    }

    public function changeStatus($id, $status){
        $category = BlogCategory::findOrFail($id);
        $category->status = $status;
        $category->save();
        return redirect()->back()->with('success', 'Kategori durumu başarıyla güncellendi');
    }

}
