<div id="parent">
    <table class="table table-striped sticky-header" id="fixTable">
        <thead>
            <tr>
                <th rowspan="2" rowspan='2' style="background:#419F51;color:white" class="text-center">No.</th>
                <th rowspan="2" rowspan='2' style="background:#419F51;color:white" class="text-center">Type Sosmed</th>
                <th rowspan="2" rowspan='2' style="background:#419F51;color:white" class="text-center">Account Name</th>
                @if($sosmed=="twitter")
                    <th colspan="2" class='text-center' style='background:#008ef6;color:white'>{{$sosmed}}</th>
                @elseif($sosmed=="facebook")
                    <th colspan="2" class='text-center' style='background:#5054ab;color:white'>{{$sosmed}}</th>
                @elseif($sosmed=="instagram")
                    <th colspan="2" class='text-center' style='background:#a200b2;color:white'>{{$sosmed}}</th>
                @elseif($sosmed=="youtube")
                    <th colspan="2" class='text-center' style='background:#ff0000;color:white'>{{$sosmed}}</th>
                @else 
                    <th colspan="2" class="text-center">{{$sosmed}}</th>
                @endif
            </tr>
            <tr>    
                @if($sosmed=="twitter")
                    <th class='text-center' style='background:#008ef6;color:white'>Last Day</th>
                    <th class='text-center' style='background:#008ef6;color:white'>Today</th>
                @elseif($sosmed=="facebook")
                    <th class='text-center' style='background:#5054ab;color:white'>Last Day</th>
                    <th class='text-center' style='background:#5054ab;color:white'>Today</th>
                @elseif($sosmed=="instagram")
                    <th class='text-center' style='background:#a200b2;color:white'>Last Day</th>
                    <th class='text-center' style='background:#a200b2;color:white'>Today</th>
                @elseif($sosmed=="youtube")
                    <th class='text-center' style='background:#ff0000;color:white'>Last Day</th>
                    <th class='text-center' style='background:#ff0000;color:white'>Today</th>
                @else 
                    <th class='text-center' style='background:#008ef6;color:white'>Last Day</th>
                    <th class='text-center' style='background:#008ef6;color:white'>Today</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $no=0;?>
            @foreach($account as $row)
                <?php $no++;?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row->type_sosmed}}</td>
                    <td>
                        @if($idsosmed==1)
                            <a href="https://www.twitter.com/{{$row->unit_sosmed_name}}" target="new target">{{$row->unit_sosmed_name}}</a>
                        @elseif($idsosmed==2)
                            <a href="https://www.facebook.com/{!!$row->unit_sosmed_account_id!!}" target="new target">{{$row->unit_sosmed_name}}</a>
                        @elseif($idsosmed==3)
                            <a href="https://www.instagram.com/{{$row->unit_sosmed_name}}" target="new target">{{$row->unit_sosmed_name}}</a>
                        @elseif($idsosmed==4)
                            <a href="https://youtube.com/{{$row->unit_sosmed_name}}" target="new target">{{$row->unit_sosmed_name}}</a>
                        @else 
                            {{$row->unit_sosmed_name}}
                        @endif
                    </td>
                    <td>{{number_format($row->follower)}}
                        <input type="hidden" name="last[{{$row->idsosmed}}]" value="{{$row->follower}}">
                    </td>
                    <td>
                        @if($row->idsosmed!=0)
                            <input type="hidden" name="official[{{$row->idsosmed}}]" value="{{$row->unit_sosmed_name}}">
                            @if($idsosmed==1)
                                <input type="number" class="form-control follower" name="sosmed[{{$row->idsosmed}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{twitter_follower($row->unit_sosmed_name)}}" required>
                            @elseif($idsosmed==2)
                                <input type="number" class="form-control follower" name="sosmed[{{$row->idsosmed}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{facebook_follower($row->unit_sosmed_account_id)}}" required>
                            @elseif($idsosmed==3)
                                <input type="number" class="form-control follower" name="sosmed[{{$row->idsosmed}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{instagram_follower($row->unit_sosmed_name)}}" required>
                            @elseif($idsosmed==4)
                                <input type="number" class="form-control follower" name="sosmed[{{$row->idsosmed}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{youtube_follower($row->unit_sosmed_account_id)}}" required>
                            @else 

                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>