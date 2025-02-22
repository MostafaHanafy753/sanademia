<?php

namespace App\Providers;

use App\Services\WhatsAppService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
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
        RateLimiter::for('resend-code', function (Request $request) {
            return [
                // Limit to 1 request every 30 seconds
                Limit::perMinute(2)->by($request->ip()),

                // Limit to 5 requests per hour
                Limit::perHour(5)->by($request->ip()),
            ];
        });

        $this->app->bind(
            WhatsappService::class,
            WhatsAppService::class
        );
    }
}
