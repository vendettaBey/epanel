<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::all();
        return view('backend.blog.index', compact('blogs'));
    }

    public function create(){
        $categories = BlogCategory::all();
        return view('backend.blog.create', compact('categories'));
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'time' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $blog = new Blog();
        $blog->title = Purifier::clean($request->title);
        $blog->slug = Str::slug($request->title);
        $blog->content = $request->content;
        $blog->author = Purifier::clean($request->author);
        $blog->time = $request->time;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image = 'uploads/blogs/'.$imageName;
        }
        $blog->tags = implode(',',$request->categories);
        $blog->user_id = Auth::id();
        $blog->save();
        return redirect()->route('blogs')->with('success', 'Blog başarıyla oluşturuldu');
    }

    public function edit($id){
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('backend.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id){
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'time' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->content = $request->content;
        $blog->author = $request->author;
        $blog->time = $request->time;
        if($request->hasFile('image')){
            if ($blog->image) {
                $imagePath = public_path($blog->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image = 'uploads/blogs/'.$imageName;
        }
        $blog->tags = implode(',',$request->categories);
        $blog->user_id = Auth::id();
        $blog->save();
        return redirect()->route('blogs')->with('success', 'Blog başarıyla güncellendi');
    }

    public function destroy($id)
    {
    $blog = Blog::findOrFail($id);
    if ($blog->image) {
        $imagePath = public_path($blog->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    $blog->delete();
    return response()->json(['success' => 'Blog başarıyla silindi!']);
}



    public function status($id){
        $blog = Blog::findOrFail($id);
        $blog->status = !$blog->status;
        $blog->save();
        return redirect()->route('blogs')->with('success', 'Blog durumu başarıyla güncellendi');
    }


}
