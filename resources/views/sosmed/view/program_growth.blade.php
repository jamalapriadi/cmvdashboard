<table class="table table-striped table-bordered sticky-header">
    <thead>
        <tr>
            <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white" valign="top">Channel</th>
            <th width="18%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">Unit</th>
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
    <tbody>
        @foreach($program as $of)
            <tr>
                <td>{{$of->program_name}}</td>
                <td>{{$of->unit_name}}</td>
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
        @endforeach
    </tbody>
</table>