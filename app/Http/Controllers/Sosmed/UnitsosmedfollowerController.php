<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Unitsosmedfollower;

class UnitsosmedfollowerController extends Controller
{
    public function index(){
        $var=Unitsosmedfollower::with('unitsosmed')->get();

        return $var;
    }

    public function store(Request $request){
        $rules=[
            'unit'=>'required',
            'tanggal'=>'required',
            'follower'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Unitsosmedfollower;
            $var->unit_sosmed_id=$request->input('unit');
            $var->tanggal=$request->input('tanggal');
            $var->follower=$request->input('follower');

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
        $var=Unitsosmedfollower::find($id);

        return $var;
    }

    public function show($id){
        $var=Unitsosmedfollower::findOrFail($id);

        return $var;
    }

    public function update(Request $request,$id){
        $rules=[
            'unit'=>'required',
            'tanggal'=>'required',
            'follower'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Unitsosmedfollower::find($id);
            $var->unit_sosmed_id=$request->input('unit');
            $var->tanggal=$request->input('tanggal');
            $var->follower=$request->input('follower');

            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil update',
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
        $var=Unitsosmedfollower::find($id);

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