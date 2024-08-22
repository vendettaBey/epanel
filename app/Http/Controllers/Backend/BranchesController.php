<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mews\Purifier\Facades\Purifier;

class BranchesController extends Controller
{
    public function index()
    {   
        $branches = Branches::all();
        return view('backend.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('backend.branches.create');
    }

    public function store(Request $request){
        $companyInfo = Company::where('owner', Auth::id())->first();
        
        $branches = new Branches();
        $branches->name = Purifier::clean($request->name);
        $branches->slug = Str::slug(Purifier::clean($request->name));
        $branches->address = Purifier::clean($request->address);
        $branches->phone = Purifier::clean($request->phone);
        $branches->email = Purifier::clean($request->email);
        $branches->company_id = $companyInfo->id;
        $branches->user_id = Auth::id();
        $branches->status = 1;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/branches'), $image_name);
            $branches->image = 'uploads/branches/'.$image_name;
        }


        $branches->save();

        return redirect()->route('branches')->with('success', 'Şube başarıyla eklendi!');
    }

    public function edit($id){
        $branch = Branches::find($id);
        return view('backend.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id){
        $branches = Branches::find($id);
        $branches->name = Purifier::clean($request->name);
        $branches->slug = Str::slug(Purifier::clean($request->name));
        $branches->address = Purifier::clean($request->address);
        $branches->phone = Purifier::clean($request->phone);
        $branches->email = Purifier::clean($request->email);
        $branches->status = $request->status;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            if(File::exists($branches->image)) {
                File::delete(public_path($branches->image));
            }
            $image->move(public_path('uploads/branches'), $image_name);
            $branches->image = 'uploads/branches/'.$image_name;
        }

        $branches->save();

        return redirect()->route('branches')->with('success', 'Şube başarıyla güncellendi!');
    }

    public function destroy($id){
        $branches = Branches::find($id);
        if(File::exists($branches->image)) {
            File::delete(public_path($branches->image));
        }
        $branches->delete();

        return redirect()->route('branches')->with('success', 'Şube başarıyla silindi!');
    }

    public function status($id){
        $branches = Branches::find($id);
        if($branches->status == 1){
            $branches->status = 0;
        }else{
            $branches->status = 1;
        }
        $branches->save();

        return redirect()->route('branches')->with('success', 'Şube durumu başarıyla güncellendi!');
    }


}
