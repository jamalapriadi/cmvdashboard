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

    public function sosmed_group(){
        return view('sosmed.group');
    }

    public function sosmed_unit(){
        return view('sosmed.unit');
    }

    public function sosmed_media(){
        return view('sosmed.media');
    }

    public function sosmed_program(){
        return view('sosmed.program');
    }

    public function sosmed_summary_program($id){
        return view('sosmed.summary_program')
            ->with('id',$id);
    }

    public function sosmed_input_report_harian(){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return view('sosmed.input_report_harian')
            ->with('sosmed',$sosmed);
    }

    public function official_and_program(Request $request){
        $group=\App\Models\Sosmed\Groupunit::with(
            [
                'unit',
                'unit.sosmed',
                'unit.sosmed.sosmed',
                'unit.sosmed.followers',
            ]
        )->get();

        return $group;
    }
}
