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
Use App\Models\beta_t_type;
Use App\Models\beta_option;
Use App\Models\User;
use Session;

class Sandbox extends Controller
{
    public function index()
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

        $beta_user = DB::select('SELECT * FROM users WHERE is_admin NOT IN ("1") ');
        


        return view('sandbox.index',compact('beta_user'))->with('latestNumber',$latestNumber);
    }

    public function sandbox_clear(REQUEST $request)
    {
        $sand = $request->data;
        if($sand=="clear_all")
        {  
            DB::table('beta_enter')->delete(); 
            DB::table('beta_enter_detail')->delete(); 
            DB::table('beta_feed_back')->delete();  

            $file_data = DB::select("SELECT * FROM beta_enter_file ");
            foreach($file_data as $row)
            {
                $path_name = $row->file_url;
                $path = public_path($path_name);
        
                $delete = beta_enter_file::where('file_id',$row->file_id)->delete(); 

                // Delete the PDF file
                if (File::exists($path)) {
                    File::delete($path);
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


            DB::table('beta_enter_file')->delete(); 
        }
        return response()->json(['message' => $sand]);
    }

    public function sandbox_set_number(Request $request)
    {
        $beta_enter = new beta_enter; 
        $beta_enter->user_id = Auth::user()->id;  
        $beta_enter->enter_number = $request->data;  
        $beta_enter->date_make = date('Y-m-d');   
        $beta_enter->status = "SUCCESS"; 
        $beta_enter->save();
        
        return response()->json(['message' => $request->data]);

    }




    

    public function sandbox_add(Request $request)
    {
        $user_name = $request->user_name;
        $user_phone = $request->user_phone;
        $user_password = $request->user_password;
        $user_select = $request->user_select;

        $password = bcrypt($request->user_password);

        $user = new user; 
        $user->name = $user_name;
        $user->email = $user_phone;
        $user->password = $password;
        $user->is_admin = $user_select;
        $user->save();
        return response()->json(['message' => '']);

    }

    public function sandbox_add_del(Request $request)
    {
        $user_id = $request->data; 
        DB::table('users')->where('id',$user_id)->delete(); 

        return response()->json(['message' => '']);

    }



    public function sandbox_set_form(Request $request)
    { 
        $status = DB::select("SELECT * FROM beta_option WHERE option_id = '1'");
        if($status[0]->print=='old')
        {
            $status = 'new'; 
        }
        else
        {
            $status = 'old';
        }
        beta_option::where('option_id','1')->update([   
            'print' => $status, 
        ]);

        return response()->json(['message' => $status]);

    }

    
}
