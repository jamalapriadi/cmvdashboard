<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Category;

class CategoryController extends Controller
{
    public function index(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $category=Category::select(
            'sector_id',
            'category_id',
            'category_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('sector');

        if($request->has('sector') && $request->input('sector')!=null){
            $category=$category->where('sector_id',$request->input('sector'));
        }

        if($request->has('cari') && $request->input('cari')!=null){
            $cari=$request->input('cari');

            $category=$category->where('category_id',$cari)
                ->orWhere('category_name',$cari);
        }

        $category=$category->paginate(15);

        return view('dashboard.cmv.view.category')
            ->with('category',$category);
    }

    public function store(Request $request){
        $rules=[
            'sector'=>'required',
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
            $category=new Category;

            $category->sector_id=$request->input('sector');
            $category->category_id=$request->input('category');
            $category->category_name=$request->input('name');
            $category->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function show($id){
        $category=Category::with('sector')->find($id);
        $sector=\App\Models\Dashboard\Cmv\Sector::select(
            'sector_id',
            'sector_name as text'
        )->get();

        return array(
            'category'=>$category,
            'sector'=>$sector
        );
    }

    public function update(Request $request,$id){
        $rules=[
            'sector'=>'required',
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
            $category=Category::find($id);

            $category->sector_id=$request->input('sector');
            $category->category_id=$request->input('category');
            $category->category_name=$request->input('name');
            $category->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );    
        }

        return $data;
    }

    public function destroy($id){
        $category=Category::find($id);

        $hapus=$category->delete();

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

            $excels=\Excel::selectSheets('category')->load($file,function($reader){})->get();
            
            $no=0;
            
            \DB::transaction(function() use($excels,$no){
                foreach($excels as $key=>$val){
                    $no++;
    
                    $category=new Category;
                    $category->sector_id=$val['sector_id'];
                    $category->category_id=$val['category_id'];
                    $category->category_name=$val['category_name'];
                    $category->save();
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
        $category=Category::select(
            'category_id',
            'sector_id',
            'category_name'
        )->limit(5)->get();

        return \Excel::create('category',function($excel) use($category){
                $excel->sheet('category',function($sheet) use($category){
                    $sheet->fromArray($category);
                });
            })->export('xlsx');
    }

    public function export(){
        $category=Category::select(
            'category_id',
            'sector_id',
            'category_name'
        )->get();

        return \Excel::create('sector',function($excel) use($category){
                $excel->sheet('sector',function($sheet) use($category){
                    $sheet->fromArray($category);
                });
            })->export('xlsx');
    }

    public function list_category(Request $request){
        $category=Category::select(
            'sector_id',
            'category_id as id',
            'category_name as text'
        );

        if($request->has('sector')){
            $category=$category->where('sector_id',$request->input('sector'));
        }

        if($request->has('q')){
            $category=$category->where('category_name','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $pagelimit=$request->input('page_limit');
        }else{
            $pagelimit=100;
        }

        $category=$category->paginate($pagelimit);

        return $category;
    }

    public function list_category_by_id(Request $request,$id){
        $category=\App\Models\Dashboard\Cmv\Brand::with('category')->find($id);

        return $category;
    }
}