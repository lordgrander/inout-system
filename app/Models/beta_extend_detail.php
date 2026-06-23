<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_extend_detail extends Model
{
    use HasFactory;

     public $table = 'beta_extend_detail';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'com_id', 
        'approved_by_user_id', 
        'object_data', 
        'log', 
        'end_at', 
        'created_at', 
        'updated_at',  
    ]; 
 

    public function beta_company_group()
    {
        return $this->belongsTo(beta_company_group::class, 'com_id', 'com_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Approve()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id', 'id');
    }


}
