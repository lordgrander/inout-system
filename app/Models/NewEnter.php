<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewEnter extends Model
{
    protected $table = 'new_enters';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'com_id',
        'enter_number',
        'sign_status',
        'take',
        'date_make',
        'date_in',
        'date_out',
        'status',
        'price',
        'lasttails',
        'slug',
        'address',
        'district',
        'province',
        'main_road_id',
        'cancel_log',
        'created_at',
        'updated_at',
    ];

    public function details()
    {
        return $this->hasMany(NewEnterDetail::class, 'new_enter_id');
    }

    public function files()
    {
        return $this->hasMany(NewEnterFile::class, 'new_enter_id');
    }
}
