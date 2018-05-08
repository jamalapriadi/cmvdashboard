<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Ta;

class TargetaudienceController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $ta=Ta::select(
            'ta_id',
            'ta_name',
            \DB::raw('@rownum := @rownum + 1 AS no')
        );

        return \DataTables::of($ta)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='#' class='btn btn-sm btn-warning editta' kode='".$query->ta_id."' title='Edit'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapusta' kode='".$query->ta_id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'idta'=>'required',
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $ta=new Ta;

            $ta->ta_id=$request->input('idta');
            $ta->ta_name=$request->input('name');
            $ta->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );    
        }

        return $data;
    }

    public function show($id){
        $ta=Ta::find($id);
        
        return $ta;
    }

    public function update(Request $request,$id){
        $rules=[
            'idta'=>'required',
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $ta=Ta::find($id);
            $ta->ta_name=$request->input('name');
            $ta->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $ta=Ta::find($id);

        $hapus=$ta->delete();

        if($hapus){
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

    public function list_ta(Request $request){
        $ta=Ta::select('ta_id as id','ta_name as text');

        if($request->has('q')){
            $ta=$ta->where('ta_name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $page=$request->input('page_limit');
        }else{
            $page=30;
        }

        $ta=$ta->paginate($page);

        return $ta;
    }
}