<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NamaAkunOfficialDanProgram implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $kemarin;
    protected $sekarang;

    public function __construct()
    {
        
    }

    public function array(): array
    {
        $lis=\DB::select("SELECT a.id, b.group_name, a.unit_name, c.NAME AS name, 
            'corporate' AS typenya,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=1
                AND bb.type_sosmed='corporate'
                AND bb.status_active='Y'
            ),'-') AS twitter,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=2
                AND bb.type_sosmed='corporate'
                AND bb.status_active='Y'
            ),'-') AS facebook,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=3
                AND bb.type_sosmed='corporate'
                AND bb.status_active='Y'
            ),'-') AS instagram,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=4
                AND bb.type_sosmed='corporate'
                AND bb.status_active='Y'
            ),'-') AS youtube
            FROM business_unit a
            LEFT JOIN group_unit b ON b.id=a.group_unit_id
            LEFT JOIN type_unit c ON c.id=a.type_unit
            UNION ALL 
            SELECT a.id, b.unit_name, a.program_name, c.NAME AS name, 
            'program' AS typenya,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=1
                AND bb.type_sosmed='program'
                AND bb.status_active='Y'
            ),'-') AS twitter,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=2
                AND bb.type_sosmed='program'
                AND bb.status_active='Y'
            ),'-') AS facebook,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=3
                AND bb.type_sosmed='program'
                AND bb.status_active='Y'
            ),'-') AS instagram,
            IFNULL((
                SELECT bb.unit_sosmed_name FROM unit_sosmed bb
                WHERE bb.business_program_unit=a.id
                AND bb.sosmed_id=4
                AND bb.type_sosmed='program'
                AND bb.status_active='Y'
            ),'-') AS youtube
            FROM program_unit a
            LEFT JOIN business_unit b ON b.id=a.business_unit_id
            LEFT JOIN type_unit c ON c.id=b.type_unit");

        $data=array();
        foreach($lis as $result){
            $data[] = (array)$result;
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Group Name",
            "Unit Name",
            "Type Unit",
            "Type Akun",
            "Twitter",
            "Facebook",
            "Instagram",
            "Youtube"
        ];
    }
}
