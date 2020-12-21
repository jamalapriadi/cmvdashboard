<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FollowerInstagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:scrap';

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
                and b.sosmed_id=3
                and b.id in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all
                select a.id, a.program_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from program_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=3
                and b.id in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')
                union all 
                select a.id, a.unit_name,
                b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
                b.unit_sosmed_account_id
                from business_unit a
                left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
                where b.sosmed_id is not null
                and b.status_active='Y'
                and b.sosmed_id=3
                and b.id in (select aa.unit_sosmed_id from unit_sosmed_follower aa where aa.tanggal='$sekarang')");

            $bar=$this->output->createProgressBar(count($bu));

            $data=array();
            $list=array();
            $unitsosmedid=array();

            foreach($bu as $row){
                if($row->unit_name != 'INEWS (4TV News)'){
                    $this->info("Instagram = ".$row->unit_name);

                    $cektanggal=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',date('Y-m-d'))
                        ->where('unit_sosmed_id',$row->unit_sosmed_id)
                        ->count();

                    if($cektanggal > 0)
                    {
                        $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
                        $account = $instagram->getAccount($row->unit_sosmed_name);
                        $medias = $instagram->getMedias($row->unit_sosmed_name, 25);

                        // $new=new \App\Models\Sosmed\Unitsosmedfollower;
                        // $new->tanggal=$sekarang;
                        // $new->unit_sosmed_id=$row->unit_sosmed_id;
                        // $new->follower=$account->getFollowsCount();
                        // $new->view_count=null;
                        // $new->video_count=null;
                        // $new->following=$account->getFollowedByCount();
                        // $new->post_count=$account->getMediaCount();
                        // $new->insert_user='jamal.apriadi@mncgroup.com';
                        // $new->youtube_json=null;
                        // $new->youtube_activity = null;
                        // $new->save();

                        $un_sosmed = \App\Models\Sosmed\Unitsosmed::find($row->unit_sosmed_id);
                        $un_sosmed->ig_id= $account->getId();
                        $un_sosmed->ig_username = $account->getUsername();
                        $un_sosmed->ig_fullname = $account->getFullName();
                        $un_sosmed->ig_biography = $account->getBiography();
                        $un_sosmed->ig_profile_picture_url = $account->getProfilePicUrl();
                        $un_sosmed->ig_external_link = $account->getExternalUrl();
                        $un_sosmed->ig_published_post = $account->getMediaCount();
                        $un_sosmed->ig_followers = $account->getFollowsCount();
                        $un_sosmed->ig_follows = $account->getFollowedByCount();
                        $un_sosmed->ig_is_private = $account->isPrivate();
                        $un_sosmed->ig_is_verified = $account->isVerified();
                        $un_sosmed->save();

                        foreach($medias as $media)
                        {
                            $ig_feed = new \App\Models\Sosmed\Unitsosmedigfeed;
                            $ig_feed->unit_sosmed_id = $un_sosmed->id;
                            $ig_feed->media_id = $media->getId();
                            $ig_feed->shortcode =  $media->getShortCode();
                            $ig_feed->ig_created_at = $media->getCreatedTime();
                            $ig_feed->caption = $media->getCaption();
                            $ig_feed->number_of_comment = $media->getCommentsCount();
                            $ig_feed->number_of_likes = $media->getLikesCount();
                            $ig_feed->get_link = $media->getLink();
                            $ig_feed->hd_image = $media->getImageHighResolutionUrl();
                            $ig_feed->media_type = $media->getType();
                            $ig_feed->save();
                        }
                    }

                    $bar->advance();
                }
            }
            
            $bar->finish();

            $this->info("Yey selesai");

        }else{
            $this->info("Karena ini hari minggu, libur dulu yaaa. . . . :D");
        }
    }
}
