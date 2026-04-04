<?php

namespace Modules\User\Tests\Fakes;

use Modules\User\Domain\TokenGeneratorInterface;
use Modules\User\Domain\User;

class FakeTokenGenerator implements TokenGeneratorInterface
{
    public function generate(User $user): string
    {
        return 'fake-token-' . $user->id;
    }
}
