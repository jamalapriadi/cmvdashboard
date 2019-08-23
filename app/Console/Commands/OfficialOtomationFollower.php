<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\NotifNarikData;
use Illuminate\Support\Facades\Mail;

class OfficialOtomationFollower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'official:follower';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save otomation official follower social media';

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
                union all
                select a.id, a.program_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from program_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                where b.sosmed_id is not null
                and b.status_active='Y'
                union all 
                select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
                where b.sosmed_id is not null
                and b.status_active='Y'");

            $bar=$this->output->createProgressBar(count($bu));

            $data=array();
            $list=array();
            $unitsosmedid=array();

            foreach($bu as $row){
                $unitsosmedid[]=$row->unit_sosmed_id;

                if($row->sosmed_id==1){
                    $this->info("Get Follower Account Twitter = ".$row->unit_name);

                    $list[]=array(
                        'unit_sosmed_id'=>$row->unit_sosmed_id,
                        'tanggal'=>$sekarang,
                        'follower'=>\Follower::twitter($row->unit_sosmed_name),
                        'view_count'=>null,
                        'video_count'=>null,
                        'following'=>null,
                        'post_count'=>null
                    );
                }

                if($row->sosmed_id==2){
                    $this->info("Get Follower Account Facebook = ".$row->unit_name);

                    $list[]=array(
                        'unit_sosmed_id'=>$row->unit_sosmed_id,
                        'tanggal'=>$sekarang,
                        'follower'=>\Follower::facebook($row->unit_sosmed_account_id),
                        'view_count'=>null,
                        'video_count'=>null,
                        'following'=>null,
                        'post_count'=>null
                    );
                }

                if($row->sosmed_id==3){
                    $this->info("Get Follower Account Instagram = ".$row->unit_name);
                    $ig=\Follower::cek_instagram($row->unit_sosmed_name);

                    $list[]=array(
                        'unit_sosmed_id'=>$row->unit_sosmed_id,
                        'tanggal'=>$sekarang,
                        'follower'=>$ig['all_follower'],
                        'view_count'=>null,
                        'video_count'=>null,
                        'following'=>$ig['mengikuti'],
                        'post_count'=>$ig['jumlah_post']
                    );
                }

                if($row->sosmed_id==4){
                    $this->info("Get Follower Account Youtube = ".$row->unit_name);
                    $yt=\Follower::youtube($row->unit_sosmed_account_id);

                    $list[]=array(
                        'unit_sosmed_id'=>$row->unit_sosmed_id,
                        'tanggal'=>$sekarang,
                        'follower'=>$yt['subscriber'],
                        'view_count'=>$yt['view_count'],
                        'video_count'=>$yt['video_count'],
                        'following'=>null,
                        'post_count'=>null
                    );
                }

                $bar->advance();
            }
            
            $bar->finish();

            $this->info("Get Followers account Success, Now process to save database....");

            /**
             * cek di tabel unit_sosmed follower
             * berdasarkan tanggal sekarang
             * dan berdasarkan unit_sosmed_id in $unitsosmedid
             */
            $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',$sekarang)
                ->whereIn('unit_sosmed_id',$unitsosmedid)
                ->get();

            if(count($cekfollower)>0){
                Mail::to('kurnia.hapsari@mncgroup.com')
                    ->send(new NotifNarikData($sekarang,'Gagal'));

                $this->info("oppsss, anda tidak bisa mengisi data ini");
            }else{
                \DB::transaction(function() use($list){
                    foreach($list as $k=>$v){
                        $new=new \App\Models\Sosmed\Unitsosmedfollower;
                        $new->tanggal=$v['tanggal'];
                        $new->unit_sosmed_id=$v['unit_sosmed_id'];
                        $new->follower=$v['follower'];
                        $new->view_count=$v['view_count'];
                        $new->video_count=$v['video_count'];
                        $new->following=$v['following'];
                        $new->post_count=$v['post_count'];
                        $new->insert_user='jamal.apriadi@mncgroup.com';
                        $new->save();
                    }
                });

                Mail::to('kurnia.hapsari@mncgroup.com')
                    ->send(new NotifNarikData($sekarang,'Sukses'));

                \Artisan::call('cache:clear');
                $this->info("yey sukses menyimpan data");
            }
        }else{
            $this->info("Karena ini hari minggu, libur dulu yaaa. . . . :D");
        }
    }
}
