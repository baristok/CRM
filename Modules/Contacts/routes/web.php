<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Http\Controllers\ContactsController;

Route::middleware(['auth', 'permission:view-contact'])->group(function () {
    Route::resource('contacts', ContactsController::class)->names('contacts');
});
