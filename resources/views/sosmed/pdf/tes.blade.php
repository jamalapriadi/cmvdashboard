<h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br><br><br>
    <?php 
        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
            if($k->id==5){
                foreach($groupOthers as $pk){
                    array_push($arrTw,$pk->tw_sekarang);
                    array_push($arrFb,$pk->fb_sekarang);
                    array_push($arrIg,$pk->ig_sekarang);
                }
            }elseif($k->id==1){
                foreach($tambahanInews as $in){
                    if($in->id=="TOTAL"){
                        array_push($arrTw,($k->tw_sekarang+$in->tw_sekarang));
                        array_push($arrFb,($k->fb_sekarang+$in->fb_sekarang));
                        array_push($arrIg,($k->ig_sekarang+$in->ig_sekarang));    
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
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Istagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>TOTAL</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>TOTAL</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>TOTAL</th>
                <th class='text-center' style='background:#a200b2;color:white'>RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllGroupByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                ?>

                @if($row->id==5)
                    @foreach($groupOthers as $pp)
                        @if(($rankTw[$pp->tw_sekarang] + 1)==1 || ($rankTw[$pp->tw_sekarang] + 1)==2 || ($rankTw[$pp->tw_sekarang] + 1)==3)
                            <?php $colorTw="#f4a018"; ?>
                        @endif

                        @if(($rankFb[$pp->fb_sekarang] + 1)==1 || ($rankFb[$pp->fb_sekarang] + 1)==2 || ($rankFb[$pp->fb_sekarang] + 1)==3)
                            <?php $colorFb="#f4a018"; ?>
                        @endif

                        @if(($rankIg[$pp->ig_sekarang] + 1)==1 || ($rankIg[$pp->ig_sekarang] + 1)==2 || ($rankIg[$pp->ig_sekarang] + 1)==3)
                            <?php $colorIg="#f4a018"; ?>
                        @endif
                    @endforeach
                @elseif($row->id==1)
                    <?php 
                        $ttw=0;
                        $growth_tw=0;
                        $tfb=0;
                        $growth_fb=0;
                        $tig=0;
                        $growth_ig=0;
                    ?>
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <?php
                                $ttw=$ins->tw_sekarang+$row->tw_sekarang;
                                $tfb=$ins->fb_sekarang+$row->fb_sekarang;
                                $tig=$ins->ig_sekarang+$row->ig_sekarang;
                            ?>
                            @if(($rankTw[$ttw] + 1)==1 || ($rankTw[$ttw] + 1)==2 || ($rankTw[$ttw] + 1)==3)
                                <?php 
                                    $colorTw="#f4a018"; 
                                    $ttw=$row->tw_sekarang+$ins->tw_sekarang;
                                    $growth_tw=$row->growth_tw+$ins->growth_tw;
                                ?>
                            @endif

                            @if(($rankFb[$tfb] + 1)==1 || ($rankFb[$tfb] + 1)==2 || ($rankFb[$tfb] + 1)==3)
                                <?php 
                                    $colorFb="#f4a018"; 
                                    $tfb=$row->fb_sekarang+$ins->fb_sekarang;
                                    $growth_fb=$row->growth_fb+$ins->growth_fb;
                                ?>
                            @endif

                            @if(($rankIg[$tig] + 1)==1 || ($rankIg[$tig] + 1)==2 || ($rankIg[$tig] + 1)==3)
                                <?php 
                                    $colorIg="#f4a018"; 
                                    $tig=$row->ig_sekarang+$ins->ig_sekarang;
                                    $growth_ig=$row->growth_ig+$ins->growth_ig;
                                ?>
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(($rankTw[$row->tw_sekarang] + 1)==1 || ($rankTw[$row->tw_sekarang] + 1)==2 || ($rankTw[$row->tw_sekarang] + 1)==3)
                        <?php $colorTw="#f4a018"; ?>
                    @endif

                    @if(($rankFb[$row->fb_sekarang] + 1)==1 || ($rankFb[$row->fb_sekarang] + 1)==2 || ($rankFb[$row->fb_sekarang] + 1)==3)
                        <?php $colorFb="#f4a018"; ?>
                    @endif

                    @if(($rankIg[$row->ig_sekarang] + 1)==1 || ($rankIg[$row->ig_sekarang] + 1)==2 || ($rankIg[$row->ig_sekarang] + 1)==3)
                        <?php $colorIg="#f4a018"; ?>
                    @endif
                @endif

                @if($row->id==5)
                    @foreach($groupOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                        ?>
                        @if(($rankTw[$p->tw_sekarang] + 1)==1 || ($rankTw[$p->tw_sekarang] + 1)==2 || ($rankTw[$p->tw_sekarang] + 1)==3)
                            <?php $ctw="#f4a018";?>
                        @endif 

                        @if(($rankFb[$p->fb_sekarang] + 1)==1 || ($rankFb[$p->fb_sekarang] + 1)==2 || ($rankFb[$p->fb_sekarang] + 1)==3)
                            <?php $cfb="#f4a018";?>
                        @endif 

                        @if(($rankIg[$p->ig_sekarang] + 1)==1 || ($rankIg[$p->ig_sekarang] + 1)==2 || ($rankIg[$p->ig_sekarang] + 1)==3)
                            <?php $cig="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            <th>{{round($p->growth_tw,2)}} %</th>
                            <th>{{number_format($p->tw_sekarang)}}</th>
                            <th style="background:{{$ctw}}">{{($rankTw[$p->tw_sekarang] + 1)}}</th>
                            <th>{{round($p->growth_fb,2)}} %</th>
                            <th>{{number_format($p->fb_sekarang)}}</th>
                            <th style="background:{{$cfb}}">{{($rankFb[$p->fb_sekarang] + 1)}}</th>
                            <th>{{round($p->growth_ig,2)}} %</th>
                            <th>{{number_format($p->ig_sekarang)}}</th>
                            <th style="background:{{$cig}}">{{($rankIg[$p->ig_sekarang] + 1)}}</th>
                        </tr>
                    @endforeach
                @elseif($row->id==1)
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th>{{number_format($ttw)}}</th>
                        <th style="background:{{$colorTw}}">{{($rankTw[$ttw] + 1)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th>{{number_format($tfb)}}</th>
                        <th style="background:{{$colorFb}}">{{($rankFb[$tfb] + 1)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th>{{number_format($tig)}}</th>
                        <th style="background:{{$colorIg}}">{{($rankIg[$tig] + 1)}}</th>
                    </tr>
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th>{{number_format($row->tw_sekarang)}}</th>
                        <th style="background:{{$colorTw}}">{{($rankTw[$row->tw_sekarang] + 1)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th>{{number_format($row->fb_sekarang)}}</th>
                        <th style="background:{{$colorFb}}">{{($rankFb[$row->fb_sekarang] + 1)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th>{{number_format($row->ig_sekarang)}}</th>
                        <th style="background:{{$colorIg}}">{{($rankIg[$row->ig_sekarang] + 1)}}</th>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL TV <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br>

    <?php
    $arrTw2=array();
    $arrFb2=array();
    $arrIg2=array();
    foreach($rankOfOfficialAccountAllTvByFollowers as $k){
        array_push($arrTw2,$k->tw_sekarang);
        array_push($arrFb2,$k->fb_sekarang);
        array_push($arrIg2,$k->ig_sekarang);
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
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Istagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>TOTAL</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>TOTAL</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>TOTAL</th>
                <th class='text-center' style='background:#a200b2;color:white'>RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllTvByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw2[$row->tw_sekarang] + 1)==1 || ($rankTw2[$row->tw_sekarang] + 1)==2 || ($rankTw2[$row->tw_sekarang] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb2[$row->fb_sekarang] + 1)==1 || ($rankFb2[$row->fb_sekarang] + 1)==2 || ($rankFb2[$row->fb_sekarang] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg2[$row->ig_sekarang] + 1)==1 || ($rankIg2[$row->ig_sekarang] + 1)==2 || ($rankIg2[$row->ig_sekarang] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
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
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>