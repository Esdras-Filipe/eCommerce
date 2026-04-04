<?php

namespace Modules\Seller\Infrastructure;

use Modules\Seller\Domain\Seller;
use Modules\Seller\Domain\SellerRepositoryInterface;
use Modules\Seller\Infrastructure\Models\SellerModel;

use Modules\Auth\Domain\Exceptions\DatabaseException;

class EloquentSellerRepository implements SellerRepositoryInterface
{
    public function findByDocument(string $document): ?Seller
    {
        $model = SellerModel::where('document', $document)->first();
        if (!$model) {
            return null;
        }

        return $this->createEntity($model);
    }

    public function findById(string $id): ?Seller
    {
        $model = SellerModel::where('id', $id)->first();

        if (!$model) {
            return null;
        }

        return $this->createEntity($model);
    }

    public function findByEmail(string $email): ?Seller
    {
        $model = SellerModel::where('email', $email)->first();

        if (!$model) {
            return null;
        }

        return $this->createEntity($model);
    }

    public function findBySlug(string $slug): ?Seller
    {
        $model = SellerModel::where('slug', $slug)->first();

        if (!$model) {
            return null;
        }

        return $this->createEntity($model);
    }

    public function save(Seller $seller): Seller
    {
        try {
            SellerModel::create([
                'id'          => $seller->id,
                'name'        => $seller->name,
                'slug'        => $seller->slug,
                'email'       => $seller->email,
                'password'    => $seller->password,
                'document'    => $seller->document,
                'is_active'   => $seller->is_active,
                'is_verified' => $seller->is_verified,
                'logo_url'    => $seller->logo_url,
                'banner_url'  => $seller->banner_url,
                'description' => $seller->description,
                'currency'    => $seller->currency,
            ]);

            return $seller;
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function update(Seller $seller): Seller
    {
        try {
            SellerModel::where('id', $seller->id)->update([
                'name'        => $seller->name,
                'slug'        => $seller->slug,
                'email'       => $seller->email,
                'password'    => $seller->password,
                'document'    => $seller->document,
                'is_active'   => $seller->is_active,
                'is_verified' => $seller->is_verified,
                'logo_url'    => $seller->logo_url,
                'banner_url'  => $seller->banner_url,
                'description' => $seller->description,
                'currency'    => $seller->currency,
            ]);

            return $seller;
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
    public function delete(Seller $seller): bool
    {
        try {
            return SellerModel::where('id', $seller->id)->delete();
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    private function createEntity(object $model): Seller
    {
        return new Seller(
            id: $model->id,
            name: $model->name,
            slug: $model->slug,
            email: $model->email,
            password: $model->password,
            document: $model->document,
            is_active: $model->is_active,
            is_verified: $model->is_verified,
            logo_url: $model->logo_url,
            banner_url: $model->banner_url,
            description: $model->description,
            currency: $model->currency,
        );
    }
}
