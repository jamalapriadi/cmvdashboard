<table class="table table-striped table-bordered sticky-header">
        <thead>
            <tr>
                <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
                <th class='text-center' style='background:#008ef6;color:white'>Twitter</th>
                <th class='text-center' style='background:#5054ab;color:white'>Facebook</th>
                <th class='text-center' style='background:#a958a5;color:white'>Instagram</th>
                <th class='text-center' style='background:#f06261;color:white'>Youtube</th>
            </tr>
            <tr>
                <th class="text-center" style='background:#008ef6;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class="text-center" style='background:#5054ab;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class="text-center" style='background:#a958a5;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                <th class="text-center" style='background:#f06261;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
            </tr>
        </thead>
        <tbody style="color:#222">
            @php $no=0; @endphp
            @foreach($overallOfficialTv as $of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>

                        @if($typeunit=="Publisher")
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
                                @endphp

                                <tr>
                                    <td>METROTVNEWS.COM</td>

                                    @foreach($sosmed as $metrosos)
                                        @if($metrosos->id==1)
                                            <td>{{number_format($metro->tw_sekarang)}}</td>
                                        @endif

                                        @if($metrosos->id==2)
                                            <td>{{number_format($metro->fb_sekarang)}}</td>
                                        @endif

                                        @if($metrosos->id==3)
                                            <td>{{number_format($metro->ig_sekarang)}}</td>
                                        @endif

                                        @if($metrosos->id==4)
                                            <td>{{number_format($metro->yt_sekarang)}}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
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
                                            <td>{{number_format($inew->tw_sekarang)}}</td>
                                        @endif

                                        @if($inewsos->id==2)
                                            <td>{{number_format($inew->fb_sekarang)}}</td>
                                        @endif

                                        @if($inewsos->id==3)
                                            <td>{{number_format($inew->ig_sekarang)}}</td>
                                        @endif

                                        @if($inewsos->id==4)
                                            <td>{{number_format($inew->yt_sekarang)}}</td>
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
                                            <td>{{number_format($cnn->tw_sekarang)}}</td>
                                        @endif

                                        @if($cnnsos->id==2)
                                            <td>{{number_format($cnn->fb_sekarang)}}</td>
                                        @endif

                                        @if($cnnsos->id==3)
                                            <td>{{number_format($cnn->ig_sekarang)}}</td>
                                        @endif

                                        @if($cnnsos->id==4)
                                            <td>{{number_format($cnn->yt_sekarang)}}</td>
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
                                            <td>{{number_format($of->total_tw_sekarang + $inewsprogram_tw_sekarang)}}</td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($of->total_fb_sekarang + $inewsprogram_fb_sekarang)}}</td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($of->total_ig_sekarang + $inewsprogram_ig_sekarang)}}</td>
                                        @endif

                                        @if($row->id==4)
                                            <td>{{number_format($of->total_yt_sekarang + $inewsprogram_yt_sekarang)}}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @else 
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
                                    </td>
                                    <td>{{number_format($of->total_tw_sekarang)}}</td>
                                    <td>{{number_format($of->total_fb_sekarang)}}</td>
                                    <td>{{number_format($of->total_ig_sekarang)}}</td>
                                    <td>{{number_format($of->total_yt_sekarang)}}</td>
                                </tr>
                            @endif
                            <!-- end menampilkan total group mncgroup di publisher -->
                        @else 
                            @if($of->group_id!=5)
                                @if($of->group_id!=12)
                                    @if($typeunit=="Publisher" && $of->group_id==3)
                                        <tr style="{{$color}}">
                                            <td>
                                                {{$nama}}
                                            </td>
                                            @foreach($sosmed as $row)
                                                @if($row->id==1)
                                                    <td>{{number_format($of->total_tw_sekarang + $cnnsprogram_tw_sekarang)}}</td>
                                                @endif

                                                @if($row->id==2)
                                                    <td>{{number_format($of->total_fb_sekarang + $cnnsprogram_fb_sekarang)}}</td>
                                                @endif

                                                @if($row->id==3)
                                                    <td>{{number_format($of->total_ig_sekarang + $cnnsprogram_ig_sekarang)}}</td>
                                                @endif

                                                @if($row->id==4)
                                                    <td>{{number_format($of->total_yt_sekarang + $cnnsprogram_yt_sekarang)}}</td>
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
                                                    <td>{{number_format($of->total_tw_sekarang)}}</td>
                                                @endif

                                                @if($row->id==2)
                                                    <td>{{number_format($of->total_fb_sekarang)}}</td>
                                                @endif

                                                @if($row->id==3)
                                                    <td>{{number_format($of->total_ig_sekarang)}}</td>
                                                @endif

                                                @if($row->id==4)
                                                    <td>{{number_format($of->total_yt_sekarang)}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endif
                            @endif
                        @endif
                        
                        {{-- @if($of->group_id!=5)
                            
                        @endif --}}
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
                        <td>{{number_format($of->total_yt_sekarang)}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>