<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Brand;

class BrandController extends Controller
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
        $var=Brand::with('category','sector');
            
        return \Datatables::of($var)
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
            $rules=['nama_brand'=>'required|unique:db_m_brand,nama_brand,NULL,id_brand,deleted_at,NULL','category'=>'required','sector'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi gagal',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=new Brand;
                $var->nama_brand=$request->input('nama_brand');
                $var->id_category=$request->input('category');
                $var->id_sector=$request->input('sector');
                $var->insert_user=\Auth::user()->USER_ID;
                $var->update_user=\Auth::user()->USER_ID;
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
            $cat=Category::select('id_category','name_category')
            ->get();

            $sector=Sector::select('id_sector','name_sector')
            ->get();

            $brand=Brand::find($id);

            return array('category'=>$cat,'sector'=>$sector,'brand'=>$brand);
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
            $rules=['nama_brand'=>'required','category'=>'required','sector'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi gagal',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=Brand::find($id);
                $var->nama_brand=$request->input('nama_brand');
                $var->id_category=$request->input('category');
                $var->id_sector=$request->input('sector');
                $var->update_user=\Auth::user()->USER_ID;
                $var->updated_at=Carbon::now();
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
            $var=Brand::find($id);
            $var->delete_user=\Auth::user()->USER_ID;
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

    public function add_new(Request $request){
        if($request->ajax()){
            $cat=Category::select('id_category','name_category')
            ->get();

            $sector=Sector::select('id_sector','name_sector')
            ->get();

            return array('category'=>$cat,'sector'=>$sector);
        }
    }

    public function sample(Request $request){
        $var=Brand::select('nama_brand','id_category','id_sector')
        ->limit(5)
        ->get();
        $category=\App::call('\App\Http\Controllers\MamDashboardController@list_category');
        $sector=\App::call('\App\Http\Controllers\MamDashboardController@list_sector');
        return \Excel::create('brand_new',function($excel) use($var,$category,$sector){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
            $excel->sheet('category',function($sheet) use($category){
                $sheet->fromArray($category);
            });
            $excel->sheet('sector',function($sheet) use($sector){
                $sheet->fromArray($sector);
            });
        })->export('xlsx');
    }

    public function samplelist(Request $request){
        $var=Brand::select('id_brand','nama_brand','id_category','id_sector')
        ->limit(5)
        ->get();
        $category=\App::call('\App\Http\Controllers\MamDashboardController@list_category');
        $sector=\App::call('\App\Http\Controllers\MamDashboardController@list_sector');
        $dataall = \DB::table('db_m_brand as a')->select('a.id_brand','a.nama_brand','a.id_category','a.id_sector','c.name_category','b.name_sector')
        ->leftJoin('db_m_sector as b', 'b.id_sector', '=', 'a.id_sector')
        ->leftJoin('db_m_category as c', 'c.id_category', '=', 'a.id_category')->get();
        $data=array();
        foreach ($dataall as $result){
           $result->id_brand;
           $result->nama_brand;
           $result->id_category;
           $result->id_sector;
           $result->name_category;
           $result->name_sector;
           $data[] = (array)$result;
       }
       return \Excel::create('brand_edit',function($excel) use($var,$category,$sector,$data){
        $excel->sheet('default',function($sheet) use($var){
            $sheet->fromArray($var);
        });
        $excel->sheet('category',function($sheet) use($category){
            $sheet->fromArray($category);
        });
        $excel->sheet('sector',function($sheet) use($sector){
            $sheet->fromArray($sector);
        });
        $excel->sheet('data',function($sheet) use($data){
            $sheet->fromArray($data);
        });
    })->export('xlsx');
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
                    $var=new Brand;
                    $var->nama_brand=$val['nama_brand'];
                    $var->id_category=$val['id_category'];
                    $var->id_sector=$val['id_sector'];
                    $var->insert_user=\Auth::user()->USER_ID;
                    $var->update_user=\Auth::user()->USER_ID;
                    $var->save();
                }
                break;
                case 'update':
                foreach($excels as $key=>$val){
                    $var=Brand::find($val['id_brand']);
                    if($val['nama_brand']!==NULL){
                        $var->nama_brand=$val['nama_brand'];
                    }
                    if($val['id_category']!==NULL){
                        $var->id_category=$val['id_category'];
                    }
                    if($val['id_sector']!==NULL){
                        $var->id_sector=$val['id_sector'];
                    }
                    $var->update_user=\Auth::user()->USER_ID;
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

    public function export(Request $request){
        // $gen=Brand::select('id_brand','nama_brand','id_category','id_sector')
        // ->get();
        $var = \DB::table('db_m_brand as a')->select('a.id_brand','a.nama_brand','a.id_category','a.id_sector','c.name_category','b.name_sector')
            ->leftJoin('db_m_sector as b', 'b.id_sector', '=', 'a.id_sector')
            ->leftJoin('db_m_category as c', 'c.id_category', '=', 'a.id_category')
            ->whereNull('a.deleted_at')
            ->get();
            $data=array();
            foreach ($var as $result){
            $result->id_brand;
            $result->nama_brand;
            $result->id_category;
            $result->id_sector;
            $result->name_category;
            $result->name_sector;
            $data[] = (array)$result;
        }
        return \Excel::create('brand',function($excel) use($data){
            $excel->sheet('brand',function($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }

    public function list_brand(Request $request){
        $var=Brand::select('id_brand as id','nama_brand as text','id_category','id_sector');

        if($request->has('q')){
            $var=$var->where('nama_brand','like','%'.$request->input('q').'%');
        }

        if($request->has('page_limit')){
            $var=$var->paginate($request->input('page_limit'));
        }else{
            $var=$var->get();
        }

        return $var;
    }
}
