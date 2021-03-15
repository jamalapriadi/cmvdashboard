<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OfficialYoutubeFollower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'official:youtube';

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

        if($minggu!="Sun"){
            $this->info("Please Wait..., aksi tanggal $sekarang");

            $bu=\DB::select("select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=4
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all
                select a.id, a.program_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from program_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=4
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all 
                select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=4
                and b.id not in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')");

            $bar=$this->output->createProgressBar(count($bu));

            $data=array();
            $list=array();
            $unitsosmedid=array();

            foreach($bu as $row){
                if($row->unit_name != 'INEWS (4TV News)'){
                    $unitsosmedid[]=$row->unit_sosmed_id;

                    if($row->sosmed_id==4){
                        $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',$sekarang)
                            ->whereIn('unit_sosmed_id',$row->unit_sosmed_id)
                            ->count();

                        if($cekfollower == 0)
                        {
                            $this->info("Youtube = ".$row->unit_name);
                            $yt=\Follower::youtube($row->unit_sosmed_account_id);

                            $new=new \App\Models\Sosmed\Unitsosmedfollower;
                            $new->tanggal=$sekarang;
                            $new->unit_sosmed_id=$row->unit_sosmed_id;
                            $new->follower=$yt['subscriber'];
                            $new->view_count=$yt['view_count'];
                            $new->video_count=$yt['video_count'];
                            $new->following=null;
                            $new->post_count=null;
                            $new->insert_user='jamal.apriadi@mncgroup.com';
                            $new->save();
                        }
                    }

                    $bar->advance();
                }
            }
            
            $bar->finish();

            $this->info("yey sukses menyimpan data");

        }else{
            $this->info("Karena ini hari minggu, libur dulu yaaa. . . . :D");
        }
    }
}
