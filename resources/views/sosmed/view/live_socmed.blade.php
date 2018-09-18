<div class="row">
    @foreach($sosmed as $row)
        @if($row->sosmed_id==1)
            <div class="col-lg-6">
                <div class="card card-accent-success">
                    <div class="card-header" bg-info>Twitter</div>
                    <div class="card-body">
                        <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==2)
            <div class="col-lg-6">
                <div class="card card-accent-primary">
                    <div class="card-header">Facebook</div>
                    <div class="card-body">
                        <div id="fb-root"></div>
    
                        {!! facebookFrame($row->unit_sosmed_account_id) !!}
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==3)
            <div class="col-lg-6">
                <div class="card card-accent-warning">
                    <div class="card-header">Instagram</div>
                    <div class="card-body">
                        {!! $row->unit_sosmed_account_id !!}
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==4)
            <div class="col-lg-6">
                <div class="card card-accent-danger">
                    <div class="card-header">Youtube</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2">
                                <img src="{{$youtube->snippet->thumbnails->default->url}}" alt="" class="img-fluid">
                            </div>
                            <div class="col-lg-6">
                                <a href="https://youtube.com/{{$youtube->snippet->customUrl}}" target="new target">
                                    <h3>{{$youtube->snippet->title}}</h3>
                                </a>
                                <p class="text-muted">{{number_format($youtube->statistics->subscriberCount)}} subscriber</p>
                            </div>
                            <div class="col-lg-3">
                                <a href="#" class="btn btn-youtube">SUBSCRIBE {{number_format($youtube->statistics->subscriberCount)}}</a></a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5>Statistik</h5>
                                <p class="small">Bergabung pada : {{date('d F Y',strtotime($youtube->snippet->publishedAt))}}</p>
                                <p>{{number_format($youtube->statistics->viewCount)}} x penayangan</p>
                            </div>
    
                            <div class="col-lg-6">
                                <h5>Detail</h5>
                                <p class="text-muted">Lokasi : {{$youtube->snippet->country}}</p>
                            </div>
                        </div>
    
                        <hr>
                        <div id="showYoutube">
                            <div class="row">
                                @foreach($activity as $row)
                                    <div class="col-lg-6" style="margin-bottom:10px;">
                                        {{youtubeUrl($row->contentDetails->upload->videoId)}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>