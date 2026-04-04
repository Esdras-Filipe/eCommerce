<?php

namespace Modules\Auth\Tests\Fakes;

use Modules\Auth\Domain\TokenGeneratorInterface;
use Modules\Auth\Domain\User;

class FakeTokenGenerator implements TokenGeneratorInterface
{
    public function generate(User $user): string
    {
        return 'fake-token-' . $user->id;
    }
}
