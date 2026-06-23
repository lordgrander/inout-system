<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_t_type extends Model
{
    use HasFactory;
    public $table = 'beta_t_type';
    public $timestamps = false;

    protected $fillable = [
        't_type_name',
        'is_round',
        'updated_at',
    ];
}
