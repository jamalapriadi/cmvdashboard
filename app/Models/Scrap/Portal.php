<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Portal extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_portal";

    use SoftDeletes;

    public function kanal(){
        return $this->hasMany('App\Models\Scrap\Kanal','portal_id')
            ->where('type_kanal','Artikel');
    }

}
