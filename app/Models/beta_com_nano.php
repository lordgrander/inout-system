<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_com_nano extends Model
{ 
    use HasFactory;
    public $table = 'beta_com_nano';
    public $timestamps = false;

    protected $fillable = [
        'id', 
        'com_id', 
        'subject', 
        'created_at', 
        'updated_at', 
    ]; 
 
}
