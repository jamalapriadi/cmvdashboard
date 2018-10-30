<?php

namespace App\Exports;

use App\Models\Sosmed\Programunit;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProgramUnitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Programunit::all();
    }
}
