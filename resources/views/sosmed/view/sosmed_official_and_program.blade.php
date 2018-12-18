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
            @foreach($unit as $of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        
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
                                    <td>{{number_format($of->tw_sekarang)}}</td>
                                    <td>{{number_format($of->fb_sekarang)}}</td>
                                    <td>{{number_format($of->ig_sekarang)}}</td>
                                    <td>{{number_format($of->yt_sekarang)}}</td>
                                </tr>
                            @endif
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
                        <td>{{number_format($of->tw_sekarang)}}</td>
                        <td>{{number_format($of->fb_sekarang)}}</td>
                        <td>{{number_format($of->ig_sekarang)}}</td>
                        <td>{{number_format($of->yt_sekarang)}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>