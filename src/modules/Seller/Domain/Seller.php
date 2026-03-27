<?php

namespace Modules\Seller\Domain;

use Modules\Seller\Domain\Enums\SellerStatus;
use Modules\Seller\Domain\Enums\SellerType;

class Seller
{
    public function __construct(
        private readonly string $id,
        private readonly string $fantayName,
        private readonly SellerType $type,
        private readonly int $cnpj,
        private readonly string $email,
        private readonly string $cellphone,
        private readonly string $address,
        private readonly SellerStatus $status
    ) {}
}
