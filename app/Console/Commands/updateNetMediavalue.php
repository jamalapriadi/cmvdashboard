<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateNetMediavalue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:netmediavalue';

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
        // WHERE a.tahun=2019
        // AND a.bulan=7
        // AND a.channel_id=1
        // AND a.product_id=5209

        //cari dulu dashboard client nett
        $this->info('dapetin dashboard net summary');
        
        
        $net_nya = \DB::connection('mysql3')
            ->table('dashboard_client_nett')
            ->where('tahun',2020)
            ->where('bulan',9)
            ->get();

        foreach($net_nya as $key=>$val)
        {
            $this->info('Update produk = '.$val->product_id." Channel = ".$val->channel_id." Bulan = ".$val->bulan." Tahun = ".$val->tahun);

            \DB::connection('mysql3')
                ->table('dashboard_client_monthly')
                ->where('id_product', $val->product_id)
                ->where('id_channel', $val->channel_id)
                ->where('tahun', $val->tahun)
                ->where('bulan', $val->bulan)
                ->update(
                    [
                        'revenue'=>$val->revenue
                    ]
                );
        }

    //     $idnya=[71216,
    //         75396,
    //         79368,
    //         103023,
    //         57028,
    //         79308,
    //         75392,
    //         79366,
    //         83700,
    //         93093,
    //         97846,
    //         106878,
    //         111395,
    //         119474,
    //         123436,
    //         93096,
    //         60318,
    //         78223
    //     ];

    //     $revenue=[
    //         '136.363636',
    //         '209.465',
    //         '1',
    //         '170',
    //         '35',
    //         '12.6',
    //         '93.636363',
    //         '159',
    //         '158.333308',
    //         '116.66668',
    //         '166.66664',
    //         '99.999984',
    //         '100.000024',
    //         '158.333324',
    //         '133.333333',
    //         '124',
    //         '1,093',
    //         '632'
    //     ];

    //     foreach($idnya as $key=>$val){
    //         $this->info('id nya = '.$val.' == revenuenya = '.$revenue[$key]);

    //         \DB::connection('mysql3')
    //             ->table('dashboard_client_monthly')
    //             ->where('id', $val)
    //             ->update(
    //                 [
    //                     'revenue'=>$revenue[$key]
    //                 ]
    //             );


    //     }

        $this->info('Selesai Yey');
    }
}
