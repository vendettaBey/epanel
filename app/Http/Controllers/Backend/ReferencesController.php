<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\References;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReferencesController extends Controller
{
    public function index(){
        $references = References::all();
        return view('backend.references.index', compact('references'));
    }

    public function create(){
        return view('backend.references.create');
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'logo' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $references = new References();
        $references->name = $request->name;

        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            $logoName = time().'.'.$logo->extension();
            $logo->move(public_path('uploads/references'), $logoName);
            $references->logo = 'uploads/references/'.$logoName;
        }

        $references->note = $request->note;
        $references->save();
        return redirect()->route('references')->with('success', 'Referans başarıyla oluşturuldu');
    }

    public function edit($id){
        $reference = References::where('id',$id)->first();
        return view('backend.references.edit', compact('reference'));
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $references = References::find($id);
        $references->name = $request->name;

        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            $logoName = time().'.'.$logo->extension();
            $logo->move(public_path('uploads/references'), $logoName);

            if($references->logo && file_exists(public_path($references->logo))){
                unlink(public_path($references->logo));
            }

            $references->logo = 'uploads/references/'.$logoName;
        }

        $references->note = $request->note;
        $references->save();
        return redirect()->route('references')->with('success', 'Referans başarıyla güncellendi');
    }

    public function destroy($id){
        $references = References::find($id);
        if($references->logo && file_exists(public_path($references->logo))){
            unlink(public_path($references->logo));
        }
        $references->delete();
        return redirect()->route('references')->with('success', 'Referans başarıyla silindi');
    }

    public function status($id){
        $references = References::find($id);
        $references->status = $references->status == 1 ? 0 : 1;
        $references->save();
        return redirect()->route('references')->with('success', 'Referans durumu başarıyla güncellendi');
    }
}
