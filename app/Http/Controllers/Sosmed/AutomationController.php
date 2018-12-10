<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class AutomationController extends Controller
{
    public function official(){
        $sekarang=date('Y-m-d');

        return $unit=Businessunit::with(
            [
                'sosmed'
            ]
        )
        ->whereHas('sosmed')
        ->select('id','group_unit_id','unit_name','type_unit')
        ->get();
        
        $data=array();
        $unitsosmedid=array();
        
        /* step pertama dapatkan semua unit sosmed official*/
        foreach($unit as $row){
            $follower=0;
            foreach($row->sosmed as $sos){
                array_push($unitsosmedid,$sos->id);

                $data[]=array(
                    'id'=>$sos->id,
                    'business_program_unit'=>$sos->business_program_unit,
                    'unit_sosmed_name'=>$sos->unit_sosmed_name,
                    'unit_sosmed_account_id'=>$sos->unit_sosmed_account_id,
                    'sosmed_id'=>$sos->sosmed_id
                );
            }
        }

        /** data unit sosmed sudah disimpan di variabel data
        ** kemudian cek di unit sosmed follower berdasarkan data
        **/
        $unitsosmedfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',$sekarang)
            ->whereIn('unit_sosmed_id',$unitsosmedid)
            ->get();

        

        $list=array();
        foreach($data as $key=>$val){
            for($a=0;$a<count($unitsosmedfollower); $a++){
                if($unitsosmedfollower[$a]->unit_sosmed_id==$val->id){
                    $list[]=array('id'=>$val->id,'status'=>'ada');
                }
            }
        }
        return $list;

        $sosmed=\App\Models\Sosmed\Sosmed::all();
        
        return view('sosmed.automation')
            ->with('unit',$unit)
            ->with('sosmed',$sosmed);
    }

    public function program(){
        $program=\App\Models\Sosmed\Programunit::with('sosmed')->get();

        return count($program);
    }
}