<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_enter_file extends Model
{
    use HasFactory;
    public $table = 'beta_enter_file';
    public $timestamps = false;
    protected $primaryKey = 'file_id';   // 👈 add this

    protected $fillable = [ 
        'user_id',
        'date',
        'file_url',
        'enter_id',
    ];
    public function fileHaveEnter()
    {
        return $this->belongsTo(beta_enter::class, 'enter_id', 'enter_id');
    }
}
