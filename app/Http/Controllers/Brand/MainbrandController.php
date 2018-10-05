<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MainbrandController  extends Controller
{
    public function index(){
        return view('brand.index');
    }

    public function sector(){
        return view('brand.sector');
    }

    public function category(){
        return view('brand.category');
    }

    public function brand(){
        return view('brand.brand');
    }

    public function produk(){
        return view('brand.produk');
    }

    public function brand_unit(){
        return view('brand.brand_unit');
    }

    public function summary_brand_unit($id){
        $bu=\App\Models\Brand\Brandunit::with('sosmed','sosmed.sosmed')->find($id);
        $sosmed=\App\Models\Sosmed\Sosmed::all();

        $channel=array();
        $activities=array();
        foreach($bu->sosmed as $row){
            if($row->sosmed_id==4){
                $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);

                $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);
            }
        }

        return view('brand.summary_brand_unit')
            ->with('bu',$bu)
            ->with('sosmed',$sosmed)
            ->with('id',$id)
            ->with('youtube',$channel)
            ->with('activity',$activities);
    }

    public function unit_sosmed(){
        return view('brand.unit_sosmed');
    }

    public function unit_sosmed_create(){
        $sosmed=\App\Models\Sosmed\Sosmed::all();
        $brand=\App\Models\Brand\Brand::select('id_brand as id','nama_brand as text','id_category','id_sector')
            ->get();

        return view('brand.unit_sosmed_create')
            ->with('sosmed',$sosmed)
            ->with('brand',$brand);
    }
}