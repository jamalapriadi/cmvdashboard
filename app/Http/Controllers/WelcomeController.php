<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Google\GTrends;

class WelcomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function unit(){
        return view('unit');
    }

    public function brand(){
        return view('brand');
    }

    public function info(){
        phpinfo();
    }

    public function tes_follower(){
        $lis=\App\Models\Sosmed\Unitsosmedfollower::paginate(10000);

        $html="";
        $html.="<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Unit Sosmed ID</th>
                    <th>Tanggal</th>
                    <th>Follower</th>
                </tr>
            </thead>
            <tbody>";
            $no=0;
            foreach($lis as $row){
                $no++;
                $html.="<tr>
                        <td>".$no."</td>
                        <td>".$row->unit_sosmed_id."</td>
                        <td>".$row->tanggal."</td>
                        <td>".$row->follower."</td>
                    </tr>";
            }
            $html.="</tbody>
        </table>";

        return $html;
    }

    public function tes_facebook(){
        $id = "CNNIndonesia";
        
        $crawler = \Goutte::request('GET', 'https://www.facebook.com/'.$id);
        $crawler->filter('._4bl9')->each(function ($node) {
            print($node);

        });
    }

    public function clear_cache(){
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }

    public function detik(){
        $crawler = \Goutte::request('GET', 'https://www.detik.com/terpopuler/inet');

        $list = array();
        $crawler->filter('.list-content')->each(function ($node) use(&$list){
            $title=array();
            $node->filter('.media__title')->each(function($t) use(&$title){
                // dump($t->text());
                $title[]=$t->text();
            });
            
            $url=array();
            $node->filter('.media__link')->each(function($t) use(&$url){
                $url[]=$t->link()->getUri();
            });
            $url = array_values(array_unique($url));

            $tanggal = array();
            $node->filter('.media__date > span')->each(function($t) use(&$tanggal){
                $tanggal[]= $t->attr("title");
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        });

        return $list;
    }

    public function video_detik(){
        $crawler = \Goutte::request('GET', 'https://20.detik.com/');

        $list = array();
        $crawler->filter('div.r_content')->each(function ($node) use(&$list){
            // dump($node->outerHtml());
            // dump($node->text());
            dump($node->attr('d-widget'));
            $node->filter('div')->each(function($t){
                dump($t->outerHtml());
                
                $t->filter('h3')->each(function($l){
                    dump($l);
                    dump($l->outerHtml());
                });
            });


            // $node->filter('section.mb30')->each(function($t) use(&$title){
            //     $t->filter('h3')->each($l, function(){
            //         return $l;
            //     });
            // });
        });

        return $list;
    }

    public function kompas(){
        $crawler = \Goutte::request('GET', 'https://money.kompas.com/');

        $list = array();
        $crawler->filter('.most')->each(function ($node) use(&$list){
            $title=array();
            $node->filter('h4.most__title')->each(function($t) use(&$title){
                $title[]=$t->text();
            });
            
            $url=array();
            $tanggal = array();
            $node->filter('.most__link')->each(function($t) use(&$url, &$tanggal){
                $url[]= $t->link()->getUri();

                $detail = \Goutte::request('GET', $t->link()->getUri());
                
                $detail->filter('.js-read-article')->each(function ($dt) use(&$tanggal){
                    $dt->filter('.read__time')->each(function($tl) use(&$tanggal){
                        $tanggal[]=$tl->text();
                    });
                });
            });
            $url = array_values(array_unique($url));

            $dibaca = array();
            $node->filter('.most__read')->each(function($t) use(&$dibaca){
                $dibaca[]= $t->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>$dibaca
            );
        });

        return $list;
    }

    public function tribun(){
        $crawler = \Goutte::request('GET', 'https://www.tribunnews.com/');

        $list = array();
        $crawler->filter('.populer')->each(function ($node) use(&$list){
            $title=array();
            $node->filter('ul > li.art-list')->each(function($t) use(&$title){
                $title[]=$t->text();
            });

            $url = array();
            $node->filter('ul > li.art-list a')->each(function($t) use(&$url){
                $url[]= $t->link()->getUri();
            });
            $url = array_values(array_unique($url));

            $tanggal = array();
            $node->filter('ul > li.art-list time')->each(function($t) use(&$tanggal){
                $tanggal[]= $t->attr("title");
            });

            $list = array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        });

        return $list;
    }

    public function tag_detik(){
        $crawler = \Goutte::request('GET', 'https://www.detik.com');

        $list = array();
        $crawler->filter('.terpopuler > .list-content')->each(function ($node) use(&$list){
            $node->filter('h3.media__title')->each(function($t) use(&$list){
                $list[]=$t->text();
            });
        });

        return $list;
    }

    public function tag_tribun(){
        $crawler = \Goutte::request('GET', 'https://www.tribunnews.com');

        $list = array();
        $crawler->filter('.pt20')->each(function ($node) use(&$list){
            $node->filter('h5.tagcloud')->each(function($t) use(&$list){
                $list[]=$t->text();
            });
        });

        return $list;
    }

    public function index_detik(Request $request)
    {
        $urlnya = "https://sport.detik.com/sepakbola/indeks";
        $subkanal = "https://www.tribunnews.com/index-news/all?date=2021-1-25";
        $client = new Client();
        $crawler = $client->request('GET', $subkanal);

        $list = array();

        /** ========================== GET INDEX TRIBUNNEWS ============================ */
            // $title=array();
            // $crawler->filter('h3.fbo > a')->each(function ($node) use(&$title) {
            //     $title[]=$node->text();
            // });

            // $url = array();
            // $crawler->filter('h3.f16 > a')->each(function ($node) use(&$url){
            //     $url[]=$node->attr("href");
            // });

            // $tanggal=array();
            // $crawler->filter('ul.lsi > li.ptb15 > .grey')->each(function ($node) use(&$tanggal){
            //     $tanggal[]=$node->text();
            // });

            // $subkanal=array();
            // $crawler->filter('h4.f14 > a')->each(function ($node) use(&$subkanal){
            //     $subkanal[]=array(
            //         'text'=>$node->text(),
            //         'url'=>$node->attr("href")
            //     );
            // });

            // $list=array(
            //     'title'=>$title,
            //     'url'=>$url,
            //     'tanggal'=>$tanggal,
            //     'subkanal'=>$subkanal,
            //     'dibaca'=>array()
            // );

            return $list;
        /** ========================== END GET INDEX TRIBUNNEWS ======================== */

        /** ========================== GET SUB KANAL KOMPAS ============================ */
            // $title = array();
            // $crawler->filter('select option')->each(function ($node) use(&$title) {
            //     $title[]= array(
            //         'label'=>$node->attr("value"),
            //         'text'=>$node->text(),
            //         'original_url'=>'https://indeks.kompas.com/?site='.$node->attr("value"),
            //         'url'=>'https://indeks.kompas.com/?site='.$node->attr("value")
            //     );
            // });
            // return $title;
        /** ========================== END GET SUB KANAL KOMPAS ========================= */

        /** ========================== KANAL KOMPAS ==================================== */
            // $title=array();
            // $crawler->filter('a.article__link')->each(function ($node) use(&$title) {
            //     $title[]=$node->text();
            // });

            // $url = array();
            // $crawler->filter('a.article__link')->each(function ($node) use(&$url){
            //     $url[]=$node->attr("href");
            // });

            // $tanggal=array();
            // $crawler->filter('.article__date')->each(function ($node) use(&$tanggal){
            //     $tanggal[]=$node->text();
            // });

            // $subkanal=array();
            // $crawler->filter('.article__subtitle')->each(function ($node) use(&$subkanal){
            //     $subkanal[]=$node->text();
            // });

            // $list=array(
            //     'title'=>$title,
            //     'url'=>$url,
            //     'tanggal'=>$tanggal,
            //     'subkanal'=>$subkanal,
            //     'dibaca'=>array()
            // );

            // return $list;
        /** ======================= END KANAL KOMPAS ================================= */


        if($urlnya === "https://sport.detik.com/indeks"){
            $title=array();
            $crawler->filter('h2')->each(function ($node) use(&$title) {
                $title[]=$node->text();
            });

            $url = array();
            $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$url){
                $url[]=$node->attr("href");
            });

            $tanggal=array();
            $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                $tanggal[]=$node->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );

        }elseif($urlnya === "https://inet.detik.com/indeks"){
            $crawler->filter('.list-content')->each(function ($node) use(&$list){
                $title=array();
                $node->filter('.media__title')->each(function($t) use(&$title){
                    // dump($t->text());
                    $title[]=$t->text();
                });

                $url=array();
                $tanggal = array();
                $node->filter('.list-content__item')->each(function($t) use(&$url, &$tanggal){
                    $url[]=$t->attr('i-link');
                    $tanggal[]=$t->attr('i-info');
                });

                $list=array(
                    'title'=>$title,
                    'url'=>$url,
                    'tanggal'=>$tanggal,
                    'dibaca'=>array()
                );
                
            });
        }elseif($urlnya === "https://travel.detik.com/indeks"){
            $title=array();
            $url=array();
            $tanggal = array();
            $crawler->filter('article')->each(function ($node) use(&$list, &$title, &$url, &$tanggal){
                $node->filter('h3 > a')->each(function($t) use(&$title, &$url){
                    // dump($t->text());
                    $title[]=$t->text();
                    $url[]=$t->attr("href");
                });
    
                $node->filter('.date')->each(function($t) use(&$tanggal){
                    $tanggal[]= $t->text();
                });
                
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
            
        }elseif($urlnya === "https://sport.detik.com/sepakbola/indeks"){
            $title=array();
            $crawler->filter('h2')->each(function ($node) use(&$title) {
                $title[]=$node->text();
            });

            $url = array();
            $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$url){
                $url[]=$node->attr("href");
            });

            $tanggal=array();
            $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                $tanggal[]=$node->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        }elseif($urlnya === "https://food.detik.com/indeks" || $urlnya === "https://health.detik.com/indeks"){
            $title=array();
            $crawler->filter('article > a > h2')->each(function ($node) use(&$title) {
                $title[]=$node->text();
            });

            $url = array();
            $crawler->filter('article > a')->each(function ($node) use(&$url){
                $url[]=$node->attr("href");
            });

            $tanggal=array();
            $crawler->filter('article > .date')->each(function ($node) use(&$tanggal){
                $tanggal[]=$node->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        }elseif($urlnya === "https://wolipop.detik.com/indeks"){
            $title=array();
            $crawler->filter('h3.title')->each(function ($node) use(&$title) {
                $title[]=$node->text();
            });

            $url = array();
            $crawler->filter('h3.title > a')->each(function ($node) use(&$url){
                $url[]=$node->attr("href");
            });

            $tanggal=array();
            $crawler->filter('.text > .time')->each(function ($node) use(&$tanggal){
                $tanggal[]=$node->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        }elseif($urlnya === "https://20.detik.com/"){
            $title=array();
            $crawler->filter('h3.title')->each(function ($node) use(&$title) {
                $title[]=$node->text();
            });

            $url = array();
            $crawler->filter('h3.title > a')->each(function ($node) use(&$url){
                $url[]=$node->attr("href");
            });

            $tanggal=array();
            $crawler->filter('.text > .time')->each(function ($node) use(&$tanggal){
                $tanggal[]=$node->text();
            });

            $list=array(
                'title'=>$title,
                'url'=>$url,
                'tanggal'=>$tanggal,
                'dibaca'=>array()
            );
        }else{
            $crawler->filter('.list-content')->each(function ($node) use(&$list){
                $title=array();
                $node->filter('.media__title')->each(function($t) use(&$title){
                    // dump($t->text());
                    $title[]=$t->text();
                });
                
                $url=array();
                $node->filter('.media__link')->each(function($t) use(&$url){
                    $url[]=$t->link()->getUri();
                });
                $url = array_values(array_unique($url));
    
                $tanggal = array();
                $node->filter('.media__date > span')->each(function($t) use(&$tanggal){
                    $tanggal[]= $t->attr("title");
                });
    
                $list=array(
                    'title'=>$title,
                    'url'=>$url,
                    'tanggal'=>$tanggal,
                    'dibaca'=>array()
                );
            });
        }
        

        return $list;
    }

    public function subkanal_detik(Request $request)
    {
        $urlnya = "https://hot.detik.com/indeks";
        $client = new Client();
        $crawler = $client->request('GET', $urlnya);

        $pecah_url = explode("/", $urlnya);
        
        $title = array();
        if($urlnya === "https://sport.detik.com/indeks"){
            $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url) {
                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                    'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                );
            });
        }elseif($urlnya === "https://travel.detik.com/indeks"){
            $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url) {
                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>$node->attr("value"),
                    'url'=>$node->attr("value")
                );
            });
        }elseif($urlnya === "https://sport.detik.com/sepakbola/indeks"){
            $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url) {
                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                    'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                );
            });
        }elseif($urlnya === "https://food.detik.com/indeks"){
            $crawler->filter('select#s_kanal option')->each(function ($node) use(&$title, &$pecah_url) {
                $original_url = 'http://'.$pecah_url[2].'/'.$node->attr("value");
                $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."/indeks";
                if($node->text() == "Semua Berita"){
                    $original_url = 'http://'.$pecah_url[2].$node->attr("value")."/indeks";
                    $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."indeks";
                }

                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>$original_url,
                    'url'=>$url
                );
            });
        }elseif($urlnya === "https://health.detik.com/indeks"){
            $crawler->filter('select#s_kanal option')->each(function ($node) use(&$title, &$pecah_url) {
                $original_url = 'http://'.$pecah_url[2].'/'.$node->attr("value");
                $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."/indeks";
                if($node->text() == "Semua Berita"){
                    $original_url = 'http://'.$pecah_url[2].$node->attr("value")."/indeks";
                    $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."indeks";
                }

                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>$original_url,
                    'url'=>$url
                );
            });
        }elseif($urlnya === "https://wolipop.detik.com/indeks"){
            $crawler->filter('select#kanal_top option')->each(function ($node) use(&$title, &$pecah_url) {
                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                    'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                );
            });
        }else{
            $crawler->filter('select#select_nav_indeks option')->each(function ($node) use(&$title, &$pecah_url) {
                $title [] = array(
                    'label'=>$node->attr("value"),
                    'text'=>$node->text(),
                    'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                    'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                );
            });
        }

        return $title;
    }

    public function deskripsi(Request $request)
    {
        /**========================= SCRAP GOOGLE TRENDS ============================== */
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

            return "sukses";
            // return response()->json($gt->interestOverTime('Dublin'));
        /**========================= END SCRAP GOOGLE TRENDS ============================== */

        return "sukses";

        $subkanal = " https://inet.detik.com/security/d-5349450/500-juta-nomor-telepon-pengguna-facebook-dijual-di-telegram?tag_from=wp_nhl_1";
        $client = new Client();
        $crawler = $client->request('GET', $subkanal);

        /** ======================== DESKRIPSI DETIK ================================== */
            // $title="";
            // $crawler->filter('.itp_bodycontent p')->each(function ($node) use(&$title) {
            //     $title.="<p>".$node->text()."</p>";
            // });

            // if($title == "")
            // {
            //     $crawler->filter('.detail__body-text p')->each(function ($node) use(&$title) {
            //         $title.="<p>".$node->text()."</p>";
            //     });
            // }
        /** ======================== END DESKRIPSI DETIK ================================== */

        /** ======================== DESKRIPSI KOMPAS ================================== */
            // $title="";
            // $crawler->filter('.read__content p')->each(function ($node) use(&$title) {
            //     $title.="<p>".$node->text()."</p>";
            // });
        /** ======================== END DESKRIPSI KOMPAS =============================== */

        /** ======================== DESKRIPSI TRIBUN ================================== */
            // $title="";
            // $crawler->filter('.side-article p')->each(function ($node) use(&$title) {
            //     $title.="<p>".$node->text()."</p>";
            // });
        /** ======================== END DESKRIPSI TRIBUN ================================== */
        
        if($title != "")
        {
            return $title;
        }else{
            return "Not Found";
        }
        
    }

    public function mediakit(Request $request)
    {
        $model = \App\Models\Scrap\TrendingSearchesDays::with(
            [
                'trendingsearch',
                'trendingsearch.artikel',
                'trendingsearch.relatedqueries'
            ]
        )->get();

        return $model;
        
        $tanggal = date('Y-m-d');
        $api = "https://mncmediakit.com/api";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $api.'/scrap-list-google-trends-api?tanggal='.$tanggal);

        // echo $response->getStatusCode(); // 200
        // echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        // echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

        $hasil = $response->getBody();

        // $final = response()->json(json_decode($hasil));
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
                        $cek_tren = \App\Models\Scrap\TrendingSearches::where('image_newsUrl', $t->image->newsUrl)
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

        return array(
            'success'=>true,
            'message'=>"Data berhasil disimpan"
        );
    }
}