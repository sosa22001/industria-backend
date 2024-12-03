<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Agregar CORS globalmente
        Route::middleware('api')->group(function ($router) {
            $router->pushMiddlewareToGroup('web', \App\Http\Middleware\Cors::class);
        });
    }
}