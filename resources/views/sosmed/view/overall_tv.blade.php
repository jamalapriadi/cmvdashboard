<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="20%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">
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
            @foreach($sosmed as $row)
                <th colspan="3" class='text-center' width="20%" style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($sosmed as $row)
                <th class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                <th class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class="text-center" style='background:{{$row->sosmed_color}};color:white'>Growth</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php $no=0; @endphp
        @foreach($overallOfficialTv as $key=>$of)
            @if($of->id=="SUBTOTAL")
                @if($of->group_id=="TOTAL")
                    
                @else 
                    @if($of->group_id!=5)
                        @if($of->group_id!=12)
                            <?php 
                                $nama=$of->group_name;
                                $color="background:#e4e7ea;color:#222;font-weight:700";
                            ?>

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
            @else 
                <?php 
                    $no++;
                    $nama=$of->unit_name;
                    $color="";
                ?>
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
        @endforeach
    </tbody>
</table>