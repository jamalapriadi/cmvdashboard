<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RANK FOR SOCIAL MEDIA ALL TV</title>

    <style>
        .page-break {
            page-break-after: always;
        }
        table, td, th {    
            border: 1px solid #ddd;
            text-align: left;
            font-size:12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 7px;
        }

        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>
    <div style="margin-top:40%;"></div>
    <h1 class="text-center">RANK FOR SOCIAL MEDIA ALL TV</h1>
    <p class="text-center">( {{date('Y-m-d',strtotime($sekarang))}} vs {{date('Y-m-d',strtotime($kemarin))}} )</p>

    <div class="page-break"></div>

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
                <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
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
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
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

    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY % GROWTH YESTERDAY</span></h3>
    <br><br><br>

    <?php 
        $arrTw3=array();
        $arrFb3=array();
        $arrIg3=array();
        foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
            if($k->id==5){
                foreach($groupOthers as $pk){
                    array_push($arrTw3,(string)$pk->growth_tw);
                    array_push($arrFb3,(string)$pk->growth_fb);
                    array_push($arrIg3,(string)$pk->growth_ig);
                }
            }elseif($k->id==1){
                foreach($tambahanInews as $in){
                    if($in->id=="TOTAL"){
                        $twsekarang1=$k->tw_sekarang+$in->tw_sekarang;
                        $twkemarin1=$k->tw_kemarin+$in->tw_kemarin;
                        $growthtw1=($twsekarang1/$twkemarin1-1)*100;

                        $fbsekarang1=$k->fb_sekarang+$in->fb_sekarang;
                        $fbkemarin1=$k->fb_kemarin+$in->fb_kemarin;
                        $growthfb1=($fbsekarang1/$fbkemarin1-1)*100;

                        $igsekarang1=$k->ig_sekarang+$in->ig_sekarang;
                        $igkemarin1=$k->ig_kemarin+$in->ig_kemarin;
                        $growthig1=($igsekarang1/$igkemarin1-1)*100;

                        array_push($arrTw3,(string)$growthtw1);
                        array_push($arrFb3,(string)$growthfb1);
                        array_push($arrIg3,(string)$growthig1);    
                    }
                }
            }else{
                array_push($arrTw3,(string)$k->growth_tw);
                array_push($arrFb3,(string)$k->growth_fb);
                array_push($arrIg3,(string)$k->growth_ig);
            }
        }
        $rankTw3=$arrTw3;
        $rankFb3=$arrFb3;
        $rankIg3=$arrIg3;

        rsort($rankTw3);
        rsort($rankFb3);
        rsort($rankIg3);

        $rankTw3=array_flip($rankTw3);
        $rankFb3=array_flip($rankFb3);
        $rankIg3=array_flip($rankIg3);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
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
                        @if(($rankTw3[$pp->growth_tw] + 1)==1 || ($rankTw3[$pp->growth_tw] + 1)==2 || ($rankTw3[$pp->growth_tw] + 1)==3)
                            <?php $colorTw="#f4a018"; ?>
                        @endif

                        @if(($rankFb3[$pp->growth_fb] + 1)==1 || ($rankFb3[$pp->growth_fb] + 1)==2 || ($rankFb3[$pp->growth_fb] + 1)==3)
                            <?php $colorFb="#f4a018"; ?>
                        @endif

                        @if(($rankIg3[$pp->growth_ig] + 1)==1 || ($rankIg3[$pp->growth_ig] + 1)==2 || ($rankIg3[$pp->growth_ig] + 1)==3)
                            <?php $colorIg="#f4a018"; ?>
                        @endif
                    @endforeach
                @elseif($row->id==1)
                    <?php 
                        $ttw3=0;
                        $growth_tw3=0;
                        $tfb3=0;
                        $growth_fb3=0;
                        $tig3=0;
                        $growth_ig3=0;
                    ?>
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <?php
                                $twsekarang2=$row->tw_sekarang+$ins->tw_sekarang;
                                $twkemarin2=$row->tw_kemarin+$ins->tw_kemarin;
                                $num_of_growth_tw2=$twsekarang2-$twkemarin2;
                                $growthtw2=($twsekarang2/$twkemarin2-1)*100;

                                $fbsekarang2=$row->fb_sekarang+$ins->fb_sekarang;
                                $fbkemarin2=$row->fb_kemarin+$ins->fb_kemarin;
                                $num_of_growth_fb2=$fbsekarang2-$fbkemarin2;
                                $growthfb2=($fbsekarang2/$fbkemarin2-1)*100;

                                $igsekarang2=$row->ig_sekarang+$ins->ig_sekarang;
                                $igkemarin2=$row->ig_kemarin+$ins->ig_kemarin;
                                $num_of_growth_ig2=$igsekarang2-$igkemarin2;
                                $growthig2=($igsekarang2/$igkemarin2-1)*100;

                                $ttw3=(string)$growthtw2;
                                $tfb3=(string)$growthfb2;
                                $tig3=(string)$growthig2;
                            ?>
                            @if(($rankTw3[$ttw3] + 1)==1 || ($rankTw3[$ttw3] + 1)==2 || ($rankTw3[$ttw3] + 1)==3)
                                <?php 
                                    $colorTw="#f4a018"; 
                                    $ttw3=(string)$growthtw2;
                                    $growth_tw3=$num_of_growth_tw2;
                                ?>
                            @endif

                            @if(($rankFb3[$tfb3] + 1)==1 || ($rankFb3[$tfb3] + 1)==2 || ($rankFb3[$tfb3] + 1)==3)
                                <?php 
                                    $colorFb="#f4a018"; 
                                    $tfb3=(string)$growthfb2;
                                    $growth_fb3=$num_of_growth_fb2
                                ?>
                            @endif

                            @if(($rankIg3[$tig3] + 1)==1 || ($rankIg3[$tig3] + 1)==2 || ($rankIg3[$tig3] + 1)==3)
                                <?php 
                                    $colorIg="#f4a018"; 
                                    $tig3=(string)$growthig2;
                                    $growth_ig3=$num_of_growth_ig2
                                ?>
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(($rankTw3[$row->growth_tw] + 1)==1 || ($rankTw3[$row->growth_tw] + 1)==2 || ($rankTw3[$row->growth_tw] + 1)==3)
                        <?php $colorTw="#f4a018"; ?>
                    @endif

                    @if(($rankFb3[$row->growth_fb] + 1)==1 || ($rankFb3[$row->growth_fb] + 1)==2 || ($rankFb3[$row->growth_fb] + 1)==3)
                        <?php $colorFb="#f4a018"; ?>
                    @endif

                    @if(($rankIg3[$row->growth_ig] + 1)==1 || ($rankIg3[$row->growth_ig] + 1)==2 || ($rankIg3[$row->growth_ig] + 1)==3)
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
                        @if(($rankTw3[$p->growth_tw] + 1)==1 || ($rankTw3[$p->growth_tw] + 1)==2 || ($rankTw3[$p->growth_tw] + 1)==3)
                            <?php $ctw="#f4a018";?>
                        @endif 

                        @if(($rankFb3[$p->growth_fb] + 1)==1 || ($rankFb3[$p->growth_fb] + 1)==2 || ($rankFb3[$p->growth_fb] + 1)==3)
                            <?php $cfb="#f4a018";?>
                        @endif 

                        @if(($rankIg3[$p->growth_ig] + 1)==1 || ($rankIg3[$p->growth_ig] + 1)==2 || ($rankIg3[$p->growth_ig] + 1)==3)
                            <?php $cig="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            <th>{{number_format($p->num_of_growth_tw)}}</th>
                            <th>{{round($p->growth_tw,2)}} %</th>
                            <th style="background:{{$ctw}}">{{($rankTw3[$p->growth_tw] + 1)}}</th>
                            <th>{{number_format($p->num_of_growth_fb)}}</th>
                            <th>{{round($p->growth_fb,2)}} %</th>
                            <th style="background:{{$cfb}}">{{($rankFb3[$p->growth_fb] + 1)}}</th>
                            <th>{{number_format($p->num_of_growth_ig)}}</th>
                            <th>{{round($p->growth_ig,2)}} %</th>
                            <th style="background:{{$cig}}">{{($rankIg3[$p->growth_ig] + 1)}}</th>
                        </tr>
                    @endforeach
                @elseif($row->id==1)
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{number_format($row->num_of_growth_tw)}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th style="background:{{$colorTw}}">{{($rankTw3[$ttw3] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_fb)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th style="background:{{$colorFb}}">{{($rankFb3[$tfb3] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_ig)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th style="background:{{$colorIg}}">{{($rankIg3[$tig3]+1)}}</th>
                    </tr>
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{number_format($row->num_of_growth_tw)}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th style="background:{{$colorTw}}">{{($rankTw3[$row->growth_tw] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_fb)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th style="background:{{$colorFb}}">{{($rankFb3[$row->growth_fb] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_ig)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th style="background:{{$colorIg}}">{{($rankIg3[$row->growth_ig] + 1)}}</th>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL TV <span style="color:red">BY % GROWTH YESTERDAY</span></h3>
    <br>

    <?php
    $arrTw4=array();
    $arrFb4=array();
    $arrIg4=array();
    foreach($rankOfOfficialAccountAllTvByFollowers as $k){
        if($k->id==4){
            foreach($tambahanInews as $in){
                if($in->id=="TOTAL"){
                    array_push($arrTw4,(string)($in->growth_tw));
                    array_push($arrFb4,(string)($in->growth_fb));
                    array_push($arrIg4,(string)($in->growth_ig));    
                }
            }
        }else{
            array_push($arrTw4,(string)$k->growth_tw);
            array_push($arrFb4,(string)$k->growth_fb);
            array_push($arrIg4,(string)$k->growth_ig);
        }
    }
    $rankTw4=$arrTw4;
    $rankFb4=$arrFb4;
    $rankIg4=$arrIg4;

    rsort($rankTw4);
    rsort($rankFb4);
    rsort($rankIg4);

    $rankTw4=array_flip($rankTw4);
    $rankFb4=array_flip($rankFb4);
    $rankIg4=array_flip($rankIg4);
    ?>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="17%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>RANK</th>
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
                            @if(($rankTw4[$in->growth_tw] + 1)==1 || ($rankTw4[$in->growth_tw] + 1)==2 || ($rankTw4[$in->growth_tw] + 1)==3)
                                <?php $colorTw="#f4a018";?>
                            @endif

                            @if(($rankFb4[$in->growth_fb] + 1)==1 || ($rankFb4[$in->growth_fb] + 1)==2 || ($rankFb4[$in->growth_fb] + 1)==3)
                                <?php $colorFb="#f4a018";?>
                            @endif

                            @if(($rankIg4[$in->growth_ig] + 1)==1 || ($rankIg4[$in->growth_ig] + 1)==2 || ($rankIg4[$in->growth_ig] + 1)==3)
                                <?php $colorIg="#f4a018";?>
                            @endif
                        @endif
                    @endforeach
                @else 
                    @if(($rankTw4[(string)$row->growth_tw] + 1)==1 || ($rankTw4[(string)$row->growth_tw] + 1)==2 || ($rankTw4[(string)$row->growth_tw] + 1)==3)
                        <?php $colorTw="#f4a018"; ?>
                    @endif 

                    @if(($rankFb4[(string)$row->growth_fb] + 1)==1 || ($rankFb4[(string)$row->growth_fb] + 1)==2 || ($rankFb4[(string)$row->growth_fb] + 1)==3)
                        <?php $colorFb="#f4a018";?>
                    @endif

                    @if(($rankIg4[(string)$row->growth_ig] + 1)==1 || ($rankIg4[(string)$row->growth_ig] + 1)==2 || ($rankIg4[(string)$row->growth_ig] + 1)==3)
                        <?php $colorIg="#f4a018";?>
                    @endif
                @endif


                <!-- tampil -->
                @if($row->id==4)
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <tr>
                                <th>{{$row->unit_name}}</th>
                                <th>{{number_format($ins->num_of_growth_tw)}}</th>
                                <th>{{round($ins->growth_tw,2)}} %</th>
                                <th style="background:{{$colorTw}}">{{($rankTw4[(string)$ins->growth_tw] + 1)}}</th>
                                <th>{{number_format($ins->num_of_growth_fb)}}</th>
                                <th>{{round($ins->growth_fb,2)}} %</th>
                                <th style="background:{{$colorFb}}">{{($rankFb4[(string)$ins->growth_fb] + 1)}}</th>
                                <th>{{number_format($ins->num_of_growth_ig)}}</th>
                                <th>{{round($ins->growth_ig,2)}} %</th>
                                <th style="background:{{$colorIg}}">{{($rankIg4[(string)$ins->growth_ig] + 1)}}</th>
                            </tr>
                        @endif
                    @endforeach
                @else 
                    <tr>
                        <th>{{$row->unit_name}}</th>
                        <th>{{number_format($row->num_of_growth_tw)}}</th>
                        <th>{{round($row->growth_tw,2)}} %</th>
                        <th style="background:{{$colorTw}}">{{($rankTw4[(string)$row->growth_tw] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_fb)}}</th>
                        <th>{{round($row->growth_fb,2)}} %</th>
                        <th style="background:{{$colorFb}}">{{($rankFb4[(string)$row->growth_fb] + 1)}}</th>
                        <th>{{number_format($row->num_of_growth_ig)}}</th>
                        <th>{{round($row->growth_ig,2)}} %</th>
                        <th style="background:{{$colorIg}}">{{($rankIg4[(string)$row->growth_ig] + 1)}}</th>
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br><br><br>
    <?php 
        $arrTw5=array();
        $arrFb5=array();
        $arrIg5=array();
        foreach($rankOverallAccountGroup as $k){
            if($k->group_unit_id==5){
                foreach($tambahanOverAllTvOthers as $pk){
                    array_push($arrTw5,$pk->total_tw_sekarang);
                    array_push($arrFb5,$pk->total_fb_sekarang);
                    array_push($arrIg5,$pk->total_ig_sekarang);
                }
            }else{
                array_push($arrTw5,$k->total_tw_sekarang);
                array_push($arrFb5,$k->total_fb_sekarang);
                array_push($arrIg5,$k->total_ig_sekarang);
            }
        }
        $rankTw5=$arrTw5;
        $rankFb5=$arrFb5;
        $rankIg5=$arrIg5;

        rsort($rankTw5);
        rsort($rankFb5);
        rsort($rankIg5);

        $rankTw5=array_flip($rankTw5);
        $rankFb5=array_flip($rankFb5);
        $rankIg5=array_flip($rankIg5);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
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
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                ?>

                @if($row->group_unit_id==5)
                    @foreach($tambahanOverAllTvOthers as $pp)
                        @if(($rankTw5[$pp->total_tw_sekarang] + 1)==1 || ($rankTw5[$pp->total_tw_sekarang] + 1)==2 || ($rankTw5[$pp->total_tw_sekarang] + 1)==3)
                            <?php $colorTw="#f4a018"; ?>
                        @endif

                        @if(($rankFb5[$pp->total_fb_sekarang] + 1)==1 || ($rankFb5[$pp->total_fb_sekarang] + 1)==2 || ($rankFb5[$pp->total_fb_sekarang] + 1)==3)
                            <?php $colorFb="#f4a018"; ?>
                        @endif

                        @if(($rankIg5[$pp->total_ig_sekarang] + 1)==1 || ($rankIg5[$pp->total_ig_sekarang] + 1)==2 || ($rankIg5[$pp->total_ig_sekarang] + 1)==3)
                            <?php $colorIg="#f4a018"; ?>
                        @endif
                    @endforeach
                @else
                    @if(($rankTw5[$row->total_tw_sekarang] + 1)==1 || ($rankTw5[$row->total_tw_sekarang] + 1)==2 || ($rankTw5[$row->total_tw_sekarang] + 1)==3)
                        <?php $colorTw="#f4a018";?>
                    @endif

                    @if(($rankFb5[$row->total_fb_sekarang] + 1)==1 || ($rankFb5[$row->total_fb_sekarang] + 1)==2 || ($rankFb5[$row->total_fb_sekarang] + 1)==3)
                        <?php $colorFb="#f4a018";?>
                    @endif

                    @if(($rankIg5[$row->total_ig_sekarang] + 1)==1 || ($rankIg5[$row->total_ig_sekarang] + 1)==2 || ($rankIg5[$row->total_ig_sekarang] + 1)==3)
                        <?php $colorIg="#f4a018";?>
                    @endif
                @endif 

                <!-- tampil -->
                @if($row->group_unit_id==5)
                    @foreach($tambahanOverAllTvOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                        ?>
                        @if(($rankTw5[$p->total_tw_sekarang] + 1)==1 || ($rankTw5[$p->total_tw_sekarang] + 1)==2 || ($rankTw5[$p->total_tw_sekarang] + 1)==3)
                            <?php $ctw="#f4a018";?>
                        @endif 

                        @if(($rankFb5[$p->total_fb_sekarang] + 1)==1 || ($rankFb5[$p->total_fb_sekarang] + 1)==2 || ($rankFb5[$p->total_fb_sekarang] + 1)==3)
                            <?php $cfb="#f4a018";?>
                        @endif 

                        @if(($rankIg5[$p->total_ig_sekarang] + 1)==1 || ($rankIg5[$p->total_ig_sekarang] + 1)==2 || ($rankIg5[$p->total_ig_sekarang] + 1)==3)
                            <?php $cig="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            <th>{{round($p->total_growth_tw,2)}} %</th>
                            <th>{{number_format($p->total_tw_sekarang)}}</th>
                            <th style="background:{{$ctw}}">{{($rankTw5[$p->total_tw_sekarang] + 1)}}</th>
                            <th>{{round($p->total_growth_fb,2)}} %</th>
                            <th>{{number_format($p->total_fb_sekarang)}}</th>
                            <th style="background:{{$cfb}}">{{($rankFb5[$p->total_fb_sekarang] + 1)}}</th>
                            <th>{{round($p->total_growth_ig,2)}} %</th>
                            <th>{{number_format($p->total_ig_sekarang)}}</th>
                            <th style="background:{{$cig}}">{{($rankIg5[$p->total_ig_sekarang] + 1)}}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{round($row->total_growth_tw,2)}} %</th>
                        <th>{{number_format($row->total_tw_sekarang)}}</th>
                        <th style="background:{{$colorTw}}">{{($rankTw5[$row->total_tw_sekarang] + 1)}}</th>
                        <th>{{round($row->total_growth_fb,2)}} %</th>
                        <th>{{number_format($row->total_fb_sekarang)}}</th>
                        <th style="background:{{$colorFb}}">{{($rankFb5[$row->total_fb_sekarang] + 1)}}</th>
                        <th>{{round($row->total_growth_ig,2)}} %</th>
                        <th>{{number_format($row->total_ig_sekarang)}}</th>
                        <th style="background:{{$colorIg}}">{{($rankIg5[$row->total_ig_sekarang] + 1)}}</th>
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL TV <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br>
    <?php 
        $arrTw6=array();
        $arrFb6=array();
        $arrIg6=array();
        foreach($rankOverallAccountAllTv as $k){
            array_push($arrTw6,$k->total_tw_sekarang);
            array_push($arrFb6,$k->total_fb_sekarang);
            array_push($arrIg6,$k->total_ig_sekarang);
        }
        $rankTw6=$arrTw6;
        $rankFb6=$arrFb6;
        $rankIg6=$arrIg6;

        rsort($rankTw6);
        rsort($rankFb6);
        rsort($rankIg6);

        $rankTw6=array_flip($rankTw6);
        $rankFb6=array_flip($rankFb6);
        $rankIg6=array_flip($rankIg6);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="18%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
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
            @foreach($rankOverallAccountAllTv as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw6[$row->total_tw_sekarang] + 1)==1 || ($rankTw6[$row->total_tw_sekarang] + 1)==2 || ($rankTw6[$row->total_tw_sekarang] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb6[$row->total_fb_sekarang] + 1)==1 || ($rankFb6[$row->total_fb_sekarang] + 1)==2 || ($rankFb6[$row->total_fb_sekarang] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg6[$row->total_ig_sekarang] + 1)==1 || ($rankIg6[$row->total_ig_sekarang] + 1)==2 || ($rankIg6[$row->total_ig_sekarang] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    <th>{{round($row->total_growth_tw,2)}} %</th>
                    <th>{{number_format($row->total_tw_sekarang)}}</th>
                    <th style="background:{{$colorTw}}">{{($rankTw6[$row->total_tw_sekarang] + 1)}}</th>
                    <th>{{round($row->total_growth_fb,2)}} %</th>
                    <th>{{number_format($row->total_fb_sekarang)}}</th>
                    <th style="background:{{$colorFb}}">{{($rankFb6[$row->total_fb_sekarang] + 1)}}</th>
                    <th>{{round($row->total_growth_ig,2)}} %</th>
                    <th>{{number_format($row->total_ig_sekarang)}}</th>
                    <th style="background:{{$colorIg}}">{{($rankIg6[$row->total_ig_sekarang] + 1)}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL GROUP <span style="color:red">BY % GROWTH FROM YESTERDAY</span></h3>
    <br><br><br>
    <?php 
        $arrTw7=array();
        $arrFb7=array();
        $arrIg7=array();
        foreach($rankOverallAccountGroup as $k){
            if($k->group_unit_id==5){
                foreach($tambahanOverAllTvOthers as $pk){
                    array_push($arrTw7,(string)$pk->total_growth_tw);
                    array_push($arrFb7,(string)$pk->total_growth_fb);
                    array_push($arrIg7,(string)$pk->total_growth_ig);
                }
            }else{
                array_push($arrTw7,(string)$k->total_growth_tw);
                array_push($arrFb7,(string)$k->total_growth_fb);
                array_push($arrIg7,(string)$k->total_growth_ig);
            }
        }
        $rankTw7=$arrTw7;
        $rankFb7=$arrFb7;
        $rankIg7=$arrIg7;

        rsort($rankTw7);
        rsort($rankFb7);
        rsort($rankIg7);

        $rankTw7=array_flip($rankTw7);
        $rankFb7=array_flip($rankFb7);
        $rankIg7=array_flip($rankIg7);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>Nom Of Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>Nom Of Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>Nom Of Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                ?>
                @if($row->group_unit_id==5)
                    @foreach($tambahanOverAllTvOthers as $pp)
                        @if(($rankTw7[$pp->total_growth_tw] + 1)==1 || ($rankTw7[$pp->total_growth_tw] + 1)==2 || ($rankTw7[$pp->total_growth_tw] + 1)==3)
                            <?php $colorTw="#f4a018"; ?>
                        @endif

                        @if(($rankFb7[$pp->total_growth_fb] + 1)==1 || ($rankFb7[$pp->total_growth_fb] + 1)==2 || ($rankFb7[$pp->total_growth_fb] + 1)==3)
                            <?php $colorFb="#f4a018"; ?>
                        @endif

                        @if(($rankIg7[$pp->total_growth_ig] + 1)==1 || ($rankIg7[$pp->total_growth_ig] + 1)==2 || ($rankIg7[$pp->total_growth_ig] + 1)==3)
                            <?php $colorIg="#f4a018"; ?>
                        @endif
                    @endforeach
                @else 
                    @if(($rankTw7[$row->total_growth_tw] + 1)==1 || ($rankTw7[$row->total_growth_tw] + 1)==2 || ($rankTw7[$row->total_growth_tw] + 1)==3)
                        <?php $colorTw="#f4a018";?>
                    @endif

                    @if(($rankFb7[$row->total_growth_fb] + 1)==1 || ($rankFb7[$row->total_growth_fb] + 1)==2 || ($rankFb7[$row->total_growth_fb] + 1)==3)
                        <?php $colorFb="#f4a018";?>
                    @endif

                    @if(($rankIg7[$row->total_growth_ig] + 1)==1 || ($rankIg7[$row->total_growth_ig] + 1)==2 || ($rankIg7[$row->total_growth_ig] + 1)==3)
                        <?php $colorIg="#f4a018";?>
                    @endif
                @endif

                <!-- tampil -->
                @if($row->group_unit_id==5)
                    @foreach($tambahanOverAllTvOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                        ?>
                        @if(($rankTw7[$p->total_growth_tw] + 1)==1 || ($rankTw7[$p->total_growth_tw] + 1)==2 || ($rankTw7[$p->total_growth_tw] + 1)==3)
                            <?php $ctw="#f4a018";?>
                        @endif 

                        @if(($rankFb7[$p->total_growth_fb] + 1)==1 || ($rankFb7[$p->total_growth_fb] + 1)==2 || ($rankFb7[$p->total_growth_fb] + 1)==3)
                            <?php $cfb="#f4a018";?>
                        @endif 

                        @if(($rankIg7[$p->total_growth_ig] + 1)==1 || ($rankIg7[$p->total_growth_ig] + 1)==2 || ($rankIg7[$p->total_growth_ig] + 1)==3)
                            <?php $cig="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            <th>{{number_format($p->total_num_of_growth_tw)}}</th>
                            <th>{{round($p->total_growth_tw,2)}} %</th>
                            <th style="background:{{$ctw}}">{{($rankTw7[$p->total_growth_tw] + 1)}}</th>
                            <th>{{number_format($p->total_num_of_growth_fb)}}</th>
                            <th>{{round($p->total_growth_fb,2)}} %</th>
                            <th style="background:{{$cfb}}">{{($rankFb7[$p->total_growth_fb] + 1)}}</th>
                            <th>{{number_format($p->total_num_of_growth_ig)}}</th>
                            <th>{{round($p->total_growth_ig,2)}} %</th>
                            <th style="background:{{$cig}}">{{($rankIg7[$p->total_growth_ig] + 1)}}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        <th>{{number_format($row->total_num_of_growth_tw)}}</th>
                        <th>{{round($row->total_growth_tw,2)}} %</th>
                        <th style="background:{{$colorTw}}">{{($rankTw7[$row->total_growth_tw] + 1)}}</th>
                        <th>{{number_format($row->total_num_of_growth_fb)}}</th>
                        <th>{{round($row->total_growth_fb,2)}} %</th>
                        <th style="background:{{$colorFb}}">{{($rankFb7[$row->total_growth_fb] + 1)}}</th>
                        <th>{{number_format($row->total_num_of_growth_ig)}}</th>
                        <th>{{round($row->total_growth_ig,2)}} %</th>
                        <th style="background:{{$colorIg}}">{{($rankIg7[$row->total_growth_ig] + 1)}}</th>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL TV <span style="color:red">BY % GROWTH FROM YESTERDAY</span></h3>
    <br>
    <?php 
        $arrTw8=array();
        $arrFb8=array();
        $arrIg8=array();
        foreach($rankOverallAccountAllTv as $k){
            array_push($arrTw8,(string)$k->total_growth_tw);
            array_push($arrFb8,(string)$k->total_growth_fb);
            array_push($arrIg8,(string)$k->total_growth_ig);
        }
        $rankTw8=$arrTw8;
        $rankFb8=$arrFb8;
        $rankIg8=$arrIg8;

        rsort($rankTw8);
        rsort($rankFb8);
        rsort($rankIg8);

        $rankTw8=array_flip($rankTw8);
        $rankFb8=array_flip($rankFb8);
        $rankIg8=array_flip($rankIg8);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="18%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>% Growth</th>
                <th class='text-center' style='background:#008ef6;color:white'>RANK</th>
                <th class='text-center' style='background:#5054ab;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>% Growth</th>
                <th class='text-center' style='background:#5054ab;color:white'>RANK</th>
                <th class='text-center' style='background:#a200b2;color:white'>Num Of Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>% Growth</th>
                <th class='text-center' style='background:#a200b2;color:white'>RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountAllTv as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw8[$row->total_growth_tw] + 1)==1 || ($rankTw8[$row->total_growth_tw] + 1)==2 || ($rankTw8[$row->total_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb8[$row->total_growth_fb] + 1)==1 || ($rankFb8[$row->total_growth_fb] + 1)==2 || ($rankFb8[$row->total_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg8[$row->total_growth_ig] + 1)==1 || ($rankIg8[$row->total_growth_ig] + 1)==2 || ($rankIg8[$row->total_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    <th>{{number_format($row->total_num_of_growth_tw)}}</th>
                    <th>{{round($row->total_growth_tw,2)}} %</th>
                    <th style="background:{{$colorTw}}">{{($rankTw8[$row->total_growth_tw] + 1)}}</th>
                    <th>{{number_format($row->total_num_of_growth_fb)}}</th>
                    <th>{{round($row->total_growth_fb,2)}} %</th>
                    <th style="background:{{$colorFb}}">{{($rankFb8[$row->total_growth_fb] + 1)}}</th>
                    <th>{{number_format($row->total_num_of_growth_ig)}}</th>
                    <th>{{round($row->total_growth_ig,2)}} %</th>
                    <th style="background:{{$colorIg}}">{{($rankIg8[$row->total_growth_ig] + 1)}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>