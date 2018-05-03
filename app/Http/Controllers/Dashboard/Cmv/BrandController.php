<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Brand;

class BrandController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $brand=Brand::select(
            'brand_id',
            'category_id',
            'brand_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('category');

        if($request->has('category') && $request->input('category')!=null){
            $brand=$brand->where('category_id',$request->input('category'));
        }

        if($request->has('cari') && $request->input('cari')!=null){
            $cari=$request->input('cari');

            $brand=$brand->where('brand_id',$cari)
                ->orWhere('brand_name',$cari);
        }

        $brand=$brand->paginate(15);

        return view('dashboard.cmv.view.brand')
            ->with('brand',$brand);
    }

    public function filter_brand(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $brand=Brand::select(
            'brand_id',
            'category_id',
            'brand_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('category');

        if($request->has('cari') && $request->input('cari')!=null){
            $cari=$request->input('cari');
            $brand=$brand->where('brand_id',$cari)
                ->orWhere('brand_name','like','%'.$cari.'%');
        }

        if($request->has('category') && $request->input('category')!=null){
            $brand=$brand->where('category_id',$request->input('category'));
        }

        $brand=$brand->paginate(15);

        return view('dashboard.cmv.view.brand')
            ->with('brand',$brand);
    }

    public function store(Request $request){
        $rules=[
            'category'=>'required',
            'brand'=>'required',
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
            $brand=new Brand;

            $brand->category_id=$request->input('category');
            $brand->brand_id=$request->input('brand');
            $brand->brand_name=$request->input('name');
            $brand->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function show($id){
        $brand=Brand::with('category')->find($id);
        $category=\App\Models\Dashboard\Cmv\category::select(
            'category_id',
            'category_name as text'
        )->get();

        return array(
            'brand'=>$brand,
            'category'=>$category
        );
    }

    public function update(Request $request,$id){
        $rules=[
            'category'=>'required',
            'brand'=>'required',
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
            $brand=Brand::find($id);

            $brand->category_id=$request->input('category');
            $brand->brand_id=$request->input('brand');
            $brand->brand_name=$request->input('name');
            $brand->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $brand=Brand::find($id);

        $hapus=$brand->delete();

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

            $excels=\Excel::selectSheets('brand')->load($file,function($reader){})->get();
            
            $no=0;

            \DB::transaction(function() use($excels,$no){
                foreach($excels as $key=>$val){
                    $no++;
    
                    $brand=new Brand;
                    $brand->category_id=$val['category_id'];
                    $brand->brand_id=$val['brand_id'];
                    $brand->brand_name=$val['brand_name'];
                    $brand->save();
                }
            });

            $data=array(
                'success'=>true,
                'pesan'=>'Berhasil import '.$no.' Data',
                'error'=>''
            );
        }

        return $data;
    }

    public function sample(){
        $brand=Brand::select(
            'brand_id',
            'category_id',
            'brand_name'
        )->limit(5)->get();

        return \Excel::create('brand',function($excel) use($brand){
                $excel->sheet('brand',function($sheet) use($brand){
                    $sheet->fromArray($brand);
                });
            })->export('xlsx');
    }

    public function export(){
        $brand=Brand::select(
            'brand_id',
            'category_id',
            'brand_name'
        )->get();

        return \Excel::create('brand',function($excel) use($brand){
                $excel->sheet('brand',function($sheet) use($brand){
                    $sheet->fromArray($brand);
                });
            })->export('xlsx');
    }

    public function list_brand(Request $request){
        $brand=Brand::select(
            'brand_id as id',
            'category_id',
            'brand_name as text'
        )->whereNotNull('parent_id');

        if($request->has('category')){
            $brand=$brand->where('category_id',$request->input('category'));
        }

        if($request->has('q')){
            $brand=$brand->where('brand_name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $pagelimit=$request->input('page_limit');
        }else{
            $pagelimit=30;
        }

        $brand=$brand->paginate($pagelimit);

        return $brand;
    }
}