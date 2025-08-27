<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Contracts\CompanyServiceInterface::class, \Modules\Companies\Services\CompanyService::class);
        $this->app->bind(\App\Contracts\ContactServiceInterface::class, \Modules\Contacts\Services\ContactService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
