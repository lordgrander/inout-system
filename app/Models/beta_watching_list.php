<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_watching_list extends Model
{
    use HasFactory;
    public $table = 'beta_watching_list';
    public $timestamps = false;

    protected $fillable = [ 
        'watching_number',
        'watching_normal',
        'created_at',
    ];
}
