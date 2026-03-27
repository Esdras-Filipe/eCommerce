<?php

namespace Modules\Seller\Domain\Enums;

enum SellerStatus: string
{
    case Active = 'active';
    case Suspended = 'suspended';
    case UnderReview = 'under_review';
}
