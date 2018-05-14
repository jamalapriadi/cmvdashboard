<?php

namespace App\Http\Controllers\Dashboard\Cmv;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Dashboard\Cmv\Brand;

class ReportController extends Controller
{
    public function filter_demography(Request $request){
        $rules=[
            'quartal'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $response=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $reqbrand=$request->input('brand');
            $reqquartal=$request->input('quartal');

            $allbrand=\DB::connection('mysql3')
                ->table('cmv_brand as a')
                ->leftJoin('cmv_variabel as b','b.brand_id','=','a.brand_id')
                ->leftJoin('cmv_sub_demography as c','c.subdemo_id','=','b.subdemo_id')
                ->leftJoin('cmv_demography as d','d.demo_id','=','c.demo_id')
                ->where('a.brand_id',$reqbrand)
                ->where('b.quartal',$reqquartal)
                ->select('a.brand_id','a.brand_name','d.demo_id','d.demo_name',
                'b.subdemo_id','c.subdemo_name','b.quartal','b.totals_thousand','b.totals_ver')
                ->get();
            
            $masterDemo=\DB::connection('mysql3')
                ->select("select demo_id, demo_name from cmv_demography");

            $masterSubDemo=\DB::connection('mysql3')
                ->select("select subdemo_id,demo_id,subdemo_name from cmv_sub_demography");

            $demo=array();
            foreach($allbrand as $d){
                $demo[]=$d->demo_id;
            }

            $alldemo=array_unique($demo);

            $data=array();
            foreach($allbrand as $row){
                $demography=array();
                foreach($alldemo as $key=>$val){
                    $demoname="";
                    $subdemo=array();

                    for($a=0;$a<count($masterDemo);$a++){
                        if($masterDemo[$a]->demo_id==$val){
                            $demoname=$masterDemo[$a]->demo_name;

                            for($b=0;$b<count($masterSubDemo);$b++){
                                if($masterSubDemo[$b]->demo_id==$masterDemo[$a]->demo_id){
                                    $variabel=array();

                                    for($c=0;$c<count($allbrand);$c++){
                                        if($allbrand[$c]->subdemo_id==$masterSubDemo[$b]->subdemo_id && $allbrand[$c]->brand_id==$row->brand_id){
                                            $variabel=array(
                                                'totals_thousand'=>$allbrand[$c]->totals_thousand,
                                                'totals_ver'=>$allbrand[$c]->totals_ver
                                            );
                                        }
                                    }

                                    $subdemo[]=array(
                                        'subdemo_id'=>$masterSubDemo[$b]->subdemo_id,
                                        'subdemo_name'=>$masterSubDemo[$b]->subdemo_name,
                                        'variabel'=>$variabel
                                    );
                                }
                            }
                        }
                    }
                    $demography[]=array(
                        'demo_id'=>$val,
                        'demo_name'=>$demoname,
                        'subdemo'=>$subdemo
                    );
                }
                $data=array(
                    'id'=>$row->brand_id,
                    'brand_name'=>$row->brand_name,
                    'demography'=>$demography
                );
            }

            return view('dashboard.cmv.view.filter_by_brand')
                ->with('data',$data);
        }
    }

