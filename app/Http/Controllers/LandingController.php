<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    

   public function homePage(){
        return view('landing');
    }
   
}
