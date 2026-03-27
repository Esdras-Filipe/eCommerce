<?php

namespace Modules\Seller\Infrastructure;

use Modules\Seller\Domain\Seller;
use Modules\Seller\Domain\SellerRepositoryInterface;
use Modules\Seller\Infrastructure\Models\SellerModel;

use Modules\Auth\Domain\Exceptions\DatabaseException;

class EloquentSellerRepository implements SellerRepositoryInterface
{
    public function findByCnpj(int $cnpj): ?Seller
    {
        $model = SellerModel::where('cnpj', $cnpj)->first();

        if (!$model) {
            return null;
        }

        return new Seller(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            passwordHash: $model->password,
            role: $model->role,
        );
    }

    /**
     * 
     * @return Seller
     */
    public function findById(string $id): ?Seller {}

    public function save(User $user): Seller
    {
        try {
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function update(User $user): Seller
    {
        try {
        } catch (\Exception $e) {
            // throw new DatabaseException($e->getMessage());
        }
    }
}