    public function filter_demography_by_ta(Request $request){
        $rules=[
            'quartal'=>'required',
            'ta'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $response=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
            return $response;
        }else{
            $reqbrand=$request->input('ta');
            $reqquartal=$request->input('quartal');

            $allbrand=\DB::connection('mysql3')
                ->table('cmv_target_audience as a')
                ->leftJoin('cmv_variabel_target_audience as b','b.ta_id','=','a.ta_id')
                ->leftJoin('cmv_sub_demography as c','c.subdemo_id','=','b.subdemo_id')
                ->leftJoin('cmv_demography as d','d.demo_id','=','c.demo_id')
                ->where('a.ta_id',$reqbrand)
                ->where('b.quartal',$reqquartal)
                ->select('a.ta_id','a.ta_name','d.demo_id','d.demo_name',
                'b.subdemo_id','c.subdemo_name','b.quartal','b.totals_thousand','b.totals_ver')
                ->get();
            
            $masterDemo=\DB::connection('mysql3')
                ->select("select demo_id, demo_name from cmv_demography");

            $masterSubDemo=\DB::connection('mysql3')
                ->select("select subdemo_id,demo_id,subdemo_name from cmv_sub_demography");

            $demo=array();
            foreach($allbrand as $d){
                $demo[]=$d->demo_id;
            }

            $alldemo=array_unique($demo);

            $data=array();
            foreach($allbrand as $row){
                $demography=array();
                foreach($alldemo as $key=>$val){
                    $demoname="";
                    $subdemo=array();

                    for($a=0;$a<count($masterDemo);$a++){
                        if($masterDemo[$a]->demo_id==$val){
                            $demoname=$masterDemo[$a]->demo_name;

                            for($b=0;$b<count($masterSubDemo);$b++){
                                if($masterSubDemo[$b]->demo_id==$masterDemo[$a]->demo_id){
                                    $variabel=array();

                                    for($c=0;$c<count($allbrand);$c++){
                                        if($allbrand[$c]->subdemo_id==$masterSubDemo[$b]->subdemo_id && $allbrand[$c]->ta_id==$row->ta_id){
                                            $variabel=array(
                                                'totals_thousand'=>$allbrand[$c]->totals_thousand,
                                                'totals_ver'=>$allbrand[$c]->totals_ver
                                            );
                                        }
                                    }

                                    $subdemo[]=array(
                                        'subdemo_id'=>$masterSubDemo[$b]->subdemo_id,
                                        'subdemo_name'=>$masterSubDemo[$b]->subdemo_name,
                                        'variabel'=>$variabel
                                    );
                                }
                            }
                        }
                    }
                    $demography[]=array(
                        'demo_id'=>$val,
                        'demo_name'=>$demoname,
                        'subdemo'=>$subdemo
                    );
                }
                $data=array(
                    'id'=>$row->ta_id,
                    'brand_name'=>$row->ta_name,
                    'demography'=>$demography
                );
            }

            return view('dashboard.cmv.view.filter_by_brand')
                ->with('data',$data);
        }
    }

    public function top_brand_by_category(Request $request){
        $reqbrand=$request->input('brand');
        $reqquartal=$request->input('quartal');

        $brand=\App\Models\Dashboard\Cmv\Brand::with('category')->find($reqbrand);
        
        $category=$brand->category_id;

        $allbrand=\DB::connection('mysql3')
            ->table('cmv_brand as a')
            ->leftJoin('cmv_variabel as b','b.brand_id','=','a.brand_id')
            ->leftJoin('cmv_sub_demography as c','c.subdemo_id','=','b.subdemo_id')
            ->where('c.demo_id','D0')
            ->where('parent_id',$brand->parent_id)
            ->orderBy('totals_ver','desc')
            ->select(
                'parent_id',
                'b.brand_id',
                'category_id',
                'brand_name',
                'quartal',
                'totals_ver',
                'totals_thousand',
                'demo_id',
                'subdemo_name'
            )
            ->orderBy('b.totals_thousand','desc')
            ->get();

        return array('allbrand'=>$allbrand,'brand'=>$brand);
    }

    public function competitive_map(Request $request){
        $reqbrand=$request->input('brand');
        $listcompare=array();

        $brand=\App\Models\Dashboard\Cmv\Brand::with('variabel')->find($reqbrand);
        $parent=\App\Models\Dashboard\Cmv\Brand::with('variabel')->find($brand->parent_id);

        if($request->has('compare')){
            $compare=$request->input('compare');
            $pecahbrand=explode(",",$compare);
            if(count($pecahbrand)){
                foreach($pecahbrand as $key=>$val){
                    array_push($listcompare,$val);
                }
            }

            $br=\App\Models\Dashboard\Cmv\Brand::with('variabel')->whereIn('brand_id',$listcompare)->get();
        }

        return array('parent'=>$parent,'brand'=>$brand,'compare'=>$br);
    }

    public function compare_product(Request $request){
        $reqbrand=$request->input('brand');
        $listcompare=array();

        $brand=\App\Models\Dashboard\Cmv\Brand::with('variabel')->find($reqbrand);
        $parent=\App\Models\Dashboard\Cmv\Brand::with('variabel')->find($brand->parent_id);

        return array('parent'=>$parent,'brand'=>$brand);
    }

    public function compare_with(Request $request){
        $rules=['compare'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $reqbrand=$request->input('brand');
            $listcompare=array();

            $compare=$request->input('compare');
            $pecahbrand=explode(",",$compare);
            if(count($pecahbrand)){
                foreach($pecahbrand as $key=>$val){
                    array_push($listcompare,$val);
                }
            }

            $br=\App\Models\Dashboard\Cmv\Brand::with('variabel')->whereIn('brand_id',$listcompare)->get();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diload',
                'data'=>$br
            );
        }

