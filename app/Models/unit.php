<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    use HasFactory;
    public $table = 'unit';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];


    public function unitInQuotar()
    {
        return $this->hasMany(QuotarList::class, 'unit_id');
    }
}
