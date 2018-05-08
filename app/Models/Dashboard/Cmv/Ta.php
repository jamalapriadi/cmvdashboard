<?php

namespace App\Models\Dashboard\Cmv;

use Illuminate\Database\Eloquent\Model;

class Ta extends Model
{
    protected $connection="mysql3";
    protected $table="cmv_target_audience";

    protected $primaryKey="id_ta";

    public $incrementing=false;

}
