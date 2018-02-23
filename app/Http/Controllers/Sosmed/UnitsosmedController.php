<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Unitsosmed;

class UnitsosmedController extends Controller
{
    public function index(){
        $var=Unitsosmed::with('sosmed','programunit','businessunit');

        return \Datatable::of($var)->make(true);
    }

    public function store(Request $request){
        $rules=[
            'type'=>'required',
            'program_unit'=>'required',
            'name_sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Unitsosmed;
            $var->type_sosmed=$request->input('type');
            $var->business_program_unit=$request->input('program_unit');
            $var->unit_sosmed_name=$request->input('name_sosmed');

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
        $var=Unitsosmed::find($id);

        return $var;
    }

    public function show($id){
        $var=Unitsosmed::findOrFail($id);

        return $var;
    }

    public function update(Request $request,$id){
        $rules=[
            'type'=>'required',
            'program_unit'=>'required',
            'name_sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Unitsosmed::find($id);
            $var->type_sosmed=$request->input('type');
            $var->business_program_unit=$request->input('program_unit');
            $var->unit_sosmed_name=$request->input('name_sosmed');

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
        $var=Unitsosmed::find($id);

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