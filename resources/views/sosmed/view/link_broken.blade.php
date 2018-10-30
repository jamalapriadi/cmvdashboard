@if($data['success']==true)
    @if(count($data['list']) > 0)
        <table class="table table-striped sticky-header" id="fixTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Type Sosmed</th>
                    <th>Type Unit</th>
                    <th>Account Name</th>
                    <th>Social Media</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $no=0; @endphp 
                @foreach($data['list'] as $row)
                    @php $no++; @endphp 
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$row->type_sosmed}}</td>
                        <td>{{$row->typeunit}}</td>
                        <td>
                            @if($row->sosmed_id==1)
                                <a href="https://www.twitter.com/{{$row->unit_sosmed_name}}" target="new target">{{$row->unit_sosmed_name}}</a>
                            @elseif($row->sosmed_id==2)
                                <a href="https://www.facebook.com/{!!$row->unit_sosmed_account_id!!}" target="new target">{{$row->unit_sosmed_name}}</a>
                            @elseif($row->sosmed_id==3)
                                <a href="https://www.instagram.com/{{$row->unit_sosmed_name}}" target="new target">{{$row->unit_sosmed_name}}</a>
                            @elseif($row->sosmed_id==4)
                                <a href="https://youtube.com/channel/{{$row->unit_sosmed_account_id}}" target="new target">{{$row->unit_sosmed_name}}</a>
                            @else 
                                {{$row->unit_sosmed_name}}
                            @endif
                        </td>
                        <td>{{$row->sosmed_name}}</td>
                        <td>
                            @if($row->sosmed_id!=0)
                                @if($row->sosmed_id==1)
                                    <input type="number" class="form-control follower" name="sosmed[{{$row->id}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{twitter_follower($row->unit_sosmed_name)}}" required>
                                @elseif($row->sosmed_id==2)
                                    <input type="number" class="form-control follower" name="sosmed[{{$row->id}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{facebook_follower($row->unit_sosmed_account_id)}}" required>
                                @elseif($row->sosmed_id==3)
                                    <input type="number" class="form-control follower" name="sosmed[{{$row->id}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{instagram_follower($row->unit_sosmed_name)}}" required>
                                @elseif($row->sosmed_id==4)
                                    <input type="number" class="form-control follower" name="sosmed[{{$row->id}}]" placeholder="{{$row->unit_sosmed_name}}" value="{{youtube_follower($row->unit_sosmed_account_id)}}" required>
                                @else 
    
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div id="pesan2"></div> 
        
        <hr>
        <div class="form-group">
            <button class="btn btn-primary">
                <i class="icon-floppy-disk"></i> Save
            </button>
        </div>
    @else 
        <div class="alert alert-success">Data Not Found</div>
    @endif
@else 
    <div class="alert alert-danger">Validasi Error</div>
@endif