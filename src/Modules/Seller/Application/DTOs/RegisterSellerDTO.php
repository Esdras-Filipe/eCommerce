<?php

namespace Modules\Seller\Application\DTOs;

use Modules\Seller\Domain\Enums\SellerStatus;
use Modules\Seller\Domain\Enums\SellerType;

class RegisterSellerDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $document,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $logo_url,
        public readonly ?string $banner_url,
        public readonly ?string $description,
        public readonly string $currency,
    ) {}
}
