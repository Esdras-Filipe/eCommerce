<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\Auth\Http\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::patch('/update', [AuthController::class, 'update']);
});
