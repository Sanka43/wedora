<?php

namespace App\Providers;

use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrentWeddingManager::class, function () {
            return new CurrentWeddingManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
