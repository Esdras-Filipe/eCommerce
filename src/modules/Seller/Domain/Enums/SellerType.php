<?php

namespace Modules\Seller\Domain\Enums;

enum SellerType: string
{
    case Individual = 'individual';   // pessoa física
    case Company = 'company';         // pessoa jurídica
}
