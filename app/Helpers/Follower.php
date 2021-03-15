<?php 
namespace App\Helpers;
use Illuminate\Support\Str;

class Follower
{
    public static function twitter($id){
        // $html=@file_get_contents("https://twitter.com/".$id,true);
        // preg_match("'followers_count&quot;:(.*?),&quot;'", $html, $match);

        // if(isset($match[1])){
        //     $hasil=$match[1];
        // }else{
        //     $hasil=0;
        // }

        // return $hasil;

        try
        {
            $a=\Twitter::getUsers(['screen_name' => $id,'format'=>'array']);

            return $a['followers_count'];
        }
        catch (Exception $e)
        {
            if(\Twitter::error()['code'] == 50){
                return 0;
            }
        }
    }

    public static function facebook($id){
        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",    // Atur type request, get atau post
            CURLOPT_POST           =>false,    // Atur menjadi GET
            CURLOPT_FOLLOWLOCATION => true,    // Follow redirect aktif
            CURLOPT_CONNECTTIMEOUT => 120,     // Atur koneksi timeout
            CURLOPT_TIMEOUT        => 120,     // Atur response timeout
            CURLOPT_USERAGENT                       =>'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1',
            CURLOPT_RETURNTRANSFER =>1,
    
        );
    
        $ch      = curl_init('https://www.facebook.com/'.$id);          // Inisialisasi Curl'BigMoviesGTVID'
        curl_setopt_array( $ch, $options );    // Set Opsi
        $page = curl_exec( $ch );           // Eksekusi Curl

        preg_match("'alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) orang mengikuti ini</div></div>'", $page, $match);
        preg_match("'alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) people follow this</div></div>'", $page, $match2);
        
        if(isset($match[1])){
            $hasil=preg_replace('/[^0-9]/', '', substr(strip_tags(Str::replaceFirst('.', '', $match[1])),15));
        }elseif(isset($match2[1])){
            $hasi=preg_replace('/[^0-9]/', '', substr(strip_tags(Str::replaceFirst('.', '', $match2[1])),15));
        }else{
            $hasil=0;
        }

        return $hasil;
        
        // preg_match("'<img class=\"_3-91 _1579 img\" src=\"https://static.xx.fbcdn.net/rsrc.php/v3/y5/r/dsGlZIZMa30.png\" alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) orang mengikuti ini</div></div>'", $page, $match);
        // preg_match("'<img class=\"_3-91 _1579 img\" src=\"https://static.xx.fbcdn.net/rsrc.php/v3/y5/r/dsGlZIZMa30.png\" alt=\"Highlights info row image\" /></div><div class=\"_4bl9\"><div>(.*?) people follow this</div></div>'", $page, $match2);
        
        // // return 100;

        // //print_r($match);
        // if(isset($match[1])){
        //     $hasil=$match[1];
        //     // print_r(Str::replaceFirst('.', '', $match[1]));
        // }elseif(isset($match2[1])){
        //     $hasil=$match2[1];
        //     // print_r(Str::replaceFirst('.', '', $match2[1]));
        // }else{
        //     $hasil=0;
        // }
    
