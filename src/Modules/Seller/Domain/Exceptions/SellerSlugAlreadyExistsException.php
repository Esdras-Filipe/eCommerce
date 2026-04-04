<?php

namespace Modules\Seller\Domain\Exceptions;

class SellerSlugAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Nome da Marca já Está em Uso');
    }
}
