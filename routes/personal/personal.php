<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonalController;


Route::prefix('v1')->group(function () {
    

    Route::apiResource('personal', PersonalController::class)->except('show', 'destroy');
});
