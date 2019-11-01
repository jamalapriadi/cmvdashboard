<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Jumlahaccount implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function array(): array
    {
        $lis=\DB::select("SELECT a.id,'OFFICIAL' AS TYPE, c.NAME, b.group_name, a.unit_name,
            SUM(if(d.sosmed_id=1,1,0)) AS twitter,
            SUM(if(d.sosmed_id=2,1,0)) AS facebook,
            SUM(if(d.sosmed_id=3,1,0)) AS instagram,
            SUM(if(d.sosmed_id=4,1,0)) AS youtube,
            SUM(if(d.sosmed_id=5,1,0)) AS website,
            SUM(if(d.sosmed_id=1,1,0)) + SUM(if(d.sosmed_id=2,1,0)) + SUM(if(d.sosmed_id=3,1,0)) + SUM(if(d.sosmed_id=4,1,0)) + SUM(if(d.sosmed_id=5,1,0)) AS total
            FROM business_unit a
            LEFT JOIN group_unit b ON b.id=a.group_unit_id
            LEFT JOIN type_unit c ON c.id=a.type_unit
            LEFT JOIN unit_sosmed d ON d.business_program_unit=a.id AND d.type_sosmed='corporate'
            GROUP BY a.id
            UNION ALL
            SELECT a.id,'PROGRAM' AS TYPE, c.NAME, a.program_name, b.unit_name,
            SUM(if(d.sosmed_id=1,1,0)) AS twitter,
            SUM(if(d.sosmed_id=2,1,0)) AS facebook,
            SUM(if(d.sosmed_id=3,1,0)) AS instagram,
            SUM(if(d.sosmed_id=4,1,0)) AS youtube,
            SUM(if(d.sosmed_id=5,1,0)) AS website,
            SUM(if(d.sosmed_id=1,1,0)) + SUM(if(d.sosmed_id=2,1,0)) + SUM(if(d.sosmed_id=3,1,0)) + SUM(if(d.sosmed_id=4,1,0)) + SUM(if(d.sosmed_id=5,1,0)) AS total
            FROM program_unit a
            LEFT JOIN business_unit b ON b.id=a.business_unit_id
            LEFT JOIN type_unit c ON c.id=b.type_unit
            LEFT JOIN unit_sosmed d ON d.business_program_unit=a.id AND d.type_sosmed='program'
            WHERE c.NAME IS NOT NULL
            GROUP BY a.id
            UNION ALL
            SELECT a.id,'BRAND' AS TYPE,'ADVERTISER' AS NAME, b.nama_adv, a.brand_name_alias,
            SUM(if(d.sosmed_id=1,1,0)) AS twitter,
            SUM(if(d.sosmed_id=2,1,0)) AS facebook,
            SUM(if(d.sosmed_id=3,1,0)) AS instagram,
            SUM(if(d.sosmed_id=4,1,0)) AS youtube,
            SUM(if(d.sosmed_id=5,1,0)) AS website,
            SUM(if(d.sosmed_id=1,1,0)) + SUM(if(d.sosmed_id=2,1,0)) + SUM(if(d.sosmed_id=3,1,0)) + SUM(if(d.sosmed_id=4,1,0)) + SUM(if(d.sosmed_id=5,1,0)) AS total
            FROM brand_unit a
            LEFT JOIN intrasm.db_m_advertiser b ON b.id_adv=a.advertiser_id
            LEFT JOIN unit_sosmed d ON d.business_program_unit=a.id AND d.type_sosmed='brand'
            GROUP BY a.id
            UNION ALL 
            SELECT b.id_agcy,'AGENCY' AS TYPE, 'AGENCY' AS NAME, b.name_agency,b.name_agency AS nama_agency,
            SUM(if(a.sosmed_id=1,1,0)) AS twitter,
            SUM(if(a.sosmed_id=2,1,0)) AS facebook,
            SUM(if(a.sosmed_id=3,1,0)) AS instagram,
            SUM(if(a.sosmed_id=4,1,0)) AS youtube,
            SUM(if(a.sosmed_id=5,1,0)) AS website,
            SUM(if(a.sosmed_id=1,1,0)) + SUM(if(a.sosmed_id=2,1,0)) + SUM(if(a.sosmed_id=3,1,0)) + SUM(if(a.sosmed_id=4,1,0)) + SUM(if(a.sosmed_id=5,1,0)) AS total 
            FROM unit_sosmed a
            LEFT JOIN intrasm.db_m_agency b ON b.id_agcy=a.business_program_unit
            WHERE a.type_sosmed='agency'
            GROUP BY a.business_program_unit
            UNION ALL
            SELECT b.id_agcyptu,'AGENCYPINTU' AS TYPE, 'AGENCYPINTU' AS NAME, b.nama_agencypintu,
            b.nama_agencypintu AS nama_agency,
            SUM(if(a.sosmed_id=1,1,0)) AS twitter,
            SUM(if(a.sosmed_id=2,1,0)) AS facebook,
            SUM(if(a.sosmed_id=3,1,0)) AS instagram,
            SUM(if(a.sosmed_id=4,1,0)) AS youtube,
            SUM(if(a.sosmed_id=5,1,0)) AS website,
            SUM(if(a.sosmed_id=1,1,0)) + SUM(if(a.sosmed_id=2,1,0)) + SUM(if(a.sosmed_id=3,1,0)) + SUM(if(a.sosmed_id=4,1,0)) + SUM(if(a.sosmed_id=5,1,0)) AS total 
            FROM unit_sosmed a
            LEFT JOIN intrasm.db_m_agencypintu b ON b.id_agcyptu=a.business_program_unit
            WHERE a.type_sosmed='agencypintu'
            GROUP BY a.business_program_unit");

        $data=array();
        foreach($lis as $result){
            $data[] = (array)$result;
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'TYPE',
            'NAME',
            'GROUP NAME',
            'UNIT NAME',
            'TWITTER',
            'FACEBOOK',
            'INSTAGRAM',
            'YOUTUBE',
            'WEBSITE',
            'JUMLAH'
        ];
    }
}
