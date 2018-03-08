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
            padding: 10px;
        }

        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>
    <div style="margin-top:40%;"></div>
    <h1 class="text-center">RANK FOR SOCIAL MEDIA ALL TV</h1>
    <p class="text-center">( {{date('d/m/Y')}} )</p>

    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br><br><br>
    <?php 
        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
            array_push($arrTw,$k->tw_sekarang);
            array_push($arrFb,$k->fb_sekarang);
            array_push($arrIg,$k->ig_sekarang);
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
                    
                    if(($rankTw[$row->tw_sekarang] + 1)==1 || ($rankTw[$row->tw_sekarang] + 1)==2 || ($rankTw[$row->tw_sekarang] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb[$row->fb_sekarang] + 1)==1 || ($rankFb[$row->fb_sekarang] + 1)==2 || ($rankFb[$row->fb_sekarang] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg[$row->ig_sekarang] + 1)==1 || ($rankIg[$row->ig_sekarang] + 1)==2 || ($rankIg[$row->ig_sekarang] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->group_name}}</th>
                    <th>{{$row->growth_tw}} %</th>
                    <th>{{$row->tw_sekarang}}</th>
                    <th style="background:{{$colorTw}}">{{($rankTw[$row->tw_sekarang] + 1)}}</th>
                    <th>{{$row->growth_fb}} %</th>
                    <th>{{$row->fb_sekarang}}</th>
                    <th style="background:{{$colorFb}}">{{($rankFb[$row->fb_sekarang] + 1)}}</th>
                    <th>{{$row->growth_ig}} %</th>
                    <th>{{$row->ig_sekarang}}</th>
                    <th style="background:{{$colorIg}}">{{($rankIg[$row->ig_sekarang] + 1)}}</th>
                </tr>
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
                    <th>{{$row->growth_tw}} %</th>
                    <th>{{$row->tw_sekarang}}</th>
                    <th style="background:{{$colorTw}}">{{($rankTw2[$row->tw_sekarang] + 1)}}</th>
                    <th>{{$row->growth_fb}} %</th>
                    <th>{{$row->fb_sekarang}}</th>
                    <th style="background:{{$colorFb}}">{{($rankFb2[$row->fb_sekarang] + 1)}}</th>
                    <th>{{$row->growth_ig}} %</th>
                    <th>{{$row->ig_sekarang}}</th>
                    <th style="background:{{$colorIg}}">{{($rankIg2[$row->ig_sekarang] + 1)}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY % GROWTH YESTERDAY</span></h3>
    <br><br><br>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' class='text-center' style='background:#a200b2;color:white'>Istagram</th>
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
            <?php 
                $arrTw3=array();
                $arrFb3=array();
                $arrIg3=array();
                foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
                    array_push($arrTw3,$k->num_of_growth_tw);
                    array_push($arrFb3,$k->num_of_growth_fb);
                    array_push($arrIg3,$k->num_of_growth_ig);
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

            @foreach($rankOfOfficialAccountAllGroupByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw3[$row->num_of_growth_tw] + 1)==1 || ($rankTw3[$row->num_of_growth_tw] + 1)==2 || ($rankTw3[$row->num_of_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb3[$row->num_of_growth_fb] + 1)==1 || ($rankFb3[$row->num_of_growth_fb] + 1)==2 || ($rankFb3[$row->num_of_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg3[$row->num_of_growth_ig] + 1)==1 || ($rankIg3[$row->num_of_growth_ig] + 1)==2 || ($rankIg3[$row->num_of_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->group_name}}</th>
                    <th>{{$row->num_of_growth_tw}}</th>
                    <th>{{$row->growth_tw}} %</th>
                    <th style="background:{{$colorTw}}">{{($rankTw3[$row->num_of_growth_tw] + 1)}}</th>
                    <th>{{$row->num_of_growth_fb}}</th>
                    <th>{{$row->growth_fb}} %</th>
                    <th style="background:{{$colorFb}}">{{($rankFb3[$row->num_of_growth_fb] + 1)}}</th>
                    <th>{{$row->num_of_growth_ig}}</th>
                    <th>{{$row->growth_ig}} %</th>
                    <th style="background:{{$colorIg}}">{{($rankIg3[$row->num_of_growth_ig] + 1)}}</th>
                </tr>
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
        array_push($arrTw4,$k->num_of_growth_tw);
        array_push($arrFb4,$k->num_of_growth_fb);
        array_push($arrIg4,$k->num_of_growth_ig);
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
                    
                    if(($rankTw4[$row->num_of_growth_tw] + 1)==1 || ($rankTw4[$row->num_of_growth_tw] + 1)==2 || ($rankTw4[$row->num_of_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb4[$row->num_of_growth_fb] + 1)==1 || ($rankFb4[$row->num_of_growth_fb] + 1)==2 || ($rankFb4[$row->num_of_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg4[$row->num_of_growth_ig] + 1)==1 || ($rankIg4[$row->num_of_growth_ig] + 1)==2 || ($rankIg4[$row->num_of_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    <th>{{$row->num_of_growth_tw}}</th>
                    <th>{{$row->growth_tw}} %</th>
                    <th style="background:{{$colorTw}}">{{($rankTw4[$row->num_of_growth_tw] + 1)}}</th>
                    <th>{{$row->num_of_growth_fb}}</th>
                    <th>{{$row->growth_fb}} %</th>
                    <th style="background:{{$colorFb}}">{{($rankFb4[$row->num_of_growth_fb] + 1)}}</th>
                    <th>{{$row->num_of_growth_ig}}</th>
                    <th>{{$row->growth_ig}} %</th>
                    <th style="background:{{$colorIg}}">{{($rankIg4[$row->num_of_growth_ig] + 1)}}</th>
                </tr>
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
            array_push($arrTw5,$k->total_tw_sekarang);
            array_push($arrFb5,$k->total_fb_sekarang);
            array_push($arrIg5,$k->total_ig_sekarang);
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
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw5[$row->total_tw_sekarang] + 1)==1 || ($rankTw5[$row->total_tw_sekarang] + 1)==2 || ($rankTw5[$row->total_tw_sekarang] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb5[$row->total_fb_sekarang] + 1)==1 || ($rankFb5[$row->total_fb_sekarang] + 1)==2 || ($rankFb5[$row->total_fb_sekarang] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg5[$row->total_ig_sekarang] + 1)==1 || ($rankIg5[$row->total_ig_sekarang] + 1)==2 || ($rankIg5[$row->total_ig_sekarang] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->group_name}}</th>
                    <th>{{$row->total_growth_tw}} %</th>
                    <th>{{$row->total_tw_sekarang}}</th>
                    <th style="background:{{$colorTw}}">{{($rankTw5[$row->total_tw_sekarang] + 1)}}</th>
                    <th>{{$row->total_growth_fb}} %</th>
                    <th>{{$row->total_fb_sekarang}}</th>
                    <th style="background:{{$colorFb}}">{{($rankFb5[$row->total_fb_sekarang] + 1)}}</th>
                    <th>{{$row->total_growth_ig}} %</th>
                    <th>{{$row->total_ig_sekarang}}</th>
                    <th style="background:{{$colorIg}}">{{($rankIg5[$row->total_ig_sekarang] + 1)}}</th>
                </tr>
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
                    <th>{{$row->total_growth_tw}} %</th>
                    <th>{{$row->total_tw_sekarang}}</th>
                    <th style="background:{{$colorTw}}">{{($rankTw6[$row->total_tw_sekarang] + 1)}}</th>
                    <th>{{$row->total_growth_fb}} %</th>
                    <th>{{$row->total_fb_sekarang}}</th>
                    <th style="background:{{$colorFb}}">{{($rankFb6[$row->total_fb_sekarang] + 1)}}</th>
                    <th>{{$row->total_growth_ig}} %</th>
                    <th>{{$row->total_ig_sekarang}}</th>
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
            array_push($arrTw7,$k->total_num_of_growth_tw);
            array_push($arrFb7,$k->total_num_of_growth_fb);
            array_push($arrIg7,$k->total_num_of_growth_ig);
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
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw7[$row->total_num_of_growth_tw] + 1)==1 || ($rankTw7[$row->total_num_of_growth_tw] + 1)==2 || ($rankTw7[$row->total_num_of_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb7[$row->total_num_of_growth_fb] + 1)==1 || ($rankFb7[$row->total_num_of_growth_fb] + 1)==2 || ($rankFb7[$row->total_num_of_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg7[$row->total_num_of_growth_ig] + 1)==1 || ($rankIg7[$row->total_num_of_growth_ig] + 1)==2 || ($rankIg7[$row->total_num_of_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->group_name}}</th>
                    <th>{{$row->total_num_of_growth_tw}}</th>
                    <th>{{$row->total_growth_tw}} %</th>
                    <th style="background:{{$colorTw}}">{{($rankTw7[$row->total_num_of_growth_tw] + 1)}}</th>
                    <th>{{$row->total_num_of_growth_fb}}</th>
                    <th>{{$row->total_growth_fb}} %</th>
                    <th style="background:{{$colorFb}}">{{($rankFb7[$row->total_num_of_growth_fb] + 1)}}</th>
                    <th>{{$row->total_num_of_growth_ig}}</th>
                    <th>{{$row->total_growth_ig}} %</th>
                    <th style="background:{{$colorIg}}">{{($rankIg7[$row->total_num_of_growth_ig] + 1)}}</th>
                </tr>
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
            array_push($arrTw8,$k->total_num_of_growth_tw);
            array_push($arrFb8,$k->total_num_of_growth_fb);
            array_push($arrIg8,$k->total_num_of_growth_ig);
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
            @foreach($rankOverallAccountAllTv as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    
                    if(($rankTw8[$row->total_num_of_growth_tw] + 1)==1 || ($rankTw8[$row->total_num_of_growth_tw] + 1)==2 || ($rankTw8[$row->total_num_of_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb8[$row->total_num_of_growth_fb] + 1)==1 || ($rankFb8[$row->total_num_of_growth_fb] + 1)==2 || ($rankFb8[$row->total_num_of_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg8[$row->total_num_of_growth_ig] + 1)==1 || ($rankIg8[$row->total_num_of_growth_ig] + 1)==2 || ($rankIg8[$row->total_num_of_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    <th>{{$row->total_num_of_growth_tw}}</th>
                    <th>{{$row->total_growth_tw}} %</th>
                    <th style="background:{{$colorTw}}">{{($rankTw8[$row->total_num_of_growth_tw] + 1)}}</th>
                    <th>{{$row->total_num_of_growth_fb}}</th>
                    <th>{{$row->total_growth_fb}} %</th>
                    <th style="background:{{$colorFb}}">{{($rankFb8[$row->total_num_of_growth_fb] + 1)}}</th>
                    <th>{{$row->total_num_of_growth_ig}}</th>
                    <th>{{$row->total_growth_ig}} %</th>
                    <th style="background:{{$colorIg}}">{{($rankIg8[$row->total_num_of_growth_ig] + 1)}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>