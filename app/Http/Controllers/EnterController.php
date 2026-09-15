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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


use Carbon\carbon;


Use App\Models\beta_enter;
Use App\Models\beta_company_group;
Use App\Models\beta_company_profile;
Use App\Models\beta_company_profile_detail;
Use App\Models\beta_enter_detail;
Use App\Models\beta_enter_file;
Use App\Models\beta_feed_back;
Use App\Models\beta_t_type;
Use App\Models\beta_enter_road_detail;
Use App\Models\beta_watching_list; 
Use App\Models\beta_tell_car_insurance; 

use Session;

class EnterController extends Controller
{
    public function index()
    {
         
            if(Carbon::now('Asia/Bangkok')>Auth::user()->end_at)
            {
                // return view('allow.expired.index');
                        $beta_company_profile = beta_company_profile::where('com_id',Auth::user()->com_id)->orderby('id','DESC')->get(); 

                return view('allow.enter.enter_testing',compact('beta_company_profile'));
            }
    
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
        
        return view('allow.enter.index',compact('beta_t_type'));

    }


    
    public function index_test()
    { 
        // if(Carbon::now('Asia/Bangkok')>Auth::user()->end_at)
        // {
        //     return view('allow.expired.index');
        // } 
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
        return view('allow.enter.enter_testing',compact('beta_t_type')); 
    }

    public function view_test()
    {  
        $beta_company_profile = beta_company_profile::where('com_id',Auth::user()->com_id)->get(); 
        
        return view('allow.enter.enter_testing_view',compact('beta_company_profile'));
    }

    

    public function update($id)
    {
          if(Carbon::now('Asia/Bangkok')>Auth::user()->end_at)
            {
                $beta_company_profile = beta_company_profile::where('com_id',Auth::user()->com_id)->get(); 

                // return view('allow.expired.index');
                return view('allow.enter.enter_testing',compact('beta_company_profile'));
            }
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE enter_id ='".$id."' AND user_id = '".Auth::user()->id."' ");
        $beta_enter_detail = DB::select("SELECT * FROM beta_enter_detail WHERE enter_id ='".$id."' AND user_id = '".Auth::user()->id."' ");
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$id."' AND user_id = '".Auth::user()->id."'");

