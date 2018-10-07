<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Produk extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_product";
    protected $primaryKey="id_produk";

    use SoftDeletes;
    public $timestamps = false;

    public static $rules=[
        'name'=>'required',
        'idcategory'=>'required',
        'idsector'=>'required',
        'idbrand'=>'required',
        'idadvertiser'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idcategory.required'=>'please choose category',
        'idsector.required'=>'please choose sector',
        'idbrand.required'=>'please choose brand',
        'idadvertiser.required'=>'please choose advertiser',
    ];
    
    function category(){
        return $this->belongsTo('App\Models\Brand\Category','id_category')
            ->select(['id_category','name_category']);
    }
    function ta(){
        return $this->belongsTo('App\Models\Brand\Targetaudience','id_ta')
            ->select(['ID_TA','TA_NAME']);
    }
    function sector(){
        return $this->belongsTo('App\Models\Brand\Sector','id_sector')
            ->select(['id_sector','name_sector']);
    }
    function brand(){
        return $this->belongsTo('App\Models\Brand\Brand','id_brand');
    }

    function advertiser(){
        return $this->belongsTo('App\Models\Brand\Advertiser','id_adv');
    }
    
    // function aprun(){
    //     return $this->hasOne('App\Models\Brand\Aprun','id_produk');
    // }

    // function account(){
    //     return $this->hasOne('App\Models\Brand\Account','id_produk')
    //         ->select(['id_targetaccount','id_produk','id_agcyptu','id_agcyptu_run']);
    // }
}
