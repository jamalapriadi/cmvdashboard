<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Sector;

class SectorController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $sector=Sector::select(
            'sector_id',
            'sector_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        );

        return \DataTables::of($sector)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                $html.="<a href='#' class='btn btn-sm btn-warning editsector' kode='".$query->sector_id."' title='Role'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapussector' kode='".$query->sector_id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'sector'=>'required',
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
            $sector=new Sector;

            $sector->sector_id=$request->input('sector');
            $sector->sector_name=$request->input('name');
            $sector->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function show($id){
        $sector=Sector::find($id);

        return $sector;
    }

    public function update(Request $request,$id){
        $rules=[
            'sector'=>'required',
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
            $sector=Sector::find($id);

            $sector->sector_id=$request->input('sector');
            $sector->sector_name=$request->input('name');
            $sector->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $sector=Sector::find($id);

        $hapus=$sector->delete();

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

            $excels=\Excel::selectSheets('sector')->load($file,function($reader){})->get();
            
            $no=0;

            \DB::transaction(function() use($excels,$no){
                foreach($excels as $key=>$val){
                    $no++;
    
                    $sector=new Sector;
                    $sector->sector_id=$val['sector_id'];
                    $sector->sector_name=$val['sector_name'];
                    $sector->save();
                }
            });

            $data=array(
                'success'=>true,
                'pesan'=>'Berhasil import '.$no.' Data',
                'error'=>''
            );
        }

        return $data;
    }

    public function export(){
        $sector=Sector::select(
            'sector_id',
            'sector_name'
        )->get();

        return \Excel::create('sector',function($excel) use($sector){
                $excel->sheet('sector',function($sheet) use($sector){
                    $sheet->fromArray($sector);
                });
            })->export('xlsx');
    }

    public function sample(){
        $sector=Sector::select(
            'sector_id',
            'sector_name'
        )->limit(5)->get();

        return \Excel::create('sector',function($excel) use($sector){
                $excel->sheet('sector',function($sheet) use($sector){
                    $sheet->fromArray($sector);
                });
            })->export('xlsx');
    }

    public function list_sector(Request $request){
        $sector=Sector::select(
            'sector_id as id',
            'sector_name as text'
        );

        if($request->has('q')){
            $sector=$sector->where('sector_name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $pagelimit=$request->input('page_limit');
        }else{
            $pagelimit=100;
        }

        $sector=$sector->paginate($pagelimit);

        return $sector;
    }
}