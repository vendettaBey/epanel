<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Sector;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::all();
        $sectors = Sector::all();
        return view('backend.services.index',compact('services','sectors'));
    }


    public function create()
    {
        return view('backend.services.create');
    }


}
