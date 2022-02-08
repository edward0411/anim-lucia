<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*', function($view) {
            
            $view->with('menus', Menu::menus());
        });
    }
}
