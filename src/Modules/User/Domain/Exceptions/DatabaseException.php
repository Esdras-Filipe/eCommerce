<?php

namespace Modules\User\Domain\Exceptions;

class DatabaseException extends \Exception
{
    public function __construct(?string $message, \Throwable $previous = null)
    {
        parent::__construct(($message ?? 'Error Creating Register'), 0, $previous);
    }
}
