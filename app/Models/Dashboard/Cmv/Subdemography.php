<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Subdemography extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_sub_demography";
    protected $primaryKey="subdemo_id";

    public $incrementing=false;

    public function demo(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Demography','demo_id','demo_id');
    }

}
