<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_price extends Model
{
    use HasFactory;
    public $table = 'beta_price';
    public $timestamps = false;

    protected $fillable = [
        'price_name',
        'price_total',
    ];
}
