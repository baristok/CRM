<?php

use Illuminate\Support\Facades\Route;
use Modules\Companies\Http\Controllers\CompaniesController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('companies', CompaniesController::class)->names('companies');
    Route::get('companies-search', [CompaniesController::class, 'index'])->name('companies.search');
    Route::get('companies/{id}/details', [CompaniesController::class, 'getCompanyDetails'])->name('companies.details');
});
