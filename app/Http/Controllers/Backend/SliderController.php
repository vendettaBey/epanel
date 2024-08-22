<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mews\Purifier\Facades\Purifier;


class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::orderBy('order', 'ASC')->get();
        return view('backend.slider.index', compact('sliders'));
    }

    public function create(){
        return view('backend.slider.create');
    }

    public function store(Request $request) {
        $rules = [
            'title' => 'required',
        ];
    
        $companyInfo = Company::where('owner', Auth::user()->id)->first();
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Mevcut en yüksek order değerini alıp 1 ekleyin
        $maxOrder = Slider::max('order');
        $newOrder = $maxOrder + 1;
    
        $slider = new Slider();
        $slider->title = strip_tags($request->title);
        $slider->description = Purifier::clean($request->description);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/slider'), $image_name);
            $slider->image = 'uploads/slider/' . $image_name;
        }
        $slider->link = Purifier::clean($request->link);
        $slider->order = $newOrder; // Yeni order değeri
        $slider->status = 1; // Varsayılan olarak aktif
        $slider->user_id = Auth::user()->id;
        $slider->company_id = $companyInfo->id;
        $slider->save();    
        return redirect()->route('sliders')->with('success', 'Slider başarıyla oluşturuldu');
    }
    

    public function edit($id){
        $slider = Slider::find($id);
        return view('backend.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id){
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slider = Slider::find($id);
        $slider->title = strip_tags($request->title);
        $slider->description = Purifier::clean($request->description);
        


        if($request->hasFile('image')){

            if(File::exists($slider->image)) {
                File::delete(public_path($slider->image));
            }
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/slider'), $image_name);
            $slider->image = 'uploads/slider/'.$image_name;
        }

        $slider->link = Purifier::clean($request->link);
        $slider->order = $request->order;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('sliders')->with('success', 'Slider updated successfully');
    }

    public function destroy($id){
        $slider = Slider::find($id);
        if(file_exists($slider->image)) {
            File::delete(public_path($slider->image));
        }
        $slider->delete();
        return redirect()->route('sliders')->with('success', 'Slider deleted successfully');
    }

    public function status($id){
        $slider = Slider::find($id);
        if($slider->status == 1){
            $slider->status = 0;
        }else{
            $slider->status = 1;
        }
        $slider->save();
        return redirect()->route('sliders')->with('success', 'Slider status updated successfully');
    }

    public function updateOrder(Request $request)
{
    $order = $request->order;

    foreach ($order as $item) {
        Slider::where('id', $item['id'])->update(['order' => $item['position']]);
    }

    return response()->json(['success' => true]);
}



}
