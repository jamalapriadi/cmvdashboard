<?php

namespace App\Exports;

use App\Models\Sosmed\Groupunit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupUnitExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Groupunit::all();
    }

    public function map($group): array
    {
        return [
            $group->id,
            $group->group_name
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'GROUP NAME',
        ];
    }
}
