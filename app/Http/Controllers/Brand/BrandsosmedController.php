<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Brandsosmed;
use App\Models\Sosmed\Unitsosmed;

class BrandsosmedController extends Controller
{
    public function index(){
        $sosmed=Unitsosmed::with('brand')->where('type_sosmed','brand');

        return \Datatables::of($sosmed)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('brand/sosmed/'.$query->id.'/sub')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Role'><i class='icon-gear'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning editdemo' kode='".$query->id."' title='Role'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapusdemo' kode='".$query->id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->rawColumns(['brand','action'])
            ->addIndexColumn()
            ->make(true);    
    }

    public function store(Request $request){
        $rules=[
            'type'=>'required',
            'brand_unit'=>'required',
            'name_sosmed'=>'required',
            'sosmedid'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $cek=Unitsosmed::where('type_sosmed',$request->input('type'))
                ->where('sosmed_id',$request->input('sosmedid'))
                ->where('business_program_unit',$request->input('brand_unit'))
                ->get();

            if(count($cek)>0){
                return array('success'=>false,'error'=>'Data sosmed ini sudah ada');
            }

            $var=new Unitsosmed;
            $var->type_sosmed=$request->input('type');
            $var->business_program_unit=$request->input('brand_unit');
            $var->unit_sosmed_name=$request->input('name_sosmed');
            $var->sosmed_id=$request->input('sosmedid');

            if($request->input('sosmedid')==4){
                $params = [
                    'q'             => $request->input('account_id'),
                    'part'          => 'id, snippet',
                    'maxResults'    => 1
                ];
                
                // Make intial call. with second argument to reveal page info such as page tokens
                $search = \Youtube::searchAdvanced($params);
                
                $youtube=array();
                
                foreach($search as $key=>$val){
                    $youtube=$val->id->channelId;
                }
        
                $var->unit_sosmed_account_id=$youtube;
            }else{
                $var->unit_sosmed_account_id=$request->input('account_id');
            }
            
            $var->status_active='Y';

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

    public function show(Request $request,$id){
        $var=Unitsosmed::with('brand')->findOrFail($id);

        return $var;
    }

    public function update(Request $request,$id){
        $rules=[
            'type'=>'required',
            'brand_unit'=>'required',
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
            $var->unit_sosmed_name=$request->input('name_sosmed');
            $var->sosmed_id=$request->input('sosmedid');

            if($request->input('sosmedid')==4){
                $params = [
                    'q'             => $request->input('account_id'),
                    'part'          => 'id, snippet',
                    'maxResults'    => 1
                ];
                
                // Make intial call. with second argument to reveal page info such as page tokens
                $search = \Youtube::searchAdvanced($params);
                
                $youtube=array();
                
                foreach($search as $key=>$val){
                    if(isset($val->id->channelId)){
                        $youtube=$val->id->channelId;
                    }else{
                        $youtube=$val->snippet->channelId;
                    }
                }
        
                $var->unit_sosmed_account_id=$youtube;
            }else{
                $var->unit_sosmed_account_id=$request->input('account_id');
            }

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

        // $fl=\App\Models\Sosmed\Unitsosmedfollower::where('unit_sosmed_id',$id)->delete();

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