<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class TrendingSearchesDays extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_trendingSearchesDays";
    
    public function trendingsearch()
    {
        return $this->hasMany('App\Models\Scrap\TrendingSearches','scrap_trendingSearchesDays_id');
    }
}
