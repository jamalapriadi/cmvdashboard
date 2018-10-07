<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
class AdvertisertypeController extends Controller
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
        if($request->ajax()){
            \DB::statement(\DB::raw('set @rownum=0'));
            $genre=\App\Models\Dashboard\Advertisertype::select('db_m_advertiser_type.*',
                \DB::raw('@rownum := @rownum + 1 AS no'));
            
            return \Datatables::of($genre)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id_advtype."' title='Edit'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id_advtype."' title='Delete'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);                        
        }

        return view('mam.dashboard.advertisertype');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if($request->ajax()){
            $var=\App\Models\Dashboard\Advertisertype::find($id);
            $var->update_user=\Auth::user()->USER_ID;
            $var->deleted_at=Carbon::now();
            $var->save();
            if($var){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil dihapus',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal dihapus',
                    'error'=>''
                );
            }

            return $data;
        }
    }
}
