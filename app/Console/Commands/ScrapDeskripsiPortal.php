<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;

class ScrapDeskripsiPortal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:deskripsi';

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
        $this->info('Update Deskripsi Berita');
        $parameter = \App\Models\Scrap\Parameter::whereNull('deskripsi')
            ->whereNotNull('link_artikel')
            ->with(
                [
                    'kanal',
                    'kanal.parameter'
                ]
            )->groupBy('judul_artikel')
            ->get();

            
        foreach($parameter as $key=>$val)
        {
            if($val->kanal != null)
            {
                if($val->kanal->portal != null)
                {
                    $url = $val->link_artikel;
                    $this->info('URL '.$url);
                    
                    if($url != null)
                    {
                        try {
                            $client = new Client();   
                            
                            $crawler = $client->request('GET', $url);

                            $title="";

                            if($val->kanal->portal->name_portal == "Detik")
                            {
                                $crawler->filter('.itp_bodycontent p')->each(function ($node) use(&$title) {
                                    $title.="<p>".$node->text()."</p>";
                                });

                                if($title == "")
                                {
                                    $crawler->filter('.detail__body-text p')->each(function ($node) use(&$title) {
                                        $title.="<p>".$node->text()."</p>";
                                    });
                                }
                            }else if($val->kanal->portal->name_portal == "Kompas"){
                                $crawler->filter('.read__content p')->each(function ($node) use(&$title) {
                                    $title.="<p>".$node->text()."</p>";
                                });
                            }else if($val->kanal->portal->name_portal == "Tribunnews"){
                                $crawler->filter('.read__content p')->each(function ($node) use(&$title) {
                                    $title.="<p>".$node->text()."</p>";
                                });
                            }

                            $this->info('Update = '.$url);
                            if($title != "")
                            {
                                \App\Models\Scrap\Parameter::where('link_artikel', $val->link_artikel)
                                    ->update(
                                        [
                                            'deskripsi'=>$title
                                        ]
                                    );
                            }
                        } catch (Exception $e) {
                            // exception is raised and it'll be handled here
                            // $e->getMessage() contains the error message
                            $this->info($e->getMessage());
                        }
                    }
                }
            }
        }

        $this->info('Selesai');
    }
}
