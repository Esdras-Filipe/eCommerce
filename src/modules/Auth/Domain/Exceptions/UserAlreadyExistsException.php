<?php

namespace Modules\Auth\Domain\Exceptions;

class UserAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('User Already Exists');
    }
}
