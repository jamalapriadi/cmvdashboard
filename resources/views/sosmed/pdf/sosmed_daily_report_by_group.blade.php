<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socmed Daily Report {{date('d-m-Y')}}</title>
    @php 
        if(count($sosmed)>3){
            $besar=20+(15*count($sosmed));
        }else{
            $besar=30+(20*count($sosmed));
        }
    @endphp
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
            width: {{$besar}}%;
            margin: 0px auto;
        }
        th{
            text-align:center;
        }

        th, td {
            padding: 6px;
        }

        .text-center{
            text-align:center;
        }

        i {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }

        .right {
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
        }

        .left {
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
        }

        .up {
            transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            color:green;
        }

        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            color:red;
        }

        .icon-arrow-up16{
            
        }
    </style>
</head>
<body>
    <div style="margin-top:40%;"></div>
    <h1 class="text-center">{{strtoupper($groupnya->group_name)}} SOCMED & YOUTUBE REPORT</h1>
    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} )</p>

    <div class="page-break"></div>


    <h3 class="text-center">OFFICIAL ACCOUNT ALL {{strtoupper($groupnya->group_name)}}</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white" rowspan="2">
                    @if($typeunit==1)
                        Channel
                    @elseif($typeunit==3)
                        Station
                    @elseif($typeunit==2)
                        Website
                    @elseif($typeunit==4)
                        SMN Artist
                    @else 
                        Channel
                    @endif
                </th>
                @foreach($sosmed as $row)
                    @if($row->id!=4 && $row->id!=5)
                        <th width="20%" colspan="3" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $row)
                    @if($row->id!=4 && $row->id!=5)
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$kemarin}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$sekarang}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">
            $listTotal=[];
            @foreach($officialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_unit_id!=12)
                        @if($of->type_unit!="TOTAL")
                            <?php 
                                $nama="TOTAL ".$of->name;
                                $color="background:#f2eff2;color:#222;font-weight:700";
                            ?>

                            <tr style="{{$color}}">
                                <td>
                                    {{strtoupper($nama)}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->tw_kemarin)}}</td>
                                        <td>{{number_format($of->tw_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->fb_kemarin)}}</td>
                                        <td>{{number_format($of->fb_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->ig_kemarin)}}</td>
                                        <td>{{number_format($of->ig_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    <!-- @if($row->id==4)
                                        <td>{{number_format($of->yt_kemarin)}}</td>
                                        <td>{{number_format($of->yt_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_yt>0)
                                                <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif -->
                                @endforeach
                            </tr>    
                        @endif 
                    @endif
                @else 
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    @if($of->group_unit_id!=12)
                        <tr style="{{$color}}">
                            <td>
                                {{strtoupper($nama)}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td>{{number_format($of->tw_kemarin)}}</td>
                                    <td>{{number_format($of->tw_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_tw>0)
                                            <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==2)
                                    <td>{{number_format($of->fb_kemarin)}}</td>
                                    <td>{{number_format($of->fb_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_fb>0)
                                            <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==3)
                                    <td>{{number_format($of->ig_kemarin)}}</td>
                                    <td>{{number_format($of->ig_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_ig>0)
                                            <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                <!-- @if($row->id==4)
                                    <td>{{number_format($of->yt_kemarin)}}</td>
                                    <td>{{number_format($of->yt_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_yt>0)
                                            <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                        @endif
                                    </td>
                                @endif -->
                            @endforeach
                        </tr>
                    @endif

                    <!-- menampilkan tambahan inews -->
                    @if($of->id==4)
                        @foreach($tambahanInews as $t)
                            @if($t->id!="TOTAL")
                                <tr>
                                    <td style='color:red'>{{$t->program_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($t->tw_kemarin)}}</td>
                                            <td>{{number_format($t->tw_sekarang)}}</td>
                                            <td>
                                                @if($t->growth_tw>0)
                                                    <a style="color:green;"> {{round($t->growth_tw,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($t->growth_tw,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($t->fb_kemarin)}}</td>
                                            <td>{{number_format($t->fb_sekarang)}}</td>
                                            <td>
                                                @if($t->growth_fb>0)
                                                    <a style="color:green;"> {{round($t->growth_fb,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($t->growth_fb,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($t->ig_kemarin)}}</td>
                                            <td>{{number_format($t->ig_sekarang)}}</td>
                                            <td>
                                                @if($t->growth_ig>0)
                                                    <a style="color:green;"> {{round($t->growth_ig,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($t->growth_ig,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        <!-- @if($row->id==4)
                                            <td>{{number_format($t->yt_kemarin)}}</td>
                                            <td>{{number_format($t->yt_sekarang)}}</td>
                                            <td>
                                                @if($t->growth_yt>0)
                                                    <a style="color:green;"> {{round($t->growth_yt,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($t->growth_yt,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    <!-- end menampilkan tambahan inews -->

                @endif
            @endforeach

            @php 
                $kurang_tw_kemarin=0;
                $kurang_tw_sekarang=0;
                $kurang_fb_kemarin=0;
                $kurang_fb_sekarang=0;
                $kurang_ig_kemarin=0;
                $kurang_ig_sekarang=0;
                $kurang_yt_kemarin=0;
                $kurang_yt_sekarang=0;
            @endphp

            @if($groupnya->id==1)
                @foreach($inewsid as $row)
                    @php 
                        $kurang_tw_kemarin+=$row->tw_kemarin;
                        $kurang_tw_sekarang+=$row->tw_sekarang;
                        $kurang_fb_kemarin+=$row->fb_kemarin;
                        $kurang_fb_sekarang+=$row->fb_sekarang;
                        $kurang_ig_kemarin+=$row->ig_kemarin;
                        $kurang_ig_sekarang+=$row->ig_sekarang;
                        $kurang_yt_kemarin+=$row->yt_kemarin;
                        $kurang_yt_sekarang+=$row->yt_sekarang;
                    @endphp 
                @endforeach
            @endif

            @foreach($officialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->type_unit=="TOTAL")
                        <?php 
                            $nama="TOTAL ".strtoupper($groupnya->group_name);
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>

                        <tr style="{{$color}}">
                            <td>
                                {{strtoupper($nama)}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td>{{number_format( ($of->tw_kemarin - $kurang_tw_kemarin))}}</td>
                                    <td>{{number_format( ($of->tw_sekarang - $kurang_tw_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_tw>0)
                                            <a style="color:white;"> {{round($of->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==2)
                                <td>{{number_format( ($of->fb_kemarin - $kurang_fb_kemarin))}}</td>
                                    <td>{{number_format( ($of->fb_sekarang - $kurang_fb_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_fb>0)
                                            <a style="color:white;"> {{round($of->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==3)
                                    <td>{{number_format( ($of->ig_kemarin - $kurang_ig_kemarin))}}</td>
                                    <td>{{number_format( ($of->ig_sekarang - $kurang_ig_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_ig>0)
                                            <a style="color:white;"> {{round($of->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                <!-- @if($row->id==4)
                                    <td>{{number_format( ($of->yt_kemarin - $kurang_yt_kemarin))}}</td>
                                    <td>{{number_format( ($of->yt_sekarang - $kurang_yt_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_yt>0)
                                            <a style="color:white;"> {{round($of->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                        @endif
                                    </td>
                                @endif -->
                            @endforeach
                        </tr>    
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OVERALL ALL {{strtoupper($groupnya->group_name)}}</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white" rowspan="2">
                    @if($typeunit==1)
                        Channel
                    @elseif($typeunit==3)
                        Station
                    @elseif($typeunit==2)
                        Website
                    @elseif($typeunit==4)
                        SMN Artist
                    @else 
                        Channel
                    @endif
                </th>
                @foreach($sosmed as $row)
                    @if($row->id!=5)
                        <th width="20%" colspan="3" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $row)
                    @if($row->id!=5)
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$kemarin}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$sekarang}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">
            $listTotal=[];
            @foreach($overallOfficialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->type_unit!="TOTAL")
                        @if($of->group_unit_id!=12)
                            <?php 
                                $nama="TOTAL ".$of->name;
                                $color="background:#f2eff2;color:#222;font-weight:700";
                            ?>

                            <tr style="{{$color}}">
                                <td>
                                    {{strtoupper($nama)}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->tw_kemarin)}}</td>
                                        <td>{{number_format($of->tw_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->fb_kemarin)}}</td>
                                        <td>{{number_format($of->fb_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->ig_kemarin)}}</td>
                                        <td>{{number_format($of->ig_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->yt_kemarin)}}</td>
                                        <td>{{number_format($of->yt_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_yt>0)
                                                <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>    
                        @endif
                    @endif 
                @else 
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    <tr style="{{$color}}">
                        <td>
                            {{strtoupper($nama)}}
                        </td>
                        @foreach($sosmed as $row)
                            @if($row->id==1)
                                <td>{{number_format($of->tw_kemarin)}}</td>
                                <td>{{number_format($of->tw_sekarang)}}</td>
                                <td>
                                    @if($of->growth_tw>0)
                                        <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                    @else
                                        <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                    @endif
                                </td>
                            @endif

                            @if($row->id==2)
                                <td>{{number_format($of->fb_kemarin)}}</td>
                                <td>{{number_format($of->fb_sekarang)}}</td>
                                <td>
                                    @if($of->growth_fb>0)
                                        <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                    @else
                                        <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                    @endif
                                </td>
                            @endif

                            @if($row->id==3)
                                <td>{{number_format($of->ig_kemarin)}}</td>
                                <td>{{number_format($of->ig_sekarang)}}</td>
                                <td>
                                    @if($of->growth_ig>0)
                                        <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                    @else
                                        <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                    @endif
                                </td>
                            @endif

                            @if($row->id==4)
                                <td>{{number_format($of->yt_kemarin)}}</td>
                                <td>{{number_format($of->yt_sekarang)}}</td>
                                <td>
                                    @if($of->growth_yt>0)
                                        <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                    @else
                                        <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endif
            @endforeach

            @foreach($overallOfficialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->type_unit=="TOTAL")
                        <?php 
                            $nama="TOTAL ".strtoupper($groupnya->group_name);
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>

                        <tr style="{{$color}}">
                            <td>
                                {{strtoupper($nama)}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td>{{number_format( ($of->tw_kemarin - $kurang_tw_kemarin))}}</td>
                                    <td>{{number_format( ($of->tw_sekarang - $kurang_tw_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_tw>0)
                                            <a style="color:white;"> {{round($of->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==2)
                                <td>{{number_format( ($of->fb_kemarin - $kurang_fb_kemarin))}}</td>
                                    <td>{{number_format( ($of->fb_sekarang - $kurang_fb_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_fb>0)
                                            <a style="color:white;"> {{round($of->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==3)
                                    <td>{{number_format( ($of->ig_kemarin - $kurang_ig_kemarin))}}</td>
                                    <td>{{number_format( ($of->ig_sekarang - $kurang_ig_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_ig>0)
                                            <a style="color:white;"> {{round($of->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==4)
                                    <td>{{number_format( ($of->yt_kemarin - $kurang_yt_kemarin))}}</td>
                                    <td>{{number_format( ($of->yt_sekarang - $kurang_yt_sekarang))}}</td>
                                    <td>
                                        @if($of->growth_yt>0)
                                            <a style="color:white;"> {{round($of->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>  
                    @endif
                @endif
            @endforeach

            @if($adaartis=="ya")
                @foreach($smnchannel as $key=>$of)
                    @if($of->id=="SUBTOTAL")
                        @if($of->type_unit!="TOTAL")
                            <?php 
                                $nama="TOTAL ".$of->name;
                                $color="background:#419F51;color:white;font-weight:700";
                            ?>

                            <tr style="{{$color}}">
                                <td>
                                    {{strtoupper($nama)}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->tw_kemarin)}}</td>
                                        <td>{{number_format($of->tw_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_tw>0)
                                                <a style="color:white;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->fb_kemarin)}}</td>
                                        <td>{{number_format($of->fb_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_fb>0)
                                                <a style="color:white;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->ig_kemarin)}}</td>
                                        <td>{{number_format($of->ig_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_ig>0)
                                                <a style="color:white;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->yt_kemarin)}}</td>
                                        <td>{{number_format($of->yt_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_yt>0)
                                                <a style="color:white;"> {{round($of->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>    
                        @endif 
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>