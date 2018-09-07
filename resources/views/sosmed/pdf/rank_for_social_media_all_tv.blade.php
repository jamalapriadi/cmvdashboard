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
    @if(count($sosmed)<2)
        @foreach($sosmed as $row)
            @if($row->id==4)
                <h1 class="text-center">
                    @if($typeunit=="Publisher")
                        RANK FOR HARDNEWS PUBLISHER YOUTUBE REPORT
                    @else 
                        RANK FOR {{strtoupper($typeunit)}} YOUTUBE REPORT
                    @endif
                </h1>
            @else 
                <h1 class="text-center">
                    @if($typeunit=="Publisher")
                        RANK FOR HARDNEWS PUBLISHER {{strtoupper($row->sosmed_name)}} REPORT
                    @else 
                        RANK FOR {{strtoupper($typeunit)}} {{strtoupper($row->sosmed_name)}} REPORT
                    @endif
                </h1>
            @endif
        @endforeach
    @elseif(count($sosmed)>3)
        @if($typeunit=="TV")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED & YOUTUBE DAILY REPORT</h1>
        @elseif($typeunit=="Radio")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit=="Publisher")
            <h1 class="text-center">RANK FOR HARDNEWS PUBLISHER SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit=="KOL")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED & YOUTUBE REPORT</h1>
        @else

        @endif
    @else 
        @if($typeunit=="TV")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED DAILY REPORT</h1>
        @elseif($typeunit=="Radio")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED REPORT</h1>
        @elseif($typeunit=="Publisher")
            <h1 class="text-center">RANK FOR HARDNEWS PUBLISHER SOCMED REPORT</h1>
        @elseif($typeunit=="KOL")
            <h1 class="text-center">RANK FOR {{strtoupper($typeunit)}} SOCMED REPORT</h1>
        @else

        @endif
    @endif

    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} vs {{date('d-m-Y',strtotime($kemarin))}} )</p>

    <div class="page-break"></div>
    
    @if($typeunit!="Radio")
    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br><br><br>
    <?php 
        $arrTw=array();
        $arrFb=array();
        $arrIg=array();
        $arrYt=array();
        foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
            if($k->id==5 || $k->id==12){
                foreach($groupOthers as $pk){
                    array_push($arrTw,$pk->tw_sekarang);
                    array_push($arrFb,$pk->fb_sekarang);
                    array_push($arrIg,$pk->ig_sekarang);
                    array_push($arrYt,$pk->yt_sekarang);
                }
            }elseif($k->id==1){
                if($typeunit=="TV"){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            array_push($arrTw,($k->tw_sekarang+$in->tw_sekarang));
                            array_push($arrFb,($k->fb_sekarang+$in->fb_sekarang));
                            array_push($arrIg,($k->ig_sekarang+$in->ig_sekarang));    
                            array_push($arrYt,($k->yt_sekarang+$in->yt_sekarang));    
                        }
                    }
                }else{
                    array_push($arrTw,$k->tw_sekarang);
                    array_push($arrFb,$k->fb_sekarang);
                    array_push($arrIg,$k->ig_sekarang);
                    array_push($arrYt,$k->yt_sekarang);    
                }
            }else{
                array_push($arrTw,$k->tw_sekarang);
                array_push($arrFb,$k->fb_sekarang);
                array_push($arrIg,$k->ig_sekarang);
                array_push($arrYt,$k->yt_sekarang);
            }
        }
        $rankTw=$arrTw;
        $rankFb=$arrFb;
        $rankIg=$arrIg;
        $rankYt=$arrYt;

        rsort($rankTw);
        rsort($rankFb);
        rsort($rankIg);
        rsort($rankYt);

        $rankTw=array_flip($rankTw);
        $rankFb=array_flip($rankFb);
        $rankIg=array_flip($rankIg);
        $rankYt=array_flip($rankYt);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $row)
                    @if($row->id!=4)
                        <th colspan='3' class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $row)
                    @if($row->id!=4)
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>% Growth</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>TOTAL</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>RANK</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllGroupByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                ?>

                <!-- jika tv maka tampilkan 1 sampai 5 saja -->
                @if($row->id==5 || $row->id==12)
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

                        @if(($rankYt[$pp->yt_sekarang] + 1)==1 || ($rankYt[$pp->yt_sekarang] + 1)==2 || ($rankYt[$pp->yt_sekarang] + 1)==3)
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
                        $tyt=0;
                        $growth_yt=0;
                    ?>
                    @if($typeunit=="TV")
                        @foreach($tambahanInews as $ins)
                            @if($ins->id=="TOTAL")
                                <?php
                                    $ttw=$ins->tw_sekarang+$row->tw_sekarang;
                                    $tfb=$ins->fb_sekarang+$row->fb_sekarang;
                                    $tig=$ins->ig_sekarang+$row->ig_sekarang;
                                    $tyt=$ins->yt_sekarang+$row->yt_sekarang;
                                ?>

                                @foreach($sosmed as $sos)
                                    @if($sos->id==1)
                                        @if(($rankTw[$ttw] + 1)==1 || ($rankTw[$ttw] + 1)==2 || ($rankTw[$ttw] + 1)==3)
                                            <?php 
                                                $colorTw="#f4a018"; 
                                                $ttw=$row->tw_sekarang+$ins->tw_sekarang;
                                                $growth_tw=$row->growth_tw+$ins->growth_tw;
                                            ?>
                                        @endif
                                    @endif

                                    @if($sos->id==2)
                                        @if(($rankFb[$tfb] + 1)==1 || ($rankFb[$tfb] + 1)==2 || ($rankFb[$tfb] + 1)==3)
                                            <?php 
                                                $colorFb="#f4a018"; 
                                                $tfb=$row->fb_sekarang+$ins->fb_sekarang;
                                                $growth_fb=$row->growth_fb+$ins->growth_fb;
                                            ?>
                                        @endif
                                    @endif

                                    @if($sos->id==3)
                                        @if(($rankIg[$tig] + 1)==1 || ($rankIg[$tig] + 1)==2 || ($rankIg[$tig] + 1)==3)
                                            <?php 
                                                $colorIg="#f4a018"; 
                                                $tig=$row->ig_sekarang+$ins->ig_sekarang;
                                                $growth_ig=$row->growth_ig+$ins->growth_ig;
                                            ?>
                                        @endif
                                    @endif

                                    @if($sos->id==4)
                                        @if(($rankYt[$tyt] + 1)==1 || ($rankYt[$tyt] + 1)==2 || ($rankYt[$tyt] + 1)==3)
                                            <?php 
                                                $colorYt="#f4a018"; 
                                                $tyt=$row->yt_sekarang+$ins->yt_sekarang;
                                                $growth_yt=$row->growth_yt+$ins->growth_yt;
                                            ?>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <?php
                            $ttw=$row->tw_sekarang;
                            $tfb=$row->fb_sekarang;
                            $tig=$row->ig_sekarang;
                            $tyt=$row->yt_sekarang;
                        ?>

                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                @if(($rankTw[$ttw] + 1)==1 || ($rankTw[$ttw] + 1)==2 || ($rankTw[$ttw] + 1)==3)
                                    <?php 
                                        $colorTw="#f4a018"; 
                                        $ttw=$row->tw_sekarang;
                                        $growth_tw=$row->growth_tw;
                                    ?>
                                @endif
                            @endif

                            @if($sos->id==2)
                                @if(($rankFb[$tfb] + 1)==1 || ($rankFb[$tfb] + 1)==2 || ($rankFb[$tfb] + 1)==3)
                                    <?php 
                                        $colorFb="#f4a018"; 
                                        $tfb=$row->fb_sekarang;
                                        $growth_fb=$row->growth_fb;
                                    ?>
                                @endif
                            @endif

                            @if($sos->id==3)
                                @if(($rankIg[$tig] + 1)==1 || ($rankIg[$tig] + 1)==2 || ($rankIg[$tig] + 1)==3)
                                    <?php 
                                        $colorIg="#f4a018"; 
                                        $tig=$row->ig_sekarang;
                                        $growth_ig=$row->growth_ig;
                                    ?>
                                @endif
                            @endif

                            @if($sos->id==4)
                                @if(($rankYt[$tyt] + 1)==1 || ($rankYt[$tyt] + 1)==2 || ($rankYt[$tyt] + 1)==3)
                                    <?php 
                                        $colorYt="#f4a018"; 
                                        $tyt=$row->yt_sekarang;
                                        $growth_yt=$row->growth_yt;
                                    ?>
                                @endif
                            @endif
                        @endforeach
                    @endif
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

                    @if(($rankYt[$row->yt_sekarang] + 1)==1 || ($rankYt[$row->yt_sekarang] + 1)==2 || ($rankYt[$row->yt_sekarang] + 1)==3)
                        <?php $colorYt="#f4a018"; ?>
                    @endif
                @endif

                <!--tampilkan data-->
                @if($row->id==5 || $row->id==12)
                    @foreach($groupOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                            $cyt="";
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

                        @if(($rankYt[$p->yt_sekarang] + 1)==1 || ($rankYt[$p->yt_sekarang] + 1)==2 || ($rankYt[$p->yt_sekarang] + 1)==3)
                            <?php $cyt="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            @foreach($sosmed as $sos)
                                @if($sos->id==1)
                                    <th>{{round($p->growth_tw,2)}} %</th>
                                    <th>{{number_format($p->tw_sekarang)}}</th>
                                    <th style="background:{{$ctw}}">{{($rankTw[$p->tw_sekarang] + 1)}}</th>
                                @endif

                                @if($sos->id==2)
                                    <th>{{round($p->growth_fb,2)}} %</th>
                                    <th>{{number_format($p->fb_sekarang)}}</th>
                                    <th style="background:{{$cfb}}">{{($rankFb[$p->fb_sekarang] + 1)}}</th>
                                @endif

                                @if($sos->id==3)
                                    <th>{{round($p->growth_ig,2)}} %</th>
                                    <th>{{number_format($p->ig_sekarang)}}</th>
                                    <th style="background:{{$cig}}">{{($rankIg[$p->ig_sekarang] + 1)}}</th>
                                @endif

                                <!-- @if($sos->id==4)
                                    <th>{{round($p->growth_yt,2)}} %</th>
                                    <th>{{number_format($p->yt_sekarang)}}</th>
                                    <th style="background:{{$cyt}}">{{($rankYt[$p->yt_sekarang] + 1)}}</th>
                                @endif -->
                            @endforeach
                        </tr>
                    @endforeach
                @elseif($row->id==1)
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th>{{number_format($ttw)}}</th>
                                <th style="background:{{$colorTw}}">{{($rankTw[$ttw] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th>{{number_format($tfb)}}</th>
                                <th style="background:{{$colorFb}}">{{($rankFb[$tfb] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th>{{number_format($tig)}}</th>
                                <th style="background:{{$colorIg}}">{{($rankIg[$tig] + 1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th>{{number_format($tyt)}}</th>
                                <th style="background:{{$colorYt}}">{{($rankYt[$tyt] + 1)}}</th>
                            @endif -->
                        @endforeach
                    </tr>
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th>{{number_format($row->tw_sekarang)}}</th>
                                <th style="background:{{$colorTw}}">{{($rankTw[$row->tw_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th>{{number_format($row->fb_sekarang)}}</th>
                                <th style="background:{{$colorFb}}">{{($rankFb[$row->fb_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th>{{number_format($row->ig_sekarang)}}</th>
                                <th style="background:{{$colorIg}}">{{($rankIg[$row->ig_sekarang] + 1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th>{{number_format($row->yt_sekarang)}}</th>
                                <th style="background:{{$colorYt}}">{{($rankYt[$row->yt_sekarang] + 1)}}</th>
                            @endif -->
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL @if($typeunit=="Publisher") HARDNEWS PUBLISHER @else {{strtoupper($typeunit)}} @endif <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br>

    <?php
    $arrTw2=array();
    $arrFb2=array();
    $arrIg2=array();
    $arrYt2=array();
    foreach($rankOfOfficialAccountAllTvByFollowers as $k){
        if($k->id==4){
            foreach($tambahanInews as $in){
                if($in->id=="TOTAL"){
                    array_push($arrTw2,$in->tw_sekarang);
                    array_push($arrFb2,$in->fb_sekarang);
                    array_push($arrIg2,$in->ig_sekarang);        
                    array_push($arrYt2,$in->yt_sekarang);        
                }
            }
        }else{
            array_push($arrTw2,$k->tw_sekarang);
            array_push($arrFb2,$k->fb_sekarang);
            array_push($arrIg2,$k->ig_sekarang);
            array_push($arrYt2,$k->yt_sekarang);
        }
    }
    $rankTw2=$arrTw2;
    $rankFb2=$arrFb2;
    $rankIg2=$arrIg2;
    $rankYt2=$arrYt2;

    rsort($rankTw2);
    rsort($rankFb2);
    rsort($rankIg2);
    rsort($rankYt2);

    $rankTw2=array_flip($rankTw2);
    $rankFb2=array_flip($rankFb2);
    $rankIg2=array_flip($rankIg2);
    $rankYt2=array_flip($rankYt2);
    ?>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="17%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                        <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>TOTAL</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllTvByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
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

                            @if(($rankYt2[$in->yt_sekarang] + 1)==1 || ($rankYt2[$in->yt_sekarang] + 1)==2 || ($rankYt2[$in->yt_sekarang] + 1)==3)
                                <?php $colorYt="#f4a018";?>
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

                    @if(($rankYt2[$row->yt_sekarang] + 1)==1 || ($rankYt2[$row->yt_sekarang] + 1)==2 || ($rankYt2[$row->yt_sekarang] + 1)==3)
                        <?php $colorYt="#f4a018";?>
                    @endif
                @endif

                @if($row->id==4)
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <tr>
                                <th>{{$row->unit_name}}</th>
                                @foreach($sosmed as $sos)
                                    @if($sos->id==1)
                                        <th>{{round($ins->growth_tw,2)}} %</th>
                                        <th>{{number_format($ins->tw_sekarang)}}</th>
                                        <th style="background:{{$colorTw}}">{{($rankTw2[$ins->tw_sekarang] + 1)}}</th>
                                    @endif

                                    @if($sos->id==2)
                                        <th>{{round($ins->growth_fb,2)}} %</th>
                                        <th>{{number_format($ins->fb_sekarang)}}</th>
                                        <th style="background:{{$colorFb}}">{{($rankFb2[$ins->fb_sekarang] + 1)}}</th>
                                    @endif

                                    @if($sos->id==3)
                                        <th>{{round($ins->growth_ig,2)}} %</th>
                                        <th>{{number_format($ins->ig_sekarang)}}</th>
                                        <th style="background:{{$colorIg}}">{{($rankIg2[$ins->ig_sekarang] + 1)}}</th>
                                    @endif

                                    <!-- @if($sos->id==4)
                                        <th>{{round($ins->growth_yt,2)}} %</th>
                                        <th>{{number_format($ins->yt_sekarang)}}</th>
                                        <th style="background:{{$colorYt}}">{{($rankYt2[$ins->yt_sekarang] + 1)}}</th>
                                    @endif -->
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->unit_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th>{{number_format($row->tw_sekarang)}}</th>
                                <th style="background:{{$colorTw}}">{{($rankTw2[$row->tw_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th>{{number_format($row->fb_sekarang)}}</th>
                                <th style="background:{{$colorFb}}">{{($rankFb2[$row->fb_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th>{{number_format($row->ig_sekarang)}}</th>
                                <th style="background:{{$colorIg}}">{{($rankIg2[$row->ig_sekarang] + 1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th>{{number_format($row->yt_sekarang)}}</th>
                                <th style="background:{{$colorYt}}">{{($rankYt2[$row->yt_sekarang] + 1)}}</th>
                            @endif -->
                        @endforeach
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
        $arrYt3=array();
        foreach($rankOfOfficialAccountAllGroupByFollowers as $k){
            if($k->id==5 || $k->id==12){
                foreach($groupOthers as $pk){
                    array_push($arrTw3,(string)$pk->growth_tw);
                    array_push($arrFb3,(string)$pk->growth_fb);
                    array_push($arrIg3,(string)$pk->growth_ig);
                    array_push($arrYt3,(string)$pk->growth_yt);
                }
            }elseif($k->id==1){
                if($typeunit=="TV"){
                    foreach($tambahanInews as $in){
                        if($in->id=="TOTAL"){
                            $twsekarang1=$k->tw_sekarang+$in->tw_sekarang;
                            $twkemarin1=$k->tw_kemarin+$in->tw_kemarin;
                            if($twkemarin1>0){
                                $growthtw1=($twsekarang1/$twkemarin1-1)*100;
                            }else{
                                $growthtw1=0;
                            }
    
                            $fbsekarang1=$k->fb_sekarang+$in->fb_sekarang;
                            $fbkemarin1=$k->fb_kemarin+$in->fb_kemarin;
                            if($fbkemarin1>0){
                                $growthfb1=($fbsekarang1/$fbkemarin1-1)*100;
                            }else{
                                $growthfb1=0;
                            }
    
                            $igsekarang1=$k->ig_sekarang+$in->ig_sekarang;
                            $igkemarin1=$k->ig_kemarin+$in->ig_kemarin;
                            if($igkemarin1>0){
                                $growthig1=($igsekarang1/$igkemarin1-1)*100;
                            }else{
                                $growthig1=0;
                            }
    
                            $ytsekarang1=$k->yt_sekarang+$in->yt_sekarang;
                            $ytkemarin1=$k->yt_kemarin+$in->yt_kemarin;
                            if($ytkemarin1>0){
                                $growthyt1=($ytsekarang1/$ytkemarin1-1)*100;
                            }else{
                                $growthyt1=0;
                            }
    
                            array_push($arrTw3,(string)$growthtw1);
                            array_push($arrFb3,(string)$growthfb1);
                            array_push($arrIg3,(string)$growthig1);    
                            array_push($arrYt3,(string)$growthyt1);    
                        }
                    }
                }else{
                    $twsekarang1=$k->tw_sekarang;
                    $twkemarin1=$k->tw_kemarin;
                    if($twkemarin1>0){
                        $growthtw1=($twsekarang1/$twkemarin1-1)*100;
                    }else{
                        $growthtw1=0;
                    }

                    $fbsekarang1=$k->fb_sekarang;
                    $fbkemarin1=$k->fb_kemarin;
                    if($fbkemarin1>0){
                        $growthfb1=($fbsekarang1/$fbkemarin1-1)*100;
                    }else{
                        $growthfb1=0;
                    }

                    $igsekarang1=$k->ig_sekarang;
                    $igkemarin1=$k->ig_kemarin;
                    if($igkemarin1>0){
                        $growthig1=($igsekarang1/$igkemarin1-1)*100;
                    }else{
                        $growthig1=0;
                    }

                    $ytsekarang1=$k->yt_sekarang;
                    $ytkemarin1=$k->yt_kemarin;
                    if($ytkemarin1>0){
                        $growthyt1=($ytsekarang1/$ytkemarin1-1)*100;
                    }else{
                        $growthyt1=0;
                    }

                    array_push($arrTw3,(string)$growthtw1);
                    array_push($arrFb3,(string)$growthfb1);
                    array_push($arrIg3,(string)$growthig1);    
                    array_push($arrYt3,(string)$growthyt1);    
                }
            }else{
                array_push($arrTw3,(string)$k->growth_tw);
                array_push($arrFb3,(string)$k->growth_fb);
                array_push($arrIg3,(string)$k->growth_ig);
                array_push($arrYt3,(string)$k->growth_yt);
            }
        }
        $rankTw3=$arrTw3;
        $rankFb3=$arrFb3;
        $rankIg3=$arrIg3;
        $rankYt3=$arrYt3;

        rsort($rankTw3);
        rsort($rankFb3);
        rsort($rankIg3);
        rsort($rankYt3);

        $rankTw3=array_flip($rankTw3);
        $rankFb3=array_flip($rankFb3);
        $rankIg3=array_flip($rankIg3);
        $rankYt3=array_flip($rankYt3);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                        <th colspan='3' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>Num Of Growth</th>
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllGroupByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                ?>

                <!--jika tipeunit adalah tv maka tampilkan group 1 sampai 5 -->
                @if($row->id==5 || $row->id==12)
                    @foreach($groupOthers as $pp)
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                @if(($rankTw3[$pp->growth_tw] + 1)==1 || ($rankTw3[$pp->growth_tw] + 1)==2 || ($rankTw3[$pp->growth_tw] + 1)==3)
                                    <?php $colorTw="#f4a018"; ?>
                                @endif
                            @endif

                            @if($sos->id==2)
                                @if(($rankFb3[$pp->growth_fb] + 1)==1 || ($rankFb3[$pp->growth_fb] + 1)==2 || ($rankFb3[$pp->growth_fb] + 1)==3)
                                    <?php $colorFb="#f4a018"; ?>
                                @endif
                            @endif

                            @if($sos->id==3)
                                @if(($rankIg3[$pp->growth_ig] + 1)==1 || ($rankIg3[$pp->growth_ig] + 1)==2 || ($rankIg3[$pp->growth_ig] + 1)==3)
                                    <?php $colorIg="#f4a018"; ?>
                                @endif
                            @endif

                            @if($sos->id==4)
                                @if(($rankYt3[$pp->growth_yt] + 1)==1 || ($rankYt3[$pp->growth_yt] + 1)==2 || ($rankYt3[$pp->growth_yt] + 1)==3)
                                    <?php $colorYt="#f4a018"; ?>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                @elseif($row->id==1)
                    @if($typeunit=="TV")
                        <?php 
                            $ttw3=0;
                            $growth_tw3=0;
                            $tfb3=0;
                            $growth_fb3=0;
                            $tig3=0;
                            $growth_ig3=0;
                            $tyt3=0;
                            $growth_yt3=0;
                        ?>
                        @foreach($tambahanInews as $ins)
                            @if($ins->id=="TOTAL")
                                <?php
                                    $twsekarang2=$row->tw_sekarang+$ins->tw_sekarang;
                                    $twkemarin2=$row->tw_kemarin+$ins->tw_kemarin;
                                    if($twkemarin2>0){
                                        $num_of_growth_tw2=$twsekarang2-$twkemarin2;
                                        $growthtw2=($twsekarang2/$twkemarin2-1)*100;
                                    }else{
                                        $num_of_growth_tw2=0;
                                        $growthtw2=0;
                                    }
                                    

                                    $fbsekarang2=$row->fb_sekarang+$ins->fb_sekarang;
                                    $fbkemarin2=$row->fb_kemarin+$ins->fb_kemarin;
                                    if($fbkemarin2>0){
                                        $num_of_growth_fb2=$fbsekarang2-$fbkemarin2;
                                        $growthfb2=($fbsekarang2/$fbkemarin2-1)*100;
                                    }else{
                                        $num_of_growth_fb2=0;
                                        $growthfb2=0;
                                    }

                                    $igsekarang2=$row->ig_sekarang+$ins->ig_sekarang;
                                    $igkemarin2=$row->ig_kemarin+$ins->ig_kemarin;
                                    if($igkemarin2>0){
                                        $num_of_growth_ig2=$igsekarang2-$igkemarin2;
                                        $growthig2=($igsekarang2/$igkemarin2-1)*100;
                                    }else{
                                        $num_of_growth_ig2=0;
                                        $growthig2=0;
                                    }
                                    

                                    $ytsekarang2=$row->yt_sekarang+$ins->yt_sekarang;
                                    $ytkemarin2=$row->yt_kemarin+$ins->yt_kemarin;
                                    if($ytkemarin2>0){
                                        $num_of_growth_yt2=$ytsekarang2-$ytkemarin2;
                                        $growthyt2=($ytsekarang2/$ytkemarin2-1)*100;
                                    }else{
                                        $num_of_growth_yt2=0;
                                        $growthyt2=0;
                                    }

                                    $ttw3=(string)$growthtw2;
                                    $tfb3=(string)$growthfb2;
                                    $tig3=(string)$growthig2;
                                    $tyt3=(string)$growthyt2;
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

                                @if(($rankYt3[$tyt3] + 1)==1 || ($rankYt3[$tyt3] + 1)==2 || ($rankYt3[$tyt3] + 1)==3)
                                    <?php 
                                        $colorYt="#f4a018"; 
                                        $tyt3=(string)$growthyt2;
                                        $growth_yt3=$num_of_growth_yt2
                                    ?>
                                @endif
                            @endif
                        @endforeach
                    @else 
                        <?php 
                            $ttw3=0;
                            $growth_tw3=0;
                            $tfb3=0;
                            $growth_fb3=0;
                            $tig3=0;
                            $growth_ig3=0;
                            $tyt3=0;
                            $growth_yt3=0;
                        ?>
                        <?php
                            $twsekarang2=$row->tw_sekarang;
                            $twkemarin2=$row->tw_kemarin;
                            if($twkemarin2>0){
                                $num_of_growth_tw2=$twsekarang2-$twkemarin2;
                                $growthtw2=($twsekarang2/$twkemarin2-1)*100;
                            }else{
                                $num_of_growth_tw2=0;
                                $growthtw2=0;
                            }
                            

                            $fbsekarang2=$row->fb_sekarang;
                            $fbkemarin2=$row->fb_kemarin;
                            if($fbkemarin2>0){
                                $num_of_growth_fb2=$fbsekarang2-$fbkemarin2;
                                $growthfb2=($fbsekarang2/$fbkemarin2-1)*100;
                            }else{
                                $num_of_growth_fb2=0;
                                $growthfb2=0;
                            }

                            $igsekarang2=$row->ig_sekarang;
                            $igkemarin2=$row->ig_kemarin;
                            if($igkemarin2>0){
                                $num_of_growth_ig2=$igsekarang2-$igkemarin2;
                                $growthig2=($igsekarang2/$igkemarin2-1)*100;
                            }else{
                                $num_of_growth_ig2=0;
                                $growthig2=0;
                            }
                            

                            $ytsekarang2=$row->yt_sekarang;
                            $ytkemarin2=$row->yt_kemarin;
                            if($ytkemarin2>0){
                                $num_of_growth_yt2=$ytsekarang2-$ytkemarin2;
                                $growthyt2=($ytsekarang2/$ytkemarin2-1)*100;
                            }else{
                                $num_of_growth_yt2=0;
                                $growthyt2=0;
                            }

                            $ttw3=(string)$growthtw2;
                            $tfb3=(string)$growthfb2;
                            $tig3=(string)$growthig2;
                            $tyt3=(string)$growthyt2;
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

                        @if(($rankYt3[$tyt3] + 1)==1 || ($rankYt3[$tyt3] + 1)==2 || ($rankYt3[$tyt3] + 1)==3)
                            <?php 
                                $colorYt="#f4a018"; 
                                $tyt3=(string)$growthyt2;
                                $growth_yt3=$num_of_growth_yt2
                            ?>
                        @endif
                    @endif
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

                    @if(($rankYt3[$row->growth_yt] + 1)==1 || ($rankYt3[$row->growth_yt] + 1)==2 || ($rankYt3[$row->growth_yt] + 1)==3)
                        <?php $colorYt="#f4a018"; ?>
                    @endif
                @endif

                @if($row->id==5 || $row->id==12)
                    @foreach($groupOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                            $cyt="";
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

                        @if(($rankYt3[$p->growth_yt] + 1)==1 || ($rankYt3[$p->growth_yt] + 1)==2 || ($rankYt3[$p->growth_yt] + 1)==3)
                            <?php $cyt="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            @foreach($sosmed as $sos)
                                @if($sos->id==1)
                                    <th>{{number_format($p->num_of_growth_tw)}}</th>
                                    <th>{{round($p->growth_tw,2)}} %</th>
                                    <th style="background:{{$ctw}}">{{($rankTw3[$p->growth_tw] + 1)}}</th>
                                @endif

                                @if($sos->id==2)
                                    <th>{{number_format($p->num_of_growth_fb)}}</th>
                                    <th>{{round($p->growth_fb,2)}} %</th>
                                    <th style="background:{{$cfb}}">{{($rankFb3[$p->growth_fb] + 1)}}</th>
                                @endif

                                @if($sos->id==3)
                                    <th>{{number_format($p->num_of_growth_ig)}}</th>
                                    <th>{{round($p->growth_ig,2)}} %</th>
                                    <th style="background:{{$cig}}">{{($rankIg3[$p->growth_ig] + 1)}}</th>
                                @endif

                                <!-- @if($sos->id==4)
                                    <th>{{number_format($p->num_of_growth_yt)}}</th>
                                    <th>{{round($p->growth_yt,2)}} %</th>
                                    <th style="background:{{$cyt}}">{{($rankYt3[$p->growth_yt] + 1)}}</th>
                                @endif -->
                            @endforeach
                        </tr>
                    @endforeach
                @elseif($row->id==1)
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{number_format($row->num_of_growth_tw)}}</th>
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th style="background:{{$colorTw}}">{{($rankTw3[$ttw3] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{number_format($row->num_of_growth_fb)}}</th>
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th style="background:{{$colorFb}}">{{($rankFb3[$tfb3] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{number_format($row->num_of_growth_ig)}}</th>
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th style="background:{{$colorIg}}">{{($rankIg3[$tig3]+1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{number_format($row->num_of_growth_yt)}}</th>
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th style="background:{{$colorYt}}">{{($rankYt3[$tyt3]+1)}}</th>
                            @endif -->
                        @endforeach
                    </tr>
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{number_format($row->num_of_growth_tw)}}</th>
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th style="background:{{$colorTw}}">{{($rankTw3[$row->growth_tw] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{number_format($row->num_of_growth_fb)}}</th>
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th style="background:{{$colorFb}}">{{($rankFb3[$row->growth_fb] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{number_format($row->num_of_growth_ig)}}</th>
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th style="background:{{$colorIg}}">{{($rankIg3[$row->growth_ig] + 1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{number_format($row->num_of_growth_yt)}}</th>
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th style="background:{{$colorYt}}">{{($rankYt3[$row->growth_yt] + 1)}}</th>
                            @endif -->
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OFFICIAL ACCOUNT ALL @if($typeunit=="Publisher") HARDNEWS PUBLISHER @else {{strtoupper($typeunit)}} @endif <span style="color:red">BY % GROWTH YESTERDAY</span></h3>
    <br>

    <?php
    $arrTw4=array();
    $arrFb4=array();
    $arrIg4=array();
    $arrYt4=array();
    foreach($rankOfOfficialAccountAllTvByFollowers as $k){
        if($k->id==4){
            foreach($tambahanInews as $in){
                if($in->id=="TOTAL"){
                    array_push($arrTw4,(string)($in->growth_tw));
                    array_push($arrFb4,(string)($in->growth_fb));
                    array_push($arrIg4,(string)($in->growth_ig));    
                    array_push($arrYt4,(string)($in->growth_yt));    
                }
            }
        }else{
            array_push($arrTw4,(string)$k->growth_tw);
            array_push($arrFb4,(string)$k->growth_fb);
            array_push($arrIg4,(string)$k->growth_ig);
            array_push($arrYt4,(string)$k->growth_yt);
        }
    }
    $rankTw4=$arrTw4;
    $rankFb4=$arrFb4;
    $rankIg4=$arrIg4;
    $rankYt4=$arrYt4;

    rsort($rankTw4);
    rsort($rankFb4);
    rsort($rankIg4);
    rsort($rankYt4);

    $rankTw4=array_flip($rankTw4);
    $rankFb4=array_flip($rankFb4);
    $rankIg4=array_flip($rankIg4);
    $rankYt4=array_flip($rankYt4);
    ?>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="17%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                        <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                    @if($sos->id!=4)
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>Num Of Growth</th>
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                        <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOfOfficialAccountAllTvByFollowers as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                ?>
                <!-- jika type unit adalah tv-->

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

                            @if(($rankYt4[$in->growth_yt] + 1)==1 || ($rankYt4[$in->growth_yt] + 1)==2 || ($rankYt4[$in->growth_yt] + 1)==3)
                                <?php $colorYt="#f4a018";?>
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

                    @if(($rankYt4[(string)$row->growth_yt] + 1)==1 || ($rankYt4[(string)$row->growth_yt] + 1)==2 || ($rankYt4[(string)$row->growth_yt] + 1)==3)
                        <?php $colorYt="#f4a018";?>
                    @endif
                @endif


                <!-- tampil -->
                @if($row->id==4)
                    @foreach($tambahanInews as $ins)
                        @if($ins->id=="TOTAL")
                            <tr>
                                <th>{{$row->unit_name}}</th>
                                @foreach($sosmed as $sos)
                                    @if($sos->id==1)
                                        <th>{{number_format($ins->num_of_growth_tw)}}</th>
                                        <th>{{round($ins->growth_tw,2)}} %</th>
                                        <th style="background:{{$colorTw}}">{{($rankTw4[(string)$ins->growth_tw] + 1)}}</th>
                                    @endif

                                    @if($sos->id==2)
                                        <th>{{number_format($ins->num_of_growth_fb)}}</th>
                                        <th>{{round($ins->growth_fb,2)}} %</th>
                                        <th style="background:{{$colorFb}}">{{($rankFb4[(string)$ins->growth_fb] + 1)}}</th>
                                    @endif

                                    @if($sos->id==3)
                                        <th>{{number_format($ins->num_of_growth_ig)}}</th>
                                        <th>{{round($ins->growth_ig,2)}} %</th>
                                        <th style="background:{{$colorIg}}">{{($rankIg4[(string)$ins->growth_ig] + 1)}}</th>
                                    @endif

                                    <!-- @if($sos->id==4)
                                        <th>{{number_format($ins->num_of_growth_yt)}}</th>
                                        <th>{{round($ins->growth_yt,2)}} %</th>
                                        <th style="background:{{$colorYt}}">{{($rankYt4[(string)$ins->growth_yt] + 1)}}</th>
                                    @endif -->
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @else 
                    <tr>
                        <th>{{$row->unit_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{number_format($row->num_of_growth_tw)}}</th>
                                <th>{{round($row->growth_tw,2)}} %</th>
                                <th style="background:{{$colorTw}}">{{($rankTw4[(string)$row->growth_tw] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{number_format($row->num_of_growth_fb)}}</th>
                                <th>{{round($row->growth_fb,2)}} %</th>
                                <th style="background:{{$colorFb}}">{{($rankFb4[(string)$row->growth_fb] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{number_format($row->num_of_growth_ig)}}</th>
                                <th>{{round($row->growth_ig,2)}} %</th>
                                <th style="background:{{$colorIg}}">{{($rankIg4[(string)$row->growth_ig] + 1)}}</th>
                            @endif

                            <!-- @if($sos->id==4)
                                <th>{{number_format($row->num_of_growth_yt)}}</th>
                                <th>{{round($row->growth_yt,2)}} %</th>
                                <th style="background:{{$colorYt}}">{{($rankYt4[(string)$row->growth_yt] + 1)}}</th>
                            @endif -->
                        @endforeach
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>

    
    <div class="page-break"></div>
    @endif

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL GROUP <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br><br><br>
    <?php 
        $arrTw5=array();
        $arrFb5=array();
        $arrIg5=array();
        $arrYt5=array();

        foreach($rankOverallAccountGroup as $k){
            if($k->group_unit_id==5 || $k->group_unit_id==12){
                foreach($tambahanOverAllTvOthers as $pk){
                    array_push($arrTw5,$pk->total_tw_sekarang);
                    array_push($arrFb5,$pk->total_fb_sekarang);
                    array_push($arrIg5,$pk->total_ig_sekarang);
                    array_push($arrYt5,$pk->total_yt_sekarang);
                }
            }else{
                array_push($arrTw5,$k->total_tw_sekarang);
                array_push($arrFb5,$k->total_fb_sekarang);
                array_push($arrIg5,$k->total_ig_sekarang);
                array_push($arrYt5,$k->total_yt_sekarang);
            }
        }
        $rankTw5=$arrTw5;
        $rankFb5=$arrFb5;
        $rankIg5=$arrIg5;
        $rankYt5=$arrYt5;

        rsort($rankTw5);
        rsort($rankFb5);
        rsort($rankIg5);
        rsort($rankYt5);

        $rankTw5=array_flip($rankTw5);
        $rankFb5=array_flip($rankFb5);
        $rankIg5=array_flip($rankIg5);
        $rankYt5=array_flip($rankYt5);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>TOTAL</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                ?>

                @if($row->group_unit_id==5 || $row->group_unit_id==12)
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

                        @if(($rankYt5[$pp->total_yt_sekarang] + 1)==1 || ($rankYt5[$pp->total_yt_sekarang] + 1)==2 || ($rankYt5[$pp->total_yt_sekarang] + 1)==3)
                            <?php $colorYt="#f4a018"; ?>
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

                    @if(($rankYt5[$row->total_yt_sekarang] + 1)==1 || ($rankYt5[$row->total_yt_sekarang] + 1)==2 || ($rankYt5[$row->total_yt_sekarang] + 1)==3)
                        <?php $colorYt="#f4a018";?>
                    @endif
                @endif 

                <!-- tampil -->
                @if($row->group_unit_id==5 || $row->group_unit_id==12)
                    @foreach($tambahanOverAllTvOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                            $cyt="";
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

                        @if(($rankYt5[$p->total_yt_sekarang] + 1)==1 || ($rankYt5[$p->total_yt_sekarang] + 1)==2 || ($rankYt5[$p->total_yt_sekarang] + 1)==3)
                            <?php $cyt="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            @foreach($sosmed as $sos)
                                @if($sos->id==1)
                                    <th>{{round($p->total_growth_tw,2)}} %</th>
                                    <th>{{number_format($p->total_tw_sekarang)}}</th>
                                    <th style="background:{{$ctw}}">{{($rankTw5[$p->total_tw_sekarang] + 1)}}</th>
                                @endif

                                @if($sos->id==2)
                                    <th>{{round($p->total_growth_fb,2)}} %</th>
                                    <th>{{number_format($p->total_fb_sekarang)}}</th>
                                    <th style="background:{{$cfb}}">{{($rankFb5[$p->total_fb_sekarang] + 1)}}</th>
                                @endif

                                @if($sos->id==3)
                                    <th>{{round($p->total_growth_ig,2)}} %</th>
                                    <th>{{number_format($p->total_ig_sekarang)}}</th>
                                    <th style="background:{{$cig}}">{{($rankIg5[$p->total_ig_sekarang] + 1)}}</th>
                                @endif

                                @if($sos->id==4)
                                    <th>{{round($p->total_growth_yt,2)}} %</th>
                                    <th>{{number_format($p->total_yt_sekarang)}}</th>
                                    <th style="background:{{$cyt}}">{{($rankYt5[$p->total_yt_sekarang] + 1)}}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{round($row->total_growth_tw,2)}} %</th>
                                <th>{{number_format($row->total_tw_sekarang)}}</th>
                                <th style="background:{{$colorTw}}">{{($rankTw5[$row->total_tw_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{round($row->total_growth_fb,2)}} %</th>
                                <th>{{number_format($row->total_fb_sekarang)}}</th>
                                <th style="background:{{$colorFb}}">{{($rankFb5[$row->total_fb_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{round($row->total_growth_ig,2)}} %</th>
                                <th>{{number_format($row->total_ig_sekarang)}}</th>
                                <th style="background:{{$colorIg}}">{{($rankIg5[$row->total_ig_sekarang] + 1)}}</th>
                            @endif

                            @if($sos->id==4)
                                <th>{{round($row->total_growth_yt,2)}} %</th>
                                <th>{{number_format($row->total_yt_sekarang)}}</th>
                                <th style="background:{{$colorYt}}">{{($rankYt5[$row->total_yt_sekarang] + 1)}}</th>
                            @endif
                        @endforeach
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">RANK OF OVERALL ACCOUNT FOR ALL @if($typeunit=="Publisher") HARDNEWS PUBLISHER @else {{strtoupper($typeunit)}} @endif <span style="color:red">BY TOTAL FOLLOWERS</span></h3>
    <br>
    <?php 
        $arrTw6=array();
        $arrFb6=array();
        $arrIg6=array();
        $arrYt6=array();
        foreach($rankOverallAccountAllTv as $k){
            array_push($arrTw6,$k->total_tw_sekarang);
            array_push($arrFb6,$k->total_fb_sekarang);
            array_push($arrIg6,$k->total_ig_sekarang);
            array_push($arrYt6,$k->total_yt_sekarang);
        }
        $rankTw6=$arrTw6;
        $rankFb6=$arrFb6;
        $rankIg6=$arrIg6;
        $rankYt6=$arrYt6;

        rsort($rankTw6);
        rsort($rankFb6);
        rsort($rankIg6);
        rsort($rankYt6);

        $rankTw6=array_flip($rankTw6);
        $rankFb6=array_flip($rankFb6);
        $rankIg6=array_flip($rankIg6);
        $rankYt6=array_flip($rankYt6);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="18%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>TOTAL</th>
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountAllTv as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                    
                    if(($rankTw6[$row->total_tw_sekarang] + 1)==1 || ($rankTw6[$row->total_tw_sekarang] + 1)==2 || ($rankTw6[$row->total_tw_sekarang] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb6[$row->total_fb_sekarang] + 1)==1 || ($rankFb6[$row->total_fb_sekarang] + 1)==2 || ($rankFb6[$row->total_fb_sekarang] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg6[$row->total_ig_sekarang] + 1)==1 || ($rankIg6[$row->total_ig_sekarang] + 1)==2 || ($rankIg6[$row->total_ig_sekarang] + 1)==3){
                        $colorIg="#f4a018";
                    }

                    if(($rankYt6[$row->total_yt_sekarang] + 1)==1 || ($rankYt6[$row->total_yt_sekarang] + 1)==2 || ($rankYt6[$row->total_yt_sekarang] + 1)==3){
                        $colorYt="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    @foreach($sosmed as $sos)
                        @if($sos->id==1)
                            <th>{{round($row->total_growth_tw,2)}} %</th>
                            <th>{{number_format($row->total_tw_sekarang)}}</th>
                            <th style="background:{{$colorTw}}">{{($rankTw6[$row->total_tw_sekarang] + 1)}}</th>
                        @endif

                        @if($sos->id==2)
                            <th>{{round($row->total_growth_fb,2)}} %</th>
                            <th>{{number_format($row->total_fb_sekarang)}}</th>
                            <th style="background:{{$colorFb}}">{{($rankFb6[$row->total_fb_sekarang] + 1)}}</th>
                        @endif

                        @if($sos->id==3)
                            <th>{{round($row->total_growth_ig,2)}} %</th>
                            <th>{{number_format($row->total_ig_sekarang)}}</th>
                            <th style="background:{{$colorIg}}">{{($rankIg6[$row->total_ig_sekarang] + 1)}}</th>
                        @endif

                        @if($sos->id==4)
                            <th>{{round($row->total_growth_yt,2)}} %</th>
                            <th>{{number_format($row->total_yt_sekarang)}}</th>
                            <th style="background:{{$colorYt}}">{{($rankYt6[$row->total_yt_sekarang] + 1)}}</th>
                        @endif
                    @endforeach
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
        $arrYt7=array();
        foreach($rankOverallAccountGroup as $k){
            if($k->group_unit_id==5 || $k->group_unit_id==12){
                foreach($tambahanOverAllTvOthers as $pk){
                    array_push($arrTw7,(string)$pk->total_growth_tw);
                    array_push($arrFb7,(string)$pk->total_growth_fb);
                    array_push($arrIg7,(string)$pk->total_growth_ig);
                    array_push($arrYt7,(string)$pk->total_growth_yt);
                }
            }else{
                array_push($arrTw7,(string)$k->total_growth_tw);
                array_push($arrFb7,(string)$k->total_growth_fb);
                array_push($arrIg7,(string)$k->total_growth_ig);
                array_push($arrYt7,(string)$k->total_growth_yt);
            }
        }
        $rankTw7=$arrTw7;
        $rankFb7=$arrFb7;
        $rankIg7=$arrIg7;
        $rankYt7=$arrYt7;

        rsort($rankTw7);
        rsort($rankFb7);
        rsort($rankIg7);
        rsort($rankYt7);

        $rankTw7=array_flip($rankTw7);
        $rankFb7=array_flip($rankFb7);
        $rankIg7=array_flip($rankIg7);
        $rankYt7=array_flip($rankYt7);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="15%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>Nom Of Growth</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                    <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountGroup as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                ?>
                @if($row->group_unit_id==5 || $row->group_unit_id==12)
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

                        @if(($rankYt7[$pp->total_growth_yt] + 1)==1 || ($rankYt7[$pp->total_growth_yt] + 1)==2 || ($rankYt7[$pp->total_growth_yt] + 1)==3)
                            <?php $colorYt="#f4a018"; ?>
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

                    @if(($rankYt7[$row->total_growth_yt] + 1)==1 || ($rankYt7[$row->total_growth_yt] + 1)==2 || ($rankYt7[$row->total_growth_yt] + 1)==3)
                        <?php $colorYt="#f4a018";?>
                    @endif
                @endif

                <!-- tampil -->
                @if($row->group_unit_id==5 || $row->group_unit_id==12)
                    @foreach($tambahanOverAllTvOthers as $p)
                        <?php 
                            $ctw="";
                            $cfb="";
                            $cig="";
                            $cyt="";
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

                        @if(($rankYt7[$p->total_growth_yt] + 1)==1 || ($rankYt7[$p->total_growth_yt] + 1)==2 || ($rankYt7[$p->total_growth_yt] + 1)==3)
                            <?php $cyt="#f4a018";?>
                        @endif 

                        <tr>
                            <th>{{$p->unit_name}}</th>
                            @foreach($sosmed as $sos)
                                @if($sos->id==1)
                                    <th>{{number_format($p->total_num_of_growth_tw)}}</th>
                                    <th>{{round($p->total_growth_tw,2)}} %</th>
                                    <th style="background:{{$ctw}}">{{($rankTw7[$p->total_growth_tw] + 1)}}</th>
                                @endif

                                @if($sos->id==2)
                                    <th>{{number_format($p->total_num_of_growth_fb)}}</th>
                                    <th>{{round($p->total_growth_fb,2)}} %</th>
                                    <th style="background:{{$cfb}}">{{($rankFb7[$p->total_growth_fb] + 1)}}</th>
                                @endif

                                @if($sos->id==3)
                                    <th>{{number_format($p->total_num_of_growth_ig)}}</th>
                                    <th>{{round($p->total_growth_ig,2)}} %</th>
                                    <th style="background:{{$cig}}">{{($rankIg7[$p->total_growth_ig] + 1)}}</th>
                                @endif

                                @if($sos->id==4)
                                    <th>{{number_format($p->total_num_of_growth_yt)}}</th>
                                    <th>{{round($p->total_growth_yt,2)}} %</th>
                                    <th style="background:{{$cyt}}">{{($rankYt7[$p->total_growth_yt] + 1)}}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th>{{$row->group_name}}</th>
                        @foreach($sosmed as $sos)
                            @if($sos->id==1)
                                <th>{{number_format($row->total_num_of_growth_tw)}}</th>
                                <th>{{round($row->total_growth_tw,2)}} %</th>
                                <th style="background:{{$colorTw}}">{{($rankTw7[$row->total_growth_tw] + 1)}}</th>
                            @endif

                            @if($sos->id==2)
                                <th>{{number_format($row->total_num_of_growth_fb)}}</th>
                                <th>{{round($row->total_growth_fb,2)}} %</th>
                                <th style="background:{{$colorFb}}">{{($rankFb7[$row->total_growth_fb] + 1)}}</th>
                            @endif

                            @if($sos->id==3)
                                <th>{{number_format($row->total_num_of_growth_ig)}}</th>
                                <th>{{round($row->total_growth_ig,2)}} %</th>
                                <th style="background:{{$colorIg}}">{{($rankIg7[$row->total_growth_ig] + 1)}}</th>
                            @endif

                            @if($sos->id==4)
                                <th>{{number_format($row->total_num_of_growth_yt)}}</th>
                                <th>{{round($row->total_growth_yt,2)}} %</th>
                                <th style="background:{{$colorYt}}">{{($rankYt7[$row->total_growth_yt] + 1)}}</th>
                            @endif
                        @endforeach
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
        $arrYt8=array();
        foreach($rankOverallAccountAllTv as $k){
            array_push($arrTw8,(string)$k->total_growth_tw);
            array_push($arrFb8,(string)$k->total_growth_fb);
            array_push($arrIg8,(string)$k->total_growth_ig);
            array_push($arrYt8,(string)$k->total_growth_yt);
        }
        $rankTw8=$arrTw8;
        $rankFb8=$arrFb8;
        $rankIg8=$arrIg8;
        $rankYt8=$arrYt8;

        rsort($rankTw8);
        rsort($rankFb8);
        rsort($rankIg8);
        rsort($rankYt8);

        $rankTw8=array_flip($rankTw8);
        $rankFb8=array_flip($rankFb8);
        $rankIg8=array_flip($rankIg8);
        $rankYt8=array_flip($rankYt8);
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th width="18%" rowspan='2' style="background:#419F51;color:white" class="text-center">Channel</th>
                @foreach($sosmed as $sos)
                    <th colspan='3' class='text-center' class='text-center' style='background:{{$sos->sosmed_color}};color:white'>{{$sos->sosmed_name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $sos)
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>Num Of Growth</th>
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>% Growth</th>
                <th class='text-center' style='background:{{$sos->sosmed_color}};color:white'>RANK</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rankOverallAccountAllTv as $row)
                <?php
                    $colorTw="";
                    $colorFb="";
                    $colorIg="";
                    $colorYt="";
                    
                    if(($rankTw8[$row->total_growth_tw] + 1)==1 || ($rankTw8[$row->total_growth_tw] + 1)==2 || ($rankTw8[$row->total_growth_tw] + 1)==3){
                        $colorTw="#f4a018";
                    }

                    if(($rankFb8[$row->total_growth_fb] + 1)==1 || ($rankFb8[$row->total_growth_fb] + 1)==2 || ($rankFb8[$row->total_growth_fb] + 1)==3){
                        $colorFb="#f4a018";
                    }

                    if(($rankIg8[$row->total_growth_ig] + 1)==1 || ($rankIg8[$row->total_growth_ig] + 1)==2 || ($rankIg8[$row->total_growth_ig] + 1)==3){
                        $colorIg="#f4a018";
                    }

                    if(($rankYt8[$row->total_growth_yt] + 1)==1 || ($rankYt8[$row->total_growth_yt] + 1)==2 || ($rankYt8[$row->total_growth_yt] + 1)==3){
                        $colorYt="#f4a018";
                    }
                ?>
                <tr>
                    <th>{{$row->unit_name}}</th>
                    @foreach($sosmed as $sos)
                        @if($sos->id==1)
                            <th>{{number_format($row->total_num_of_growth_tw)}}</th>
                            <th>{{round($row->total_growth_tw,2)}} %</th>
                            <th style="background:{{$colorTw}}">{{($rankTw8[$row->total_growth_tw] + 1)}}</th>
                        @endif

                        @if($sos->id==2)
                            <th>{{number_format($row->total_num_of_growth_fb)}}</th>
                            <th>{{round($row->total_growth_fb,2)}} %</th>
                            <th style="background:{{$colorFb}}">{{($rankFb8[$row->total_growth_fb] + 1)}}</th>
                        @endif

                        @if($sos->id==3)
                            <th>{{number_format($row->total_num_of_growth_ig)}}</th>
                            <th>{{round($row->total_growth_ig,2)}} %</th>
                            <th style="background:{{$colorIg}}">{{($rankIg8[$row->total_growth_ig] + 1)}}</th>
                        @endif

                        @if($sos->id==4)
                            <th>{{number_format($row->total_num_of_growth_yt)}}</th>
                            <th>{{round($row->total_growth_yt,2)}} %</th>
                            <th style="background:{{$colorYt}}">{{($rankYt8[$row->total_growth_yt] + 1)}}</th>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>