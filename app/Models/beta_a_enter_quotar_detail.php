<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_a_enter_quotar_detail extends Model
{
    use HasFactory;
    public $table = 'beta_a_enter_quotar_detail';
    public $timestamps = false;

    protected $fillable = [
        'qo_id',
        'name',
        'qty',
        'total_price',
        'cur',
        'weight',
        'unit_id',
        'pro_id',
    ];


    public function dHaveQ()
    {
        return $this->belongsTo(beta_a_enter_quotar::class, 'qo_id', 'id');
    }


    public function dHaveP()
    {
        return $this->belongsTo(products::class, 'pro_id', 'id');
    }
}
