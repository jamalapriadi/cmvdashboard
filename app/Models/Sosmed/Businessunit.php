<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Businessunit extends Model
{
    protected $table="business_unit";

    public function groupunit(){
    	return $this->belongsTo('\App\Models\Sosmed\Groupunit','group_unit_id')
    		->select(
    			[
    				'id',
    				'group_name',
    				'logo'
    			]
    		);
    }
}
