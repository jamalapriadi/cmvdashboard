<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_sector";
    protected $primaryKey="id_sector";

    public function brand(){
        return $this->hasMany('App\Models\Brand\Brand','id_sector');
    }
}