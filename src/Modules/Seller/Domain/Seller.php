<?php

namespace Modules\Seller\Domain;

class Seller
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $document,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $is_active,
        public readonly bool $is_verified,
        public readonly ?string $logo_url,
        public readonly ?string $banner_url,
        public readonly ?string $description,
        public readonly string $currency,
    ) {}
}
