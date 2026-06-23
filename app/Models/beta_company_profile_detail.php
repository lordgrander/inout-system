<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_company_profile_detail extends Model
{
    use HasFactory;

    protected $table = 'beta_company_profile_detail';
    public $timestamps = true; // set true if you have created_at/updated_at columns

    protected $fillable = [
        'text',
        'company_profile_id',
        'com_id',
        'user_id',
        'file_url',
    ];

    public function beta_company_group()
    {
        // detail.com_id -> group.id
        return $this->belongsTo(beta_company_group::class, 'com_id', 'com_id');
    }

    public function beta_company_profile()
    {
        // detail.company_profile_id -> profile.id
        return $this->belongsTo(beta_company_profile::class, 'company_profile_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
