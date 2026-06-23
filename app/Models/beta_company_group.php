<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // import

class beta_company_group extends Model
{
    use HasFactory;

    protected $table = 'beta_company_group';
    public $timestamps = true; // if you have created_at/updated_at

    protected $fillable = [
        'com_name',
        'com_owner',
        'com_phone',
        'com_status',
        'active_at',
        'end_at',
    ];

    public function companyHaveUser()
    {
        // users.com_id -> group.id
        return $this->hasMany(User::class, 'com_id', 'id');
    }

    public function companyHaveQ()
    {
        return $this->hasMany(beta_enter_quotar::class, 'com_id', 'id');
    }

    public function beta_company_profile()
    {
        // profile.com_id -> group.id
        return $this->hasMany(beta_company_profile::class, 'com_id', 'id');
    }

    public function beta_company_profile_detail()
    {
        // detail.com_id -> group.id
        return $this->hasMany(beta_company_profile_detail::class, 'com_id', 'id');
    }
}
