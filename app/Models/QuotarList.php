<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotarList extends Model
{
    use HasFactory;
    public $table = 'quotarlist';
    public $timestamps = false;

    protected $fillable = [
        'com_id',
        'pro_id',
        'pro_type_id',
        'unit_id',
        'total_in',
        'total_out',
        'lastupdated_at',
        'expired_at',
    ];
    public function QuotarHaveUnit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    
    public function QuotarHaveType()
    {
        return $this->belongsTo(typex::class, 'pro_type_id', 'id');
    }

    public function proHaveDetail()
    {
        return $this->hasMany(beta_enter_detail::class, 'pro_id');
    }

    public function QuotarHaveProduct()
    {
        return $this->belongsTo(products::class, 'pro_id', 'id');
    }
}
