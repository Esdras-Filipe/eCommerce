<?php

namespace Modules\Seller\Domain;

use Modules\Seller\Domain\Seller;

interface SellerRepositoryInterface
{
    public function findById(string $id): ?Seller;
    public function findByCnpj(int $cnpj): ?Seller;
    public function save(Seller $seller): Seller;
    public function update(Seller $seller): Seller;
}
