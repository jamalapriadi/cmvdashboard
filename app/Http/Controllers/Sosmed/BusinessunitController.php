<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class BusinessunitController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $var=Businessunit::with('groupunit')
            ->select('id','group_unit_id','unit_name',
            \DB::raw('@rownum := @rownum + 1 AS no'));

        return \Datatables::of($var)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('sosmed/business-unit/'.$query->id.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-stats-dots'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
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

                if($request->has('sosmed')){
                    $sosmed=$request->input('sosmed');

                    foreach($sosmed as $key=>$val){
                        $s=new \App\Models\Sosmed\Unitsosmed;
                        $s->type_sosmed="corporate";
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
        $var=Businessunit::with('sosmed')->find($id);

        return $var;
    }

    public function show($id){
        $var=Businessunit::with('sosmed')->findOrFail($id);
        $group=\App\Models\Sosmed\Groupunit::all();
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return array('unit'=>$var,'group'=>$group,'sosmed'=>$sosmed);
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

                if($request->has('sosmed')){
                    $sosmed=$request->input('sosmed');

                    foreach($sosmed as $key=>$val){
                        $ceksosmed=\App\Models\Sosmed\Unitsosmed::where('sosmed_id',$val)
                            ->where('business_program_unit',$var->id)
                            ->first();
                        
                        if(count($ceksosmed)>0){
                            $s=\App\Models\Sosmed\Unitsosmed::find($ceksosmed->id);
                            $s->type_sosmed="corporate";
                            $s->unit_sosmed_name=$val;
                            $s->save();
                        }else{
                            $s=new \App\Models\Sosmed\Unitsosmed;
                            $s->type_sosmed="corporate";
                            $s->business_program_unit=$var->id;
                            $s->sosmed_id=$key;
                            $s->unit_sosmed_name=$val;
                            $s->save();
                        }
                    }
                }


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
            $s=\App\Models\Sosmed\Unitsosmed::where('type_sosmed','corporate')
                ->where('business_program_unit',$id)
                ->delete();
                
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

    public function list_unit(Request $request){
        $var=Businessunit::select('id','unit_name');

        if($request->has('group')){
            $var=$var->where('group_unit_id',$request->input('group'));
        }

        $var=$var->get();

        return $var;
    }
}