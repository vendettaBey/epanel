<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyGallery;

class CompanyController extends Controller
{
    public function index(){
        $user = auth()->user();
        $company = Company::find(1);
        return view('backend.company.index',compact('user','company') );
    }


    public function edit(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'string',
        ]);

        // Find the company by id
        $company = Company::findOrFail($id);

        // Update company information
        $company->company_name = $request->company_name;
        $company->company_description = $request->company_description;
        $company->phone_numbers = json_encode($request->phone_numbers);
        $company->email_addresses = json_encode($request->email_addresses);
        $company->address = $request->address;
        $company->owner = auth()->user()->id;
        $company->whyus = $request->whyus;
        $company->vision = $request->vision;
        $company->mission = $request->mission;
        $company->long = $request->long;
        $company->lat = $request->lat;
        $company->apiKey = $request->apiKey;
        
        // Save the updated company data
        $company->save();

        return back()->with('success', 'Şirket bilgileri başarıyla güncellendi');
    }


    public function photo(Request $request,$id){

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $cPhoto = new CompanyGallery();
        $cPhoto->type = $request->type;
        $cPhoto->company_id = $id;
        $image = $request->file('photo');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/company'), $imageName);

        $cPhoto->image = 'uploads/company/'.$imageName;
        $cPhoto->is_active = 1;
        $cPhoto->is_cover = 0;
        $cPhoto->save();

        return back()->with('success', 'Şirket fotoğrafı başarıyla eklendi');
    }

    public function photoDelete($id){
        $photo = CompanyGallery::find($id);
        if(file_exists(public_path($photo->image))){
            unlink(public_path($photo->image));
        }
        $photo->delete();
        return back()->with('success', 'Şirket fotoğrafı başarıyla silindi');
    }

    public function photoStatus($id){
        $photo = CompanyGallery::find($id);
        $photo->is_active = !$photo->is_active;
        $photo->save();
        return back()->with('success', 'Şirket fotoğrafı durumu başarıyla güncellendi');
    }

    public function photoCover($id) {
        // Find the photo by ID
        $photo = CompanyGallery::findOrFail($id);
        // Set all other photos' is_cover to 0
        CompanyGallery::where('company_id', $photo->company_id)
                      ->where('id', '!=', $id)
                      ->update(['is_cover' => 0]);
        // Set the selected photo's is_cover to 1
        $photo->is_cover = 1;
        $photo->save();
        return back()->with('success', 'Şirket fotoğrafı kapak fotoğrafı olarak ayarlandı');
    }
    


}
