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

use Session;

class CompanyController extends Controller
{
   public function subject_list(Request $request)
    {
        $id = $request->id;

        $company = beta_company_group::where('com_id', $id)->first();
        if (!$company) {
            return response()->json(['status'=>404, 'msg'=>'Not_found']);
        }

        // If you really want a list:
        // Adjust select(...) to the columns you need.
        $subjects = beta_com_nano::where('com_id', $id)
            ->select('id', 'subject','com_id')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data'   => $subjects, // <-- array, great for forEach
        ]);
    }

    public function subject_add(Request $request)
    {
        $id = $request->id;
        $text_subject = $request->text_subject;

        $company = beta_company_group::where('com_id', $id)->first();
        if (!$company) {
            return response()->json(['status'=>404, 'msg'=>'Not_found']);
        }

        // If you really want a list:
        // Adjust select(...) to the columns you need.
        $subjects = beta_com_nano::where('com_id', $id)
            ->select('id', 'subject','com_id')
            ->orderBy('id')
            ->get();
        $subject = new beta_com_nano;
        $subject->com_id = $id;
        $subject->subject = $text_subject;
        $subject->created_at = Carbon::now('Asia/Bangkok');
        $subject->updated_at = Carbon::now('Asia/Bangkok');
        $subject->save();
        
        return response()->json([
            'status' => 200,
            'id' => $id,
            'delete' => $subject->id,
            'data'   => $subjects, // <-- array, great for forEach
        ]); 
    }

    public function subject_delete(Request $request)
    {
        $id = $request->id;
        $delete = $request->deletex;

        $company = beta_company_group::where('com_id', $id)->first();
        if (!$company) {
            return response()->json(['status'=>404, 'msg'=>'Not_found']);
        }

        $delete = beta_com_nano::where('id',$delete)->first();
        if($delete)
        {
            $delete->delete();
            $subjects = beta_com_nano::where('com_id', $id)
            ->select('id', 'subject','com_id')
            ->orderBy('id')
            ->get();

            return response()->json([
                'status' => 200,
                'data'   => $subjects, // <-- array, great for forEach
            ]);  
        }

    }


    public function watching_list()
    {
        $today = Carbon::now('Asia/Bangkok');

        $watching_list = beta_watching_list::orderby('id','DESC')->get();
        return view('notallow.watching.index',compact('watching_list'));
    }

    public function watching_delete(Request $request)
    {
        $id = $request->id;
        $delete = beta_watching_list::where('id',$id)->first();
        $delete->delete();
          return response()->json([
                'status' => 200, 
            ]);   
    }

    public function watching_add(Request $request)
    {
        $watching_number = $request->watching_number;

        $add = new beta_watching_list;
        $add->watching_number = preg_replace('/\D/', '', $watching_number);
        $add->watching_normal = $watching_number;
        $add->save();

          return response()->json([
                'status' => 200, 
            ]);    
    }



    public function company_profile_list()
    {
        $beta_company_profile = beta_company_profile::where('status','pending')->paginate(50, ['*'], 'page_name');

        $beta_extend_detail = beta_extend_detail::orderby('id','DESC')->get();

        return view('notallow.company.index',compact('beta_company_profile','beta_extend_detail'));
    }

    public function company_profile_list_status($status)
    {
        if($status=='all')
        {
            $beta_company_profile = beta_company_profile::orderby('id','DESC')->paginate(50, ['*'], 'page_name'); 
        }
        else
        {
            $beta_company_profile = beta_company_profile::where('status',$status)->orderby('id','DESC')->paginate(50, ['*'], 'page_name'); 
        }
 
        $beta_extend_detail = beta_extend_detail::orderby('id','DESC')->get();

        return view('notallow.company.index',compact('beta_company_profile','beta_extend_detail'));
    }


    public function filterCompanyProfile(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;

        $get_list = beta_company_profile::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'accepted')
            ->with('beta_company_group') // ✅ model reference
            ->get();

        return response()->json($get_list);
    }
    
}