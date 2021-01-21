<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;

class ScrapPortal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:portal';

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
     * @return mixed
     */
    public function handle()
    {
        $list_portal = \App\Models\Scrap\Portal::with(
            [
                'kanal',
                'kanal.subkanal'
            ]
        )->get();

        foreach($list_portal as $key=>$val)
        {
            $this->info('Portal === '.$val->name_portal);
            $portal = $val->name_portal;

            $tags = array();
            $this->info('Tag == '.$portal);
            
            if($portal === "Detik")
            {
                $client = new Client();
                $crawler = $client->request('GET', $val->url_portal);

                $crawler->filter('.terpopuler > .list-content')->each(function ($node) use(&$tags){
                    $node->filter('h3.media__title')->each(function($t) use(&$tags){
                        $tags[]=$t->text();
                    });
                });

            }elseif($portal === "Kompas"){

            }elseif($portal === "Tribunnews"){
                $client = new Client();
                $crawler = $client->request('GET', $val->url_portal);

                $crawler->filter('.pt20')->each(function ($node) use(&$tags){
                    $node->filter('h5.tagcloud')->each(function($t) use(&$tags){
                        $tags[]=$t->text();
                    });
                });
            }

            foreach($tags as $s=>$v)
            {
                $cekTag = \App\Models\Scrap\Tag::where('portal_id', $val->id)
                    ->where('tanggal', date('Y-m-d'))
                    ->where('tag', $v)
                    ->count();

                if($cekTag == 0)
                {
                    $tg = new \App\Models\Scrap\Tag;
                    $tg->portal_id = $val->id;
                    $tg->tanggal  = date('Y-m-d');
                    $tg->jam = date('H:i:s');
                    $tg->tag = $v;
                    $tg->save();
                }
            }

            foreach($val->kanal as $kan)
            {
                $client = new Client();
                $url = $kan->url_kanal;

                $this->info($url);
                $this->info('Kanal === '.$kan->kanal_name);

                $list = array();

                if($kan->type_kanal == "Artikel")
                {
                    if($portal === "Detik")
                    {
                        if($url === "https://inet.detik.com/indeks")
                        {
                            $crawler = $client->request('GET', $url);
                            
                            $crawler->filter('.list-content')->each(function ($node) use(&$list, &$kan){
                                $title=array();
                                $node->filter('.media__title')->each(function($t) use(&$title){
                                    // dump($t->text());
                                    $title[]=$t->text();
                                });
                
                                $list_url=array();
                                $tanggal = array();
                                $node->filter('.list-content__item')->each(function($t) use(&$list_url, &$tanggal){
                                    $list_url[]=$t->attr('i-link');
                                    $tanggal[]=$t->attr('i-info');
                                });
                
                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Parameter;
                                        $param->tanggal = date('Y-m-d');
                                        $param->jam = date('H:i:s');
                                        $param->kanal_id = $kan->id;
                                        $param->judul_artikel = $t;
                                        $param->link_artikel = $list_url[$s];
                                        $param->tanggal_publish = $tanggal[$s];

                                        $param->save();
                                    }
                                }
                                
                            });
                        }elseif($url === "https://sport.detik.com/indeks"){
                            $crawler = $client->request('GET', $url);
                            
                            $title=array();
                            $crawler->filter('h2')->each(function ($node) use(&$title) {
                                $title[]=$node->text();
                            });

                            $list_url = array();
                            $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$list_url){
                                $list_url[]=$node->attr("href");
                            });

                            $tanggal=array();
                            $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                                $tanggal[]=$node->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }elseif($url === "https://travel.detik.com/indeks"){
                            $crawler = $client->request('GET', $url);

                            $title=array();
                            $list_url=array();
                            $tanggal = array();
                            $crawler->filter('article')->each(function ($node) use(&$list, &$title, &$list_url, &$tanggal){
                                $node->filter('h3 > a')->each(function($t) use(&$title, &$list_url){
                                    // dump($t->text());
                                    $title[]=$t->text();
                                    $list_url[]=$t->attr("href");
                                });
                    
                                $node->filter('.date')->each(function($t) use(&$tanggal){
                                    $tanggal[]= $t->text();
                                });
                                
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }elseif($url === "https://sport.detik.com/sepakbola/indeks"){
                            $crawler = $client->request('GET', $url);

                            $title=array();
                            $crawler->filter('h2')->each(function ($node) use(&$title) {
                                $title[]=$node->text();
                            });

                            $list_url = array();
                            $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$list_url){
                                $list_url[]=$node->attr("href");
                            });

                            $tanggal=array();
                            $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                                $tanggal[]=$node->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }elseif($url === "https://food.detik.com/indeks"){
                            $crawler = $client->request('GET', $url);

                            $title=array();
                            $crawler->filter('article > a > h2')->each(function ($node) use(&$title) {
                                $title[]=$node->text();
                            });

                            $list_url = array();
                            $crawler->filter('article > a')->each(function ($node) use(&$list_url){
                                $list_url[]=$node->attr("href");
                            });

                            $tanggal=array();
                            $crawler->filter('article > .date')->each(function ($node) use(&$tanggal){
                                $tanggal[]=$node->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }elseif($url === "https://health.detik.com/indeks"){
                            $crawler = $client->request('GET', $url);

                            $title=array();
                            $crawler->filter('article > a > h2')->each(function ($node) use(&$title) {
                                $title[]=$node->text();
                            });

                            $list_url = array();
                            $crawler->filter('article > a')->each(function ($node) use(&$list_url){
                                $list_url[]=$node->attr("href");
                            });

                            $tanggal=array();
                            $crawler->filter('article > .date')->each(function ($node) use(&$tanggal){
                                $tanggal[]=$node->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }elseif($url === "https://wolipop.detik.com/indeks"){
                            $crawler = $client->request('GET', $url);

                            $title=array();
                            $crawler->filter('h3.title')->each(function ($node) use(&$title) {
                                $title[]=$node->text();
                            });

                            $list_url = array();
                            $crawler->filter('h3.title > a')->each(function ($node) use(&$list_url){
                                $list_url[]=$node->attr("href");
                            });

                            $tanggal=array();
                            $crawler->filter('.text > .time')->each(function ($node) use(&$tanggal){
                                $tanggal[]=$node->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        }else{
                            $crawler = $client->request('GET', $url);

                            $crawler->filter('.list-content')->each(function ($node) use(&$list, &$kan){
                                $title=array();
                                $node->filter('.media__title')->each(function($t) use(&$title){
                                    // dump($t->text());
                                    $title[]=$t->text();
                                });
                                
                                $list_url=array();
                                $node->filter('.media__link')->each(function($t) use(&$list_url){
                                    $list_url[]=$t->link()->getUri();
                                });
                                $list_url = array_values(array_unique($list_url));

                                $tanggal = array();
                                $node->filter('.media__date > span')->each(function($t) use(&$tanggal){
                                    $tanggal[]= $t->attr("title");
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Parameter;
                                        $param->tanggal = date('Y-m-d');
                                        $param->jam = date('H:i:s');
                                        $param->kanal_id = $kan->id;
                                        $param->judul_artikel = $t;
                                        $param->link_artikel = $list_url[$s];
                                        $param->tanggal_publish = $tanggal[$s];

                                        $param->save();
                                    }
                                }
                            });
                        }
                    }elseif($portal === "Kompas"){
                        $crawler = $client->request('GET', $url);

                        $crawler->filter('.most')->each(function ($node) use(&$list, &$kan){
                            $title=array();
                            $node->filter('h4.most__title')->each(function($t) use(&$title){
                                $title[]=$t->text();
                            });
                            
                            $list_url=array();
                            $tanggal = array();
                            $node->filter('.most__link')->each(function($t) use(&$list_url, &$tanggal){
                                $list_url[]= $t->link()->getUri();

                                $client = new Client();

                                $detail = $client->request('GET', $t->link()->getUri());
                                
                                $detail->filter('.js-read-article')->each(function ($dt) use(&$tanggal){
                                    $dt->filter('.read__time')->each(function($tl) use(&$tanggal){
                                        $tanggal[]=$tl->text();
                                    });
                                });
                            });
                            $list_url = array_values(array_unique($list_url));

                            $dibaca = array();
                            $node->filter('.most__read')->each(function($t) use(&$dibaca){
                                $dibaca[]= $t->text();
                            });

                            $list=array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>$dibaca
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        });
                    }elseif($portal === "Tribunnews"){
                        $crawler = $client->request('GET', $url);

                        $crawler->filter('.populer')->each(function ($node) use(&$list, &$kan){
                            $title=array();
                            $node->filter('ul > li.art-list')->each(function($t) use(&$title){
                                $title[]=$t->text();
                            });

                            $list_url = array();
                            $node->filter('ul > li.art-list a')->each(function($t) use(&$list_url){
                                $list_url[]= $t->link()->getUri();
                            });
                            $list_url = array_values(array_unique($list_url));

                            $tanggal = array();
                            $node->filter('ul > li.art-list time')->each(function($t) use(&$tanggal){
                                $tanggal[]= $t->attr("title");
                            });

                            $list = array(
                                'title'=>$title,
                                'url'=>$list_url,
                                'tanggal'=>$tanggal,
                                'dibaca'=>array()
                            );

                            foreach($title as $s=>$t)
                            {
                                $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                    ->where('link_artikel',$list_url[$s])
                                    ->where('kanal_id', $kan->id)
                                    ->count();

                                if($cek == 0)
                                {
                                    $param = new \App\Models\Scrap\Parameter;
                                    $param->tanggal = date('Y-m-d');
                                    $param->jam = date('H:i:s');
                                    $param->kanal_id = $kan->id;
                                    $param->judul_artikel = $t;
                                    $param->link_artikel = $list_url[$s];
                                    $param->tanggal_publish = $tanggal[$s];

                                    $param->save();
                                }
                            }
                        });
                    }
                }elseif($kan->type_kanal == "Video")
                {
                    
                }

                // foreach($list['title'] as $s=>$t)
                // {
                //     $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                //         ->where('link_artikel',$list['url'][$s])
                //         ->where('kanal_id', $kan->id)
                //         ->count();

                //     if($cek == 0)
                //     {
                //         $param = new \App\Models\Scrap\Parameter;
                //         $param->tanggal = date('Y-m-d');
                //         $param->jam = date('H:i:s');
                //         $param->kanal_id = $kan->id;
                //         $param->judul_artikel = $t;
                //         $param->link_artikel = $list['url'][$s];
                        
                //         if(!isset($list['tanggal']))
                //         {
                //             $param->tanggal_publish = $list['tanggal'][$s];
                //         }

                //         if($portal === "Kompas")
                //         {
                //             $param->jumlah_views = $list['dibaca'][$s];
                //         }

                //         $param->save();
                //     }
                // }
            }
        }

        $this->info('Get Subkanal');
        foreach($list_portal as $key=>$val)
        {
            $portal = $val->name_portal;

            foreach($val->kanal as $kan)
            {
                $client = new Client();
                $urlnya = $kan->url_kanal;

                $this->info($urlnya);
                $this->info('Kanal === '.$kan->kanal_name);

                $list = array();

                if($kan->type_kanal == "Artikel")
                {
                    if($portal === "Detik")
                    {
                        if($kan->type == "indeks")
                        {
                            $title = array();
                            $crawler = $client->request('GET', $urlnya);
                            $pecah_url = explode("/", $urlnya);

                            if($urlnya === "https://sport.detik.com/indeks"){
                                $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                                        'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }elseif($urlnya === "https://travel.detik.com/indeks"){
                                $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>$node->attr("value"),
                                        'url'=>$node->attr("value")
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }elseif($urlnya === "https://sport.detik.com/sepakbola/indeks"){
                                $crawler->filter('select option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                                        'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }elseif($urlnya === "https://food.detik.com/indeks"){
                                $crawler->filter('select#s_kanal option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $original_url = 'http://'.$pecah_url[2].'/'.$node->attr("value");
                                    $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."/indeks";
                                    if($node->text() == "Semua Berita"){
                                        $original_url = 'http://'.$pecah_url[2].$node->attr("value")."/indeks";
                                        $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."indeks";
                                    }
                    
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>$original_url,
                                        'url'=>$url
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }elseif($urlnya === "https://health.detik.com/indeks"){
                                $crawler->filter('select#s_kanal option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $original_url = 'http://'.$pecah_url[2].'/'.$node->attr("value");
                                    $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."/indeks";
                                    if($node->text() == "Semua Berita"){
                                        $original_url = 'http://'.$pecah_url[2].$node->attr("value")."/indeks";
                                        $url = 'http://'.$pecah_url[2].'/'.$node->attr("value")."indeks";
                                    }
                    
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>$original_url,
                                        'url'=>$url
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }elseif($urlnya === "https://wolipop.detik.com/indeks"){
                                $crawler->filter('select#kanal_top option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                                        'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }else{
                                $crawler->filter('select#select_nav_indeks option')->each(function ($node) use(&$title, &$pecah_url, &$kan) {
                                    $title= array(
                                        'label'=>$node->attr("value"),
                                        'text'=>$node->text(),
                                        'original_url'=>'http://'.$pecah_url[2].$node->attr("value"),
                                        'url'=>'http://'.$pecah_url[2].$node->attr("value")."/indeks"
                                    );

                                    $cek = \App\Models\Scrap\Subkanal::where('text',$title['text'])
                                        ->where('kanal_id', $kan->id)
                                        ->count();

                                    if($cek == 0)
                                    {
                                        $param = new \App\Models\Scrap\Subkanal;
                                        $param->kanal_id = $kan->id;
                                        $param->label = $title['label'];
                                        $param->text = $title['text'];
                                        $param->original_url = $title['original_url'];
                                        $param->url = $title['url'];

                                        $param->save();
                                    }
                                });
                            }
                        }
                        
                    }elseif($portal === "Kompas"){

                    }elseif($portal === "Tribunnews"){

                    }
                }
            }
        }

        $this->info('Update subkanal di parameter');
        foreach($list_portal as $key=>$val)
        {
            $this->info('Portal === '.$val->name_portal);
            $portal = $val->name_portal;

            foreach($val->kanal as $kan)
            {
                $client = new Client();
                $url = $kan->url_kanal;

                $this->info($url);
                $this->info('Kanal === '.$kan->kanal_name);

                $list = array();

                if($kan->type_kanal == "Artikel")
                {
                    if($portal === "Detik")
                    {
                        if($url === "https://inet.detik.com/indeks")
                        {
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);
                            
                                $crawler->filter('.list-content')->each(function ($node) use(&$list, &$kan, &$sub){
                                    $title=array();
                                    $node->filter('.media__title')->each(function($t) use(&$title){
                                        // dump($t->text());
                                        $title[]=$t->text();
                                    });
                    
                                    $list_url=array();
                                    $tanggal = array();
                                    $node->filter('.list-content__item')->each(function($t) use(&$list_url, &$tanggal){
                                        $list_url[]=$t->attr('i-link');
                                        $tanggal[]=$t->attr('i-info');
                                    });
                    
                                    $list=array(
                                        'title'=>$title,
                                        'url'=>$list_url,
                                        'tanggal'=>$tanggal,
                                        'dibaca'=>array()
                                    );

                                    foreach($title as $s=>$t)
                                    {
                                        $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                            ->where('link_artikel',$list_url[$s])
                                            ->where('kanal_id', $kan->id)
                                            ->whereNull('subkanal_id')
                                            ->where('tanggal',date('Y-m-d'))
                                            ->update(
                                                [
                                                    'subkanal_id'=>$sub->id
                                                ]
                                            );
                                    }
                                    
                                });
                            }
                        }elseif($url === "https://sport.detik.com/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);
                            
                                $title=array();
                                $crawler->filter('h2')->each(function ($node) use(&$title) {
                                    $title[]=$node->text();
                                });

                                $list_url = array();
                                $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$list_url){
                                    $list_url[]=$node->attr("href");
                                });

                                $tanggal=array();
                                $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                                    $tanggal[]=$node->text();
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->whereNull('subkanal_id')
                                        ->where('tanggal',date('Y-m-d'))
                                        ->update(
                                            [
                                                'subkanal_id'=>$sub->id
                                            ]
                                        );
                                }

                            }
                        }elseif($url === "https://travel.detik.com/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $title=array();
                                $list_url=array();
                                $tanggal = array();
                                $crawler->filter('article')->each(function ($node) use(&$list, &$title, &$list_url, &$tanggal){
                                    $node->filter('h3 > a')->each(function($t) use(&$title, &$list_url){
                                        // dump($t->text());
                                        $title[]=$t->text();
                                        $list_url[]=$t->attr("href");
                                    });
                        
                                    $node->filter('.date')->each(function($t) use(&$tanggal){
                                        $tanggal[]= $t->text();
                                    });
                                    
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->whereNull('subkanal_id')
                                        ->where('tanggal',date('Y-m-d'))
                                        ->update(
                                            [
                                                'subkanal_id'=>$sub->id
                                            ]
                                        );
                                }
                            }
                        }elseif($url === "https://sport.detik.com/sepakbola/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $title=array();
                                $crawler->filter('h2')->each(function ($node) use(&$title) {
                                    $title[]=$node->text();
                                });

                                $list_url = array();
                                $crawler->filter('.desc_idx  > a')->each(function ($node) use(&$list_url){
                                    $list_url[]=$node->attr("href");
                                });

                                $tanggal=array();
                                $crawler->filter('.labdate ')->each(function ($node) use(&$tanggal){
                                    $tanggal[]=$node->text();
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                if(count($title) == count($list_url))
                                {
                                    foreach($title as $s=>$t)
                                    {
                                        $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                            ->where('link_artikel',$list_url[$s])
                                            ->where('kanal_id', $kan->id)
                                            ->whereNull('subkanal_id')
                                            ->where('tanggal',date('Y-m-d'))
                                            ->update(
                                                [
                                                    'subkanal_id'=>$sub->id
                                                ]
                                            );
                                    }
                                }
                            }
                        }elseif($url === "https://food.detik.com/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $title=array();
                                $crawler->filter('article > a > h2')->each(function ($node) use(&$title) {
                                    $title[]=$node->text();
                                });

                                $list_url = array();
                                $crawler->filter('article > a')->each(function ($node) use(&$list_url){
                                    $list_url[]=$node->attr("href");
                                });

                                $tanggal=array();
                                $crawler->filter('article > .date')->each(function ($node) use(&$tanggal){
                                    $tanggal[]=$node->text();
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->whereNull('subkanal_id')
                                        ->where('tanggal',date('Y-m-d'))
                                        ->update(
                                            [
                                                'subkanal_id'=>$sub->id
                                            ]
                                        );
                                }
                            }
                        }elseif($url === "https://health.detik.com/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $title=array();
                                $crawler->filter('article > a > h2')->each(function ($node) use(&$title) {
                                    $title[]=$node->text();
                                });

                                $list_url = array();
                                $crawler->filter('article > a')->each(function ($node) use(&$list_url){
                                    $list_url[]=$node->attr("href");
                                });

                                $tanggal=array();
                                $crawler->filter('article > .date')->each(function ($node) use(&$tanggal){
                                    $tanggal[]=$node->text();
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->whereNull('subkanal_id')
                                        ->where('tanggal',date('Y-m-d'))
                                        ->update(
                                            [
                                                'subkanal_id'=>$sub->id
                                            ]
                                        );
                                }
                            }
                        }elseif($url === "https://wolipop.detik.com/indeks"){
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $title=array();
                                $crawler->filter('h3.title')->each(function ($node) use(&$title) {
                                    $title[]=$node->text();
                                });

                                $list_url = array();
                                $crawler->filter('h3.title > a')->each(function ($node) use(&$list_url){
                                    $list_url[]=$node->attr("href");
                                });

                                $tanggal=array();
                                $crawler->filter('.text > .time')->each(function ($node) use(&$tanggal){
                                    $tanggal[]=$node->text();
                                });

                                $list=array(
                                    'title'=>$title,
                                    'url'=>$list_url,
                                    'tanggal'=>$tanggal,
                                    'dibaca'=>array()
                                );

                                foreach($title as $s=>$t)
                                {
                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                        ->where('link_artikel',$list_url[$s])
                                        ->where('kanal_id', $kan->id)
                                        ->whereNull('subkanal_id')
                                        ->where('tanggal',date('Y-m-d'))
                                        ->update(
                                            [
                                                'subkanal_id'=>$sub->id
                                            ]
                                        );
                                }
                            }
                        }else{
                            foreach($kan->subkanal as $sub)
                            {
                                $subkanal=str_replace("http","https",$sub->url);
                                $this->info('Subkanal = '.$subkanal);

                                $crawler = $client->request('GET', $subkanal);

                                $crawler->filter('.list-content')->each(function ($node) use(&$list, &$kan, &$sub){
                                    $title=array();
                                    $node->filter('.media__title')->each(function($t) use(&$title){
                                        // dump($t->text());
                                        $title[]=$t->text();
                                    });
                                    
                                    $list_url=array();
                                    $node->filter('.media__link')->each(function($t) use(&$list_url){
                                        $list_url[]=$t->link()->getUri();
                                    });
                                    $list_url = array_values(array_unique($list_url));
    
                                    $tanggal = array();
                                    $node->filter('.media__date > span')->each(function($t) use(&$tanggal){
                                        $tanggal[]= $t->attr("title");
                                    });
    
                                    $list=array(
                                        'title'=>$title,
                                        'url'=>$list_url,
                                        'tanggal'=>$tanggal,
                                        'dibaca'=>array()
                                    );

                                    

                                    
                                    if(count($title) > 0)
                                    {
                                        if(count($title) == count($list_url))
                                        {
                                            foreach($title as $s=>$t)
                                            {
                                                try {
                                                    $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                                                    ->where('link_artikel',$list_url[$s])
                                                    ->where('kanal_id', $kan->id)
                                                    ->whereNull('subkanal_id')
                                                    ->where('tanggal',date('Y-m-d'))
                                                    ->update(
                                                        [
                                                            'subkanal_id'=>$sub->id
                                                        ]
                                                    );
                                                } catch (Exception $e) {
                                                    // exception is raised and it'll be handled here
                                                    // $e->getMessage() contains the error message
                                                }
                                            }
                                        }
                                    }
                                    
                                });
                            }
                        }
                    }elseif($portal === "Kompas"){
                        
                    }elseif($portal === "Tribunnews"){
                        
                    }
                }elseif($kan->type_kanal == "Video")
                {
                    
                }
            }
        }

        $this->info('Selesai');
    }
}
