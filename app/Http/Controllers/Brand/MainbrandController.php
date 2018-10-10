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

    public function advertiser(){
        return view('brand.advertiser');
    }

    public function brand_unit(){
        $sector=\App\Models\Brand\Sector::all();
        $category=\App\Models\Brand\Category::all();

        return view('brand.brand_unit')
            ->with('sector',$sector)
            ->with('category',$category);
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

    public function live_socmed(Request $request){
        $unit=\App\Models\Brand\Brandunit::all();
        $channel=array();
        $activities=array();
        $requnit=request('unit');

        if($request->has('unit')){
            $filter="ada";
            $brand=\App\Models\Brand\Brandunit::with('sosmed')->find(request('unit'));

            foreach($brand->sosmed as $row){
                if($row->sosmed_id==4){
                    $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);
    
                    $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);
                }
            }
        }else{
            $filter="tidak";
            $brand=array();
        }

        $sosmed=\App\Models\Sosmed\Sosmed::all();

        return view('brand.live_socmed')
            ->with('unit',$unit)
            ->with('filter',$filter)
            ->with('brand',$brand)
            ->with('sosmed',$sosmed)
            ->with('youtube',$channel)
            ->with('activity',$activities)
            ->with('requnit',$requnit);
    }

    public function sosmed_input_report(Request $request,$id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();
        $sekarang=date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime('-7 day', strtotime($sekarang)));

        switch($id){
            case 'twitter':
                    
                break;
            case 'facebook':
                    
                break;
            case 'instagram':
                    
                break;
            case 'youtube':
                    
                break;
            default:

                break;
        }

        return view('brand.input_report')
                ->with('sosmed',$sosmed)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin)
                ->with('id',$id);
    }

    public function add_new_report_daily(Request $request,$id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return view('brand.add_new_report_harian')
            ->with('sosmed',$sosmed)
            ->with('id',$id);
    }
}