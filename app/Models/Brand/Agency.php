<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agency extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_agency";
    protected $primaryKey="id_agcy";

    use SoftDeletes;

    public function sosmed(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmed','business_program_unit')
			->where('type_sosmed','agency')
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
	
	public function agencypintu(){
		return $this->hasMany('App\Models\Brand\Agencypintu','id_agcy');
	}

}