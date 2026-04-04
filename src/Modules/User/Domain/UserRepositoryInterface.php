<?php

namespace Modules\User\Domain;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Application\DTOs\ListUsersDTO;
use Modules\User\Domain\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function findById(string $id): ?User;

    public function save(User $user): User;

    public function update(User $user): User;

    public function delete(User $user): bool;

    public function search(ListUsersDTO $dto): LengthAwarePaginator;
}
