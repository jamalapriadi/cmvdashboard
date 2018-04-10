<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table="unit_sosmed_activity";

    public function user(){
        return $this->belongsTo('App\User','insert_user','email')
            ->select(
                [
                    'id',
                    'name',
                    'email',
                    'images'
                ]
            );
    }
}
