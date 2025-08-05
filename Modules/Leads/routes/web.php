<?php

use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\LeadsController;

Route::middleware(['auth'])->group(function () {
    Route::resource('leads', LeadsController::class)->names('leads');
    Route::get('leads-search', [LeadsController::class, 'search'])->name('leads.search');
    Route::get('leads/{id}/details', [LeadsController::class, 'details'])->name('leads.details');
    Route::post('leads-import', [LeadsController::class, 'import'])->name('leads.import');
    Route::get('leads-export', [LeadsController::class, 'export'])->name('leads.export');
});
