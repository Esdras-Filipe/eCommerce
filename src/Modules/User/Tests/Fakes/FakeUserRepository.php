<?php

namespace Modules\User\Tests\Fakes;

use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\User;

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
