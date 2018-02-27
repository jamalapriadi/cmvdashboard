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
            $tanggal=$request->input('tanggal');
        }else{
            $tanggal=date('Y-m-d');
        }

        $group=\App\Models\Sosmed\Groupunit::select('id','group_name')->get();

        $sum=\DB::select("select a.id,a.group_unit_id, a.unit_name, b.type_sosmed, c.tanggal,
            sum(if(b.sosmed_id=1,c.follower,0)) twitter,
            sum(if(b.sosmed_id=2,c.follower,0)) facebook,
            sum(if(b.sosmed_id=3,c.follower,0)) instagram,
            sum(c.follower) as total
            from business_unit a 
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$tanggal'
            group by a.id, c.tanggal");

        return array(
            'tanggal'=>$tanggal,
            'sum'=>$sum,
            'group'=>$group
        );
    }
}