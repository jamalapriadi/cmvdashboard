<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
class ChartBrandController extends Controller
{
    public function daily_by_advertiser(Request $request){
        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('advertiser') && $request->input('advertiser')!=null){
            $adv=request('advertiser');
        }else{
            $adv=1837;
        }

        $daily=\DB::select("select a.brand_name_alias, a.advertiser_id,
            sum(if(b.sosmed_id=1, c.follower,0)) as tw,
            sum(if(b.sosmed_id=2, c.follower,0)) as fb,
            sum(if(b.sosmed_id=3, c.follower,0)) as ig,
            sum(if(b.sosmed_id=4, c.follower,0)) as yt,
            sum(if(b.sosmed_id=1, c.follower,0)) + sum(if(b.sosmed_id=2, c.follower,0)) +
            sum(if(b.sosmed_id=3, c.follower,0)) + sum(if(b.sosmed_id=4, c.follower,0)) as total
            from brand_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='Brand'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            where a.advertiser_id=$adv
            group by a.id
            order by total desc
            limit 15");

        usort($daily, function($a, $b) {
            return $a->total <=> $b->total;
        });

        return $daily;
    }

    public function daily_by_category(Request $request){
        $rules=['category'=>'required','tanggal'=>'required'];

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('category') && $request->input('category')!=null){
            $category=request('category');
        }else{
            $category=235;
        }

        $daily=\DB::select("select a.id,a.brand_name_alias, a.advertiser_id,d.brand_unit_id, d.brand_id,
            e.id_category, e.id_sector,
            sum(if(b.sosmed_id=1, c.follower,0)) as tw,
            sum(if(b.sosmed_id=2, c.follower,0)) as fb,
            sum(if(b.sosmed_id=3, c.follower,0)) as ig,
            sum(if(b.sosmed_id=4, c.follower,0)) as yt,
            (
                sum(if(b.sosmed_id=1, c.follower,0)) +
                sum(if(b.sosmed_id=2, c.follower,0)) +
                sum(if(b.sosmed_id=3, c.follower,0)) +
                sum(if(b.sosmed_id=4, c.follower,0))
            ) as total
            from brand_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='Brand'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            left join brand_unit_detail d on d.brand_id=a.id
            left join intrasm.db_m_brand e on e.id_brand=d.brand_unit_id
            where e.id_category='$category'
            group by a.id, e.id_category");

        usort($daily, function($a, $b) {
            return $a->total <=> $b->total;
        });

        return $daily;
    }

    public function daily_by_sector(Request $request){
        $rules=['category'=>'required','tanggal'=>'required'];

        if($request->has('tanggal')){
            $sekarang=date('Y-m-d',strtotime($request->input('tanggal')));
        }else{
            $sekarang=date('Y-m-d');
        }

        if($request->has('sector') && $request->input('sector')!=null){
            $sector=request('sector');
        }else{
            $sector=103;
        }

        $daily=\DB::select("select a.id,a.brand_name_alias, a.advertiser_id,d.brand_unit_id, d.brand_id,
            e.id_category, e.id_sector,
            if(b.sosmed_id=1, c.follower,0) as tw,
            if(b.sosmed_id=2, c.follower,0) as fb,
            if(b.sosmed_id=3, c.follower,0) as ig,
            if(b.sosmed_id=4, c.follower,0) as yt,
            (
                if(b.sosmed_id=1, c.follower,0) +
                if(b.sosmed_id=2, c.follower,0) +
                if(b.sosmed_id=3, c.follower,0) +
                if(b.sosmed_id=4, c.follower,0)
            ) as total
            from brand_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='Brand'
            left join unit_sosmed_follower c on c.unit_sosmed_id=b.id and c.tanggal='$sekarang'
            left join brand_unit_detail d on d.brand_id=a.id
            left join intrasm.db_m_brand e on e.id_brand=d.brand_unit_id
            where e.id_sector='$sector'
            group by a.id, e.id_sector");

        usort($daily, function($a, $b) {
            return $a->total <=> $b->total;
        });

        return $daily;
    }
}