<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_road_select extends Model
{
    use HasFactory;
    public $table = 'beta_road_select';
    public $timestamps = false;

    protected $fillable = [ 
        'road_name',
    ];
}
