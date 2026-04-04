<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\Seller\Http\SellerController;

Route::prefix('sellers')->group(function () {
    Route::post('/register', [SellerController::class, 'register']);
});
