<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\Seller\Http\SellerController;

Route::prefix('seller')->group(function () {
    Route::post('/register', [SellerController::class, 'register']);
    Route::patch('/update/{id}', [SellerController::class, 'update']);
    Route::delete('/delete/{id}', [SellerController::class, 'delete']);
});
