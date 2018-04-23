<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Variabel extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_variabel";

    public function brand(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Brand','brand_id','brand_id')
            ->select(
                [
                    'brand_id',
                    'category_id',
                    'brand_name'
                ]
            );
    }

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
