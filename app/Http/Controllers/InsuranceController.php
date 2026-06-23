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


Use App\Models\beta_cars; 
Use App\Models\beta_t_type; 
Use App\Models\beta_insurance; 
Use App\Models\beta_insurance_type;

use Session;

class InsuranceController extends Controller
{
    public function index()
    {
        $beta_insurance_type = beta_insurance_type::all();
        $beta_insurance = beta_insurance::all();
        $beta_t_type = beta_t_type::all();
        $beta_cars = beta_cars::all();
        return view('allow.insurance.index', compact('beta_insurance_type', 'beta_insurance', 'beta_t_type', 'beta_cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number'     => 'required|string|max:20',
            'end_plate_number' => 'nullable|string|max:20',
            't_type_id'        => 'required|integer',
            'engine_number'    => 'required|string|max:50',
            'file_url'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360', // 15MB
            'exp_date' => 'required|date_format:Y-m-d', 
            'insurance_id'      => 'nullable|integer',
            'insurance_type_id' => 'nullable|integer',
        ]);

        // get com_id from current user
        $com_id = DB::table('users')->where('id', Auth::id())->value('com_id');

        // store file
        $path = null;
        if ($request->hasFile('file_url')) {
            // example path: insurance/com_1/user_5/....
            $dum_path = sprintf(
                'insurance/com_%d/user_%d/%s/',
                $com_id,
                Auth::id(),
                now()->format('Y/m/d')
            );
            $path = $request->file('file_url')->store($dum_path, ['disk' => 'my_files']);
            // If you don't have "my_files", use:
            // $path = $request->file('file_url')->store($dum_path, 'public');
        }

        $car = new beta_cars();
        $car->insurance_id = $request->input('insurance_id');          // null ok
        $car->insurance_type_id = $request->input('insurance_type_id'); // null ok
        $car->com_id = $com_id;
        $car->user_id = Auth::id();
        $car->t_type_id = $request->t_type_id;
        $car->plate_number = $request->plate_number;
        $car->end_plate_number = $request->end_plate_number;
        $car->engine_number = $request->engine_number;
        $car->file_url = $path;
        $car->active_at  = Carbon::now('Asia/Bangkok'); // or null if you want
        $car->expired_at = Carbon::createFromFormat('Y-m-d', $request->exp_date, 'Asia/Bangkok')->endOfDay();
        $car->save();

        return response()->json([
            'status' => 200,
            'message' => 'saved',
            'data' => [
                'id' => $car->id,
                'plate_number' => $car->plate_number,
                'file_url' => $car->file_url,
                'created_at' => $car->created_at,
            ]
        ]);
    }
}
