<?php

namespace Modules\User\Infrastructure;

use Modules\User\Application\DTOs\ListUsersDTO;
use Modules\User\Domain\User;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Infrastructure\Models\UserModel;
use Modules\User\Domain\Exceptions\DatabaseException;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function delete(User $user): bool
    {
        try {
            UserModel::where('id', $user->id)->delete();

            return true;
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function search(ListUsersDTO $dto): LengthAwarePaginator
    {
        $query = UserModel::query();

        if ($dto->name) {
            $query->where('name', 'like', "%{$dto->name}%");
        }

        if ($dto->email) {
            $query->where('email', 'like', "%{$dto->email}%");
        }

        $query->orderBy($dto->sortBy, $dto->sortDirection);

        $paginator = $query->paginate(
            perPage: $dto->perPage ?? 15,
            page: $dto->page ?? 1
        );

        $paginator->getCollection()->transform(function (UserModel $model) {
            return new User(
                id: $model->id,
                name: $model->name,
                email: $model->email,
                passwordHash: '',
                role: $model->role
            );
        });

        return $paginator;
    }
}
