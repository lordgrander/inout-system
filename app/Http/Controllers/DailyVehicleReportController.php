<?php

namespace App\Http\Controllers;

use App\Services\Reports\DailyVehicleTargetService;
use App\Services\Reports\VehicleDetailSelectionService;
use App\Services\Reports\VehicleReportBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DailyVehicleReportController extends Controller
{
    public function index(
        Request $request,
        DailyVehicleTargetService $targetService,
        VehicleDetailSelectionService $selectionService,
        VehicleReportBuilderService $reportBuilder
    ) {
        $date = $request->query('date');
        $report = null;
        $errors = collect();

        if ($date !== null) {
            $validator = Validator::make($request->query(), [
                'date' => ['required', 'date_format:Y-m-d'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
            } else {
                $statistic = $targetService->findForDate($date);

                if (! $statistic) {
                    $errors = collect(['No daily vehicle statistic exists for this date.']);
                } else {
                    $target = (int) $statistic->vehicles;
                    $selection = $selectionService->selectForDate($date, $target);
                    $report = $reportBuilder->build($date, $target, $selection);
                }
            }
        }

        return view('reports.daily-vehicle', [
            'date' => $date,
            'report' => $report,
            'reportErrors' => $errors,
        ]);
    }

    public function legacyRange(
        string $start,
        string $end,
        DailyVehicleTargetService $targetService,
        VehicleDetailSelectionService $selectionService,
        VehicleReportBuilderService $reportBuilder
    ) {
        $validator = Validator::make([
            'start' => $start,
            'end' => $end,
        ], [
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d'],
        ]);

        $messages = [];
        $selections = [];

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
        } elseif (strtotime($start) > strtotime($end)) {
            $messages = ['Start date must be before or equal to end date.'];
        } else {
            foreach ($this->datesBetween($start, $end) as $date) {
                $statistic = $targetService->findForDate($date);

                if (! $statistic) {
                    $messages[] = 'No daily vehicle statistic exists for this date: '.$date;
                    continue;
                }

                $selections[$date] = $selectionService->selectForDate($date, (int) $statistic->vehicles);
            }
        }

        $viewData = $reportBuilder->buildLegacyRange($start, $end, $selections, $messages);

        return view('reports.daily-vehicle-legacy', $viewData);
    }

    public function successRange(
        string $start,
        string $end,
        VehicleReportBuilderService $reportBuilder
    ) {
        $validator = Validator::make([
            'start' => $start,
            'end' => $end,
        ], [
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d'],
        ]);

        $messages = [];

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $viewData = $reportBuilder->buildSuccessRange($start, $end, $messages);
        } elseif (strtotime($start) > strtotime($end)) {
            $messages = ['Start date must be before or equal to end date.'];
            $viewData = $reportBuilder->buildSuccessRange($start, $end, $messages);
        } else {
            $viewData = $reportBuilder->buildSuccessRange($start, $end);
        }

        return view('reports.daily-vehicle-legacy', $viewData);
    }

    private function datesBetween(string $start, string $end): array
    {
        $dates = [];
        $current = strtotime($start);
        $last = strtotime($end);

        while ($current <= $last) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }
}
