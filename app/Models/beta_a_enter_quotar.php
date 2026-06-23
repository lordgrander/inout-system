<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_a_enter_quotar extends Model
{
    use HasFactory;
    public $table = 'beta_a_enter_quotar';
    public $timestamps = false;

    protected $fillable = [
        'com_id',
        'user_id',
        'status',
        'created_at',
        'expired_at',
        'note',
        'file_url',
        'in',
        'out',
        'transfer',
        'correct',
        'incorrect',
        'reapply',
        'reject_and_return_the_goods',
        'yes',
        'none',
        'collect_sample_for_rapid_test',
        'local',
        'cancel_log',
    ];
    
    public function QhaveD()
    {
        return $this->hasMany(beta_a_enter_quotar_detail::class, 'qo_id');
    }

    public function QhaveF()
    {
        return $this->hasMany(beta_a_enter_quotar_file::class, 'qo_id');
    } 

    public function QHaveCom()
    {
        return $this->belongsTo(beta_company_group::class, 'com_id', 'com_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
