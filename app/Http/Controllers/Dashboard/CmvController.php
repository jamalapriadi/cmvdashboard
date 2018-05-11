<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CmvController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $demo=\App\Models\Dashboard\Cmv\Demography::all();
        
        $brand=\App\Models\Dashboard\Cmv\Brand::all();

        $sector=\App\Models\Dashboard\Cmv\Sector::select('sector_id','sector_name')->get();
        $category=\App\Models\Dashboard\Cmv\Category::all();
        $ta=\App\Models\Dashboard\Cmv\Ta::all();
        $variabel=\App\Models\Dashboard\Cmv\Variabel::all();

        return view('dashboard.cmv.index')
            ->with('title','CMV')
            ->with('home','Dashboard')
            ->with('demo',$demo)
            ->with('brand',$brand)
            ->with('sector',$sector)
            ->with('category',$category)
            ->with('ta',$ta)
            ->with('variabel',$variabel);
    }

    public function sector(){
        return view('dashboard.cmv.sector')
            ->with('title','Sector')
            ->with('home','CMV');
    }

    public function category(){
        return view('dashboard.cmv.category')
            ->with('home','CMV')
            ->with('title','Category');
    }

    public function brand(){
        return view('dashboard.cmv.brand')
            ->with('home','CMV')
            ->with('title','Brand');
    }

    public function demography(){
        return view('dashboard.cmv.demography')
            ->with('home','CMV')
            ->with('title','Demography');
    }

    public function sub_demography($id){
        $demo=\App\Models\Dashboard\Cmv\Demography::find($id);

        return view('dashboard.cmv.sub_demography')
            ->with('home','DEMOGRAPHY')
            ->with('title',$demo->demo_name)
            ->with('demo',$demo);
    }

    public function target_audience(){
        return view('dashboard.cmv.target_audience')
            ->with('home','CMV')
            ->with('title','Target Audience');
    }

    public function variabel(){
        return view('dashboard.cmv.variabel')
            ->with('home','CMV')
            ->with('title','Variabel');
    }

    public function chart_brand(){
        return view('dashboard.cmv.chart.brand')
            ->with('home','CMV')
            ->with('title','Chart');
    }

    public function chart_competitive_map(){
        return view('dashboard.cmv.chart.competitive_map')
            ->with('home','CMV')
            ->with('title','Competitive Map');
    }

    public function chart_by_target_audience(){
        return view('dashboard.cmv.chart.by_target_audience')
            ->with('home','CMV')
            ->with('title','By Target Audience');
    }

    public function import(Request $request){
        $rules=[
            'file'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $file=$request->file('file');

            $excels=\Excel::selectSheets('default')->load($file,function($reader){})->get();

            $data=array();
            foreach($excels as $key=>$val){
                $data[]=array(

                );
            }
        }
    }
}