<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Unitsosmedfollower extends Model
{
    protected $table="unit_sosmed_follower";

    public function unitsosmed(){
    	return $this->belongsTo('\App\Models\Sosmed\Unitsosmed','unit_sosmed_id')
    		->select(
    			[
    				'id',
    				'type_sosmed',
    				'unit_sosmed_name'
    			]
    		);
    }
}
