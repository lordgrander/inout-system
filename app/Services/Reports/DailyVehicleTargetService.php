<?php

namespace App\Services\Reports;

use App\Models\DailyVehicleStatistic;

class DailyVehicleTargetService
{
    public function findForDate(string $date): ?DailyVehicleStatistic
    {
        return DailyVehicleStatistic::query()
            ->whereDate('stat_date', $date)
            ->first();
    }
}
