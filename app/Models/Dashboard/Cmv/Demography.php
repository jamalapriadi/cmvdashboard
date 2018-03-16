<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Demography extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_demography";

    public function subdemo(){
        return $this->hasMany('App\Models\Dashboard\Cmv\Subdemography','demo_id','demo_id');
    }
}
