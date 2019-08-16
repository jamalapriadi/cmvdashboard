<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class GroupFollower implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $follower;
    protected $program;
    
    public function __construct($follower, $program)
    {
        $this->follower=$follower;
        $this->program=$program;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new Corporate($this->follower);
        $sheets[] = new Program($this->program);

        return $sheets;
    }
}
