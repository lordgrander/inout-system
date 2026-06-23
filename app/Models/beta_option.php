<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_option extends Model
{ 
    use HasFactory;
    public $table = 'beta_option';
    public $timestamps = false;

    protected $fillable = [ 
        'print',
    ];
}
