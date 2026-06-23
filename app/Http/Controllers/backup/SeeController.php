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
Use App\Models\beta_enter_detail;
Use App\Models\beta_enter_file;
Use App\Models\beta_feed_back;
Use App\Models\beta_main_road;
Use App\Models\beta_sign;
Use App\Models\beta_enter_road_detail;
Use App\Models\beta_road_select;
session();

class SeeController extends Controller
{
    
    public function index()
    {      
        $count = DB::select("SELECT COUNT(enter_id) AS count_amount FROM beta_enter WHERE status='WAITING' ");
        $count_amount_pointing = DB::select("SELECT COUNT(enter_id) AS count_amount FROM beta_enter WHERE status='POINTING' ");
        $count_amount_signing = DB::select("SELECT COUNT(enter_id) AS count_amount FROM beta_enter WHERE status='SIGNING' ");
        $count_amount_signined = DB::select("SELECT COUNT(enter_id) AS count_amount FROM beta_enter WHERE status='SIGNINED' ");
        $count_amount_cancel = DB::select("SELECT COUNT(enter_id) AS count_amount FROM beta_enter WHERE status='CANCEL' ");
        
        return view('notallow.see.index')
        ->with('count_amount',$count[0]->count_amount)
        ->with('count_amount_pointing',$count_amount_pointing[0]->count_amount)
        ->with('count_amount_signing',$count_amount_signing[0]->count_amount)
        ->with('count_amount_signined',$count_amount_signined[0]->count_amount)
        ->with('count_amount_cancel',$count_amount_cancel[0]->count_amount);
    }
    
    public function log($id)
    {      
        $log = DB::select("SELECT l.*,u.name FROM beta_feed_back l LEFT JOIN users u ON l.user_id=u.id WHERE l.ref_id = '".$id."' AND l.pointer = 'CheckingEnter' OR  l.ref_id = '".$id."' AND l.pointer = 'CheckingEnter & Cancel'");
        return view('notallow.see.log',compact('log'));
    }


    public function waiting()
    {        
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'WAITING'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id ASC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select"); 
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'WAITING' AND e.date_make = '".date('Y-m-d')."'  AND e.date_make = '".date('Y-m-d')."'");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'WAITING' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.date_make,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'WAITING'");
        return view('notallow.see.list',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }


