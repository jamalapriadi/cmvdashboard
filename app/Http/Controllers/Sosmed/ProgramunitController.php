<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Programunit;

class ProgramunitController extends Controller
{
    public function index(){
        $var=Programunit::with('businessunit');

        return \Datatables::of($var)->make(true);
    }

    public function store(Request $request){
        $rules=[
            'unit'=>'required',
            'name'=>'required',
            'sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Programunit;
            $var->business_unit_id=$request->input('unit');
            $var->program_name=$request->input('name');

            $simpan=$var->save();

            if($simpan){
                if($request->has('sosmed')){
                    $sosmed=$request->input('sosmed');

                    foreach($sosmed as $key=>$val){
                        $s=new \App\Models\Sosmed\Unitsosmed;
                        $s->type_sosmed="program";
                        $s->business_program_unit=$var->id;
                        $s->sosmed_id=$key;
                        $s->unit_sosmed_name=$val;
                        $s->save();
                    }
                }

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
        $var=Programunit::find($id);

        return $var;
    }

    public function show($id){
        $var=Programunit::with('sosmed')->findOrFail($id);
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        $data=array();
        foreach($sosmed as $key=>$val){
            $nama="";
            for($i=0;$i<count($var['sosmed']);$i++){
                if($var['sosmed'][$i]['id']==$val->id){
                    $nama=$var['sosmed'][$i]['pivot']['unit_sosmed_name'];
                }
            }

            $data[]=array(
                'id'=>$val->id,
                'sosmed_name'=>$val->sosmed_name,
                'name'=>$nama
            );
        }

        return array(
            'program'=>$var,
            'sosmed'=>$data
        );
    }

    public function update(Request $request,$id){
        $rules=[
            'bu'=>'required',
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
            $var=Programunit::find($id);
            $var->business_unit_id=$request->input('bu');
            $var->program_name=$request->input('name');

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
        $var=Programunit::find($id);

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