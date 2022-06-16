<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class giveNumController extends Controller
{
    public function index(){
        return view('give_num.index');
    }
}
