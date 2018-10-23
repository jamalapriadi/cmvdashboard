<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ta extends Model {
    
    protected $table="ta";
    protected $primaryKey="id";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    
    
}
