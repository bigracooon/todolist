<?php

namespace App\Providers;

use App\Contracts\Model\IssueContract;
use App\Contracts\Service\AuthServiceContract;
use App\Contracts\Service\IssueServiceContract;
use App\Models\Issue;
use App\Service\AuthService;
use App\Service\IssueService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IssueContract::class, Issue::class);
        $this->app->singleton(IssueServiceContract::class, IssueService::class);
        $this->app->singleton(AuthServiceContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
