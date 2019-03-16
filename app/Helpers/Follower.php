<?php 
namespace App\Helpers;

class Follower
{
    public static function twitter($id){
        $html=@file_get_contents("https://twitter.com/".$id,true);
        preg_match("'followers_count&quot;:(.*?),&quot;'", $html, $match);

        if(isset($match[1])){
            $hasil=$match[1];
        }else{
            $hasil=0;
        }

        return $hasil;
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
            $hasil=preg_replace('/[^0-9]/', '', substr(strip_tags(str_replace('.', '', $match[1])),15));
        }elseif(isset($match2[1])){
            $hasi=preg_replace('/[^0-9]/', '', substr(strip_tags(str_replace('.', '', $match2[1])),15));
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
        //     // print_r(str_replace('.', '', $match[1]));
        // }elseif(isset($match2[1])){
        //     $hasil=$match2[1];
        //     // print_r(str_replace('.', '', $match2[1]));
        // }else{
        //     $hasil=0;
        // }
    
        // return str_replace('.', '', $hasil);
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
        $channel = \Youtube::getChannelByID($id);

        $youtube=$channel;

        if(isset($youtube->statistics)){
            return array(
                'subscriber'=>$youtube->statistics->subscriberCount,
                'view_count'=>$youtube->statistics->viewCount,
                'video_count'=>$youtube->statistics->videoCount
            );
        }else{
            return array(
                'subscriber'=>0,
                'view_count'=>0,
                'video_count'=>0
            );
        }
    }
}