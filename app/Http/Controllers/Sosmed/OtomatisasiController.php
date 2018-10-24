<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Businessunit;

class OtomatisasiController extends Controller
{
    public function official_sosmed(){
        $bu=\DB::select("select a.id, a.unit_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, 
            b.unit_sosmed_account_id
            from business_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='corporate'
            where b.sosmed_id is not null
            and b.status_active='Y'
            union all
            select a.id, a.program_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, b.unit_sosmed_account_id
            from program_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='program'
            where b.sosmed_id is not null
            and b.status_active='Y'
            union all
            select a.id, a.program_name,
            b.id as unit_sosmed_id, b.sosmed_id, b.unit_sosmed_name, b.status_active, b.unit_sosmed_account_id
            from program_unit a
            left join unit_sosmed b on b.business_program_unit=a.id and b.type_sosmed='brand'
            where b.sosmed_id is not null
            and b.status_active='Y'");
        
        $sekarang=date('Y-m-d');

        $data=array();
        $list=array();
        $unitsosmedid=array();

        foreach($bu as $row){
            $unitsosmedid[]=$row->unit_sosmed_id;

            if($row->sosmed_id==1){
                $list[]=array(
                    'unit_sosmed_id'=>$row->unit_sosmed_id,
                    'tanggal'=>$sekarang,
                    'follower'=>\Follower::twitter($row->unit_sosmed_name)
                );
            }

            if($row->sosmed_id==2){
                $list[]=array(
                    'unit_sosmed_id'=>$row->id,
                    'tanggal'=>$sekarang,
                    'follower'=>\Follower::facebook($row->unit_sosmed_account_id)
                );
            }

            if($row->sosmed_id==3){
                $list[]=array(
                    'unit_sosmed_id'=>$row->id,
                    'tanggal'=>$sekarang,
                    'follower'=>\Follower::instagram($row->unit_sosmed_name)
                );
            }

            if($row->sosmed_id==4){
                $list[]=array(
                    'unit_sosmed_id'=>$row->id,
                    'tanggal'=>$sekarang,
                    'follower'=>\Follower::youtube($row->unit_sosmed_account_id)
                );
            }
        }

        /**
         * cek di tabel unit_sosmed follower
         * berdasarkan tanggal sekarang
         * dan berdasarkan unit_sosmed_id in $unitsosmedid
         */
        $cekfollower=\App\Models\Sosmed\Unitsosmedfollower::where('tanggal',$sekarang)
            ->whereIn('unit_sosmed_id',$unitsosmedid)
            ->get();

        if(count($cekfollower)>0){
            return "oppsss, anda tidak bisa mengisi data ini";
        }else{
            \DB::transaction(function() use($list){
                foreach($list as $k=>$v){
                    $new=new \App\Models\Sosmed\Unitsosmedfollower;
                    $new->tanggal=$v['tanggal'];
                    $new->unit_sosmed_id=$v['unit_sosmed_id'];
                    $new->follower=$v['follower'];
                    $new->insert_user='jamal.apriadi@mncgroup.com';
                    $new->save();
                }
            });

            return "yey sukses menyimpan data";
        }

        return $list;
    }

    public function cek_sosmed(Request $request){
        $user=\App\User::with(
                [
                    'unit',
                    'unit.sosmed',
                    'unit.program'=>function($q){
                        $q->whereHas('sosmed');
                    },
                    'unit.program.sosmed'
                ]
            )
            ->whereHas('unit')
            ->find(1);
        
        $data=array();

        /**
         * Looping unit (official)
         */
        foreach($user->unit as $unit){
            $twitterOfficial=array();
            $facebookOfficial=array();
            $instagramOfficial=array();
            $youtubeOfficial=array();
            foreach($unit->sosmed as $sosmed){
                /**
                 * growth = ((follower_sekarang/follower_kemarin) - 1) *100
                 */
                if($sosmed->sosmed_id==1){
                    $last_day=$this->get_last_day_follower($sosmed->id);
                    $flw=$this->twitter_follower($sosmed->unit_sosmed_name);

                    $twitterOfficial=array(
                        'unit_sosmed_id'=>$sosmed->id,
                        'account'=>$sosmed->unit_sosmed_name,
                        'last_day'=>$last_day,
                        'follower'=>$flw,
                        'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                        'num_of_growth'=>(int)$flw-(int)$last_day
                    );
                }

                if($sosmed->sosmed_id==2){
                    $last_day=$this->get_last_day_follower($sosmed->id);
                    // $flw=$this->facebook_follower($sosmed->unit_sosmed_name);
                    $flw=$this->get_follower_sekarang($sosmed->id);

                    $facebookOfficial=array(
                        'unit_sosmed_id'=>$sosmed->id,
                        'account'=>$sosmed->unit_sosmed_name,
                        'last_day'=>$last_day,
                        'follower'=>$flw,
                        'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                        'num_of_growth'=>(int)$flw-(int)$last_day
                    );
                }

                if($sosmed->sosmed_id==3){
                    $last_day=$this->get_last_day_follower($sosmed->id);
                    $flw=$this->instagram_follower($sosmed->unit_sosmed_name);

                    $instagramOfficial=array(
                        'unit_sosmed_id'=>$sosmed->id,
                        'account'=>$sosmed->unit_sosmed_name,
                        'last_day'=>$last_day,
                        'follower'=>$flw,
                        'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                        'num_of_growth'=>(int)$flw-$last_day
                    );
                }

                // if($sosmed->sosmed_id==4){
                //     $last_day=$this->get_last_day_follower($sosmed->id);
                //     $flw=$this->youtube_follower($sosmed->unit_sosmed_name);

                //     $youtubeOfficial=array(
                //         'unit_sosmed_id'=>$sosmed->id,
                //         'account'=>$sosmed->unit_sosmed_name,
                //         'last_day'=>$last_day,
                //         'follower'=>$flw,
                //         'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                //         'num_of_growth'=>(int)$flw-(int)$last_day
                //     );
                // }
            }

            /**
             * Looping program and save to varabel program
             */
            $program=array();
            foreach($unit->program as $prog){
                $twitterProgram=array();
                $facebookProgram=array();
                $instagramProgram=array();
                $youtubeProgram=array();

                foreach($prog->sosmed as $sosmed){
                    /**
                     * growth = ((follower_sekarang/follower_kemarin) - 1) *100
                     */
                    if($sosmed->sosmed_id==1){
                        $last_day=$this->get_last_day_follower($sosmed->id);
                        $flw=$this->twitter_follower($sosmed->unit_sosmed_name);
    
                        $twitterProgram=array(
                            'unit_sosmed_id'=>$sosmed->id,
                            'account'=>$sosmed->unit_sosmed_name,
                            'last_day'=>$last_day,
                            'follower'=>$flw,
                            'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                            'num_of_growth'=>(int)$flw-(int)$last_day
                        );
                    }
    
                    if($sosmed->sosmed_id==2){
                        $last_day=$this->get_last_day_follower($sosmed->id);
                        // $flw=$this->facebook_follower($sosmed->unit_sosmed_name);
                        $flw=$this->get_follower_sekarang($sosmed->id);
    
                        $facebookProgram=array(
                            'unit_sosmed_id'=>$sosmed->id,
                            'account'=>$sosmed->unit_sosmed_name,
                            'last_day'=>$last_day,
                            'follower'=>$flw,
                            'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                            'num_of_growth'=>(int)$flw-(int)$last_day
                        );
                    }
    
                    if($sosmed->sosmed_id==3){
                        $last_day=$this->get_last_day_follower($sosmed->id);
                        $flw=$this->instagram_follower($sosmed->unit_sosmed_name);
    
                        $instagramProgram=array(
                            'unit_sosmed_id'=>$sosmed->id,
                            'account'=>$sosmed->unit_sosmed_name,
                            'last_day'=>$last_day,
                            'follower'=>$flw,
                            'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                            'num_of_growth'=>(int)$flw-$last_day
                        );
                    }
    
                    // if($sosmed->sosmed_id==4){
                    //     $last_day=$this->get_last_day_follower($sosmed->id);
                    //     $flw=$this->youtube_follower($sosmed->unit_sosmed_name);
    
                    //     $youtubeProgram=array(
                    //         'unit_sosmed_id'=>$sosmed->id,
                    //         'account'=>$sosmed->unit_sosmed_name,
                    //         'last_day'=>$last_day,
                    //         'follower'=>$flw,
                    //         'growth'=>(((int)$flw/(int)$last_day)-1)*100,
                    //         'num_of_growth'=>(int)$flw-(int)$last_day
                    //     );
                    // }
                }

                $program[]=array(
                    'id'=>$prog->id,
                    'name'=>$prog->program_name,
                    'official'=>array(
                        'twitter'=>$twitterProgram,
                        'facebook'=>$facebookProgram,
                        'instagram'=>$instagramProgram,
                        // 'youtube'=>$youtubeProgram
                    )
                );
            }


            $data[]=array(
                'unit_name'=>$unit->unit_name,
                'type_account'=>'corporate',
                'official'=>array(
                    'twitter'=>$twitterOfficial,
                    'facebook'=>$facebookOfficial,
                    'instagram'=>$instagramOfficial,
                    // 'youtube'=>$youtubeOfficial
                ),
                'program'=>$program
            );
        }

        // return $data;

        return view('sosmed.emails.otomatisasi')
            ->with('data',$data);

        return $user;
    }

    public function get_follower_sekarang($id){
        $sekarang=date('Y-m-d');

        $follower=\App\Models\Sosmed\Unitsosmedfollower::where('unit_sosmed_id',$id)
            ->where('tanggal',$sekarang)
            ->first();

        if($follower!=null){
            return $follower->follower;
        }else{
            return 0;
        }
    }

    public function get_last_day_follower($id){
        $harini=$this->hari_ini();
        $sekarang=date('Y-m-d');

        /**
         * jika hari ini adalah senein, maka last day nya di jadiin hari sabtu
         * atau kurang 2 hari dari sekarang,
         * jika bukan maka kurangi 1 hari
         */
        if($harini=="Senin"){
            $kemarin = date('Y-m-d', strtotime('-2 day', strtotime($sekarang)));
        }else{
            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($sekarang)));
        }

