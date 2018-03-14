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