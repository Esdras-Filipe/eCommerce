<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Seller\Providers\SellerServiceProvider::class,
];
