<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class Corporate implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $follower;
    
    public function __construct($follower)
    {
        $this->follower=$follower;
    }

    public function collection()
    {
        return $this->follower;
    }

    public function map($unit): array
    {
        return [
            // $unit->group_unit_id,
            $unit->groupunit->group_name,
            $unit->unit_name,
            // $unit->type_unit,
            $unit->type_unit_name,
            $unit->TYPE,
            // $unit->sosmed_id,
            $unit->sosmed_name,
            $unit->unit_sosmed_name,
            $unit->tanggal,
            $unit->follower,
            $unit->video_count,
            $unit->view_count
        ];
    }

    public function headings(): array
    {
        return [
            // 'GROUP UNIT ID',
            'GROUP NAME',
            'UNIT NAME',
            // 'TYPE UNIT',
            'TYPE UNIT NAME',
            'TYPE',
            'TYPE SOSMED',
            // 'SOSMED ID',
            'SOSMED NAME',
            'TANGGAL',
            'FOLLOWER',
            'FOLLOWER',
            'VIDEO COUNT',
            'VIEW COUNT'
        ];
    }
}
