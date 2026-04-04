<?php

namespace Modules\Auth\Tests\Fakes;

use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\User;

class FakeUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function add(User $user): void
    {
        $this->users[$user->email] = $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->users[$email] ?? null;
    }

    public function save(User $user): User
    {
        $this->users[$user->email] = $user;

        return $user;
    }
}
