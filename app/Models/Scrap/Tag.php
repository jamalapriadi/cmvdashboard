<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_portal_tag";
    
    public function portal(){
        return $this->belongsTo('App\Models\Scrap\Portal','portal_id');
    }

}
