<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Unitsosmed extends Model
{
	// use SoftDeletes;

	protected $table="unit_sosmed";
	
	// protected $dates=['deleted_at'];

	public function sosmed(){
		return $this->belongsTo('App\Models\Sosmed\Sosmed','sosmed_id')
			->select(
				[
					'id',
					'sosmed_name',
				]
			);
	}

	public function followers(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmedfollower','unit_sosmed_id');
	}

	public function target(){
		return $this->hasOne('App\Models\Sosmed\Unitsosmedtarget','id','target_use');
	}

	public function alltarget(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmedtarget','id','target_use');
	}

	public function program(){
		return $this->belongsTo('App\Models\Sosmed\Programunit','business_program_unit');
	}

	public function businessunit(){
		return $this->belongsTo('App\Models\Sosmed\Businessunit','business_program_unit')
			->select(
				[
					'id',
					'group_unit_id',
					'unit_name',
					'logo'
				]
			);
	}
}
