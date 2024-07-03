<?php

use App\Http\Controllers\IssueController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('issues', [IssueController::class, 'index']);
    });
});
