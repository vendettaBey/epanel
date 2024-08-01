<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\SectorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



    Route::get('/company', [CompanyController::class, 'index'])->name('company');
    Route::any('/company/edit/{id}', [CompanyController::class,'edit'])->name('company.edit');
    Route::any('/company/photo/{id}', [CompanyController::class,'photo'])->name('company.photo');
    Route::any('/company/photo/delete/{id}', [CompanyController::class,'photoDelete'])->name('company.photo.delete');
    Route::any('/company/photo/status/{id}', [CompanyController::class,'photoStatus'])->name('company.photo.status');
    Route::any('/company/photo/cover/{id}', [CompanyController::class,'photoCover'])->name('company.photo.cover');



    Route::get('/sectors', [SectorController::class, 'index'])->name('sectors');
    Route::any('/sectors/create', [SectorController::class,'create'])->name('sectors.create');
    Route::any('/sectors/store', [SectorController::class,'store'])->name('sectors.store');
    Route::any('/sectors/edit/{id}', [SectorController::class,'edit'])->name('sectors.edit');
    Route::any('/sectors/update/{id}', [SectorController::class,'update'])->name('sectors.update');
    Route::any('/sectors/destroy/{id}', [SectorController::class,'destroy'])->name('sectors.destroy');
    Route::any('/sectors/status/{id}', [SectorController::class,'status'])->name('sectors.status');


    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::any('/services/create', [ServicesController::class,'create'])->name('services.create');
    Route::any('/services/store', [ServicesController::class,'store'])->name('services.store');
    Route::any('/services/edit/{id}', [ServicesController::class,'edit'])->name('services.edit');
    Route::any('/services/destroy/{id}', [ServicesController::class,'destroy'])->name('services.destroy');
    Route::any('/services/status/{id}', [ServicesController::class,'status'])->name('services.status');
    Route::any('/services/photo/{id}', [ServicesController::class,'photo'])->name('services.photo');
    Route::any('/services/photo/delete/{id}', [ServicesController::class,'photoDelete'])->name('services.photo.delete');
    Route::any('/services/photo/status/{id}', [ServicesController::class,'photoStatus'])->name('services.photo.status');
    Route::any('/services/photo/cover/{id}', [ServicesController::class,'photoCover'])->name('services.photo.cover');


});

require __DIR__.'/auth.php';
