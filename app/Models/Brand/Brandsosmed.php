<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Brandsosmed extends Model
{
    protected $table="brand_sosmed";

    public function brand(){
        return $this->belongsToMany('App\Models\Brand\Brand','intrasm_sosmed.brand_sosmed_unit','brand_id','brand_sosmed_id');
    }

    public function sosmed(){
		return $this->belongsTo('App\Models\Sosmed\Sosmed','sosmed_id')
			->select(
				[
					'id',
					'sosmed_name',
				]
			);
	}
}