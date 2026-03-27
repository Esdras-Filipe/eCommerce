<?php

namespace Modules\Seller\Application\DTOs;

use Modules\Seller\Domain\Enums\SellerStatus;
use Modules\Seller\Domain\Enums\SellerType;

class RegisterSellerDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $fantayName,
        public readonly SellerType $type,
        public readonly string $documentNumber,
        public readonly string $email,
        public readonly string $cellphone,
        public readonly string $address,
        public readonly SellerStatus $status
    ) {}
}
