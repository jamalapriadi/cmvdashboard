<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class Kanalparameter extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_portal_kanal_parameter";
    
    public function kanal(){
        return $this->belongsTo('App\Models\Scrap\Kanal','kanal_id');
    }

    public function parameter(){
        return $this->belongsTo('App\Models\Scrap\Parameter','parameter_id');
    }

    public function portal(){
        return $this->belongsTo('App\Models\Scrap\Portal','portal_id');
    }

    public function subkanal(){
        return $this->belongsTo('App\Models\Scrap\Subkanal','subkanal_id');
    }

}
