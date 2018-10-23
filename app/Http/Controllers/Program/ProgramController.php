<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ProgramController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function dashboard_program(){


        return view('program.index');
    }
   
}