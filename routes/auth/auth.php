<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Authenticate;

Route::prefix('v1')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('refresh', 'refresh');
    })->middleware('api');
