<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Unitsosmedinfomedia extends Model
{
    protected $connection="mysql";
    protected $table="unit_sosmed_info_media";
    
    public function unitsosmedinfo(){
        return $this->belongsTo('App\Models\Sosmed\Unitsosmedinfo','unit_sosmed_info_id');
    }
}