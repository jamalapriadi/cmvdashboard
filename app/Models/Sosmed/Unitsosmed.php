<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Unitsosmed extends Model
{
    protected $table="unit_sosmed";

    public function sosmed(){
    	return $this->belongsTo('\App\Models\Sosmed\Sosmed','sosmed_id')
    		->select(
    			[
    				'id',
    				'sosmed_name',
    				'logo'
    			]
    		);
    }

    public function programunit(){
    	return $this->belongsTo('\App\Models\Sosmed\Programunit','id')
    		->select(
    			[
    				'id',
    				'program_name'
    			]
    		);
    }

    public function businessunit(){
    	return $this->belongsTo('\App\Models\Sosmed\Businessunit','id')
    		->select(
    			[
    				'id',
    				'unit_name'
    			]
    		);
    }
}
