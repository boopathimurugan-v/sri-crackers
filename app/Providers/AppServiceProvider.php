<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer for Store Layout
        View::composer('layouts.store', function ($view) {
            $view->with('cartCount', 0); // Cart is handled via AlpineJS/LocalStorage now
        });

        // Share global settings if table exists
        if (Schema::hasTable('settings')) {
            $globalSettings = Setting::first();
            View::share('globalSettings', $globalSettings);
        }
    }
}
