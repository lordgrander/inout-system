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
           
            return view('notallow.see.print',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
        }
        else
        {
           
            return view('notallow.see.print_new',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('id',$id); 
        }
    }
    
    public function daily($start,$end)
    {
       
        $com = DB::select("SELECT * FROM beta_company_group");
     
        $count_t_model = DB::select("SELECT e.com_id,COUNT(ed.enter_id) AS TOTAL_COUNT FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY e.com_id");
    
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE date_make >= '".$start."' AND date_make <= '".$end."' AND status='SUCCESS' ORDER BY date_make ASC");
        $count_beta_enter = DB::select("SELECT com_id,COUNT(enter_id) AS TOTAL_COUNT_COM FROM beta_enter WHERE date_make >= '".$start."' AND date_make <= '".$end."' AND status='SUCCESS' GROUP BY com_id");
    
        $enter_detail = DB::select("SELECT e.*,ed.*,t.t_type_name FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id JOIN beta_t_type t ON ed.t_model=t.t_type_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."'");
        $sw = 'on';
 
        if (count($enter_detail) > 1000) {
           $sw = 'off';
        }
        $main_road = DB::select("SELECT * FROM beta_main_road");
        $count_main_road = DB::SELECT("SELECT e.main_road_id,COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY main_road_id");
        
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $count_beta_t_type = DB::SELECT("SELECT ed.t_model,COUNT(ed.enter_id) AS TOTAL_COUNT_T FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY t_model");
        

        
        return view('notallow.report.daily',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter'))->with('start',$start)->with('end',$end)->with('sw',$sw);
    }


    
    public function ptsd($start,$end)
    {
      

        $com = DB::select("SELECT * FROM beta_company_group");
        $count_t_model = DB::select("SELECT e.com_id,COUNT(ed.enter_id) AS TOTAL_COUNT FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY e.com_id");
  
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE date_make >= '".$start."' AND date_make <= '".$end."' AND status='SUCCESS' ORDER BY date_make ASC");
        $count_beta_enter = DB::select("SELECT com_id,COUNT(enter_id) AS TOTAL_COUNT_COM FROM beta_enter WHERE date_make >= '".$start."' AND date_make <= '".$end."' AND status='SUCCESS' GROUP BY com_id");
    
        $enter_detail = DB::select("SELECT e.*,ed.*,t.t_type_name FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id JOIN beta_t_type t ON ed.t_model=t.t_type_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."'");
        
        $main_road = DB::select("SELECT * FROM beta_main_road");
        $count_main_road = DB::SELECT("SELECT e.main_road_id,COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY main_road_id");
        
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $count_beta_t_type = DB::SELECT("SELECT ed.t_model,COUNT(ed.enter_id) AS TOTAL_COUNT_T FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND e.date_make >= '".$start."' AND e.date_make <= '".$end."' GROUP BY t_model");
        

        
        return view('notallow.report.ptsd',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter'))->with('start',$start)->with('end',$end);
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
