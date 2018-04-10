<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Userloginactivity extends Model
{
    protected $table="user_login_activity";

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}