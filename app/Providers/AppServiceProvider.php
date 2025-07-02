<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

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
        // Fix for MySQL index length limit on older versions/shared hosting
        Schema::defaultStringLength(191);
        
        // Force HTTPS for Ngrok URLs
        if (str_contains(request()->getHost(), 'ngrok.io') ||
            str_contains(request()->getHost(), 'ngrok-free.app') ||
            str_contains(request()->getHost(), 'ngrok.app')) {
            URL::forceScheme('https');
        }

        // Set application locale based on system settings
        try {
            $language = \App\Models\SystemSetting::getLanguage();
            \Illuminate\Support\Facades\App::setLocale($language);
        } catch (\Exception $e) {
            // If database is not available or setting doesn't exist, use default
            \Illuminate\Support\Facades\App::setLocale('en');
        }
    }
}
