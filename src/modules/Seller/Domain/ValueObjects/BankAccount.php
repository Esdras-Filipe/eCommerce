<?php

namespace Modules\Sellers\Domain\ValueObjects;

class BankAccount
{
    public function __construct(
        public readonly string $bank,
        public readonly string $agency,
        public readonly string $account,
        public readonly string $accountType,
    ) {}
}
