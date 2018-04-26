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

    public function top_brand_by_category(Request $request){
        $reqbrand=$request->input('brand');
        $reqquartal=$request->input('quartal');

        $brand=\App\Models\Dashboard\Cmv\Brand::find($reqbrand);
        $category=$brand->category_id;

        $cat=\DB::connection('mysql3')->select("select a.category_id,a.category_name, b.brand_id, b.brand_name, 
        sum(if(c.subdemo_id='DD1',c.totals_thousand,0)) as male,
        sum(if(c.subdemo_id='DD2',c.totals_thousand,0)) as female,
        sum(if(c.subdemo_id='DD1',c.totals_thousand,0)) + sum(if(c.subdemo_id='DD2',c.totals_thousand,0)) as total
        from cmv_category a
        left join cmv_brand b on b.category_id=a.category_id
        left join cmv_variabel c on c.brand_id=b.brand_id and c.subdemo_id in ('DD1','DD2')
        where a.category_id='$category'
        group by b.brand_id order by total desc");

        $data=array();
        $value=array();
        $label=array();
        foreach($cat as $key=>$val){
            if($key<10){
                array_push($label,$val->brand_name);
                array_push($data,$val->total);
            }
        }

        return array('data'=>$data,'label'=>$label);

    }

    public function competitive_map(Request $request){
        $category=$request->input('category');

        $listcompare=array();
        $alldemo=\App\Models\Dashboard\Cmv\Demography::all();
        $brand=\App\Models\Dashboard\Cmv\Brand::find($request->input('brand'));

        $list=\DB::connection('mysql3')->table('cmv_category as a')
            ->leftJoin('cmv_brand as b','b.category_id','=','a.category_id')
            ->leftJoin('cmv_variabel as c','c.brand_id','=','b.brand_id')
            ->leftJoin('cmv_sub_demography as d','d.subdemo_id','=','c.subdemo_id')
            ->select(
                'a.category_id',
                'a.category_name',
                'b.brand_id',
                'b.brand_name',
                'd.demo_id',
                'c.subdemo_id',
                'd.subdemo_name',
                'c.quartal',
                'c.totals_ver'
            );

        // if($request->has('compare')){
        //     $compare=$request->input('compare');
        //     $pecahbrand=explode(",",$compare);
        //     if(count($pecahbrand)){
        //         foreach($pecahbrand as $key=>$val){
        //             array_push($listcompare,$val);
        //         }
        //     }

        //     $list=$list->whereIn('b.brand_id',$listcompare);

        //     $br=\App\Models\Dashboard\Cmv\Brand::whereIn('brand_id',$listcompare)->get();
        // }

        if($request->has('brand')){
            $list=$list->where('b.brand_id',$request->input('brand'));
        }

        if($request->has('category')){
            $list=$list->where('a.category_id',$category);
        }

        $list=$list->orderBy('c.subdemo_id','asc')->get();

        return array('list'=>$list,'alldemo'=>$alldemo,'brand'=>$brand);


        // $com=\DB::select("select a.category_id,a.category_name, b.brand_id, 
        // b.brand_name,d.demo_id, c.subdemo_id, c.quartal, c.totals_thousand
        // from cmv_category a
        // left join cmv_brand b on b.category_id=a.category_id
        // left join cmv_variabel c on c.brand_id=b.brand_id
        // left join cmv_sub_demography as d on d.subdemo_id=c.subdemo_id
        // where a.category_id='AA1'
        // and b.brand_id in ('B10','B11')");
    }

    public function compare_with(Request $request){
        $brand=$request->input('brand');

        $listcompare=array();

        // select a.brand_id,a.brand_name, c.demo_id,b.subdemo_id, b.quartal, b.totals_ver,
        // (
        // b.totals_ver - (select cc.totals_ver
        //         from cmv_brand bb
        //         left join cmv_variabel cc on cc.brand_id=bb.brand_id
        //         left join cmv_sub_demography as dd on dd.subdemo_id=cc.subdemo_id
        //         where bb.brand_id='B1' and cc.subdemo_id=b.subdemo_id)
        // ) as total
        // from cmv_brand a 
        // left join cmv_variabel b on b.brand_id=a.brand_id
        // left join cmv_sub_demography c on c.subdemo_id=b.subdemo_id
        // where a.brand_id in ('B10','B11')

        $list=\DB::connection('mysql3')->table('cmv_category as a')
            ->leftJoin('cmv_brand as b','b.category_id','=','a.category_id')
            ->leftJoin('cmv_variabel as c','c.brand_id','=','b.brand_id')
            ->leftJoin('cmv_sub_demography as d','d.subdemo_id','=','c.subdemo_id')
            ->select(
                'a.category_id',
                'a.category_name',
                'b.brand_id',
                'b.brand_name',
                'd.demo_id',
                'c.subdemo_id',
                'd.subdemo_name',
                'c.quartal',
                'c.totals_ver',
                \DB::raw("(
                    c.totals_ver - (
                        select cc.totals_ver
                        from cmv_brand bb 
                        left join cmv_variabel cc on cc.brand_id=bb.brand_id
                        left join cmv_sub_demography dd on dd.subdemo_id=cc.subdemo_id
                        where bb.brand_id='$brand' and cc.subdemo_id=c.subdemo_id
                    )
                )as total")
            );

        if($request->has('compare')){
            $compare=$request->input('compare');
            $pecahbrand=explode(",",$compare);
            if(count($pecahbrand)){
                foreach($pecahbrand as $key=>$val){
                    array_push($listcompare,$val);
                }
            }

            $list=$list->whereIn('b.brand_id',$listcompare);

            $br=\App\Models\Dashboard\Cmv\Brand::whereIn('brand_id',$listcompare)->get();
        }

        if($request->has('category')){
            $list=$list->where('a.category_id',$category);
        }

        $list=$list->orderBy('c.subdemo_id','desc')->get();

        return array('list'=>$list,'compare'=>$br);
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
}