<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DateAndCancelValue;
use Carbon\Carbon;

class CancelValueController extends Controller
{
    public function index() {
        return view('notallow.settings.cancel_values');
    }

    public function fetch(Request $request) {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        // Get the start and end of the chosen month
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;

        // Get existing data from DB
        $existingValues = DateAndCancelValue::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('cancel_value', 'date')
            ->toArray();

        $html = '';
        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDate = $startOfMonth->copy()->addDays($i)->format('Y-m-d');
            $value = $existingValues[$currentDate] ?? 0;

            $html .= "<tr>
                <td>{$currentDate}</td>
                <td>
                    <input type='number' class='form-control ajax-update' 
                           data-date='{$currentDate}' value='{$value}'>
                </td>
            </tr>";
        }
        return response()->json(['html' => $html]);
    }

    public function update(Request $request) {
        // Update if exists, Create if not
        DateAndCancelValue::updateOrCreate(
            ['date' => $request->date],
            ['cancel_value' => $request->value]
        );

        return response()->json(['status' => 'success']);
    }
}