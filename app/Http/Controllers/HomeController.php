<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
       // sleep('60');
        return inertia('home');
    }
}
