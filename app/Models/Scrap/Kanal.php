<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Kanal extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_portal_kanal";

    // use SoftDeletes;
    
    public function portal(){
        return $this->belongsTo('App\Models\Scrap\Portal','portal_id');
    }

    public function parameter(){
        return $this->hasMany('App\Models\Scrap\Parameter','kanal_id');
    }

    public function subkanal(){
        return $this->hasMany('App\Models\Scrap\Subkanal','kanal_id');
    }

}
