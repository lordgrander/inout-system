<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_insurance extends Model
{
    use HasFactory;
    public $table = 'beta_insurance';
    public $timestamps = false;

    protected $fillable = [ 
        'name',
        'images_url',
        'created_at',
        'updated_at',
    ];
}
