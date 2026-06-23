<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
Use App\Models\datain;
Use App\Models\datains_pics;
Use App\Models\remembers;
Use App\Models\type;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;


class Incontroller extends Controller
{
    // @ 1
    public function index()
    {        
        $datain =  datain::where('type','in')->paginate(100);   
        $type = 'in';
        $databigtype =  type::get();
        return view('doc_in.index', compact('datain','databigtype'))->with('type',$type); 
    }


    public function index_out()
    {        
        $datain =  datain::where('type','out')->paginate(100);   
        $type = 'out';
        $databigtype =  type::get();   
        return view('doc_in.index', compact('datain','databigtype'))->with('type',$type); 
    }


    public function search(Request $request, $type)
    {        
        $txtsearch = $request->txtsearch;
        $datain =  datain::where('type',$type)->where('header', 'LIKE' ,'%'.$txtsearch.'%')->paginate(20);   
        $type = 'out';
        return view('doc_in.index', compact('datain'))->with('type',$type); 
    }
 

    // @ 2
    public function store(Request $request)
    {        
        $request->validate(
            [
                'header'=>'required',
                'doc_number'=>'required|',
                'doc_type_id'=>'required|not_in:0', 
                'main_file_path'=>'mimes:jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm',
            ],
            [
                'header.required'=>"ກະລຸນາປ້ອນຫົວຂໍ້.", 
                'doc_number.required'=>"ກະລຸນາປ້ອນໝາຍເລກເອກະສານອ້າງອີງ.", 
                'doc_type_id.required'=>'ກະລຸນາເລືອກປະເພດເອກະສານ', 
                'main_file_path.mimes'=>'ກະລຸນາປ້ອນ Fileທີ່ມີນາມສະກຸນເປັນ jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm', 
            ]); 

        //ການເຂົ້າລະຫັດຮູບພາບ
        // dd($request->service_name, $request->service_image);
        $service_image = $request->file('main_file_path'); 
         
        
        if($service_image)
        {
            //Generate ຊື່ຮູບພາບ
            $name_gen = hexdec(uniqid());
            
            //ດືງຂໍ້ມູນຈາກຮູບພາບ ນາມສະກຸນ File ແລ້ວເຮັດເປັນໂຕນ້ອຍໝົດໂດຍໃຊ້ strtoLower
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            
            $img_name = $name_gen.'.'.$img_ext;
            
            //upload ແລະ ບັນທຶກຂໍ້ມູນ
            $upload_location = 'image/in/';
            $full_path = $upload_location.$img_name;
            //ທົດລອງອັບໂຫຼດ
            datain::insert([
                                'type'=>$request->type, 
                                'info'=>$request->info,
                                'doc_number'=>$request->doc_number,
                                'header'=>$request->header,
                                'color'=>$request->color,
                                'doc_type_id'=>$request->doc_type_id,
                                'subject'=>$request->subject, 
                                'user_id'=>Auth::user()->id,
                                'main_file_path'=>$full_path,
                                'custom_date'=>$request->custom_date, 
                                'created_at'=>Carbon::now(), //use Carbon\carbon; 
                                'updated_at'=>Carbon::now(), //use Carbon\carbon; 
                            ]);

            $service_image->move($upload_location, $img_name); 
            $datain = datain::orderBy('id', 'desc')->first();   
            $datains_pics = datains_pics::where('in_id',$datain->id)->get();   

            return view('doc_in.view.index', compact('datain','datains_pics')); 
        }
        else
        {
            datain::insert([
                'type'=>$request->type, 
                'info'=>$request->info,
                'doc_number'=>$request->doc_number,
                'header'=>$request->header,
                'color'=>$request->color,
                'doc_type_id'=>$request->doc_type_id,
                'subject'=>$request->subject, 
                'user_id'=>Auth::user()->id, 
                'custom_date'=>$request->custom_date, 
                'created_at'=>Carbon::now(), //use Carbon\carbon; 
                'updated_at'=>Carbon::now(), //use Carbon\carbon; 
            ]);

            $datain = datain::orderBy('id', 'desc')->first();   
            $datains_pics = datains_pics::where('in_id',$datain->id)->get();   

            return view('doc_in.view.index', compact('datain','datains_pics')); 

        }

    } 


    public function view($id)
    {         
        $datain = datain::find($id);   
        
        
        $datains_pics = datains_pics::where('in_id',$id)->get();   
         
        return view('doc_in.view.index', compact('datain','datains_pics')); 
    }


    public function pic_store(Request $request,$id)
    {        
        
        $request->validate(
            [  
                'pic_name'=>'required',
                'main_file_path'=>'required|mimes:jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm',
            ],
            [
                'pic_name.required'=>"ກະລຸນາປ້ອນຊື່.",  
                'main_file_path.required'=>"ກະລຸນາເລືອກເອກະສານ.",  
                'main_file_path.mimes'=>'ກະລຸນາປ້ອນ Fileທີ່ມີນາມສະກຸນເປັນ jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm', 
            ]); 

        //ການເຂົ້າລະຫັດຮູບພາບ
        // dd($request->service_name, $request->service_image);
        $service_image = $request->file('main_file_path');
         
        //Generate ຊື່ຮູບພາບ
        $name_gen = hexdec(uniqid());
        
        //ດືງຂໍ້ມູນຈາກຮູບພາບ ນາມສະກຸນ File ແລ້ວເຮັດເປັນໂຕນ້ອຍໝົດໂດຍໃຊ້ strtoLower
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        
        $img_name = $name_gen.'.'.$img_ext;
        
        //upload ແລະ ບັນທຶກຂໍ້ມູນ
        $upload_location = 'image/in/';
        $full_path = $upload_location.$img_name;
        //ທົດລອງອັບໂຫຼດ 
        datains_pics::insert([
                            'in_id'=>$id,
                            'user_id'=>Auth::user()->id,
                            'main_file_path'=>$full_path,
                            'pic_name'=>$request->pic_name, 
                            'created_at'=>Carbon::now(), //use Carbon\carbon; 
                            'updated_at'=>Carbon::now(), //use Carbon\carbon; 
                        ]);

        $service_image->move($upload_location, $img_name); 

        return   redirect()->back();

    }

