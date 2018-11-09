<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ErrorOtomationExport implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $sekarang=date('Y-m-d');

        $query=\DB::select("select b.unit_sosmed_name,c.sosmed_name, b.type_sosmed,
                if(b.type_sosmed='corporate',e.unit_name, d.program_name) as bu_or_program,
                if(b.type_sosmed='corporate',e.type_unit,f.type_unit) as typeunit,
                a.tanggal, a.follower, a.unit_sosmed_id, a.id as id_follower 
                from unit_sosmed_follower a 
                left join unit_sosmed b on b.id=a.unit_sosmed_id
                left join sosmed c on c.id=b.sosmed_id
                left join program_unit d on d.id=b.business_program_unit
                left join business_unit e on e.id=b.business_program_unit
                left join business_unit f on f.id=d.business_unit_id
                where a.tanggal='$sekarang'
                and a.follower=0");

        return $query;
    }

    public function map($unit): array
    {
        return [
            $unit->unit_sosmed_name,
            $unit->sosmed,
            $unit->type_sosmed,
            $unit->bu_or_program,
            $unit->typeunit,
            $unit->tanggal,
            $unit->follower
        ];
    }

    public function headings(): array
    {
        return [
            'UNIT SOCMED NAME',
            'SOCMED',
            'TYPE SOCMED',
            'UNIT / PROGRAM',
            'TYPE UNIT',
            'TANGGAL',
            'FOLLOWER'
        ];
    }
}
