<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;



// Dil değiştirme rotası
Route::get('/change-language/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('change.language');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empty', function () {
    return view('layouts.index');
});






