<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class SosmedapiController extends Controller
{
    public function list_unit_by_name($id){
        $unit=\App\Models\Sosmed\Businessunit::where('unit_name',$id)
            ->with(
                [
                    'sosmed'
                ]
            )
            ->first();

        return $unit;
    }
}