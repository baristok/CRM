<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AuthController;

//Auth Middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/change-language/{locale}', function ($locale) {
        Session::put('locale', $locale);
        return redirect()->back();
    })->name('change.language');
    
    
    Route::get('/', function () {
        return view('layouts.index');
    })->name('index');

});

// // Dil değiştirme rotası
// Route::get('/change-language/{locale}', function ($locale) {
//     Session::put('locale', $locale);
//     return redirect()->back();
// })->name('change.language');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/empty', function () {
//     return view('layouts.index');
// });

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'signin'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');





