<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateAndCancelValue extends Model
{
    use HasFactory;

    // Since your table name has underscores and doesn't follow 
    // the standard "date_and_cancel_values" plural, we define it here:
    protected $table = 'date_and_cancel_value';

    // Allow these fields to be filled via forms/arrays
    protected $fillable = [
        'date',
        'cancel_value',
    ];

    // Optional: Cast the date as a date object for easier Carbon usage
    protected $casts = [
        'date' => 'date',
    ];
}