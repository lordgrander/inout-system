<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_enter_road_detail extends Model
{
    use HasFactory;
    public $table = 'beta_enter_road_detail';
    public $timestamps = false;

    protected $fillable = [ 
        'enter_id',
        'road_id',
    ];
}
