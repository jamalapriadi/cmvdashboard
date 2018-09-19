<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ReportController extends Controller
{
    public function summary_program_by_id($id){
        $program=\App\Models\Sosmed\Programunit::with(
            [
                'sosmed',
                'sosmed.sosmed',
                'sosmed.followers'
            ]
        )->find($id);

        return $program;
    }

    public function target_vs_achievement(Request $request){
        $rules=[
            'group'=>'alpha_num',
            'tanggal'=>'date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );

            return $data;
        }else{
            if($request->has('tanggal')){
                $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }else{
                $sekarang=date('Y-m-d');
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
    
            if($request->has('group')){
                $group=htmlentities($request->input('group'), ENT_QUOTES, 'UTF-8', false);
            }else{
                $group=1;
            }

            // $target=\DB::table('business_unit as a')
            //     ->leftJoin('unit_sosmed as b',function($join){
            //         $join->on('b.business_program_unit','a.id');
            //         $join->where('b.type_sosmed','corporate');
            //     })
            //     ->leftJoin('unit_sosmed_target as c',function($join){
            //         $join->on('c.unit_sosmed_id','b.id');
            //     })
            //     ->leftJoin('unit_sosmed_follower as d',function($join) use($sekarang){
            //         $join->on('d.unit_sosmed_id','b.id');
            //         $join->where('d.tanggal',$sekarang);
            //     })
            //     ->select(
            //         'a.id',
            //         'a.group_unit_id',
            //         'a.unit_name',
            //         'b.target_use',
            //         \DB::Raw("sum(if(b.sosmed_id=1, c.target,0)) as target_tw"),
            //         \DB::raw("sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) as follower_tw"),
            //         \DB::Raw("( sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) / sum(if(b.sosmed_id=1, c.target,0)) * 100) as acv_tw"),
            //         \DB::raw("sum(if(b.sosmed_id=2, c.target,0)) as target_fb"),
            //         \DB::raw("sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) as follower_fb"),
            //         \DB::raw("( sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) / sum(if(b.sosmed_id=2, c.target,0)) * 100) as acv_fb"),
            //         \DB::raw("sum(if(b.sosmed_id=3, c.target,0)) as target_ig"),
            //         \DB::raw("sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) as follower_ig"),
            //         \DB::raw("( sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) / sum(if(b.sosmed_id=3, c.target,0)) * 100) as acv_ig")
            //     )
            //     ->where('a.group_unit_id',$group)
            //     ->groupBy('a.id')
            //     ->get();

            // $tambahanInews=\DB::table('program_unit as a')
            //     ->leftJoin('unit_sosmed as b',function($join){
            //         $join->on('b.business_program_unit','=','a.id')
            //             ->where('b.type_sosmed','program');
            //     })
            //     ->leftJoin('unit_sosmed_follower as c',function($join) use($kemarin,$sekarang){
            //         $join->on('c.unit_sosmed_id','=','b.id')
            //             ->whereBetween('c.tanggal',[$kemarin,$sekarang]);
            //     })
            //     ->leftJoin('business_unit as d','d.id','=','a.business_unit_id')
            //     ->select(
            //         \DB::raw("ifnull(a.id,'TOTAL') as id"),
            //         'a.business_unit_id',
            //         'd.group_unit_id',
            //         'a.program_name',
            //         \DB::raw("sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin"),
            //         \DB::raw("sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang"),
            //         \DB::raw("(sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw"),
            //         \DB::raw("sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin"),
            //         \DB::raw("sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang"),
            //         \DB::raw("(sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb"),
            //         \DB::raw("sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin"),
            //         \DB::raw("sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang"),
            //         \DB::raw("(sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig")
            //     )
            //     ->whereIn('a.id',[89, 101, 95, 87])
            //     ->groupBy(\DB::raw('a.id WITH ROLLUP'))
            //     ->get();
    
            $target=\DB::select("select a.id, a.group_unit_id, a.unit_name, b.target_use, 
                sum(if(b.sosmed_id=1, c.target,0)) as target_tw,
                sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) as follower_tw,
                ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) / sum(if(b.sosmed_id=1, c.target,0)) * 100) as acv_tw,
                sum(if(b.sosmed_id=2, c.target,0)) as target_fb,
                sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) as follower_fb,
                ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) / sum(if(b.sosmed_id=2, c.target,0)) * 100) as acv_fb,
                sum(if(b.sosmed_id=3, c.target,0)) as target_ig,
                sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) as follower_ig,
                ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) / sum(if(b.sosmed_id=3, c.target,0)) * 100) as acv_ig
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_target c on c.unit_sosmed_id=b.id
                left join unit_sosmed_follower d on d.unit_sosmed_id=b.id and d.tanggal='$sekarang'
                where a.group_unit_id='$group' and a.type_unit='TV'
                GROUP by a.id");
    
            $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
                d.group_unit_id, a.program_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig
                from program_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join business_unit d on d.id=a.business_unit_id and d.type_unit='TV'
                where a.id in (89, 101, 95, 87)
                group by a.id
                with ROLLUP");
    
            return view('sosmed.view.target_vs_achivement')
                ->with('targetVsAch',$target)
                ->with('tambahanInews',$tambahanInews)
                ->with('sekarang',$sekarang);
        }
    }

    public function official_account_all_tv(Request $request){
        $rules=[
            'group'=>'alpha_num'
        ];

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'error'=>$validasi->errors()->all()
            );
            return $data;
        }else{
            $allsosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

            if($request->has('tanggal')){
                $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

                if($request->has('pilih')){
                    $pilih=$request->input('pilih');
    
                    if($pilih=="on"){
                        if($request->has('kemarin')){
                            $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                        }else{
                            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                        }
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $sekarang=date('Y-m-d');
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }

            if($request->has('group')){
                $gr=htmlentities($request->input('group'), ENT_QUOTES, 'UTF-8', false);

                $group="where group_unit_id='".$gr."'";
            }

            $unit=\DB::select("select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
                ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit e on e.id=a.group_unit_id
                where a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                with ROLLUP");

            $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
                d.group_unit_id, a.program_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
                (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt
                from program_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join business_unit d on d.id=a.business_unit_id and d.type_unit='TV'
                where a.id in (89, 101, 95, 87)
                group by a.id
                with ROLLUP");

            return view('sosmed.view.official_account_all_tv')
                ->with('officialTv',$unit)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin)
                ->with('tambahanInews',$tambahanInews);
        }
    }

    public function sosmed_official_and_program(Request $request){
        $rules=[
            'tanggal'=>'date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $overallOfficialTv=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        return view('sosmed.view.sosmed_official_and_program')
                ->with('overallOfficialTv',$overallOfficialTv)
                ->with('sekarang',$sekarang)
                ->with('kemarin',$kemarin);
    }

    public function official_and_program(Request $request){
        $rules=[
            'tanggal'=>'date',
            'group'=>'alpha_num'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }
        

        if($request->has('group')){
            $group=$request->input('group');
        }

        $officialAndProgram=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
            b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
            from business_unit a
            left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            where a.group_unit_id='$group' and a.type_unit='$typeunit'
            group by a.id
            union all 
            select 'program' as urut,d.id, d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where d.group_unit_id='$group'
            group by a.id
            union all 
            select 'total' as urut,semua.id, semua.group_unit_id, semua.unit_name, semua.type_sosmed, semua.unit_sosmed_name, semua.tanggal,
                sum(tw) as total_tw,
                sum(fb) as total_fb,
                sum(ig) as total_ig,
                sum(yt) as total_yt
                from (
                    select a.id,a.group_unit_id, a.unit_name, b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
                    from business_unit a
                    left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                    left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                    where a.group_unit_id='$group' and a.type_unit='$typeunit'
                    group by a.id
                    union all 
                    select d.id,d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
                    from program_unit a 
                    left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                    left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                    left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
                    where d.group_unit_id='$group'
                    group by a.id
                ) as semua 
            group by semua.id
            order by id, urut,type_sosmed");

        return view('sosmed.view.detail_official_and_program')
            ->with('sekarang',$sekarang)
            ->with('officialAndProgram',$officialAndProgram);
    }

    /* rank */
    public function rank_of_official_account_all_group(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
            
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $data['sekarang']=$sekarang;
        $data['kemarin']=$kemarin;

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }
        

        $rankOfOfficialAccountAllGroupByFollowers=\DB::select("select a.id, a.group_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            FROM group_unit a 
            left join business_unit b on b.group_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            where b.type_unit='$typeunit'
            group by a.id");

        $rankOfOfficialAccountAllTvByFollowers=\DB::select("select b.id, b.unit_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            where b.type_unit='$typeunit'
            group by b.id");

        $rankOverallAccountGroup=\DB::select("select terjadi.group_unit_id,terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig
                from (
                    select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang
                    from 
                    business_unit a 
                    left join program_unit b on b.business_unit_id=a.id
                    left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                    left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id
                    union all 
                    select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang
                    from 
                    business_unit a 
                    left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                    left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id 
                ) as terjadi
            group by terjadi.group_unit_id");

        $rankOverallAccountAllTv=\DB::select("select terjadi.id, terjadi.group_unit_id,terjadi.unit_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig
            from (
                select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
                a.group_unit_id,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                where a.type_unit='$typeunit'
                group by a.id
                union all 
                select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
                a.group_unit_id,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                where a.type_unit='$typeunit'
                group by a.id 
            ) as terjadi
            group by terjadi.id");

        $groupOthers=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
            b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) - 1) * 100 as growth_tw,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100 as growth_fb,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100 as growth_ig,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0))) as num_of_growth_ig
            from business_unit a
            left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal between '$kemarin' and '$sekarang'
            where a.group_unit_id=5 and a.type_unit='$typeunit'
            group by a.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            and weekday(c.tanggal) <= 6
            group by a.id
            with ROLLUP");

        $tambahanOverAllTvOthers=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=5 and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=5 and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
            ) as terjadi
            group by terjadi.group_id,terjadi.id");


        return view('sosmed.view.rank_official_account_all_group_by_followers')
            ->with('sekarang',$sekarang)
            ->with('kemarin',$kemarin)
            ->with('rankOfOfficialAccountAllGroupByFollowers',$rankOfOfficialAccountAllGroupByFollowers)
            ->with('rankOfOfficialAccountAllTvByFollowers',$rankOfOfficialAccountAllTvByFollowers)
            ->with('rankOverallAccountGroup',$rankOverallAccountGroup)
            ->with('rankOverallAccountAllTv',$rankOverallAccountAllTv)
            ->with('tambahanOverAllTvOthers',$tambahanOverAllTvOthers)
            ->with('tambahanInews',$tambahanInews)
            ->with('groupOthers',$groupOthers);
    }

    public function rank_of_official_account_all_tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $group=\DB::select("select b.id, b.unit_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) -1) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) -1) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) -1) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            group by b.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $data=array();

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($group as $k){
            if($k->id==4){
                foreach($tambahanInews as $in){
                    if($in->id=="TOTAL"){
                        array_push($arrTw,$in->tw_sekarang);
                        array_push($arrFb,$in->fb_sekarang);
                        array_push($arrIg,$in->ig_sekarang);        
                    }
                }
            }else{
                array_push($arrTw,$k->tw_sekarang);
                array_push($arrFb,$k->fb_sekarang);
                array_push($arrIg,$k->ig_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);

        foreach($group as $row){
            if($row->id==4){
                foreach($tambahanInews as $ins){
                    if($ins->id=="TOTAL"){
                        $data[]=array(
                            'id'=>$row->id,
                            'unit_name'=>$row->unit_name,
                            'follower'=>array(
                                'tw'=>1,
                                'growth_twitter'=>$ins->growth_tw." %",
                                'tw_sekarang'=>$ins->tw_sekarang,
                                'rank_tw'=>($rankTw[$ins->tw_sekarang]+1),
                                'num_of_growth_tw'=>$ins->num_of_growth_tw,
                                'fb'=>2,
                                'growth_fb'=>$ins->growth_fb." %",
                                'fb_sekarang'=>$ins->fb_sekarang,
                                'rank_fb'=>($rankFb[$ins->fb_sekarang]+1),
                                'num_of_growth_fb'=>$ins->num_of_growth_fb,
                                'ig'=>3,
                                'growth_ig'=>$ins->growth_ig,
                                'ig_sekarang'=>$ins->ig_sekarang,
                                'rank_ig'=>($rankIg[$ins->ig_sekarang]+1),
                                'num_of_growth_ig'=>$ins->num_of_growth_ig
                            )
                        );
                    }
                }
            }else{
                $data[]=array(
                    'id'=>$row->id,
                    'unit_name'=>$row->unit_name,
                    'follower'=>array(
                        'tw'=>1,
                        'growth_twitter'=>$row->growth_tw." %",
                        'tw_sekarang'=>$row->tw_sekarang,
                        'rank_tw'=>($rankTw[$row->tw_sekarang] + 1),
                        'num_of_growth_tw'=>$row->num_of_growth_tw,
                        'fb'=>2,
                        'growth_fb'=>$row->growth_fb." %",
                        'fb_sekarang'=>$row->fb_sekarang,
                        'rank_fb'=>($rankFb[$row->fb_sekarang] + 1),
                        'num_of_growth_fb'=>$row->num_of_growth_fb,
                        'ig'=>3,
                        'growth_ig'=>$row->growth_ig." %",
                        'ig_sekarang'=>$row->ig_sekarang,
                        'rank_ig'=>($rankIg[$row->ig_sekarang] + 1),
                        'num_of_growth_ig'=>$row->num_of_growth_ig
                    )
                );
            }
        }

        return $data;
    }

    public function rank_growth_from_yesterday_all_tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }


        $rankOfOfficialAccountAllTvByFollowers=\DB::select("select b.id, b.unit_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            group by b.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        return view('sosmed.view.rank_growth_from_yesterday_all_tv')
            ->with('kemarin',$kemarin)
            ->with('sekarang',$sekarang)
            ->with('rankOfOfficialAccountAllTvByFollowers',$rankOfOfficialAccountAllTvByFollowers)
            ->with('tambahanInews',$tambahanInews);
    }

    public function rank_growth_from_yesterday_group(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }


        $group=\DB::select("select a.id, a.group_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            FROM group_unit a 
            left join business_unit b on b.group_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            group by a.id");

        $data=array();

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($group as $k){
            array_push($arrTw,$k->tw_sekarang);
            array_push($arrFb,$k->fb_sekarang);
            array_push($arrIg,$k->ig_sekarang);
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);

        foreach($group as $row){
            $data[]=array(
                'id'=>$row->id,
                'group_name'=>$row->group_name,
                'follower'=>array(
                    'num_of_tw'=>$row->num_of_growth_tw,
                    'growth_twitter'=>$row->growth_tw." %",
                    'rank_tw'=>($rankTw[$row->tw_sekarang] + 1),
                    'num_of_fb'=>$row->num_of_growth_fb,
                    'growth_fb'=>$row->growth_fb." %",
                    'rank_fb'=>($rankFb[$row->fb_sekarang] + 1),
                    'num_of_ig'=>$row->num_of_growth_ig,
                    'growth_ig'=>$row->growth_ig." %",
                    'rank_ig'=>($rankIg[$row->ig_sekarang] + 1)
                )
            );
        }

        return $data;
    }

    public function rank_overall_account_all_tv_by_total_followers(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group="where a.group_unit_id='".$request->input('group')."'";
        }else{
            $group="";
        }

        $summary=\DB::select("select terjadi.id, terjadi.unit_name,
            sum(terjadi.kemarin_tw) as total_kemarin_tw,
            sum(terjadi.sekarang_tw) as total_sekarang_tw,
            ((sum(terjadi.sekarang_tw)/sum(terjadi.kemarin_tw)-1) * 100) as growth_tw,
            (sum(terjadi.sekarang_tw)-sum(terjadi.kemarin_tw)) as num_of_growth_tw,
            sum(terjadi.kemarin_fb) as total_kemarin_fb,
            sum(terjadi.sekarang_fb) as total_sekarang_fb,
            ((sum(terjadi.sekarang_fb)/sum(terjadi.kemarin_fb)-1) * 100) as growth_fb,
            (sum(terjadi.sekarang_fb)-sum(terjadi.kemarin_fb)) as num_of_growth_fb,
            sum(terjadi.kemarin_ig) as total_kemarin_ig,
            sum(terjadi.sekarang_ig) as total_sekarang_ig,
            ((sum(terjadi.sekarang_ig)/sum(terjadi.kemarin_ig)-1) * 100) as growth_ig ,
            (sum(terjadi.sekarang_ig)-sum(terjadi.kemarin_ig)) as num_of_growth_ig
            from (
                select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as kemarin_tw,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as sekarang_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as kemarin_fb,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as sekarang_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as kemarin_ig,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as sekarang_ig
            from 
            business_unit a 
            left join program_unit b on b.business_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal between '$kemarin' and '$sekarang'
            $group
            group by a.id
            union all 
            select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
            sum(if(b.sosmed_id=1 and c.tanggal='$kemarin',c.follower,0)) as kemarin_tw,
            sum(if(b.sosmed_id=1 and c.tanggal='$sekarang',c.follower,0)) as sekarang_tw,
            sum(if(b.sosmed_id=2 and c.tanggal='$kemarin',c.follower,0)) as kemarin_fb,
            sum(if(b.sosmed_id=2 and c.tanggal='$sekarang',c.follower,0)) as sekarang_fb,
            sum(if(b.sosmed_id=3 and c.tanggal='$kemarin',c.follower,0)) as kemarin_ig,
            sum(if(b.sosmed_id=3 and c.tanggal='$sekarang',c.follower,0)) as sekarang_ig
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal between '$kemarin' and '$sekarang'
            $group
            group by a.id ) as terjadi
            group by terjadi.id");

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($summary as $k){
            array_push($arrTw,$k->total_sekarang_tw);
            array_push($arrFb,$k->total_sekarang_fb);
            array_push($arrIg,$k->total_sekarang_ig);
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);

        $data=array();
        foreach($summary as $key=>$val){
            $follower=array(
                'tw'=>array(
                    'growth'=>$val->growth_tw,
                    'num_of_growth'=>$val->num_of_growth_tw,
                    'total'=>$val->total_sekarang_tw,
                    'rank'=>($rankTw[$val->total_sekarang_tw] + 1)
                ),
                'fb'=>array(
                    'growth'=>$val->growth_fb,
                    'num_of_growth'=>$val->num_of_growth_fb,
                    'total'=>$val->total_sekarang_fb,
                    'rank'=>($rankFb[$val->total_sekarang_fb] + 1)
                ),
                'ig'=>array(
                    'growth'=>$val->growth_ig,
                    'num_of_growth'=>$val->num_of_growth_ig,
                    'total'=>$val->total_sekarang_ig,
                    'rank'=>($rankIg[$val->total_sekarang_ig] + 1)
                )
            );

            $data[]=array(
                'id'=>$val->id,
                'unit_name'=>$val->unit_name,
                'followers'=>$follower
            );
        }

        return $data;
    }

    public function rank_of_overall_all_group_by_follower(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $summary=\DB::select("select a.id,a.group_name,  
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=1,e.follower,0)) as kemarin_tw,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=1,e.follower,0)) as sekarang_tw,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=1,e.follower,0)) / sum(if(e.tanggal='$kemarin' and c.sosmed_id=1,e.follower,0)) - 1) as growth_tw,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=1,e.follower,0)) - sum(if(e.tanggal='$kemarin' and c.sosmed_id=1,e.follower,0))) as num_growth_tw,
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=2,e.follower,0)) as kemarin_fb,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=2,e.follower,0)) as sekarang_fb,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=2,e.follower,0)) / sum(if(e.tanggal='$kemarin' and c.sosmed_id=2,e.follower,0)) - 1) as growth_fb,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=2,e.follower,0)) - sum(if(e.tanggal='$kemarin' and c.sosmed_id=2,e.follower,0))) as num_growth_fb,
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=3,e.follower,0)) as kemarin_ig,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=3,e.follower,0)) as sekarang_ig,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=3,e.follower,0)) / sum(if(e.tanggal='$kemarin' and c.sosmed_id=3,e.follower,0)) - 1) as growth_ig,
            (sum(if(e.tanggal='$sekarang' and c.sosmed_id=3,e.follower,0)) - sum(if(e.tanggal='$kemarin' and c.sosmed_id=3,e.follower,0))) as num_growth_ig
            from group_unit a 
            left join business_unit b on b.group_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join sosmed d on d.id=c.sosmed_id
            left join unit_sosmed_follower e on e.unit_sosmed_id=c.id and e.tanggal between '$kemarin' and '$sekarang'
            group by a.id");   

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($summary as $k){
            array_push($arrTw,$k->sekarang_tw);
            array_push($arrFb,$k->sekarang_fb);
            array_push($arrIg,$k->sekarang_ig);
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);


        $data=array();

        foreach($summary as $key=>$val){
            $follower=array(
                'tw'=>array(
                    'growth'=>$val->growth_tw,
                    'num_of_growth'=>$val->num_growth_tw,
                    'total'=>$val->sekarang_tw,
                    'rank'=>($rankTw[$val->sekarang_tw] + 1)
                ),
                'fb'=>array(
                    'growth'=>$val->growth_fb,
                    'num_of_growth'=>$val->num_growth_fb,
                    'total'=>$val->sekarang_fb,
                    'rank'=>($rankFb[$val->sekarang_fb] + 1)
                ),
                'ig'=>array(
                    'growth'=>$val->growth_ig,
                    'num_of_growth'=>$val->num_growth_ig,
                    'total'=>$val->sekarang_ig,
                    'rank'=>($rankIg[$val->sekarang_ig] + 1)
                )
            );

            $data[]=array(
                'id'=>$val->id,
                'group_name'=>$val->group_name,
                'followers'=>$follower
            );
        }

        return $data;
    }

    public function rank_of_official_account_among_4tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group="where a.group_unit_id='".$request->input('group')."'";
        }else{
            $group="";
        }

        $summary=\DB::select("select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as kemarin_tw,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as sekarang_tw,
            ( sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_tw,
            ( sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as kemarin_fb,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as sekarang_fb,
            ( sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_fb,
            ( sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as kemarin_ig,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as sekarang_ig,
            ( sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_ig,
            ( sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig
            from 
            business_unit a 
            left join program_unit b on b.business_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal between '$kemarin' and '$sekarang'
            $group
            group by a.id");
        
        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($summary as $k){
            array_push($arrTw,$k->sekarang_tw);
            array_push($arrFb,$k->sekarang_fb);
            array_push($arrIg,$k->sekarang_ig);
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);

        $data=array();
        foreach($summary as $key=>$val){
            $follower=array(
                'tw'=>array(
                    'growth'=>$val->growth_tw,
                    'num_of_growth'=>$val->num_of_growth_tw,
                    'total'=>$val->sekarang_tw,
                    'rank'=>($rankTw[$val->sekarang_tw] + 1)
                ),
                'fb'=>array(
                    'growth'=>$val->growth_fb,
                    'num_of_growth'=>$val->num_of_growth_fb,
                    'total'=>$val->sekarang_fb,
                    'rank'=>($rankFb[$val->sekarang_fb] + 1)
                ),
                'ig'=>array(
                    'growth'=>$val->growth_ig,
                    'num_of_growth'=>$val->num_of_growth_ig,
                    'total'=>$val->sekarang_ig,
                    'rank'=>($rankIg[$val->sekarang_ig] + 1)
                )
            );

            $data[]=array(
                'id'=>$val->id,
                'unit_name'=>$val->unit_name,
                'followers'=>$follower
            );
        }

        return $data;
    }

    public function pdf_rank_for_social_media_all_tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'typeunit'=>'required',
            'sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        $listsosmed=$request->input('sosmed');

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
            
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $data['sekarang']=$sekarang;
        $data['kemarin']=$kemarin;

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        switch($typeunit){
            case "TV":
                    $filtergroup="where a.id in(1,2,3,4,5)";
                    $othergroup=5;
                break;
            case "Publisher":
                    $filtergroup="where a.id in(1,3,9,10,11,12)";
                    $othergroup=12;
                break;
            case "Radio":
                    $filtergroup="where a.id in(6,7,8,9)";
                    $othergroup=5;
                break;
            case "KOL":
                    $filtergroup="where a.id=46";
                    $othergroup=5;
                break;  
            default:
                    $filtergroup="";
                    $othergroup=5;
                break;
        }

        $data['rankOfOfficialAccountAllGroupByFollowers']=\DB::select("select a.id, a.group_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig,
            sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) as yt_kemarin,
            sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) as yt_sekarang,
            ((sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_yt,
            (sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_yt
            FROM group_unit a 
            left join business_unit b on b.group_unit_id=a.id and b.type_unit='$typeunit'
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            $filtergroup
            group by a.id");

        $data['groupOthers']=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
            b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) - 1) * 100 as growth_tw,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100 as growth_fb,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100 as growth_ig,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0))) as num_of_growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100 as growth_yt,
            ( sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0))) as num_of_growth_yt
            from business_unit a
            left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal between '$kemarin' and '$sekarang'
            where a.group_unit_id=$othergroup and a.type_unit='$typeunit'
            group by a.id");

        $data['tambahanInews']=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0))) as num_of_growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $data['rankOfOfficialAccountAllTvByFollowers']=\DB::select("select b.id, b.unit_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig,
            sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) as yt_sekarang,
            ((sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_yt,
            (sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_yt
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            where b.type_unit='$typeunit'
            group by b.id");

        $data['rankOverallAccountGroup']=\DB::select("select terjadi.group_unit_id,terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt
                from (
                    select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                    from 
                    business_unit a 
                    left join program_unit b on b.business_unit_id=a.id
                    left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                    left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id
                    union all 
                    select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                    from 
                    business_unit a 
                    left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                    left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id 
                ) as terjadi
            group by terjadi.group_unit_id");

        $data['rankOverallAccountAllTv']=\DB::select("select terjadi.id, terjadi.group_unit_id,terjadi.unit_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt
            from (
                select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
                a.group_unit_id,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                where a.type_unit='$typeunit'
                group by a.id
                union all 
                select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
                a.group_unit_id,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                where a.type_unit='$typeunit'
                group by a.id 
            ) as terjadi
            group by terjadi.id");

        $data['tambahanOverAllTvOthers']=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt  
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=$othergroup and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=$othergroup and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        $data['sosmed']=\App\Models\Sosmed\Sosmed::whereIn('id',$listsosmed)->get();

        $data['typeunit']=$typeunit;

        $pdf = \PDF::loadView('sosmed.pdf.rank_for_social_media_all_tv', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('Socmed Ranking '.date('d-M-Y').'.pdf');
    }

    public function pdf_sosmed_daily_report(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
            'typeunit'=>'required',
            'sosmed'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        $listsosmed=$request->input('sosmed');

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }

        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group=$request->input('group');
        }else{
            $group=1;
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        $data['sekarang']=$sekarang;
        $data['kemarin']=$kemarin;

        $data['targetVsAch']=\DB::select("select a.id, a.group_unit_id, a.unit_name, b.target_use, 
            sum(if(b.sosmed_id=1, c.target,0)) as target_tw,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) as follower_tw,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) / sum(if(b.sosmed_id=1, c.target,0)) * 100) as acv_tw,
            sum(if(b.sosmed_id=2, c.target,0)) as target_fb,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) as follower_fb,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) / sum(if(b.sosmed_id=2, c.target,0)) * 100) as acv_fb,
            sum(if(b.sosmed_id=3, c.target,0)) as target_ig,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) as follower_ig,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) / sum(if(b.sosmed_id=3, c.target,0)) * 100) as acv_ig
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_target c on c.unit_sosmed_id=b.id
            left join unit_sosmed_follower d on d.unit_sosmed_id=b.id and d.tanggal='$sekarang'
            where a.group_unit_id='$group' and a.type_unit='$typeunit'
            GROUP by a.id");

        $data['officialTv']=\DB::select("select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='$typeunit'
            group by a.group_unit_id,a.id 
            with ROLLUP");

        $data['overallOfficialTv']=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        /* official and program mnc group */
        $data['officialAndProgram']=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
                b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
                from business_unit a
                left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                where a.group_unit_id='$group' and a.type_unit='$typeunit'
                group by a.id
                union all 
                select 'program' as urut,d.id, d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
                from program_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
                where d.group_unit_id='$group'
                group by a.id
                union all 
                select 'total' as urut,semua.id, semua.group_unit_id, semua.unit_name, semua.type_sosmed, semua.unit_sosmed_name, semua.tanggal,
                    sum(tw) as total_tw,
                    sum(fb) as total_fb,
                    sum(ig) as total_ig,
                    sum(yt) as total_yt
                    from (
                        select a.id,a.group_unit_id, a.unit_name, b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
                        from business_unit a
                        left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        where a.group_unit_id='$group' and a.type_unit='$typeunit'
                        group by a.id
                        union all 
                        select d.id,d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
                        from program_unit a 
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
                        where d.group_unit_id='$group'
                        group by a.id
                    ) as semua 
                group by semua.id
                order by id, urut,type_sosmed");

        $data['attachment']=\App\Models\Sosmed\Businessunit::select('id','unit_name')
                ->with(
                [
                    'sosmed',
                    'program',
                    'program.sosmed'
                ]
            )->where('type_unit',$typeunit)->get();
        
        $data['sosmed']=\App\Models\Sosmed\Sosmed::whereIn('id',$listsosmed)->get();

        $data['typeunit']=$typeunit;

        $data['tambahanInews']=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $pdf = \PDF::loadView('sosmed.pdf.sosmed_daily_report', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('Socmed Daily Report '.date('d-M-Y').'.pdf');
    }

    public function pdf_sosmed_daily_report_by_group(Request $request){
        $rules=[
            'tanggal2'=>'date',
            'kemarin2'=>'nullable|date',
            'group'=>'alpha_num',
            'media'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal2')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal2')));

            if($request->has('pilih2')){
                $pilih=$request->input('pilih2');

                if($pilih=="on"){
                    if($request->has('kemarin2')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin2')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }

        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group2')){
            $group=$request->input('group2');
        }else{
            $group=1;
        }

        // if($request->has('media')){
        //     $typeunit=$request->input('media');
        // }else{
        //     $typeunit=["TV","Publisher","Radio"];
        // }

        $typeunit="TV";

        $data['sekarang']=$sekarang;
        $data['kemarin']=$kemarin;

        $data['officialTv']=\DB::select("select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='TV' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP

            union all 

            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  a.type_unit,
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Publisher' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP

            union all

            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit, 
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Radio' and a.group_unit_id=6
            group by a.group_unit_id,a.id
            with ROLLUP
            
            union all 
           
            
            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Production House' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP
            
            union all 
            
            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  a.type_unit,
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='PAYTV,IPTV,OTT' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP
            
            union all 
            
            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit, 
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Newspaper' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP

            union all 

            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  a.type_unit,
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Magazine' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP
            
            union all 
            
            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  a.type_unit,
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='Animation Production' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP
            
            union all 
            
            select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  a.type_unit,
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) * 100) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) * 100) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) * 100) as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang,
            ((sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) - 1) * 100) as growth_yt
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            where a.type_unit='SMN Channel' and a.group_unit_id=1
            group by a.group_unit_id,a.id
            with ROLLUP");
        
        $data['sosmed']=\App\Models\Sosmed\Sosmed::all();
        $data['typeunit']=$typeunit;

        $data['tambahanInews']=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $data['overallOfficialTv']=\DB::select("select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='TV' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='TV' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Publisher' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Publisher' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Radio' and a.group_unit_id=6
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Radio' and a.group_unit_id=6
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='KOL' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='KOL' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Production House' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Production House' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='PAYTV,IPTV,OTT' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='PAYTV,IPTV,OTT' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Newspaper' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Newspaper' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Magazine' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Magazine' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Animation Production' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='Animation Production' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id
            
            union all 
            
            select terjadi.id, terjadi.type_unit, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt 
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,a.type_unit,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='SMN Channel' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, a.type_unit,
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.type_unit='SMN Channel' and a.group_unit_id=1
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        $data['kemarin']=$kemarin;
        $data['sekarang']=$sekarang;

        $pdf = \PDF::loadView('sosmed.pdf.sosmed_daily_report_by_group', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('Socmed Ranking '.date('d-M-Y').'.pdf');

        

        /* official and program mnc group */
        $data['officialAndProgram']=\DB::select("select 'corporate' as urut,a.id, a.group_unit_id, a.unit_name, 
                b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
                from business_unit a
                left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                where a.group_unit_id='$group' and a.type_unit='$typeunit'
                group by a.id
                union all 
                select 'program' as urut,d.id, d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
                from program_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
                where d.group_unit_id='$group'
                group by a.id
                union all 
                select 'total' as urut,semua.id, semua.group_unit_id, semua.unit_name, semua.type_sosmed, semua.unit_sosmed_name, semua.tanggal,
                    sum(tw) as total_tw,
                    sum(fb) as total_fb,
                    sum(ig) as total_ig,
                    sum(yt) as total_yt
                    from (
                        select a.id,a.group_unit_id, a.unit_name, b.type_sosmed, b.unit_sosmed_name, c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt
                        from business_unit a
                        left join unit_sosmed as b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        where a.group_unit_id='$group' and a.type_unit='$typeunit'
                        group by a.id
                        union all 
                        select d.id,d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt
                        from program_unit a 
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
                        where d.group_unit_id='$group'
                        group by a.id
                    ) as semua 
                group by semua.id
                order by id, urut,type_sosmed");

        $data['attachment']=\App\Models\Sosmed\Businessunit::select('id','unit_name')
                ->with(
                [
                    'sosmed',
                    'program',
                    'program.sosmed'
                ]
            )->where('type_unit',$typeunit)->get();
        
        $data['sosmed']=\App\Models\Sosmed\Sosmed::whereIn('id',$listsosmed)->get();

        $data['typeunit']=$typeunit;

        $pdf = \PDF::loadView('sosmed.pdf.sosmed_daily_report', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('Socmed Daily Report '.date('d-M-Y').'.pdf');
    }

    public function highlight_of_official_account_all_tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'typeunit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        $group=\DB::select("select b.id, b.unit_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig,
            sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) as yt_kemarin,
            sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) as yt_sekarang,
            ((sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) -1) * 100) as growth_yt,
            (sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_yt
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            where b.type_unit='$typeunit'
            group by b.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0))) as num_of_growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $data=array();

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($group as $k){
            if($k->id==4){
                foreach($tambahanInews as $in){
                    if($in->id=="TOTAL"){
                        array_push($arrTw,$in->tw_sekarang);
                        array_push($arrFb,$in->fb_sekarang);
                        array_push($arrIg,$in->ig_sekarang);        
                        array_push($arrYt,$in->yt_sekarang);        
                    }
                }
            }else{
                array_push($arrTw,$k->tw_sekarang);
                array_push($arrFb,$k->fb_sekarang);
                array_push($arrIg,$k->ig_sekarang);
                array_push($arrYt,$k->yt_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);

        foreach($group as $row){
            if($row->id==4){
                foreach($tambahanInews as $ins){
                    if($ins->id=="TOTAL"){
                        $data[]=array(
                            'id'=>$row->id,
                            'unit_name'=>$row->unit_name,
                            'follower'=>array(
                                'tw'=>1,
                                'growth_twitter'=>$ins->growth_tw." %",
                                'tw_sekarang'=>$ins->tw_sekarang,
                                'rank_tw'=>($rankTw[$ins->tw_sekarang]+1),
                                'num_of_growth_tw'=>$ins->num_of_growth_tw,
                                'fb'=>2,
                                'growth_fb'=>$ins->growth_fb." %",
                                'fb_sekarang'=>$ins->fb_sekarang,
                                'rank_fb'=>($rankFb[$ins->fb_sekarang]+1),
                                'num_of_growth_fb'=>$ins->num_of_growth_fb,
                                'ig'=>3,
                                'growth_ig'=>$ins->growth_ig,
                                'ig_sekarang'=>$ins->ig_sekarang,
                                'rank_ig'=>($rankIg[$ins->ig_sekarang]+1),
                                'num_of_growth_ig'=>$ins->num_of_growth_ig,
                                'yt'=>4,
                                'growth_yt'=>$ins->growth_yt,
                                'yt_sekarang'=>$ins->yt_sekarang,
                                'rank_yt'=>($rankYt[$ins->yt_sekarang]+1),
                                'num_of_growth_yt'=>$ins->num_of_growth_yt
                            )
                        );
                    }
                }
            }else{
                $data[]=array(
                    'id'=>$row->id,
                    'unit_name'=>$row->unit_name,
                    'follower'=>array(
                        'tw'=>1,
                        'growth_twitter'=>$row->growth_tw." %",
                        'tw_sekarang'=>$row->tw_sekarang,
                        'rank_tw'=>($rankTw[$row->tw_sekarang] + 1),
                        'num_of_growth_tw'=>$row->num_of_growth_tw,
                        'fb'=>2,
                        'growth_fb'=>$row->growth_fb." %",
                        'fb_sekarang'=>$row->fb_sekarang,
                        'rank_fb'=>($rankFb[$row->fb_sekarang] + 1),
                        'num_of_growth_fb'=>$row->num_of_growth_fb,
                        'ig'=>3,
                        'growth_ig'=>$row->growth_ig." %",
                        'ig_sekarang'=>$row->ig_sekarang,
                        'rank_ig'=>($rankIg[$row->ig_sekarang] + 1),
                        'num_of_growth_ig'=>$row->num_of_growth_ig,
                        'yt'=>4,
                        'growth_yt'=>$row->growth_yt." %",
                        'yt_sekarang'=>$row->yt_sekarang,
                        'rank_yt'=>($rankYt[$row->yt_sekarang] + 1),
                        'num_of_growth_yt'=>$row->num_of_growth_yt
                    )
                );
            }
        }

        return $data;
    }

    public function highlight_group_official_account_by_total_followers(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
            'typeunit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        $allsosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group="where group_unit_id='".$request->input('group')."'";
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        switch($typeunit){
            case "TV":
                    $filtergroup="where a.id in(1,2,3,4,5)";
                    $othergroup=5;
                break;
            case "Publisher":
                    $filtergroup="where a.id in(1,3,9,10,11,12)";
                    $othergroup=12;
                break;
            case "Radio":
                    $filtergroup="where a.id in(6,7,8,9)";
                    $othergroup=5;
                break;
            case "KOL":
                    $filtergroup="";
                break;  
            default:
                    $filtergroup="";
                    $othergroup=5;
                break;
        }

        $group=\DB::select("select a.id, a.group_name,d.tanggal,
            sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) as tw_kemarin,
            sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) as tw_sekarang,
            ((sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_tw,
            (sum(if(c.sosmed_id=1 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=1 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_tw,
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            ((sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_fb,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            ((sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_ig,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_ig,
            sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) as yt_kemarin,
            sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) as yt_sekarang,
            ((sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0)) - 1) * 100) as growth_yt,
            (sum(if(c.sosmed_id=4 and d.tanggal='$sekarang',d.follower,0)) - sum(if(c.sosmed_id=4 and d.tanggal='$kemarin',d.follower,0))) as num_of_growth_yt
            FROM group_unit a 
            left join business_unit b on b.group_unit_id=a.id and b.type_unit='$typeunit'
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            $filtergroup
            group by a.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) -1)*100 as growth_yt,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0))) as num_of_growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $tambahanOverAllTvOthers=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt  
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=$othergroup and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        $data=array();

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($group as $k){
            if($k->id==1){
                if($typeunit=="TV"){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            array_push($arrTw,($in->tw_sekarang+$k->tw_sekarang));
                            array_push($arrFb,($in->fb_sekarang+$k->fb_sekarang));
                            array_push($arrIg,($in->ig_sekarang+$k->ig_sekarang));        
                            array_push($arrYt,($in->yt_sekarang+$k->yt_sekarang));        
                        }
                    }
                }else{
                    array_push($arrTw,$k->tw_sekarang);
                    array_push($arrFb,$k->fb_sekarang);
                    array_push($arrIg,$k->ig_sekarang);
                    array_push($arrYt,$k->yt_sekarang);    
                }
                
            }else if($k->id==5 || $k->id==12){
                foreach($tambahanOverAllTvOthers as $ro){
                    array_push($arrTw,$ro->total_tw_sekarang);
                    array_push($arrFb,$ro->total_fb_sekarang);
                    array_push($arrIg,$ro->total_ig_sekarang);    
                    array_push($arrYt,$ro->total_yt_sekarang);    
                }
            }else{
                array_push($arrTw,$k->tw_sekarang);
                array_push($arrFb,$k->fb_sekarang);
                array_push($arrIg,$k->ig_sekarang);
                array_push($arrYt,$k->yt_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);

        foreach($group as $row){
            if($row->id==1){
                if($typeunit=="TV"){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            if($in->yt_kemarin+$row->yt_kemarin >0){
                                $growth_yt=(($in->yt_sekarang+$row->yt_sekarang) / ($in->yt_kemarin+$row->yt_kemarin) -1)*100;
                            }else{
                                $growth_yt=0;
                            }
                            $data[]=array(
                                'id'=>$row->id,
                                'group_name'=>$row->group_name,
                                'follower'=>array(
                                    'tw'=>1,
                                    'tw_sekarang'=>($in->tw_sekarang+$row->tw_sekarang),
                                    'tw_kemarin'=>($in->tw_kemarin+$row->tw_kemarin),
                                    'growth_tw'=>number_format((($in->tw_sekarang+$row->tw_sekarang) / ($in->tw_kemarin+$row->tw_kemarin) -1)*100,4),
                                    'num_of_growth_tw'=>(($in->tw_sekarang+$row->tw_sekarang) - ($in->tw_kemarin+$row->tw_kemarin)),
                                    'rank_tw'=>($rankTw[($in->tw_sekarang+$row->tw_sekarang)]+1),
                                    'fb'=>2,
                                    'fb_sekarang'=>($in->fb_sekarang+$row->fb_sekarang),
                                    'fb_kemarin'=>($in->fb_kemarin+$row->fb_kemarin),
                                    'growth_fb'=>number_format((($in->fb_sekarang+$row->fb_sekarang) / ($in->fb_kemarin+$row->fb_kemarin) -1)*100,4),
                                    'num_of_growth_fb'=>(($in->fb_sekarang+$row->fb_sekarang) - ($in->fb_kemarin+$row->fb_kemarin)),
                                    'rank_fb'=>($rankFb[($in->fb_sekarang+$row->fb_sekarang)]+1),
                                    'ig'=>3,
                                    'ig_sekarang'=>($in->ig_sekarang+$row->ig_sekarang),
                                    'ig_kemarin'=>($in->ig_kemarin+$row->ig_kemarin),
                                    'growth_ig'=>number_format((($in->ig_sekarang+$row->ig_sekarang) / ($in->ig_kemarin+$row->ig_kemarin) -1)*100,4),
                                    'num_of_growth_ig'=>(($in->ig_sekarang+$row->ig_sekarang) - ($in->ig_kemarin+$row->ig_kemarin)),
                                    'rank_ig'=>($rankIg[($in->ig_sekarang+$row->ig_sekarang)]+1),
                                    'yt'=>4,
                                    'yt_sekarang'=>($in->yt_sekarang+$row->yt_sekarang),
                                    'yt_kemarin'=>($in->yt_kemarin+$row->yt_kemarin),
                                    'growth_yt'=>number_format($growth_yt,4),
                                    'num_of_growth_yt'=>(($in->yt_sekarang+$row->yt_sekarang) - ($in->yt_kemarin+$row->yt_kemarin)),
                                    'rank_yt'=>($rankYt[($in->yt_sekarang+$row->yt_sekarang)]+1)
                                )
                            );
                        }
                    }
                }else{
                    $data[]=array(
                        'id'=>$row->id,
                        'group_name'=>$row->group_name,
                        'follower'=>array(
                            'tw'=>1,
                            'tw_sekarang'=>$row->tw_sekarang,
                            'tw_kemarin'=>$row->tw_kemarin,
                            'growth_tw'=>$row->growth_tw,
                            'num_of_growth_tw'=>$row->num_of_growth_tw,
                            'rank_tw'=>($rankTw[$row->tw_sekarang]+1),
                            'fb'=>2,
                            'fb_sekarang'=>$row->fb_sekarang,
                            'fb_kemarin'=>$row->fb_kemarin,
                            'growth_fb'=>$row->growth_fb,
                            'num_of_growth_fb'=>$row->num_of_growth_fb,
                            'rank_fb'=>($rankFb[$row->fb_sekarang]+1),
                            'ig'=>3,
                            'ig_sekarang'=>$row->ig_sekarang,
                            'ig_kemarin'=>$row->ig_kemarin,
                            'growth_ig'=>$row->growth_ig,
                            'num_of_growth_ig'=>$row->num_of_growth_ig,
                            'rank_ig'=>($rankIg[$row->ig_sekarang]+1),
                            'yt'=>4,
                            'yt_sekarang'=>$row->yt_sekarang,
                            'yt_kemarin'=>$row->yt_kemarin,
                            'growth_yt'=>$row->growth_yt,
                            'num_of_growth_yt'=>$row->num_of_growth_yt,
                            'rank_yt'=>($rankYt[$row->yt_sekarang]+1)
                        )
                    );
                }
            }else if($row->id==5 || $row->id==12){
                foreach($tambahanOverAllTvOthers as $ro){
                    $data[]=array(
                        'id'=>$ro->id,
                        'group_name'=>$ro->unit_name,
                        'follower'=>array(
                            'tw'=>1,
                            'tw_sekarang'=>$ro->total_tw_sekarang,
                            'tw_kemarin'=>$ro->total_tw_kemarin,
                            'growth_tw'=>$ro->total_growth_tw,
                            'num_of_growth_tw'=>$ro->total_num_of_growth_tw,
                            'rank_tw'=>($rankTw[$ro->total_tw_sekarang]+1),
                            'fb'=>2,
                            'fb_sekarang'=>$ro->total_fb_sekarang,
                            'fb_kemarin'=>$ro->total_fb_kemarin,
                            'growth_fb'=>$ro->total_growth_fb,
                            'num_of_growth_fb'=>$ro->total_num_of_growth_fb,
                            'rank_fb'=>($rankFb[$ro->total_fb_sekarang]+1),
                            'ig'=>3,
                            'ig_sekarang'=>$ro->total_ig_sekarang,
                            'ig_kemarin'=>$ro->total_ig_kemarin,
                            'growth_ig'=>$ro->total_growth_ig,
                            'num_of_growth_ig'=>$ro->total_num_of_growth_ig,
                            'rank_ig'=>($rankIg[$ro->total_ig_sekarang]+1),
                            'yt'=>4,
                            'yt_sekarang'=>$ro->total_yt_sekarang,
                            'yt_kemarin'=>$ro->total_yt_kemarin,
                            'growth_yt'=>$ro->total_growth_yt,
                            'num_of_growth_yt'=>$ro->total_num_of_growth_yt,
                            'rank_yt'=>($rankYt[$ro->total_yt_sekarang]+1)
                        )
                    );    
                }
            }else{
                $data[]=array(
                    'id'=>$row->id,
                    'group_name'=>$row->group_name,
                    'follower'=>array(
                        'tw'=>1,
                        'tw_sekarang'=>$row->tw_sekarang,
                        'tw_kemarin'=>$row->tw_kemarin,
                        'growth_tw'=>$row->growth_tw,
                        'num_of_growth_tw'=>$row->num_of_growth_tw,
                        'rank_tw'=>($rankTw[$row->tw_sekarang]+1),
                        'fb'=>2,
                        'fb_sekarang'=>$row->fb_sekarang,
                        'fb_kemarin'=>$row->fb_kemarin,
                        'growth_fb'=>$row->growth_fb,
                        'num_of_growth_fb'=>$row->num_of_growth_fb,
                        'rank_fb'=>($rankFb[$row->fb_sekarang]+1),
                        'ig'=>3,
                        'ig_sekarang'=>$row->ig_sekarang,
                        'ig_kemarin'=>$row->ig_kemarin,
                        'growth_ig'=>$row->growth_ig,
                        'num_of_growth_ig'=>$row->num_of_growth_ig,
                        'rank_ig'=>($rankIg[$row->ig_sekarang]+1),
                        'yt'=>4,
                        'yt_sekarang'=>$row->yt_sekarang,
                        'yt_kemarin'=>$row->yt_kemarin,
                        'growth_yt'=>$row->growth_yt,
                        'num_of_growth_yt'=>$row->num_of_growth_yt,
                        'rank_yt'=>($rankYt[$row->yt_sekarang]+1)
                    )
                );
            }
        }

        return $data;
    }

    public function highlight_group_overall_account(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
            'typeunit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group="where a.group_unit_id='".$request->input('group')."'";
        }else{
            $group="";
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        switch($typeunit){
            case "TV":
                    $filtergroup="where a.id in(1,2,3,4,5)";
                    $othergroup=5;
                break;
            case "Publisher":
                    $filtergroup="where a.id in(1,3,9,10,11,12)";
                    $othergroup=12;
                break;
            case "Radio":
                    $filtergroup="where a.id in(6,7,8,9)";
                    $othergroup=5;
                break;
            case "KOL":
                    $filtergroup="";
                break;  
            default:
                    $filtergroup="";
                    $othergroup=5;
                break;
        }

        $group=\DB::select("select terjadi.group_unit_id,terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt
                from (
                    select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                    sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                    sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                    from 
                    business_unit a 
                    left join program_unit b on b.business_unit_id=a.id
                    left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                    left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id
                    union all 
                    select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
                    a.group_unit_id,e.group_name,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                    sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                    sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                    from 
                    business_unit a 
                    left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                    left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                    left join group_unit e on e.id=a.group_unit_id
                    where a.type_unit='$typeunit'
                    group by a.id 
                ) as terjadi
            group by terjadi.group_unit_id");

        $tambahanOverAllTvOthers=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            ((sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) * 100) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            ((sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) * 100) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            ((sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) * 100) as total_growth_ig,
            (sum(terjadi.ig_sekarang) - sum(terjadi.ig_kemarin)) as total_num_of_growth_ig,
            sum(terjadi.yt_kemarin) as total_yt_kemarin,
            sum(terjadi.yt_sekarang) as total_yt_sekarang,
            ((sum(terjadi.yt_sekarang) / sum(terjadi.yt_kemarin) - 1) * 100) as total_growth_yt,
            (sum(terjadi.yt_sekarang) - sum(terjadi.yt_kemarin)) as total_num_of_growth_yt  
            from
            (
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=$othergroup
                and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
                union all 
                select ifnull(a.id,'SUBTOTAL') as id, a.unit_name, 
                ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
                sum(if(c.tanggal='$kemarin' and b.sosmed_id=4,c.follower,0)) as yt_kemarin,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) as yt_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                where a.group_unit_id=$othergroup and a.type_unit='$typeunit'
                group by a.group_unit_id,a.id
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        $data=array();

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($group as $k){
            if($k->group_unit_id==5 || $k->group_unit_id==12){
                foreach($tambahanOverAllTvOthers as $ro){
                    array_push($arrTw,$ro->total_tw_sekarang);
                    array_push($arrFb,$ro->total_fb_sekarang);
                    array_push($arrIg,$ro->total_ig_sekarang);    
                    array_push($arrYt,$ro->total_yt_sekarang);    
                }
            }else{
                array_push($arrTw,$k->total_tw_sekarang);
                array_push($arrFb,$k->total_fb_sekarang);
                array_push($arrIg,$k->total_ig_sekarang);
                array_push($arrYt,$k->total_yt_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);

        foreach($group as $row){
            if($row->group_unit_id==5 || $row->group_unit_id==12){
                foreach($tambahanOverAllTvOthers as $ro){
                    $data[]=array(
                        'id'=>$ro->id,
                        'group_name'=>$ro->unit_name,
                        'follower'=>array(
                            'tw'=>1,
                            'tw_sekarang'=>$ro->total_tw_sekarang,
                            'tw_kemarin'=>$ro->total_tw_kemarin,
                            'growth_tw'=>$ro->total_growth_tw,
                            'num_of_growth_tw'=>$ro->total_num_of_growth_tw,
                            'rank_tw'=>($rankTw[$ro->total_tw_sekarang]+1),
                            'fb'=>2,
                            'fb_sekarang'=>$ro->total_fb_sekarang,
                            'fb_kemarin'=>$ro->total_fb_kemarin,
                            'growth_fb'=>$ro->total_growth_fb,
                            'num_of_growth_fb'=>$ro->total_num_of_growth_fb,
                            'rank_fb'=>($rankFb[$ro->total_fb_sekarang]+1),
                            'ig'=>3,
                            'ig_sekarang'=>$ro->total_ig_sekarang,
                            'ig_kemarin'=>$ro->total_ig_kemarin,
                            'growth_ig'=>$ro->total_growth_ig,
                            'num_of_growth_ig'=>$ro->total_num_of_growth_ig,
                            'rank_ig'=>($rankIg[$ro->total_ig_sekarang]+1),
                            'yt'=>4,
                            'yt_sekarang'=>$ro->total_yt_sekarang,
                            'yt_kemarin'=>$ro->total_yt_kemarin,
                            'growth_yt'=>$ro->total_growth_yt,
                            'num_of_growth_yt'=>$ro->total_num_of_growth_yt,
                            'rank_yt'=>($rankYt[$ro->total_yt_sekarang]+1)
                        )
                    );    
                }
            }else{
                $data[]=array(
                    'id'=>$row->group_unit_id,
                    'group_name'=>$row->group_name,
                    'follower'=>array(
                        'tw'=>1,
                        'tw_sekarang'=>$row->total_tw_sekarang,
                        'tw_kemarin'=>$row->total_tw_kemarin,
                        'growth_tw'=>$row->total_growth_tw,
                        'num_of_growth_tw'=>$row->total_num_of_growth_tw,
                        'rank_tw'=>($rankTw[$row->total_tw_sekarang]+1),
                        'fb'=>2,
                        'fb_sekarang'=>$row->total_fb_sekarang,
                        'fb_kemarin'=>$row->total_fb_kemarin,
                        'growth_fb'=>$row->total_growth_fb,
                        'num_of_growth_fb'=>$row->total_num_of_growth_fb,
                        'rank_fb'=>($rankFb[$row->total_fb_sekarang]+1),
                        'ig'=>3,
                        'ig_sekarang'=>$row->total_ig_sekarang,
                        'ig_kemarin'=>$row->total_ig_kemarin,
                        'growth_ig'=>$row->total_growth_ig,
                        'num_of_growth_ig'=>$row->total_num_of_growth_ig,
                        'rank_ig'=>($rankIg[$row->total_ig_sekarang]+1),
                        'yt'=>4,
                        'yt_sekarang'=>$row->total_yt_sekarang,
                        'yt_kemarin'=>$row->total_yt_kemarin,
                        'growth_yt'=>$row->total_growth_yt,
                        'num_of_growth_yt'=>$row->total_num_of_growth_yt,
                        'rank_yt'=>($rankYt[$row->total_yt_sekarang]+1)
                    )
                );
            }
        }

        return $data;

    }

    public function higlight_program_account_all_tv(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
            'typeunit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        switch($typeunit){
            case "TV":
                    $filtergroup="where e.group_unit_id in(1,2,3,4,5)  and b.id not in (89, 101, 95, 87)";
                    $othergroup=5;
                break;
            case "Publisher":
                    $filtergroup="where e.group_unit_id in(1,3,9,10,11,12)";
                    $othergroup=12;
                    $filtertv="";
                break;
            case "Radio":
                    $filtergroup="where e.group_unit_id in(6,7,8,9)";
                    $othergroup=5;
                    $filtertv="";
                break;
            case "KOL":
                    $filtergroup="";
                    $filtertv="";
                break;  
            default:
                    $filtergroup="";
                    $othergroup=5;
                    $filtertv="";
                break;
        }

        $program=\DB::select("select b.id,e.unit_name, b.program_name,  
            sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0)) as tw_kemarin,
            sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) as tw_sekarang,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) 
                / 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0))
                - 1
            ) * 100 as growth_tw,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=1,d.follower,0)) 
                - 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=1,d.follower,0))
            ) as num_of_growth_tw,
            sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0)) as fb_kemarin,
            sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) as fb_sekarang,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) 
                / 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0))
                - 1
            ) * 100 as growth_fb,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=2,d.follower,0)) 
                - 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=2,d.follower,0))
            ) as num_of_growth_fb,
            sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0)) as ig_kemarin,
            sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) as ig_sekarang,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) 
                / 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0))
                - 1
            ) * 100 as growth_ig,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=3,d.follower,0)) 
                - 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=3,d.follower,0))
            ) as num_of_growth_ig,
            sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0)) as yt_kemarin,
            sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) as yt_sekarang,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) 
                / 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0))
                - 1
            ) * 100 as growth_yt,
            ( 
                sum(if(d.tanggal='$sekarang' and c.sosmed_id=4,d.follower,0)) 
                - 
                sum(if(d.tanggal='$kemarin' and c.sosmed_id=4,d.follower,0))
            ) as num_of_growth_yt
            from program_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit as e on e.id=b.business_unit_id and e.type_unit='$typeunit'
            $filtergroup
            group by b.id");

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($program as $k){
            array_push($arrTw,$k->num_of_growth_tw);
            array_push($arrFb,$k->num_of_growth_fb);
            array_push($arrIg,$k->num_of_growth_ig);
            array_push($arrYt,$k->num_of_growth_yt);
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);

        $data=array();

        foreach($program as $val){
            $data[]=array(
                'id'=>$val->id,
                'unit_name'=>$val->program_name." - ".$val->unit_name,
                'follower'=>array(
                    'tw'=>1,
                    'growth_tw'=>$val->growth_tw,
                    'num_of_growth_tw'=>$val->num_of_growth_tw,
                    'tw_sekarang'=>$val->tw_sekarang,
                    'rank_tw'=>($rankTw[$val->num_of_growth_tw] + 1),
                    'fb'=>2,
                    'growth_fb'=>$val->growth_fb,
                    'num_of_growth_fb'=>$val->num_of_growth_fb,
                    'fb_sekarang'=>$val->fb_sekarang,
                    'rank_fb'=>($rankFb[$val->num_of_growth_fb] + 1),
                    'ig'=>3,
                    'growth_ig'=>$val->growth_ig,
                    'num_of_growth_ig'=>$val->num_of_growth_ig,
                    'ig_sekarang'=>$val->ig_sekarang,
                    'rank_ig'=>($rankIg[$val->num_of_growth_ig] + 1),
                    'yt'=>4,
                    'growth_yt'=>$val->growth_yt,
                    'num_of_growth_yt'=>$val->num_of_growth_yt,
                    'yt_sekarang'=>$val->yt_sekarang,
                    'rank_yt'=>($rankYt[$val->num_of_growth_yt] + 1)
                )
            );
        }

        return $data;
    }

    public function highlight_target_achivement(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
            'typeunit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group=$request->input('group');
        }else{
            $group=1;
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit='TV';
        }

        switch($typeunit){
            case "TV":
                    $filtergroup="and a.group_unit_id in(1,2,3,4,5)";
                    $othergroup=5;
                break;
            case "Publisher":
                    $filtergroup="and a.group_unit_id in(1,3,9,10,11,12)";
                    $othergroup=12;
                    $filtertv="";
                break;
            case "Radio":
                    $filtergroup="and a.group_unit_id in(6,7,8,9)";
                    $othergroup=5;
                    $filtertv="";
                break;
            case "KOL":
                    $filtergroup="";
                    $filtertv="";
                break;  
            default:
                    $filtergroup="";
                    $othergroup=5;
                    $filtertv="";
                break;
        }

        $target=\DB::select("select a.id, a.group_unit_id, a.unit_name, b.target_use, 
            sum(if(b.sosmed_id=1, c.target,0)) as target_tw,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) as follower_tw,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=1, d.follower,0)) / sum(if(b.sosmed_id=1, c.target,0)) * 100) as acv_tw,
            sum(if(b.sosmed_id=2, c.target,0)) as target_fb,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) as follower_fb,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=2, d.follower,0)) / sum(if(b.sosmed_id=2, c.target,0)) * 100) as acv_fb,
            sum(if(b.sosmed_id=3, c.target,0)) as target_ig,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) as follower_ig,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=3, d.follower,0)) / sum(if(b.sosmed_id=3, c.target,0)) * 100) as acv_ig,
            sum(if(b.sosmed_id=4, c.target,0)) as target_yt,
            sum(if(d.tanggal='$sekarang' and b.sosmed_id=4, d.follower,0)) as follower_yt,
            ( sum(if(d.tanggal='$sekarang' and b.sosmed_id=4, d.follower,0)) / sum(if(b.sosmed_id=4, c.target,0)) * 100) as acv_yt
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_target c on c.unit_sosmed_id=b.id
            left join unit_sosmed_follower d on d.unit_sosmed_id=b.id and d.tanggal='$sekarang'
            where a.type_unit='$typeunit' $filtergroup
            GROUP by a.id");

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as id, a.business_unit_id,
            d.group_unit_id, a.program_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) -1)*100 as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) -1)*100 as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_ig,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=4, c.follower,0)) as yt_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as yt_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) -1)*100 as growth_yt
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id and d.type_unit='$typeunit'
            where a.id in (89, 101, 95, 87)
            group by a.id
            with ROLLUP");

        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($target as $r){
            if($r->group_unit_id==1){
                if($r->id==4){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            array_push($arrTw,$in->tw_sekarang);
                            array_push($arrFb,$in->fb_sekarang);
                            array_push($arrIg,$in->ig_sekarang);                
                            array_push($arrYt,$in->yt_sekarang);                
                        }
                    }
                }else{
                    array_push($arrTw,$r->follower_tw);
                    array_push($arrFb,$r->follower_fb);
                    array_push($arrIg,$r->follower_ig);
                    array_push($arrYt,$r->follower_yt);
                }
            }else{
                array_push($arrTw,$r->follower_tw);
                array_push($arrFb,$r->follower_fb);
                array_push($arrIg,$r->follower_ig);
                array_push($arrYt,$r->follower_yt);
            }
        }

        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);

        $data=array();
        foreach($target as $row){
            if($row->group_unit_id==1){
                if($row->id==4){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            
                            if($row->target_yt){
                                $act_yt=number_format(($row->follower_yt+$in->yt_sekarang) /  $row->target_yt * 100);
                            }else{
                                $act_yt=0;
                            }

                            $data[]=array(
                                'id'=>$row->id,
                                'unit_name'=>$row->unit_name,
                                'follower'=>array(
                                    'tw'=>1,
                                    'target_tw'=>$row->target_tw,
                                    'tw_sekarang'=>($row->follower_tw+$in->tw_sekarang),
                                    'acv_tw'=>number_format(($row->follower_tw+$in->tw_sekarang) /  $row->target_tw * 100),
                                    'rank_tw'=>($rankTw[$in->tw_sekarang]+1),
                                    'fb'=>2,
                                    'target_fb'=>$row->target_fb,
                                    'fb_sekarang'=>($row->follower_fb+$in->fb_sekarang),
                                    'acv_fb'=>number_format(($row->follower_fb+$in->fb_sekarang) /  $row->target_fb * 100),
                                    'rank_fb'=>($rankFb[$in->fb_sekarang]+1),
                                    'ig'=>3,
                                    'target_ig'=>$row->target_ig,
                                    'ig_sekarang'=>($row->follower_ig+$in->ig_sekarang),
                                    'acv_ig'=>number_format(($row->follower_ig+$in->ig_sekarang) /  $row->target_ig * 100),
                                    'rank_ig'=>($rankIg[$in->ig_sekarang]+1),
                                    'yt'=>4,
                                    'target_yt'=>$row->target_yt,
                                    'yt_sekarang'=>($row->follower_yt+$in->yt_sekarang),
                                    'acv_yt'=>$act_yt,
                                    'rank_yt'=>($rankYt[$in->yt_sekarang]+1)
                                )
                            );
                        }
                    }
                }else{
                    if($row->target_yt){
                        $act_yt=number_format($row->follower_yt /  $row->target_yt * 100);
                    }else{
                        $act_yt=0;
                    }

                    $data[]=array(
                        'id'=>$row->id,
                        'unit_name'=>$row->unit_name,
                        'follower'=>array(
                            'tw'=>1,
                            'target_tw'=>$row->target_tw,
                            'tw_sekarang'=>$row->follower_tw,
                            'acv_tw'=>number_format($row->follower_tw /  $row->target_tw * 100),
                            'rank_tw'=>($rankTw[$row->follower_tw]+1),
                            'fb'=>2,
                            'target_fb'=>$row->target_fb,
                            'fb_sekarang'=>$row->follower_fb,
                            'acv_fb'=>number_format($row->follower_fb /  $row->target_fb * 100),
                            'rank_fb'=>($rankFb[$row->follower_fb]+1),
                            'ig'=>3,
                            'target_ig'=>$row->target_ig,
                            'ig_sekarang'=>$row->follower_ig,
                            'acv_ig'=>number_format($row->follower_ig /  $row->target_ig * 100),
                            'rank_ig'=>($rankIg[$row->follower_ig]+1),
                            'yt'=>4,
                            'target_yt'=>$row->target_yt,
                            'yt_sekarang'=>$row->follower_yt,
                            'acv_yt'=>$act_yt,
                            'rank_yt'=>($rankYt[$row->follower_yt]+1)
                        )
                    );
                }
            }
        }

        return $data;
    }

    public function daily_chart_program(Request $request,$id){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('bulan')){
            $bulan=date('Y-m',strtotime($request->input('bulan')));
        }else{
            $bulan=date('Y-m');
        }

        $program=\DB::select("select a.id, a.business_unit_id, a.program_name, c.tanggal, 
            sum(if(b.sosmed_id=1, c.follower,0)) as tw,
            sum(if(b.sosmed_id=2, c.follower,0)) as fb,
            sum(if(b.sosmed_id=3, c.follower,0)) as ig
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            where a.id=$id
            and date_format(c.tanggal,'%Y-%m')='$bulan'
            group by c.tanggal");

        $tanggal=array();
        $fb=array();
        $ig=array();
        $tw=array();
        foreach($program as $row){
            array_push($tanggal,date('d',strtotime($row->tanggal)));
            array_push($tw,$row->tw);
            array_push($fb,$row->fb);
            array_push($ig,$row->ig);
        }

        return array(
            'tanggal'=>$tanggal,
            'tw'=>$tw,
            'fb'=>$fb,
            'ig'=>$ig
        );
    }

    public function all_program_growth(Request $request){
        $rules=[
            'tanggal'=>'date',
            'kemarin'=>'nullable|date',
            'group'=>'alpha_num',
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));

            if($request->has('pilih')){
                $pilih=$request->input('pilih');

                if($pilih=="on"){
                    if($request->has('kemarin')){
                        $kemarin=date('Y-m-d',strtotime($request->input('kemarin')));
                    }else{
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                    }
                }else{
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
                }
            }else{
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
            }
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group=$request->input('group');
        }else{
            $group=1;
        }

        if($request->has('unit') && $request->input('unit')!=null){
            $unit=$request->input('unit');
            $filterunit="and a.business_unit_id=$unit";
        }else{
            $unit=1;
            $filterunit="";
        }

        $program=\DB::select("select d.id,d.group_unit_id, d.unit_name, b.type_sosmed,a.program_name,c.tanggal, 
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as tw_sekarang,
            (((sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) -1) * 100) as growth_tw,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=1, c.follower,0))) as num_of_growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as fb_sekarang,
            (((sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) -1) * 100) as growth_fb,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=2, c.follower,0))) as num_of_growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as ig_sekarang,
            (((sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) -1) * 100) as growth_ig,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) - sum(if(c.tanggal='$kemarin' and b.sosmed_id=3, c.follower,0))) as num_of_growth_ig
            from program_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join business_unit d on d.id=a.business_unit_id 
            where d.type_unit='TV'
            $filterunit
            group by a.id order by d.id");

        return view('sosmed.view.program_growth')
            ->with('program',$program)
            ->with('kemarin',$kemarin)
            ->with('sekarang',$sekarang);
    }


    /* chart */
    public function all_tier(Request $request){
        $rules=[
            'tanggal'=>'date'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            return array(
                'success'=>false,
                'pesan'=>'Validasi error',
                'errors'=>$validasi->errors()->all()
            );
        }

        if($request->has('tanggal')){
            $tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $tanggal=date('Y-m-d');
        }

        $chart=\DB::select("select a.id, a.group_unit_id, a.unit_name,
            sum(if(b.sosmed_id=1,c.follower,0)) as tw,
            sum(if(b.sosmed_id=2,c.follower,0)) as fb,
            sum(if(b.sosmed_id=3,c.follower,0)) as ig,
            (sum(if(b.sosmed_id=1,c.follower,0)) + sum(if(b.sosmed_id=2,c.follower,0)) + sum(if(b.sosmed_id=3,c.follower,0))) as total
            from business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left JOIN unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tanggal'
            GROUP by a.id");

        return $chart;
    }

    public function chart_official_tv(Request $request){
        $sekarang=date('Y-m');

        $chart=\App\Models\Sosmed\Businessunit::with(
            [
                'followers'=>function($q) use($sekarang){
                    $q->where(\DB::Raw("date_format(tanggal,'%Y-%m')"),$sekarang)
                        ->where('type_sosmed','corporate')
                        ->where('sosmed_id',1);
                }
            ]
        )
        ->select('id','group_unit_id','unit_name')
        ->where('id',5)
        ->orWhere('id',10)
        ->orWhere('id',2)
        ->get();

        $data=array();
        $labels=array();

        foreach($chart as $key=>$val){

            if($val->id==1){
                $line="#a6cee3";
                $marker=array(
                    "background-color"=>"#a6cee3",
                    "border-color"=>"#a6cee3"
                );

            }elseif($val->id==6){
                $line="#1f78b4";
                $marker=array(
                    "background-color"=>"#1f78b4",
                    "border-color"=>"#1f78b4"
                );
            }elseif($val->id==5){
                $line="#1f78b4";
                $marker=array(
                    "background-color"=>"#1f78b4",
                    "border-color"=>"#1f78b4"
                );
            }elseif($val->id==10){
                $line="#1f78b4";
                $marker=array(
                    "background-color"=>"#1f78b4",
                    "border-color"=>"#1f78b4"
                );
            }elseif($val->id==2){
                $line="#1f78b4";
                $marker=array(
                    "background-color"=>"#1f78b4",
                    "border-color"=>"#1f78b4"
                );
            }
            

            $values=array();
            foreach($val->followers as $f){
                $values[]=$f->follower;

                //cek labels
                if(!in_array(date('d',strtotime($f->tanggal)),$labels)){
                    array_push($labels,date('d',strtotime($f->tanggal)));
                }
            }

            $data[]=array(
                'values'=>$values,
                'text'=>$val->unit_name,
                'line-color'=>$line,
                'marker'=>$marker
            );
        }

        return array('labels'=>$labels,'series'=>$data);
    }
    /* end chart */

    public function export_excel(Request $request){
        // return array(
        //     'typeunit'=>$request->input('typeunit'),
        //     'typeaccount'=>$request->input('typeaccount'),
        //     'start'=>date('Y-m-d',strtotime($request->input('start'))),
        //     'end'=>date('Y-m-d',strtotime($request->input('end')))
        // );

        if($request->has('typeunit') && $request->input('typeunit')!=null){
            return "type unit ada";
        }

        if($request->has('typeaccount') && $request->input('typeaccount')!=null){
            return "type account ada";
        }

        return "tidak ada semua";

        $corporate=\DB::select("SELECT
                a.group_unit_id,
                a.unit_name,
                a.type_unit,
                IF(
                    b.type_sosmed = 'corporate',
                    'corporate',
                    'program'
                ) AS TYPE,
                b.sosmed_id,
                b.unit_sosmed_name,
                c.tanggal,
                c.follower
            FROM
                business_unit a
            LEFT JOIN unit_sosmed b ON
                b.business_program_unit = a.id AND b.type_sosmed = 'corporate'
            LEFT JOIN unit_sosmed_follower c ON
                c.unit_sosmed_id = b.id
            ORDER BY
                a.id,
                c.tanggal");

        return $corporate;
    }

    public function chart_by_tier(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        $filter=$request->input('filter');

        switch($filter){
            case "all":
                    /**
                     * chart all, gabungan official dan program
                     */
                    $chart=\DB::select("select total.id,total.unit_name,total.group_unit_id,
                        sum(total.twitter) as total_twitter,
                        sum(total.facebook) as total_facebook,
                        sum(total.instagram) as total_instagram,
                        sum(total.youtube) as total_youtube
                        from 
                        (
                            select a.id,a.group_unit_id, a.unit_name, c.tanggal, 
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) twitter,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) facebook,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) instagram,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) youtube
                            from business_unit a
                            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                            where a.type_unit='$typeunit'
                            group by a.id
                            WITH ROLLUP
                            UNION ALL 
                            select if(a.id is null, 'tidak', a.business_unit_id) as idnya,d.group_unit_id, d.unit_name, c.tanggal, 
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) twitter,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) facebook,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) instagram,
                            sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) youtube
                            from program_unit a
                            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                            left join business_unit d on d.id=a.business_unit_id
                            where d.type_unit='$typeunit'
                            group by a.business_unit_id
                            WITH ROLLUP
                        ) as total
                        group by total.id
                        order by total.group_unit_id,total.id desc");

                        usort($chart, function($a, $b) {
                            return $b->group_unit_id <=> $a->group_unit_id;
                        });
                break;
            case "official":
            default:
                    $chart=\DB::select("select total.* from (select a.id,a.group_unit_id, a.unit_name, c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) total_twitter,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) total_facebook,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) total_instagram,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) total_youtube
                        from business_unit a
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        where a.type_unit='$typeunit'
                        group by a.id
                        WITH ROLLUP) AS total
                        order by total.group_unit_id, total.id desc");

                    usort($chart, function($a, $b) {
                        return $b->group_unit_id <=> $a->group_unit_id;
                    });
                break;
            case "program":
                    $chart=\DB::select("select total.* from (select if(a.id is null, 'tidak', a.business_unit_id) as id, a.business_unit_id,d.group_unit_id, d.unit_name, c.tanggal, 
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) total_twitter,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) total_facebook,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) total_instagram,
                        sum(if(c.tanggal='$sekarang' and b.sosmed_id=4,c.follower,0)) total_youtube
                        from program_unit a
                        left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                        left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                        left join business_unit d on d.id=a.business_unit_id
                        where d.type_unit='$typeunit'
                        group by a.business_unit_id
                        WITH ROLLUP) as total
                        order by total.group_unit_id,total.business_unit_id desc");

                    usort($chart, function($a, $b) {
                        return $b->group_unit_id <=> $a->group_unit_id;
                    });
                break;
        }

        $tambahanInews=\DB::select("select ifnull(a.id,'TOTAL') as idnya, a.business_unit_id,
                d.group_unit_id, a.program_name,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=1, c.follower,0)) as total_twitter,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=2, c.follower,0)) as total_facebook,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3, c.follower,0)) as total_instagram,
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=4, c.follower,0)) as total_youtube
                from program_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
                left join business_unit d on d.id=a.business_unit_id and d.type_unit='TV'
                where a.id in (89, 101, 95, 87)
                group by a.id
                with ROLLUP
                HAVING idnya='TOTAL'");

        return array('chart'=>$chart,'inews'=>$tambahanInews);
    }

    public function official_by_tier(Request $request){
        if($request->has('idsosmed')){
            $idsosmed=$request->input('idsosmed');
        }else{
            $idsosmed=1;
        }

        if($request->input('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('periode')){
            $periode=$request->input('periode');
        }else{
            $periode=date('Y-m');
        }

        $follower=\DB::select("select a.id, a.unit_name, c.tanggal, 
            @kemarin:=(
                select cc.follower from business_unit aa
                left join unit_sosmed bb on bb.business_program_unit=aa.id and bb.type_sosmed='corporate'
                left join unit_sosmed_follower cc on cc.unit_sosmed_id=bb.id
                where bb.sosmed_id=$idsosmed
                and aa.id=a.id
                and cc.tanggal < c.tanggal
                order by cc.tanggal desc
                limit 1
            ) as kemarin,
            c.follower,
            ((c.follower / @kemarin) - 1)*100 as growth,
            (c.follower - @kemarin) num_of_growth
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            where b.sosmed_id=$idsosmed
            and a.type_unit='$typeunit'
            and date_format(c.tanggal,'%Y-%m')='$periode'
            order by a.id");

        $unit=\App\Models\Sosmed\Businessunit::where('type_unit',$typeunit)
                ->get();

        $warna=array("#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
                "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2",
                "#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
                "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2");

        $data=array();
        foreach($unit as $key=>$val){
            $fol=array();
            for($a=0;$a<count($follower);$a++){
                if($follower[$a]->id==$val->id){
                    $fol[]=array(
                        'tanggal'=>$follower[$a]->tanggal,
                        'follower'=>$follower[$a]->follower,
                        'growth'=>$follower[$a]->growth,
                        'num_of_growth'=>$follower[$a]->num_of_growth
                    );
                }
            }

            $data[]=array(
                'id'=>$val->id,
                'warna'=>$warna[$key],
                'unit_name'=>$val->unit_name,
                'follower'=>$fol
            );
        }

        return $data;
    }

    public function program_by_tier(Request $request){
        if($request->has('idsosmed')){
            $idsosmed=$request->input('idsosmed');
        }else{
            $idsosmed=1;
        }

        if($request->input('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('periode')){
            $periode=date('Y-m-d',strtotime($request->input('periode')));
        }else{
            $periode=date('Y-m');
        }

        if($request->has('unit')){
            $unit=$request->input('unit');
        }else{
            $unit=1;
        }

        $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
            ->where('business_unit.type_unit','TV')
            ->where('business_unit_id',$unit)
            ->select(
                'program_unit.id',
                'program_unit.program_name'
            )
            ->get();

        $follower=\DB::select("select a.id, a.program_name, c.tanggal, 
            @kemarin:=(
                select cc.follower from program_unit aa
                left join unit_sosmed bb on bb.business_program_unit=aa.id and bb.type_sosmed='program'
                left join unit_sosmed_follower cc on cc.unit_sosmed_id=bb.id
                left join business_unit dd on dd.id=aa.business_unit_id
                where bb.sosmed_id=$idsosmed
                and aa.id=a.id
                and cc.tanggal < c.tanggal
                and dd.type_unit='TV'
                and aa.business_unit_id=$unit
                order by cc.tanggal desc
                limit 1
            ) as kemarin,
            c.follower,
            ((c.follower / @kemarin) - 1)*100 as growth,
            (c.follower - @kemarin) as num_of_growth
            from program_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            left join business_unit d on d.id=a.business_unit_id
            where b.sosmed_id=$idsosmed
            and d.type_unit='$typeunit'
            and date_format(c.tanggal,'%Y-%m')='$periode'
            and a.business_unit_id=$unit
            order by a.id");

        $warna=array("#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2",
            "#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2",
            "#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2");

        $data=array();
        foreach($program as $key=>$val){
            $fol=array();
            for($a=0;$a<count($follower);$a++){
                if($follower[$a]->id==$val->id){
                    $fol[]=array(
                        'tanggal'=>$follower[$a]->tanggal,
                        'follower'=>$follower[$a]->follower,
                        'growth'=>$follower[$a]->growth,
                        'num_of_growth'=>$follower[$a]->num_of_growth
                    );
                }
            }

            $data[]=array(
                'id'=>$val->id,
                'warna'=>$warna[$key],
                'program_name'=>$val->program_name,
                'follower'=>$fol
            );
        }

        return array('success'=>true,'data'=>$data);
    }

    public function post_program_by_tier(Request $request){
        $rules=[
            'idsosmed'=>'required',
            'typeunit'=>'required',
            'periode'=>'required',
            'group'=>'required',
            'unit'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>"Validasi error",
                'errors'=>$validasi->errors()->all()
            );

            return $data;
        }


        if($request->has('idsosmed')){
            $idsosmed=$request->input('idsosmed');
        }else{
            $idsosmed=1;
        }

        if($request->input('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('periode')){
            $periode=date('Y-m',strtotime($request->input('periode')));
        }else{
            $periode=date('Y-m');
        }

        if($request->has('unit')){
            $unit=$request->input('unit');
        }else{
            $unit=1;
        }

        $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
            ->where('business_unit.type_unit','TV')
            ->where('business_unit_id',$unit)
            ->select(
                'program_unit.id',
                'program_unit.program_name'
            )
            ->get();

        $follower=\DB::select("select a.id, a.program_name, c.tanggal, 
            @kemarin:=(
                select cc.follower from program_unit aa
                left join unit_sosmed bb on bb.business_program_unit=aa.id and bb.type_sosmed='program'
                left join unit_sosmed_follower cc on cc.unit_sosmed_id=bb.id
                left join business_unit dd on dd.id=aa.business_unit_id
                where bb.sosmed_id=$idsosmed
                and aa.id=a.id
                and cc.tanggal < c.tanggal
                and dd.type_unit='TV'
                and aa.business_unit_id=$unit
                order by cc.tanggal desc
                limit 1
            ) as kemarin,
            c.follower,
            ((c.follower / @kemarin) - 1)*100 as growth,
            (c.follower - @kemarin) as num_of_growth
            from program_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id
            left join business_unit d on d.id=a.business_unit_id
            where b.sosmed_id=$idsosmed
            and d.type_unit='$typeunit'
            and date_format(c.tanggal,'%Y-%m')='$periode'
            and a.business_unit_id=$unit
            order by a.id");

        $warna=array("#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2",
            "#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2",
            "#0e529e","#e6232b","#2d2d2b","#598e48","#ec6514","#1c9cff",
            "#af28a3","#693995","#cb0101","#f39","#ffd330","#bec4bd","#b4fdf2");

        $data=array();
        foreach($program as $key=>$val){
            $fol=array();
            for($a=0;$a<count($follower);$a++){
                if($follower[$a]->id==$val->id){
                    $fol[]=array(
                        'tanggal'=>$follower[$a]->tanggal,
                        'follower'=>$follower[$a]->follower,
                        'growth'=>$follower[$a]->growth,
                        'num_of_growth'=>$follower[$a]->num_of_growth
                    );
                }
            }

            $data[]=array(
                'id'=>$val->id,
                'warna'=>$warna[$key],
                'program_name'=>$val->program_name,
                'follower'=>$fol
            );
        }

        return array('success'=>true,'data'=>$data);
    }

    public function top_official_twitter_today(Request $request){
        if($request->input('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('idsosmed')){
            $idsosmed=$request->input('idsosmed');
            switch($idsosmed){
                case 1:
                        $unit=\App\Models\Sosmed\Businessunit::with(
                            [
                                'follower_twitter'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                            ->orderBy('follower','desc');
                                },
                                'follower_twitter.unitsosmed'
                            ]
                        )
                        ->where('type_unit',$typeunit)
                        ->whereHas('follower_twitter')->get();
                    break;
                case 2:
                        $unit=\App\Models\Sosmed\Businessunit::with(
                            [
                                'follower_facebook'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                            ->orderBy('follower','desc');
                                },
                                'follower_facebook.unitsosmed'
                            ]
                        )
                        ->where('type_unit',$typeunit)
                        ->whereHas('follower_facebook')->get();
                    break;
                case 3:
                        $unit=\App\Models\Sosmed\Businessunit::with(
                            [
                                'follower_instagram'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                            ->orderBy('follower','desc');
                                },
                                'follower_instagram.unitsosmed'
                            ]
                        )
                        ->where('type_unit',$typeunit)
                        ->whereHas('follower_instagram')->get();
                    break;
                case 4:
                        $unit=\App\Models\Sosmed\Businessunit::with(
                            [
                                'follower_youtube'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                            ->orderBy('follower','desc');
                                },
                                'follower_youtube.unitsosmed'
                            ]
                        )
                        ->where('type_unit',$typeunit)
                        ->whereHas('follower_youtube')->get();
                    break;
                default:

                    break;
            }
        }

        $data=array();
        foreach($unit as $row){
            $fol=0;
            switch($idsosmed){
                case 1:
                        if(count($row->follower_twitter)>0){
                            $fol=$row->follower_twitter[0]->follower;
                        }
                    break;
                case 2:
                        if(count($row->follower_facebook)>0){
                            $fol=$row->follower_facebook[0]->follower;
                        }
                    break;
                case 3:
                        if(count($row->follower_instagram)>0){
                            $fol=$row->follower_instagram[0]->follower;
                        }
                    break;
                case 4:
                        if(count($row->follower_youtube)>0){
                            $fol=$row->follower_youtube[0]->follower;
                        }
                    break;
            }
            
            $data[]=array(
                'id'=>$row->id,
                'unit_name'=>$row->unit_name,
                'follower'=>$fol
            );
        }

        usort($data, function($a, $b) {
            return $b['follower'] <=> $a['follower'];
        });

        return $data;
    }

    public function top_program_twitter_today(Request $request){
        if($request->input('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('typeunit')){
            $typeunit=$request->input('typeunit');
        }else{
            $typeunit="TV";
        }

        if($request->has('idsosmed')){
            $idsosmed=$request->input('idsosmed');

            switch($idsosmed){
                case 1:
                        $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
                            ->where('business_unit.type_unit',$typeunit)
                            ->select('program_unit.id','program_unit.business_unit_id','program_unit.program_name')
                            ->with(
                                [
                                    'follower_twitter'=>function($q) use($sekarang){
                                        $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                            ->orderBy('follower','desc');
                                    },
                                    'follower_twitter.unitsosmed'
                                ]
                            )
                            ->whereHas('follower_twitter')
                            ->get();
                    break;
                case 2:
                    $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
                        ->where('business_unit.type_unit',$typeunit)
                        ->select('program_unit.id','program_unit.business_unit_id','program_unit.program_name')
                        ->with(
                            [
                                'follower_facebook'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                        ->orderBy('follower','desc');
                                },
                                'follower_facebook.unitsosmed'
                            ]
                        )
                        ->whereHas('follower_facebook')
                        ->get();       
                    break;
                case 3:
                    $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
                        ->where('business_unit.type_unit',$typeunit)
                        ->select('program_unit.id','program_unit.business_unit_id','program_unit.program_name')
                        ->with(
                            [
                                'follower_instagram'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                        ->orderBy('follower','desc');
                                },
                                'follower_instagram.unitsosmed'
                            ]
                        )
                        ->whereHas('follower_instagram')
                        ->get();
                    break;
                case 4:
                    $program=\App\Models\Sosmed\Programunit::leftJoin('business_unit','business_unit.id','=','program_unit.business_unit_id')
                        ->where('business_unit.type_unit',$typeunit)
                        ->select('program_unit.id','program_unit.business_unit_id','program_unit.program_name')
                        ->with(
                            [
                                'follower_youtube'=>function($q) use($sekarang){
                                    $q->where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"),$sekarang)
                                        ->orderBy('follower','desc');
                                },
                                'follower_youtube.unitsosmed'
                            ]
                        )
                        ->whereHas('follower_youtube')
                        ->get();
                    break;
            }
        }


        $data=array();
        foreach($program as $row){
            $fol=0;
            switch($idsosmed){
                case 1:
                        if(count($row->follower_twitter)>0){
                            $fol=$row->follower_twitter[0]->follower;
                        }
                    break;
                case 2:
                        if(count($row->follower_facebook)>0){
                            $fol=$row->follower_facebook[0]->follower;
                        }
                    break;
                case 3:
                        if(count($row->follower_instagram)>0){
                            $fol=$row->follower_instagram[0]->follower;
                        }
                    break;
                case 4:
                        if(count($row->follower_youtube)>0){
                            $fol=$row->follower_youtube[0]->follower;
                        }
                    break;
            }

            $data[]=array(
                'id'=>$row->id,
                'program_name'=>$row->program_name,
                'follower'=>$fol
            );
        }

        usort($data, function($a, $b) {
            return $b['follower'] <=> $a['follower'];
        });

        return $data;
    }
}