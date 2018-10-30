<?php

namespace App\Exports;

use App\Models\Sosmed\Businessunit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BusinessUnitExport implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Businessunit::with(
            [
                'sosmed',
                'sosmed.sosmed',
                'groupunit'
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
        return [
            $unit->id,
            $unit->groupunit->group_name,
            $unit->unit_name,
            $unit->type_unit,
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
            'GROUP NAME',
            'UNIT NAME',
            'TYPE UNIT',
            'TWITTER ACCOUNT',
            'FACEBOOK ACCOUNT',
            'INSTAGRAM ACCOUNT',
            'YOUTUBE ACCOUNT'
        ];
    }
}
