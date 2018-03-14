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
    <tbody style="color:#222">
        @foreach($officialAndProgram as $a=>$b)
            @if($b->urut=="total")
                <?php $warna="background:#f2eff2;color:#222;font-weight:700";?>
            @else 
                <?php $warna="";?>
            @endif
            
            <tr style="{{$warna}}">
                <td>
                    @if($b->urut=="total")
                        Total
                    @elseif($b->urut=="corporate")
                        {{$b->unit_name}} Official
                    @else
                        {{$b->unit_sosmed_name}}
                    @endif
                </td>
                <td>{{number_format($b->tw)}}</td>
                <td>{{number_format($b->fb)}}</td>
                <td>{{number_format($b->ig)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>