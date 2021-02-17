<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Goutte\Client;

class ScrapOkezone extends Command
{
    /**
    * The name and git signature of the console command.
    *code 
    * @var string
    */
    protected $signature = 'scrap:okezone';
    
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
        )->find(7);
                
        $this->info('Memulai');
            
        foreach($list_portal->kanal as $kan)
        {
            if($kan->type == "indeks")
            {
                $this->info('Menarik Data == '.$kan->url_kanal);
                
                $client = new Client();
                $url = $kan->url_kanal;
                $crawler = $client->request('GET', $url);

                $title=array();
                $list_url=array();
                if($url=="https://celebrity.okezone.com/indeks/"){
                    $crawler->filter('.content-hardnews .c-celebrity a')->each(function($node) use(&$title){
                        $title[]=$node->attr('title');
                    });

                    $crawler->filter('.content-hardnews .c-celebrity a')->each(function($node) use(&$list_url){
                        $list_url[]=$node->attr('href');
                    });
                }else if($url=="https://techno.okezone.com/indeks"){
                    $crawler->filter('.content-hardnews .c-techno a')->each(function($node) use(&$title){
                        $title[]=$node->attr('title');
                    });

                    $crawler->filter('.content-hardnews .c-techno a')->each(function($node) use(&$list_url){
                        $list_url[]=$node->attr('href');
                    });
                }else{
                    $crawler->filter('.content-hardnews .c-news a')->each(function($node) use(&$title){
                        $title[]=$node->attr('title');
                    });

                    $crawler->filter('.content-hardnews .c-news a')->each(function($node) use(&$list_url){
                        $list_url[]=$node->attr('href');
                    });
                }
                
                $tanggal=array();
                $crawler->filter('time.category-hardnews')->each(function($node) use(&$tanggal){
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