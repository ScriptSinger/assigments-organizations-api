<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\ApiKeyAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiKeyAuth::class])->group(function () {

    // Список организаций в конкретном здании
    // Route::get('/buildings/{building}/organizations', [OrganizationController::class, 'index']);

    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show']);
});