        return $data;
    }

    public function chart_all_data(Request $request){
        $rules=[
            'quartal'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $response=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );

            return $response;
        }else{
            $reqbrand=$request->input('brand');
            $reqquartal=$request->input('quartal');
            
            $allbrand=\DB::connection('mysql3')
                ->select("select a.brand_id, a.brand_name,d.demo_id,d.demo_name,b.subdemo_id,
                c.subdemo_name ,b.quartal, b.totals_thousand, b.totals_ver from cmv_brand a 
                left join cmv_variabel as b on b.brand_id=a.brand_id
                left join cmv_sub_demography as c on c.subdemo_id=b.subdemo_id
                left join cmv_demography as d on d.demo_id=c.demo_id
                where a.brand_id='$reqbrand'
                and b.quartal='$reqquartal'");

            return $allbrand;
        }
    }

    public function all_brand(Request $request){
        $rules=[
            'quartal'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $response=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
            return $response;
        }else{
            $reqbrand=$request->input('brand');
            $reqquartal=$request->input('quartal');

            $allbrand=\DB::connection('mysql3')
                ->select("select a.brand_id, a.brand_name,d.demo_id,d.demo_name,b.subdemo_id,
                c.subdemo_name ,b.quartal, b.totals_thousand, b.totals_ver 
                from cmv_brand a 
                left join cmv_variabel as b on b.brand_id=a.brand_id
                left join cmv_sub_demography as c on c.subdemo_id=b.subdemo_id
                left join cmv_demography as d on d.demo_id=c.demo_id
                where b.quartal='$reqquartal' where a.brand_id='$reqbrand'");
            
            $masterDemo=\DB::connection('mysql3')
                ->select("select demo_id, demo_name from cmv_demography");

            $masterSubDemo=\DB::connection('mysql3')
                ->select("select subdemo_id,demo_id,subdemo_name from cmv_sub_demography");

            $demo=array();
            foreach($allbrand as $d){
                $demo[]=$d->demo_id;
            }

            $alldemo=array_unique($demo);

            $data=array();
            foreach($allbrand as $row){
                $demography=array();
                foreach($alldemo as $key=>$val){
                    $demoname="";
                    $subdemo=array();

                    for($a=0;$a<count($masterDemo);$a++){
                        if($masterDemo[$a]->demo_id==$val){
                            $demoname=$masterDemo[$a]->demo_name;

                            for($b=0;$b<count($masterSubDemo);$b++){
                                if($masterSubDemo[$b]->demo_id==$masterDemo[$a]->demo_id){
                                    $variabel=array();

                                    for($c=0;$c<count($allbrand);$c++){
                                        if($allbrand[$c]->subdemo_id==$masterSubDemo[$b]->subdemo_id && $allbrand[$c]->brand_id==$row->brand_id){
                                            $variabel=array(
                                                'totals_thousand'=>$allbrand[$c]->totals_thousand,
                                                'totals_ver'=>$allbrand[$c]->totals_ver
                                            );
                                        }
                                    }

                                    $subdemo[]=array(
                                        'subdemo_id'=>$masterSubDemo[$b]->subdemo_id,
                                        'subdemo_name'=>$masterSubDemo[$b]->subdemo_name,
                                        'variabel'=>$variabel
                                    );
                                }
                            }
                        }
                    }
                    $demography[]=array(
                        'demo_id'=>$val,
                        'demo_name'=>$demoname,
                        'subdemo'=>$subdemo
                    );
                }
                $data=array(
                    'id'=>$row->brand_id,
                    'brand_name'=>$row->brand_name,
                    'demography'=>$demography
                );
            }

            return view('dashboard.cmv.view.filter_by_brand')
                ->with('data',$data);
        }
    }

    public function all_data_by_ta(Request $request){
        $rules=[
            'quartal'=>'required',
            'brand'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $response=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );

            return $response;
        }else{
            $reqbrand=$request->input('brand');
            $reqquartal=$request->input('quartal');
            
            $allbrand=\DB::connection('mysql3')
                ->select("select a.ta_id, a.ta_name,d.demo_id,d.demo_name,b.subdemo_id,
                c.subdemo_name ,b.quartal, b.totals_thousand, b.totals_ver 
                from cmv_target_audience a 
                left join cmv_variabel_target_audience as b on b.ta_id=a.ta_id
                left join cmv_sub_demography as c on c.subdemo_id=b.subdemo_id
                left join cmv_demography as d on d.demo_id=c.demo_id
                where a.ta_id='$reqbrand'
                and b.quartal='$reqquartal'");

            return $allbrand;
        }
    }

    public function day_part(Request $request){
        // SELECT a.brand_id, a.brand_name, c.subdemo_name,
        // sum(if(b.subdemo_id='DD215' or b.subdemo_id='DD216' or b.subdemo_id='DD217',b.totals_thousand,0)) as '02:00 TO 06:59',
        // sum(if(b.subdemo_id='DD218' or b.subdemo_id='DD219' or b.subdemo_id='DD220',b.totals_thousand,0)) as '07:00 TO 08:59',
        // sum(if(b.subdemo_id='DD221' or b.subdemo_id='DD222' or b.subdemo_id='DD223',b.totals_thousand,0)) as '09:00 TO 11:59',
        // sum(if(b.subdemo_id='DD224' or b.subdemo_id='DD225' or b.subdemo_id='DD226',b.totals_thousand,0)) as '12:00 TO 13:59',
        // sum(if(b.subdemo_id='DD227' or b.subdemo_id='DD228' or b.subdemo_id='DD229',b.totals_thousand,0)) as '14:00 TO 17:59',
        // sum(if(b.subdemo_id='DD230' or b.subdemo_id='DD231' or b.subdemo_id='DD232',b.totals_thousand,0)) as '18:00 TO 19:59',
        // sum(if(b.subdemo_id='DD233' or b.subdemo_id='DD234' or b.subdemo_id='DD235',b.totals_thousand,0)) as '20:00 TO 21:59',
        // sum(if(b.subdemo_id='DD236' or b.subdemo_id='DD237' or b.subdemo_id='DD238',b.totals_thousand,0)) as '22:00 TO 23:59',
        // sum(if(b.subdemo_id='DD239' or b.subdemo_id='DD240' or b.subdemo_id='DD241',b.totals_thousand,0)) as '24:00 TO 25:59'
        // from cmv_brand a
        // left join cmv_variabel b on b.brand_id=a.brand_id
        // left join cmv_sub_demography c on c.subdemo_id=b.subdemo_id
        // left join cmv_demography d on d.demo_id=c.demo_id
        // where a.brand_id='B686'
        // and c.demo_id in ('D23','D24','D25','D26','D27','D28','D29','D30','D31')
        // group by a.brand_id, c.subdemo_name
        $rules=['brand'=>'required','quartal'=>'required'];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi Errors',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $brand=$request->input('brand');
            $quartal=$request->input('quartal');

            $day=\DB::connection('mysql3')->Table('cmv_brand as a')
                ->leftJoin('cmv_variabel as b','b.brand_id','=','a.brand_id')
                ->leftJoin('cmv_sub_demography as c','c.subdemo_id','=','b.subdemo_id')
                ->leftJoin('cmv_demography as d','d.demo_id','=','c.demo_id')
                ->where('a.brand_id',$brand)
                ->where('b.quartal',$quartal)
                ->whereIn('c.demo_id',['D23','D24','D25','D26','D27','D28','D29','D30','D31'])
                ->groupBy('a.brand_id','c.subdemo_name')
                ->select(
                    'a.brand_id', 'a.brand_name', 'c.subdemo_name',
                    \DB::raw("sum(if(b.subdemo_id='DD215' or b.subdemo_id='DD216' or b.subdemo_id='DD217',b.totals_thousand,0)) as 'pertama'"),
                    \DB::raw("sum(if(b.subdemo_id='DD218' or b.subdemo_id='DD219' or b.subdemo_id='DD220',b.totals_thousand,0)) as 'kedua'"),
                    \DB::raw("sum(if(b.subdemo_id='DD221' or b.subdemo_id='DD222' or b.subdemo_id='DD223',b.totals_thousand,0)) as 'ketiga'"),
                    \DB::raw("sum(if(b.subdemo_id='DD224' or b.subdemo_id='DD225' or b.subdemo_id='DD226',b.totals_thousand,0)) as 'keempat'"),
                    \DB::raw("sum(if(b.subdemo_id='DD227' or b.subdemo_id='DD228' or b.subdemo_id='DD229',b.totals_thousand,0)) as 'kelima'"),
                    \DB::raw("sum(if(b.subdemo_id='DD230' or b.subdemo_id='DD231' or b.subdemo_id='DD232',b.totals_thousand,0)) as 'keenam'"),
                    \DB::raw("sum(if(b.subdemo_id='DD233' or b.subdemo_id='DD234' or b.subdemo_id='DD235',b.totals_thousand,0)) as 'ketujuh'"),
                    \DB::raw("sum(if(b.subdemo_id='DD236' or b.subdemo_id='DD237' or b.subdemo_id='DD238',b.totals_thousand,0)) as 'kedelapan'"),
                    \DB::raw("sum(if(b.subdemo_id='DD239' or b.subdemo_id='DD240' or b.subdemo_id='DD241',b.totals_thousand,0)) as 'kesembilan'")
                )->orderBy('c.subdemo_name','desc')
                ->get();

            return array(
                'success'=>true,
                'pesan'=>'Data berhasil diload',
                'data'=>$day
            );
        }
    }
}