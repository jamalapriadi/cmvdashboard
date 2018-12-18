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
        <!-- =========================== JIKA YANG DIPILIH ADALAH PUBLISHER ======================== -->
        @if($typeunit==2)
            @foreach($officialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id!="TOTAL")
                        <?php 
                            $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";
                        ?>

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

                            if($typeunit==2){
                                $pembagi=$no+3;
                            }else{
                                $pembagi=13;
                            }
                        ?>
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
                    @endif
                @endif
            @endforeach
        <!-- =========================== END JIKA YANG DIPILIH ADALAH PUBLISHER ======================== -->

        <!-- =========================== JIKA YANG DIPILIH ADA TV ======================== -->
        @elseif($typeunit==1)
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

                            if($typeunit==2){
                                $pembagi=$no+3;
                            }else{
                                $pembagi=13;
                            }
                        ?>
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
                        @if($of->group_id!=5)
                            <?php 
                                $nama=$of->group_name;
                                $color="background:#f2eff2;color:#222;font-weight:700";
                            ?>

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
                @else 
                    @if($of->id==4)
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
                        
                        @if(count($tambahanInews)>0)
                            @foreach($tambahanInews as $inews)
                                <tr>
                                    <td style="color:red;">{{$inews->program_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($inews->tw_kemarin)}}</td>
                                            <td>{{number_format($inews->tw_sekarang)}}</td>
                                            <td>
                                                @if($inews->growth_tw>0)
                                                    <a style="color:green;"> {{round($inews->growth_tw,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($inews->growth_tw,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($inews->fb_kemarin)}}</td>
                                            <td>{{number_format($inews->fb_sekarang)}}</td>
                                            <td>
                                                @if($inews->growth_fb>0)
                                                    <a style="color:green;"> {{round($inews->growth_fb,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($inews->growth_fb,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($inews->ig_kemarin)}}</td>
                                            <td>{{number_format($inews->ig_sekarang)}}</td>
                                            <td>
                                                @if($inews->growth_ig>0)
                                                    <a style="color:green;"> {{round($inews->growth_ig,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($inews->growth_ig,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==4)
                                            <td>{{number_format($inews->yt_kemarin)}}</td>
                                            <td>{{number_format($inews->yt_sekarang)}}</td>
                                            <td>
                                                @if($inews->growth_yt>0)
                                                    <a style="color:green;"> {{round($inews->growth_yt,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($inews->growth_yt,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
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
            @endforeach
        
        <!-- =========================== END JIKA YANG DIPILIH ADALAH TV ======================== -->

        <!-- =========================== JIKA YANG DIPILIH ADALAH SELAIN TV DAN PUBLISHER ======================== -->
        @else 
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

                            if($typeunit==2){
                                $pembagi=$no+3;
                            }else{
                                $pembagi=13;
                            }
                        ?>
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
                        @if($of->group_id!=5)
                            @if($of->group_id!=12)
                                <?php 
                                    $nama=$of->group_name;
                                    $color="background:#f2eff2;color:#222;font-weight:700";
                                ?>

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
        <!-- =========================== END JIKA YANG DIPILIH ADALAH TV DAN PUBLISHER ======================== -->
        @endif
    </tbody>
</table>