    //^^ Delete Pic
    public function pic_delete($id)
    { 
        $image = datains_pics::find($id)->main_file_path; 
        
        $delete = datains_pics::find($id)->delete();


        if($image!='')
        {
            unlink($image);   
        } 

        $remember = new remembers; 
        $remember->link_id = $id; 
        $remember->type    = "In";  
        $remember->user_id = Auth::user()->id;
        $remember->object  = "Delete"; 
        $remember->subject = "ລົບຮູບພາບປະກອບ";  
        $remember->save();
 
        return   redirect()->back();
    }



    //^^ Select Edit Doc
    public function edit($id)
    {        
        $datain = datain::find($id);   
        $datains_pics = datains_pics::where('in_id',$id)->get();   
         
        return view('doc_in.view.edit', compact('datain','datains_pics')); 
    }

    //^^ Update In Doc
    public function update(Request $request, $id)
    {        
        
 
        $request->validate(
            [
                'header'=>'required',
                'doc_type_id'=>'required|not_in:0', 
                'main_file_path'=>'mimes:jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm',
            ],
            [
                'header.required'=>"ກະລຸນາປ້ອນຫົວຂໍ້.", 
                'doc_type_id.required'=>'ກະລຸນາເລືອກປະເພດເອກະສານ', 
                'main_file_path.mimes'=>'ກະລຸນາປ້ອນ Fileທີ່ມີນາມສະກຸນເປັນ jpg,jpeg,png,pdf,xlsx,xlsm,docx,docx,dot,dotm', 
            ]); 
   


        // .. ການເຂົ້າລະຫັດຮູບພາບ
        // ..dd($request->service_name, $request->service_image);
        $service_image = $request->file('main_file_path');
         
        
        if($service_image)
        {
            //Terminal only update picture and name
            //Terminal dd("update picture and name");

            
            //Terminal Generate ຊື່ຮູບພາບ
            $name_gen = hexdec(uniqid());
            
            //Terminal ດືງຂໍ້ມູນຈາກຮູບພາບ ນາມສະກຸນ File ແລ້ວເຮັດເປັນໂຕນ້ອຍໝົດໂດຍໃຊ້ strtoLower
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            
            $img_name = $name_gen.'.'.$img_ext;
            
            //Terminal upload ແລະ ບັນທຶກຂໍ້ມູນ
            $upload_location = 'image/in/';
            $full_path = $upload_location.$img_name;
            //Terminal ທົດລອງອັບໂຫຼດ
            datain::find($id)->update([
                                'info'=>$request->info,
                                'doc_number'=>$request->doc_number,
                                'header'=>$request->header,
                                'color'=>$request->color,
                                'main_file_path'=>$full_path,
                                'doc_type_id'=>$request->doc_type_id, 
                                'subject'=>$request->subject,  
                                'updated_at'=>Carbon::now(), //[]use Carbon\carbon;
                            ]);

            $remember = new remembers; 
            $remember->link_id = $id; 
            $remember->type    = "In";  
            $remember->user_id = Auth::user()->id;
            $remember->object  = "Edit"; 
            $remember->subject = "ແກ້ໄຂເອກະສານ ພ້ອມຮູບ : [ " .$request->header . " ]";  
            $remember->save();               
            
            $service_image->move($upload_location, $img_name); 

            //Terminal delete old image
            $old_image = $request->old_image; 
            unlink($old_image); 
            return redirect()->back()->with('success', "ບັນທຶກຂໍ້ມູນຮູບພາບຮຽບຮ້ອຍ"); 
        }
        else
        { 

            //Terminal only update name
            //Terminal  dd("update name");
            //Terminal ທົດລອງອັບໂຫຼດ 
            datain::find($id)->update([
                'info'=>$request->info,
                'doc_number'=>$request->doc_number,
                'header'=>$request->header,
                'color'=>$request->color,
                'doc_type_id'=>$request->doc_type_id, 
                'subject'=>$request->subject,  
                'updated_at'=>Carbon::now(), //[]use Carbon\carbon; 
            ]);  

            $remember = new remembers; 
            $remember->link_id = $id; 
            $remember->type    = "In";  
            $remember->user_id = Auth::user()->id;
            $remember->object  = "Edit"; 
            $remember->subject = "ແກ້ໄຂເອກະສານ ຫົວຂໍ້ : [ " .$request->header . " ]";  
            $remember->save();
            return redirect()->back()->with('success', "ບັນທຶກຂໍ້ມູນຊື່ຮູບພາບຮຽບຮ້ອຍ"); 
        }
 
    }  


    public function delete_doc($id)
    {        
        $image  = datain::find($id)->main_file_path;  


        // if($image!='') { unlink($image); } 

        $header = datain::find($id)->header;  
        $doc_number = datain::find($id)->doc_number;  

        $remember = new remembers; 
        $remember->link_id = $id; 
        $remember->type    = "In";  
        $remember->user_id = Auth::user()->id;
        $remember->object  = "Delete"; 
        $remember->subject = "ລົບເອກະສານ ຫົວຂໍ້ : [ " .$header . " ][ ". $doc_number ."] ";  
        $remember->save();


        $delete = datain::find($id)->delete();
        $delete = datains_pics::where('in_id',$id)->delete();


        $datain =  datain::paginate(20);   
        return view('doc_in.index', compact('datain')); 

    }
    
}
