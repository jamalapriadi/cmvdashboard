<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function unitsosmed(){
        return $this->belongsTo('App\Models\Sosmed\Businessunit','unit_id');
    }

    public function unit(){
        return $this->belongsToMany('App\Models\Sosmed\Businessunit','user_handle_unit','user_id','business_unit_id')
            ->select(
                [
                    'id',
                    'group_unit_id',
                    'unit_name',
                    'logo'
                ]
            );
    }
}
