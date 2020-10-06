<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MainbrandController  extends Controller
{
    public function index(){
        $adv=\App\Models\Brand\Brandunit::select('advertiser_id')
            ->groupBy('advertiser_id')
            ->with('advertiser')
            ->get();
            
        return view('brand.index')
            ->with('adv',$adv);
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

    public function agency(){
        return view('brand.agency');
    }

    public function agency_pintu(){
        return view('brand.agency_pintu');
    }

    public function summary_agency($id)
    {
        $agency=\App\Models\Brand\Agency::with('sosmed','sosmed.sosmed')->find($id);
        $sosmed=\App\Models\Sosmed\Sosmed::all();

        $channel=array();
        $activities=array();
        foreach($agency->sosmed as $row){
            if($row->sosmed_id==4){
                try {
                    // Validate the value...
                    $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);

                    $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);   
                } catch (\Throwable $e) {
                    // report($e);
                    // return $e;
            
                    // return false;
                }            }
        }

        return view('brand.summary_agency')
            ->with('id',$id)
            ->with('agency',$agency)
            ->with('sosmed',$sosmed)
            ->with('youtube',$channel)
            ->with('activity',$activities);
    }

    public function summary_agency_pintu($id)
    {
        $agency=\App\Models\Brand\Agencypintu::with('sosmed','sosmed.sosmed')->find($id);
        $sosmed=\App\Models\Sosmed\Sosmed::all();

        $channel=array();
        $activities=array();
        foreach($agency->sosmed as $row){
            if($row->sosmed_id==4){
                try {
                    // Validate the value...
                    $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);

                    $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);   
                } catch (\Throwable $e) {
                    // report($e);
                    // return $e;
            
                    // return false;
                }
            }
        }

        return view('brand.summary_agency_pintu')
            ->with('id',$id)
            ->with('agency',$agency)
            ->with('sosmed',$sosmed)
            ->with('youtube',$channel)
            ->with('activity',$activities);
    }

    public function brand_unit(){
        $sector=\App\Models\Brand\Sector::all();
        $category=\App\Models\Brand\Category::all();
        $advertiser=\App\Models\Brand\Advertiser::all();

        return view('brand.brand_unit')
            ->with('sector',$sector)
            ->with('category',$category)
            ->with('advertiser',$advertiser);
    }

    public function summary_brand_unit($id){
        $bu=\App\Models\Brand\Brandunit::with('sosmed','sosmed.sosmed')->find($id);
        $sosmed=\App\Models\Sosmed\Sosmed::all();

        $channel=array();
        $activities=array();
        foreach($bu->sosmed as $row){
            if($row->sosmed_id==4){
                
                try {
                    // Validate the value...
                    $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);

                    $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);   
                } catch (\Throwable $e) {
                    // report($e);
                    // return $e;
            
                    // return false;
                }
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
                    try {
                        // Validate the value...
                        $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);
    
                        $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);   
                    } catch (\Throwable $e) {
                        // report($e);
                        // return $e;
                
                        // return false;
                    }
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

        $var=\App\Models\Brand\Brandunit::select('advertiser_id')
            ->groupBy('advertiser_id')
            ->with('advertiser')
            ->get();

        return view('brand.input_report')
                ->with('sosmed',$sosmed)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin)
                ->with('advertiser',$var)
                ->with('id',$id);
    }

    public function add_new_report_daily(Request $request,$id){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        return view('brand.add_new_report_harian')
            ->with('sosmed',$sosmed)
            ->with('id',$id);
    }

    public function list_advertiser(){
        $var=\App\Models\Brand\Brandunit::select('advertiser_id')
            ->groupBy('advertiser_id')
            ->with('advertiser')
            ->get();

        return $var;
    }

    public function remote_data_advertiser(Request $request)
    {
        $var=\App\Models\Brand\Advertiser::with('produk')->select('id_adv as id','nama_adv as text','id_adv');

        if($request->has('q') && $request->input('q')!=null){
            $var=$var->where('nama_adv','like','%'.$request->input('q')['term'].'%');
        }

        if($request->has('produk') && $request->input('produk')!=null){
            $produk=$request->input('produk');

            $var=$var->whereHas('produk',function($q) use($produk){
                $q->where('id_produk',$produk);
            });
        }
        
        if($request->has('brand') && $request->input('brand')!=null){
            $brand=$request->input('brand');

            $var=$var->whereHas('produk',function($q) use($brand){
                $q->where('id_brand',$brand);
            });
        }

        if($request->has('page_limit')){
            $page_limit=$request->input('page_limit');
        }else{
            $page_limit=25;
        }

        $var=$var->paginate($page_limit);

        return $var;
    }

    public function remote_data_brand(Request $request)
    {
        $var=\App\Models\Brand\Brand::with('produk')->select('id_brand','id_brand as id','nama_brand as text')
            ->where('filter',1);

        if($request->has('q') && $request->input('q')!=null){
            $var=$var->where('nama_brand','like','%'.$request->input('q')['term'].'%');
        }

        if($request->has('produk') && $request->input('produk')!=null){
            $produk=$request->input('produk');

            $var=$var->whereHas('produk',function($q) use($produk){
                $q->where('id_produk',$produk);
            });
        }

        if($request->has('advertiser') && $request->input('advertiser')!=null){
            $advertiser=$request->input('advertiser');

            $var=$var->whereHas('produk',function($q) use($advertiser){
                $q->where('id_adv',$advertiser);
            });
        }

        if($request->has('page_limit')){
            $page_limit=$request->input('page_limit');
        }else{
            $page_limit=25;
        }

        $var=$var->paginate($page_limit);

        return $var;
    }

    public function remote_data_produk(Request $request)
    {
        $var=\App\Models\Brand\Produk::select('id_produk as id','nama_produk as text','id_adv');

        if($request->has('q') && $request->input('q')!=null){
            $var=$var->where('nama_produk','like','%'.$request->input('q')['term'].'%');
        }

        if($request->has('advertiser') && $request->input('advertiser')!=null){
            $var=$var->where('id_adv',$request->input('advertiser'));
        }

        if($request->has('page_limit')){
            $page_limit=$request->input('page_limit');
        }else{
            $page_limit=25;
        }

        $var=$var->paginate($page_limit);

        return $var;
    }
}