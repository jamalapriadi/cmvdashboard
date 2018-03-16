<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Subdemography extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_sub_demography";

    public function demo(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Demography','demo_id','demo_id');
    }

}
