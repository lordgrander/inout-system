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
Use App\Models\unit; 
Use Session;
class QuotarCon extends Controller
{
    public function index($com_id)
    {
        $check = beta_company_group::where('com_id',$com_id)->where('com_status','YES')->first();
        if($check)
        {
            $list = QuotarList::where('com_id',$com_id)->get();
            $type = typex::get();
            $unit = unit::get();

            return view('notallow.add.com.quotar.index',compact('list','type','unit'))->with('com_id',$com_id);


        }
        else
        {
            dd('ບໍ່ມີ Quotar');
        }
    }

    public function save(Request $request,$com_id)
    {
         
        $check = beta_company_group::where('com_id',$com_id)->where('com_status','YES')->first();
        if($check)
        {
            $type_id = $request->type_id;
            $unit_id = $request->unit_id;
            $product_name = $request->product_name;
            if($product_name)
            {
                
            $QuotarList = new QuotarList;
            $QuotarList->com_id = $com_id;
            $QuotarList->pro_name = $product_name;
            $QuotarList->pro_type_id = $type_id;
            $QuotarList->unit_id = $unit_id;
            $QuotarList->save();
            return redirect()->back();
    
            }
            else
            {
                dd('ບໍ່ມີຊື່');
            }

        }
        else
        {
            dd('ບໍ່ມີ Quotar');
        }
    }

    public function edit(Request $request)
    {
         
        $id = $request->id;
        $name = $request->name;
        $type = $request->type;
        $unit = $request->unit;
        $com_id = $request->com_id;

        QuotarList::where('com_id',$com_id)->where('id',$id)->update([ 
            'pro_name' => $name,
            'pro_type_id' => $type,
            'unit_id' => $unit, 
            'lastupdated_at' => carbon::now('Asia/Bangkok'), 
        ]);

        return response()->json(['message'=>"Complete"],200);
    }


    public function delete(Request $request)
    {
        $id = $request->id;

        $com_id = $request->com_id;

        $check = QuotarList::where('com_id',$com_id)->where('id',$id)->first();
        

        if($check->total_in == 0 || $check->total_in <0)
        { 
            if($check->total_out == 0 || $check->total_out <0)
            {
                $delete = QuotarList::where('com_id',$com_id)->where('id',$id)->delete(); 
            }
        }


        return response()->json(['message'=>"Complete"],200);

    }


    public function com_add()
    {
        $com_id = session('com_id');
        $check = beta_company_group::where('com_id',$com_id)->where('com_status','YES')->first();
        if($check)
        {
            $list = QuotarList::where('com_id',$com_id)->get();
            $type = typex::get();
            $unit = unit::get();

            return view('allow.register.index',compact('list','type','unit'))->with('com_id',$com_id);


        }
        else
        {
            dd('ບໍ່ມີ Quotar');
        } 
    }

    public function tell()
    {
        $com_id = session('com_id');

        $list = QuotarList::where('com_id',$com_id)->get();
       
        return view('allow.quotar.index',compact('list'));
    }
}
