<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Groupunit extends Model
{
    protected $table="group_unit";

    public function unit(){
        return $this->hasMany('App\Models\Sosmed\Businessunit','group_unit_id')
            ->select(
                [
                    'id',
                    'group_unit_id',
                    'unit_name',
                    'type_unit'
                ]
            );
    }
}