        if($beta_enter[0]->status=='CANCEL' || $beta_enter[0]->status=='DRAFT' )
        {
            return view('allow.enter.update',compact('beta_t_type','beta_enter_detail','beta_enter','beta_enter_file'))->with('id',$id);
        }
        else
        {
            return redirect()->route('EnterList');
        }
    }


    public function store(Request $request)
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
            $beta_enter->status = "WAITING";
            $beta_enter->price = "0";
            $beta_enter->lasttails = $request->lasttails;
            $beta_enter->slug = $slug;
            $beta_enter->address  = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->address);
            $beta_enter->district = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->district);
            $beta_enter->province = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->province);
            // $beta_enter->enter_type = "QUOTAR"; // we have this in quotar
            $beta_enter->save();

            $enter_id = $beta_enter->enter_id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_plate = 'input_plate_'.$i;
                $input_d_name = 'input_d_name_'.$i;
                $input_t_model = 'input_t_model_'.$i;
                $input_p_import = 'input_p_import_'.$i;
                $input_weight = 'input_weight_'.$i;
                $input_detail = 'input_detail_'.$i;
                $input_t_model_round = 'input_t_model_round_'.$i;
                // $input_hash = 'input_hash_'.$i; //other side have hash for quotarController
              
                $plate = $request->$input_plate;
                $d_name = $request->$input_d_name;
                $t_model = $request->$input_t_model;
                $p_import = $request->$input_p_import;
                $weight = $request->$input_weight;
                $detail = $request->$input_detail;
                $t_model_round = $request->$input_t_model_round; 
                // $pro_id = $request->$input_hash; // quotarcontroller have this one

                $dum_str .= $t_model;
                
                if($plate!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;
                    // 1️⃣ Keep only digits
                    $check_plate = preg_replace('/\D/', '', $plate); // removes everything except 0–9

                    // 2️⃣ Query for record within last 7 days
                    $check_list = beta_watching_list::where('watching_number', $check_plate)
                        ->where('created_at', '>=', Carbon::now()->subDays(7))
                        ->exists();

                    // 3️⃣ Assign verify result
                    $verify = $check_list ? 'YES' : 'NO';

                    $beta_enter_detail = new beta_enter_detail;
                    $beta_enter_detail->enter_id = $enter_id;
                    $beta_enter_detail->user_id = Auth::user()->id;
                    $beta_enter_detail->plate_number = $plate;
                    $beta_enter_detail->t_model = $t_model;
                    $beta_enter_detail->d_name = $d_name;
                    $beta_enter_detail->p_import = $p_import;
                    $beta_enter_detail->rounds = $t_model_round;
                    $beta_enter_detail->weight = $weight;
                    $beta_enter_detail->detail = $detail;
                    $beta_enter_detail->status = '0';
                    $beta_enter_detail->t_type_id = '0';
                    $beta_enter_detail->p_type_id = '0';
                    $beta_enter_detail->is_verify = $verify; // QuotarController dont have this one
                    // $beta_enter_detail->pro_id = $pro_id; // quotarController side have this one
                    $beta_enter_detail->save();

                }
            }

            $com_id_path = 'c'.$com_id[0]->com_id;
            $iv_id = 'in'.$enter_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'com/'. $com_id_path .'/'.$iv_id;
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

            $this->sendEnterSavedDiscordNotification($enter_id);

            return response()->json([
                'status'=>200,
                'message'=>$dum_str,
            ]);
            
        }
    }

    private function sendEnterSavedDiscordNotification($enter_id)
    {
        $webhookUrl = config('services.discord.new_enter_webhook_url');

        if (!$webhookUrl || !$enter_id) {
            return;
        }

        try {
            $enter = beta_enter::where('enter_id', $enter_id)->first();

            if (!$enter) {
                return;
            }

            $company = beta_company_group::where('com_id', $enter->com_id)->first();
            $details = beta_enter_detail::where('enter_id', $enter_id)->orderBy('enter_detail_id')->get();
            $fileCount = beta_enter_file::where('enter_id', $enter_id)->count();
            $destination = trim(collect([$enter->address, $enter->district, $enter->province])->filter()->implode(', '));
            $number = $enter->enter_number && $enter->enter_number !== '0'
                ? $enter->enter_number
                : 'ENTER-'.date('Y', strtotime($enter->date_make)).'-'.str_pad((string) $enter->enter_id, 6, '0', STR_PAD_LEFT);

            $vehicleLines = $details->take(5)->map(function ($detail, $index) {
                return ($index + 1).'. '.$detail->plate_number.' | '.$detail->d_name.' | '.$detail->p_import.' | '.$detail->weight;
            })->implode("\n");

            Http::timeout(5)->post($webhookUrl, [
                'username' => 'Vehicle Permit System',
                'content' => '[ENTER] ມີໃບອະນຸຍາດໃໝ່ຖືກບັນທຶກສຳເລັດ',
                'embeds' => [[
                    'title' => '[ENTER] '.$number,
                    'color' => 0x0a427a,
                    'fields' => [
                        ['name' => 'ບໍລິສັດ', 'value' => $company->com_name ?? 'No company', 'inline' => true],
                        ['name' => 'ຜູ້ສົ່ງ', 'value' => Auth::user()->name ?? '-', 'inline' => true],
                        ['name' => 'ສະຖານະ', 'value' => $enter->status ?? '-', 'inline' => true],
                        ['name' => 'ວັນທີ', 'value' => date('d-m-Y', strtotime($enter->date_make)), 'inline' => true],
                        ['name' => 'ຈຳນວນລົດ', 'value' => (string) $details->count(), 'inline' => true],
                        ['name' => 'ໄຟລ໌ແນບ', 'value' => (string) $fileCount, 'inline' => true],
                        ['name' => 'ປາຍທາງ', 'value' => $destination ?: '-', 'inline' => false],
                        ['name' => 'ລາຍການລົດ', 'value' => $vehicleLines ?: '-', 'inline' => false],
                    ],
                ]],
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Discord enter notification failed', [
                'enter_id' => $enter_id,
                'message' => $exception->getMessage(),
            ]);
        }
    }


    public function store_test(Request $request)
    { 
            $dum_str = null; 
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now('Asia/Bangkok'); 
            $company_room = 'com_id_'.$com_id[0]->com_id;
            $compay_subject = 'submit_from_'.date('d-m-Y',strtotime(Carbon::now('Asia/Bangkok')));
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'list_of_submissions/'. $company_room .'/'.$compay_subject;
            $path = public_path($dum_path);
            
            // Create the directory if it does not exist
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->upload_files) {
                $pdfFiles = $request->file('upload_files'); 
                    // Save the PDF files to the storage/pdfs directory 
                    $beta_company_profile = new beta_company_profile;
                    $beta_company_profile->text = $request->lasttails; 
                    $beta_company_profile->created_at = Carbon::now('Asia/Bangkok');
                    $beta_company_profile->com_id = $com_id[0]->com_id;
                    $beta_company_profile->user_id =  Auth::user()->id; 
                    $beta_company_profile->save();
                    foreach ($pdfFiles as $pdfFile) {
                        if (File::isReadable($pdfFile)) {
                            if (File::size($pdfFile) < 20097152) { // 2MB
                                // File is larger than 2MB, do something
                                // Storage::put('com/' . $pdfFile->getClientOriginalName(), $pdfFile);
                                $path_name =$pdfFile->store($dum_path, ['disk' =>   'my_files']);
                                // $dum_str .= $path_name; 
                                $beta_company_profile_detail = new beta_company_profile_detail;
                                $beta_company_profile_detail->com_id = $com_id[0]->com_id;
                                $beta_company_profile_detail->company_profile_id = $beta_company_profile->id;
                                $beta_company_profile_detail->created_at = Carbon::now('Asia/Bangkok');
                                $beta_company_profile_detail->file_url = $path_name; 
                                $beta_company_profile_detail->text ='data';
                                $beta_company_profile_detail->save(); 
                            }
                            else
                            {
                                $can_not_upload .= ' [] : '.$pdfFile->getClientOriginalName().'';  
                                return response()->json([
                                    'status'=>200,
                                    'message'=>$can_not_upload,
                                ]);
                            }
                        }
                        else
                        {
                            $can_not_upload .= '[][][] : '.$pdfFile->getClientOriginalName(); 
                                return response()->json([
                                    'status'=>200,
                                    'message'=>$can_not_upload,
                                ]);
                        }
                    }  
            } 
            return response()->json([
                'status'=>200,
                'message'=>$dum_str,
            ]); 
    }

    public function draft(Request $request)
    {
        
        $index = $request->index;
        $dum_str = null;
 
        if($index)
        {
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now();
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
            $beta_enter->status = "DRAFT";
            $beta_enter->price = "0";
            $beta_enter->slug = $slug;
            $beta_enter->lasttails = $request->lasttails;
            $beta_enter->address  = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->address);
            $beta_enter->district = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->district);
            $beta_enter->province = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛ໝໜ\s]/u', '', $request->province);
            $beta_enter->save();

            $enter_id = $beta_enter->enter_id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_plate = 'input_plate_'.$i;
                $input_d_name = 'input_d_name_'.$i;
                $input_t_model = 'input_t_model_'.$i;
                $input_p_import = 'input_p_import_'.$i;
                $input_weight = 'input_weight_'.$i;
                $input_detail = 'input_detail_'.$i;

                
              
                $plate = $request->$input_plate;
                $d_name = $request->$input_d_name;
                $t_model = $request->$input_t_model;
                $p_import = $request->$input_p_import;
                $weight = $request->$input_weight;
                $detail = $request->$input_detail;

                $dum_str .= $t_model;
                
                if($plate!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;

                    $beta_enter_detail = new beta_enter_detail;
                    $beta_enter_detail->enter_id = $enter_id;
                    $beta_enter_detail->user_id = Auth::user()->id;
                    $beta_enter_detail->plate_number = $plate;
                    $beta_enter_detail->t_model = $t_model;
                    $beta_enter_detail->d_name = $d_name;
                    $beta_enter_detail->p_import = $p_import;
                    $beta_enter_detail->weight = $weight;
                    $beta_enter_detail->detail = $detail;
                    $beta_enter_detail->status = '0';
                    $beta_enter_detail->t_type_id = '0';
                    $beta_enter_detail->p_type_id = '0';
                    $beta_enter_detail->save();

                }
            }

            $com_id_path = 'c'.$com_id[0]->com_id;
            $iv_id = 'in'.$enter_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'com/'. $com_id_path .'/'.$iv_id;
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
                            if (File::size($pdfFile) < 2097152) { // 2MB
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
            
           
            return response()->json([
                'status'=>200,
                'message'=>$dum_str,
            ]);
            
        }
    }



    public function updatestore(Request $request,$id)
    {

        $index = $request->index;
        $dum_str = null;
        
        $delete = beta_enter_detail::where('enter_id',$id)->where('user_id',Auth::user()->id)->delete();
        if($index)
        {
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now('Asia/Bangkok');
            $newDate = $date->addDays(2);
            

            // $beta_enter = new beta_enter;
            // $beta_enter->user_id = Auth::user()->id;
            // $beta_enter->com_id = $com_id[0]->com_id;
            // $beta_enter->enter_number = "0";
            // $beta_enter->sign_status = '0';
            // $beta_enter->date_make = date('Y-m-d');
            // $beta_enter->date_in = date('Y-m-d');
            // $beta_enter->date_out = $newDate;
            // $beta_enter->status = "WAITING";
            // $beta_enter->price = "0";
            // $beta_enter->lasttails = $request->lasttails;
            // $beta_enter->address = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->address);
            // $beta_enter->district = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->district);
            // $beta_enter->province = preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->province);
            // $beta_enter->save();

            beta_enter::where('enter_id',$id)->where('user_id',Auth::user()->id)->update([
                'date_make' => Carbon::now('Asia/Bangkok'),
                'date_in' =>  Carbon::now('Asia/Bangkok'),
                'date_out' => $newDate,
                'status' => "WAITING",
                'lasttails' => $request->lasttails,
                'address' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->address),
                'district' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->district),
                'province' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->province),
            ]);

            $enter_id = $id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_plate = 'input_plate_'.$i;
                $input_d_name = 'input_d_name_'.$i;
                $input_t_model = 'input_t_model_'.$i;
                $input_p_import = 'input_p_import_'.$i;
                $input_weight = 'input_weight_'.$i;
                $input_detail = 'input_detail_'.$i;
              
                $plate = $request->$input_plate;
                $d_name = $request->$input_d_name;
                $t_model = $request->$input_t_model;
                $p_import = $request->$input_p_import;
                $weight = $request->$input_weight;
                $detail = $request->$input_detail;

                $dum_str .= $t_model;
                
                if($plate!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;

                    $beta_enter_detail = new beta_enter_detail;
                    $beta_enter_detail->enter_id = $enter_id;
                    $beta_enter_detail->user_id = Auth::user()->id;
                    $beta_enter_detail->plate_number = $plate;
                    $beta_enter_detail->t_model = $t_model;
                    $beta_enter_detail->d_name = $d_name;
                    $beta_enter_detail->p_import = $p_import;
                    $beta_enter_detail->weight = $weight;
                    $beta_enter_detail->detail = $detail;
                    $beta_enter_detail->status = '0';
                    $beta_enter_detail->t_type_id = '0';
                    $beta_enter_detail->p_type_id = '0';
                    $beta_enter_detail->save();

                }
            }

            $com_id_path = 'c'.$com_id[0]->com_id;
            $iv_id = 'in'.$enter_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'com/'. $com_id_path .'/'.$iv_id;
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
                            if (File::size($pdfFile) < 15242880) { // 2MB
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
                'message'=>0,
            ]);
        }
    }


    public function updatedraft(Request $request,$id)
    {

        $index = $request->index;
        $dum_str = null;
        
        $delete = beta_enter_detail::where('enter_id',$id)->where('user_id',Auth::user()->id)->delete();
        if($index)
        {
            $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
            $date = Carbon::now('Asia/Bangkok');
            $newDate = $date->addDays(2);

            beta_enter::where('enter_id',$id)->where('user_id',Auth::user()->id)->update([
                'date_make' => Carbon::now('Asia/Bangkok'),
                'date_in' =>  Carbon::now('Asia/Bangkok'),
                'date_out' => $newDate,
                'status' => "DRAFT",
                'lasttails' => $request->lasttails,
                'address' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->address),
                'district' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->district),
                'province' => preg_replace('/[^a-zA-Z0-9ก-๙ກ-໛\s]/u', '', $request->province),
            ]);

            $enter_id = $id;
 
            for($i=1;$i<=$index;$i++)
            {
                $input_plate = 'input_plate_'.$i;
                $input_d_name = 'input_d_name_'.$i;
                $input_t_model = 'input_t_model_'.$i;
                $input_p_import = 'input_p_import_'.$i;
                $input_weight = 'input_weight_'.$i;
                $input_detail = 'input_detail_'.$i;
              
                $plate = $request->$input_plate;
                $d_name = $request->$input_d_name;
                $t_model = $request->$input_t_model;
                $p_import = $request->$input_p_import;
                $weight = $request->$input_weight;
                $detail = $request->$input_detail;

                $dum_str .= $t_model;
                
                if($plate!='this_delete')
                {
                    // $dum_str_i = $plate.''.$d_name.'='.$t_model.''.$p_import.''.$weight.''.$detail;
                    // $dum_str = $dum_str .' [][][]'.$dum_str_i;

                    $beta_enter_detail = new beta_enter_detail;
                    $beta_enter_detail->enter_id = $enter_id;
                    $beta_enter_detail->user_id = Auth::user()->id;
                    $beta_enter_detail->plate_number = $plate;
                    $beta_enter_detail->t_model = $t_model;
                    $beta_enter_detail->d_name = $d_name;
                    $beta_enter_detail->p_import = $p_import;
                    $beta_enter_detail->weight = $weight;
                    $beta_enter_detail->detail = $detail;
                    $beta_enter_detail->status = '0';
                    $beta_enter_detail->t_type_id = '0';
                    $beta_enter_detail->p_type_id = '0';
                    $beta_enter_detail->save();

                }
            }

            $com_id_path = 'c'.$com_id[0]->com_id;
            $iv_id = 'in'.$enter_id;
            $can_not_upload = '';
            // Set the path for the directory
            $dum_path = 'com/'. $com_id_path .'/'.$iv_id;
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
                            if (File::size($pdfFile) < 15242880) { // 2MB
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
             

            return response()->json([
                'status'=>200,
                'message'=>0,
            ]);
        }
    }
    public function list()
    {
        $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
        $com_name = DB::select("SELECT com_name FROM beta_company_group WHERE com_id = '".$com_id[0]->com_id."'");
         
        $com_id = $com_id[0]->com_id;
        $com_name = $com_name[0]->com_name;

        $user_list = DB::select("SELECT * FROM users WHERE id = '".Auth::user()->id."'");

        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."' AND Date(date_make) = '".Carbon::now('Asia/Bangkok')->format('Y-m-d')."' AND status NOT IN ('CANCEL') AND status NOT IN ('DRAFT')  ORDER BY enter_id DESC LIMIT 50");
        $beta_enter_file = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status NOT IN ('CANCEL') AND e.status NOT IN ('DRAFT') AND f.user_id = '".Auth::user()->id."'");
        
        $beta_enter_cancel = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."' AND Date(date_make) = '".Carbon::now('Asia/Bangkok')->format('Y-m-d')."' AND status = 'CANCEL' ORDER BY enter_id DESC LIMIT 50");
        $beta_enter_file_cancel = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'CANCEL' AND f.user_id = '".Auth::user()->id."'");
        
        $beta_enter_draft = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."' AND status = 'DRAFT' ORDER BY enter_id DESC LIMIT 50");
        $beta_enter_file_draft = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'DRAFT' AND f.user_id = '".Auth::user()->id."'");
      
        return view('allow.enter.list',compact(
                                                'user_list',
                                                'beta_enter',
                                                'beta_enter_cancel',
                                                'beta_enter_draft',
                                                'beta_enter_file',
                                                'beta_enter_file_cancel',
                                                'beta_enter_file_draft',
                                                ))->with('com_name',$com_name);

    }
    
    public function history()
    {
        
            if(Carbon::now('Asia/Bangkok')>Auth::user()->end_at)
            {
                $beta_company_profile = beta_company_profile::where('com_id',Auth::user()->com_id)->orderby('id','DESC')->get(); 
                // return view('allow.expired.index');
                return view('allow.enter.enter_testing',compact('beta_company_profile'));
            }
        $com_id = DB::select("SELECT com_id FROM users WHERE id = '".Auth::user()->id."'");
        $com_name = DB::select("SELECT com_name FROM beta_company_group WHERE com_id = '".$com_id[0]->com_id."'");
         
        $com_id = $com_id[0]->com_id;
        $com_name = $com_name[0]->com_name;

        $user_list = DB::select("SELECT * FROM users WHERE id = '".Auth::user()->id."'");

        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."'  AND status NOT IN ('CANCEL')  ORDER BY enter_id DESC LIMIT 25");
        $beta_enter_cancel = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."'  AND status = 'CANCEL'  ORDER BY enter_id DESC LIMIT 25");
        $beta_enter_draft = DB::select("SELECT * FROM beta_enter WHERE com_id = '".$com_id."' AND status = 'DRAFT' ORDER BY enter_id DESC LIMIT 50");
        $beta_enter_file_cancel = DB::select("SELECT f.*,e.status FROM beta_enter_file f LEFT JOIN beta_enter e ON f.enter_id=e.enter_id WHERE e.status = 'CANCEL' AND f.user_id = '".Auth::user()->id."'");
    
        $beta_enter_file = DB::table('beta_enter_file as f')
        ->select('f.*', 'e.status')
        ->leftJoin('beta_enter as e', 'f.enter_id', '=', 'e.enter_id') 
        ->where('e.com_id', '=', $com_id)
        ->orderby('enter_id','DESC')
        ->limit('25')
        ->get();
        return view('allow.enter.list',compact('user_list','beta_enter','beta_enter_cancel','beta_enter_draft','beta_enter_file',
                                                'beta_enter_file_cancel'))->with('com_name',$com_name);
    }

    public function view($id)
    {
        // return redirect()->route('EnterList'); 
        $user_data = DB::select("SELECT * FROM users WHERE id = '".Auth::user()->id."'");
        $com_name = DB::select("SELECT com_name FROM beta_company_group WHERE com_id = '".$user_data[0]->com_id."'");
        
        $com_id = $user_data[0]->com_id;
        $com_name = $com_name[0]->com_name;
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$id."' AND user_id = '".Auth::user()->id."' AND com_id = '".$com_id."'");
        $beta_enter_detail = DB::select("SELECT ed.*, t.t_type_name FROM beta_enter_detail ed JOIN beta_t_type t ON ed.t_model = t.t_type_id WHERE ed.enter_id = '".$id."'");
    
        $progress_bar_name = '';
        $progress_bar_percent = '0%';
        $progress_bar_color = '#0b7dda';
        if($beta_enter[0]->status=='WAITING' || $beta_enter[0]->status=='QWAIT' )
        {
            $progress_bar_name = 'ກຳລັງລໍຖ້າ';
            $progress_bar_percent = '20%';
        }
        elseif($beta_enter[0]->status=='POINTING')
        {
            $progress_bar_name = 'ກຳລັງລະບຸສາຍທາງ';
            $progress_bar_percent = '50%';
        }
        elseif($beta_enter[0]->status=='SIGNING'  || $beta_enter[0]->status=='QSIGNING' )
        {
            $progress_bar_name    = 'ກຳລັງດຳເນີນການ';
            $progress_bar_percent = '70%';
        }
        elseif($beta_enter[0]->status=='SIGNINED')
        {
            $progress_bar_name    = 'ກຳລັງດຳເນີນການ';
            $progress_bar_percent = '80%';
        }
        elseif($beta_enter[0]->status=='READY')
        {

            $progress_bar_name    = 'ກຳລັງດຳເນີນການ';
            $progress_bar_percent = '90%';
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

        return view('allow.enter.view',compact('beta_enter','beta_enter_detail','user_data'))
        ->with('com_name',$com_name)
        ->with('progress_bar_name',$progress_bar_name)
        ->with('progress_bar_percent',$progress_bar_percent)
        ->with('progress_bar_color',$progress_bar_color)
        ->with('id',$id);
    }


    public function filedrop(Request $request)
    {
        
        $file_data = DB::select("SELECT * FROM beta_enter_file WHERE file_id = '".$request->id."' AND user_id = '".Auth::user()->id."' ");
        // Set the path to the PDF file
        $path_name = $file_data[0]->file_url;
        $path = public_path($path_name);

        $delete = beta_enter_file::where('file_id',$request->id)->where('user_id',Auth::user()->id)->delete();
        
        // Delete the PDF file
        if (File::exists($path)) {
            File::delete($path);
        }
        return response()->json(['message' => $request->id]);
    }

    // public function updatesession(Request $request)
    // {
    //     // if(Session::get('date') !== $currentDate) {
    //     //     // reset the session data
    //     //     Session::forget(['address', 'district', 'province']);
    //     //     Session::put('date', $currentDate);
    //     // }
    //     $value = $request->input('value');
    //     $input = $request->input('input');
    //     session([$input => $value]);
    //     return response()->json(['success' => true]);
    // }

    public function updatesession(Request $request)
    {
        $value = $request->input('value');
        $input = $request->input('input');

        // Check if today has passed to the next day
        $now = Carbon::now();
        $tomorrow = Carbon::tomorrow();
        if ($now >= $tomorrow) {
            // Remove the session data if today has passed to the next day
            session()->forget($input);
        } else {
            // Update the session data
            session([$input => $value]);
        }

        return response()->json(['success' => true]);
    }


    public function cancel(Request $request)
    {
     
        $check = beta_enter::where('enter_id',$request->id)->where('user_id',Auth::user()->id)->first();
        if($check->status=='WAITING')
        {
            beta_enter::where('enter_id',$request->id)->where('user_id',Auth::user()->id)->update([
                'status' => 'CANCEL',
                'sign_url' => '',
                'cancel_log' => 'ຜູ້ໃຊ້ຍົກເລີກ',
            ]);

            $currentTime = Carbon::now();

            $beta_feed_back = new beta_feed_back;
            $beta_feed_back->user_id = Auth::user()->id;
            $beta_feed_back->date = date('Y-m-d');
            $beta_feed_back->time = $currentTime->format('h:i:s');
            $beta_feed_back->feed_back_msg = ' ຍົກເລີກ :  ສາເຫດທີ່ຍົກເລີກ ຜູ້ໃຊ້ຍົກເລີກ';
            $beta_feed_back->ref_id        = $request->id;
            $beta_feed_back->pointer       = "User & Cancel";
            $beta_feed_back->save();

            return response()->json([
                'status'=>200,
                'math'=>'1',
                'message'=>$request->id,
            ]);
        }
        else
        { 
            return response()->json([
                'status'=>200,
                'math'=>'0',
                'message'=>$request->id,
            ]);
        }

     
        
    }

    public function delete(Request $request)
    {
        
        
        $check_ex = DB::select("SELECT * FROM beta_enter WHERE enter_id = '".$request->id."' AND user_id = '".Auth::user()->id."' ");
        if($check_ex)
        {
            
        $delete = beta_enter::where('enter_id',$request->id)->where('user_id',Auth::user()->id)->delete();
        $delete = beta_enter_detail::where('enter_id',$request->id)->where('user_id',Auth::user()->id)->delete();
        $delete = beta_enter_road_detail::where('enter_id',$request->id)->delete();


        $file_data = DB::select("SELECT * FROM beta_enter_file WHERE enter_id = '".$request->id."' AND user_id = '".Auth::user()->id."' ");
        foreach($file_data as $row)
        {
            // Set the path to the PDF file
            $path_name = $row->file_url;
            $path = public_path($path_name);

            $delete = beta_enter_file::where('file_id',$row->file_id)->where('user_id',Auth::user()->id)->delete();

            // Delete the PDF file
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        


        $currentTime = Carbon::now();

        $beta_feed_back = new beta_feed_back;
        $beta_feed_back->user_id = Auth::user()->id;
        $beta_feed_back->date = date('Y-m-d');
        $beta_feed_back->time = $currentTime->format('h:i:s');
        $beta_feed_back->feed_back_msg = ' ລຶບເອກະສານ';
        $beta_feed_back->ref_id        = $request->id;
        $beta_feed_back->pointer       = "User & Cancel";
        $beta_feed_back->save();

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]);

        }
        
    }

    public function send(Request $request)
    {
        beta_enter::where('enter_id',$request->id)->where('user_id',Auth::user()->id)->update([
            'status' => 'WAITING',
            'date_make' => Carbon::now('Asia/Bangkok'),
            'date_in' => Carbon::now('Asia/Bangkok'),
        ]);

        $this->sendEnterSavedDiscordNotification($request->id);

        return response()->json([
            'status'=>200,
            'message'=>$request->id,
        ]);

    }


    public function download($file)
    {
        $beta_enter_file = DB::select("SELECT * FROM beta_enter_file WHERE user_id = '".Auth::user()->id."' AND file_id = '".$file."'");
        if ($beta_enter_file) {
            $file_path = $beta_enter_file[0]->file_url;

            return response()->file($file_path);
        } else {
            abort(404);
        }

    }
    

    public function tell_car_insurance()
    {
        // You said you already have $beta_t_type — so fetch it here
        $beta_t_type = DB::table('beta_t_type')->orderBy('t_type_name')->get();
         $beta_tell_car_insurance = DB::SELECT('
                SELECT i.*,c.com_name,t.t_type_name FROM beta_tell_car_insurance i 
                JOIN beta_company_group c ON i.com_id = c.com_id
                JOIN beta_t_type t ON i.car_type_id = t.t_type_id
                WHERE i.com_id = "'.(Auth::user()->com_id ?? '0').'"
                ORDER BY i.status ASC  
        ');

        return view('allow.enter.tell_insurance', compact('beta_t_type', 'beta_tell_car_insurance'));
    }

            
        public function tell_car_insurance_store(Request $request)
        {
            $user = Auth::user();

            $validated = $request->validate([
                'plate_number'            => ['required','string','max:50'],
                'insurance_extra_number'  => ['nullable','string','max:100'],
                'car_type_id'             => ['required','string','max:255'],
                'date_in'          => ['required','date'],
                'file_upload'             => ['nullable'],
                'file_upload.*'           => ['file','max:10240'], // 10MB each
            ]);

            $now = Carbon::now('Asia/Bangkok');

            // 1) create row FIRST to get id (so folder can include id)
            $row = beta_tell_car_insurance::create([
                'com_id'                  => $user->com_id ?? null,
                'plate_number'            => $validated['plate_number'],
                'insurance_extra_number'  => $validated['insurance_extra_number'] ?? null,
                'car_type_id'             => $validated['car_type_id'],
                'date_in'                 => $validated['date_in'], 
                'file_upload'             => null, // update after upload   
                'created_at'              => $now,
                'updated_at'              => $now,
                'status'                  => 'WAITING',
                'user_id'                 => $user->user_id ?? $user->id,
            ]);

            // 2) prepare folder like your working controller
            $com_id_path = 'c' . ($user->com_id ?? '0');
            $ti_id       = 'ti' . $row->id;

            // example: com/c12/tell_car_insurance/ti55
            $dum_path = 'tell_car_insurance/' . $com_id_path . '/'.date("Y").'/'.date("m").'/' . $ti_id .'_'. date("d");

            // create physical folder (if your disk points to public/)
            $path = public_path($dum_path);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // 3) upload multi files using your working disk (my_files)
            $paths = [];
            if ($request->hasFile('file_upload')) {
                foreach ((array)$request->file('file_upload') as $up) {
                    if (!$up) continue;

                    // keep your safe naming style
                    $safeName = Str::slug(pathinfo($up->getClientOriginalName(), PATHINFO_FILENAME));
                    $ext      = strtolower($up->getClientOriginalExtension());
                    $final    = $safeName . '_' . date('Ymd_His') . '_' . Str::random(6) . '.' . $ext;

                    // store into dum_path using disk my_files
                    // IMPORTANT: storeAs works best for naming
                    $storedPath = $up->storeAs($dum_path, $final, ['disk' => 'my_files']);

                    if ($storedPath) {
                        $paths[] = $storedPath; // store path string
                    }
                }
            }

            // 4) update file_upload JSON after upload
            $row->file_upload = !empty($paths) ? json_encode($paths, JSON_UNESCAPED_UNICODE) : null;
            $row->updated_at  = $now;
            $row->save();

            return response()->json([
                'ok' => true,
                'id' => $row->id,
                'msg' => 'Saved successfully',
            ]);
        } 

        public function store_company_profile(Request $request)
        { 
                $dum_str = null;  
              
                $date = Carbon::now('Asia/Bangkok'); 
                $company_room = 'com_id_'.$request->com_id;
                $compay_subject = 'submit_from_'.date('d-m-Y',strtotime(Carbon::now('Asia/Bangkok')));
                $can_not_upload = '';
                // Set the path for the directory
                $dum_path = 'list_of_submissions/'. $company_room .'/'.$compay_subject;
                $path = public_path($dum_path);
                
                // Create the directory if it does not exist
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                if ($request->upload_files) {
                    $pdfFiles = $request->file('upload_files'); 
                        // Save the PDF files to the storage/pdfs directory 
                        $beta_company_profile = new beta_company_profile;
                        $beta_company_profile->text = $request->lasttails; 
                        $beta_company_profile->created_at = Carbon::now('Asia/Bangkok');
                        $beta_company_profile->com_id = $request->com_id;
                        $beta_company_profile->user_id =  Auth::user()->id; 
                        $beta_company_profile->save();
                        foreach ($pdfFiles as $pdfFile) {
                            if (File::isReadable($pdfFile)) {
                                if (File::size($pdfFile) < 20097152) { // 2MB
                                    // File is larger than 2MB, do something
                                    // Storage::put('com/' . $pdfFile->getClientOriginalName(), $pdfFile);
                                    $path_name =$pdfFile->store($dum_path, ['disk' =>   'my_files']);
                                    // $dum_str .= $path_name; 
                                    $beta_company_profile_detail = new beta_company_profile_detail;
                                    $beta_company_profile_detail->com_id = $request->com_id;
                                    $beta_company_profile_detail->company_profile_id = $beta_company_profile->id;
                                    $beta_company_profile_detail->created_at = Carbon::now('Asia/Bangkok');
                                    $beta_company_profile_detail->file_url = $path_name; 
                                    $beta_company_profile_detail->text ='data';
                                    $beta_company_profile_detail->save(); 
                                }
                                else
                                {
                                    $can_not_upload .= ' [] : '.$pdfFile->getClientOriginalName().'';  
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>$can_not_upload,
                                    ]);
                                }
                            }
                            else
                            {
                                $can_not_upload .= '[][][] : '.$pdfFile->getClientOriginalName(); 
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>$can_not_upload,
                                    ]);
                            }
                        }  
                } 
                return response()->json([
                    'status'=>200,
                    'message'=>$dum_str,
                ]); 
        }
 
}
