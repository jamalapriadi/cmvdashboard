<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Groupunit;

class GroupunitController extends Controller
{
    public function index(){
        $group=Groupunit::all();

        return $group;
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
}