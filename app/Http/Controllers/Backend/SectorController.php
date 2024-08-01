<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sector;
use Illuminate\Support\Str;

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
        $sector->name = $request->name;
        $sector->slug = Str::slug($request->name);
        $sector->description = $request->description;


        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sectors'), $image_name);
            $sector->image = 'uploads/sectors'.$image_name;
        }
        $sector->company_id = 1;
        $sector->user_id = auth()->user()->id;
        $sector->status = 1;
        $sector->save();

        return redirect()->route('sectors')->with('success', 'Sector created successfully');
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
        $sector->name = $request->name;
        $sector->slug = Str::slug($request->name);
        $sector->description = $request->description;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sectors'), $image_name);
            $sector->image = 'uploads/sectors'.$image_name;
        }
        $sector->company_id = 1;
        $sector->user_id = auth()->user()->id;
        $sector->status = 1;
        $sector->save();

        return redirect()->route('sectors')->with('success', 'Sector updated successfully');
    }

    public function destroy($id)
    {
        $sector = Sector::find($id);
        if(file_exists($sector->image)) {
            unlink($sector->image);
        }
        $sector->delete();
        return redirect()->route('sectors')->with('success', 'Sector deleted successfully');
    }







}
