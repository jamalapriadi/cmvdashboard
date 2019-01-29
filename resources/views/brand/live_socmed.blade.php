@extends('layouts.coreui.main')

@section('content')
<div class="card card-primary">
    <div class="card-header">SOCMED LIVE</div>
        <div class="card-body">
            <form action="{{URL::to('brand/live-socmed')}}" method="get">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Brand Unit</label>
                            <select name="unit" id="unit" class="form-control">
                                <option value="" disabled selected>--Pilih Unit--</option>
                                @foreach($unit as $row)
                                    <option value="{{$row->id}}" @if($row->id==$requnit) selected='selected' @endif>{{$row->brand_name_alias}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Account Type</label>
                            <select name="accounttype" id="accounttype" class="form-control">
                                <option value="brand">Brand</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="accountprogram"></div>

                    <div class="col-lg-3">
                        <button class="btn btn-primary" style="margin-top:25px;">
                            <i class="icon-display4"></i> Show
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($filter=="ada")
        <div class="row">
            @foreach($brand->sosmed as $row)
                @if($row->sosmed_id==1)
                    <div class="col-lg-6">
                        <div class="card card-accent-success" style="overflow:scroll">
                            <div class="card-header" bg-info>Twitter</div>
                            <div class="card-body">
                                <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        </div>
                    </div>
                @endif

                @if($row->sosmed_id==2)
                    <div class="col-lg-6">
                        <div class="card card-accent-primary" style="overflow:scroll">
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
                        <div class="card card-accent-warning" style="overflow:scroll">
                            <div class="card-header">Instagram</div>
                            <div class="card-body">
                                {!! $row->unit_sosmed_account_id !!}
                            </div>
                        </div>
                    </div>
                @endif

                @if($row->sosmed_id==4)
                    <div class="col-lg-6">
                        <div class="card card-accent-danger" style="overflow:scroll">
                            <div class="card-header">Youtube</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <img src="{{$youtube->snippet->thumbnails->default->url}}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-lg-6">
                                        @if(isset($youtube->snippet->customUrl))
                                            @php 
                                                $url=$youtube->snippet->customUrl;
                                            @endphp 
                                        @else 
                                            @php 
                                                $url="";
                                            @endphp
                                        @endif
                                        <a href="https://youtube.com/{{$url}}" target="new target">
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
                                    
                                    @if(isset($youtube->snippet->country))
                                        <div class="col-lg-6">
                                            <h5>Detail</h5>
                                            <p class="text-muted">Lokasi : {{$youtube->snippet->country}}</p>
                                        </div>
                                    @endif
                                </div>
            
                                <hr>
                                <div id="showYoutube">
                                    <div class="row">
                                        @if(isset($activity))
                                            @foreach($activity as $key=>$val)
                                                @if($key<4)
                                                    <div class="col-lg-6" style="margin-bottom:10px;">
                                                        @if(isset($val->contentDetails->upload))
                                                            {{youtubeUrl($val->contentDetails->upload->videoId)}}
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($row->sosmed_id==5)
                    <div class="col-lg-6">
                        <div class="card card-accent-warning" style="overflow:scroll">
                            <div class="card-header">Web</div>
                            <div class="card-body">
                                {{webUrl($row->unit_sosmed_account_id)}}
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    @endif
@stop

@section('js')
    <script>
        $(function(){
            $("#unit").select2();
        })
    </script>
@stop