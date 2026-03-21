<?php

namespace Modules\Auth\Domain\Exceptions;

class InvalidCredentialsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Credenciais inválidas');
    }
}
