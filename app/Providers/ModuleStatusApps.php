<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ModuleStatusApps extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // // Modül durumunu kontrol eden helper function
        // if (!function_exists('isModuleEnabled')) {
        //     function isModuleEnabled($moduleName) {
        //         $statusFile = base_path('modules_statuses.json');
        //         if (file_exists($statusFile)) {
        //             $statuses = json_decode(file_get_contents($statusFile), true);
        //             return isset($statuses[$moduleName]) && $statuses[$moduleName] === true;
        //         }
        //         return false;
        //     }
        // }

        // // Sidebar için modül durumlarını view'lara gönder
        // View::composer('*', function ($view) {
        //     $view->with('moduleStatuses', [
        //         'contacts' => isModuleEnabled('Contacts'),
        //         'companies' => isModuleEnabled('Companies'),
        //     ]);
        // });
    }
}
