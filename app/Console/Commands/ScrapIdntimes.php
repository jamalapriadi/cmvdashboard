<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapIdntimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:idn';

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
        )->find(9);

        $this->info('Memulai');

        foreach($list_portal->kanal as $kan)
        {
            if($kan->type == "indeks")
            {
                $this->info('Menarik Data == '.$kan->url_kanal);
                
                $var =\DB::connection('mysql3')->table('scrap_portal_parameter_dummy as a')->selectRaw('a.*')
                ->whereDate('a.tanggal', Carbon::today())
                ->where('dibaca', 'N')
                ->get();

                $title=array();
                $list_url=array();
                $tanggal=array();

                foreach($var as $i=>$val){
                    $title[]=$val->link_artikel;
                    $list_url[]=$val->judul_artikel;
                    $tanggal[]=$val->tanggal_publish;
                }
                
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
                            if(stripos($list_url[$s], 'https://www.idntimes.com/travel') !== FALSE){
                                $param->kanal_id = 210;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/health') !== FALSE){
                                $param->kanal_id = 209;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/life') !== FALSE){
                                $param->kanal_id = 208;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/hype') !== FALSE){
                                $param->kanal_id = 207;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/tech') !== FALSE){
                                $param->kanal_id = 206;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/sport') !== FALSE){
                                $param->kanal_id = 205;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/business') !== FALSE){
                                $param->kanal_id = 204;
                            }else if(stripos($list_url[$s], 'https://www.idntimes.com/news') !== FALSE){
                                    $param->kanal_id = 203;
                            }else{
                                $param->kanal_id = 0;
                            }
                            $param->judul_artikel = $t;
                            $param->link_artikel = $list_url[$s];
                            $param->tanggal_publish = $tanggal[$s];
                            
                            $simpanparam = $param->save();

                            $updatedibaca=\App\Models\Scrap\Parameter_dummy::where('judul_artikel',$t)
                            ->where('dibaca', 'N')
                            ->update(
                                [
                                    'dibaca'=>'Y'
                                ]
                            );
                            
                            if($simpanparam){
                                $cek_kanal_parameter = \App\Models\Scrap\Kanalparameter::where('parameter_id', $param->id)
                                ->where('kanal_id', $kan->id)
                                ->count();
                                
                                if($cek_kanal_parameter == 0)
                                {
                                    $p = new \App\Models\Scrap\Kanalparameter;
                                    $p->parameter_id = $param->id;

                                    if(stripos($list_url[$s], 'https://www.idntimes.com/travel') !== FALSE){
                                        $p->kanal_id = 210;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/health') !== FALSE){
                                        $p->kanal_id = 209;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/life') !== FALSE){
                                        $p->kanal_id = 208;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/hype') !== FALSE){
                                        $p->kanal_id = 207;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/tech') !== FALSE){
                                        $p->kanal_id = 206;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/sport') !== FALSE){
                                        $p->kanal_id = 205;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/business') !== FALSE){
                                        $p->kanal_id = 204;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/news') !== FALSE){
                                        $p->kanal_id = 203;
                                    }else{
                                        $p->kanal_id = 0;
                                    }

                                    $p->portal_id = 9;
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

                                    if(stripos($list_url[$s], 'https://www.idntimes.com/travel') !== FALSE){
                                        $p->kanal_id = 210;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/health') !== FALSE){
                                        $p->kanal_id = 209;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/life') !== FALSE){
                                        $p->kanal_id = 208;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/hype') !== FALSE){
                                        $p->kanal_id = 207;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/tech') !== FALSE){
                                        $p->kanal_id = 206;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/sport') !== FALSE){
                                        $p->kanal_id = 205;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/business') !== FALSE){
                                        $p->kanal_id = 204;
                                    }else if(stripos($list_url[$s], 'https://www.idntimes.com/news') !== FALSE){
                                            $p->kanal_id = 203;
                                    }else{
                                        $p->kanal_id = 0;
                                    }

                                
                                $p->portal_id = $list_portal->id;
                                $p->save();

                                $updatedibaca=\App\Models\Scrap\Parameter_dummy::where('judul_artikel',$t)
                                ->where('dibaca', 'N')
                                ->update(
                                    [
                                        'dibaca'=>'Y'
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        }
        
        $this->info('Selesai');
    }
}
