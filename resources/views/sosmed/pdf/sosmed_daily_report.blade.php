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
                        ?>

                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
                            </td>
                            <td></td>
                            <td>{{number_format($of->tw_sekarang)}}</td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($of->fb_sekarang)}}</td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($of->ig_sekarang)}}</td>
                            <td></td>
                        </tr>
                    @else    
                        <?php 
                            $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";
                        ?>
                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
                            </td>
                            <td>{{number_format($of->tw_kemarin)}}</td>
                            <td>{{number_format($of->tw_sekarang)}}</td>
                            <td>{{$of->growth_tw}}</td>
                            <td>{{number_format($of->fb_kemarin)}}</td>
                            <td>{{number_format($of->fb_sekarang)}}</td>
                            <td>{{$of->growth_fb}}</td>
                            <td>{{number_format($of->ig_kemarin)}}</td>
                            <td>{{number_format($of->ig_sekarang)}}</td>
                            <td>{{$of->growth_ig}}</td>
                        </tr>
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
                        <td>{{number_format($of->tw_kemarin)}}</td>
                        <td>{{number_format($of->tw_sekarang)}}</td>
                        <td>{{$of->growth_tw}}</td>
                        <td>{{number_format($of->fb_kemarin)}}</td>
                        <td>{{number_format($of->fb_sekarang)}}</td>
                        <td>{{$of->growth_fb}}</td>
                        <td>{{number_format($of->ig_kemarin)}}</td>
                        <td>{{number_format($of->ig_sekarang)}}</td>
                        <td>{{$of->growth_ig}}</td>
                    </tr>
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
                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
                            </td>
                            <td>{{number_format($of->total_tw_sekarang)}}</td>
                            <td>{{number_format($of->total_fb_sekarang)}}</td>
                            <td>{{number_format($of->total_ig_sekarang)}}</td>
                        </tr>
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
                <tr>
                    <td>{{$b->unit_name}} Official</td>
                    @if(count($b->sosmed)>0)
                        @foreach($b->sosmed as $c=>$d)
                            @if(count($d->followers)>0){
                                <td>{{number_format($d->followers[0]->follower)}}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endforeach
                    @else 
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                </tr>
                @if(count($b->program)>0)
                    @foreach($b->program as $e=>$f)
                        <tr>
                            <td>{{$f->program_name}}</td>
                            @if(count($f->sosmed)>0)
                                @foreach($f->sosmed as $g=>$h)
                                    @if(count($h->followers)>0)
                                        <td>{{number_format($h->followers[0]->follower)}}</td>
                                    @else 
                                        <td>-</td>
                                    @endif
                                @endforeach
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                            
                <tr style='background:#f2eff2;color:#222;font-weight:700'>
                    <td>Total</td>
                    @for($z=0; $z<count($summaryOfficialAndProgram);$z++)
                        @if($summaryOfficialAndProgram[$z]->id==$b->id)
                            <td>{{number_format($summaryOfficialAndProgram[$z]->total_twitter)}}</td>
                            <td>{{number_format($summaryOfficialAndProgram[$z]->total_fb)}}</td>
                            <td>{{number_format($summaryOfficialAndProgram[$z]->total_ig)}}</td>
                        @endif
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">ATTACHMENT
        <small>( Socmed Account Name )</small>
    </h3>
    <div class="page-break"></div>
</body>
</html>