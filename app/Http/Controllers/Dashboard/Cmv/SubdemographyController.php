<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Subdemography;

class SubdemographyController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $demo=Subdemography::select(
            'id',
            'subdemo_id',
            'demo_id',
            'subdemo_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('demo');

        if($request->has('demo')){
            $demo=$demo->where('demo_id',$request->input('demo'));
        }

        return \DataTables::of($demo)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='#' class='btn btn-sm btn-warning editdemo' kode='".$query->id."' title='Role'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapusdemo' kode='".$query->id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'demo'=>'required',
            'subdemo'=>'required',
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
            $demo=new Subdemography;

            $demo->demo_id=$request->input('demo');
            $demo->subdemo_id=$request->input('subdemo');
            $demo->subdemo_name=$request->input('name');
            $demo->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function edit($id){
        $demo=Subdemography::find($id);

        return $demo;
    }

    public function show($id){
        $demo=Subdemography::with('subdemo')->find($id);

        return $demo;
    }

    public function update(Request $request,$id){
        $rules=[
            'subdemo'=>'required',
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
            $demo=Subdemography::find($id);

            $demo->subdemo_id=$request->input('subdemo');
            $demo->subdemo_name=$request->input('name');
            $demo->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $demo=Subdemography::find($id);

        $hapus=$demo->delete();

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

    public function import(Request $request){
        $rules=['file'=>'required'];
        $pesan=['file.required'=>'Pesan harus diisi'];

        $validasi=\Validator::make($request->all(),$rules,$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $file=$request->file('file');

            $excels=\Excel::selectSheets('subdemo')->load($file,function($reader){})->get();
            
            $no=0;
            foreach($excels as $key=>$val){
                $no++;

                $demo=new Subdemography;
                $demo->subdemo_id=$val['subdemo_id'];
                $demo->demo_id=$val['demo_id'];
                $demo->subdemo_name=$val['subdemo_name'];
                $demo->save();
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Berhasil import '.$no.' Data',
                'error'=>''
            );
        }

        return $data;
    }

    public function export(){
        $demo=Subdemography::select(
            'id',
            'subdemo_id',
            'demo_id',
            'subdemo_name'
        )->get();

        return \Excel::create('subdemo',function($excel) use($demo){
                $excel->sheet('subdemo',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function sample(){
        $demo=Subdemography::select(
            'id',
            'subdemo_id',
            'demo_id',
            'subdemo_name'
        )->limit(5)->get();

        return \Excel::create('subdemo',function($excel) use($demo){
                $excel->sheet('subdemo',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function list_subdemo(){
        $demo=Subdemography::select(
            'subdemo_id',
            'subdemo_name as text'
        )->get();

        return $demo;
    }

    public function list_sub_demo(Request $request){
        $demo=Subdemography::select(
            'subdemo_id as id',
            'subdemo_name as text'
        );

        if($request->has('q')){
            $demo=$demo->where('subdemo_name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $pagelimit=$request->input('page_limit');
        }else{
            $pagelimit=30;
        }

        $demo=$demo->paginate($pagelimit);

        return $demo;
    }
}