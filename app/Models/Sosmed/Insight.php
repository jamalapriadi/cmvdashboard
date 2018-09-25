<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    protected $table="insight";

    public function detail(){
        return $this->hasMany('App\Models\Sosmed\Insightdetail','insight_id');
    }
}
