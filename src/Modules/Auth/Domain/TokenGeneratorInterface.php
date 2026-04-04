<?php

namespace Modules\Auth\Domain;

interface TokenGeneratorInterface
{
    public function generate(User $user): string;

    public function validateToken(string $token): object;
}
