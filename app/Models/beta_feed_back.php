<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_feed_back extends Model
{
    use HasFactory;
    public $table = 'beta_feed_back';
    public $timestamps = false;

    protected $fillable = [ 
        'com_id',
        'user_id',
        'date',
        'time',
        'feed_back_msg',
        'ref_id',
        'pointer',
    ];
}
