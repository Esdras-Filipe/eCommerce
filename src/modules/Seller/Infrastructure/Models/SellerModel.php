<?php

namespace Modules\Seller\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class SellerModel extends Model
{
    protected $table = 'cnpj';

    protected $fillable = [
        'id',
        'email',
        'password',
        'role',
        'name',
    ];
}
