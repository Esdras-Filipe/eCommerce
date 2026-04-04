<?php

namespace Modules\Auth\Infrastructure;

use Modules\Auth\Domain\User;
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Infrastructure\Models\UserModel;
use Modules\Auth\Domain\Exceptions\DatabaseException;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        $model = UserModel::where('email', $email)->first();

        if (!$model) {
            return null;
        }

        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            passwordHash: $model->password,
            role: $model->role,
        );
    }

    /**
     * 
     * @return User
     */
    public function findById(string $id): ?User
    {
        $model = UserModel::where('id', $id)->first();

        if (!$model) {
            return null;
        }

        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            passwordHash: $model->password,
            role: $model->role
        );
    }

    public function save(User $user): User
    {
        try {
            UserModel::create([
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => $user->passwordHash,
                'role'     => $user->role,
            ]);

            return $user;
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function update(User $user): User
    {
        try {
            UserModel::where('id', $user->id)->update([
                'email'             => $user->email,
                'name'              => $user->name,
                'role'              => $user->role,
                'email_verified_at' => $user->email_verified_at,
                'remember_token'    => $user->remember_token,
            ]);

            return $user;
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}
