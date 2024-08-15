<?php

use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BlogCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BranchesController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\SectorController;
use App\Http\Controllers\Backend\SliderController;

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


    Route::get('/branches',[BranchesController::class, 'index'])->name('branches');
    Route::any('/branches/create', [BranchesController::class,'create'])->name('branches.create');
    Route::any('/branches/store', [BranchesController::class,'store'])->name('branches.store');
    Route::any('/branches/edit/{id}', [BranchesController::class,'edit'])->name('branches.edit');
    Route::any('/branches/update/{id}', [BranchesController::class,'update'])->name('branches.update');
    Route::any('/branches/destroy/{id}', [BranchesController::class,'destroy'])->name('branches.destroy');
    Route::any('/branches/status/{id}', [BranchesController::class,'status'])->name('branches.status');

    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders');
    Route::any('/sliders/create', [SliderController::class,'create'])->name('sliders.create');
    Route::any('/sliders/store', [SliderController::class,'store'])->name('sliders.store');
    Route::any('/sliders/edit/{id}', [SliderController::class,'edit'])->name('sliders.edit');
    Route::any('/sliders/update/{id}', [SliderController::class,'update'])->name('sliders.update');
    Route::any('/sliders/destroy/{id}', [SliderController::class,'destroy'])->name('sliders.destroy');
    Route::any('/sliders/status/{id}', [SliderController::class,'status'])->name('sliders.status');
    Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');


    Route::get('/blogs',[BlogController::class, 'index'])->name('blogs');
    Route::any('/blogs/create', [BlogController::class,'create'])->name('blogs.create');
    Route::any('/blogs/store', [BlogController::class,'store'])->name('blogs.store');
    Route::any('/blogs/edit/{id}', [BlogController::class,'edit'])->name('blogs.edit');
    Route::any('/blogs/update/{id}', [BlogController::class,'update'])->name('blogs.update');
    Route::any('/blogs/destroy/{id}', [BlogController::class,'destroy'])->name('blogs.destroy');
    Route::any('/blogs/status/{id}', [BlogController::class,'status'])->name('blogs.status');

    Route::get('/blog-categories',[BlogCategoryController::class, 'index'])->name('blog-categories');
    Route::any('/blog-categories/store', [BlogCategoryController::class,'store'])->name('blog-categories.store');
    Route::put('/blog-categories/{category}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
    Route::any('/blog-categories/destroy/{id}', [BlogCategoryController::class,'destroy'])->name('blog-categories.destroy');
    Route::any('/blog-categories/status/{id}', [BlogCategoryController::class,'status'])->name('blog-categories.status');



});

require __DIR__.'/auth.php';
