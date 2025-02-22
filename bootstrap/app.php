<?php

use App\Http\Middleware\CalculateVisits;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function() {
            Route::middleware(['web'])
                ->group(base_path('routes/dashboard.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'calculateVisits' => \App\Http\Middleware\CalculateVisits::class,
            'trackGuest' => \App\Http\Middleware\TrackGuestMiddleware::class,
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'language' => \App\Http\Middleware\LanguageMiddleware::class,
        ]);


        $middleware->appendToGroup('api', [
           \Illuminate\Session\Middleware\StartSession::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
