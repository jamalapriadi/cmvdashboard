<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

        return view('sosmed.dashboard')
            ->with('group',$group);
    }

    public function role(){
        return view('user.role');
    }

    public function permission($id){
        $role=Role::with('permissions')->find($id);

        return view('user.permission')
            ->with('role',$role);
    }

    public function user(){
        return view('user.user');
    }

    public function user_role(){
        return view('user.user_role');
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
        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
        $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name','group_unit_id')->get();

        return view('sosmed.program')
            ->with('group',$group)
            ->with('unit',$unit);
    }

    public function sosmed_summary_program($id){
        return view('sosmed.summary_program')
            ->with('id',$id);
    }

    public function sosmed_summary_bu($id){
        return view('sosmed.summary_bu')
            ->with('id',$id);
    }

    public function sosmed_input_report_harian(){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return view('sosmed.input_report_harian')
            ->with('sosmed',$sosmed);
    }

    public function add_new_report_harian(){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        $bu=\App\Models\Sosmed\Businessunit::select('id','unit_name')->get();

        return view('sosmed.add_new_report_harian')
            ->with('sosmed',$sosmed)
            ->with('bu',$bu);
    }

    public function sosmed_rangking(){
        return view('sosmed.rangking');
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
