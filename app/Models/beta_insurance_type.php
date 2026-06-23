<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_insurance_type extends Model
{
    use HasFactory;
    public $table = 'beta_insurance_type';
    public $timestamps = false;

    protected $fillable = [ 
        'insurance_id',
        'name',
        'price',
        'date_limit',
        'created_at',
        'updated_at',
    ];
}
