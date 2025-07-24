<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Http\Controllers\ContactsController;

Route::middleware(['auth', 'permission:view-contact'])->group(function () {
    Route::resource('contacts', ContactsController::class)->names('contacts');
    
    // Export ve Import rotaları
    Route::get('contacts-export', [ContactsController::class, 'export'])->name('contacts.export');
    Route::post('contacts-import', [ContactsController::class, 'import'])->name('contacts.import');
});
