<?php

namespace Modules\Seller\Http;

use Illuminate\Routing\Controller;

class SellerController extends Controller
{
    public function __construct() {}

    public function register()
    {
        return response()->json(['data' => 'Isso é um teste'], 200);
    }
}
