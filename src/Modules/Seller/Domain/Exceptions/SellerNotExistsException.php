<?php

namespace Modules\Seller\Domain\Exceptions;

class SellerNotExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('ID de Loja Informada não existe');
    }
}
