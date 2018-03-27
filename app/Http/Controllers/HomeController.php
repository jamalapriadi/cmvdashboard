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
        if(auth()->user()->can('Read User')){
            return view('user.user');
        }else{
            return view('errors.403');
        }
    }

    public function user_role($id){
        return view('user.user_role')
            ->with('id',$id);
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
        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
        $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name','group_unit_id')->get();
        $sekarang=date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

        return view('sosmed.input_report_harian')
            ->with('sosmed',$sosmed)
            ->with('group',$group)
            ->with('unit',$unit)
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin);
    }

    public function add_new_report_harian($id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        $bu=\App\User::with('unit')->find(auth()->user()->id);

        return view('sosmed.add_new_report_harian')
            ->with('sosmed',$sosmed)
            ->with('bu',$bu)
            ->with('id',$id);
    }

    public function sosmed_rangking(){
        return view('sosmed.rangking');
    }

    public function sosmed_daily_report(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        return view('sosmed.daily_report')
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin);
    }

    public function sosmed_ranking_soc_med(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        return view('sosmed.ranking_soc_med')
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin);
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

    public function sosmed_input_report(Request $request,$id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();
        $user=\App\User::with('unit','unit.groupunit')->find(auth()->user()->id);
        $sekarang=date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

        return view('sosmed.input_report')
            ->with('sosmed',$sosmed)
            ->with('group',$group)
            ->with('user',$user)
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin)
            ->with('id',$id);
    }

    public function change_password(){
        return view('user.change_password');
    }
}
