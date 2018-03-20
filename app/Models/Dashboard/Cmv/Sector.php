<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_sector";
    protected $primaryKey="sector_id";

    public $incrementing=false;

    public function category(){
        return $this->hasMany('App\Models\Dashboard\Cmv\Category','sector_id');
    }

}
