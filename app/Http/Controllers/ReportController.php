<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use Carbon\carbon;


Use App\Models\beta_enter;
Use App\Models\beta_company_group;
Use App\Models\beta_enter_detail;
Use App\Models\beta_enter_file;
Use App\Models\beta_feed_back;
Use App\Models\beta_main_road;
Use App\Models\beta_sign;
Use App\Models\beta_option;
class ReportController extends Controller
{

    public function index()
    {
        return view('notallow.report.index');
    }

    public function print($id)
    {
        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.enter_id = '".$id."'"); 

        $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = '".$id."'");

        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
             
        $com_name_data = DB::select("SELECT * FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name_data[0]->com_name;
        $com_owner_name = $com_name_data[0]->com_owner;

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$id."'");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$id."'");

        $option = DB::select("SELECT * FROM beta_option");
   
        if($option[0]->print=='old')
        {
           if($beta_enter[0]->mark=='0')
           {
                return view('notallow.see.print',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
           }
           else
           {  
               return view('notallow.see.print_mark',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
           }
        }
        else
        {
           
            return view('notallow.see.print_new',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
        }
    }
    

    public function print_abc($enter_number,$year,$left,$right,$image_size)
    {
        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.enter_number = '".$enter_number."' AND YEAR(e.date_make) = '".$year."'"); 
         $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = '".$beta_enter[0]->enter_id."'");
        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
             
        $com_name_data = DB::select("SELECT * FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name_data[0]->com_name;
        $com_owner_name = $com_name_data[0]->com_owner;

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$beta_enter[0]->enter_id."'");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$beta_enter[0]->enter_id."'");

        $option = DB::select("SELECT * FROM beta_option");
   
        if($option[0]->print=='old')
        {
           if($beta_enter[0]->mark=='0')
           {
                return view('notallow.see.print_abc',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$beta_enter[0]->enter_id)
                ->with('left',$left)->with('right',$right)
                ->with('image_size',$image_size); 
           }
           else
           {  
               return view('notallow.see.print_mark',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$beta_enter[0]->enter_id)->with('left',$left)->with('right',$right)->with('image_size',$image_size); 
           }
        }
        else
        {
           
            return view('notallow.see.print_new',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$beta_enter[0]->enter_id)->with('left',$left)->with('right',$right)->with('image_size',$image_size); 
        }
    }
    

    public function print_test($id)
    {
        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.enter_id = '".$id."'"); 

        $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = '".$id."'");

        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
             
        $com_name_data = DB::select("SELECT * FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name_data[0]->com_name;
        $com_owner_name = $com_name_data[0]->com_owner;

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$id."'");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$id."'");

        $option = DB::select("SELECT * FROM beta_option");
   
        if($option[0]->print=='old')
        {
           if($beta_enter[0]->mark=='0')
           {
                return view('notallow.see.print_test',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
           }
           else
           {  
               return view('notallow.see.print_mark',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
           }
        }
        else
        {
           
            return view('notallow.see.print_test',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
        }
    }
    
    public function daily($start, $end)
    {
        $start_original = $start;
        $end_original   = $end;

        // user 805 => show all dates (no filter)
        if (auth()->user()->id == '805') {
            $start = null;
            $end   = null;
        }

        $com        = DB::table('beta_company_group')->get();
        $main_road  = DB::table('beta_main_road')->get();
        $beta_t_type= DB::table('beta_t_type')->get();

        // Base query for SUCCESS enters
        $baseEnter = DB::table('beta_enter as e')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        });

        // 1) beta_enter list
        $beta_enter = (clone $baseEnter)
            ->orderBy('e.date_make', 'asc')
            ->get();

        // 2) count per company (COUNT DISTINCT enter_id is usually what you want)
        // If you truly want count of details rows, use join + count(ed.enter_id) instead.
        $count_beta_enter = (clone $baseEnter)
            ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 3) count details per company (this matches your old $count_t_model logic)
        $count_t_model = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select('e.com_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 4) main_road counts
        $count_main_road = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select('e.main_road_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD'))
            ->groupBy('e.main_road_id')
            ->get()
            ->keyBy('main_road_id');

        // 5) t_type counts
        $count_beta_t_type = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
           ->when($start, function ($q) use ($start) {
                $q->whereDate('e.date_make', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('e.date_make', '<=', $end);
            })
            ->select('ed.t_model', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_T'))
            ->groupBy('ed.t_model')
            ->get()
            ->keyBy('t_model');

        // 6) detail rows (only needed when sw on)
        $enter_detail = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
            $q->whereDate('e.date_make', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('e.date_make', '<=', $end);
        })
            ->select(
                'e.enter_id', 'e.com_id', 'e.date_make', 'e.enter_number',
                'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
                't.t_type_name'
            )
            ->orderBy('e.date_make','asc')
            ->get();

        $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

        // Index details by com_id then enter_id for fast Blade rendering
        $detailsByComEnter = [];
        if ($sw === 'on') {
            foreach ($enter_detail as $d) {
                $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
            }
        }

        $rounds_count = DB::select("SELECT COUNT(ed.rounds) AS total_round FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND ed.rounds > '1' ");
        $rounds_count = $rounds_count[0]->total_round;
        $get_count    = DB::select("SELECT COUNT(ed.enter_detail_id) AS total_take FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id  WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND e.take = '1' ");
        $take_count   = $get_count[0]->total_take;
     
        $take_list  = DB::select("SELECT e.*,c.* FROM beta_enter e JOIN beta_company_group c ON e.com_id = c.com_id WHERE date(e.date_make) >= '".$start."' AND date(e.date_make) <= '".$end."' AND e.take = '1' ");
        $detail_list = DB::SELECT("SELECT * FROM beta_enter_detail WHERE enter_id IN (SELECT enter_id FROM beta_enter WHERE date(date_make) >= '".$start."' AND date(date_make) <= '".$end."' AND take = '1')");
        return view('notallow.report.daily', compact(
            'com',
            'main_road',
            'beta_t_type',
            'beta_enter',
            'sw',
            'detailsByComEnter',
            'count_t_model',
            'count_main_road',
            'count_beta_t_type',
            'count_beta_enter',
            'take_list',
            'detail_list'
        ))
        ->with('start', $start_original)
        ->with('end', $end_original)
        ->with('rounds_count',$rounds_count)
        ->with('take_count',$take_count)
        ;
    }


    public function daily_testing($start, $end)
    {
         $start_original = $start;
        $end_original   = $end;

    // user 805 => show all dates (no filter)
  

    // ✅ limiter (display only 80% of details, but keep at least 1 per enter_id)
    $limiter_percent = 20;
    $keepPercent     = (100 - $limiter_percent) / 100; // 0.80

    $com         = DB::table('beta_company_group')->get();
    $main_road   = DB::table('beta_main_road')->get();
    $beta_t_type = DB::table('beta_t_type')->get();

    // Base query for SUCCESS enters
    $baseEnter = DB::table('beta_enter as e')
        ->where('e.status', 'SUCCESS')
        ->when($start, function ($q) use ($start) { $q->whereDate('e.date_make', '>=', $start); })
        ->when($end,   function ($q) use ($end)   { $q->whereDate('e.date_make', '<=', $end); });

    // 1) beta_enter list (for headers/groups)
    $beta_enter = (clone $baseEnter)
        ->orderBy('e.date_make', 'asc')
        ->get();

    // 2) count enter per company (this is enter count, not detail count)
    $count_beta_enter = (clone $baseEnter)
        ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
        ->groupBy('e.com_id')
        ->get()
        ->keyBy('com_id');

    // 3) FULL detail rows first
    $enter_detail_full = DB::table('beta_enter_detail as ed')
        ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
        ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
        ->where('e.status', 'SUCCESS')
        ->when($start, function ($q) use ($start) { $q->whereDate('e.date_make', '>=', $start); })
        ->when($end,   function ($q) use ($end)   { $q->whereDate('e.date_make', '<=', $end); })
        ->select(
            'e.enter_id','e.com_id','e.main_road_id','e.date_make','e.enter_number',
            'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
            't.t_type_name'
        )
        ->orderBy('e.date_make','asc')
        ->orderBy('ed.enter_detail_id','asc')
        ->get();

    // 4) Reduce details per enter_id (keep at least 1)
    $grouped = [];
    foreach ($enter_detail_full as $d) {
        $grouped[$d->enter_id][] = $d;
    }

    $enter_detail = collect();

    foreach ($grouped as $enter_id => $rows) {
        $n = count($rows);

        // always keep at least 1
        if ($n <= 1) {
            $enter_detail->push($rows[0]);
            continue;
        }

        // ✅ reduce only "extras": keep = 1 + floor((n-1) * keepPercent)
        $keepExtras = (int) floor(($n - 1) * $keepPercent);
        $keepCount  = 1 + max(0, $keepExtras);

        if ($keepCount < 1) $keepCount = 1;
        if ($keepCount > $n) $keepCount = $n;

        // keep first row stable + randomly pick from the rest
        $kept = [$rows[0]];
        $rest = array_slice($rows, 1);
        shuffle($rest);

        $need = $keepCount - 1;
        for ($i = 0; $i < $need; $i++) {
            if (!isset($rest[$i])) break;
            $kept[] = $rest[$i];
        }

        // sort back for nice display
        usort($kept, function($a,$b){
            return $a->enter_detail_id <=> $b->enter_detail_id;
        });

        foreach ($kept as $k) $enter_detail->push($k);
    }

    // 5) sw based on REDUCED details
    $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

    // 6) Build detailsByComEnter from REDUCED details
    $detailsByComEnter = [];
    if ($sw === 'on') {
        foreach ($enter_detail as $d) {
            $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
        }
    }

    // 7) ✅ Recalculate counts from REDUCED details (this is the balance magic)
    $tmpCompany = [];
    $tmpRoad    = [];
    $tmpType    = [];

    foreach ($enter_detail as $d) {
        $tmpCompany[$d->com_id] = ($tmpCompany[$d->com_id] ?? 0) + 1;
        $tmpRoad[$d->main_road_id] = ($tmpRoad[$d->main_road_id] ?? 0) + 1;
        $tmpType[$d->t_model] = ($tmpType[$d->t_model] ?? 0) + 1;
    }

    // turn into objects so Blade can use ->TOTAL_COUNT_...
    $count_t_model = collect();
    foreach ($tmpCompany as $com_id => $cnt) {
        $count_t_model->push((object)[ 'com_id' => $com_id, 'TOTAL_COUNT' => $cnt ]);
    }
    $count_t_model = $count_t_model->keyBy('com_id');

    $count_main_road = collect();
    foreach ($tmpRoad as $mid => $cnt) {
        $count_main_road->push((object)[ 'main_road_id' => $mid, 'TOTAL_COUNT_MAIN_ROAD' => $cnt ]);
    }
    $count_main_road = $count_main_road->keyBy('main_road_id');

    $count_beta_t_type = collect();
    foreach ($tmpType as $tmodel => $cnt) {
        $count_beta_t_type->push((object)[ 't_model' => $tmodel, 'TOTAL_COUNT_T' => $cnt ]);
    }
    $count_beta_t_type = $count_beta_t_type->keyBy('t_model');

    return view('notallow.report.daily', compact(
        'com',
        'main_road',
        'beta_t_type',
        'beta_enter',
        'sw',
        'detailsByComEnter',
        'count_t_model',
        'count_main_road',
        'count_beta_t_type',
        'count_beta_enter',
        'limiter_percent'
    ))
    ->with('start', $start_original)
    ->with('end', $end_original) 
    ->with('rounds_count', 0)
    ->with('take_count', 0)
    ;
    }
    
    
    public function dailycs($start,$end,$limit)
    {
       
        $com = DB::select("SELECT * FROM beta_company_group ");
     
        $count_t_model = DB::select("SELECT e.com_id,COUNT(ed.enter_id) AS TOTAL_COUNT FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY e.com_id");
    
        $beta_enter = DB::select("SELECT * FROM beta_enter  WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' ORDER BY date_make ASC");
        $beta_enter_fil = DB::select("SELECT  * FROM  beta_enter_file WHERE enter_id IN (SELECT enter_id FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS')");
  
        $count_beta_enter = DB::select("SELECT com_id,COUNT(enter_id) AS TOTAL_COUNT_COM FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' GROUP BY com_id");
    
        $enter_detail = DB::select("SELECT e.*,ed.*,t.t_type_name FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id JOIN beta_t_type t ON ed.t_model=t.t_type_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."'");
        $sw = 'on';
 
        if (count($enter_detail) > 1000) {
           $sw = 'off';
        }
        $main_road = DB::select("SELECT * FROM beta_main_road");
        $count_main_road = DB::SELECT("SELECT e.main_road_id,COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY main_road_id");
        
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $count_beta_t_type = DB::SELECT("SELECT ed.t_model,COUNT(ed.enter_id) AS TOTAL_COUNT_T FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY t_model");
        

        
        return view('notallow.report.dailycs',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter','beta_enter_fil'))->with('start',$start)->with('end',$end)->with('sw',$sw)->with('limit',$limit);
    }


    
    public function ptsd($start,$end)
    {
      

        $start_original = $start;
        $end_original   = $end;

        // user 805 => show all dates (no filter)
        if (auth()->user()->id == '805') {
            $start = null;
            $end   = null;
        }

        $com        = DB::table('beta_company_group')->get();
        $main_road  = DB::table('beta_main_road')->get();
        $beta_t_type= DB::table('beta_t_type')->get();

        // Base query for SUCCESS enters
        $baseEnter = DB::table('beta_enter as e')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
});

        // 1) beta_enter list
        $beta_enter = (clone $baseEnter)
            ->orderBy('e.date_make', 'asc')
            ->get();

        // 2) count per company (COUNT DISTINCT enter_id is usually what you want)
        // If you truly want count of details rows, use join + count(ed.enter_id) instead.
        $count_beta_enter = (clone $baseEnter)
            ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 3) count details per company (this matches your old $count_t_model logic)
        $count_t_model = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select('e.com_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 4) main_road counts
        $count_main_road = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select('e.main_road_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD'))
            ->groupBy('e.main_road_id')
            ->get()
            ->keyBy('main_road_id');

        // 5) t_type counts
        $count_beta_t_type = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
           ->when($start, function ($q) use ($start) {
                $q->whereDate('e.date_make', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('e.date_make', '<=', $end);
            })
            ->select('ed.t_model', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_T'))
            ->groupBy('ed.t_model')
            ->get()
            ->keyBy('t_model');

        // 6) detail rows (only needed when sw on)
        $enter_detail = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select(
                'e.enter_id', 'e.com_id', 'e.date_make', 'e.enter_number',
                'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
                't.t_type_name'
            )
            ->orderBy('e.date_make','asc')
            ->get();

        $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

        // Index details by com_id then enter_id for fast Blade rendering
        $detailsByComEnter = [];
        if ($sw === 'on') {
            foreach ($enter_detail as $d) {
                $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
            }
        }

        return view('notallow.report.ptsd', compact(
            'com',
            'main_road',
            'beta_t_type',
            'beta_enter',
            'sw',
            'detailsByComEnter',
            'count_t_model',
            'count_main_road',
            'count_beta_t_type',
            'count_beta_enter'
        ))
        ->with('start', $start_original)
        ->with('end', $end_original);
        
        return view('notallow.report.ptsd',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter'))->with('start',$start)->with('end',$end);
    }


    
    public function ptsd_testing($start,$end)
    {
         $start_original = $start;
    $end_original   = $end;

   

    // ✅ limiter (display only 80% of details, but keep at least 1 per enter_id)
    $limiter_percent = 20;
    $keepPercent     = (100 - $limiter_percent) / 100; // 0.80

    $com         = DB::table('beta_company_group')->get();
    $main_road   = DB::table('beta_main_road')->get();
    $beta_t_type = DB::table('beta_t_type')->get();

    // Base query for SUCCESS enters
    $baseEnter = DB::table('beta_enter as e')
        ->where('e.status', 'SUCCESS')
        ->when($start, function ($q) use ($start) { $q->whereDate('e.date_make', '>=', $start); })
        ->when($end,   function ($q) use ($end)   { $q->whereDate('e.date_make', '<=', $end); });

    // 1) beta_enter list (for headers/groups)
    $beta_enter = (clone $baseEnter)
        ->orderBy('e.date_make', 'asc')
        ->get();

    // 2) count enter per company (this is enter count, not detail count)
    $count_beta_enter = (clone $baseEnter)
        ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
        ->groupBy('e.com_id')
        ->get()
        ->keyBy('com_id');

    // 3) FULL detail rows first
    $enter_detail_full = DB::table('beta_enter_detail as ed')
        ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
        ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
        ->where('e.status', 'SUCCESS')
        ->when($start, function ($q) use ($start) { $q->whereDate('e.date_make', '>=', $start); })
        ->when($end,   function ($q) use ($end)   { $q->whereDate('e.date_make', '<=', $end); })
        ->select(
            'e.enter_id','e.com_id','e.main_road_id','e.date_make','e.enter_number',
            'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
            't.t_type_name'
        )
        ->orderBy('e.date_make','asc')
        ->orderBy('ed.enter_detail_id','asc')
        ->get();

    // 4) Reduce details per enter_id (keep at least 1)
    $grouped = [];
    foreach ($enter_detail_full as $d) {
        $grouped[$d->enter_id][] = $d;
    }

    $enter_detail = collect();

    foreach ($grouped as $enter_id => $rows) {
        $n = count($rows);

        // always keep at least 1
        if ($n <= 1) {
            $enter_detail->push($rows[0]);
            continue;
        }

        // ✅ reduce only "extras": keep = 1 + floor((n-1) * keepPercent)
        $keepExtras = (int) floor(($n - 1) * $keepPercent);
        $keepCount  = 1 + max(0, $keepExtras);

        if ($keepCount < 1) $keepCount = 1;
        if ($keepCount > $n) $keepCount = $n;

        // keep first row stable + randomly pick from the rest
        $kept = [$rows[0]];
        $rest = array_slice($rows, 1);
        shuffle($rest);

        $need = $keepCount - 1;
        for ($i = 0; $i < $need; $i++) {
            if (!isset($rest[$i])) break;
            $kept[] = $rest[$i];
        }

        // sort back for nice display
        usort($kept, function($a,$b){
            return $a->enter_detail_id <=> $b->enter_detail_id;
        });

        foreach ($kept as $k) $enter_detail->push($k);
    }

    // 5) sw based on REDUCED details
    $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

    // 6) Build detailsByComEnter from REDUCED details
    $detailsByComEnter = [];
    if ($sw === 'on') {
        foreach ($enter_detail as $d) {
            $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
        }
    }

    // 7) ✅ Recalculate counts from REDUCED details (this is the balance magic)
    $tmpCompany = [];
    $tmpRoad    = [];
    $tmpType    = [];

    foreach ($enter_detail as $d) {
        $tmpCompany[$d->com_id] = ($tmpCompany[$d->com_id] ?? 0) + 1;
        $tmpRoad[$d->main_road_id] = ($tmpRoad[$d->main_road_id] ?? 0) + 1;
        $tmpType[$d->t_model] = ($tmpType[$d->t_model] ?? 0) + 1;
    }

    // turn into objects so Blade can use ->TOTAL_COUNT_...
    $count_t_model = collect();
    foreach ($tmpCompany as $com_id => $cnt) {
        $count_t_model->push((object)[ 'com_id' => $com_id, 'TOTAL_COUNT' => $cnt ]);
    }
    $count_t_model = $count_t_model->keyBy('com_id');

    $count_main_road = collect();
    foreach ($tmpRoad as $mid => $cnt) {
        $count_main_road->push((object)[ 'main_road_id' => $mid, 'TOTAL_COUNT_MAIN_ROAD' => $cnt ]);
    }
    $count_main_road = $count_main_road->keyBy('main_road_id');

    $count_beta_t_type = collect();
    foreach ($tmpType as $tmodel => $cnt) {
        $count_beta_t_type->push((object)[ 't_model' => $tmodel, 'TOTAL_COUNT_T' => $cnt ]);
    }
    $count_beta_t_type = $count_beta_t_type->keyBy('t_model');

    return view('notallow.report.ptsd', compact(
        'com',
        'main_road',
        'beta_t_type',
        'beta_enter',
        'sw',
        'detailsByComEnter',
        'count_t_model',
        'count_main_road',
        'count_beta_t_type',
        'count_beta_enter',
        'limiter_percent'
    ))
    ->with('start', $start_original)
    ->with('end', $end_original);
    }


    
    public function ptsdcs($start,$end,$limit)
    {
      

        $com = DB::select("SELECT * FROM beta_company_group");
        $count_t_model = DB::select("SELECT e.com_id,COUNT(ed.enter_id) AS TOTAL_COUNT FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY e.com_id");
  
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' ORDER BY date_make ASC");
        $count_beta_enter = DB::select("SELECT com_id,COUNT(enter_id) AS TOTAL_COUNT_COM FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' GROUP BY com_id");
    
        $enter_detail = DB::select("SELECT e.*,ed.*,t.t_type_name FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id JOIN beta_t_type t ON ed.t_model=t.t_type_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."'");
        
        $main_road = DB::select("SELECT * FROM beta_main_road");
        $count_main_road = DB::SELECT("SELECT e.main_road_id,COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY main_road_id");
        
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $count_beta_t_type = DB::SELECT("SELECT ed.t_model,COUNT(ed.enter_id) AS TOTAL_COUNT_T FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY t_model");
        

        
        return view('notallow.report.ptsdcs',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter'))->with('start',$start)->with('end',$end)->with('limit',$limit);
    }


    public function search_enter_number($enter_number)
    { 

        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE enter_number = '".$enter_number."'");

        if($beta_enter)
        {
            return redirect()->to('/see/enter/list/view/' . $beta_enter[0]->enter_id);  
        }
        else
        {
            dd('No data');
        }
    }


    public function fetch_search(Request $request)
    {
        $start = $request->start;
        $end   = $request->end;
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE enter_number  >= '".$start."' AND enter_number <= '".$end."'");
          
        return response()->json(['data' => $beta_enter]);
    }
}
