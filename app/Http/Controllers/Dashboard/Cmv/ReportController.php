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
                ->select("select a.brand_id, a.brand_name,d.demo_id,d.demo_name,b.subdemo_id,
                c.subdemo_name ,b.quartal, b.totals_thousand, b.totals_ver from cmv_brand a 
                left join cmv_variabel as b on b.brand_id=a.brand_id
                left join cmv_sub_demography as c on c.subdemo_id=b.subdemo_id
                left join cmv_demography as d on d.demo_id=c.demo_id
                where a.brand_id='$reqbrand'
                and b.quartal='$reqquartal'");
            
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
}