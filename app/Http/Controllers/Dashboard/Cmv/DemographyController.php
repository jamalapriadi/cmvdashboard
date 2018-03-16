<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Demography;

class DemographyController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $demo=Demography::select(
            'id',
            'demo_id',
            'demo_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('subdemo');

        return \DataTables::of($demo)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('mam/cmv/demography/'.$query->id.'/sub')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Role'><i class='icon-gear'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning editdemo' kode='".$query->id."' title='Role'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapusdemo' kode='".$query->id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->addColumn('jumlahsub',function($q){
                return "<label class='label label-info'>".count($q->subdemo)." Sub Demography";
            })
            ->rawColumns(['jumlahsub','action'])
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'demo'=>'required',
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
            $demo=new Demography;

            $demo->demo_id=$request->input('demo');
            $demo->demo_name=$request->input('name');
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
        $demo=Demography::find($id);

        return $demo;
    }

    public function show($id){
        $demo=Demography::with('subdemo')->find($id);

        return $demo;
    }

    public function update(Request $request,$id){
        $rules=[
            'demo'=>'required',
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
            $demo=Demography::find($id);

            $demo->demo_id=$request->input('demo');
            $demo->demo_name=$request->input('name');
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
        $demo=Demography::find($id);

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

            $excels=\Excel::selectSheets('demo')->load($file,function($reader){})->get();
            
            $no=0;
            foreach($excels as $key=>$val){
                $no++;

                $demo=new Demography;
                $demo->demo_id=$val['demo_id'];
                $demo->demo_name=$val['demo_name'];
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
        $demo=Demography::select(
            'id',
            'demo_id',
            'demo_name'
        )->get();

        return \Excel::create('demo',function($excel) use($demo){
                $excel->sheet('demo',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function sample(){
        $demo=Demography::select(
            'id',
            'demo_id',
            'demo_name'
        )->limit(5)->get();

        return \Excel::create('demo',function($excel) use($demo){
                $excel->sheet('demo',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function list_demo(){
        $demo=Demography::select(
            'demo_id',
            'demo_name as text'
        )->get();

        return $demo;
    }
}