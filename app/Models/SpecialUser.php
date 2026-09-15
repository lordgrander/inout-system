<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialUser extends Model
{
    protected $table = 'special_user';

    protected $fillable = [
        'username',
        'name',
        'password',
        'status',
        'take_visible',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];
}
