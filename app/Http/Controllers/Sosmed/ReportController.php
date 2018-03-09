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

    /* rank */
    public function rank_of_official_account_all_group(Request $request){
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
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) - 1) as growth_ig
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
                    'growth_twitter'=>$row->growth_tw." %",
                    'tw_sekarang'=>$row->tw_sekarang,
                    'rank_tw'=>($rankTw[$row->tw_sekarang] + 1),
                    'growth_fb'=>$row->growth_fb." %",
                    'fb_sekarang'=>$row->fb_sekarang,
                    'rank_fb'=>($rankFb[$row->fb_sekarang] + 1),
                    'growth_ig'=>$row->growth_ig." %",
                    'ig_sekarang'=>$row->ig_sekarang,
                    'rank_ig'=>($rankIg[$row->ig_sekarang] + 1)
                )
            );
        }

        return $data;
    }

    public function rank_of_official_account_all_tv(Request $request){
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
            sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) as fb_kemarin,
            sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) as fb_sekarang,
            (sum(if(c.sosmed_id=2 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=2 and d.tanggal='$kemarin',d.follower,0)) -1) as growth_fb,
            sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) as ig_kemarin,
            sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) as ig_sekarang,
            (sum(if(c.sosmed_id=3 and d.tanggal='$sekarang',d.follower,0)) / sum(if(c.sosmed_id=3 and d.tanggal='$kemarin',d.follower,0)) -1) as growth_ig
            FROM business_unit b
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal BETWEEN '$kemarin' and '$sekarang'
            group by b.id");

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
                'unit_name'=>$row->unit_name,
                'follower'=>array(
                    'growth_twitter'=>$row->growth_tw." %",
                    'tw_sekarang'=>$row->tw_sekarang,
                    'rank_tw'=>($rankTw[$row->tw_sekarang] + 1),
                    'growth_fb'=>$row->growth_fb." %",
                    'fb_sekarang'=>$row->fb_sekarang,
                    'rank_fb'=>($rankFb[$row->fb_sekarang] + 1),
                    'growth_ig'=>$row->growth_ig." %",
                    'ig_sekarang'=>$row->ig_sekarang,
                    'rank_ig'=>($rankIg[$row->ig_sekarang] + 1)
                )
            );
        }

        return $data;
    }

    public function rank_growth_from_yesterday_all_tv(Request $request){
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
                'unit_name'=>$row->unit_name,
                'follower'=>array(
                    'num_of_twitter'=>$row->num_of_growth_tw,
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

    public function rank_growth_from_yesterday_group(Request $request){
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
            (sum(terjadi.sekarang_tw)/sum(terjadi.kemarin_tw)-1) as growth_tw,
            (sum(terjadi.sekarang_tw)-sum(terjadi.kemarin_tw)) as num_of_growth_tw,
            sum(terjadi.kemarin_fb) as total_kemarin_fb,
            sum(terjadi.sekarang_fb) as total_sekarang_fb,
            (sum(terjadi.sekarang_fb)/sum(terjadi.kemarin_fb)-1) as growth_fb,
            (sum(terjadi.sekarang_fb)-sum(terjadi.kemarin_fb)) as num_of_growth_fb,
            sum(terjadi.kemarin_ig) as total_kemarin_ig,
            sum(terjadi.sekarang_ig) as total_sekarang_ig,
            (sum(terjadi.sekarang_ig)/sum(terjadi.kemarin_ig)-1) as growth_ig ,
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
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }


        $data['rankOfOfficialAccountAllGroupByFollowers']=\DB::select("select a.id, a.group_name,d.tanggal,
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

        $data['rankOfOfficialAccountAllTvByFollowers']=\DB::select("select b.id, b.unit_name,d.tanggal,
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

        $data['rankOverallAccountGroup']=\DB::select("select terjadi.group_unit_id,terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            (sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            (sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            (sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) as total_growth_ig,
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
                    group by a.id 
                ) as terjadi
            group by terjadi.group_unit_id");

        $data['rankOverallAccountAllTv']=\DB::select("select terjadi.id, terjadi.group_unit_id,terjadi.unit_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            (sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            (sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            (sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) as total_growth_ig,
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
                group by a.id 
            ) as terjadi
            group by terjadi.id");

        $pdf = \PDF::loadView('sosmed.pdf.rank_for_social_media_all_tv', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream();
    }

    public function pdf_sosmed_daily_report(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        if($request->has('group')){
            $group=$request->input('group');
        }else{
            $group=1;
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
            where a.group_unit_id='$group'
            GROUP by a.id");

        $data['officialTv']=\DB::select("select ifnull(a.id,'SUBTOTAL') as id, a.unit_name,  
            ifnull(a.group_unit_id,'TOTAL') as group_id,e.group_name,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) as tw_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) as tw_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=1,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=1,c.follower,0)) -1) as growth_tw,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) as fb_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) as fb_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=2,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=2,c.follower,0)) - 1) as growth_fb,
            sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) as ig_kemarin,
            sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang,
            (sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) / sum(if(c.tanggal='$kemarin' and b.sosmed_id=3,c.follower,0)) - 1) as growth_ig
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
            left join group_unit e on e.id=a.group_unit_id
            group by a.group_unit_id,a.id
            with ROLLUP");

        $data['overallOfficialTv']=\DB::select("select terjadi.id, terjadi.unit_name, terjadi.group_id, terjadi.group_name,
            sum(terjadi.tw_kemarin) as total_tw_kemarin,
            sum(terjadi.tw_sekarang) as total_tw_sekarang,
            (sum(terjadi.tw_sekarang) / sum(terjadi.tw_kemarin) - 1) as total_growth_tw,
            (sum(terjadi.tw_sekarang) - sum(terjadi.tw_kemarin)) as total_num_of_growth_tw,
            sum(terjadi.fb_kemarin) as total_fb_kemarin,
            sum(terjadi.fb_sekarang) as total_fb_sekarang,
            (sum(terjadi.fb_sekarang) / sum(terjadi.fb_kemarin) - 1) as total_growth_fb,
            (sum(terjadi.fb_sekarang) - sum(terjadi.fb_kemarin)) as total_num_of_growth_fb,
            sum(terjadi.ig_kemarin) as total_ig_kemarin,
            sum(terjadi.ig_sekarang) as total_ig_sekarang,
            (sum(terjadi.ig_sekarang) / sum(terjadi.ig_kemarin) - 1) as total_growth_ig,
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
                sum(if(c.tanggal='$sekarang' and b.sosmed_id=3,c.follower,0)) as ig_sekarang
                from 
                business_unit a 
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal BETWEEN '$kemarin' and '$sekarang'
                left join group_unit as e on e.id=a.group_unit_id
                group by a.group_unit_id,a.id
                with ROLLUP
            ) as terjadi
            group by terjadi.group_id,terjadi.id");

        /* official and program mnc group */
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
                'sosmed.followers'=>function($q) use($sekarang){
                    $q->where('tanggal',$sekarang)
                        ->select('unit_sosmed_id','follower');
                },
                'program'=>function($q){
                    $q->select('id','business_unit_id','program_name');
                },
                'program.sosmed'=>function($q) use($sekarang){
                    
                },
                'program.sosmed.followers'=>function($q) use($sekarang){
                    $q->where('tanggal',$sekarang)
                        ->select('id','unit_sosmed_id','tanggal','follower');
                }
            ]
        )->where('group_unit_id',$group);
        $unit=$unit->get();
        $data['officialAndProgram']=$unit;

        $data['summaryOfficialAndProgram']=\DB::select("select terjadi.id, terjadi.unit_name,sum(terjadi.tw) as total_twitter,
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
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id and d.tanggal='$sekarang'
            group by a.id
            union all 
            select a.id, a.unit_name,b.unit_sosmed_name ,c.tanggal,  
            sum(if(b.sosmed_id=1,c.follower,0)) as tw,
            sum(if(b.sosmed_id=2,c.follower,0)) as fb,
            sum(if(b.sosmed_id=3,c.follower,0)) as ig
            from 
            business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            group by a.id ) as terjadi
            group by terjadi.id");

        $pdf = \PDF::loadView('sosmed.pdf.sosmed_daily_report', $data)
            ->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream();
    }
}