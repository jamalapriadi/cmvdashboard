<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Programunit extends Model
{
    protected $table="program_unit";

    public function businessunit(){
    	return $this->belongsTo('\App\Models\Sosmed\Businessunit','business_unit_id')
    		->select(
    			[
    				'id',
    				'unit_name',
    				'logo'
    			]
    		);
    }
}
