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
Use App\Models\beta_company_profile;
Use App\Models\beta_enter_detail;
Use App\Models\beta_enter_file;
Use App\Models\beta_feed_back;
Use App\Models\beta_t_type;
Use App\Models\beta_enter_road_detail;
Use App\Models\beta_watching_list; 
Use App\Models\beta_extend_detail; 
Use App\Models\User; 

use Session;

class ExpiredController extends Controller
{
    public function list(Request $request)
    {
        $query = User::query();

        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('userHaveCompany', function ($q2) use ($search) {
                    $q2->where('com_name', 'like', "%{$search}%");
                });
            });
        }

        // ⏰ Status filter
        $filter = $request->input('filter', 'expired'); // default: expired
        $today = \Carbon\Carbon::now('Asia/Bangkok')->format('Y-m-d');

        if ($filter === 'expired') {
            $query->whereDate('end_at', '<', $today);
        } elseif ($filter === 'active') {
            $query->whereDate('end_at', '>=', $today);
        }
        // if "all", skip filtering

        // Eager load company relationship to prevent N+1
        $users = $query->with('userHaveCompany')
                    ->orderBy('end_at', 'asc')
                    ->paginate(50)
                    ->appends($request->query()); // keep filters in pagination links

        return view('notallow.expired.list', compact('users', 'filter'));
    }
    
    public function extendEndAt(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'end_at'  => 'required|date', 
        ]);

        $user = User::findOrFail($request->user_id);

        // Save as timestamp or date depending on your column type
        $user->end_at = Carbon::parse($request->end_at); // or ->endOfDay()
        $user->save();

        $com = beta_company_group::where('com_id',$user->com_id)->first();

        $objectData = [
            'user' => [
                'id'     => $user->id,
                'name'   => $user->name, 
                'end_at' => optional($user->end_at)->format('Y-m-d'),
            ],
            'company' => [
                'com_id'        => $com->com_id,
                'com_name'  => $com->com_name,
                'com_owner' => $com->com_owner,
                'com_phone' => $com->com_phone,
            ],
        ];

        $beta_extend_detail = new beta_extend_detail; 
        $beta_extend_detail->user_id = $request->user_id;
        $beta_extend_detail->com_id = $user->com_id;
        $beta_extend_detail->approved_by_user_id = auth()->id();
        $beta_extend_detail->object_data = json_encode($objectData, JSON_UNESCAPED_UNICODE);
        $beta_extend_detail->log = null;
        $beta_extend_detail->end_at =  Carbon::parse($request->end_at);
        $beta_extend_detail->created_at =  Carbon::now('Asia/Bangkok');
        $beta_extend_detail->updated_at =  Carbon::now('Asia/Bangkok');
        $beta_extend_detail->save();

        
        if($request->data_com_pro_id ?? '' !=='')
        { 
            $beta_company_profile = beta_company_profile::where('id',$request->data_com_pro_id)->first(); 
            $beta_company_profile->status = 'accepted'; 
            $beta_company_profile->save(); 
        } 

        return response()->json([
            'status'             => 'success',
            'message'            => 'ຕໍ່ອາຍຸຜູ້ໃຊ້ສໍາເລັດແລ້ວ',
            'end_at'             => $user->end_at,
            'end_at_formatted'   => $user->end_at
                                        ? $user->end_at->format('d-m-Y')
                                        : null,
        ]);
    }

    public function reject_extend(Request $request)
    {
          $request->validate([
            'user_id' => 'required|exists:users,id', 

        ]);
      
        $user = User::findOrFail($request->user_id);

        $beta_company_profile = beta_company_profile::where('id',$request->data_com_pro_id)->first(); 
        $beta_company_profile->status = 'rejected'; 
        $beta_company_profile->log = $request->tearea; 
        $beta_company_profile->save();
        
        return response()->json([
            'status'             => 'success',
            'message'            => 'ປະຕິເສດສຳເລັດ',
            'end_at'             => null,
            'end_at_formatted'   =>null,
        ]);
    }

   public function verified_check($slug)
   { 
        $beta_enter = DB::select("SELECT e.*,m.main_road_name FROM beta_enter e  LEFT JOIN beta_main_road m ON e.main_road_id = m.main_road_id WHERE e.slug = '".$slug."'"); 
      
        $beta_enter_road_detail = DB::select("SELECT r.*,rn.road_name FROM beta_enter_road_detail r LEFT JOIN beta_road_select rn ON r.road_id=rn.road_id WHERE r.enter_id = '".$beta_enter[0]->enter_id."'");

        $user_data = DB::select("SELECT * FROM users WHERE id = '".$beta_enter[0]->user_id."'");
             
        $com_name_data = DB::select("SELECT * FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name_data[0]->com_name;
        $com_owner_name = $com_name_data[0]->com_owner;

        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed LEFT JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$beta_enter[0]->enter_id."'");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$beta_enter[0]->enter_id."'");

        $option = DB::select("SELECT * FROM beta_option");
   
       
            return view('public.verified',compact('beta_enter','beta_enter_detail','user_data','beta_enter_road_detail','beta_enter_file'))->with('com_name',$com_name)->with('com_owner_name',$com_owner_name)->with('slug',$slug)->with('id',$beta_enter[0]->enter_id);  
   }
}