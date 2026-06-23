<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_cars extends Model
{
    use HasFactory;

    public $table = 'beta_cars';
    public $timestamps = false;

    protected $fillable = [ 
        'com_id',
        'insurance_type_id',
        'insurance_id',
        'user_id',
        't_type_id',
        'plate_number',
        'end_plate_number',
        'engine_number',
        'file_url',
        'created_at',
        'active_at',
        'expired_at',
        'updated_at',
        'log', 
    ];


    public function beta_company_group()
    {
        return $this->belongsTo(beta_company_group::class, 'com_id', 'com_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
