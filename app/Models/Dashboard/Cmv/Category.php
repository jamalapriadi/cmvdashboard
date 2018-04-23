<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_category";
    protected $primaryKey="category_id";

    public $incrementing=false;

    public function sector(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Sector','sector_id','sector_id')
            ->select(
                [
                    'sector_id',
                    'sector_name'
                ]
            );
    }

    public function variabel(){
        return $this->hasManyThrough('App\Models\Dashboard\Cmv\Variabel','App\Models\Dashboard\Cmv\Brand','category_id','brand_id')
            ->select(
                [
                    'cmv_variabel.id',
                    'cmv_variabel.brand_id',
                    'subdemo_id',
                    'quartal',
                    'totals_thousand',
                    'totals_ver'
                ]
            );
    }

}
