<?php

use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\FaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BranchesController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\SectorController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ReferencesController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\FullCalenderController;
use App\Http\Controllers\Backend\AppointmentController;

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


    Route::get('/references',[ReferencesController::class, 'index'])->name('references');
    Route::any('/references/create', [ReferencesController::class,'create'])->name('references.create');
    Route::any('/references/store', [ReferencesController::class,'store'])->name('references.store');
    Route::any('/references/edit/{id}', [ReferencesController::class,'edit'])->name('references.edit');
    Route::any('/references/update/{id}', [ReferencesController::class,'update'])->name('references.update');
    Route::any('/references/destroy/{id}', [ReferencesController::class,'destroy'])->name('references.destroy');
    Route::any('/references/status/{id}', [ReferencesController::class,'status'])->name('references.status');

    Route::get('/galleries',[GalleryController::class, 'index'])->name('galleries');
    Route::any('/galleries/store', [GalleryController::class,'store'])->name('galleries.store');
    Route::any('/galleries/destroy', [GalleryController::class,'destroy'])->name('galleries.destroy');
    Route::any('/galleries/status/{id}', [GalleryController::class,'status'])->name('galleries.status');

    Route::get('/faqs',[FaqController::class, 'index'])->name('faqs');
    Route::any('/faqs/create', [FaqController::class,'create'])->name('faqs.create');
    Route::any('/faqs/store', [FaqController::class,'store'])->name('faqs.store');
    Route::any('/faqs/edit/{id}', [FaqController::class,'edit'])->name('faqs.edit');
    Route::any('/faqs/update/{id}', [FaqController::class,'update'])->name('faqs.update');
    Route::any('/faqs/destroy/{id}', [FaqController::class,'destroy'])->name('faqs.destroy');
    Route::any('/faqs/status/{id}', [FaqController::class,'status'])->name('faqs.status');


    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/settings', [AppointmentController::class, 'settings'])->name('appointments.settings');
    Route::post('/appointments/settings', [AppointmentController::class, 'updateSettings'])->name('appointments.updateSettings');
    Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.getAvailableSlots');
    Route::post('/appointments/toggle-status/{day}', [AppointmentController::class, 'toggleStatus'])->name('appointments.toggleStatus');


});


Route::get('/fullcalender', [FullCalenderController::class, 'index']);
Route::post('/fullcalenderAjax', [FullCalenderController::class, 'ajax']);

require __DIR__.'/auth.php';
