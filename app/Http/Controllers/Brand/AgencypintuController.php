<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
class AgencypintuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
        \DB::statement(\DB::raw('set @rownum=0'));
        $var=\App\Models\Brand\Agencypintu::select('db_m_agencypintu.*',
            \DB::raw('@rownum := @rownum + 1 AS no'));
        
        return \Datatables::of($var)
        ->addColumn('action',function($query){
            $html="<div class='btn-group'>";
            $html.="<a href='".\URL::to('brand/agency-pintu/'.$query->id_agcyptu.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id_agcy."' title='Gear'><i class='icon-gear'></i></a>";
            $html.="</div>";

            return $html;
        })
        ->addColumn('agen',function($q){
            if($q->agency!=null){
                $html=$q->agency->name_agency;
            }else{
                $html="";
            }

            return $html;
        })
        ->addIndexColumn()
        ->rawColumns(['action','agen'])
        ->make(true);  
    }
}