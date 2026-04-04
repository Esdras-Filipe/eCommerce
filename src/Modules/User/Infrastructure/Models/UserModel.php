<?php

namespace Modules\User\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'email',
        'password',
        'role',
        'name',
    ];
}
