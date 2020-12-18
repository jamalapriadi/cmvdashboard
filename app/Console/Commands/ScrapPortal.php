<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $list_portal = \App\Models\Scrap\Portal::with('kanal')
            ->get();

        foreach($list_portal as $key=>$val)
        {
            $this->info('Portal === '.$val->name_portal);
            $portal = $val->name_portal;

            $tags = array();
            $this->info('Tag == '.$portal);
            
            if($portal === "Detik")
            {
                $crawler = \Goutte::request('GET', $val->url_portal);

                $crawler->filter('.terpopuler > .list-content')->each(function ($node) use(&$tags){
                    $node->filter('h3.media__title')->each(function($t) use(&$tags){
                        $tags[]=$t->text();
                    });
                });

            }elseif($portal === "Kompas"){

            }elseif($portal === "Tribunnews"){
                $crawler = \Goutte::request('GET', $val->url_portal);

                $crawler->filter('.pt20')->each(function ($node) use(&$tags){
                    $node->filter('h5.tagcloud')->each(function($t) use(&$tags){
                        $tags[]=$t->text();
                    });
                });
            }

            foreach($tags as $s=>$v)
            {
                $tg = new \App\Models\Scrap\Tag;
                $tg->portal_id = $val->id;
                $tg->tanggal  = date('Y-m-d');
                $tg->jam = date('H:i:s');
                $tg->tag = $v;
                $tg->save();
            }

            foreach($val->kanal as $kan)
            {
                $url = $kan->url_kanal;

                $this->info('Kanal === '.$kan->kanal_name);

                $list = array();

                if($kan->type_kanal == "Artikel")
                {
                    if($portal === "Detik")
                    {
                        $crawler = \Goutte::request('GET', $url);

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
                    }elseif($portal === "Kompas"){
                        $crawler = \Goutte::request('GET', $url);

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
                    }elseif($portal === "Tribunnews"){
                        $crawler = \Goutte::request('GET', $url);

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
                    }
                }elseif($kan->type_kanal == "Video")
                {
                    
                }

                foreach($list['title'] as $s=>$t)
                {
                    $param = new \App\Models\Scrap\Parameter;
                    $param->tanggal = date('Y-m-d');
                    $param->jam = date('H:i:s');
                    $param->kanal_id = $kan->id;
                    $param->judul_artikel = $t;
                    $param->link_artikel = $list['url'][$s];
                    $param->tanggal_publish = $list['tanggal'][$s];

                    if($portal === "Kompas")
                    {
                        $param->jumlah_views = $list['dibaca'][$s];
                    }

                    $param->save();
                }
            }
        }

        $this->info('Selesai');
    }
}
