<?php

namespace App\Providers;

use App\Orchid\Screens\PostScreen;
use App\Services\PostService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PostScreen::class, fn () => new PostScreen(new PostService()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
