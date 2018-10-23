<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level2 extends Model {
    
    protected $table="level2";
    protected $primaryKey="id_level2";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    
    
}
