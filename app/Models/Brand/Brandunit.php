<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Brandunit extends Model
{
    protected $table="brand_unit";

    public function brand(){
        return $this->belongsToMany('App\Models\Brand\Brand','intrasm_sosmed.brand_unit_detail','brand_id','brand_unit_id');
    }

    public function sosmed(){
		return $this->hasMany('App\Models\Brand\Brandsosmed','brand_unit_id')
			->where('type_sosmed','brand')
			->select(
				[
					'id',
					'type_sosmed',
					'brand_unit_id',
					'sosmed_id',
					'unit_sosmed_name',
					'status_active',
					'unit_sosmed_account_id',
					'target_use'
				]
			);
    }
}