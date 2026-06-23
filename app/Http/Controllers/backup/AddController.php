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
Use App\Models\beta_t_type; 
Use App\Models\beta_company_group; 
Use App\Models\User; 


class AddController extends Controller
{
    public function index()
    { 
        if (auth()->user()->is_admin == 2) {
            return redirect()->route('ComAdd'); 
        }
        else
        {
            return view('notallow.add.index'); 
        }
    }



   public function road()
   {
       $beta_road_select = DB::select("SELECT * FROM beta_road_select");
       return view('notallow.add.road.index',compact('beta_road_select'));
   }
   public function roadStore(Request $request)
   {
      
    $beta_road_select = new beta_road_select;  
    $beta_road_select->road_name = $request->name;  
    $beta_road_select->save();
    return response()->json([
        'status'=>200,
        'message'=>'',
    ]); 
   }

    public function roadUpdate(Request $request)
    { 
        if($request->name_old)
        {
            if($request->name_old!=$request->name_edit)
            { 
                beta_road_select::where('road_id',$request->id)->update([ 
                'road_name' => $request->name_edit, 
            ]);

           

            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]);   
            }
        }
        
    }

    public function roadDel(Request $request)
    {
        $delete = beta_road_select::where('road_id',$request->id)->delete();

    }




   public function wheels()
   {
       $beta_t_type = DB::select("SELECT * FROM beta_t_type");
       return view('notallow.add.wheels.index',compact('beta_t_type'));
   }
   
   public function wheelsStore(Request $request)
   {
      
    $beta_t_type = new beta_t_type;  
    $beta_t_type->t_type_name = $request->name;  
    $beta_t_type->save();
    return response()->json([
        'status'=>200,
        'message'=>'',
    ]); 
   }

    public function wheelsUpdate(Request $request)
    { 
        if($request->name_old)
        {
            if($request->name_old!=$request->name_edit)
            { 
                beta_t_type::where('t_type_id',$request->id)->update([ 
                't_type_name' => $request->name_edit, 
            ]);

           

            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]);   
            }
        }
        
    }

    public function wheelsDel(Request $request)
    {
        $delete = beta_t_type::where('t_type_id',$request->id)->delete();
    }


    
   public function mainroad()
   {
       $beta_main_road = DB::select("SELECT * FROM beta_main_road");
       return view('notallow.add.main_road.index',compact('beta_main_road'));
   }
   
   public function mainroadStore(Request $request)
   {
      
    $beta_main_road = new beta_main_road;  
    $beta_main_road->main_road_name = $request->name;  
    $beta_main_road->save();
    return response()->json([
        'status'=>200,
        'message'=>'',
    ]); 
   }

    public function mainroadUpdate(Request $request)
    { 
        if($request->name_old)
        {
            if($request->name_old!=$request->name_edit)
            { 
                beta_main_road::where('main_road_id',$request->id)->update([ 
                'main_road_name' => $request->name_edit, 
            ]);

            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]);   
            }
        }
        
    }

    public function mainroadDel(Request $request)
    {
        $delete = beta_main_road::where('main_road_id',$request->id)->delete();
    }



   public function com()
   {
    //    $beta_company_group = DB::select("SELECT * FROM beta_company_group");
       $beta_company_group = beta_company_group::paginate(10, ['*'], 'page_name');
       return view('notallow.add.com.index',compact('beta_company_group'));
   }



   public function com_search(Request $request)
   {
        $search = $request->text_search; 
    //    $beta_company_group = DB::select("SELECT * FROM beta_company_group");
       $beta_company_group = beta_company_group::WHERE('com_name','LIKE','%'.$search.'%')->orWHERE('com_owner','LIKE','%'.$search.'%')->orWHERE('com_phone','LIKE','%'.$search.'%')->paginate(10, ['*'], 'page_name');
       return view('notallow.add.com.index',compact('beta_company_group'));
   }
   
   public function comStore(Request $request)
   {
      
    $beta_company_group = new beta_company_group;  
    $beta_company_group->com_name = $request->name;  
    $beta_company_group->com_owner = $request->owner_name;  
    $beta_company_group->com_phone = $request->owner_phone;  
    $beta_company_group->save();
    return response()->json([
        'status'=>200,
        'message'=>'',
    ]); 
   }

    public function comUpdate(Request $request)
    { 
         
                beta_company_group::where('com_id',$request->id)->update([ 
                'com_name' => $request->name_edit, 
                'com_owner' => $request->owner_name_edit, 
                'com_phone' => $request->owner_phone_edit, 
            ]);

            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]);    
        
    }
 
    public function comDel(Request $request)
    {
        $delete = beta_company_group::where('com_id',$request->id)->delete();
    }



    

   public function comUser($id)
   {
       $beta_company_group = DB::select("SELECT * FROM beta_company_group WHERE com_id = '".$id."'");
       $beta_users = DB::select("SELECT * FROM users WHERE com_id = '".$id."'");
       return view('notallow.add.com.user.index',compact('beta_company_group','beta_users'))->with('com_id',$id);
   }
   
   public function comUserStore(Request $request,$com_id)
   { 
        $mail_checker = DB::select("SELECT name FROM users WHERE email = '".$request->owner_name."' ");
        if($mail_checker)
        {
            return response()->json([
                'status'=>413,
                'message'=>'Already_exist',
            ]); 
        }
        else
        {
            $user = new User;  
            $user->name = $request->name;  
            $user->email = $request->owner_name;  
            $user->com_id = $com_id;   
            $user->is_admin = '1';  
            $user->password = '$2y$10$HGd0qS97OpqWquXnS03l1ua9lESZNBB9zAuOsTtyzxef/O1f/gUUe';  
            $user->save();
            
    
            return response()->json([
                'status'=>200,
                'message'=>$com_id,
            ]); 
        }
        
   }

    public function comUserUpdate(Request $request,$com_id)
    { 
         
            User::where('id',$request->id)->update([ 
                'name' => $request->name_edit,  
            ]);

            return response()->json([
                'status'=>200,
                'message'=>$request->id,
            ]);    
        
    }

    public function comUserDel(Request $request,$com_id)
    {
        $delete = User::where('id',$request->id)->delete();
    }


    public function comQuotar(Request $request)
    {
        
        $id = $request->id;
        $data = beta_company_group::where('com_id',$id)->first();

        $status ='YES';

        if($data->com_status=='YES')
        {
            $status ='NO';

        }
        beta_company_group::where('com_id',$id)->update([ 
            'com_status' => $status,
        ]);

        return response()->json(['message'=>''.$id]);
    }

    
}
