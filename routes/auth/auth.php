<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('v1')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('refresh', 'refresh')->middleware('2fa');
        Route::post('send-code-2fa', 'sendCodeTwoFA')->middleware('auth:api');
        Route::post('verify-code-2fa', 'verifyCodeTwoFA')->middleware('auth:api');
    });
