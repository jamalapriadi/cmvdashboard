<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Youtubetvandprogram implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $kemarin;
    protected $sekarang;

    public function __construct($kemarin,$sekarang)
    {
        $this->kemarin=$kemarin;
        $this->sekarang=$sekarang;
    }

    public function array(): array
    {
        $lis=\DB::select("select b.type_sosmed, f.name,e.group_name,a.unit_name, a.unit_name as unit_or_program, c.sosmed_name, 
        b.unit_sosmed_name,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.follower,0)) as follower_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.view_count,0)) as view_count_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.video_count,0)) as video_count_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.follower,0)) as follower_end,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.view_count,0)) as view_count_end,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.video_count,0)) as video_count_end
        from business_unit a
        left JOIN unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate' and b.sosmed_id=4
        left join sosmed c on c.id=b.sosmed_id
        left join unit_sosmed_follower d on d.unit_sosmed_id=b.id
        left join group_unit e on e.id=a.group_unit_id
        left join type_unit f on f.id=a.type_unit
        where d.tanggal='$this->kemarin' or d.tanggal='$this->sekarang'
        group by a.id
        union all
        select b.type_sosmed,g.name,f.group_name,e.unit_name, a.program_name, c.sosmed_name, 
        b.unit_sosmed_name,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.follower,0)) as follower_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.view_count,0)) as view_count_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->kemarin', d.video_count,0)) as video_count_start,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.follower,0)) as follower_end,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.view_count,0)) as view_count_end,
        sum(if(b.sosmed_id=4 and d.tanggal='$this->sekarang', d.video_count,0)) as video_count_end
        from program_unit a
        left JOIN unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program' and b.sosmed_id=4
        left join sosmed c on c.id=b.sosmed_id
        left join unit_sosmed_follower d on d.unit_sosmed_id=b.id
        left join business_unit e on e.id=a.business_unit_id
        left join group_unit f on f.id=e.group_unit_id
        left join type_unit g on g.id=e.type_unit
        where d.tanggal='$this->kemarin' or d.tanggal='$this->sekarang'
        group by a.id");

        $data=array();
        foreach($lis as $result){
            $data[] = (array)$result;
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            "Type Socmed",
            "Name",
            "Group Name",
            "Unit Name",
            "Unit / Program",
            "Socmed Name",
            "Unit Socmed Name",
            "Follower ".$this->kemarin,
            "View Count ".$this->kemarin,
            "Video Count ".$this->kemarin,
            "Follower ".$this->sekarang,
            "View Count ".$this->sekarang,
            "Video Count ".$this->sekarang
        ];
    }
}
