<?php

namespace Modules\User\Domain\Exceptions;

class InvalidCredentialsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Credenciais inválidas');
    }
}
