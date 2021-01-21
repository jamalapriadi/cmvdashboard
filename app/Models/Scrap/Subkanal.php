<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Subkanal extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_portal_subkanal";

    // use SoftDeletes;
    
    public function kanal(){
        return $this->belongsTo('App\Models\Scrap\Kanal','kanal_id');
    }

}
