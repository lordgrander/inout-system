<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_a_enter_quotar_file extends Model
{
    use HasFactory;

    public $table = 'beta_a_enter_quotar_file';
    public $timestamps = false;

    protected $fillable = [ 
        'user_id',
        'date',
        'file_url',
        'qo_id',
    ];


    public function fHaveQ()
    {
        return $this->belongsTo(beta_a_enter_quotar::class, 'qo_id', 'id');
    }
}
