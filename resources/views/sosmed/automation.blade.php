<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Unit</th>
                @foreach($sosmed as $row)
                    <th></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $no=0; @endphp
            @foreach($unit as $un)
                @php $no++; @endphp
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$un->unit_name}}</td>
                    @foreach($un->sosmed as $sos)
                        @if($sos->sosmed_id==1)
                            <td>
                                <input type="number" class="form-control follower" placeholder="{{$sos->unit_sosmed_name}}" value="{{twitter_follower($sos->unit_sosmed_name)}}" required>
                            </td>
                        @elseif($sos->sosmed_id==2)
                            <td>
                                <input type="number" class="form-control follower" placeholder="{{$sos->unit_sosmed_name}}" value="{{facebook_follower($sos->unit_sosmed_account_id)}}" required>
                            </td>
                        @elseif($sos->sosmed_id==3)
                            <td>
                                <input type="number" class="form-control follower" placeholder="{{$sos->unit_sosmed_name}}" value="{{instagram_follower($sos->unit_sosmed_name)}}" required>
                            </td>
                        @elseif($sos->sosmed_id==4)
                            <td>
                                <input type="number" class="form-control follower" placeholder="{{$sos->unit_sosmed_name}}" value="{{youtube_follower($sos->unit_sosmed_account_id)}}" required>
                            </td>
                        @else 
                            <td>-</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{$unit->links()}}
</body>
</html>