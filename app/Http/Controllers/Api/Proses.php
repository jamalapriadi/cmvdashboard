<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Adldap\AdldapInterface;
use DB; 
use Illuminate\Http\Request;



class Proses extends Controller{

    public function list_program(Request $request){

        $prog=\App\Models\Program\Programariana::select('id_program_ariana as id','name as text');

        if($request->has('q')){
            $prog=$prog->where('name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
               $prog=$prog->paginate($request->input('page_limit'));
        }else{
               $prog=$prog->paginate(10);
        }

        return $prog;



    }
    

   
}