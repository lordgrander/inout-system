<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_main_road extends Model
{
    use HasFactory;
    public $table = 'beta_main_road';
    public $timestamps = false;

    protected $fillable = [ 
        'main_road_name',
    ];
}
