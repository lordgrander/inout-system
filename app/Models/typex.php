<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typex extends Model
{
    use HasFactory;
    public $table = 'typex';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function proHaveType()
    {
        return $this->hasMany(products::class, 'pro_type_id');
    }
}