    public function Linkpointing()
    {        
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'POINTING' AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select"); 
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'POINTING'  AND e.date_make = '".date('Y-m-d')."'"); 
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'POINTING' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'POINTING'"); 
        return view('notallow.see.list',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }


    public function Linksigning()
    {        
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SIGNING'  AND e.date_make = '".date('Y-m-d')."'  ORDER BY e.enter_id DESC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select");
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'SIGNING'  AND e.date_make = '".date('Y-m-d')."'");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'SIGNING' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'SIGNING'");
        return view('notallow.see.list',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }


    public function Linksigned()
    {        
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SIGNINED'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select");
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'SIGNINED'  AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'SIGNINED' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'SIGNINED'");
        return view('notallow.see.list',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }

    public function Linkready()
    {        
        $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'READY'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC");
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select");
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'READY'  AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_road_detail = DB::select("SELECT e.date_make,e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'READY' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'SIGNINED'");
        return view('notallow.see.list',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }


    public function Linksussess()
    {        
        // $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC LIMIT 0,40 ");
        
        
        $beta_enter = DB::table('beta_enter as e')
        ->select('c.com_name', 'c.com_phone', 'u.name', 'u.email', 'e.*', 'm.main_road_name')
        ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
        ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
        ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id')
        ->where('e.status', 'SUCCESS')
        ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
        ->whereDate('e.date_make', '<=', now()->toDateString())

        ->orderBy('e.enter_number', 'DESC')
        ->paginate(10, ['*'], 'page_name');

    // This will fetch the data you need into the $betaEnterData variable.

        
        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select");
        // $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."'");
        $beta_enter_detail = DB::table('beta_enter as e')
        ->select('ed.*', 't.t_type_name')
        ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
        ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
        ->where('e.status', 'SUCCESS')
        ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
        ->whereDate('e.date_make', '<=', now()->toDateString())
        ->get();

        // $beta_enter_road_detail = DB::select("SELECT e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'SUCCESS' AND e.date_make = '".date('Y-m-d')."' ");
        $beta_enter_road_detail = DB::table('beta_enter_road_detail as r')
        ->select('e.status', 'r.*', 'rn.road_name')
        ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
        ->leftJoin('beta_enter as e', 'r.enter_id', '=', 'e.enter_id')
        ->where('e.status', 'SUCCESS')
        ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
        ->whereDate('e.date_make', '<=', now()->toDateString())
        ->get();

        // $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'SUCCESS'");
        $beta_enter_file = DB::table('beta_enter_file as f')
        ->select('f.*', 'e.status')
        ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id')
        ->where('e.status', 'SUCCESS')
        ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
        ->whereDate('e.date_make', '<=', now()->toDateString())
        ->get();
        return view('notallow.see.success',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }



    public function Linkcancel()
    {       
         
         // $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC LIMIT 0,40 ");
        
        
         $beta_enter = DB::table('beta_enter as e')
         ->select('c.com_name', 'c.com_phone', 'u.name', 'u.email', 'e.*', 'm.main_road_name')
         ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
         ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
         ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id')
         ->where('e.status', 'CANCEL')
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
 
         ->orderBy('e.enter_number', 'DESC')
         ->paginate(10, ['*'], 'page_name');
 
     // This will fetch the data you need into the $betaEnterData variable.
 
         
         $beta_main_road = DB::select("SELECT * FROM beta_main_road");
         $beta_road_select = DB::select("SELECT * FROM beta_road_select");
         // $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."'");
         $beta_enter_detail = DB::table('beta_enter as e')
         ->select('ed.*', 't.t_type_name')
         ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
         ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
         ->where('e.status', 'CANCEL')
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
         ->get();
 
         // $beta_enter_road_detail = DB::select("SELECT e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'SUCCESS' AND e.date_make = '".date('Y-m-d')."' ");
         $beta_enter_road_detail = DB::table('beta_enter_road_detail as r')
         ->select('e.status', 'r.*', 'rn.road_name')
         ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
         ->leftJoin('beta_enter as e', 'r.enter_id', '=', 'e.enter_id')
         ->where('e.status', 'CANCEL')
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
         ->get();
 
         // $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'SUCCESS'");
         $beta_enter_file = DB::table('beta_enter_file as f')
         ->select('f.*', 'e.status')
         ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id')
         ->where('e.status', 'CANCEL')
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
         ->get();
         return view('notallow.see.success',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }



    public function Linkall()
    {       
         
         
         // $beta_enter = DB::select("SELECT c.com_name,c.com_phone,u.name,u.email,e.*,m.main_road_name FROM beta_enter e LEFT JOIN beta_company_group c ON e.com_id = c.com_id LEFT JOIN users u ON e.user_id = u.id LEFT JOIN beta_main_road m ON e.main_road_id=m.main_road_id WHERE e.status = 'SUCCESS'  AND e.date_make = '".date('Y-m-d')."' ORDER BY e.enter_id DESC LIMIT 0,40 ");
        
        
         $beta_enter = DB::table('beta_enter as e')
         ->select('c.com_name', 'c.com_phone', 'u.name', 'u.email', 'e.*', 'm.main_road_name')
         ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
         ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
         ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id') 
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString()) 
         ->orderBy('e.enter_number', 'DESC')
         ->paginate(10, ['*'], 'page_name');
 
     // This will fetch the data you need into the $betaEnterData variable.
 
         
         $beta_main_road = DB::select("SELECT * FROM beta_main_road");
         $beta_road_select = DB::select("SELECT * FROM beta_road_select");
         // $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter e LEFT JOIN beta_enter_detail ed ON e.enter_id=ed.enter_id LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE e.status= 'CANCEL'  AND e.date_make = '".date('Y-m-d')."'");
         $beta_enter_detail = DB::table('beta_enter as e')
         ->select('ed.*', 't.t_type_name')
         ->leftJoin('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
         ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id') 
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
         ->get();
 
         // $beta_enter_road_detail = DB::select("SELECT e.status,r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id LEFT JOIN beta_enter e ON r.enter_id=e.enter_id WHERE e.status = 'CANCEL' AND e.date_make = '".date('Y-m-d')."' ");
         $beta_enter_road_detail = DB::table('beta_enter_road_detail as r')
         ->select('e.status', 'r.*', 'rn.road_name')
         ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
         ->leftJoin('beta_enter as e', 'r.enter_id', '=', 'e.enter_id') 
         ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
         ->whereDate('e.date_make', '<=', now()->toDateString())
         ->get();
 
         
         $beta_enter_file = DB::table('beta_enter_file as f')
        ->select('f.*', 'e.status')
        ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id') 
        ->whereDate('e.date_make', '>=', now()->subDays(5)->toDateString())
        ->whereDate('e.date_make', '<=', now()->toDateString())
        ->get();
         return view('notallow.see.success',compact('beta_enter','beta_main_road','beta_road_select','beta_enter_detail','beta_enter_road_detail','beta_enter_file')); 
    }

    



    public function view($id)
    {      
        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.enter_id = '".$id."'"); 

        $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = '".$id."'");
      
        
        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
        $com_name = DB::select("SELECT com_name FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name[0]->com_name; 

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$id."'");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$id."'");
        return view('notallow.see.view',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('id',$id); 
    }

    public function edit($id)
    {
        $beta_enter_road_detail = DB::select("SELECT * FROM beta_enter_road_detail WHERE enter_id = '".$id."'");
        $beta_road_select = DB::select("SELECT * FROM beta_road_select");
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$id."'");

        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
        $com_name = DB::select("SELECT com_name FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");

        $beta_main_road = DB::select("SELECT * FROM beta_main_road");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name[0]->com_name; 
        
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$id."'");
    
        $progress_bar_name = '';
        $progress_bar_percent = '0%';
        $progress_bar_color = '#0b7dda';
        if($beta_enter[0]->status=='WAITING')
        {
            $progress_bar_name = 'ກຳລັງລໍຖ້າ';
            $progress_bar_percent = '20%';
        }
        elseif($beta_enter[0]->status=='POINTING')
        { 
            $progress_bar_name = 'ກຳລັງລະບຸເສັ້ນທາງ';
            $progress_bar_percent = '50%';
        } 
        elseif($beta_enter[0]->status=='SIGNING')
        { 
            $progress_bar_name = 'ກຳລັງລໍຖ້າເຊັນ';
            $progress_bar_percent = '70%';
        }
        elseif($beta_enter[0]->status=='SIGNINED')
        { 
            $progress_bar_name = 'ເຊັນສຳເລັດ';
            $progress_bar_percent = '80%';
        }
        elseif($beta_enter[0]->status=='SUCCESS')
        { 
            $progress_bar_name = 'ສຳເລັດ';
            $progress_bar_percent = '100%';
            $progress_bar_color = '#00d011'; 
        }
        elseif($beta_enter[0]->status=='CANCEL')
        { 
            $progress_bar_name = 'ເອກະສານຖືກຍົກເລີກ';
            $progress_bar_percent = '100%';
            $progress_bar_color = 'red'; 
        }
        else
        {

        }
       
        
        return view('notallow.see.first',
                    compact(
                                'beta_enter',
                                'beta_enter_detail',
                                'user_data',
                                'beta_main_road',
                                'beta_enter_road_detail',
                                'beta_road_select'
                            ))
        ->with('com_name',$com_name)
        ->with('progress_bar_name',$progress_bar_name) 
        ->with('progress_bar_percent',$progress_bar_percent) 
        ->with('progress_bar_color',$progress_bar_color) 
        ->with('id',$id); 

    }   

    public function first(Request $request)
    {

        $check = DB::select('SELECT * FROM beta_enter WHERE enter_id = "'.$request->id.'" ');

        if($check[0]->status=='WAITING')
        {
            
            if($check[0]->date_sign)
            {
                beta_enter::where('enter_id',$request->id)->update([ 
                    'status' => 'POINTING',  
                ]);
            }
            else
            {
                $year = date('Y');
                $latestRecord = DB::select('SELECT * FROM beta_enter WHERE YEAR(date_make) = ' . $year . ' ORDER BY enter_number DESC LIMIT 1');
            
                if ($latestRecord) {
                    $latestNumber = (int) $latestRecord[0]->enter_number;
                    $latestNumber++;
                    $latestNumber = str_pad($latestNumber, 5, "0", STR_PAD_LEFT);
                } else {
                    $latestNumber = '00001';
                }
                
                beta_enter::where('enter_id',$request->id)->update([ 
                    'status' => 'POINTING', 
                    'enter_number' => $latestNumber, 
                ]);
            }
                

            $currentTime = Carbon::now();

            $beta_feed_back = new beta_feed_back; 
            $beta_feed_back->user_id = Auth::user()->id;
            $beta_feed_back->date = date('Y-m-d'); 
            $beta_feed_back->time = $currentTime->format('h:i:s'); 
            $beta_feed_back->feed_back_msg = 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ';
            $beta_feed_back->ref_id = $request->id;
            $beta_feed_back->pointer = "CheckingEnter";
            $beta_feed_back->save();

            return response()->json([
                'status'=>200,
                'message'=>$request->id,

            ]); 
        }
        else
        {
            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]); 
        }
        
    }



    public function back(Request $request)
    {

        $check_data = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$request->id."'");
        if($check_data[0]->date_sign)
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'WAITING',  
            ]);
        }
        else
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'WAITING', 
                'enter_number' => '0', 
            ]);
        }


        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = 'ດືງຄືນເອກະສານກັບຈາກການລະບຸເສັ້ນທາງ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    public function backFromPointing(Request $request)
    {
        $check_data = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$request->id."'");
        if($check_data[0]->date_sign)
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'WAITING',  
            ]);
        }
        else
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'WAITING', 
                'enter_number' =>'0',
            ]);
        }

        $delete = beta_enter_road_detail::where('enter_id',$request->id)->delete(); 


        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ເອກະສານຕິກັບ :  ສາເຫດທີ່ຕີກັບ "'.$request->log.'"';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    public function backFromSigning(Request $request)
    {
        
 
        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'POINTING',  
        ]);

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = 'ດືງຄືນເອກະສານກັບຈາກການຢືນເຊັນ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    
    public function Pointing(Request $request)
    {  
        $checkbox_data = $request->formdata;
        
        $delete = beta_enter_road_detail::where('enter_id',$request->id)->delete(); 
        foreach($checkbox_data as $data)
        {
            $check_data = DB::select("SELECT * FROM beta_enter_road_detail WHERE enter_id = '".$request->id."' AND road_id = '".$data."' ");
            if($check_data)
            {

            }
            else
            {
                $beta_enter_road_detail = new beta_enter_road_detail;
                $beta_enter_road_detail->road_id = $data;
                $beta_enter_road_detail->enter_id = $request->id;
                $beta_enter_road_detail->save();
            }
           
        }

        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'SIGNING', 
            'feed_back_msg' => $request->details, 
            'main_road_id' => $request->main_road, 
        ]);

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ລະບຸເສັນທາງສຳເລັດ ກຳລັງລໍຖ້າເຊັນ ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }


    public function backFromBoss(Request $request)
    {

        
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'POINTING',
            ]);
        

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ເອກະສານຕິກັບ ຈາກການເຊັນ : ສາເຫດທີ່ຕີກັບ "'.$request->log.'" ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }


    public function backFromBossSign(Request $request)
    {
        $check_data = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$request->id."'");
        if($check_data[0]->date_sign)
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNING', 
            ]);
        }
        else
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNING',
                'sign_url' => '',  
                'date_sign' => null,
                'date_confirm' => null,
            ]);
        }

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ຍົກເລີກເຊັນ  ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    public function backToSign(Request $request)
    {
        
        $check_data = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$request->id."'");
        if($check_data[0]->date_sign)
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNING', 
            ]);

        }
        else
        {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNING',
                'sign_url' => '',  
                'date_sign' => null,
                'date_confirm' => null,
            ]);

        }

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ຕີກັບໄປເຊັນ  ';
        $beta_feed_back->ref_id = $request->id;
        $beta_feed_back->pointer = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    

    public function cancel(Request $request)
    {

        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'CANCEL', 
            'sign_url' => '', 
            'cancel_log' => $request->log, 
        ]);

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ຍົກເລີກ :  ສາເຫດທີ່ຍົກເລີກ "'.$request->log.'"';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter & Cancel";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }


    public function reroll(Request $request)
    {
        $delete = beta_enter_road_detail::where('enter_id',$request->id)->delete(); 

        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'WAITING', 
            'main_road_id' => '0', 
            'sign_url' => '', 
        ]);

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ດືງເອກະສານກັບຈາກຍົກເລີກ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }


    public function sign(Request $request)
    { 
        $sign_url = DB::select("SELECT * FROM beta_sign WHERE user_id ='".Auth::user()->id."' ");
        
        if (session('command') == 'off') {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNINED',  
                'sign_url' => null, 
                'date_sign' =>  date('Y-m-d'),
                'date_confirm' => date('Y-m-d'),
            ]);

        } else {
            beta_enter::where('enter_id',$request->id)->update([ 
                'status' => 'SIGNINED', 
                'sign_url' => $sign_url[0]->sign_url,
                'date_confirm' => date('Y-m-d'),
                'date_sign' => date('Y-m-d'),
            ]);
        }
        

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ເຊັນແລ້ວ ເອກະສານຢູ່ນຳລະບຸສານທາງ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    public function ready(Request $request)
    {  
        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'READY',  
        ]);

        $currentTime = Carbon::now(); 
        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id; 
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ເຊັນແລ້ວ ລະບຸສາຍທາງສົ່ງໃຫ້ ຂາເຂົ້າຂາອອກ'; 
        $beta_feed_back->ref_id        = $request->id; 
        $beta_feed_back->pointer       = "CheckingEnter"; 
        $beta_feed_back->save(); 

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
    }
       

    public function signCompany(Request $request)
    {
 

        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'SUCCESS',  
        ]);

        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }

    public function readyback(Request $request)
    { 
        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'SIGNINED',  
        ]);

        $currentTime = Carbon::now(); 
        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ຕີເອກະສານກັບໄປຫາສາຍທາງ ແຕ່ເຊັນແລ້ວ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }


    public function successback(Request $request)
    { 
        beta_enter::where('enter_id',$request->id)->update([ 
            'status' => 'READY',
        ]);

        $currentTime = Carbon::now(); 
        $beta_feed_back = new beta_feed_back; 
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d'); 
        $beta_feed_back->time = $currentTime->format('h:i:s'); 
        $beta_feed_back->feed_back_msg = ' ດືງກັບເອກະສານຈາກບໍລິສັດ ແຕ່ເຊັນແລ້ວ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "CheckingEnter";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]); 
        
    }
    

    
}
