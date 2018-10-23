<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model {
    
    protected $table="db_m_channel";
    protected $primaryKey="id_channel";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    
    
}
