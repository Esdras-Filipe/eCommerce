<?php

namespace Modules\Seller\Application\DTOs;

class UpdateSellerDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name,
        public readonly ?string $logo_url,
        public readonly ?string $banner_url,
        public readonly ?string $description,
    ) {}
}
