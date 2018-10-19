<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Brandunit extends Model
{
    protected $table="brand_unit";

    public function brand(){
        return $this->belongsToMany('App\Models\Brand\Brand','intrasm_sosmed.brand_unit_detail','brand_id','brand_unit_id');
	}
	
	public function advertiser(){
		return $this->belongsTo('App\Models\Brand\Advertiser','advertiser_id')
			->select(['id_adv','nama_adv','id_typeadv','id_demography','is_group']);
	}

    public function sosmed(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmed','business_program_unit')
			->where('type_sosmed','brand')
			->select(
				[
					'id',
					'type_sosmed',
					'business_program_unit',
					'sosmed_id',
					'unit_sosmed_name',
					'status_active',
					'unit_sosmed_account_id',
					'target_use'
				]
			);
    }
}