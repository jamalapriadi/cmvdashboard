<h2>Report Highlights as of {{date('H')}} today ({{$sekarang}}) compared to ({{$kemarin}})</h2>
<br>
<strong>1. Official Accounts ALL TV by TOTAL FOLLOWERS</strong>
    <?php 
        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($unitAccount as $k){
            if($k->id==4){
                foreach($tambahanInews as $in){
                    if($in->id=="TOTAL"){
                        array_push($arrTw,$in->tw_sekarang);
                        array_push($arrFb,$in->fb_sekarang);
                        array_push($arrIg,$in->ig_sekarang);        
                    }
                }
            }else{
                array_push($arrTw,$k->tw_sekarang);
                array_push($arrFb,$k->fb_sekarang);
                array_push($arrIg,$k->ig_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
    ?>
    @foreach($unitAccount as $row)
        @if($row->id==4)
            @foreach($tambahanInews as $ins)
                @if($ins->id=="TOTAL")

                @endif
            @endforeach
        @else 

        @endif
    @endforeach