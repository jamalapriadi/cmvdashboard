<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Unitsosmedigfeed extends Model
{
    protected $connection="mysql";
    protected $table="unit_sosmed_ig_feed";
    
    public function unitsosmed(){
        return $this->belongsTo('App\Models\Sosmed\Unitsosmed','unit_sosmed_id');
    }
}