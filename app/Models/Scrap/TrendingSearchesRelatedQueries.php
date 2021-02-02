<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class TrendingSearchesRelatedQueries extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_trendingSearches_relatedQueries";
    
    public function trendingsearch()
    {
        return $this->hasMany('App\Models\Scrap\TrendingSearches','scrap_trendingSearchesDays_id');
    }
}
