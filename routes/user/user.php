<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::prefix('v1')->group(function () {
    
    Route::apiResource('user', UserController::class)->except('show', 'destroy', 'index');
});