        // return Str::replaceFirst('.', '', $hasil);
    }

    public static function instagram($id){
        $raw = @file_get_contents('https://www.instagram.com/'.$id,true); //replace with user
        preg_match('/\"edge_followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/',$raw,$m);

        if(isset($m[1])){
            $hasil=intval($m[1]);
        }else{
            $hasil=0;
        }

        return $hasil;
    }

    public static function youtube($id){
        \Youtube::setApiKey('AIzaSyDNI2FrJGI_nxgGGYwxqNmmlpJB54Xesm8');
        $channel = \Youtube::getChannelByID($id);
        $activities = \Youtube::getActivitiesByChannelId($id);   

        $youtube=$channel;
        $youtube_activity = $activities;

        if(isset($youtube->statistics)){
            return array(
                'subscriber'=>$youtube->statistics->subscriberCount,
                'view_count'=>$youtube->statistics->viewCount,
                'video_count'=>$youtube->statistics->videoCount,
                'youtube_json'=>$youtube,
                'youtube_activity'=>$youtube_activity
            );
        }else{
            return array(
                'subscriber'=>0,
                'view_count'=>0,
                'video_count'=>0,
                'youtube_json'=>'',
                'youtube_activity'=>''
            );
        }
    }

    /** sudah tidak digunakan */
    public static function cek_instagram($id){
        $url = "https://instagram.com/".$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        $output;
        $metaPos = strpos($result, "<meta content=");
        $metaPosFollower = strpos($result, "edge_followed_by");
        
        if($metaPos != false)
        {
            $meta = substr($result ,$metaPos,70);
            //meghdare followers
            $followerPos = strpos($meta , "Followers");
            $followers = substr($meta , 15 , $followerPos-15);
            $output['pengikut'] = $followers;
            //meghdare followings
            // $commaPos = strpos($meta , ',');
            $followingPos = strpos($meta, 'Following');
            $followings = substr($meta , $followerPos+10 , $followingPos - ($followerPos+10));
            $output['mengikuti'] = $followings; //mengikuti
            //meghdare posts
            $seccondCommaPos = $followingPos + 10;
            $postsPos = strpos($meta, 'Post');
            $posts = substr($meta, $seccondCommaPos , $postsPos - $seccondCommaPos);
            $output['jumlah_post'] = $posts; //jumlah post
            
            //image finder
            $imgPos = strpos($result, "og:image");
            $image = substr($result , $imgPos+19 , 200);
            $endimgPos = strpos($image, "/>");
            $finalImagePos = substr($result, $imgPos+19 , $endimgPos-2);
            // $output[4] = $finalImagePos;

            //allnumber follower
            $metafollower = substr($result ,$metaPosFollower,70);
            $followerPos = preg_match_all('!\d+!', $metafollower, $matches);
            if(isset($matches)){
                $output['all_follower']=$matches[0][0]; //semua pengikut
            }else{
                $output['all_follower']=0; //semua pengikut
            }
            
            return $output;
        }
        else
        {
            return array(
                'pengikut'=>0,
                'mengikuti'=> 0,
                'jumlah_post'=> 0,
                'all_follower'=> 0
            );
        }
    }
    /** end sudah tidak digunakan */

    public static function scrap_instagram($nama){
        $instagram = new \InstagramScraper\Instagram();
        // For getting information about account you don't need to auth:
        $account = $instagram->getAccount($nama);

        return array(
            'pengikut'=> $account->getFollowedByCount(),
            'mengikuti'=> $account->getFollowsCount(),
            'jumlah_post'=> $account->getMediaCount(),
            'all_follower'=> $account->getFollowedByCount()
        );
    }

    public static function cek_instagram_account($id){
        $instagram = new \InstagramScraper\Instagram();
        $account = $instagram->getAccount($id);
        
        // Available fields
        return array(
            'account_id'=>$account->getId(),
            'username'=>$account->getUsername(),
            'full_name'=>$account->getFullName(),
            'biography'=>$account->getBiography(),
            'profile_picture_url'=>$account->getProfilePicUrl(),
            'external_link'=>$account->getExternalUrl(),
            'number_of_published_post'=>$account->getMediaCount(),
            'number_of_followers'=>$account->getFollowsCount(),
            'number_of_follows'=>$account->getFollowedByCount(),
            'is_private'=>$account->isPrivate(),
            'is_verified'=>$account->isVerified()
        );

        // echo "Account info:\n";
        // echo "Id: {$account->getId()}\n";
        // echo "Username: {$account->getUsername()}\n";
        // echo "Full name: {$account->getFullName()}\n";
        // echo "Biography: {$account->getBiography()}\n";
        // echo "Profile picture url: {$account->getProfilePicUrl()}\n";
        // echo "External link: {$account->getExternalUrl()}\n";
        // echo "Number of published posts: {$account->getMediaCount()}\n";
        // echo "Number of followers: {$account->getFollowsCount()}\n";
        // echo "Number of follows: {$account->getFollowedByCount()}\n";
        // echo "Is private: {$account->isPrivate()}\n";
        // echo "Is verified: {$account->isVerified()}\n";
    }

    public static function scrap_jam($jam)
    {
        // return date('F');
        // $jam =  "Senin, 15 Februari 2021 - 08:33:00 WIB | Bali";
        $pecahjam = explode("|", $jam);
        $pecahjamlagi = explode("-",$pecahjam[0]);

        $tanggal = $pecahjamlagi[0];
        $pecahtanggal = explode(",", $tanggal);
        $jamlagi = $pecahjamlagi[1];

        return $this->bulan_indo_ke_int($pecahtanggal[1], $jamlagi);
    }

    public static function bulan_indo_ke_int($tanggal, $jam){
        $pecahtanggal = explode(" ",$tanggal);
        $bulan = $pecahtanggal[2];
        $jam = str_replace("WIB","",$jam);
        $pecahjam = explode(" ","".$jam);

        if($bulan == "Januari"){
            $j = "01";
        }elseif($bulan == "Februari"){
            $j = "02";
        }elseif($bulan == "Maret"){
            $j = "03";
        }elseif($bulan == "April"){
            $j = "04";
        }elseif($bulan == "Mei"){
            $j ="05";
        }elseif($bulan == "Juni"){
            $j = "06";
        }elseif($bulan == "Juli"){
            $j = "07";
        }elseif($bulan == "Agustus"){
            $j = "08";
        }elseif($bulan == "September"){
            $j = "09";
        }elseif($bulan == "Oktober"){
            $j = "10";
        }elseif($bulan == "November"){
            $j = "11";
        }elseif($bulan == "Desember"){
            $j = "12";
        }

        return $pecahtanggal[3]."-".$j."-".$pecahtanggal[1]." ".$pecahjam[1];
    }
}