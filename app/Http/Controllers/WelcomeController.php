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
}