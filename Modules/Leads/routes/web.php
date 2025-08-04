<?php

use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\LeadsController;

Route::middleware(['auth'])->group(function () {
    Route::resource('leads', LeadsController::class)->names('leads');
    Route::get('leads-search', [LeadsController::class, 'search'])->name('leads.search');
});
