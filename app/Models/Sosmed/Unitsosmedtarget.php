<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Unitsosmedtarget extends Model
{
    protected $table="unit_sosmed_target";

    public function unitsosmed(){
        return $this->belongsTo('App\Models\Sosmed\Unitsosmed','unit_sosmed_id');
    }
    
}