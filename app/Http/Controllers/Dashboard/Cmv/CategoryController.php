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
            'id',
            'sector_id',
            'category_id',
            'category_name',
            'created_at',
            \DB::raw('@rownum := @rownum + 1 AS no')
        )->with('sector');

        return \DataTables::of($category)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                $html.="<a href='#' class='btn btn-sm btn-warning editcategory' kode='".$query->id."' title='Role'><i class='icon-pencil4'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapuscategory' kode='".$query->id."' title='Hapus'><i class='icon-trash'></i></a>";
                $html.="</div>";

                return $html;
            })
            ->make(true);
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
            foreach($excels as $key=>$val){
                $no++;

                $category=new Category;
                $category->sector_id=$val['sector_id'];
                $category->category_id=$val['category_id'];
                $category->category_name=$val['category_name'];
                $category->save();
            }

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
            'id',
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
            'id',
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
            'id',
            'sector_id',
            'category_id',
            'category_name as text'
        );

        if($request->has('sector')){
            $category=$category->where('sector_id',$request->input('sector'));
        }

        $category=$category->get();

        return $category;
    }
}