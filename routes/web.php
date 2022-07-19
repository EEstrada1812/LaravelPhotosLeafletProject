<?php

use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    
    Route::get('/map', function () {return view('map');})->name('map');
    
    Route::get('/map/get-images', [ImageController::class, 'getImages'])->name('images.getImages');

    Route::post('/map/upload-image', [ImageController::class, 'uploadImage'])->middleware('is_admin')->name('images.uploadImage');
});

