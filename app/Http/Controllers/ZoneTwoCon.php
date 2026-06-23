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

Use App\Models\beta_company_group; 
Use App\Models\typex; 
Use App\Models\QuotarList; 
Use App\Models\products; 
Use App\Models\unit; 
Use App\Models\beta_a_enter_quotar; 
Use App\Models\beta_a_enter_quotar_detail; 
Use App\Models\beta_a_enter_quotar_file; 
Use Session;

class ZoneTwoCon extends Controller
{
    public function index()
    {         
         // $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC LIMIT 0,40 ");
        $is_admin = Auth::user()->is_admin;
        if($is_admin)
        { 
            $typex = typex::get();

            if($is_admin=='7')
            {
                $waiting = beta_a_enter_quotar::where('status','WAITING')->orderby('id','DESC')->paginate(10, ['*'], 'page_name');

            }
            elseif($is_admin=='8')
            {
                $waiting = beta_a_enter_quotar::where('status','POINTING')->orderby('id','DESC')->paginate(10, ['*'], 'page_name');
            }
            else
            {

            } 
            return view('notallow.zone.two.index',compact('waiting','typex'));  
        }
        else
        { 
        } 
    }

    public function index_quotar()
    {
        
    }
    
    // public function success()
    // {          
    //     $is_admin = Auth::user()->is_admin;
    //     if($is_admin)
    //     { 
    //         $typex = typex::get(); 
    //         $waiting = beta_a_enter_quotar::where('status','SUCCESS')->orderby('id','DESC')->paginate(10, ['*'], 'page_name'); 
    //         return view('notallow.zone.two.index',compact('waiting','typex'));  
    //     }
    //     else
    //     { 
    //     } 
    // }


    public function setType(Request $request)
    {

        $beta_a_enter_quotar_detail = beta_a_enter_quotar_detail::WHERE('id',$request->id)->first();
        if($beta_a_enter_quotar_detail)
        {
            $beta_a_enter_quotar_detail->pro_id = $request->pro_type_id;
            $beta_a_enter_quotar_detail->save();
        }
        return response()->json(['Message'=>'Success'],200);
    }

 
    public function quotarPoiting(Request $request)
    {
        $q_id = $request->id;
        $picking = beta_a_enter_quotar_detail::WHERE('qo_id',$q_id)->get();

        foreach($picking AS $row)
        {
            if($row->pro_id)
            {

            }
            else
            {
                return response()->json(['Message'=>'Failed'],404); 
            }
        }

        $date = Carbon::now('Asia/Bangkok');
        $newDate = $date->addDays(90);

        $pointing = beta_a_enter_quotar::where('id',$q_id)->first();
        $pointing->status = 'SUCCESS';
        $pointing->expired_at = $newDate;
        $pointing->save();
        
        return response()->json(['Message'=>'Success'],200);
    }  
 
    public function quotarCancel(Request $request)
    {
        $q_id = $request->id;
        $cancel_log = $request->cancel_log;
        $cancel = beta_a_enter_quotar::WHERE('id',$q_id)->first();
        $cancel->status = 'CANCEL';
        $cancel->cancel_log = $cancel_log;
        $cancel->save();
        
        return response()->json(['Message'=>'Success'],200);
    }

    public function waiting()
    { 
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'QWAIT'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id ASC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select"); 
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'QWAIT' AND e.date_make = '".date('Y-m-d')."'  AND e.date_make = '".date('Y-m-d')."'");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'QWAIT' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.date_make,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'QWAIT'");
        
     
        return view('notallow.zone.two.waiting',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }

    public function success()
    {
        
    
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'QWAIT'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id ASC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select"); 
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'QWAIT' AND e.date_make = '".date('Y-m-d')."'  AND e.date_make = '".date('Y-m-d')."'");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'QWAIT' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.date_make,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'QWAIT'");
        
     
        return view('notallow.zone.two.waiting',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }
    
    
 
}
