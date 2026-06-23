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
Use App\Models\beta_t_type;
Use App\Models\beta_enter_road_detail;

Use App\Models\typex; 
Use App\Models\QuotarList; 
Use App\Models\products; 
Use App\Models\unit; 
Use App\Models\beta_a_enter_quotar; 
Use App\Models\beta_a_enter_quotar_detail; 
Use App\Models\beta_a_enter_quotar_file; 
Use App\Models\beta_watching_list; 
Use Session;
class QuotarCon extends Controller
{
    public function index()
    {
        
            $list = products::get();
            $type = typex::get();
            $unit = unit::get();

            return view('notallow.add.com.quotar.index',compact('list','type','unit'));
 
    }

    public function save(Request $request)
    { 
            $type_id = $request->type_id; 
            $product_name = $request->product_name;
            if($product_name)
            {
                
            $products = new products; 
            $products->name = $product_name;
            $products->pro_type_id = $type_id; 
            $products->save();
            return redirect()->back();
    
            }
            else
            {
                dd('ບໍ່ມີຊື່');
            } 
    }

    public function edit(Request $request)
    {
         
        $id = $request->id;
        $name = $request->name;
        $type = $request->type; 

        products::where('id',$id)->update([ 
            'name' => $name,
            'pro_type_id' => $type, 
        ]);
        // 'lastupdated_at' => carbon::now('Asia/Bangkok'), 

        return response()->json(['message'=>"Complete"],200);
    }


