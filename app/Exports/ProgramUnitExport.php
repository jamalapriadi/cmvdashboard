<?php

namespace App\Exports;

use App\Models\Sosmed\Programunit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProgramUnitExport implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Programunit::with(
            [
                'businessunit'=>function($q){

                },
                'sosmed'
            ]
        )->get();
    }

    public function map($unit): array
    {
        $twitter="";
        $facebook="";
        $instagram="";
        $youtube="";

        foreach($unit->sosmed as $row){
            if($row->sosmed_id==1){
                $twitter=$row->unit_sosmed_name;
            }

            if($row->sosmed_id==2){
                $facebook=$row->unit_sosmed_name;
            }

            if($row->sosmed_id==3){
                $instagram=$row->unit_sosmed_name;
            }

            if($row->sosmed_id==4){
                $youtube=$row->unit_sosmed_name;
            }
        }

        $bu="";
        if($unit->businessunit!=null){
            $bu=$unit->businessunit->unit_name;
        }

        return [
            $unit->id,
            $bu,
            $unit->program_name,
            $twitter,
            $facebook,
            $instagram,
            $youtube
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'UNIT NAME',
            'PROGRAM NAME',
            'TWITTER ACCOUNT',
            'FACEBOOK ACCOUNT',
            'INSTAGRAM ACCOUNT',
            'YOUTUBE ACCOUNT'
        ];
    }
}
