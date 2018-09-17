<?php
    $arrTw2=array();
    $arrFb2=array();
    $arrIg2=array();
    foreach($rankOfOfficialAccountAllTvByFollowers as $k){
        if($k->id==4){
            foreach($tambahanInews as $in){
                if($in->id=="TOTAL"){
                    array_push($arrTw2,$in->tw_sekarang);
                    array_push($arrFb2,$in->fb_sekarang);
                    array_push($arrIg2,$in->ig_sekarang);        
                }
            }
        }else{
            array_push($arrTw2,$k->tw_sekarang);
            array_push($arrFb2,$k->fb_sekarang);
            array_push($arrIg2,$k->ig_sekarang);
        }
    }
    $rankTw2=$arrTw2;
    $rankFb2=$arrFb2;
    $rankIg2=$arrIg2;

    rsort($rankTw2);
    rsort($rankFb2);
    rsort($rankIg2);

    $rankTw2=array_flip($rankTw2);
    $rankFb2=array_flip($rankFb2);
    $rankIg2=array_flip($rankIg2);
    ?>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="17%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a958a5;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>TOTAL</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>TOTAL</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a958a5;color:white'>% Growth</th>
                <th class='text-center' style='background:#a958a5;color:white'>TOTAL</th>
                <th class='text-center' style='background:#a958a5;color:white'>RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllTvByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                ?>

                @if($row->id==4)
                    @foreach($tambahanInews as $in)
                        @if($in->id=="TOTAL")
                            @if(($rankTw2[$in->tw_sekarang] + 1)==1 || ($rankTw2[$in->tw_sekarang] + 1)==2 || ($rankTw2[$in->tw_sekarang] + 1)==3)
                                <?php $colorTw="#f4a018";?>
                            @endif

                            @if(($rankFb2[$in->fb_sekarang] + 1)==1 || ($rankFb2[$in->fb_sekarang] + 1)==2 || ($rankFb2[$in->fb_sekarang] + 1)==3)
                                <?php $colorFb="#f4a018";?>
                            @endif

                            @if(($rankIg2[$in->ig_sekarang] + 1)==1 || ($rankIg2[$in->ig_sekarang] + 1)==2 || ($rankIg2[$in->ig_sekarang] + 1)==3)
                                <?php $colorIg="#f4a018";?>
                            @endif
                        @endif
                    @endforeach
                @else 
                    @if(($rankTw2[$row->tw_sekarang] + 1)==1 || ($rankTw2[$row->tw_sekarang] + 1)==2 || ($rankTw2[$row->tw_sekarang] + 1)==3)
                        <?php $colorTw="#f4a018";?>
                    @endif

                    @if(($rankFb2[$row->fb_sekarang] + 1)==1 || ($rankFb2[$row->fb_sekarang] + 1)==2 || ($rankFb2[$row->fb_sekarang] + 1)==3)
                        <?php $colorFb="#f4a018";?>
                    @endif

                    @if(($rankIg2[$row->ig_sekarang] + 1)==1 || ($rankIg2[$row->ig_sekarang] + 1)==2 || ($rankIg2[$row->ig_sekarang] + 1)==3)
                        <?php $colorIg="#f4a018";?>
                    @endif
                @endif

                @if($row->id==4)
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <tr>
                                <th>{{$row->unit_name}}</th>
                                <th>{{round($ins->growth_tw,2)}} %</th>
                                <th>{{number_format($ins->tw_sekarang)}}</th>
                                <th style="background:{{$colorTw}}">{{($rankTw2[$ins->tw_sekarang] + 1)}}</th>
                                <th>{{round($ins->growth_fb,2)}} %</th>
                                <th>{{number_format($ins->fb_sekarang)}}</th>
                                <th style="background:{{$colorFb}}">{{($rankFb2[$ins->fb_sekarang] + 1)}}</th>
                                <th>{{round($ins->growth_ig,2)}} %</th>
                                <th>{{number_format($ins->ig_sekarang)}}</th>
                                <th style="background:{{$colorIg}}">{{($rankIg2[$ins->ig_sekarang] + 1)}}</th>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->unit_name}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th>{{number_format($row->tw_sekarang)}}</th>
                        <th style="background:{{$colorTw}}">{{($rankTw2[$row->tw_sekarang] + 1)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th>{{number_format($row->fb_sekarang)}}</th>
                        <th style="background:{{$colorFb}}">{{($rankFb2[$row->fb_sekarang] + 1)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th>{{number_format($row->ig_sekarang)}}</th>
                        <th style="background:{{$colorIg}}">{{($rankIg2[$row->ig_sekarang] + 1)}}</th>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>