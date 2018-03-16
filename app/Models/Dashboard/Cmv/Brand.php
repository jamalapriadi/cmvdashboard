<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_brand";

    public function category(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Category','category_id','category_id')
            ->select(
                [
                    'id',
                    'category_id',
                    'sector_id',
                    'category_name'
                ]
            );
    }

    protected function setPrimaryKey($key)
    {
        $this->primaryKey = $key;
    }

    public function variabel(){
        //return $this->hasMany('App\Models\Dashboard\Cmv\Variabel','brand_id','brand_id');
        
        $relation=$this->belongsToMany('App\Models\Dashboard\Cmv\Subdemography','cmv_variabel','brand_id','subdemo_id','brand_id','subdemo_id')
            ->withPivot('brand_id','subdemo_id','quartal','totals_thousand','totals_ver','total_hor');

        return $relation;

    }

}
