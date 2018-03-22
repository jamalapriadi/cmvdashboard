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
	
	// public function sosmed(){
	// 	return $this->belongsToMany('App\Models\Sosmed\Sosmed','unit_sosmed','business_program_unit','sosmed_id','id','id')
	// 		->where('type_sosmed','corporate')
	// 		->withPivot('id','type_sosmed','unit_sosmed_name')
	// 		->select(['sosmed.id','sosmed_name']);
	// }

	public function program(){
		return $this->hasMany('App\Models\Sosmed\Programunit','business_unit_id');
	}

	public function sosmed(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmed','business_program_unit')
			->where('type_sosmed','corporate')
			->select(
				[
					'id',
					'type_sosmed',
					'business_program_unit',
					'sosmed_id',
					'unit_sosmed_name',
					'target_use'
				]
			);
	}

	public function user(){
		return $this->belongsToMany('App\User','user_handle_unit','business_unit_id','user_id');
	}

}
