<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
    public function boot()
    {
        Paginator::useBootstrap();
        Route::resourceVerbs([
            'create' => 'olustur',
            'store' => 'store',
            'edit' => 'guncelle',
            'update' => 'update',
            'destroy' => 'delete',
        ]);
    }
}
