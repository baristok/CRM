<?php

use Illuminate\Support\Facades\Route;
use Modules\Deals\Http\Controllers\DealsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('deals', DealsController::class)->names('deals');
    Route::post('deals/update-position', [DealsController::class, 'updatePosition'])->name('deals.updatePosition');
});
