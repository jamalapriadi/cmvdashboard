<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_category";

    public function sector(){
        return $this->belongsTo('App\Models\Dashboard\Cmv\Sector','sector_id','sector_id')
            ->select(
                [
                    'id',
                    'sector_id',
                    'sector_name'
                ]
            );
    }

}
