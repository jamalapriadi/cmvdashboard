<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class BusinessunitController extends Controller
{
    public function index(){
        $var=Businessunit::with('groupunit');

        return \Datatables::of($var)->make(true);
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
                if (!is_dir('uploads/logo/bu/')) {
                    mkdir('uploads/logo/bu/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/bu/';
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
                if (!is_dir('uploads/logo/bu/')) {
                    mkdir('uploads/logo/bu/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/bu/';
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

    public function list_unit(){
        $var=Businessunit::select('id','unit_name')->get();

        return $var;
    }
}