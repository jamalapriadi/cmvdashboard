<table class="table table-striped table-bordered sticky-header">
        <thead>
            <tr>
                <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
                <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th colspan='3' class='text-center' style='background:#a958a5;color:white'>Instagram</th>
                <th colspan='3' class='text-center' style='background:#f06261;color:white'>Youtube</th>
            </tr>
            <tr>
                <th class='text-center' style='background:#008ef6;color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                <th class='text-center' style='background:#008ef6;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class='text-center' style='background:#008ef6;color:white'>Growth From Yesterday</th>

                <th class='text-center' style='background:#5054ab;color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class='text-center' style='background:#5054ab;color:white'>Growth From Yesterday</th>

                <th class='text-center' style='background:#a958a5;color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                <th class='text-center' style='background:#a958a5;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class='text-center' style='background:#a958a5;color:white'>Growth From Yesterday</th>

                <th class='text-center' style='background:#f06261;color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                <th class='text-center' style='background:#f06261;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class='text-center' style='background:#f06261;color:white'>Growth From Yesterday</th>
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
                            $satu_yt=0;
                        ?>
                        @for($a=0;$a<count($tambahanInews);$a++)
                            @if($tambahanInews[$a]->id=="TOTAL")
                                <?php 
                                    $satu_tw=$tambahanInews[$a]->tw_sekarang;
                                    $satu_fb=$tambahanInews[$a]->fb_sekarang;
                                    $satu_ig=$tambahanInews[$a]->ig_sekarang;
                                    $satu_yt=$tambahanInews[$a]->yt_sekarang;
                                ?>
                            @endif
                        @endfor

                        <tr>
                            <td style="{{$color}}">
                                {{$nama}}
                            </td>
                            <td colspan="3" class="text-center" style='background:#008ef6;color:white'>{{number_format(($of->tw_sekarang+$satu_tw)/13)}}</td>
                            <td colspan="3" class="text-center" style='background:#5054ab;color:white'>{{number_format(($of->fb_sekarang+$satu_fb)/13)}}</td>
                            <td colspan="3" class="text-center" style='background:#a958a5;color:white'>{{number_format(($of->ig_sekarang+$satu_ig)/13)}}</td>
                            <td colspan="3" class="text-center" style='background:#f06261;color:white'>{{number_format(($of->yt_sekarang+$satu_yt)/13)}}</td>
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
                                        <td>{{number_format($tambahanInews[$a]->yt_kemarin+$of->yt_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_yt>0)
                                                <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
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
                                    <td>{{number_format($of->yt_kemarin)}}</td>
                                    <td>{{number_format($of->yt_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_yt>0)
                                            <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
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
                                    <td>{{number_format($tambahanInews[$a]->yt_kemarin+$of->yt_kemarin)}}</td>
                                    <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                    <td>
                                        @if($tambahanInews[$a]->growth_yt>0)
                                            <a style="color:green;"> {{round($tambahanInews[$a]->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($tambahanInews[$a]->growth_yt,2)}} % </a>
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
                            <td>{{number_format($of->yt_kemarin)}}</td>
                            <td>{{number_format($of->yt_sekarang)}}</td>
                            <td>
                                @if($of->growth_yt>0)
                                    <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                @else
                                    <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
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
                                    <td>{{number_format($t->yt_kemarin)}}</td>
                                    <td>{{number_format($t->yt_sekarang)}}</td>
                                    <td>
                                        @if($t->growth_yt>0)
                                            <a style="color:green;"> {{round($t->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($t->growth_yt,2)}} % </a>
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