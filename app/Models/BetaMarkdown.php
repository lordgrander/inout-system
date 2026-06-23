<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetaMarkdown extends Model
{
    use HasFactory;

    protected $table = 'beta_markdown';

    protected $fillable = [
        'id',
        'name',
        'detail',
        'created_at',
        'updated_at'
    ];  

    public function enters()
    {
        return $this->hasMany(beta_enter::class, 'markdown_id');
    }
}
