<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_p_type extends Model
{
    use HasFactory;
    public $table = 'beta_p_type';
    public $timestamps = false;

    protected $fillable = [
        'p_type_name',
    ];
}
