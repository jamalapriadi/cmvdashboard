<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
class AdvertiserController extends Controller
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
        $varre=\App\Models\Brand\Advertiser::with('advertisertype');
        
        return \Datatables::of($varre)
            ->addColumn('type',function($query){
                $html="";
                if($query->advertisertype!=null){
                    $html.=$query->advertisertype->name_advtype;
                }else{
                    $html.="-";
                }
                return $html;
            })
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
            $rules=['nama_adv'=>'required|unique:db_m_advertiser','type'=>'required','group'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data sudah ada',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $var=new \App\Models\Brand\Advertiser;
                $var->nama_adv=$request->input('nama_adv');
                $var->id_typeadv=$request->input('type');
                $var->is_group=$request->input('group');
                $var->created_at=Carbon::now();
                $var->updated_at=Carbon::now();
                $var->insert_user=\Auth::user()->USER_ID;
                $var->update_user=\Auth::user()->USER_ID;
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
            $var=\App\Models\Brand\Advertiser::find($id);

            $type=\App\Models\Brand\Advertisertype::select('id_advtype','name_advtype')
            ->get();

            return array('adv'=>$var,'type'=>$type);
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
            $rules=['nama_adv'=>'required','type'=>'required','group'=>'required'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi error',
                    'error'=>''
                );
            }else{
                $var=\App\Models\Brand\Advertiser::find($id);
                $var->nama_adv=$request->input('nama_adv');
                $var->id_typeadv=$request->input('type');
                $var->is_group=$request->input('group');
                $var->updated_at=Carbon::now();
                $var->update_user=\Auth::user()->USER_ID;

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
            $var=\App\Models\Brand\Advertiser::find($id);
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

    public function list_advertiser_type(Request $request){
        if($request->ajax()){
            $var=\App\Models\Brand\Advertisertype::select('id_advtype','name_advtype')
            ->get();

            return $var;
        }
    }

    public function export(Request $request){
        $var = \DB::table('db_m_advertiser as a')->select('a.id_adv','a.nama_adv','a.id_typeadv','a.id_demography','a.is_group','b.name_advtype','c.name_demography')
        ->leftJoin('db_m_advertiser_type as b', 'b.id_advtype', '=', 'a.id_typeadv')
        ->leftJoin('db_m_demography as c', 'c.id_demography', '=', 'a.id_demography')
        ->whereNull('a.deleted_at')
        ->get();
        $data=array();
        foreach ($var as $result){
           $result->id_adv;
           $result->nama_adv;
           $result->id_typeadv;
           $result->id_demography;
           $result->is_group;
           $result->name_advtype;
           $result->name_demography;
           $data[] = (array)$result;
        }
        return \Excel::create('advertiser',function($excel) use($data){
            $excel->sheet('advertiser',function($sheet) use($data){
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }

    public function sample(Request $request){
        $var=\App\Models\Brand\Advertiser::select('nama_adv','id_typeadv','id_demography','is_group')
        ->limit(5)
        ->get();
    
        $advtype=\App::call('\App\Http\Controllers\MamDashboardController@list_advtype');
        return \Excel::create('advertiser_new',function($excel) use($var,$advtype){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
            $excel->sheet('typeadv',function($sheet) use($advtype){
                $sheet->fromArray($advtype);
            });
        })->export('xlsx');
    }

    public function list_advertiser(Request $request){
        $var=\App\Models\Brand\Advertiser::select(
            'id_adv',
            'nama_adv',
            'id_typeadv',
            'id_demography',
            'is_group'
        )->get();

        return $var;
    }

    public function samplelist(Request $request){
        $var=\App\Models\Brand\Advertiser::select('id_adv','nama_adv','id_typeadv','id_demography','is_group')
            ->limit(5)
            ->get();
        $advtype=\App::call('\App\Http\Controllers\MamDashboardController@list_advtype');
        $dataall = \DB::table('db_m_advertiser as a')->select('a.id_adv','a.nama_adv','a.id_typeadv','a.id_demography','a.is_group','b.name_advtype','c.name_demography')
            ->leftJoin('db_m_advertiser_type as b', 'b.id_advtype', '=', 'a.id_typeadv')
            ->leftJoin('db_m_demography as c', 'c.id_demography', '=', 'a.id_demography')->get();
        $data=array();
        foreach ($dataall as $result){
            $result->id_adv;
            $result->nama_adv;
            $result->id_typeadv;
            $result->id_demography;
            $result->is_group;
            $result->name_advtype;
            $result->name_demography;
            $data[] = (array)$result;
        }
        return \Excel::create('advertiser_edit',function($excel) use($var,$advtype,$data){
            $excel->sheet('default',function($sheet) use($var){
                $sheet->fromArray($var);
            });
            $excel->sheet('typeadv',function($sheet) use($advtype){
                $sheet->fromArray($advtype);
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
                            $var=new \App\Models\Brand\Advertiser;
                            $var->nama_adv=$val['nama_adv'];
                            $var->id_typeadv=$val['id_typeadv'];
                            $var->id_demography=$val['id_demography'];
                            $var->is_group=$val['is_group'];
                            $var->insert_user=\Auth::user()->USER_ID;
                            $var->update_user=\Auth::user()->USER_ID;
                            $var->save();
                        }
                    break;
                    case 'update':
                        foreach($excels as $key=>$val){
                            $var=\App\Models\Brand\Advertiser::find($val['id_adv']);
                            if($val['nama_adv']!==NULL){
                                $var->nama_adv=$val['nama_adv'];
                            }
                            if($val['id_typeadv']!==NULL){
                                $var->id_typeadv=$val['id_typeadv'];
                            }
                            if($val['is_group']!==NULL){
                                $var->is_group=$val['is_group'];
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

    public function add_new_agency(Request $request){
        if($request->ajax()){
            $rules=['name_agency'=>'required|unique:db_m_agency'];

            $validasi=\Validator::make($request->all(),$rules);

            if($validasi->fails()){
                $data=array(
                    'success'=>false,
                    'pesan'=>'Validasi error',
                    'error'=>$validasi->errors()->all()
                );
            }else{
                $ag=new \App\Models\Dashboard\Agency;
                $ag->name_agency=$request->input('name_agency');
                $ag->insert_user=\Auth::user()->USER_ID;
                $ag->update_user=\Auth::user()->USER_ID;
                $ag->created_at=Carbon::now();
                $ag->updated_at=Carbon::now();
                $ag->save();

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>'',
                    'idagency'=>$ag->id_agcy
                );
            }

            return $data;
        }
    }

    public function list_brand_by_advertiser(Request $request){
        $rules=['advertiser'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi errors',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $produk=\App\Models\Brand\Produk::with('brand')
                ->where('id_adv',request('advertiser'))
                ->groupBy('id_brand')
                ->get();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diload',
                'produk'=>$produk
            );
        }

        return $data;
    }
}
