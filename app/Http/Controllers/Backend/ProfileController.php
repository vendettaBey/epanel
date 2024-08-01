<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('backend.profile.index', compact('user'));
    }

    public function update(Request $request){
        $userInfo = auth()->user();
        $user = User::find($userInfo->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->filled('password')) {
            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        if($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $imageName);
            $user->profile_picture = 'uploads/profile/'.$imageName;
        }
        $user->save();
        return back()->with('success', 'Profile updated successfully');
    }
    
}
