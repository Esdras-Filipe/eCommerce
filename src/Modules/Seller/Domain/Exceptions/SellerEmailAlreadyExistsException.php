<?php

namespace Modules\Seller\Domain\Exceptions;

class SellerEmailAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('CNPJ Informado Já Possui Cadastro');
    }
}
