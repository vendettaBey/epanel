<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Company;
use App\Models\Sector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::all();
        $sectors = Sector::all();
        return view('backend.services.index', compact('services', 'sectors'));
    }


    public function create()
    {
        $sectors = Sector::all();
        return view('backend.services.create', compact('sectors'));
    }

    public function store(Request $request){
        $companyInfo = Company::where('owner', Auth::id())->first();
        $services = new Services();
        if($request->sector_id){
            $services->sector_id = $request->sector_id;
        }
        $services->name = Purifier::clean($request->name);
        $services->slug = Str::slug(Purifier::clean($request->name));
        $services->description = Purifier::clean($request->desc);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $image_name);
            $services->image = 'uploads/services/'.$image_name;
        }
        $services->company_id = $companyInfo->id;
        $services->user_id = Auth::id();
        $services->status = 1;
        $services->save();

        return redirect()->route('services')->with('success', 'Hizmet başarıyla eklendi!');
    }

    public function edit($id){
        $services = Services::find($id);
        $sectors = Sector::all();
        return view('backend.services.edit', compact('services', 'sectors'));
    }

    public function update(Request $request, $id){
        $services = Services::find($id);
        if($request->sector_id){
            $services->sector_id = $request->sector_id;
        }
        $services->name = Purifier::clean($request->name);
        $services->slug = Str::slug(Purifier::clean($request->name));
        $services->description = Purifier::clean($request->desc);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $image_name);
            $services->image = 'uploads/services/'.$image_name;
        }
        $services->save();

        return redirect()->route('services')->with('success', 'Hizmet başarıyla güncellendi!');
    }



    public function status($id){
        $services = Services::find($id);
        if($services->status == 1){
            $services->status = 0;
        }else{
            $services->status = 1;
        }
        $services->save();
        return redirect()->route('services')->with('success', 'Hizmet durumu başarıyla değiştirildi!');
    }


}
