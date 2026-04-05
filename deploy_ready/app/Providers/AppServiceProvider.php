<?php

namespace App\Providers;

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
        if (request()->header('X-Forwarded-Proto') === 'https' || request()->secure() || str_contains(request()->getHost(), 'ngrok-free.dev')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
