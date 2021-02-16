<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Goutte\Client;

class ScrapInews extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'scrap:inews';
    
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
        $list_portal = \App\Models\Scrap\Portal::with(
            [
                'kanal',
                'kanal.subkanal'
            ]
            )->find(6);
                
            $this->info('Memulai');
            
            foreach($list_portal->kanal as $kan)
            {
                if($kan->type == "indeks")
                {
                    $this->info('Menarik Data == '.$kan->url_kanal);
                    
                    $client = new Client();
                    $url = $kan->url_kanal;
                    $crawler = $client->request('GET', $url."/".date('d-m-Y'));
                    
                    $title=array();
                    $crawler->filter('h3.title-news-update')->each(function($node) use(&$title){
                        $title[]=$node->text();
                    });
                    
                    $list_url=array();
                    $crawler->filter('ul.list-unstyled li a')->each(function($node) use(&$list_url){
                        $list_url[]=$node->attr('href');
                    });
                    
                    $tanggal=array();
                    $crawler->filter('.news-excerpt div.date')->each(function($node) use(&$tanggal){
                        $tanggal[]=$node->text();
                    });
                    
                    if(count($title) == count($tanggal))
                    {
                        foreach($title as $s=>$t)
                        {
                            $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t)
                            ->orWhere('link_artikel',$list_url[$s])
                            ->first();
                            
                            if($cek == null)
                            {
                                $param = new \App\Models\Scrap\Parameter;
                                $param->tanggal = date('Y-m-d');
                                $param->jam = date('H:i:s');
                                $param->kanal_id = $kan->id;
                                $param->judul_artikel = $t;
                                $param->link_artikel = $list_url[$s];
                                $param->tanggal_publish = $tanggal[$s];
                                
                                $simpanparam = $param->save();
                                
                                if($simpanparam){
                                    $cek_kanal_parameter = \App\Models\Scrap\Kanalparameter::where('parameter_id', $param->id)
                                    ->where('kanal_id', $kan->id)
                                    ->count();
                                    
                                    if($cek_kanal_parameter == 0)
                                    {
                                        $p = new \App\Models\Scrap\Kanalparameter;
                                        $p->parameter_id = $param->id;
                                        $p->kanal_id = $kan->id;
                                        $p->portal_id = $list_portal->id;
                                        $p->save();
                                    }
                                }
                            }else{
                                $cek_kanal_parameter = \App\Models\Scrap\Kanalparameter::where('parameter_id', $cek->id)
                                ->where('kanal_id', $kan->id)
                                ->count();
                                
                                if($cek_kanal_parameter == 0)
                                {
                                    $p = new \App\Models\Scrap\Kanalparameter;
                                    $p->parameter_id = $cek->id;
                                    $p->kanal_id = $kan->id;
                                    $p->portal_id = $list_portal->id;
                                    $p->save();
                                }
                            }
                        }
                    }
                }
            }
            
            $this->info('Selesai');
        }
    }
        