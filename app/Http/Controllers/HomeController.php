<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function import_data(Request $request){
        $rules=[
            'file'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi gagal",
                'error'=>$validasi->errors()->all()
            );
        }else{
            $file=$request->file('file');

            $excels=\Excel::selectSheets('default')->load($file,function($reader){})->get();

            return (($excels->first())->keys())->toArray();
            
            $pesan=array();
            foreach($excels as $key=>$val){
                $pesan=array(
                    'key'=>$key,
                    'val'=>$val
                );
            }

            $data=array(
                'success'=>true,
                'pesan'=>$pesan,
                'error'=>''
            );
        }

        return $data;
    }
}
