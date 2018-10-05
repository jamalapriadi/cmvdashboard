<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Produk;

class ProdukController extends Controller
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
    	$var=Produk::with('category','sector','brand','advertiser');
        
        return \Datatables::of($var)
            ->addIndexColumn()
            ->make(true);                                  
    }

    public function store(Request $request){
        if($request->ajax()){
            $rules=['nama_produk'=>'required|unique:db_m_product','category'=>'required','sector'=>'required','brand'=>'required',
            'advertiser'=>'required','ta'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data sudah ada',
                    'error'=>$validasi->errors()->all()
                );
            }else{

                $var=new Produk;
                $var->nama_produk=$request->input('nama_produk');
                $var->id_category=$request->input('category');
                $var->id_sector=$request->input('sector');
                $var->id_brand=$request->input('brand');
                $var->id_adv=$request->input('advertiser');
                $var->id_ta=$request->input('ta');
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

    public function show(Request $request,$id){
        if($request->ajax()){
            $var=Produk::with('category','brand','advertiser','sector','ta')->find($id);
            return $var;
        }
    }

    public function update(Request $request,$id){
        if($request->ajax()){
            $rules=['nama_produk'=>'required','category'=>'required','sector'=>'required','brand'=>'required',
            'advertiser'=>'required','ta'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi Error',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=Produk::find($id);
                $var->nama_produk=$request->input('nama_produk');
                $var->id_category=$request->input('category');
                $var->id_sector=$request->input('sector');
                $var->id_brand=$request->input('brand');
                $var->id_adv=$request->input('advertiser');
                $var->id_ta=$request->input('ta');
                $var->update_user=\Auth::user()->USER_ID;
                $var->updated_at=Carbon::now();
                $var->save();

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil diupdate',
                    'error'=>''
                );
            }

            return $data;
        }
    }

    public function destroy(Request $request,$id){
        if($request->ajax()){
            $var=Produk::find($id);
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

    public function list_brand(Request $request){
        if($request->ajax()){
            $var=Brand::select('id_brand as id','nama_brand as text');

            if($request->has('q')){
                $var=$var->where('nama_brand','like','%'.$request->input('q').'%');
            }

            $var=$var->get();

            return array('brand'=>$var);
        }
    }

    public function list_advertiser(Request $request){
        if($request->ajax()){
            $var=Advertiser::select('id_adv as id','nama_adv as text');

            if($request->has('q')){
                $var=$var->where('nama_adv','like','%'.$request->input('q').'%');
            }

            $var=$var->get();

            return array('advertiser'=>$var);
        }   
    }

    public function list_category(Request $request){
        if($request->ajax()){
            $var=Category::select('id_category as id','name_category as text');

            if($request->has('q')){
                $var=$var->where('name_category','like','%'.$request->input('q').'%');
            }

            $var=$var->get();

            return array('category'=>$var);
        }   
    }

    public function list_sector(Request $request){
        if($request->ajax()){
            $var=Sector::select('id_sector as id','name_sector as text');

            if($request->has('q')){
                $var=$var->where('name_sector','like','%'.$request->input('q').'%');
            }

            $var=$var->get();

            return array('sector'=>$var);
        }   
    }
    public function list_ta(Request $request){
        if($request->ajax()){
            $var=Targetaudience::select('ID_TA as id','TA_NAME as text')
            ->where('TA','1');

            $var=$var->get();

            return array('ta'=>$var);
        }
    }
    public function sample(Request $request){
        $var=Produk::select('nama_produk','id_category','id_sector','id_brand','id_adv','id_ta')
        ->limit(5)
        ->get();

        $category=\App::call('\App\Http\Controllers\MamDashboardController@list_category');
        $sector=\App::call('\App\Http\Controllers\MamDashboardController@list_sector');
        $brand=\App::call('\App\Http\Controllers\MamDashboardController@list_brand');
        $advertiser=\App::call('\App\Http\Controllers\MamDashboardController@list_advertiser');
        $ta=\App::call('\App\Http\Controllers\MamDashboardController@list_ta');

        return \Excel::create('product_new',function($excel) use($var,$category,$sector,$brand,$advertiser,$ta){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
            $excel->sheet('category',function($sheet) use($category){
                $sheet->fromArray($category);
            });
            $excel->sheet('sector',function($sheet) use($sector){
                $sheet->fromArray($sector);
            });
            $excel->sheet('brand',function($sheet) use($brand){
                $sheet->fromArray($brand);
            });
            $excel->sheet('advertiser',function($sheet) use($advertiser){
                $sheet->fromArray($advertiser);
            });
            $excel->sheet('ta',function($sheet) use($ta){
                $sheet->fromArray($ta);
            });
        })->export('xlsx');
    }

    public function samplelist(Request $request){
        $var=Produk::select('id_produk','nama_produk','id_category','id_sector','id_brand','id_adv','id_ta')
        ->limit(5)
        ->get();
        $category=\App::call('\App\Http\Controllers\MamDashboardController@list_category');
        $sector=\App::call('\App\Http\Controllers\MamDashboardController@list_sector');
        $brand=\App::call('\App\Http\Controllers\MamDashboardController@list_brand');
        $advertiser=\App::call('\App\Http\Controllers\MamDashboardController@list_advertiser');
        $ta=\App::call('\App\Http\Controllers\MamDashboardController@list_ta');
        $dataall = \DB::table('db_m_product as a')->select('a.id_produk', 'a.nama_produk', 'a.id_category', 'a.id_sector', 'a.id_brand', 'a.id_adv', 'a.id_ta', 'e.name_category', 'd.name_sector', 'b.nama_brand', 'c.nama_adv', 'f.TA_NAME')
        ->leftJoin('db_m_brand as b', 'b.id_brand', '=', 'a.id_brand')
        ->leftJoin('db_m_advertiser as c', 'c.id_adv', '=', 'a.id_adv')
        ->leftJoin('db_m_sector as d', 'd.id_sector', '=', 'a.id_sector')
        ->leftJoin('db_m_category as e', 'e.id_category', '=', 'a.id_category')
        ->leftJoin('tbl_target_audience as f', 'f.ID_TA', '=', 'a.id_ta')->get();
        $data=array();
        foreach ($dataall as $result){
           $result->id_produk;
           $result->nama_produk;
           $result->id_category;
           $result->id_sector;
           $result->id_brand;
           $result->id_adv;
           $result->id_ta;
           $result->name_category;
           $result->name_sector;
           $result->nama_brand;
           $result->nama_adv;
           $result->TA_NAME;
           $data[] = (array)$result;
       }
        return \Excel::create('product_edit',function($excel) use($var,$category,$sector,$brand,$advertiser,$ta,$data){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
            $excel->sheet('category',function($sheet) use($category){
                $sheet->fromArray($category);
            });
            $excel->sheet('sector',function($sheet) use($sector){
                $sheet->fromArray($sector);
            });
            $excel->sheet('brand',function($sheet) use($brand){
                $sheet->fromArray($brand);
            });
            $excel->sheet('advertiser',function($sheet) use($advertiser){
                $sheet->fromArray($advertiser);
            });
            $excel->sheet('ta',function($sheet) use($ta){
                $sheet->fromArray($ta);
            });
            $excel->sheet('data',function($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }

    public function export(Request $request){
        $var = \DB::table('db_m_product as a')->select('a.id_produk', 'a.nama_produk', 'a.id_category', 'a.id_sector', 'a.id_brand', 'a.id_adv', 'a.id_ta', 'e.name_category', 'd.name_sector', 'b.nama_brand', 'c.nama_adv', 'f.TA_NAME')
        ->leftJoin('db_m_brand as b', 'b.id_brand', '=', 'a.id_brand')
        ->leftJoin('db_m_advertiser as c', 'c.id_adv', '=', 'a.id_adv')
        ->leftJoin('db_m_sector as d', 'd.id_sector', '=', 'a.id_sector')
        ->leftJoin('db_m_category as e', 'e.id_category', '=', 'a.id_category')
        ->leftJoin('tbl_target_audience as f', 'f.ID_TA', '=', 'a.id_ta')
        ->whereNull('a.deleted_at')
        ->get();
        $data=array();
        foreach ($var as $result){
           $result->id_produk;
           $result->nama_produk;
           $result->id_category;
           $result->id_sector;
           $result->id_brand;
           $result->id_adv;
           $result->id_ta;
           $result->name_category;
           $result->name_sector;
           $result->nama_brand;
           $result->nama_adv;
           $result->TA_NAME;
           $data[] = (array)$result;
       }
       return \Excel::create('produk',function($excel) use($data){
        $excel->sheet('produk',function($sheet) use($data){
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
                    $var=new Produk;
                    $var->nama_produk=$val['nama_produk'];
                    $var->id_category=$val['id_category'];
                    $var->id_sector=$val['id_sector'];
                    $var->id_brand=$val['id_brand'];
                    $var->id_adv=$val['id_adv'];
                    $var->id_ta=$val['id_ta'];
                    $var->insert_user=\Auth::user()->USER_ID;
                    $var->update_user=\Auth::user()->USER_ID;
                    $var->save();

                }
                break;
                case 'update':
                foreach($excels as $key=>$val){
                    $var=Produk::find($val['id_produk']);
                    if($val['nama_produk']!==NULL){
                        $var->nama_produk=$val['nama_produk'];
                    }
                    if($val['id_category']!==NULL){
                        $var->id_category=$val['id_category'];
                    }
                    if($val['id_sector']!==NULL){
                        $var->id_sector=$val['id_sector'];
                    }
                    if($val['id_brand']!==NULL){
                        $var->id_brand=$val['id_brand'];
                    }
                    if($val['id_adv']!==NULL){
                        $var->id_adv=$val['id_adv'];
                    }
                    if($val['id_ta']!==NULL){
                        $var->id_ta=$val['id_ta'];
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

public function add_new_brand(Request $request){
    if($request->ajax()){
        $rules=['nama_brand'=>'required|unique:db_m_brand,nama_brand,NULL,id_brand,deleted_at,NULL','category'=>'required','sector'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Data sudah ada',
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
            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>'',
                    'id_brand'=>$var->id_brand,
                    'nama_brand'=>$request->input('nama')
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

public function add_new_advertiser(Request $request){
    if($request->ajax()){
        $rules=['nama_adv'=>'required|unique:db_m_advertiser','type'=>'required','group'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Advertiser;
            $var->nama_adv=$request->input('nama_adv');
            $var->id_typeadv=$request->input('type');
            $var->is_group=$request->input('group');
            $var->insert_user=\Auth::user()->USER_ID;
            $var->update_user=\Auth::user()->USER_ID;
            $var->created_at=Carbon::now();
            $var->updated_at=Carbon::now();
            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>'',
                    'id_advertiser'=>$var->id_adv,
                    'nama_adv'=>$request->input('nama')
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

public function list_produk(Request $request){
    if($request->ajax()){
        $p=Produk::select('id_produk as id','nama_produk as text');

        if($request->has('q')){
            $p=$p->where('nama_produk','like','%'.$request->input('q').'%');
        }else{
            $p=$p->limit(100);
        }
        
        $p=$p->get();

        return array('produk'=>$p);
    }
}
}