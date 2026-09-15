<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beta_enter extends Model
{ 
    use HasFactory;
    public $table = 'beta_enter';
    public $timestamps = false;
    protected $primaryKey = 'enter_id';

    protected $fillable = [
        'enter_id',
        'user_id',
        'enter_number',
        'com_id',
        'confirmer_id',
        'boss_id',
        'qboss_id',
        'markdown_id',
        'sign_status',
        'sign_url',
        'q_sign_url',
        'date_make',
        'date_confirm',
        'date_sign',
        'date_in',
        'date_out',
        'status',
        'qstatus',
        'price',
        'lasttails',
        'slug',
        'address',
        'district',
        'province',
        'mark',
        'feed_back_msg',
        'main_road_id',
        'cancel_log',
        'enter_type',
        'take',
        'expired_at',
    ]; 

    public function enterHaveDetail()
    {
        return $this->hasMany(beta_enter_detail::class, 'enter_id');
    }
    
    
    public function enterHaveFile()
    {
        return $this->hasMany(beta_enter_file::class, 'enter_id');
    }
    
    public function enf()
    {
        return $this->hasMany(beta_enter_file::class, 'enter_id');
    }
    
    public function markdown()
    {
        return $this->belongsTo(BetaMarkdown::class, 'markdown_id');
    }
}
