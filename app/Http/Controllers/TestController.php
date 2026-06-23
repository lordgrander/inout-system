<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
     public function test()
     {
        return view('test.index');
     }


     public function menu()
     {
        return view('test.menu');
     }
}
