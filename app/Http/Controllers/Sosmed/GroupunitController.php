<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Groupunit;

class GroupunitController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $group=Groupunit::select('id','group_name','insert_user',
            'created_at','updated_at',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        return \Datatables::of($group)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                if(auth()->user()->can('Summary Group')){
                    $html.="<a href='#' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-stats-dots'></i></a>";
                }

                if(auth()->user()->can('Edit Group')){
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                }
                
                if(auth()->user()->can('Delete Group')){
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                }
                
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
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
            $group=new Groupunit;
            $group->group_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/group/')) {
                    mkdir('uploads/logo/group/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/group/';
                $file->move($destinationPath,$filename);

                $group->logo=$filename;
            }

            $simpan=$group->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function edit($id){
        $group=Groupunit::find($id);

        return $group;
    }

    public function show($id){
        $group=Groupunit::findOrFail($id);

        return $group;
    }

    public function update(Request $request,$id){
        $rules=[
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
            $group=Groupunit::find($id);
            $group->group_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/group/')) {
                    mkdir('uploads/logo/group/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/group/';
                $file->move($destinationPath,$filename);
                
                $group->logo=$filename;
            }

            $simpan=$group->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function destroy($id){
        $group=Groupunit::find($id);

        $hapus=$group->delete();

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

    public function list_group(Request $request){
        $group=array();
        $sosmed=array();
        $unit=array();

        if($request->has('group')){
            $group=Groupunit::select('id','group_name')->get();
        }
        
        if($request->has('sosmed')){
            $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        }

        if($request->has('unit')){
            $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name')->get();
        }

        return array(
            'group'=>$group,
            'sosmed'=>$sosmed,
            'unit'=>$unit
        );
    }

    public function import(Request $request){
        $var = \App\Models\Sosmed\Groupunit::select('id','group_name')->get();

        return \Excel::create('group',function($excel) use($var){
            $excel->sheet('sheet1',function($sheet) use($var){
                $sheet->fromArray($var);
            });
        })->export('xlsx');
    }
}