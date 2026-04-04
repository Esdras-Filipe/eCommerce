<?php

namespace Modules\Seller\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class SellerModel extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'sellers';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'document',
        'email',
        'password',
        'is_active',
        'is_verified',
        'logo_url',
        'banner_url',
        'description',
        'currency',

    ];
}
