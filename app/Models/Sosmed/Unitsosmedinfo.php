<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Unitsosmedinfo extends Model
{
    protected $connection="mysql";
    protected $table="unit_sosmed_info";
    
    public function unitsosmed(){
        return $this->belongsTo('App\Models\Sosmed\Unitsosmed','unit_sosmed_id');
    }

    public function media(){
        return $this->hasMany('App\Models\Sosmed\Unitsosmedinfomedia','unit_sosmed_info_id');
    }
}