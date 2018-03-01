<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ReportController extends Controller
{
    public function target_vs_achievement(Request $request){
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        if($request->has('tanggal')){
            $tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $tanggal=date('Y-m-d');
        }

        $unit=\App\Models\Sosmed\Businessunit::with(
            [
                'sosmed',
                'sosmed.sosmed',
                'sosmed.target',
                'sosmed.followers'=>function($q) use($tanggal){
                    $q->where('tanggal',$tanggal);
                }
            ]
        )->whereHas('sosmed');

        if($request->has('group')){
            $unit=$unit->where('group_unit_id',$request->input('group'));
        }

        $unit=$unit->get();


        /*addional color  */
        $colorheader=["#008ef6","#5054ab","#a200b2"];
        $subheader=["#008ef6","#008ef6","#008ef6","#5054ab","#5054ab","#5054ab","#a200b2","#a200b2","#a200b2"];

        return array(
            'unit'=>$unit,
            'sosmed'=>$sosmed,
            'tanggal'=>$tanggal,
            'header'=>$colorheader,
            'subheader'=>$subheader
        );
    }

    public function official_account_all_tv(Request $request){
        $allsosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $unit=\App\Models\Sosmed\Groupunit::with(
            [
                'unit',
                'unit.sosmed',
                'unit.sosmed.followers'=>function($q) use($sekarang,$kemarin){
                    $q->whereBetween('tanggal',[$kemarin,$sekarang]);
                }
            ]
        );

        $unit=$unit->get();

        $data=array();
        foreach($unit as $key=>$val){
            $unit=array();
            foreach($val->unit as $p){
                $sosmed=array();

                $follower=array(
                    'sekarang'=>0,
                    'kemarin'=>0,
                    'growth'=>0
                );

                foreach($p->sosmed as $q){
                    foreach($q->followers as $r){
                        if($r->tanggal==$sekarang){
                            $follower['sekarang']=$r->follower;
                        }

                        if($r->tanggal==$kemarin){
                            $follower['kemarin']=$r->follower;
                        }
                    }

                    if($follower['kemarin']>0){
                        $follower['growth']=$follower['sekarang']/$follower['kemarin']-1;
                    }else{
                        $follower['growth']=0;
                    }

                    $sosmed[]=array(
                        'id'=>$q->id,
                        'unit_sosmed_name'=>$q->unit_sosmed_name,
                        'sosmed_id'=>$q->sosmed_id,
                        'sosmed'=>$q->sosmed->sosmed_name,
                        'followers'=>$follower
                    );
                }

                $unit[]=array(
                    'id'=>$p->id,
                    'unit_name'=>$p->unit_name,
                    'sosmed'=>$sosmed
                );
            }
            

            $total[]=array(
                array(
                    'sekarang'=>0,
                    'kemarin'=>0,
                    'growth'=>0
                ),
                array(
                    'sekarang'=>0,
                    'kemarin'=>0,
                    'growth'=>0
                ),
                array(
                    'sekarang'=>0,
                    'kemarin'=>0,
                    'growth'=>0
                )
            );

            $data[]=array(
                'id'=>$val->id,
                'group_name'=>$val->group_name,
                'unit'=>$unit,
                'total'=>$total
            );
        }

        /* summary */
        $summary=\DB::select("select a.id,a.group_name,  
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=1,e.follower,0)) as kemarin_twitter,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=1,e.follower,0)) as sekarang_twitter,
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=2,e.follower,0)) as kemarin_facebook,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=2,e.follower,0)) as sekarang_facebook,
            sum(if(e.tanggal='$kemarin' and c.sosmed_id=3,e.follower,0)) as kemarin_instagram,
            sum(if(e.tanggal='$sekarang' and c.sosmed_id=3,e.follower,0)) as sekarang_instagram
            from group_unit a 
            left join business_unit b on b.group_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join sosmed d on d.id=c.sosmed_id
            left join unit_sosmed_follower e on e.unit_sosmed_id=c.id and e.tanggal between '$kemarin' and '$sekarang'
            group by a.id");

        /*addional color  */
        $colorheader=["#008ef6","#5054ab","#a200b2"];
        $subheader=["#008ef6","#008ef6","#008ef6","#5054ab","#5054ab","#5054ab","#a200b2","#a200b2","#a200b2"];

        return array(
            'unit'=>$data,
            'sosmed'=>$allsosmed,
            'sekarang'=>$sekarang,
            'kemarin'=>$kemarin,
            'header'=>$colorheader,
            'subheader'=>$subheader,
            'summary'=>$summary
        );

    }

    public function sosmed_official_and_program(Request $request){
        if($request->has('tanggal')){
            $tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $tanggal=date('Y-m-d');
        }

        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

        $unit=\DB::select("select b.id, b.group_unit_id, b.unit_name, c.unit_sosmed_name,
            sum(if(c.sosmed_id=1,d.follower,0)) as twitter_official,
            sum(if(c.sosmed_id=2,d.follower,0)) as fb_official,
            sum(if(c.sosmed_id=3,d.follower,0)) as ig_official
            from business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal='$tanggal'
            group by b.id");

        $program=\DB::select("select a.id, a.unit_name, c.sosmed_id, 
                sum(if(c.sosmed_id=1,d.follower,0)) as tw_program,
                sum(if(c.sosmed_id=2,d.follower,0)) as fb_program,
                sum(if(c.sosmed_id=3,d.follower,0)) as ig_program
                from business_unit a 
                left join program_unit b on b.business_unit_id=a.id
                left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
                left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal='$tanggal'
                group by a.id");

        $data=array();
        $total=array();
        foreach($group as $row){
            $officialunit=array();

            for($a=0;$a<count($unit);$a++){
                if($unit[$a]->group_unit_id==$row->id){
                    $pr=array();

                    for($b=0;$b<count($program);$b++){
                        if($program[$b]->id==$unit[$a]->id){
                            $pr=array(
                                'tw'=>$program[$b]->tw_program,
                                'fb'=>$program[$b]->fb_program,
                                'ig'=>$program[$b]->ig_program
                            );
                        }
                    }

                    $tesofficial=array(
                        'tw'=>$unit[$a]->twitter_official,
                        'fb'=>$unit[$a]->fb_official,
                        'ig'=>$unit[$a]->ig_official
                    );

                    $total=array(
                        'tw'=>$tesofficial['tw']+$pr['tw'],
                        'fb'=>$tesofficial['fb']+$pr['fb'],
                        'ig'=>$tesofficial['ig']+$pr['ig']
                    );

                    $officialunit[]=array(
                        'unit_name'=>$unit[$a]->unit_name,
                        'sosmed_name'=>$unit[$a]->unit_sosmed_name,
                        'official'=>$tesofficial,
                        'program'=>$pr,
                        'total'=>$total
                    );
                }
            }

            $total=array(
                'tw'=>0,
                'fb'=>0,
                'ig'=>0
            );

            $subtotal=array(
                'tw'=>0,
                'fb'=>0,
                'ig'=>0
            );

            foreach($officialunit as $k=>$v){
                $subtotal['tw']+=$v['total']['tw'];  
                $subtotal['fb']+=$v['total']['fb'];  
                $subtotal['ig']+=$v['total']['ig'];  
            }

            $total['tw']+=$subtotal['tw'];
            $total['fb']+=$subtotal['fb'];
            $total['ig']+=$subtotal['ig'];

            $data[]=array(
                'id'=>$row->id,
                'group_name'=>$row->group_name,
                'unit'=>$officialunit,
                'total'=>$total
            );
        }   

        return array(
            'data'=>$data,
            'tanggal'=>$tanggal
        );
    }

    public function official_and_program(Request $request){
        if($request->has('tanggal')){
            $tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $tanggal=date('Y-m-d');
        }

        $unit=\App\Models\Sosmed\Businessunit::select('id','unit_name')
            ->with(
            [
                'sosmed'=>function($q){
                    $q->select(
                        'id',
                        'business_program_unit',
                        'type_sosmed',
                        'sosmed_id',
                        'unit_sosmed_name'
                    );
                },
                'sosmed.followers'=>function($q) use($tanggal){
                    $q->where('tanggal',$tanggal)
                        ->select('unit_sosmed_id','follower');
                },
                'program'=>function($q){
                    $q->select('id','business_unit_id','program_name');
                },
                'program.sosmed'=>function($q) use($tanggal){
                    
                },
                'program.sosmed.followers'=>function($q) use($tanggal){
                    $q->where('tanggal',$tanggal)
                        ->select('id','unit_sosmed_id','tanggal','follower');
                }
            ]
        );

        if($request->has('group')){
            $unit=$unit->where('group_unit_id',$request->input('group'));
        }

        $unit=$unit->get();

        $summary=\DB::select("select terjadi.id, terjadi.unit_name,sum(terjadi.tw) as total_twitter,
            sum(terjadi.fb) as total_fb,
            sum(terjadi.ig) as total_ig from (
                select a.id, a.unit_name,c.unit_sosmed_name ,d.tanggal,  
            sum(if(c.sosmed_id=1,d.follower,0)) as tw,
            sum(if(c.sosmed_id=2,d.follower,0)) as fb,
            sum(if(c.sosmed_id=3,d.follower,0)) as ig
            from 
            business_unit a 
            left join program_unit b on b.business_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='program'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal='$tanggal'
            group by a.id
            union all 
            select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
            sum(if(b.sosmed_id=1,c.follower,0)) as tw,
            sum(if(b.sosmed_id=2,c.follower,0)) as fb,
            sum(if(b.sosmed_id=3,c.follower,0)) as ig
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tanggal'
            group by a.id ) as terjadi
            group by terjadi.id");

        return array(
            'unit'=>$unit,
            'summary'=>$summary
        );

        
    }
}