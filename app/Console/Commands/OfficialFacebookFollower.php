<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OfficialFacebookFollower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'official:facebook';

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
        $sekarang=date('Y-m-d');

        $minggu=date('D',strtotime($sekarang));
        
        $this->info("Please Wait..., aksi tanggal $sekarang");

        $bu=\DB::select("select a.id, a.unit_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
            b.unit_sosmed_account_id
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            where b.sosmed_id is not null
            and b.status_active='Y'
            and b.sosmed_id=2
            and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
            union all
            select a.id, a.program_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
            b.unit_sosmed_account_id
            from program_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            where b.sosmed_id is not null
            and b.status_active='Y'
            and b.sosmed_id=2
            and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
            union all 
            select a.id, a.unit_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
            b.unit_sosmed_account_id
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
            where b.sosmed_id is not null
            and b.status_active='Y'
            and b.sosmed_id=2
            and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')");

        $bar=$this->output->createProgressBar(count($bu));

        foreach($bu as $key=>$val)
        {
            $id=$val->unit_sosmed_id;
            
            \DB::table('tarikan_sementara')
                ->delete();

            if($val->unit_name != 'INEWS (4TV News)')
            {
                $this->info("Facebook = ".$val->unit_name);

                $crawler = \Goutte::request('GET', 'https://www.facebook.com/'.$val->unit_sosmed_account_id);
                $crawler->filter('._4bl9')->each(function ($node) use($id) {

                    if (strpos($node->text(), 'orang mengikuti ini') !== false) {
                        \DB::table('tarikan_sementara')
                            ->insert(
                                [
                                    'unit_sosmed_id'=>$id,
                                    'tanggal'=>date('Y-m-d'),
                                    'hasil'=>$node->text(),
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s')
                                ]
                            );
                    }

                    $h=\DB::table('tarikan_sementara')->get();

                    if(count($h) > 0){
                        $cektanggal=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d'))
                            ->where('unit_sosmed_id',$id)
                            ->count();

                        if($cektanggal == 0)
                        {
                            $fo = str_replace("orang mengikuti ini","",$h[0]->hasil);
                            $final = str_replace(".","",$fo);

                            $new=new \App\Models\Sosmed\Unitsosmedfollower;
                            $new->tanggal=date('Y-m-d');
                            $new->unit_sosmed_id=$id;
                            $new->follower=$final;
                            $new->view_count=null;
                            $new->video_count=null;
                            $new->following=null;
                            $new->post_count=null;
                            $new->insert_user='jamal.apriadi@mncgroup.com';
                            $new->save();
                        }
                    }

                });
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info('input manual yang ga dapet');
        
        $bu=\DB::select("select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=2
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all
                select a.id, a.program_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from program_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=2
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all 
                select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=2
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')");

        foreach($bu as $key=>$val)
        {
            $id=$val->unit_sosmed_id;
            
            $cektanggal=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d'))
                            ->where('unit_sosmed_id',$id)
                            ->count();

            if($cektanggal == 0)
            {
                $new=new \App\Models\Sosmed\Unitsosmedfollower;
                $new->tanggal=date('Y-m-d');
                $new->unit_sosmed_id=$id;
                $new->follower=0;
                $new->view_count=null;
                $new->video_count=null;
                $new->following=null;
                $new->post_count=null;
                $new->insert_user='jamal.apriadi@mncgroup.com';
                $new->save();
            }
        }

        
        $this->info("yey sukses menyimpan data");
    }
}
