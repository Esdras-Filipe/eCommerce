<?php

namespace Modules\Auth\Domain;

use Modules\Auth\Domain\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function findById(string $id): ?User;
    public function save(User $user): User;
    public function update(User $user): User;
}
