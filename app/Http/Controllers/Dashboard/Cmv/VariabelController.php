<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Variabel;

class VariabelController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $demo=Variabel::select(
            'cmv_variabel.id',
            'cmv_variabel.brand_id',
            'cmv_variabel.subdemo_id',
            'quartal',
            'totals_thousand',
            'totals_ver',
            'cmv_variabel.created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('brand','subdemo');

        if($request->has('cari')){
            $cari=$request->input('cari');
            $demo=$demo->where('brand_id',$cari);
        }

        $demo=$demo->paginate(15);

        return view('dashboard.cmv.view.variabel')
            ->with('demo',$demo);
    }

    public function filter_variabel(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $demo=Variabel::select(
            'cmv_variabel.id',
            'cmv_variabel.brand_id',
            'cmv_variabel.subdemo_id',
            'quartal',
            'totals_thousand',
            'totals_ver',
            'cmv_variabel.created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('brand','subdemo');

        if($request->has('cari')){
            $cari=$request->input('cari');
            $demo=$demo->whereHas('brand',function($q) use($cari){
                $q->where('brand_name','like','%'.$cari.'%');
            });
        }

        $demo=$demo->paginate(15);

        return view('dashboard.cmv.view.variabel')
            ->with('demo',$demo);
    }

    public function store(Request $request){
        $rules=[
            'demo'=>'required',
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
            $demo=new Demography;

            $demo->demo_id=$request->input('demo');
            $demo->demo_name=$request->input('name');
            $demo->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function edit($id){
        $demo=Variabel::with('brand','subdemo')->find($id);

        return $demo;
    }

    public function show($id){
        $demo=Variabel::with('subdemo')->find($id);

        return $demo;
    }

    public function update(Request $request,$id){
        $rules=[
            'demo'=>'required',
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
            $demo=Variabel::find($id);

            $demo->demo_id=$request->input('demo');
            $demo->demo_name=$request->input('name');
            $demo->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $demo=Variabel::find($id);

        $hapus=$demo->delete();

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

    public function import(Request $request){
        $rules=['file'=>'required'];
        $pesan=['file.required'=>'Pesan harus diisi'];

        $validasi=\Validator::make($request->all(),$rules,$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $file=$request->file('file');

            $excels=\Excel::selectSheets('variabel')->load($file,function($reader){})->get();
            
            $no=0;
            foreach($excels as $key=>$val){
                $no++;
                $demo=new Variabel;
                $demo->brand_id=$val['brand_id'];
                $demo->subdemo_id=$val['subdemo_id'];
                $demo->quartal=$val['quartal'];
                $demo->totals_thousand=$val['totals_thousand'];
                $demo->totals_Ver=$val['totals_ver'];
                $demo->save();
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Berhasil import '.$no.' Data',
                'error'=>''
            );
        }

        return $data;
    }

    public function export(){
        $demo=Variabel::select(
            'brand_id',
            'subdemo_id',
            'quartal',
            'totals_thousand',
            'totals_ver'
        )->get();

        return \Excel::create('variabel',function($excel) use($demo){
                $excel->sheet('variabel',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function sample(){
        $demo=Variabel::select(
            'brand_id',
            'subdemo_id',
            'quartal',
            'totals_thousand',
            'totals_ver'
        )->limit(5)->get();

        return \Excel::create('variabel',function($excel) use($demo){
                $excel->sheet('variabel',function($sheet) use($demo){
                    $sheet->fromArray($demo);
                });
            })->export('xlsx');
    }

    public function list_demo(){
        $demo=Variabel::select(
            'demo_id',
            'demo_name as text'
        )->get();

        return $demo;
    }

    public function search(Request $request){
        // return array(
        //     'sector'=>$request->input('sector'),
        //     'category'=>$request->input('category'),
        //     'brand'=>$request->input('brand')
        // );
        $rules=[
            'sector'=>'required',
            'category'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $brand=\App\Models\Dashboard\Cmv\Brand::with('variabel','variabel.demo')
                ->where('brand_id',$request->input('brand'))->first();

            $demo=array();
            $allbrand=array();
            foreach($brand->variabel as $row){
                array_push($demo,$row->demo->demo_name);

                $allbrand[]=array(
                    'id_brand'=>$brand->brand_id,
                    'nama_brand'=>$brand->brand_name,
                    'demo_id'=>$row->demo_id,
                    'demo_name'=>$row->demo->demo_name,
                    'subdemo_id'=>$row->subdemo_id,
                    'subdemo_name'=>$row->subdemo_name,
                    'quartal'=>$row->pivot->quartal,
                    'totals_thousand'=>$row->pivot->totals_thousand,
                    'totals_ver'=>$row->pivot->totals_ver
                );
            }

            $alldemo=array_unique($demo);

            $header=array();
            foreach($alldemo as $key=>$val){
                $sub=array();
                $totals=array();
                $totalthousand=0;
                $subtotalthousand=0;
                for($i=0;$i<count($allbrand);$i++){
                    if($allbrand[$i]['demo_name']==$val){

                        $sub[]=array(
                            'subdemo'=>$allbrand[$i]['subdemo_name'],
                            'total_thousand'=>$allbrand[$i]['totals_thousand'],
                            'total_vertical'=>$allbrand[$i]['totals_ver']
                        );
                        $totals[]=array(
                            $allbrand[$i]['totals_thousand'],$allbrand[$i]['totals_ver']
                        );

                        $subtotalthousand+=$allbrand[$i]['totals_thousand'];
                    }

                    $totalthousand=$subtotalthousand;
                }
                $header[]=array(
                    'demo'=>$val,
                    'subdemo'=>$sub,
                    'persen'=>$totalthousand
                );
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diload',
                'data'=>$header
            );
        }

        return $data;
    }
}