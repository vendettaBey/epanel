<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sector;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        return view('backend.sectors.index', compact('sectors'));
    }


    public function create()
    {
        return view('backend.sectors.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $sector = new Sector();
        $sector->name = Purifier::clean($request->name);
        $sector->slug = Str::slug(Purifier::clean($request->name));
        $sector->description = Purifier::clean($request->desc);


        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sectors'), $image_name);
            $sector->image = 'uploads/sectors'.$image_name;
        }
        $sector->company_id = 1;
        $sector->user_id = Auth::user()->id;
        $sector->status = 1;
        $sector->save();

        return redirect()->route('sectors')->with('success', 'Sektör başarıyla eklendi!');
    }
    public function edit($id)
    {
        $sector = Sector::find($id);
        return view('backend.sectors.edit', compact('sector'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $sector = Sector::find($id);
        $sector->name = Purifier::clean($request->name);
        $sector->slug = Str::slug(Purifier::clean($request->name));
        $sector->description = $request->desc;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sectors'), $image_name);
            $sector->image = 'uploads/sectors'.$image_name;
        }
        $sector->company_id = 1;
        $sector->user_id = Auth::user()->id;
        $sector->status = 1;
        $sector->save();

        return redirect()->route('sectors')->with('success', 'Sektör başarıyla güncellendi');
    }

    public function destroy($id)
    {
        $sector = Sector::find($id);
        if(file_exists($sector->image)) {
            unlink($sector->image);
        }
        $sector->delete();
        return redirect()->route('sectors')->with('success', 'Sektör başarıyla silindi');
    }

    public function status($id){
        $sector = Sector::find($id);
        if($sector->status == 1){
            $sector->status = 0;
        }else{
            $sector->status = 1;
        }
        $sector->save();
        return redirect()->route('sectors')->with('success', 'Sektör başarıyla güncellendi');
    }





}
