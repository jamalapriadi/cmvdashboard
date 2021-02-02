<?php

namespace App\Models\Scrap;

use Illuminate\Database\Eloquent\Model;

class TrendingSearchesArticles extends Model
{
    protected $connection="mysql3";
    protected $table="scrap_trendingSearches_articles";
    
    public function trendingsearch()
    {
        return $this->belongsTo('App\Models\Scrap\TrendingSearches','scrap_trendingSearches_id');
    }
}
