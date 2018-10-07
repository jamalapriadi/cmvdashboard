<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
        $category=Category::select('id_category','name_category');
        
        return \Datatables::of($category)
            ->addIndexColumn()
            ->make(true);                      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $rules=['name_category'=>'required|unique:db_m_category'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data sudah ada',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=new Category;
                $var->name_category=$request->input('name_category');
                $var->insert_user=\Auth::auth()->user()->email;
                $var->update_user=\Auth::auth()->user()->email;
                $var->created_at=Carbon::now();
                $var->updated_at=Carbon::now();
                $var->save();

                    $data=array(
                        'success'=>true,
                        'pesan'=>'Data berhasil disimpan',
                        'error'=>''
                    );
                
            }

            return $data;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $var=Category::find($id);

            return $var;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            $rules=['name_category'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi error',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=Category::find($id);
                $var->name_category=$request->input('name_category');
                $var->update_user=\Auth::auth()->user()->email;
                $var->updated_at=Carbon::now();
                $var->save();

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }

            return $data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if($request->ajax()){
            $var=Category::find($id);
            $var->delete_user=\Auth::auth()->user()->email;
            $var->deleted_at=Carbon::now();
            $var->save();

            if($var){
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

    public function import(Request $request){
        if($request->ajax()){
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

                $excels=\Excel::selectSheets('default')->load($file,function($reader){})->get();

                switch($request->input('action')){
                    case 'insert':
                    foreach($excels as $key=>$val){
                        $var=new Category;
                        $var->name_category=$val['name_category'];
                        $var->insert_user=\Auth::auth()->user()->email;
                        $var->update_user=\Auth::auth()->user()->email;
                        $var->save();
                    }
                    break;
                    case 'update':
                    foreach($excels as $key=>$val){
                        $var=Category::find($val['id_category']);
                        if($val['name_category']!==NULL){
                            $var->name_category=$val['name_category'];
                        }
                        $var->update_user=\Auth::auth()->user()->email;
                        $var->save();
                    }
                    break;
                }

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diimport',
                    'error'=>''
                );
            }

            return $data;
        }
    }

    public function sample(Request $request){
        $var=Category::select('name_category')
        ->limit(5)
        ->get();

        return \Excel::create('category_new',function($excel) use($var){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
        })->export('xlsx');
    }

    public function samplelist(Request $request){
        $var=Category::select('id_category','name_category')
        ->limit(5)
        ->get();

        return \Excel::create('category_edit',function($excel) use($var){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
        })->export('xlsx');
    }

    public function export(Request $request){
        $var=Category::select('id_category','name_category')
        ->whereNull('deleted_at')
        ->get();

        return \Excel::create('category',function($excel) use($var){
            $excel->sheet('category',function($sheet) use($var){
                $sheet->fromArray($var);
            });
        })->export('xlsx');
    }
}
