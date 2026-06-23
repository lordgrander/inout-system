<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    public $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'pro_type_id',
        'name',
    ];

    public function proHaveQuotar()
    {
        return $this->hasMany(QuotarList::class, 'pro_id');
    }

    public function proHaveQ()
    {
        return $this->hasMany(beta_a_enter_quotar_detail::class, 'pro_id');
    }
}
