<?php

function periode($date1,$date2){
    if($date1>$date2){
        $per1=$date2;
        $per2=$date1;
    } else {
        $per1=$date1;
        $per2=$date2;
    }

    $dper1= date("d", strtotime($per1));
    $Mper1= date("M", strtotime($per1));
    $Yper1= date("Y", strtotime($per1));
    $dMYper1= date("d M Y", strtotime($per1));
    $dMper1= date("d M", strtotime($per1));
    $dper2= date("d", strtotime($per2));
    $Mper2= date("M", strtotime($per2));
    $Yper2= date("Y", strtotime($per2));
    $dMYper2= date("d M Y", strtotime($per2));
    if ($Yper1!=$Yper2){
        return $dMYper1."-".$dMYper2;
    } else {
        if($Mper1!=$Mper2){
            return $dMper1."-".$dMYper2;
        } else {
            if($dper1!=$dper2){
                return $dper1."-".$dMYper2;
            } else {
                return $dMYper2;
            }
        }
    }
}

function pipeline($number){
    $milyar=1000000000;
    $juta=1000000;
    $num=0;
    
    if($number>$milyar){
        $num=$number/$milyar;

        return number_format($num,2)." M";
    }else{
        $num=$number/$juta;

        return number_format($num,2)." Jt";
    }
}

function instagram_follower($id){
    $raw = file_get_contents('https://www.instagram.com/'.$id); //replace with user
    preg_match('/\"edge_followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/',$raw,$m);
    echo intval($m[1]);
}

function twitter_follower($id){
    $html=file_get_contents("https://twitter.com/".$id);
    preg_match("'followers_count&quot;:(.*?),&quot;'", $html, $match);
    echo $title = $match[1];
}

function youtube_follower($id){
    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', 'http://rctimobile.com/engine/ytsubs.php?id='.$id);

    echo $res->getBody();
}

function youtubeUrl($uri){
    $url = 'https://www.youtube.com/watch?v='.$uri;
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
    $id = $matches[1];
    $width = '230px';
    $height = '150px';
    
    $html='<iframe id="ytplayer" type="text/html" width="'.$width.'" height="'.$height.'"
    src="https://www.youtube.com/embed/'.$id.'?rel=0&showinfo=0&color=white&iv_load_policy=3"
    frameborder="0" allowfullscreen></iframe>';

    echo $html;
}

function facebookFrame($url){
    $html='<iframe src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/'.$url.'&tabs=timeline&width=460&height=600&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" 
        width="460" height="600" style="border:none;overflow:hidden" scrolling="no" 
        frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';

    echo $html;
}