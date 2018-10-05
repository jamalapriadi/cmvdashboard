<?php

namespace App\Models\Brand;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertisertype extends Model
{
    protected $connection="mysql4";
    protected $table="db_m_advertiser_type";
    protected $primaryKey="id_advtype";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idcategory'=>'required',
        'idsector'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idcategory.required'=>'please choose category',
        'idsector.required'=>'please choose sector',
    ];

    
    function advertiser(){
        return $this->hasOne('App\Models\Brand\Advertiser','ID_TYPEADV');
    }
}
