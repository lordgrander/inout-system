<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_company_profile extends Model
{
    use HasFactory;

    protected $table = 'beta_company_profile';
    public $timestamps = true; // if timestamps exist

    protected $fillable = [
        'text',
        'com_id',
        'user_id',
        'status',
        'log',
    ];

    public function beta_company_profile_detail()
    {
        // details.company_profile_id -> profile.id   (FIXED)
        return $this->hasMany(beta_company_profile_detail::class, 'company_profile_id', 'id');
    }

    public function beta_company_group()
    {
        // profile.com_id -> group.id   (FIXED method name)
        return $this->belongsTo(beta_company_group::class, 'com_id', 'com_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
