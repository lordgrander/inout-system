<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewEnterFile extends Model
{
    protected $table = 'new_enter_files';
    public $timestamps = false;

    protected $fillable = [
        'new_enter_id',
        'user_id',
        'date',
        'file_url',
        'original_name',
        'file_size',
        'mime_type',
        'created_at',
        'updated_at',
    ];
}
