<?php

namespace Modules\Seller\Application\DTOs;

class ListSellerDTO
{
    public function __construct(
        public readonly int $page,
        public readonly ?int $perPage,
        public readonly ?string $sortBy,
        public readonly ?string $sortDirection,
        public readonly ?string $name,
        public readonly ?string $slug,
        public readonly ?string $document,
        public readonly ?string $email,
        public readonly ?bool $is_active,
        public readonly ?bool $is_verified,
        public readonly ?string $description,
        public readonly ?string $currency,
    ) {}
}
