@extends('layouts.coreui.main')

@section('content')
    <div class="card card-primary">
        <div class="card-header">SOCMED LIVE</div>
        <div class="card-body">
            <form action="{{URL::to('sosmed/live-socmed')}}" method="get">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Unit</label>
                            <select name="unit" id="unit" class="form-control select2">
                                @foreach($user->unit as $row)
                                    <option value="{{$row->id}}" @if($unit==$row->id) selected='selected' @endif>{{$row->unit_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="" class="control-label">Account Type</label>
                            <select name="accounttype" id="accounttype" class="form-control">
                                <option value="official" @if($accounttype=="official") selected='selected' @endif>Official</option>
                                <option value="program" @if($accounttype=="program") selected='selected' @endif>Program</option>
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

            <div class="row">
                @foreach($bu->sosmed as $row)
                    @if($row->sosmed_id==1)
                        <div class="col-lg-6">
                            <div class="card card-accent-success" style="overflow:scroll">
                                <div class="card-header" bg-info>Twitter</div>
                                <div class="card-body">
                                    @if($unit==4)
                                        <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_account_id}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_account_id}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    @else 
                                        <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    @endif
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
                            <div class="card card-accent-info">
                                <div class="card-header">Website</div>
                                <div class="card-body">
                                    <a href="{{$row->unit_sosmed_account_id}}" target="_blank">
                                        <img src="{{asset('uploads/web/'.$row->unit_sosmed_name)}}" alt="" class="img-fluid" target="_blank">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    
                @endforeach
            </div>
            
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function(){

            $(".select2").select2();
            
            function liveSocmed(){
                var unit=$("#unit").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+unit,
                    type:"GET",
                    data:"type=corporate",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#divLiveSocmed").empty().html(result);
                    },
                    errors:function(){

                    }
                })
            }

            $(document).on("change","#unit",function(){
                var accounttype=$("#accounttype option:selected").val();

                if(accounttype=="official"){
                    $("#accountprogram").empty();
                    liveSocmed();
                }else if(accounttype=="program"){
                    showProgram();
                }
            })

            $(document).on("click","#filtergroup",function(){
                var nm=$("#group option:selected").text();
                $("#namagroup").empty().html(nm);

                showgroup();
            })

            $(document).on("change","#accounttype",function(){
                var accounttype=$("#accounttype option:selected").val();

                if(accounttype=="official"){
                    /* langsung tampilkan */
                    $("#accountprogram").empty();
                    liveSocmed();
                }else if(accounttype=="program"){
                    /* tampilkan program berdasarkan unit ini*/
                    showProgram();
                }
            })

            function showProgram(){
                var accounttype=$("#accounttype option:selected").val();
                var unit=$("#unit option:selected").val();

                $.ajax({
                    url:"{{URL::to('sosmed/data/list-program-by-unit')}}/"+unit,
                    type:"GET",
                    beforeSend:function(){
                        $("#divLiveSocmed").empty();
                        $("#accountprogram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                    },
                    success:function(result){
                        var el="<div class='col-lg-12'>";
                        el+="<div class='form-group'>"+
                            '<label class="control-label">Program</label>'+
                            "<select name='program' id='program' class='form-control'>"+
                                '<option value="" disabled selected>--Select Program--</option>';
                                $.each(result,function(a,b){
                                    el+="<option value='"+b.id+"'>"+b.program_name+"</option>";
                                })
                            el+="</select>"+
                        "</div></div>";

                        $("#accountprogram").empty().html(el);
                    },
                    errors:function(){
                        $("#accountprogram").empty().html("<div class='alert alert-danger'>Failed to load data...</div>");
                    }
                })
            }

            function pilihProgram(){
                var accounttype="{{$accounttype}}";
                if(accounttype=="program"){
                    var p="{{$program}}";
                    
                    var accounttype=$("#accounttype option:selected").val();
                    var unit=$("#unit option:selected").val();

                    $.ajax({
                        url:"{{URL::to('sosmed/data/list-program-by-unit')}}/"+unit,
                        type:"GET",
                        beforeSend:function(){
                            $("#divLiveSocmed").empty();
                            $("#accountprogram").empty().html("<div class='alert alert-info'>Please Wait...</div>");
                        },
                        success:function(result){
                            var el="<div class='col-lg-12'>";
                            el+="<div class='form-group'>"+
                                '<label class="control-label">Program</label>'+
                                "<select name='program' id='program' class='form-control'>"+
                                    '<option value="" disabled selected>--Select Program--</option>';
                                    $.each(result,function(a,b){
                                        var pilih="";
                                        if(b.id==p){
                                            pilih="selected='selected'";
                                        }else{
                                            pilih="";
                                        }

                                        el+="<option value='"+b.id+"' "+pilih+">"+b.program_name+"</option>";
                                    })
                                el+="</select>"+
                            "</div></div>";

                            $("#accountprogram").empty().html(el);
                        },
                        errors:function(){
                            $("#accountprogram").empty().html("<div class='alert alert-danger'>Failed to load data...</div>");
                        }
                    })
                }
            }

            // $(document).on("change","#program",function(){
            //     var program=$("#program option:selected").val();

            //     $.ajax({
            //         url:"{{URL::to('sosmed/data/live-socmed-by-id')}}/"+program,
            //         type:"GET",
            //         data:"type=program",
            //         beforeSend:function(){
            //             $("#divLiveSocmed").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
            //         },
            //         success:function(result){
            //             $("#divLiveSocmed").empty().html(result);
            //         },
            //         errors:function(){

            //         }
            //     })
            // })

            // liveSocmed();
            pilihProgram();
        })
    </script>
@stop