<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Http\Controllers\ContactsController;

Route::middleware(['auth', 'permission:view-contact'])->group(function () {
    Route::resource('contacts', ContactsController::class)->names('contacts');
    
    
    // Kişi detaylarını getiren rota
    Route::get('contacts/{id}/details', [ContactsController::class, 'getContactDetails'])->name('contacts.details');
    
    // Export ve Import rotaları
    Route::get('contacts-export', [ContactsController::class, 'export'])->name('contacts.export');
    Route::post('contacts-import', [ContactsController::class, 'import'])->name('contacts.import');
});
