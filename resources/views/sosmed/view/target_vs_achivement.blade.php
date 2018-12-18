<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Channel</th>
            <th colspan='3' class='text-center' style='background:#008ef6;color:white'>Twitter</th>
            <th colspan='3' class='text-center' style='background:#5054ab;color:white'>Facebook</th>
            <th colspan='3' class='text-center' style='background:#a200b2;color:white'>Instagram</th>
        </tr>
        <tr>
            <th class='text-center' style='background:#008ef6;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
            <th class='text-center' style='background:#008ef6;color:white'>Target</th>
            <th class='text-center' style='background:#008ef6;color:white'>ACH</th>

            <th class='text-center' style='background:#5054ab;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
            <th class='text-center' style='background:#5054ab;color:white'>Target</th>
            <th class='text-center' style='background:#5054ab;color:white'>ACH</th>

            <th class='text-center' style='background:#a200b2;color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
            <th class='text-center' style='background:#a200b2;color:white'>Target</th>
            <th class='text-center' style='background:#a200b2;color:white'>ACH</th>
        </tr>
    </thead>
    <tbody style="color:#222">
        @foreach($targetVsAch as $row)
            @if($row->id==4)
                @for($a=0;$a< count($tambahanInews);$a++)
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