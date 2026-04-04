<?php

namespace Modules\User\Domain\Exceptions;

class UserPermissionDeniedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Usuário Não Possui Permissão para a Ação');
    }
}
