<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('menu', function ($app)
        {
            return new Menu($this->loadMenus());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function loadMenus(): array
    {
        $menus = [];
        $modules = Module::toCollection()->filter(function ($module)
        {
            return $module->isEnabled();
        });

        foreach($modules as $module)
        {
            $menufile = $module->getPath() . '/config/menu.php';
            if (file_exists($menufile)) {
                $moduleMenu = File::getRequire($menufile);
                if (is_array($moduleMenu) && isset($moduleMenu['route'])) {
                    try {
                        $moduleMenu['url'] = route($moduleMenu['route']);
                        
                        // Child menüleri de işle
                        if (isset($moduleMenu['child']) && is_array($moduleMenu['child'])) {
                            foreach ($moduleMenu['child'] as &$child) {
                                if (isset($child['route'])) {
                                    try {
                                        $child['url'] = route($child['route']);
                                    } catch (\Exception $e) {
                                        $child['url'] = '#';
                                    }
                                }
                            }
                        }
                        
                        $menus[] = $moduleMenu;
                    } catch (\Exception $e) {
                        // Route bulunamazsa skip et
                        continue;
                    }
                }
            }
        }
        
        // Menüleri order'a göre sırala
        usort($menus, function($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });
        
        return $menus;
    }

    
}   

