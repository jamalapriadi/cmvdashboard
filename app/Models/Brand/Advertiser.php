<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertiser extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_advertiser";
    protected $primaryKey="id_adv";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    public static $rules=[
        'name'=>'required',
        'idtype'=>'required',
        'isgroup'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idtype.required'=>'please choose type advertiser',
        'isgroup.required'=>'please choose is group',
    ];
    
    function produk(){
        return $this->hasOne('App\Models\Brand\Produk','id_produk');
    }

    function advertisertype(){
        return $this->belongsTo('App\Models\Brand\Advertisertype','id_typeadv');
    }
}
