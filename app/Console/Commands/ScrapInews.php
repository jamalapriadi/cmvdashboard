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
                            $param->tanggal_publish = scrap_jam($tanggal[$s]);
                            
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

        $bulan_sekarang = date('Y-m');

        /** UPDATE UNTUK PORTAL 4 DAN 5 */
            $sql= \DB::connection('mysql3')
                ->select("SELECT a.*
                FROM view_scrap_portal_parameter a
                LEFT JOIN scrap_portal_kanal b ON b.id=a.kanal_id
                LEFT JOIN scrap_portal_parameter c ON c.id=a.id
                WHERE b.portal_id in (4,5)
                AND a.portal_publish IS NULL 
                AND DATE_FORMAT(a.created_at,'%Y-%m')='$bulan_sekarang'");

            $list = array();
            foreach($sql as $key=>$val)
            {
                $list[]= array(
                    'id'=>$val->id,
                    'judul_artikel'=>$val->judul_artikel,
                    'tanggal_asli'=>$val->tanggal_publish,
                    'tanggal'=>date('Y-m-d H:i', strtotime($val->tanggal_publish))." WIB",
                    'jam'=>date('H:i:s', strtotime($val->tanggal_publish))
                    // 'jam'=>$this->scrap_jam($val->tanggal_publish)
                );
            }

            foreach($list as $key=>$val){
                $sql= \DB::connection('mysql3')
                    ->table('scrap_portal_parameter')
                    ->where('id', $val['id'])
                    ->update(
                        [
                            'tanggal_publish'=>$val['tanggal'],
                            // 'jam'=>$val['jam']
                        ]
                    );
            }
        /** END UPDATE UNTUK PORTAL 4 DAN 5 */

        /** UPDATE UNTUK PORTAL DENGAN KATEGORI DETIK DAN MENIT LALU */
            $sql= \DB::connection('mysql3')
                ->select("SELECT a.*
                FROM view_scrap_portal_parameter a
                LEFT JOIN scrap_portal_kanal b ON b.id=a.kanal_id
                LEFT JOIN scrap_portal_parameter c ON c.id=a.id
                WHERE a.portal_publish IS NULL 
                AND ( a.tanggal_publish LIKE '%MENIT LALU%' OR a.tanggal_publish LIKE '%DETIK LALU%' OR a.tanggal_publish LIKE '%BARU SAJA%')
                AND DATE_FORMAT(a.created_at,'%Y-%m')='$bulan_sekarang'");

            $list = array();
            foreach($sql as $key=>$val)
            {
                $list[]= array(
                    'id'=>$val->id,
                    'judul_artikel'=>$val->judul_artikel,
                    'tanggal_asli'=>$val->tanggal_publish,
                    'tanggal'=>date('Y-m-d H:i', strtotime($val->created_at))." WIB",
                    'jam'=>date('H:i:s', strtotime($val->created_at))
                );
            } 

            foreach($list as $key=>$val){
                $sql= \DB::connection('mysql3')
                    ->table('scrap_portal_parameter')
                    ->where('id', $val['id'])
                    ->update(
                        [
                            'tanggal_publish'=>$val['tanggal'],
                            // 'jam'=>$val['jam']
                        ]
                    );
            }
        /** END UPDATE UNTUK PORTAL DENGAN KATEGORI DETIK DAN MENIT LALU */

        /** UPDATE UNTUK PORTAL DENGAN JAM LALU */
            $sql= \DB::connection('mysql3')
                ->select("SELECT a.*
                FROM view_scrap_portal_parameter a
                LEFT JOIN scrap_portal_kanal b ON b.id=a.kanal_id
                LEFT JOIN scrap_portal_parameter c ON c.id=a.id
                WHERE a.portal_publish IS NULL 
                AND a.tanggal_publish LIKE '%JAM LALU%'
                AND DATE_FORMAT(a.created_at,'%Y-%m')='$bulan_sekarang'");

            $list = array();
            foreach($sql as $key=>$val)
            {
                $pecah_jam = explode(" ",$val->tanggal_publish);
                $my_date_time = date("Y-m-d H:i:s", strtotime($val->created_at."-".$pecah_jam[0]." hours"));

                $list[]= array(
                    'id'=>$val->id,
                    'judul_artikel'=>$val->judul_artikel,
                    'tanggal_asli'=>$my_date_time,
                    'tanggal'=>date('Y-m-d H:i', strtotime($val->created_at))." WIB",
                    'jam'=>date('H:i:s', strtotime($val->created_at))
                );
            }

            foreach($list as $key=>$val){
                $sql= \DB::connection('mysql3')
                    ->table('scrap_portal_parameter')
                    ->where('id', $val['id'])
                    ->update(
                        [
                            'tanggal_publish'=>$val['tanggal'],
                        ]
                    );
            }
        /** END UPDATE UNTUK PORTAL DENGAN JAM LALU */
            
        $this->info('Selesai');
    }
}
    
        