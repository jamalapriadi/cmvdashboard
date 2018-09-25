<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Insight;

class InsightController extends Controller
{
    public function index(){
        $insight=Insight::with('detail')->get();

        return $insight;
    }

    public function store(Request $request){
        $rules=['title'=>'required','teaser'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi Error",
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $in=new Insight;
            $in->title=$request->input('title');
            $in->teaser=$request->input('teaser');
            $simpan=$in->save();

            if($simpan){
                if($request->hasFile('file')){
                    $file=$request->file('file');
    
                    foreach($file as $key=>$val){
                        if (!is_dir('uploads/insight/'.$in->id)) {
                            mkdir('uploads/insight/'.$in->id, 0777, TRUE);
                        }
    
                        $folder='uploads/insight/'.$in->id."/";
                        $filename=$val->getClientOriginalName();
                        $destinationPath='uploads/insight/'.$in->id."/";
    
                        if($val->move($destinationPath,$filename)){
                            $detail=new \App\Models\Sosmed\Insightdetail;
                            $detail->insight_id=$in->id;
                            $detail->nama_file=$filename;
                            $detail->insert_user=auth()->user()->email;
                            $detail->save();
                        }
                    }
                }

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupload',
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

    public function show($id){
        $in=Insight::with('detail')->find($id);

        return $in;
    }

    public function update(Request $request,$id){
        $rules=['title'=>'required','teaser'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi Error",
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $in=Insight::find($id);
            $in->title=$request->input('title');
            $in->teaser=$request->input('teaser');
            $simpan=$in->save();

            if($simpan){
                if($request->hasFile('file')){
                    $file=$request->file('file');
    
                    foreach($file as $key=>$val){
                        if (!is_dir('uploads/insight/'.$in->id)) {
                            mkdir('uploads/insight/'.$in->id, 0777, TRUE);
                        }
    
                        $folder='uploads/insight/'.$in->id."/";
                        $filename=$val->getClientOriginalName();
                        $destinationPath='uploads/insight/'.$in->id."/";
    
                        if($val->move($destinationPath,$filename)){
                            $detail=new \App\Models\Sosmed\Insightdetail;
                            $detail->insight_id=$in->id;
                            $detail->nama_file=$filename;
                            $detail->insert_user=auth()->user()->email;
                            $detail->save();
                        }
                    }
                }

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupload',
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
        $in=Insight::find($id)->delete();
        $detail=\App\Models\Sosmed\Insightdetail::where('insight_id',$id)->delete();

        $data=array(
            'success'=>true,
            'pesan'=>"Data berhasil dihapus",
            'error'=>array()
        );

        return $data;
    }

    public function delete_detail(Request $request,$id){
        $detail=\App\Models\Sosmed\Insightdetail::find($id);

        $hapus=$detail->delete();

        if($hapus){
            $in=Insight::with('detail')->find($request->input('insight'));

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil dihapus",
                'error'=>array(),
                'insight'=>$in
            );
        }else{
            $data=array(
                'success'=>false,
                'pesan'=>'Data gagal',
                'errors'=>array()
            );
        }

        return $data;
    }
}