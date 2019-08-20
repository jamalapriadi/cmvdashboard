<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
class AgencyController extends Controller
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
        $var=\App\Models\Brand\Agency::
            with('agencypintu')
            ->select('db_m_agency.*',
            \DB::raw('@rownum := @rownum + 1 AS no'));
        
        return \Datatables::of($var)
        ->addColumn('action',function($query){
            $html="<div class='btn-group'>";
            $html.="<a href='".\URL::to('brand/agency/'.$query->id_agcy.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id_agcy."' title='Gear'><i class='icon-gear'></i></a>";
            $html.="</div>";

            return $html;
        })
        ->addColumn('agen',function($q){
            $html="<ul>";
            foreach($q->agencypintu as $row){
                $html.="<li>".$row->nama_agencypintu."</li>";
            }
            $html.="</ul>";

            return $html;
        })
        ->addIndexColumn()
        ->rawColumns(['action','agen'])
        ->make(true);  
    }
}