<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_tell_car_insurance extends Model
{
    use HasFactory;

    public $table = 'beta_tell_car_insurance';
    public $timestamps = false;

    protected $fillable = [ 
        'com_id',
        'plate_number',
        'insurance_extra_number',
        'car_type_id',
        'file_upload',
        'date_in',
        'created_at',
        'updated_at',
        'status', 
        'user_id', 
        'cancel_reason', 
        'remark', 
    ];

 
}
