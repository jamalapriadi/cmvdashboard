<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socmed Daily Report {{date('d-m-Y')}}</title>

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
    <h1 class="text-center">SOCMED DAILY REPORT</h1>
    <p class="text-center">( {{$sekarang}} )</p>

    <div class="page-break"></div>

    <h3 class="text-center">TARGET VS ACHIEVEMENT</h3>
    <br><br><br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
                <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#008ef6;color:white'>Target</th>
                <th class='text-center' style='background:#008ef6;color:white'>ACH</th>

                <th class='text-center' style='background:#5054ab;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>Target</th>
                <th class='text-center' style='background:#5054ab;color:white'>ACH</th>

                <th class='text-center' style='background:#a200b2;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#a200b2;color:white'>Target</th>
                <th class='text-center' style='background:#a200b2;color:white'>ACH</th>
            </tr>
        </thead>
        <tbody style="color:#222">
            @foreach($targetVsAch as $row)
                @if($row->id==4)
                    @for($a=0;$a<count($tambahanInews);$a++)
                        @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->business_unit_id==$row->id)

                            <tr>
                                <td>{{$row->unit_name}}</td>
                                <td>{{number_format($tambahanInews[$a]->tw_sekarang+$row->follower_tw)}}</td>
                                <td>{{number_format($row->target_tw)}}</td>
                                <td>
                                    @if($row->target_tw!=null)
                                        @if($row->target_tw>0)
                                            {{number_format(($tambahanInews[$a]->tw_sekarang / $row->target_tw) * 100,2)}} %
                                        @else 
                                            %
                                        @endif 
                                    @else 
                                        %
                                    @endif
                                </td>
                                <td>{{number_format($tambahanInews[$a]->fb_sekarang+$row->follower_fb)}}</td>
                                <td>{{number_format($row->target_fb)}}</td>
                                <td>
                                    @if($row->target_fb!=null)
                                        @if($row->target_fb>0)
                                            {{number_format(($tambahanInews[$a]->fb_sekarang / $row->target_fb) * 100,2)}} %
                                        @else 
                                            %
                                        @endif 
                                    @else 
                                        %
                                    @endif
                                </td>
                                <td>{{number_format($tambahanInews[$a]->ig_sekarang+$row->follower_ig)}}</td>
                                <td>{{number_format($row->target_ig)}}</td>
                                <td>
                                    @if($row->target_ig!=null)
                                        @if($row->target_ig>0)
                                            {{number_format(($tambahanInews[$a]->ig_sekarang / $row->target_ig) * 100,2)}} %
                                        @else 
                                            %
                                        @endif 
                                    @else 
                                        %
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endfor
                @else
                    <tr>
                        <td>{{$row->unit_name}}</td>
                        <td>{{number_format($row->follower_tw)}}</td>
                        <td>{{number_format($row->target_tw)}}</td>
                        <td>{{number_format($row->acv_tw,2)}} %</td>
                        <td>{{number_format($row->follower_fb)}}</td>
                        <td>{{number_format($row->target_fb)}}</td>
                        <td>{{number_format($row->acv_fb,2)}} %</td>
                        <td>{{number_format($row->follower_ig)}}</td>
                        <td>{{number_format($row->target_ig)}}</td>
                        <td>{{number_format($row->acv_ig,2)}} %</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OFFICIAL ACCOUNT ALL TV</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
                <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>{{$kemarin}}</th>
                <th class='text-center' style='background:#008ef6;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#008ef6;color:white'>Growth From Yesterday</th>

                <th class='text-center' style='background:#5054ab;color:white'>{{$kemarin}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>Growth From Yesterday</th>

                <th class='text-center' style='background:#a200b2;color:white'>{{$kemarin}}</th>
                <th class='text-center' style='background:#a200b2;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#a200b2;color:white'>Growth From Yesterday</th>
            </tr>
        </thead>
        <tbody style="color:#222">
            @foreach($officialTv as $of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                            $satu_tw=0;
                            $satu_fb=0;
                            $satu_ig=0;
                        ?>
                        @for($a=0;$a<count($tambahanInews);$a++)
                            @if($tambahanInews[$a]->id=="TOTAL")
                                <?php 
                                    $satu_tw=$tambahanInews[$a]->tw_sekarang;
                                    $satu_fb=$tambahanInews[$a]->fb_sekarang;
                                    $satu_ig=$tambahanInews[$a]->ig_sekarang;
                                ?>
                            @endif
                        @endfor

                        <tr>
                            <td style="{{$color}}">
                                {{$nama}}
                            </td>
                            <td colspan="3" class="text-center" style='background:#008ef6;color:white'>{{number_format(($of->tw_sekarang+$satu_tw)/13)}}</td>
                            <td colspan="3" class="text-center" style='background:#5054ab;color:white'>{{number_format(($of->fb_sekarang+$satu_fb)/13)}}</td>
                            <td colspan="3" class="text-center" style='background:#a200b2;color:white'>{{number_format(($of->ig_sekarang+$satu_ig)/13)}}</td>
                        </tr>
                    @else    
                        <?php 
                            $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";
                        ?>

                        @if($of->group_id==1)
                            <!-- tambahkan untuk inews -->
                            @for($a=0;$a<count($tambahanInews);$a++)
                                @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->group_unit_id==$of->group_id)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        <td>{{number_format($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                        <td>{{number_format($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                        <td>{{number_format($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        @else   
                            @if($of->group_id!=5)
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
                                    </td>
                                    <td>{{number_format($of->tw_kemarin)}}</td>
                                    <td>{{number_format($of->tw_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_tw>0)
                                            <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($of->fb_kemarin)}}</td>
                                    <td>{{number_format($of->fb_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_fb>0)
                                            <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($of->ig_kemarin)}}</td>
                                    <td>{{number_format($of->ig_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_ig>0)
                                            <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif
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
                                    <td>{{number_format($tambahanInews[$a]->tw_kemarin+$of->tw_kemarin)}}</td>
                                    <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                    <td>
                                        @if($tambahanInews[$a]->growth_tw>0)
                                            <a style="color:green;"> {{round($tambahanInews[$a]->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($tambahanInews[$a]->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin)}}</td>
                                    <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                    <td>
                                        @if($tambahanInews[$a]->growth_fb>0)
                                            <a style="color:green;"> {{round($tambahanInews[$a]->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($tambahanInews[$a]->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin)}}</td>
                                    <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                    <td>
                                        @if($tambahanInews[$a]->growth_ig>0)
                                            <a style="color:green;"> {{round($tambahanInews[$a]->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($tambahanInews[$a]->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endfor

                    @else
                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
                            </td>
                            <td>{{number_format($of->tw_kemarin)}}</td>
                            <td>{{number_format($of->tw_sekarang)}}</td>
                            <td>
                                @if($of->growth_tw>0)
                                    <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                @endif
                            </td>
                            <td>{{number_format($of->fb_kemarin)}}</td>
                            <td>{{number_format($of->fb_sekarang)}}</td>
                            <td>
                                @if($of->growth_fb>0)
                                    <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                @endif
                            </td>
                            <td>{{number_format($of->ig_kemarin)}}</td>
                            <td>{{number_format($of->ig_sekarang)}}</td>
                            <td>
                                @if($of->growth_ig>0)
                                    <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                @endif
                            </td>
                        </tr>
                    @endif

                    <!-- menampilkan tambahan inews -->
                    @if($of->id==4)
                        @foreach($tambahanInews as $t)
                            @if($t->id!="TOTAL")
                                <tr>
                                    <td style='color:red'>{{$t->program_name}}</td>
                                    <td>{{number_format($t->tw_kemarin)}}</td>
                                    <td>{{number_format($t->tw_sekarang)}}</td>
                                    <td>
                                        @if($t->growth_tw>0)
                                            <a style="color:green;"> {{round($t->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($t->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($t->fb_kemarin)}}</td>
                                    <td>{{number_format($t->fb_sekarang)}}</td>
                                    <td>
                                        @if($t->growth_fb>0)
                                            <a style="color:green;"> {{round($t->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($t->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                    <td>{{number_format($t->ig_kemarin)}}</td>
                                    <td>{{number_format($t->ig_sekarang)}}</td>
                                    <td>
                                        @if($t->growth_ig>0)
                                            <a style="color:green;"> {{round($t->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($t->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    <!-- end menampilkan tambahan inews -->

                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OVERALL ALL TV ( OFFICIAL & PROGRAM )</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
                <th class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class="text-center" style='background:#008ef6;color:white'>{{$sekarang}}</th>
                <th class="text-center" style='background:#5054ab;color:white'>{{$sekarang}}</th>
                <th class="text-center" style='background:#a200b2;color:white'>{{$sekarang}}</th>
            </tr>
        </thead>
        <tbody style="color:#222">
            @foreach($overallOfficialTv as $of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>
                    @else    
                        <?php 
                            $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";
                        ?>
                        @if($of->group_id!=5)
                            <tr style="{{$color}}">
                                <td>
                                    {{$nama}}
                                </td>
                                <td>{{number_format($of->total_tw_sekarang)}}</td>
                                <td>{{number_format($of->total_fb_sekarang)}}</td>
                                <td>{{number_format($of->total_ig_sekarang)}}</td>
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
                            {{$nama}}
                        </td>
                        <td>{{number_format($of->total_tw_sekarang)}}</td>
                        <td>{{number_format($of->total_fb_sekarang)}}</td>
                        <td>{{number_format($of->total_ig_sekarang)}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OFFICIAL & PROGRAM MNC GROUP</h3>
    <br>
    <table class='table table-striped table-bordered'>
        <thead>
            <tr> 
                <th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">General Name</th>
                <th class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th class='text-center' style='background:#a200b2;color:white'>Instagram</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>{{$sekarang}}</th>
                <th class='text-center' style='background:#a200b2;color:white'>{{$sekarang}}</th>
            </tr>
        </thead>
        <tbody style="color:#222">';
            @foreach($officialAndProgram as $a=>$b)
                @if($b->urut=="total")
                    <?php $warna="background:#f2eff2;color:#222;font-weight:700";?>
                @else 
                    <?php $warna="";?>
                @endif
                
                <tr style="{{$warna}}">
                    <td>
                        @if($b->urut=="total")
                            Total
                        @elseif($b->urut=="corporate")
                            {{$b->unit_name}} Official
                        @else
                            {{$b->unit_sosmed_name}}
                        @endif
                    </td>
                    <td>{{number_format($b->tw)}}</td>
                    <td>{{number_format($b->fb)}}</td>
                    <td>{{number_format($b->ig)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">ATTACHMENT
        <small>( Socmed Account Name )</small>
    </h3>
    <br>
    <table class='table table-striped table-bordered'>
        <thead>
            <tr> 
                <th style="background:#419F51;color:white" class="align-middle text-white">General Name</th>
                <th class='text-center' style='background:#008ef6;color:white'>Twitter Account Name</th>
                <th class='text-center' style='background:#5054ab;color:white'>Facebook Account Name</th>
                <th class='text-center' style='background:#a200b2;color:white'>Instagram Account Name</th>
            </tr>
        </thead>
        <tbody style="color:#222">';
            @foreach($attachment as $row)
                <tr style="background:#f2eff2;color:#222;font-weight:700">
                    <td>{{$row->unit_name}} Official</td>
                    @if(count($row->sosmed)>0)
                        @foreach($sosmed as $sa)
                            <?php $h="-";?>
                            @for($c=0;$c<count($row->sosmed);$c++)
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
                    @endif
                </tr>
                @foreach($row->program as $p)
                    <tr>
                        <td>{{$p->program_name}}</td>
                        @foreach($sosmed as $s)
                            <?php $hasil="-";?>
                            @for($a=0;$a<count($p->sosmed);$a++)
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