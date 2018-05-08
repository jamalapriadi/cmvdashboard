<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Variabelta extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_variabel_target_audience";

    public function subdemo(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Subdemography','subdemo_id','subdemo_id')
            ->select(
                [
                    'subdemo_id',
                    'demo_id',
                    'subdemo_name'
                ]
            );
    }

}
