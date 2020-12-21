<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $id="BigMoviesGTVID";

        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://www.facebook.com/'.$id);
        $response = $request->getBody()->getContents();
    
        // return json_decode($response, true);
        $page = response()->json($response);

        preg_match("'alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) orang mengikuti ini</div></div>'", $page, $json_matches);
        return $json_matches;

        return;

        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",    // Atur type request, get atau post
            CURLOPT_POST           =>false,    // Atur menjadi GET
            CURLOPT_FOLLOWLOCATION => true,    // Follow redirect aktif
            CURLOPT_CONNECTTIMEOUT => 120,     // Atur koneksi timeout
            CURLOPT_TIMEOUT        => 120,     // Atur response timeout
            CURLOPT_USERAGENT                       =>'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1',
            CURLOPT_RETURNTRANSFER =>1,
    
        );
    
        $ch      = curl_init('https://www.facebook.com/'.$id);          // Inisialisasi Curl'BigMoviesGTVID'
        curl_setopt_array( $ch, $options );    // Set Opsi
        $page = curl_exec( $ch );           // Eksekusi Curl

        preg_match("'alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) orang mengikuti ini</div></div>'", $page, $match);
        preg_match("'alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) people follow this</div></div>'", $page, $match2);
        
        if(isset($match[1])){
            $hasil=preg_replace('/[^0-9]/', '', substr(strip_tags(str_replace('.', '', $match[1])),15));
        }elseif(isset($match2[1])){
            $hasi=preg_replace('/[^0-9]/', '', substr(strip_tags(str_replace('.', '', $match2[1])),15));
        }else{
            $hasil=0;
        }

        return $hasil;

        
        // return \Follower::youtube('UC_vsErcsq56hOscPHkG-aVw');
        $channel = \Youtube::getChannelByID($id);

        $youtube=$channel;

        // return json_encode($channel);
        if(isset($youtube->statistics)){
            return array(
                'subscriber'=>$youtube->statistics->subscriberCount,
                'view_count'=>$youtube->statistics->viewCount,
                'video_count'=>$youtube->statistics->videoCount
            );
        }else{
            return array(
                'subscriber'=>0,
                'view_count'=>0,
                'video_count'=>0
            );
        }
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
}