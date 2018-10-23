<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programariana extends Model {
    
    protected $table="program_ariana";
    protected $primaryKey="id_program_ariana";

    use SoftDeletes;

    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    
    
}
