<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agencypintu extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_agencypintu";
    protected $primaryKey="id_agcyptu";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
    public $timestamps = false;
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idagency'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idagency.required'=>'please choose agency',
    ];

    function agency(){
        return $this->belongsTo('App\Models\Brand\Agency','id_agcy')
            ->select(['id_agcy','name_agency']);
    }

    public function sosmed(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmed','business_program_unit')
			->where('type_sosmed','agencypintu')
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
