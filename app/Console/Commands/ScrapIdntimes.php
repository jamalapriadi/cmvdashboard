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
        $this->info('Mulai');

        $var = \App\Models\Scrap\Parameter_dummy::where('tanggal', date('Y-m-d'))
            ->where('dibaca','N')
            ->get();

        foreach($var as $s=>$t)
        {
            $link_artikel = $t->link_artikel;
            $judul_artikel = $t->judul_artikel;

            $this->info($judul_artikel);

            $cek = \App\Models\Scrap\Parameter::where('judul_artikel',$t->judul_artikel)
                    ->orWhere('link_artikel',$t->link_artikel)
                    ->first();  
                    
            if($cek == null)
            {
                $param = new \App\Models\Scrap\Parameter;
                $param->tanggal = date('Y-m-d');
                $param->jam = date('H:i:s');

                if(stripos($t->link_artikel, 'https://www.idntimes.com/travel') !== FALSE){
                    $param->kanal_id = 210;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/health') !== FALSE){
                    $param->kanal_id = 209;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/life') !== FALSE){
                    $param->kanal_id = 208;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/hype') !== FALSE){
                    $param->kanal_id = 207;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/tech') !== FALSE){
                    $param->kanal_id = 206;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/sport') !== FALSE){
                    $param->kanal_id = 205;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/business') !== FALSE){
                    $param->kanal_id = 204;
                }else if(stripos($t->link_artikel, 'https://www.idntimes.com/news') !== FALSE){
                        $param->kanal_id = 203;
                }else{
                    $param->kanal_id = 0;
                }

                $param->judul_artikel = $t->judul_artikel;
                $param->link_artikel = $t->link_artikel;
                $param->tanggal_publish = $t->tanggal_publish;
                
                $simpanparam = $param->save();
                
                if($simpanparam){

                    $cek_kanal_parameter = \App\Models\Scrap\Kanalparameter::where('parameter_id', $param->id)
                        ->where('kanal_id', $param->kanal_id)
                        ->count();
                    
                    if($cek_kanal_parameter == 0)
                    {
                        $p = new \App\Models\Scrap\Kanalparameter;
                        $p->parameter_id = $param->id;

                        if(stripos($link_artikel, 'https://www.idntimes.com/travel') !== FALSE){
                            $p->kanal_id = 210;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/health') !== FALSE){
                            $p->kanal_id = 209;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/life') !== FALSE){
                            $p->kanal_id = 208;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/hype') !== FALSE){
                            $p->kanal_id = 207;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/tech') !== FALSE){
                            $p->kanal_id = 206;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/sport') !== FALSE){
                            $p->kanal_id = 205;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/business') !== FALSE){
                            $p->kanal_id = 204;
                        }else if(stripos($link_artikel, 'https://www.idntimes.com/news') !== FALSE){
                            $p->kanal_id = 203;
                        }else{
                            $p->kanal_id = 0;
                        }

                        $p->portal_id = 9;
                        $p->save();
                    }
                }
            }else{
                if(stripos($cek->link_artikel, 'https://www.idntimes.com/travel') !== FALSE){
                    $kanal_id = 210;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/health') !== FALSE){
                    $kanal_id = 209;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/life') !== FALSE){
                    $kanal_id = 208;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/hype') !== FALSE){
                    $kanal_id = 207;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/tech') !== FALSE){
                    $kanal_id = 206;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/sport') !== FALSE){
                    $kanal_id = 205;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/business') !== FALSE){
                    $kanal_id = 204;
                }else if(stripos($cek->link_artikel, 'https://www.idntimes.com/news') !== FALSE){
                        $kanal_id = 203;
                }else{
                    $kanal_id = 0;
                }

                $cek_kanal_parameter = \App\Models\Scrap\Kanalparameter::where('parameter_id', $cek->id)
                    ->where('kanal_id', $kanal_id)
                    ->count();
                
                if($cek_kanal_parameter == 0)
                {
                    $p = new \App\Models\Scrap\Kanalparameter;
                    $p->parameter_id = $cek->id;
                    $p->kanal_id = $kanal_id;
                    $p->portal_id = $list_portal->id;
                    $p->save();

                    
                }
            }

            $this->info('Update == '.$t->id);
            
            \App\Models\Scrap\Parameter_dummy::where('id', $t->id)
                    ->update(
                        [
                            'dibaca'=>'Y'
                        ]
                    );
        }

        $this->info('Selesai');
    }
}
