<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Google\GTrends;

class ScrapGoogleTrend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:googletrend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('scrap google trends');
        $options = [
            'hl'  => 'en-US',
            'tz'  => -60, # last hour
            'geo' => 'ID',
        ];
        $gt = new GTrends($options);

        $hasil = json_encode($gt->getDailySearchTrends('p54', date('Ymd')));

        // return $hasil;
        \DB::connection('mysql3')
            ->table('scrap_google_trends')
            ->insert(
                [
                    'tanggal'=>date('Y-m-d'),
                    'jam'=>date('H:i:s'),
                    'hasil'=>$hasil,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]
            );

        $this->info('SIMPAN DATA GOOGLE TREND');
        $tanggal = date('Y-m-d');
        $api = "https://mncmediakit.com/api";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $api.'/scrap-list-google-trends-api?tanggal='.$tanggal);

        $hasil = $response->getBody();

        $final = json_decode($hasil);
        
        $data=array();
        if($final->success == true)
        {
            foreach($final->data->original->default->trendingSearchesDays as $key=>$val)
            {
                $cek_day = \App\Models\Scrap\TrendingSearchesDays::where('date', $val->date)
                    ->first();

                if($cek_day != null)
                {
                    $day_s= \App\Models\Scrap\TrendingSearchesDays::find($cek_day->id);
                }else{
                    $day_s= new \App\Models\Scrap\TrendingSearchesDays;
                }
                
                $day_s->date = $val->date;
                $day_s->formattedDate = $val->formattedDate;
                $save_date = $day_s->save();

                if($save_date)
                {
                    foreach($val->trendingSearches as $t)
                    {
                        $cek_tren = \App\Models\Scrap\TrendingSearches::where('title_query', $t->title->query)
                            ->first();

                        if($cek_tren != null)
                        {
                            $tren_day = \App\Models\Scrap\TrendingSearches::find($cek_tren->id);
                        }else{
                            $tren_day = new \App\Models\Scrap\TrendingSearches;
                            $tren_day->scrap_trendingSearchesDays_id = $day_s->id;
                        }
                        
                        if(isset($t->image))
                        {
                            $tren_day->image_source = $t->image->source;
                            $tren_day->image_newsUrl = $t->image->newsUrl;
                            $tren_day->image_imageUrl = $t->image->imageUrl;
                        }
                        
                        $tren_day->title_query = $t->title->query;
                        $tren_day->title_exploreLink = $t->title->exploreLink;
                        $tren_day->shareUrl = $t->shareUrl;
                        $tren_day->formattedTraffic = $t->formattedTraffic;
                        $simpan_tren_day = $tren_day->save();

                        if($simpan_tren_day)
                        {
                            foreach($t->articles as $art)
                            {
                                $cek_ar = \App\Models\Scrap\TrendingSearchesArticles::where('url', $art->url)
                                    ->first();

                                if($cek_ar != null)
                                {
                                    $ar = \App\Models\Scrap\TrendingSearchesArticles::find($cek_ar->id);
                                }else{
                                    $ar = new \App\Models\Scrap\TrendingSearchesArticles;
                                    $ar->scrap_trendingSearches_id = $tren_day->id;
                                }
                                
                                $ar->url = $art->url;
                                if(isset($art->image))
                                {
                                    $ar->image_source = $art->image->source;
                                    $ar->image_newsUrl = $art->image->newsUrl;
                                    $ar->image_imageUrl = $art->image->imageUrl;
                                }
                                
                                $ar->title = $art->title;
                                $ar->source = $art->source;
                                $ar->snippet = $art->snippet;
                                $ar->timeAgo = $art->timeAgo;
                                $simpan_ar = $ar->save();

                                if($simpan_ar)
                                {
                                    //cari di parameter sesuai url dan update trendingnya
                                    \App\Models\Scrap\Parameter::where('link_artikel', $ar->url)
                                        ->update(
                                            [
                                                'trending_google'=>'Y'
                                            ]
                                        );
                                }
                            }

                            foreach($t->relatedQueries as $rel)
                            {
                                $cek_rq = \App\Models\Scrap\TrendingSearchesRelatedQueries::where('kueri', $rel->query)
                                    ->first();

                                if($cek_rq != null)
                                {
                                    $rq = \App\Models\Scrap\TrendingSearchesRelatedQueries::find($cek_rq->id);
                                }else{
                                    $rq = new \App\Models\Scrap\TrendingSearchesRelatedQueries;
                                    $rq->scrap_trendingSearches_id = $tren_day->id;
                                }
                                
                                $rq->kueri = $rel->query;
                                $rq->exploreLink = $rel->exploreLink;
                                $rq->save();
                            }
                        }
                    }
                }
            }

            $http = new \GuzzleHttp\Client();
            $response = $http->request('POST',$api.'/update-scrap-google', [
                'form_params' => [
                    'id'=>$final->model_id
                ],
            ]);
        }
    }
}
