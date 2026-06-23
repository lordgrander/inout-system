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

class AdminInsuranceController extends Controller
{
    public function index()
    {
        $beta_cars = beta_cars::all();
        return view('admin.insurance.index',compact('beta_cars'));
    }
}
