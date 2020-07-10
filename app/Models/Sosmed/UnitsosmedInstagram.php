<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UnitsosmedInstagram extends Model
{
	// use SoftDeletes;
	protected $connection="mysql";
	protected $table="unit_sosmed_instagram";
    
}