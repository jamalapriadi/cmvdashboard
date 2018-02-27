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
        $sosmed=\App\Models\Sosmed\Sosmed::select('id','sosmed_name')->get();

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }else{
            $sekarang=date('Y-m-d');
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $summary=\DB::select("select a.id as group_id, a.group_name, b.id as bu_id, 
            b.id,b.unit_name, c.unit_sosmed_name,e.id as sos_id,e.sosmed_name,d.tanggal, 
            sum(d.follower) jumlah from group_unit a
            left join business_unit b on b.group_unit_id=a.id
            left join unit_sosmed c on c.business_program_unit=b.id and c.type_sosmed='corporate'
            left join sosmed e on e.id=c.sosmed_id
            left join unit_sosmed_follower d on d.unit_sosmed_id=c.id
            where c.unit_sosmed_name is not null
            and d.tanggal is not null
            and d.tanggal between '$kemarin' and '$sekarang'
            group by d.tanggal, e.id");

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

        /*addional color  */
        $colorheader=["#008ef6","#5054ab","#a200b2"];
        $subheader=["#008ef6","#008ef6","#008ef6","#5054ab","#5054ab","#5054ab","#a200b2","#a200b2","#a200b2"];

        return array(
            'unit'=>$unit,
            'sosmed'=>$sosmed,
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

        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')
            ->with(
                [
                    'unit'=>function($q){
                        $q->select(
                            [
                                'business_unit.id',
                                'group_unit_id',
                                'unit_name'
                            ]
                        );
                    },
                    /* ini untuk menghitung official account unit tersebut */
                    'unit.sosmed'=>function($q) use($tanggal){
                        $q->select(
                            [
                                'unit_sosmed.id',
                                'business_program_unit',
                                'type_sosmed',
                                'unit_sosmed_name',
                                'sosmed_id',
                                'target_use',
                                'tanggal',
                                \DB::raw("sum(follower) as total")
                            ]
                        )->with('sosmed')
                        ->leftJoin('unit_sosmed_follower',function($q) use($tanggal){
                            $q->on('unit_sosmed_id','=','unit_sosmed.id')
                                ->where('tanggal',$tanggal)
                                ->groupBy('tanggal');
                        })->groupBy('sosmed_id');
                    },
                    'unit.program'=>function($q) use($tanggal){
                        $q->select(
                            [
                                'id',
                                'business_unit_id',
                                'program_name'
                            ]
                        )->with(
                            [
                                'sosmed'=>function($q) use($tanggal){
                                    $q->select(
                                        'unit_sosmed.id',
                                        'type_sosmed',
                                        'business_program_unit',
                                        'sosmed_id',
                                        'unit_sosmed_name',
                                        'target_use',
                                        'tanggal',
                                        \DB::raw("sum(follower) as total")
                                    )->leftJoin('unit_sosmed_follower',function($q) use($tanggal){
                                        $q->on('unit_sosmed_id','=','unit_sosmed.id')
                                            ->where('tanggal',$tanggal)
                                            ->groupBy('tanggal');
                                    })->groupBy('sosmed_id');
                                }
                            ]
                        );
                    }
                ]
            )->get();

        $data=array();
        foreach($group as $key=>$val){
            $unit=array();
            $subtotal=array(
                'tw'=>'',
                'fb'=>'',
                'ig'=>''
            );
            $total=array(
                'tw'=>'',
                'fb'=>'',
                'ig'=>''
            );

            foreach($val->unit as $p=>$r){
                $fbunit=0;
                $twunit=0;
                $igunit=0;

                foreach($r->sosmed as $s){
                    if($s->sosmed_id==1){
                        $twunit=$s->total;
                    }

                    if($s->sosmed_id==2){
                        $fbunit=$s->total;
                    }

                    if($s->sosmed_id==3){
                        $igunit=$s->total;
                    }
                }

                foreach($r->program as $pr){
                    foreach($pr->sosmed as $sos){
                        if($sos->sosmed_id==1){
                            $twunit+=$sos->total;
                        }
    
                        if($sos->sosmed_id==2){
                            $fbunit+=$sos->total;
                        }
    
                        if($sos->sosmed_id==3){
                            $igunit+=$sos->total;
                        }
                    }
                }


                $unit[]=array(
                    'id'=>$r->id,
                    'unit_name'=>$r->unit_name,
                    'jumlah_twitter'=>$twunit,
                    'jumlah_facebook'=>$fbunit,
                    'jumlah_instagram'=>$igunit
                );

                $subtotal['tw']+=$twunit;
                $subtotal['fb']+=$fbunit;
                $subtotal['ig']+=$igunit;
            }

            $total['tw']+=$subtotal['tw'];
            $total['ig']+=$subtotal['ig'];
            $total['fb']+=$subtotal['fb'];

            $data[]=array(
                'id'=>$val->id,
                'group_name'=>$val->group_name,
                'total'=>$total,
                'unit'=>$unit
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

        $unit=\App\Models\Sosmed\Businessunit::select('business_unit.id','group_unit_id','unit_name')
            ->with(
                [
                    'sosmed'=>function($q) use($tanggal){
                        $q->select(
                            [
                                'unit_sosmed.id',
                                'business_program_unit',
                                'type_sosmed',
                                'unit_sosmed_name',
                                'sosmed_id',
                                'target_use',
                                'tanggal',
                                \DB::raw("sum(follower) as total")
                            ]
                        )->with('sosmed')
                        ->leftJoin('unit_sosmed_follower',function($q) use($tanggal){
                            $q->on('unit_sosmed_id','=','unit_sosmed.id')
                                ->where('tanggal',$tanggal)
                                ->groupBy('tanggal');
                        })->groupBy('sosmed_id');
                    },
                    'program'=>function($q) use($tanggal){
                        $q->select(
                            [
                                'id',
                                'business_unit_id',
                                'program_name'
                            ]
                        )->with(
                            [
                                'sosmed'=>function($q) use($tanggal){
                                    $q->select(
                                        'unit_sosmed.id',
                                        'type_sosmed',
                                        'business_program_unit',
                                        'sosmed_id',
                                        'unit_sosmed_name',
                                        'target_use',
                                        'tanggal',
                                        \DB::raw("sum(follower) as total")
                                    )->leftJoin('unit_sosmed_follower',function($q) use($tanggal){
                                        $q->on('unit_sosmed_id','=','unit_sosmed.id')
                                            ->where('tanggal',$tanggal)
                                            ->groupBy('tanggal');
                                    })->groupBy('sosmed_id');
                                }
                            ]
                        );
                    }
                ]
            );

            if($request->has('group')){
                $unit=$unit->where('group_unit_id',$request->input('group'));
            }

            $unit=$unit->get();

            $data=array();

            foreach($unit as $row){
                $official=array();
                $program=array();
                
                $subtotal=array(
                    'tw'=>'',
                    'fb'=>'',
                    'ig'=>''
                );
                $total=array(
                    'tw'=>'',
                    'fb'=>'',
                    'ig'=>''
                );

                foreach($row->sosmed as $k){
                    $fbunit=0;
                    $twunit=0;
                    $igunit=0;

                    $official[]=array(
                        'id'=>$k->id,
                        'business_program_unit'=>$k->business_program_unit,
                        'type_sosmed'=>$k->type_sosmed,
                        'unit_sosmed_name'=>$k->unit_sosmed_name,
                        'sosmed_id'=>$k->sosmed_id,
                        'target_use'=>$k->target_use,
                        'tanggal'=>$k->tanggal,
                        'total'=>$k->total,
                        'sosmed'=>$k->sosmed->sosmed_name
                    );

                    if($k->sosmed_id==1){
                        $twunit=$k->total;
                    }

                    if($k->sosmed_id==2){
                        $fbunit=$k->total;
                    }

                    if($k->sosmed_id==3){
                        $igunit=$k->total;
                    }

                    $subtotal['tw']+=$twunit;
                    $subtotal['fb']+=$fbunit;
                    $subtotal['ig']+=$igunit;
                }

                foreach($row->program as $p){
                    $sosmed=array();

                    foreach($p->sosmed as $l){
                        $fbunit2=0;
                        $twunit2=0;
                        $igunit2=0;

                        if($l->sosmed_id==1){
                            $twunit2=$l->total;
                        }
    
                        if($l->sosmed_id==2){
                            $fbunit2=$l->total;
                        }
    
                        if($l->sosmed_id==3){
                            $igunit2=$l->total;
                        }

                        $subtotal['tw']+=$twunit2;
                        $subtotal['fb']+=$fbunit2;
                        $subtotal['ig']+=$igunit2;

                        $sosmed[]=array(
                            'id'=>$l->id,
                            'business_program_unit'=>$l->business_program_unit,
                            'type_sosmed'=>$l->type_sosmed,
                            'unit_sosmed_name'=>$l->unit_sosmed_name,
                            'sosmed_id'=>$l->sosmed_id,
                            'target_use'=>$l->target_use,
                            'tanggal'=>$l->tanggal,
                            'total'=>$l->total,
                            'sosmed'=>$l->sosmed->sosmed_name
                        );  
                    }

                    $program[]=array(
                        'id'=>$p->id,
                        'program_name'=>$p->program_name,
                        'sosmed'=>$sosmed
                    );
                }

                $total['tw']+=$subtotal['tw'];
                $total['ig']+=$subtotal['ig'];
                $total['fb']+=$subtotal['fb'];


                $data[]=array(
                    'id'=>$row->id,
                    'unit_name'=>$row->unit_name,
                    'official'=>$official,
                    'program'=>$program,
                    'total'=>$total
                );
            }

            return $data;
    }
}