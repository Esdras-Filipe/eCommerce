<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\User\Http\UserController;

Route::prefix('user')->middleware('jwt')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/register', [UserController::class, 'store']);
    Route::patch('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
});
