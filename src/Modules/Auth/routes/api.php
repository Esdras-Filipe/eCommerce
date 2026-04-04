<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
