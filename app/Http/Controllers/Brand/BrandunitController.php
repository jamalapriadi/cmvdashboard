<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand\Brandunit;

class BrandunitController extends Controller
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

    public function index(){
        $unit=Brandunit::with('brand');

        return \Datatables::of($unit)
            ->addColumn('action',function($query){
                $html="<div class='btn-group'>";
                $html.="<a href='".\URL::to('brand/brand-unit/'.$query->id.'/summary')."' class='btn btn-sm btn-success' kode='".$query->id."' title='Summary'><i class='icon-gear'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                
                $html.="</div>";

                return $html;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);     
    }

    public function store(Request $request){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Valdiasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $unit=new Brandunit;
            $unit->brand_name_alias=request('name');
            $simpan=$unit->save();

            if($simpan){
                $brand=request('brand');

                foreach($brand as $key=>$val){
                    $unit->brand()->attach($val);
                }
                
                $data=array(
                    'success'=>true,
                    'pesan'=>"Data berhasil disimpan",
                    'errors'=>array()
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>"Data gagal disimpan",
                    'errors'=>array()
                );
            }
        }

        return $data;
    }

    public function show($id){
        $unit=Brandunit::find($id);

        return $unit;
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Valdiasi gagal',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $unit=Brandunit::find($id);
            $unit->brand_name_alias=request('name');
            $unit->save();

            $data=array(
                'success'=>true,
                'pesan'=>"Data berhasil disimpan",
                'errors'=>array()
            );
        }

        return $data;
    }

    public function destroy($id){
        $unit=Brandunit::find($id);

        $hapus=$unit->delete();

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

    public function save_brand_sosmed(Request $request){
        $rules=[
            'id'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
            );
        }else{
            $unit=Brandunit::find(request('id'));

            $brand=request('brand');

            foreach($brand as $key=>$val){
                $unit->brand()->attach($val);
            }

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'errors'=>''
            );
        }

        return $data;
    }

    public function show_list_brand(Request $request,$id){
        $unit=Brandunit::with('brand')->find($id);

        return $unit;
    }

    public function unit_sosmed_by_brand(Request $request,$id){
        $unit=Brandunit::with(
            [
                'sosmed',
                'sosmed.sosmed'
            ]
        )->find($id);

        return $unit;
    }

    public function hapus_related_brand(Request $request,$id){
        $unit=Brandunit::find($id);
        $related=request('related');

        $unit->brand()->detach($related);

        $data=array(
            'success'=>true,
            'pesan'=>'Data berhasil dihapus',
            'error'=>''
        );

        return $data;
    }
}