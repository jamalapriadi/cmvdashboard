<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sosmed\UnitsosmedInstagram as SosmedInstagram;

class UnitSosmedInstagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sosmed:instagram';

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
                and b.sosmed_id=1
                union all
                select a.id, a.program_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from program_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=1
                union all 
                select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=1");

            $bar=$this->output->createProgressBar(count($bu));

            $data=array();
            $list=array();
            $unitsosmedid=array();

            foreach($bu as $row){
                if($row->unit_name != 'INEWS (4TV News)'){
                    $unitsosmedid[]=$row->unit_sosmed_id;

                    if($row->sosmed_id==3){
                        $this->info("Get Follower Account Instagram = ".$row->unit_name);
                        $ig=\Follower::cek_instagram_account($row->unit_sosmed_name);

                        $list[]=array(
                            'unit_sosmed_id'=>$row->unit_sosmed_id,
                            'account_id'=>$ig['account_id'],
                            'username'=>$ig['username'],
                            'full_name'=>$ig['full_name'],
                            'biography'=>$ig['biography'],
                            'profile_picture_url'=>$ig['profile_picture_url'],
                            'external_link'=>$ig['external_link'],
                            'number_of_published_post'=>$ig['number_of_published_post'],
                            'number_of_followers'=>$ig['number_of_followers'],
                            'number_of_follows'=>$ig['number_of_follows'],
                            'is_private'=>$ig['is_private'],
                            'is_verified'=>$ig['is_verified']
                        );
                    }

                    $bar->advance();
                }
            }
            
            $bar->finish();

            $this->info("Get Followers account Success, Now process to save database....");

            foreach($list as $k=>$v){
                $cekduluya = SosmedInstagram::where('unit_sosmed_id',$v['unit_sosmed_id'])
                    ->count();

                if($cekduluya > 0){
                    //update
                    SosmedInstagram::where('unit_sosmed_id',$v['unit_sosmed_id'])
                        ->update(
                            [
                                'account_id'=>$v['account_id'],
                                'username'=>$v['username'],
                                'full_name'=>$v['full_name'],
                                'biography'=>$v['biography'],
                                'profile_picture_url'=>$v['profile_picture_url'],
                                'external_link'=>$v['external_link'],
                                'number_of_published_post'=>$v['number_of_published_post'],
                                'number_of_followers'=>$v['number_of_followers'],
                                'number_of_follows'=>$v['number_of_follows'],
                                'is_private'=>$v['is_private'],
                                'is_verified'=>$v['is_verified']
                            ]
                        );
                }else{
                    //insert
                    SosmedInstagram::insert(
                            [
                                'unit_sosmed_id'=>$v['unit_sosmed_id'],
                                'account_id'=>$v['account_id'],
                                'username'=>$v['username'],
                                'full_name'=>$v['full_name'],
                                'biography'=>$v['biography'],
                                'profile_picture_url'=>$v['profile_picture_url'],
                                'external_link'=>$v['external_link'],
                                'number_of_published_post'=>$v['number_of_published_post'],
                                'number_of_followers'=>$v['number_of_followers'],
                                'number_of_follows'=>$v['number_of_follows'],
                                'is_private'=>$v['is_private'],
                                'is_verified'=>$v['is_verified']
                            ]
                        );
                }
            }

            $this->info("yey sukses menyimpan data");
            
        }else{
            $this->info("Karena ini hari minggu, libur dulu yaaa. . . . :D");
        }
    }
}
