<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_brand";
    protected $primaryKey="id_brand";
    
    public function category(){
        return $this->belongsTo('App\Models\Brand\Category','id_category');
    }

    public function sector(){
        return $this->belongsTo('App\Models\Brand\Sector','id_sector');
    }

    public function produk(){
        return $this->hasMany('App\Models\Brand\Produk','id_brand','id_brand')
                ->select(
                    [
                        'id_produk',
                        'nama_produk',
                        'id_category',
                        'id_sector',
                        'id_brand',
                        'id_adv'
                    ]
                );
    }
}