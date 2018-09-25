<table class="table table-striped table-bordered sticky-header" style="font-size:10px;">
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
        @php $no=0; @endphp
        @foreach($officialTv as $key=>$of)
            @if($of->id=="SUBTOTAL")
                @if($of->group_id=="TOTAL")
                    <?php 
                        $nama="NILAI RATA - RATA";
                        $color="background:#419F51;color:white;font-weight:700";
                        $satu_tw=0;
                        $satu_fb=0;
                        $satu_ig=0;
                        $satu_yt=0;

                        if($typeunit=="Publisher"){
                            $pembagi=$no+3;
                        }else{
                            $pembagi=13;
                        }
                    ?>

                    @if($typeunit=="TV")
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
                    @endif

                    @if($typeunit=="Publisher")
                        @foreach($inewsidprogram as $inew)
                            <?php 
                                $satu_tw+=$inew->tw_sekarang;
                                $satu_fb+=$inew->fb_sekarang;
                                $satu_ig+=$inew->ig_sekarang;
                                $satu_yt+=$inew->yt_sekarang;
                            ?>
                        @endforeach

                        @foreach($metrofficial as $metro)
                            <!-- menambahkan metro official di publisher -->
                            <!-- define tambahan untuk inewsprogram nanti dimasukan ke total mncgroup -->
                            @php 
                                $metrosprogram_tw_kemarin=$metro->tw_kemarin;
                                $metrosprogram_tw_sekarang=$metro->tw_sekarang;
                                $metrosprogram_fb_kemarin=$metro->fb_kemarin;
                                $metrosprogram_fb_sekarang=$metro->fb_sekarang;
                                $metrosprogram_ig_kemarin=$metro->ig_kemarin;
                                $metrosprogram_ig_sekarang=$metro->ig_sekarang;
                                $metrosprogram_yt_kemarin=$metro->yt_kemarin;
                                $metrosprogram_yt_sekarang=$metro->yt_sekarang;

                                $satu_tw+=$metro->tw_sekarang;
                                $satu_fb+=$metro->fb_sekarang;
                                $satu_ig+=$metro->ig_sekarang;
                                $satu_yt+=$metro->yt_sekarang;
                            @endphp

                            <tr>
                                <td>METROTVNEWS.COM</td>

                                @foreach($sosmed as $metrosos)
                                    @if($metrosos->id==1)
                                        <td>{{number_format($metro->tw_kemarin)}}</td>
                                        <td>{{number_format($metro->tw_sekarang)}}</td>
                                        <td>
                                            @if($metro->growth_tw>0)
                                                <a style="color:green;"> {{round($metro->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($metro->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($metrosos->id==2)
                                        <td>{{number_format($metro->fb_kemarin)}}</td>
                                        <td>{{number_format($metro->fb_sekarang)}}</td>
                                        <td>
                                            @if($metro->growth_fb>0)
                                                <a style="color:green;"> {{round($metro->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($metro->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($metrosos->id==3)
                                        <td>{{number_format($metro->ig_kemarin)}}</td>
                                        <td>{{number_format($metro->ig_sekarang)}}</td>
                                        <td>
                                            @if($metro->growth_ig>0)
                                                <a style="color:green;"> {{round($metro->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($metro->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($metrosos->id==4)
                                        <td>{{number_format($metro->yt_kemarin)}}</td>
                                        <td>{{number_format($metro->yt_sekarang)}}</td>
                                        <td>
                                            @if($metro->growth_yt>0)
                                                <a style="color:green;"> {{round($metro->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($metro->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                    <tr>
                        <td style="{{$color}}">
                            {{$nama}}
                        </td>
                        @foreach($sosmed as $row)
                            @if($row->id==1)
                                <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->tw_sekarang+$satu_tw)/$pembagi)}}</td>
                            @endif

                            @if($row->id==2)
                                <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->fb_sekarang+$satu_fb)/$pembagi)}}</td>
                            @endif

                            @if($row->id==3)
                                <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->ig_sekarang+$satu_ig)/$pembagi)}}</td>
                            @endif

                            @if($row->id==4)
                                <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->yt_sekarang+$satu_yt)/$pembagi)}}</td>
                            @endif
                        @endforeach
                    </tr>
                @else    
                    <?php 
                        $nama=$of->group_name;
                        $color="background:#f2eff2;color:#222;font-weight:700";
                        $inewsprogram_tw_kemarin=0;
                        $inewsprogram_tw_sekarang=0;
                        $inewsprogram_fb_kemarin=0;
                        $inewsprogram_fb_sekarang=0;
                        $inewsprogram_ig_kemarin=0;
                        $inewsprogram_ig_sekarang=0;
                        $inewsprogram_yt_kemarin=0;
                        $inewsprogram_yt_sekarang=0;
                    ?>

                    <!-- tambahkan inewsid, metrotvnews, ccnindonesia di program -->
                    <!-- ini khusu untuk publisher -->
                    @if($typeunit=="Publisher" && $of->group_id==1)
                        <!-- inject publisher untuk inews -->
                        @foreach($inewsidprogram as $inew)
                            <!-- define tambahan untuk inewsprogram nanti dimasukan ke total mncgroup -->
                            @php 
                                $inewsprogram_tw_kemarin=$inew->tw_kemarin;
                                $inewsprogram_tw_sekarang=$inew->tw_sekarang;
                                $inewsprogram_fb_kemarin=$inew->fb_kemarin;
                                $inewsprogram_fb_sekarang=$inew->fb_sekarang;
                                $inewsprogram_ig_kemarin=$inew->ig_kemarin;
                                $inewsprogram_ig_sekarang=$inew->ig_sekarang;
                                $inewsprogram_yt_kemarin=$inew->yt_kemarin;
                                $inewsprogram_yt_sekarang=$inew->yt_sekarang;
                            @endphp

                            <tr>
                                <td>INEWS.ID</td>

                                @foreach($sosmed as $inewsos)
                                    @if($inewsos->id==1)
                                        <td>{{number_format($inew->tw_kemarin)}}</td>
                                        <td>{{number_format($inew->tw_sekarang)}}</td>
                                        <td>
                                            @if($inew->growth_tw>0)
                                                <a style="color:green;"> {{round($inew->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($inew->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($inewsos->id==2)
                                        <td>{{number_format($inew->fb_kemarin)}}</td>
                                        <td>{{number_format($inew->fb_sekarang)}}</td>
                                        <td>
                                            @if($inew->growth_fb>0)
                                                <a style="color:green;"> {{round($inew->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($inew->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($inewsos->id==3)
                                        <td>{{number_format($inew->ig_kemarin)}}</td>
                                        <td>{{number_format($inew->ig_sekarang)}}</td>
                                        <td>
                                            @if($inew->growth_ig>0)
                                                <a style="color:green;"> {{round($inew->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($inew->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($inewsos->id==4)
                                        <td>{{number_format($inew->yt_kemarin)}}</td>
                                        <td>{{number_format($inew->yt_sekarang)}}</td>
                                        <td>
                                            @if($inew->growth_yt>0)
                                                <a style="color:green;"> {{round($inew->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($inew->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @elseif($typeunit=="Publisher" && $of->group_id==3)
                        <!-- inject publisher untuk cnn indonesia -->
                        @foreach($cnnprogram as $cnn)
                            <!-- define tambahan untuk cnnsprogram nanti dimasukan ke total mncgroup -->
                            @php 
                                $cnnsprogram_tw_kemarin=$cnn->tw_kemarin;
                                $cnnsprogram_tw_sekarang=$cnn->tw_sekarang;
                                $cnnsprogram_fb_kemarin=$cnn->fb_kemarin;
                                $cnnsprogram_fb_sekarang=$cnn->fb_sekarang;
                                $cnnsprogram_ig_kemarin=$cnn->ig_kemarin;
                                $cnnsprogram_ig_sekarang=$cnn->ig_sekarang;
                                $cnnsprogram_yt_kemarin=$cnn->yt_kemarin;
                                $cnnsprogram_yt_sekarang=$cnn->yt_sekarang;
                            @endphp

                            <tr>
                                <td>CNNINDONESIA.COM</td>

                                @foreach($sosmed as $cnnsos)
                                    @if($cnnsos->id==1)
                                        <td>{{number_format($cnn->tw_kemarin)}}</td>
                                        <td>{{number_format($cnn->tw_sekarang)}}</td>
                                        <td>
                                            @if($cnn->growth_tw>0)
                                                <a style="color:green;"> {{round($cnn->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($cnn->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($cnnsos->id==2)
                                        <td>{{number_format($cnn->fb_kemarin)}}</td>
                                        <td>{{number_format($cnn->fb_sekarang)}}</td>
                                        <td>
                                            @if($cnn->growth_fb>0)
                                                <a style="color:green;"> {{round($cnn->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($cnn->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($cnnsos->id==3)
                                        <td>{{number_format($cnn->ig_kemarin)}}</td>
                                        <td>{{number_format($cnn->ig_sekarang)}}</td>
                                        <td>
                                            @if($cnn->growth_ig>0)
                                                <a style="color:green;"> {{round($cnn->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($cnn->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($cnnsos->id==4)
                                        <td>{{number_format($cnn->yt_kemarin)}}</td>
                                        <td>{{number_format($cnn->yt_sekarang)}}</td>
                                        <td>
                                            @if($cnn->growth_yt>0)
                                                <a style="color:green;"> {{round($cnn->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($cnn->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                    @if($of->group_id==1)
                        
                        <!-- menampilkan total group mncgroup di publisher -->
                        @if($typeunit=="Publisher")
                            <tr style="{{$color}}">
                                <td>
                                    {{$nama}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->tw_kemarin + $inewsprogram_tw_kemarin)}}</td>
                                        <td>{{number_format($of->tw_sekarang + $inewsprogram_tw_sekarang)}}</td>
                                        <td>
                                            @if( ( (($of->tw_sekarang + $inewsprogram_tw_sekarang) / ( $of->tw_kemarin + $inewsprogram_tw_kemarin ) - 1) * 100 ) > 0)
                                                <a style="color:green;"> {{round(( (($of->tw_sekarang + $inewsprogram_tw_sekarang) / ( $of->tw_kemarin + $inewsprogram_tw_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round(( (($of->tw_sekarang + $inewsprogram_tw_sekarang) / ( $of->tw_kemarin + $inewsprogram_tw_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->fb_kemarin + $inewsprogram_fb_kemarin)}}</td>
                                        <td>{{number_format($of->fb_sekarang + $inewsprogram_fb_sekarang)}}</td>
                                        <td>
                                            @if( ( (($of->fb_sekarang + $inewsprogram_fb_sekarang) / ( $of->fb_kemarin + $inewsprogram_fb_kemarin ) - 1) * 100 ) > 0)
                                                <a style="color:green;"> {{round(( (($of->fb_sekarang + $inewsprogram_fb_sekarang) / ( $of->fb_kemarin + $inewsprogram_fb_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round(( (($of->fb_sekarang + $inewsprogram_fb_sekarang) / ( $of->fb_kemarin + $inewsprogram_fb_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->ig_kemarin + $inewsprogram_ig_kemarin)}}</td>
                                        <td>{{number_format($of->ig_sekarang + $inewsprogram_ig_sekarang)}}</td>
                                        <td>
                                            @if( ( (($of->ig_sekarang + $inewsprogram_ig_sekarang) / ( $of->ig_kemarin + $inewsprogram_ig_kemarin ) - 1) * 100 ) > 0)
                                                <a style="color:green;"> {{round(( (($of->ig_sekarang + $inewsprogram_ig_sekarang) / ( $of->ig_kemarin + $inewsprogram_ig_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round(( (($of->ig_sekarang + $inewsprogram_ig_sekarang) / ( $of->ig_kemarin + $inewsprogram_ig_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->yt_kemarin + $inewsprogram_yt_kemarin)}}</td>
                                        <td>{{number_format($of->yt_sekarang + $inewsprogram_yt_sekarang)}}</td>
                                        <td>
                                            @if( ( (($of->yt_sekarang + $inewsprogram_yt_sekarang) / ( $of->yt_kemarin + $inewsprogram_yt_kemarin ) - 1) * 100 ) > 0)
                                                <a style="color:green;"> {{round(( (($of->yt_sekarang + $inewsprogram_yt_sekarang) / ( $of->yt_kemarin + $inewsprogram_yt_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round(( (($of->yt_sekarang + $inewsprogram_yt_sekarang) / ( $of->yt_kemarin + $inewsprogram_yt_kemarin ) - 1) * 100 ),2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                        <!-- end menampilkan total group mncgroup di publisher -->

                        <!-- tambahkan untuk inews -->
                        @if($typeunit=="TV")
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
                        @endif
                    @else   
                        @if($of->group_id!=5)
                            @if($of->group_id!=12)
                                <!-- menampilkan total group mncgroup di publisher -->
                                @if($typeunit=="Publisher" && $of->group_id==3)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($of->tw_kemarin + $cnnsprogram_tw_kemarin)}}</td>
                                                <td>{{number_format($of->tw_sekarang + $cnnsprogram_tw_sekarang)}}</td>
                                                <td>
                                                    @if( ( (($of->tw_sekarang + $cnnsprogram_tw_sekarang) / ( $of->tw_kemarin + $cnnsprogram_tw_kemarin ) - 1) * 100 ) > 0)
                                                        <a style="color:green;"> {{round(( (($of->tw_sekarang + $cnnsprogram_tw_sekarang) / ( $of->tw_kemarin + $cnnsprogram_tw_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(( (($of->tw_sekarang + $cnnsprogram_tw_sekarang) / ( $of->tw_kemarin + $cnnsprogram_tw_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($of->fb_kemarin + $cnnsprogram_fb_kemarin)}}</td>
                                                <td>{{number_format($of->fb_sekarang + $cnnsprogram_fb_sekarang)}}</td>
                                                <td>
                                                    @if( ( (($of->fb_sekarang + $cnnsprogram_fb_sekarang) / ( $of->fb_kemarin + $cnnsprogram_fb_kemarin ) - 1) * 100 ) > 0)
                                                        <a style="color:green;"> {{round(( (($of->fb_sekarang + $cnnsprogram_fb_sekarang) / ( $of->fb_kemarin + $cnnsprogram_fb_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(( (($of->fb_sekarang + $cnnsprogram_fb_sekarang) / ( $of->fb_kemarin + $cnnsprogram_fb_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($of->ig_kemarin + $cnnsprogram_ig_kemarin)}}</td>
                                                <td>{{number_format($of->ig_sekarang + $cnnsprogram_ig_sekarang)}}</td>
                                                <td>
                                                    @if( ( (($of->ig_sekarang + $cnnsprogram_ig_sekarang) / ( $of->ig_kemarin + $cnnsprogram_ig_kemarin ) - 1) * 100 ) > 0)
                                                        <a style="color:green;"> {{round(( (($of->ig_sekarang + $cnnsprogram_ig_sekarang) / ( $of->ig_kemarin + $cnnsprogram_ig_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(( (($of->ig_sekarang + $cnnsprogram_ig_sekarang) / ( $of->ig_kemarin + $cnnsprogram_ig_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif

                                            @if($row->id==4)
                                                <td>{{number_format($of->yt_kemarin + $cnnsprogram_yt_kemarin)}}</td>
                                                <td>{{number_format($of->yt_sekarang + $cnnsprogram_yt_sekarang)}}</td>
                                                <td>
                                                    @if( ( (($of->yt_sekarang + $cnnsprogram_yt_sekarang) / ( $of->yt_kemarin + $cnnsprogram_yt_kemarin ) - 1) * 100 ) > 0)
                                                        <a style="color:green;"> {{round(( (($of->yt_sekarang + $cnnsprogram_yt_sekarang) / ( $of->yt_kemarin + $cnnsprogram_yt_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @else
                                                        <a style="color:red;"> {{round(( (($of->yt_sekarang + $cnnsprogram_yt_sekarang) / ( $of->yt_kemarin + $cnnsprogram_yt_kemarin ) - 1) * 100 ),2)}} % </a>
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
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
                        @endif
                    @endif
                @endif
            @else 
                <?php 
                    $no++;
                    $nama=$of->unit_name;
                    $color="";
                ?>

                <!-- id 4 adalah tv inews, jadi ditambahkan dengan 4 program ke tv inews -->
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
                                            @if($tambahanInews[$a]->growth_tw>0)
                                                <a style="color:green;"> {{round($tambahanInews[$a]->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($tambahanInews[$a]->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($tambahanInews[$a]->fb_kemarin+$of->fb_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                        <td>
                                            @if($tambahanInews[$a]->growth_fb>0)
                                                <a style="color:green;"> {{round($tambahanInews[$a]->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($tambahanInews[$a]->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($tambahanInews[$a]->ig_kemarin+$of->ig_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                        <td>
                                            @if($tambahanInews[$a]->growth_ig>0)
                                                <a style="color:green;"> {{round($tambahanInews[$a]->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($tambahanInews[$a]->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($tambahanInews[$a]->yt_kemarin+$of->yt_kemarin)}}</td>
                                        <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                        <td>
                                            @if($tambahanInews[$a]->growth_yt>0)
                                                <a style="color:green;"> {{round($tambahanInews[$a]->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($tambahanInews[$a]->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
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

                                    @if($row->id==4)
                                        <td>{{number_format($t->yt_kemarin)}}</td>
                                        <td>{{number_format($t->yt_sekarang)}}</td>
                                        <td>
                                            @if($t->growth_yt>0)
                                                <a style="color:green;"> {{round($t->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($t->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                <!-- end menampilkan tambahan inews -->

            @endif
        @endforeach
    </tbody>
</table>