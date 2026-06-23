<?php

namespace App\Http\Controllers;
Use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {          

        $user =  User::paginate(20);   
        return view('user.index',compact('user')); 
    }
}