    public function delete(Request $request)
    {
        $id = $request->id;
 

        $check = products::where('id',$id)->first();
        
        if($check)
        {
            $delete = products::where('id',$id)->delete(); 

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


    public function tellStore(Request $request)
    {
        $index = $request->index;
        $dum_str = null;
 
        if($index)
        {
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now('Asia/Bangkok');
            $newDate = $date->addDays(2); 

            
            $beta_a_enter_quotar = new beta_a_enter_quotar;
            $beta_a_enter_quotar->user_id = Auth::user()->id;
            $beta_a_enter_quotar->com_id = $com_id[0]->com_id; 
            $beta_a_enter_quotar->status = "WAITING";  
            $beta_a_enter_quotar->created_at = date('Y-m-d');  
            $beta_a_enter_quotar->note  = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->lasttails);  
            $beta_a_enter_quotar->in = $request->in;  
            $beta_a_enter_quotar->out = $request->out;  
            $beta_a_enter_quotar->transfer = $request->pass;  
            $beta_a_enter_quotar->local = $request->in_for_animal;  

            $beta_a_enter_quotar->save();


            $qo_id = $beta_a_enter_quotar->id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_name = 'input_name_'.$i;
                $input_qty = 'input_qty_'.$i;
                $input_price_total = 'input_price_total_'.$i; 
                $input_weight = 'input_weight_'.$i;
                $cur_select = 'cur_select_'.$i;
                // $input_detail = 'input_cur_'.$i;
              
                $input_name = $request->$input_name;
                $input_qty = $request->$input_qty;
                $input_price_total = str_replace(',','',$request->$input_price_total);
                $input_weight = str_replace(',','',$request->$input_weight); 
                $cur_select = $request->$cur_select;
               

                $dum_str .= '';
                
                if($input_name!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;

                    $beta_a_enter_quotar_detail = new beta_a_enter_quotar_detail;
                    $beta_a_enter_quotar_detail->qo_id = $qo_id; 
                    $beta_a_enter_quotar_detail->name = $input_name;
                    $beta_a_enter_quotar_detail->qty = $input_qty;
                    $beta_a_enter_quotar_detail->total_price = $input_price_total;
                    $beta_a_enter_quotar_detail->cur = $cur_select;
                    $beta_a_enter_quotar_detail->weight = $input_weight; 
                    $beta_a_enter_quotar_detail->save();

                }
            }

            $com_id_path = 'c'.$com_id[0]->com_id;
            $iv_id = 'q'.$qo_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'quotarlist/'. $com_id_path .'/'.$iv_id;
            $path = public_path($dum_path);
            
            // Create the directory if it does not exist
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->upload_files) {
                $pdfFiles = $request->file('upload_files');

                    // Save the PDF files to the storage/pdfs directory
                    foreach ($pdfFiles as $pdfFile) {
                        if (File::isReadable($pdfFile)) {
                            if (File::size($pdfFile) < 20097152) { // 2MB
                                // File is larger than 2MB, do something
                                // Storage::put('com/' . $pdfFile->getClientOriginalName(), $pdfFile);
                                $path_name =$pdfFile->store($dum_path, ['disk' =>   'my_files']);
                                // $dum_str .= $path_name;

                                $beta_a_enter_quotar_file = new beta_a_enter_quotar_file;
                                $beta_a_enter_quotar_file->user_id = Auth::user()->id;
                                $beta_a_enter_quotar_file->date = date('Y-m-d');
                                $beta_a_enter_quotar_file->file_url = $path_name;
                                $beta_a_enter_quotar_file->qo_id = $qo_id;
                                $beta_a_enter_quotar_file->save();

                            }
                            else
                            {
                                $can_not_upload .= ' [ຂະໜາດເກີນ] : '.$pdfFile->getClientOriginalName().'';
                            }
                        }
                        else
                        {
                            $can_not_upload .= '[ລະບົບອ່ານບໍ່ໄດ້][ຄວາມປອດໄພ][ຂະໜາດເກີນ] : '.$pdfFile->getClientOriginalName();
                        }
                    }  
            } 
            
            // Set the path to the directory
            // $path = public_path('pdfs');

            // // Delete the directory
            // if (File::exists($path)) {
            //     File::deleteDirectory($path);
            // }

            
            // // Set the path to the PDF file
            // $path = public_path($path_name);

            // // Delete the PDF file
            // if (File::exists($path)) {
            //     File::delete($path);
            // }

            return response()->json([
                'status'=>200,
                'message'=>$dum_str,
            ]);
            
        }
    }


    
    public function history()
    {
        $beta_a_enter_quotar = beta_a_enter_quotar::where('com_id',Auth::user()->com_id)->paginate(10, ['*'], 'page_name');
      
        return view('allow.quotar.history',compact('beta_a_enter_quotar'));
    }


    public function seeQuotar()
    {
        $typex = typex::get(); 

        // $typex = typex::
        // with(['o_in_od' => function ($query) use ($food_id) {
        //     $query->where('food_id', $food_id);
        // }])
        // ->get();

        return view('allow.quotar.quotar',compact('typex')); 
    }


    public function enter_quotar()
    {
        if(session('com_status')=='YES')
        {
            if(Auth::user()->com_id)
            { 
                $beta_t_type = DB::select("SELECT * FROM beta_t_type");

                $company = beta_company_group::where('com_id', Auth::user()->com_id)->first();
                if($company==null)
                { 
                    session(['com_id'   =>0,
                    'com_status'=>'NO']); 
                }
                else
                {  
                    session(['com_id'   =>$company->com_id,
                        'com_status'=>$company->com_status]);  

                }
                $date = Carbon::now('Asia/Bangkok');
                // $newDate = $date->addDays(90); 

                $beta_a_enter_quotar = beta_a_enter_quotar::where('com_id',Auth::user()->com_id)
                                                          ->where('status','SUCCESS')
                                                          ->where('expired_at','>',$date)
                                                          ->get();
              
                return view('allow.enter.enter_quotar',compact('beta_t_type','beta_a_enter_quotar'));
            }
        }
        else
        {
            dd('');   
        }



    }

    public function enter_quotar_save(Request $request)
    {
        
        $index = $request->index;
        $dum_str = null;
 
        if($index)
        {
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now('Asia/Bangkok');
            $newDate = $date->addDays(2); 

            $slug = Str::random(50);

            while (beta_enter::where('slug', $slug)->exists()) {
                $slug = Str::random(50);
            }

            $beta_enter = new beta_enter;
            $beta_enter->user_id = Auth::user()->id;
            $beta_enter->com_id = $com_id[0]->com_id;
            $beta_enter->enter_number = "0";
            $beta_enter->sign_status = '0';
            $beta_enter->date_make = Carbon::now('Asia/Bangkok');
            $beta_enter->date_in = Carbon::now('Asia/Bangkok');
            $beta_enter->date_out = $newDate;
            $beta_enter->status = "WAITING"; //status
            $beta_enter->qstatus = "WAITING"; //status
            $beta_enter->price = "0";
            $beta_enter->lasttails = $request->lasttails;
            $beta_enter->slug = $slug;
            $beta_enter->address  = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->address);
            $beta_enter->district = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->district);
            $beta_enter->province = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->province);
            $beta_enter->enter_type = "QUOTAR";
            $beta_enter->save();

            $enter_id = $beta_enter->id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_plate = 'input_plate_'.$i;
                $input_d_name = 'input_d_name_'.$i;
                $input_t_model = 'input_t_model_'.$i;
                $input_p_import = 'input_p_import_'.$i;
                $input_weight = 'input_weight_'.$i;
                $input_detail = 'input_detail_'.$i;
                $input_hash = 'input_hash_'.$i; // no this in other side for enterOCntroller
              
                $plate = $request->$input_plate;
                $d_name = $request->$input_d_name;
                $t_model = $request->$input_t_model;
                $p_import = $request->$input_p_import;
                $weight = $request->$input_weight;
                $detail = $request->$input_detail;
                $pro_id = $request->$input_hash; // entercontroller dont have this one
              

                $dum_str .= $t_model;
                
                if($plate!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;
                    $check_plate = preg_replace('/\D/', '', $plate); // removes everything except 0–9
                    $check_list = beta_watching_list::where('watching_number', $check_plate)
                                            ->where('created_at', '>=', Carbon::now()->subDays(7))
                                            ->exists();
                    $verify = $check_list ? 'YES' : 'NO';



                    $beta_enter_detail = new beta_enter_detail;
                    $beta_enter_detail->enter_id = $enter_id;
                    $beta_enter_detail->user_id = Auth::user()->id;
                    $beta_enter_detail->plate_number = $plate;
                    $beta_enter_detail->t_model = $t_model;
                    $beta_enter_detail->d_name = $d_name;
                    $beta_enter_detail->p_import = $p_import;
                    $beta_enter_detail->weight = str_replace(',','',$weight);
                    $beta_enter_detail->detail = $detail;
                    $beta_enter_detail->status = '0';
                    $beta_enter_detail->t_type_id = '0';
                    $beta_enter_detail->p_type_id = '0';
                    $beta_enter_detail->pro_id = $pro_id; // enterController side dont have this one
                    $beta_enter_detail->is_verify = $verify; // QuotarController dont have this one
                    $beta_enter_detail->save();

                }
            }

            $com_id_path = 'com_'.$com_id[0]->com_id;
            $iv_id = 'in'.$enter_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'quotar/'. $com_id_path .'/'.$iv_id;
            $path = public_path($dum_path);
            
            // Create the directory if it does not exist
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->upload_files) {
                $pdfFiles = $request->file('upload_files');

                    // Save the PDF files to the storage/pdfs directory
                    foreach ($pdfFiles as $pdfFile) {
                        if (File::isReadable($pdfFile)) {
                            if (File::size($pdfFile) < 20097152) { // 2MB
                                // File is larger than 2MB, do something
                                // Storage::put('com/' . $pdfFile->getClientOriginalName(), $pdfFile);
                                $path_name =$pdfFile->store($dum_path, ['disk' =>   'my_files']);
                                // $dum_str .= $path_name;

                                $beta_enter_file = new beta_enter_file;
                                $beta_enter_file->user_id = Auth::user()->id;
                                $beta_enter_file->date = date('Y-m-d');
                                $beta_enter_file->file_url = $path_name;
                                $beta_enter_file->enter_id = $enter_id;
                                $beta_enter_file->save();

                            }
                            else
                            {
                                $can_not_upload .= ' [ຂະໜາດເກີນ] : '.$pdfFile->getClientOriginalName().'';
                            }
                        }
                        else
                        {
                            $can_not_upload .= '[ລະບົບອ່ານບໍ່ໄດ້][ຄວາມປອດໄພ][ຂະໜາດເກີນ] : '.$pdfFile->getClientOriginalName();
                        }
                    }
                
                if($can_not_upload!='')
                {
                    $currentTime = Carbon::now();

                    $beta_feed_back = new beta_feed_back;
                    $beta_feed_back->com_id = $com_id[0]->com_id;
                    $beta_feed_back->user_id = Auth::user()->id;
                    $beta_feed_back->date = date('Y-m-d');
                    $beta_feed_back->time = $currentTime->format('h:i:s');
                    $beta_feed_back->feed_back_msg = ' Failed : ອັບໂຫລດ File ບໍ່ຜ່ານ ອ້າງອີງການປ້ອນ "'.$can_not_upload.'"';
                    $beta_feed_back->ref_id = $enter_id;
                    $beta_feed_back->pointer = "Enter";
                    $beta_feed_back->save();
                }
         
            }
            
            // Set the path to the directory
            // $path = public_path('pdfs');

            // // Delete the directory
            // if (File::exists($path)) {
            //     File::deleteDirectory($path);
            // }

            
            // // Set the path to the PDF file
            // $path = public_path($path_name);

            // // Delete the PDF file
            // if (File::exists($path)) {
            //     File::delete($path);
            // }

            return response()->json([
                'status'=>200,
                'message'=>$dum_str,
            ]);
            
        }
    }
}
