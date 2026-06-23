<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
  


use Carbon\carbon;

 
Use App\Models\beta_company_group; 
Use App\Models\beta_com_nano; 
Use App\Models\beta_watching_list; 
Use App\Models\beta_company_profile; 
Use App\Models\beta_company_profile_detail; 
Use App\Models\beta_extend_detail; 
use App\Models\DateAndCancelValue;
use Session;

class DocumentController extends Controller
{
    public function index()
    {
       return view('notallow.document.index');
    }

    public function docreport($start, $end)
    {
        $count_by_day = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
                $q->whereDate('e.date_make', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('e.date_make', '<=', $end);
            })
            ->select(
                DB::raw('DATE(e.date_make) as report_date'),
                DB::raw('COUNT(ed.enter_id) as total')
            )
            ->groupBy(DB::raw('DATE(e.date_make)'))
            ->orderBy('report_date', 'asc')
            ->get();
 

        $cancel_values = DB::table('date_and_cancel_value')
        ->whereBetween('date', [$start, $end])
        ->pluck('cancel_value', 'date') // Creates ['2025-03-01' => 32, '2025-03-02' => 15]
        ->toArray();

        $get_count    = DB::select("SELECT DATE(e.date_make) as date_only, COUNT(ed.enter_detail_id) AS total_take FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id  WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND e.take = '1' GROUP BY date_only ");
      
     

        return view('notallow.document.index', compact(
            'count_by_day',
            'start',
            'end',
            'get_count',
            'cancel_values'
        ));
    }
}