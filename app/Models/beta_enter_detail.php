<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_enter_detail extends Model
{
    use HasFactory;
    public $table = 'beta_enter_detail';
    public $timestamps = false;

    protected $fillable = [
        'enter_id',
        'user_id',
        'plate_number',
        'end_plate_number',
        't_model',
        'd_name',
        'p_import',
        'rounds',
        'weight',
        'detail',
        'status',
        't_type_id',
        'p_type_id',
        'pro_id',
        'remark',
        'remark_created_at',
        'remark_canceled_at',
        'remark_by',
    ];


    public function detailHaveQuotar()
    {
        return $this->belongsTo(QuotarList::class, 'pro_id', 'id');
    }


    public function detailHaveEnter()
    {
        return $this->belongsTo(beta_enter::class, 'enter_id', 'enter_id');
    }

}
