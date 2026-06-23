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
Use App\Models\beta_a_enter_quotar; 
Use App\Models\beta_a_enter_quotar_detail; 
Use App\Models\beta_a_enter_quotar_file; 

class QuotarController extends Controller
{
   public function pick()
   {
    dd('this is pick');
   }

   public function tell()
   {
    $company = beta_company_group::orderby('com_id','DESC')->paginate(50, ['*'], 'page_name');
    return view('notallow.quotar.tell',compact('company'));
   }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $companies = \App\Models\beta_company_group::query()
            ->when($query, function ($q) use ($query) {
                $q->where('com_name', 'like', "%{$query}%")
                ->orWhere('com_owner', 'like', "%{$query}%")
                ->orWhere('com_phone', 'like', "%{$query}%");
            })
            ->orderBy('com_id', 'DESC')
            ->limit(50)
            ->get();

        return response()->json($companies);
    }

}
