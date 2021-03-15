<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapTribunParameter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:tribunparameter';

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

        $cek = \App\Models\Scrap\Kanal::where('portal_id',4)
                ->where('bisa_scrap','N')
                ->get();

        $list = array();
        foreach($cek as $key=>$val)
        {
            $this->info('Kumpulkan = '.strtolower($val->kanal_name));

            $list[]= array(
                'id'=>$val->id,
                'url'=>"https://www.tribunnews.com/".strtolower($val->kanal_name)
            );
        }

        $artikel = array();
        foreach($list as $key=>$val)
        {
            $l = array();
            
            $this->info('Get Parameter '.$val['url']);

            $parameter = \App\Models\Scrap\Parameter::where(\DB::raw("date_format(tanggal,'%Y-%m-%d')"), date('Y-m-d'))
                    ->where('link_artikel','like','%'.$val['url'].'%')
                    ->groupBy('link_artikel')
                    ->get();

            foreach($parameter as $k){
                $l[]=array(
                    'id'=>$k->id,
                    'artikel'=>$k->link_artikel
                );
            }
            $artikel[]=array(
                'kanal_id'=>$val['id'],
                'link'=>$val['url'],
                'artikel'=>$l
            );
        }

        foreach($artikel as $key=>$val)
        {
            foreach($val['artikel'] as $ar)
            {
                $this->info('Cek Parameter='.$ar['id']);

                $cek_kanal_parameter = \DB::connection('mysql3')
                    ->table('scrap_portal_kanal_parameter')
                    ->where('portal_id', 4)
                    ->where('kanal_id',$val['kanal_id'])
                    ->where('parameter_id',$ar['id'])
                    ->count();

                if($cek_kanal_parameter == 0)
                {
                    $this->info('Simpan='.$ar['id']);

                    \DB::connection('mysql3')
                        ->table('scrap_portal_kanal_parameter')
                        ->insert(
                            [
                                'portal_id'=>4,
                                'kanal_id'=>$val['kanal_id'],
                                'parameter_id'=>$ar['id'],
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s')
                            ]
                        );
                }
            }
        }

        $this->info('Selesai');
    }
}
