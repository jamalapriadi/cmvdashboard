<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_category";
    protected $primaryKey="id_category";
    
    public function brand(){
        return $this->hasMany('App\Models\Brand\Brand','id_sector');
    }
}