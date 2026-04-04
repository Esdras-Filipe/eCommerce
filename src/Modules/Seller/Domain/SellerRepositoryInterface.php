<?php

namespace Modules\Seller\Domain;

use Modules\Seller\Domain\Seller;

interface SellerRepositoryInterface
{
    public function findById(string $id): ?Seller;
    public function findByDocument(string $document): ?Seller;
    public function findByEmail(string $email): ?Seller;
    public function findBySlug(string $slug): ?Seller;
    public function save(Seller $seller): Seller;
    public function update(Seller $seller): Seller;
    public function delete(Seller $seller): bool;
}
