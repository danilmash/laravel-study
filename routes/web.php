<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [MainController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    $contactData = [
        'email' => 'info@example.com',
        'phone' => '123-456-789',
    ];

    return view('contact', compact('contactData'));
})->name('contact');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
