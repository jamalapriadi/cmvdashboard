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
			->where('type_sosmed','corporate');
	}

	public function typeunit(){
		return $this->belongsTo('App\Models\Sosmed\Typeunit','type_unit','id');
	}

	public function user(){
		return $this->belongsToMany('App\User','user_handle_unit','business_unit_id','user_id');
	}

	public function followers(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','corporate');
	}

	public function follower_twitter(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','corporate')
			->where('status_active','Y')
			->where('sosmed_id',1);
	}

	public function follower_facebook(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','corporate')
			->where('status_active','Y')
			->where('sosmed_id',2);
	}

	public function follower_instagram(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','corporate')
			->where('status_active','Y')
			->where('sosmed_id',3);
	}

	public function follower_youtube(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','corporate')
			->where('sosmed_id',4);
	}

}
