<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socmed {{$typereport}} Report {{date('d-m-Y')}}</title>
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
    @if(count($sosmed)<2)
        @foreach($sosmed as $row)
            @if($row->id==4)
                <h1 class="text-center">
                    @if($typeunit==2)
                        {{strtoupper($mtype->name)}} YOUTUBE REPORT
                    @else 
                        {{strtoupper($mtype->name)}} YOUTUBE REPORT
                    @endif
                </h1>
            @else 
                <h1 class="text-center">
                    @if($typeunit==2)
                        {{strtoupper($mtype->name)}} {{strtoupper($row->sosmed_name)}} REPORT
                    @else 
                        {{strtoupper($mtype->name)}} {{strtoupper($row->sosmed_name)}} REPORT
                    @endif
                </h1>
            @endif
        @endforeach
    @elseif(count($sosmed)>3)
        @if($typeunit==1)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit==3)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit==2)
            <h1 class="text-center">{{strtoupper($mtype->name)}} & YOUTUBE REPORT</h1>
        @elseif($typeunit==4)
            <h1 class="text-center">{{strtoupper($mtype->name)}} & YOUTUBE REPORT</h1>
        @else
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @endif
    @else 
        @if($typeunit==1)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED {{$typereport}} REPORT</h1>
        @elseif($typeunit==3)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED REPORT</h1>
        @elseif($typeunit==2)
            <h1 class="text-center">{{strtoupper($mtype->name)}} REPORT</h1>
        @elseif($typeunit==4)
            <h1 class="text-center">{{strtoupper($mtype->name)}} REPORT</h1>
        @else
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @endif
    @endif
    
    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} vs {{date('d-m-Y',strtotime($kemarin))}} )</p>

    <div class="page-break"></div>

    <!-- jika youtube maka tidak ada official -->
    @php $youtubedoang="tidak"; @endphp 
    @if(count($sosmed)<=1)
        @foreach($sosmed as $row)
            @if($row->id==4)
                @php $youtubedoang="ya"; @endphp
            @else 
                @php $youtubedoang="tidak"; @endphp
            @endif
        @endforeach
    @endif
    
    @if($youtubedoang!="ya")
        <h3 class="text-center">OFFICIAL ACCOUNT ALL {{strtoupper($mtype->name)}}</h3>
        <br>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">
                        Channel
                    </th>
                    @foreach($sosmed as $row)
                        @if($row->id==1)
                            <th colspan='3' width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                        @endif 

                        @if($row->id==2)
                            <th colspan='3' width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                        @endif 

                        @if($row->id==3)
                            <th colspan='3' width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                        @endif 
                    @endforeach
                </tr>
                <tr>
                    @foreach($sosmed as $row)
                        @if($row->id==1)
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                        @endif 

                        @if($row->id==2)
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                        @endif 

                        @if($row->id==3)
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                            <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                        @endif 
                    @endforeach
                </tr>
            </thead>
            <tbody style="color:#222">
                @php $no=0; @endphp
                @foreach($officialTv as $key=>$of)
                    @if($of->id=="SUBTOTAL")
                        @if($of->group_id=="TOTAL")
                            
                        @else 
                            @if($of->group_id!=12)
                                <tr style="background:#f2eff2;color:#222;font-weight:700">
                                    <td>{{$of->group_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_tw>0)
                                                    <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_fb>0)
                                                    <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_ig>0)
                                                    <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @endif
                    @else 
                        @if($of->group_id!=12)
                            <tr style="">
                                <td>
                                    {{$of->unit_name}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endif
                @endforeach

                @foreach($officialTv as $key=>$of)
                    @if($of->group_id==12)
                        @if($of->id!="SUBTOTAL")
                            <tr style="">
                                <td>
                                    {{$of->unit_name}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endif
                @endforeach

                @foreach($officialTv as $key=>$of)
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                            $satu_tw=0;
                            $satu_fb=0;
                            $satu_ig=0;
                            $satu_yt=0;

                            $pembagi=13;
                        ?>

                        <!-- menampilkan nilai rata rata -->
                        <tr>
                            <td style="{{$color}}">
                                {{$nama}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white; text-align:right'>{{number_format(($of->tw_sekarang+$satu_tw)/$pembagi)}}</td>
                                @endif

                                @if($row->id==2)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white; text-align:right'>{{number_format(($of->fb_sekarang+$satu_fb)/$pembagi)}}</td>
                                @endif

                                @if($row->id==3)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white; text-align:right'>{{number_format(($of->ig_sekarang+$satu_ig)/$pembagi)}}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="page-break"></div>      
    @endif


    <h3 class="text-center">OVERALL ALL  
        @if($typeunit!=4) 
            @if($typeunit==2)
                {{$mtype->name}}
            @else
                {{strtoupper($mtype->name)}} 
            @endif
        @else 
            {{$mtype->name}}
        @endif ( OFFICIAL & @if($typeunit==2) CANAL @else PROGRAM @endif )</h3>
    <br>
    <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">
                        Channel
                    </th>
                    @foreach($sosmed as $row)
                        <th colspan='3' width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach($sosmed as $row)
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                    @endforeach
                </tr>
            </thead>
            <tbody style="color:#222">
                @php $no=0; @endphp
                @foreach($overallOfficialTv as $key=>$of)
                    @if($of->id=="SUBTOTAL")
                        @if($of->group_id=="TOTAL")
                            
                        @else 
                            @if($of->group_id!=12)
                                <tr style="background:#f2eff2;color:#222;font-weight:700">
                                    <td>{{$of->group_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_tw>0)
                                                    <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_fb>0)
                                                    <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                            <td style="text-align:right">
                                                @if($of->growth_ig>0)
                                                    <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==4)
                                            <td style="text-align:right">{{number_format($of->yt_kemarin)}}</td>
                                            <td style="text-align:right">{{number_format($of->yt_sekarang)}}</td>
                                            <td style="text-align:right">
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
                        @if($of->group_id!=12)
                            <tr style="">
                                <td>
                                    {{$of->unit_name}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td style="text-align:right">{{number_format($of->yt_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->yt_sekarang)}}</td>
                                        <td style="text-align:right">
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
                @endforeach

                @foreach($overallOfficialTv as $key=>$of)
                    @if($of->group_id==12)
                        @if($of->id!="SUBTOTAL")
                            <tr style="">
                                <td>
                                    {{$of->unit_name}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td style="text-align:right">{{number_format($of->tw_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->tw_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td style="text-align:right">{{number_format($of->fb_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->fb_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td style="text-align:right">{{number_format($of->ig_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->ig_sekarang)}}</td>
                                        <td style="text-align:right">
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td style="text-align:right">{{number_format($of->yt_kemarin)}}</td>
                                        <td style="text-align:right">{{number_format($of->yt_sekarang)}}</td>
                                        <td style="text-align:right">
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
                @endforeach
            </tbody>
        </table>
    <div class="page-break"></div> 
    
    
    <!-- JUMLAH -->
    <h3 class="text-center">JUMLAH ACCOUNT SOCMED</h3>
    <br>
    <table class='table table-striped table-bordered' style="font-size:10px">
        <thead>
            <tr>
                {{-- <th rowspan="2">No.</th> --}}
                <th rowspan="2" width="20%" style="background:#305496;color:white" class="align-middle text-white">
                    @if($typeunit==1)
                        Channel
                    @elseif($typeunit==3)
                        Station
                    @elseif($typeunit==2)
                        Website
                    @elseif($typeunit==4)
                        Artists
                    @else 
                        {{$typeunit}}
                    @endif
                </th>
                <th colspan="{{count($sosmed)}}" class='text-center' style='background:#548235;color:white'>DETAIL OFFICIAL</th>
                <th rowspan="2" style='background:#548235;color:white'>TOTAL OFFICIAL</th>

                <th colspan="{{count($sosmed)}}" class='text-center' style='background:#c65911;color:white'>DETAIL PROGRAM</th>
                <th rowspan="2" style='background:#c65911;color:white'>TOTAL PROGRAM</th>

                <th colspan="{{count($sosmed)}}" class='text-center' style='background:#305496;color:white'>SOCMED ACCOUNT</th>
                <th rowspan="2" style='background:#305496;color:white'>TOTAL ALL SOCMED</th>

            </tr>
            <tr>
                @foreach($sosmed as $row)
                    <th class="text-center" style='background:#548235;color:white'>{{$row->sosmed_name}}</th>
                @endforeach

                @foreach($sosmed as $row)
                    <th class="text-center" style='background:#c65911;color:white'>{{$row->sosmed_name}}</th>
                @endforeach

                @foreach($sosmed as $row)
                    <th class="text-center" style='background:#305496;color:white'>{{$row->sosmed_name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($jumlahAccount as $k=>$val)
                @if($val->group_id != "total")
                    @php $bg="" @endphp 
                    @if($val->id == "subtotal")
                        @php $bg="background:#d9d9d9;font-weight:700" @endphp
                        @if($val->group_id != "total")
                            @if($val->group_name == "OTHERS") @continue @endif
                        @endif
                    @endif

                    <tr style="{{$bg}}">
                        {{-- <td>{{($k+1)}}</td> --}}
                        <td>
                            @if($val->id == "subtotal")
                                @if($val->group_id == "total")
                                    TOTAL
                                @else 
                                    {{$val->group_name}}
                                @endif
                            @else 
                                {{$val->unit_name}}
                            @endif
                        </td>
                        @php $t_official=0; @endphp
                        @foreach($sosmed as $row)
                            @if($row->id == 1)
                                <td style="text-align:right">{{$val->c_tw}}</td>
                                @php $t_official+=$val->c_tw @endphp
                            @elseif($row->id == 2)
                                <td style="text-align:right">{{$val->c_fb}}</td>
                                @php $t_official+=$val->c_fb @endphp
                            @elseif($row->id == 3)
                                <td style="text-align:right">{{$val->c_ig}}</td>
                                @php $t_official+=$val->c_ig @endphp
                            @elseif($row->id == 4)
                                <td style="text-align:right">{{$val->c_yt}}</td>
                                @php $t_official+=$val->c_yt @endphp
                            @endif
                        @endforeach

                        <td style="text-align:right">{{$t_official}}</td>

                        @php $t_program=0; @endphp
                        @foreach($sosmed as $row)
                            @if($row->id == 1)
                                <td style="text-align:right">{{$val->p_tw}}</td>
                                @php $t_program+=$val->p_tw @endphp
                            @elseif($row->id == 2)
                                <td style="text-align:right">{{$val->p_fb}}</td>
                                @php $t_program+=$val->p_fb @endphp
                            @elseif($row->id == 3)
                                <td style="text-align:right">{{$val->p_ig}}</td>
                                @php $t_program+=$val->p_ig @endphp
                            @elseif($row->id == 4)
                                <td style="text-align:right">{{$val->p_yt}}</td>
                                @php $t_program+=$val->p_yt @endphp
                            @endif
                        @endforeach

                        <td style="text-align:right">{{$t_program}}</td>

                        @php $t_total=0; @endphp
                        @foreach($sosmed as $row)
                            @if($row->id == 1)
                                <td style="text-align:right">{{$val->total_tw}}</td>
                                @php $t_total+=$val->total_tw @endphp
                            @elseif($row->id == 2)
                                <td style="text-align:right">{{$val->total_fb}}</td>
                                @php $t_total+=$val->total_fb @endphp
                            @elseif($row->id == 3)
                                <td style="text-align:right">{{$val->total_ig}}</td>
                                @php $t_total+=$val->total_ig @endphp
                            @elseif($row->id == 4)
                                <td style="text-align:right">{{$val->total_yt}}</td>
                                @php $t_total+=$val->total_yt @endphp
                            @endif
                        @endforeach

                        <td style="text-align:right">{{$t_total}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>
    <!-- END JUMLAH -->

    <h3 class="text-center">ATTACHMENT
        <small>( Socmed Account Name )</small>
    </h3>
    <br>
    <table class='table table-striped table-bordered'>
        <thead>
            <tr> 
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white">
                    @if($typeunit!=4)
                        General Name
                    @else 
                        Artist
                    @endif
                </th>
                @foreach($sosmed as $row)
                    <th class='text-center' width="20%" style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}} Account Name</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">';
            @foreach($attachment as $row)
                @if($typeunit!=4)
                    <tr style="background:#f2eff2;color:#222;font-weight:700">
                        <td>{{$row->unit_name}} Official</td>
                        @if(count($row->sosmed)>0)
                            @foreach($sosmed as $sa)
                                <?php $h="-";?>
                                @for($c=0;$c< count($row->sosmed);$c++)
                                    @if($row->sosmed[$c]->sosmed_id==$sa->id)
                                        <?php $h=$row->sosmed[$c]->unit_sosmed_name;?>
                                    @endif
                                @endfor
                                <td>{{$h}}</td>
                            @endforeach
                        @else 
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif
                    </tr>
                @endif
                @foreach($row->program as $p)
                    <tr>
                        <td>{{$p->program_name}}</td>
                        @foreach($sosmed as $s)
                            <?php $hasil="-";?>
                            @for($a=0;$a< count($p->sosmed);$a++)
                                @if($p->sosmed[$a]->sosmed_id==$s->id)
                                    <?php $hasil=$p->sosmed[$a]->unit_sosmed_name;?>
                                @endif
                            @endfor
                            <td>{{$hasil}}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>