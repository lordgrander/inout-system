<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyVehicleStatistic extends Model
{
    protected $table = 'daily_vehicle_statistics';

    protected $fillable = [
        'stat_date',
        'vehicles',
    ];

    protected $casts = [
        'vehicles' => 'integer',
    ];
}
