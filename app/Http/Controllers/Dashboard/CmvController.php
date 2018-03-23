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
        $demo=\App\Models\Dashboard\Cmv\Demography::select('id','demo_id','demo_name')
            ->with(
                [
                    'subdemo'
                ]
            )
            ->get();
        $id='A1';
        
        $brand=\App\Models\Dashboard\Cmv\Brand::with(
            [
                'category',
                'category.sector'=>function($q) use($id){
                    $q->where('sector_id',$id);
                },
                'variabel'
            ]
        )->where('category_id','AA1')->paginate(10);

        $sector=\App\Models\Dashboard\Cmv\Sector::select('sector_id','sector_name')->get();

        return view('dashboard.cmv.index')
            ->with('title','CMV')
            ->with('home','Dashboard')
            ->with('demo',$demo)
            ->with('brand',$brand)
            ->with('sector',$sector);
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

    public function variabel(){
        return view('dashboard.cmv.variabel')
            ->with('home','CMV')
            ->with('title','Variabel');
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