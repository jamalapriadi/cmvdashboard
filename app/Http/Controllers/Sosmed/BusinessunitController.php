<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class BusinessunitController extends Controller
{
    public function index(){
        $var=Businessunit::with('groupunit')->get();

        return $var;
    }

    public function store(Request $request){
        $rules=[
            'name'=>'required',
            'group'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Businessunit;
            $var->group_unit_id=$request->input('group');
            $var->unit_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/group/')) {
                    mkdir('uploads/logo/group/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/group/';
                $file->move($destinationPath,$filename);

                $var->logo=$filename;
            }

            $simpan=$var->save();

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
        $var=Businessunit::find($id);

        return $var;
    }

    public function show($id){
        $var=Businessunit::findOrFail($id);

        return $var;
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required',
            'group'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Businessunit::find($id);
            $var->group_unit_id=$request->input('group');
            $var->unit_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/group/')) {
                    mkdir('uploads/logo/group/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/group/';
                $file->move($destinationPath,$filename);
                
                $var->logo=$filename;
            }

            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupdate',
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
        $var=Businessunit::find($id);

        $hapus=$var->delete();

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
}