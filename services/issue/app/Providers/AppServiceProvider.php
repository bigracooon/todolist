<?php

namespace App\Providers;

use App\Contracts\Model\IssueContract;
use App\Contracts\Service\AuthServiceContract;
use App\Contracts\Service\IssueServiceContract;
use App\Http\Controllers\IssueController;
use App\Http\Middleware\AuthMiddleware;
use App\Models\Issue;
use App\Service\AuthService;
use App\Service\IssueService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

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

        $this->app->bind(IssueServiceContract::class, function (Application $app) {
            return new IssueService($app->make(IssueContract::class));
        });

        $this->app->bind(IssueController::class, function (Application $app) {
            return new IssueController($app->make(IssueServiceContract::class));
        });

        $this->app->bind(AuthMiddleware::class, function (Application $app) {
            return new AuthMiddleware($app->make(AuthServiceContract::class));
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