        $follower=\App\Models\Sosmed\Unitsosmedfollower::where('unit_sosmed_id',$id)
            ->where('tanggal',$kemarin)
            ->first();

        if($follower!=null){
            return $follower->follower;
        }else{
            return 0;
        }
    }

    public function twitter_follower($id){
        $html=file_get_contents("https://twitter.com/".$id);
        preg_match("'followers_count&quot;:(.*?),&quot;'", $html, $match);
        return $title = $match[1];
    }

    public function facebook_follower($id){

    }

    public function instagram_follower($id){
        $raw = file_get_contents('https://www.instagram.com/'.$id); //replace with user
        preg_match('/\"edge_followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/',$raw,$m);
        return intval($m[1]);
    }

    public function youtube_follower($id){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://rctimobile.com/engine/ytsubs.php?id='.$id);
    
        return $res->getBody();
    }

    function hari_ini(){
        $hari = date ("D");
     
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;
     
            case 'Mon':			
                $hari_ini = "Senin";
            break;
     
            case 'Tue':
                $hari_ini = "Selasa";
            break;
     
            case 'Wed':
                $hari_ini = "Rabu";
            break;
     
            case 'Thu':
                $hari_ini = "Kamis";
            break;
     
            case 'Fri':
                $hari_ini = "Jumat";
            break;
     
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";		
            break;
        }
     
        return $hari_ini;
     
    }

    public function cek_tanggal_libur(){
        $tahun=date('Y');
        $bulan=12;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://apiliburan.now.sh/holidays?year='.$tahun.'&month='.$bulan);
    }
}