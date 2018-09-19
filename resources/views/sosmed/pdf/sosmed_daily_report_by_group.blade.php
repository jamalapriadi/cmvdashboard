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
    <h1 class="text-center">MNC GROUP SOCMED & YOUTUBE REPORT</h1>
    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} )</p>

    <div class="page-break"></div>


    <h3 class="text-center">OFFICIAL ACCOUNT ALL MNC GROUP</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white" rowspan="2">
                    @if($typeunit=="TV")
                        Channel
                    @elseif($typeunit=="Radio")
                        Station
                    @elseif($typeunit=="Publisher")
                        Website
                    @elseif($typeunit=="KOL")
                        SMN Artist
                    @else 
                        {{$typeunit}}
                    @endif
                </th>
                @foreach($sosmed as $row)
                    @if($row->id!=4)
                        <th width="20%" colspan="3" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $row)
                    @if($row->id!=4)
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
                    @if($of->group_id=="TOTAL")
                    <?php 
                            $nama="TOTAL ".strtoupper($of->type_unit);
                            // $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";

                            $listTotal[]=array(
                                'nama'=>'Total MNC Group',
                                'tw_kemarin'=>$of->tw_kemarin,
                                'tw_sekarang'=>$of->tw_sekarang,
                                'growt_tw'=>round($of->growth_tw,2),
                                'fb_kemarin'=>$of->fb_kemarin,
                                'fb_sekarang'=>$of->fb_sekarang,
                                'growt_fb'=>round($of->growth_fb,2),
                                'ig_kemarin'=>$of->ig_kemarin,
                                'ig_sekarang'=>$of->ig_sekarang,
                                'growt_ig'=>round($of->growth_ig,2),
                                'yt_kemarin'=>$of->yt_kemarin,
                                'yt_sekarang'=>$of->yt_sekarang,
                                'growt_yt'=>round($of->growth_yt,2)
                            );
                        ?>

                        @if($of->group_id==1)
                            <!-- menampilkan total group mncgroup di publisher -->
                            @if($typeunit=="Publisher")
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
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
                                            <td>{{number_format($of->yt_sekarang)}}</td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                            <!-- end menampilkan total group mncgroup di publisher -->

                            <!-- tambahkan untuk inews -->
                            @for($a=0;$a<count($tambahanInews);$a++)
                                @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->group_unit_id==$of->group_id)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin)}}</td>
                                                <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                                <td>
                                                    @if(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100) > 0)
                                                        <a style="color:green;"> {{round(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin)}}</td>
                                                <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                                <td>
                                                    @if(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100) > 0)
                                                        <a style="color:green;"> {{round(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin)}}</td>
                                                <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                                <td>
                                                    @if(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100) > 0)
                                                        <a style="color:green;"> {{round(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            <!-- @if($row->id==4)
                                                <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                            @endif -->
                                        @endforeach
                                    </tr>
                                @endif
                            @endfor
                        @else  
                            <!-- menampilkan total group selain others --> 
                            @if($of->group_id!=5)
                                @if($of->group_id!=12)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
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
                                                    @if($of->growth_tw>0)
                                                        <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($of->ig_kemarin)}}</td>
                                                <td>{{number_format($of->ig_sekarang)}}</td>
                                                <td>
                                                    @if($of->growth_tw>0)
                                                        <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            <!-- @if($row->id==4)
                                                <td>{{number_format($of->yt_sekarang)}}</td>
                                            @endif -->
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                            <!-- menampilkan total group selain others -->
                        @endif
                    @else    
                        
                    @endif
                @else 
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    @if($of->id==4)
                        @for($a=0;$a<count($tambahanInews);$a++)
                            @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->business_unit_id==$of->id)
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
                                    </td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin)}}</td>
                                            <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                            <td>
                                                @if(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100) > 0)
                                                    <a style="color:green;"> {{round(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100),2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round(((($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang) / ($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin) - 1) * 100),2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin)}}</td>
                                            <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                            <td>
                                                @if(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100) > 0)
                                                    <a style="color:green;"> {{round(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100),2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round(((($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang) / ($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin) - 1) * 100),2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin)}}</td>
                                            <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                            <td>
                                                @if(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100) > 0)
                                                    <a style="color:green;"> {{round(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100),2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round(((($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang) / ($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin) - 1) * 100),2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        <!-- @if($row->id==4)
                                            <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                        @endfor

                    @else
                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
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
                                    <td>{{number_format($of->yt_sekarang)}}</td>
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
                                            <td>{{number_format($t->yt_sekarang)}}</td>
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
                $pertama=0;
                $pertama2=0;
                $kedua=0;
                $kedua2=0;
                $ketiga=0;
                $ketiga2=0;
                $keempat=0;
            @endphp
            @foreach($listTotal as $key=>$val)
                @php
                    $pertama2+=$val['tw_kemarin']; 
                    $pertama+=$val['tw_sekarang'];
                    $kedua+=$val['fb_sekarang'];
                    $kedua2+=$val['fb_kemarin'];
                    $ketiga+=$val['ig_sekarang'];
                    $ketiga2+=$val['ig_kemarin'];
                    $keempat+=$val['yt_sekarang'];
                @endphp 
            @endforeach
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL MNC GROUP</td>
                <td>{{number_format($pertama2)}}</td>
                <td>{{number_format($pertama)}}</td>
                <td>
                    @if((($pertama / $pertama2 )- 1) * 100)
                        <a style="color:white;" class="text-white"> {{round((($pertama / $pertama2 )- 1) * 100,2)}} % </a>
                    @else
                        <a style="color:red;" class="text-white"> {{round((($pertama / $pertama2 )- 1) * 100,2)}} % </a>
                    @endif
                </td>
                <td>{{number_format($kedua2)}}</td>
                <td>{{number_format($kedua)}}</td>
                <td>
                    @if((($kedua / $kedua2 )- 1) * 100)
                        <a style="color:white;" class="text-white"> {{round((($kedua / $kedua2 )- 1) * 100,2)}} % </a>
                    @else
                        <a style="color:red;" class="text-white"> {{round((($kedua / $kedua2 )- 1) * 100,2)}} % </a>
                    @endif
                </td>
                <td>{{number_format($ketiga2)}}</td>
                <td>{{number_format($ketiga)}}</td>
                <td>
                    @if((($ketiga / $ketiga2 )- 1) * 100)
                        <a style="color:white;" class="text-white"> {{round((($ketiga / $ketiga2 )- 1) * 100,2)}} % </a>
                    @else
                        <a style="color:red;" class="text-white"> {{round((($ketiga / $ketiga2 )- 1) * 100,2)}} % </a>
                    @endif
                </td>
                <!-- <td>{{number_format($keempat)}}</td> -->
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OVERALL ALL  MNC GROUP</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" rowspan="2" class="align-middle text-white">
                    @if($typeunit=="TV")
                        Channel
                    @elseif($typeunit=="Radio")
                        Station
                    @elseif($typeunit=="Publisher")
                        Website
                    @elseif($typeunit=="KOL")
                        Artists
                    @else 
                        {{$typeunit}}
                    @endif
                </th>
                @foreach($sosmed as $row)
                    <th colspan="3" class='text-center' width="20%" style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($sosmed as $row)
                    <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$kemarin}}</th>
                    <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$sekarang}}</th>
                    <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">
            @php 
                $listprogram=array();
                $listtotal=array();
                $total2=array();
                $totalKol=array();
            @endphp
            @foreach($overallOfficialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>
                    @else    
                        <?php 
                            $nama="TOTAL ".strtoupper($of->type_unit);
                            $color="background:#f2eff2;color:#222;font-weight:700";

                            if($of->type_unit!="KOL"){
                                $total2[]=array(
                                    'nama'=>'Total MNC Group',
                                    'tw_kemarin'=>$of->total_tw_kemarin,
                                    'tw_sekarang'=>$of->total_tw_sekarang,
                                    'growth_tw'=>$of->total_growth_tw,
                                    'fb_kemarin'=>$of->total_fb_kemarin,
                                    'fb_sekarang'=>$of->total_fb_sekarang,
                                    'growth_fb'=>$of->total_growth_fb,
                                    'ig_kemarin'=>$of->total_ig_kemarin,
                                    'ig_sekarang'=>$of->total_ig_sekarang,
                                    'growth_ig'=>$of->total_growth_ig,
                                    'yt_kemarin'=>$of->total_yt_kemarin,
                                    'yt_sekarang'=>$of->total_yt_sekarang,
                                    'growth_yt'=>$of->total_growth_yt
                                );
                            }else{
                                $totalKol[]=array(
                                    'nama'=>'Total KOL',
                                    'tw_kemarin'=>$of->total_tw_kemarin,
                                    'tw_sekarang'=>$of->total_tw_sekarang,
                                    'growth_tw'=>$of->total_growth_tw,
                                    'fb_kemarin'=>$of->total_fb_kemarin,
                                    'fb_sekarang'=>$of->total_fb_sekarang,
                                    'growth_fb'=>$of->total_growth_fb,
                                    'ig_kemarin'=>$of->total_ig_kemarin,
                                    'ig_sekarang'=>$of->total_ig_sekarang,
                                    'growth_ig'=>$of->total_growth_ig,
                                    'yt_kemarin'=>$of->total_yt_kemarin,
                                    'yt_sekarang'=>$of->total_yt_sekarang,
                                    'growth_yt'=>$of->total_growth_yt
                                );
                            }
                        ?>

                        <!--tampilkan totalnya kecuali yang dari group others -->
                        @if($of->group_id!=5)
                            @if($of->group_id!=12)
                                @if($of->type_unit!="KOL")
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($of->total_tw_kemarin)}}</td>
                                                <td>{{number_format($of->total_tw_sekarang)}}</td>
                                                <td>
                                                    @if($of->total_growth_tw>0)
                                                        <a style="color:green;"> {{round($of->total_growth_tw,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->total_growth_tw,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($of->total_fb_kemarin)}}</td>
                                                <td>{{number_format($of->total_fb_sekarang)}}</td>
                                                <td>
                                                    @if($of->total_growth_fb>0)
                                                        <a style="color:green;"> {{round($of->total_growth_fb,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->total_growth_fb,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($of->total_ig_kemarin)}}</td>
                                                <td>{{number_format($of->total_ig_sekarang)}}</td>
                                                <td>
                                                    @if($of->total_growth_ig>0)
                                                        <a style="color:green;"> {{round($of->total_growth_ig,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->total_growth_ig,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==4)
                                                <td>{{number_format($of->total_yt_kemarin)}}</td>
                                                <td>{{number_format($of->total_yt_sekarang)}}</td>
                                                <td>
                                                    @if($of->total_growth_yt>0)
                                                        <a style="color:green;"> {{round($of->total_growth_yt,2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round($of->total_growth_yt,2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                            
                        @endif
                    @endif
                @else 
                    <!--jika unitnya adalah other publisher, maka data disimpan ke array dulu, karena nantinya
                    data ini akan ditampilkan di list paling bawah -->
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    @if($of->group_id!=12)
                        <!--tampilkan unitnya -->
                        @if($of->type_unit!="KOL")
                            <tr style="{{$color}}">
                                <td>
                                    {{$nama}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->total_tw_kemarin)}}</td>
                                        <td>{{number_format($of->total_tw_sekarang)}}</td>
                                        <td>
                                            @if($of->total_growth_tw>0)
                                                <a style="color:green;"> {{round($of->total_growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->total_growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->total_fb_kemarin)}}</td>
                                        <td>{{number_format($of->total_fb_sekarang)}}</td>
                                        <td>
                                            @if($of->total_growth_fb>0)
                                                <a style="color:green;"> {{round($of->total_growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->total_growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->total_ig_kemarin)}}</td>
                                        <td>{{number_format($of->total_ig_sekarang)}}</td>
                                        <td>
                                            @if($of->total_growth_ig>0)
                                                <a style="color:green;"> {{round($of->total_growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->total_growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->total_yt_kemarin)}}</td>
                                        <td>{{number_format($of->total_yt_sekarang)}}</td>
                                        <td>
                                            @if($of->total_growth_yt>0)
                                                <a style="color:green;"> {{round($of->total_growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->total_growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @else 
                        <!--simpan unit other publisher ke dalam array -->
                        @php 
                            if($of->type_unit!="KOL"){
                                $listprogram[]=array(
                                    'nama'=>$nama,
                                    'color'=>$color,

                                    'tw_kemarin'=>number_format($of->total_tw_kemarin),
                                    'tw_sekarang'=>number_format($of->total_tw_sekarang),
                                    'growth_tw'=>round($of->total_growth_tw,2),

                                    'fb_kemarin'=>number_format($of->total_fb_kemarin),
                                    'fb_sekarang'=>number_format($of->total_fb_sekarang),
                                    'growth_fb'=>round($of->total_growth_fb,2),

                                    'ig_kemarin'=>number_format($of->total_ig_kemarin),
                                    'ig_sekarang'=>number_format($of->total_ig_sekarang),
                                    'growth_ig'=>round($of->total_growth_ig,2),

                                    'yt_kemarin'=>number_format($of->total_yt_kemarin),
                                    'yt_sekarang'=>number_format($of->total_yt_sekarang),
                                    'growth_yt'=>round($of->total_growth_yt,2)
                                );
                            }
                        @endphp 
                    @endif

                @endif
            @endforeach
            
            @foreach($listprogram as $l)
                <tr style="{{$l['color']}}">
                    <td>{{$l['nama']}}</td>
                    @foreach($sosmed as $row)
                        @if($row->id==1)
                            <td>{{$l['tw_kemarin']}}</td>
                            <td>{{$l['tw_sekarang']}}</td>
                            <td>
                                @if($l['growth_tw']>0)
                                    <a style="color:green;"> {{round($l['growth_tw'],2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($l['growth_tw'],2)}} % </a>
                                @endif
                            </td>
                        @endif

                        @if($row->id==2)
                            <td>{{$l['fb_kemarin']}}</td>
                            <td>{{$l['fb_sekarang']}}</td>
                            <td>
                                @if($l['growth_fb']>0)
                                    <a style="color:green;"> {{round($l['growth_fb'],2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($l['growth_fb'],2)}} % </a>
                                @endif
                            </td>
                        @endif

                        @if($row->id==3)
                            <td>{{$l['ig_kemarin']}}</td>
                            <td>{{$l['ig_sekarang']}}</td>
                            <td>
                                @if($l['growth_ig']>0)
                                    <a style="color:green;"> {{round($l['growth_ig'],2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($l['growth_ig'],2)}} % </a>
                                @endif
                            </td>
                        @endif

                        @if($row->id==4)
                            <td>{{$l['yt_kemarin']}}</td>
                            <td>{{$l['yt_sekarang']}}</td>
                            <td>
                                @if($l['growth_yt']>0)
                                    <a style="color:green;"> {{round($l['growth_yt'],2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($l['growth_yt'],2)}} % </a>
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach

            @php 
                $pertama3=0;
                $pertama33=0;
                $pertama333=0;
                $kedua3=0;
                $kedua33=0;
                $kedua333=0;
                $ketiga3=0;
                $ketiga33=0;
                $ketiga333=0;
                $keempat33=0;
                $keempat3=0;
                $keempat333=0;
            @endphp
            @foreach($total2 as $key=>$val)
                @php
                    $pertama33+=$val['tw_kemarin']; 
                    $pertama3+=$val['tw_sekarang'];
                    $pertama33+=$val['growth_tw'];
                    $kedua33+=$val['fb_kemarin']; 
                    $kedua3+=$val['fb_sekarang'];
                    $kedua33+=$val['growth_fb'];
                    $ketiga33+=$val['ig_kemarin']; 
                    $ketiga3+=$val['ig_sekarang'];
                    $ketiga33+=$val['growth_ig'];
                    $keempat33+=$val['yt_kemarin'];
                    $keempat3+=$val['yt_sekarang'];
                    $keempat333+=$val['growth_yt'];
                @endphp 
            @endforeach
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL MNC GROUP</td>
                <td>{{number_format($pertama33)}}</td>
                <td>{{number_format($pertama3)}}</td>
                <td>
                    @if($pertama333>0)
                        <a style="color:white;"> {{round($pertama333,2)}} % </a>
                    @else
                        <a style="color:red;"> {{round($pertama333,2)}} % </a>
                    @endif
                </td>
                <td>{{number_format($kedua33)}}</td>
                <td>{{number_format($kedua3)}}</td>
                <td>
                    @if($kedua333>0)
                        <a style="color:white;"> {{round($kedua333,2)}} % </a>
                    @else
                        <a style="color:red;"> {{round($kedua333,2)}} % </a>
                    @endif
                </td>
                <td>{{number_format($ketiga33)}}</td>
                <td>{{number_format($ketiga3)}}</td>
                <td>
                    @if($ketiga333>0)
                        <a style="color:white;"> {{round($ketiga333,2)}} % </a>
                    @else
                        <a style="color:red;"> {{round($ketiga333,2)}} % </a>
                    @endif
                </td>
                <td>{{number_format($keempat33)}}</td>
                <td>{{number_format($keempat3)}}</td>
                <td>
                    @if($keempat333>0)
                        <a style="color:white;"> {{round($keempat333,2)}} % </a>
                    @else
                        <a style="color:red;"> {{round($keempat333,2)}} % </a>
                    @endif
                </td>
            </tr>
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL SMN ARTIST</td>
                @foreach($totalKol as $k)
                    <td>{{number_format($k['tw_kemarin'])}}</td>
                    <td>{{number_format($k['tw_sekarang'])}}</td>
                    <td>
                        @if($k['growth_tw']>0)
                            <a style="color:white;"> {{round($k['growth_tw'],2)}} % </a>
                        @else
                            <a style="color:red;"> {{round($k['growth_tw'],2)}} % </a>
                        @endif
                    </td>
                    <td>{{number_format($k['fb_kemarin'])}}</td>
                    <td>{{number_format($k['fb_sekarang'])}}</td>
                    <td>
                        @if($k['growth_fb']>0)
                            <a style="color:white;"> {{round($k['growth_fb'],2)}} % </a>
                        @else
                            <a style="color:red;"> {{round($k['growth_fb'],2)}} % </a>
                        @endif
                    </td>
                    <td>{{number_format($k['ig_kemarin'])}}</td>
                    <td>{{number_format($k['ig_sekarang'])}}</td>
                    <td>
                        @if($k['growth_ig']>0)
                            <a style="color:white;"> {{round($k['growth_ig'],2)}} % </a>
                        @else
                            <a style="color:red;"> {{round($k['growth_ig'],2)}} % </a>
                        @endif
                    </td>
                    <td>{{number_format($k['yt_kemarin'])}}</td>
                    <td>{{number_format($k['yt_sekarang'])}}</td>
                    <td>
                        @if($k['growth_yt']>0)
                            <a style="color:white;"> {{round($k['growth_yt'],2)}} % </a>
                        @else
                            <a style="color:red;"> {{round($k['growth_yt'],2)}} % </a>
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>