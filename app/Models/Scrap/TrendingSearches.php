<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class TrendingSearches extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_trendingSearches";
    
    public function trendingsearchday()
    {
        return $this->belongsTo('App\Models\Scrap\TrendingSearchesDays','scrap_trendingSearchesDays_id');
    }

    public function artikel()
    {
        return $this->hasMany('App\Models\Scrap\TrendingSearchesArticles','scrap_trendingSearches_id');
    }

    public function relatedqueries()
    {
        return $this->hasMany('App\Models\Scrap\TrendingSearchesRelatedQueries','scrap_trendingSearches_id');
    }
}
