<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Detect admin routes and change session cookie name accordingly
        if (Request::is('admin') || Request::is('admin/*')) {
            Config::set('session.cookie', 'admin_session');
        } else {
            Config::set('session.cookie', 'web_session');
        }
    }
    
}
