<?php

namespace Modules\Sellers\Domain\ValueObjects;

class Address
{
    public function __construct(
        public readonly string $street,
        public readonly string $number,
        public readonly string $complement,
        public readonly string $district,
        public readonly string $city,
        public readonly string $state,
        public readonly string $zipCode,
    ) {}
}
