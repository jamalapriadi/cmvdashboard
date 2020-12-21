@extends('layouts.coreui.main')

@section('extra-style')
    <style>
        /* Profile Section */
    
        .profile {
            padding: 5rem 0;
        }
    
        .profile::after {
            content: "";
            display: block;
            clear: both;
        }
    
        .profile-image {
            float: left;
            width: calc(33.333% - 1rem);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 3rem;
        }
    
        .profile-image img {
            border-radius: 50%;
        }
    
        .profile-user-settings,
        .profile-stats,
        .profile-bio {
            float: left;
            width: calc(66.666% - 2rem);
        }
    
        .profile-user-settings {
            margin-top: 1.1rem;
        }
    
        .profile-user-name {
            display: inline-block;
            font-size: 3.2rem;
            font-weight: 300;
        }
    
        .profile-edit-btn {
            font-size: 1.4rem;
            line-height: 1.8;
            border: 0.1rem solid #dbdbdb;
            border-radius: 0.3rem;
            padding: 0 2.4rem;
            margin-left: 2rem;
        }
    
        .profile-settings-btn {
            font-size: 2rem;
            margin-left: 1rem;
        }
    
        .profile-stats {
            margin-top: 2.3rem;
        }
    
        .profile-stats li {
            display: inline-block;
            font-size: 1.6rem;
            line-height: 1.5;
            margin-right: 4rem;
            cursor: pointer;
        }
    
        .profile-stats li:last-of-type {
            margin-right: 0;
        }
    
        .profile-bio {
            font-size: 1.6rem;
            font-weight: 400;
            line-height: 1.5;
            margin-top: 2.3rem;
        }
    
        .profile-real-name,
        .profile-stat-count,
        .profile-edit-btn {
            font-weight: 600;
        }
    
        /* Gallery Section */
    
        .gallery {
            display: flex;
            flex-wrap: wrap;
            margin: -1rem -1rem;
            padding-bottom: 3rem;
        }
    
        .gallery-item {
            position: relative;
            flex: 1 0 22rem;
            margin: 1rem;
            color: #fff;
            cursor: pointer;
        }
    
        .gallery-item:hover .gallery-item-info,
        .gallery-item:focus .gallery-item-info {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            width: 90%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }
    
        .gallery-item-info {
            display: none;
        }
    
        .gallery-item-info li {
            display: inline-block;
            font-weight: 600;
        }
    
        .gallery-item-likes {
            margin-right: 2.2rem;
        }
    
        .gallery-item-type {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 2.5rem;
            text-shadow: 0.2rem 0.2rem 0.2rem rgba(0, 0, 0, 0.1);
        }
    
        .fa-clone,
        .fa-comment {
            transform: rotateY(180deg);
        }
    
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    
        /* Loader */
    
        .loader {
            width: 5rem;
            height: 5rem;
            border: 0.6rem solid #999;
            border-bottom-color: transparent;
            border-radius: 50%;
            margin: 0 auto;
            animation: loader 500ms linear infinite;
        }
    
        /* Media Query */
    
        @media screen and (max-width: 40rem) {
            .profile {
                display: flex;
                flex-wrap: wrap;
                padding: 4rem 0;
            }
    
            .profile::after {
                display: none;
            }
    
            .profile-image,
            .profile-user-settings,
            .profile-bio,
            .profile-stats {
                float: none;
                width: auto;
            }
    
            .profile-image img {
                width: 7.7rem;
            }
    
            .profile-user-settings {
                flex-basis: calc(100% - 10.7rem);
                display: flex;
                flex-wrap: wrap;
                margin-top: 1rem;
            }
    
            .profile-user-name {
                
            }
    
            .profile-edit-btn {
                order: 1;
                padding: 0;
                text-align: center;
                margin-top: 1rem;
            }
    
            .profile-edit-btn {
                margin-left: 0;
            }
    
            .profile-bio {
                margin-top: 1.5rem;
            }
    
            .profile-edit-btn,
            .profile-bio,
            .profile-stats {
                flex-basis: 100%;
            }
    
            .profile-stats {
                order: 1;
                margin-top: 1.5rem;
            }
    
            .profile-stats ul {
                display: flex;
                text-align: center;
                padding: 1.2rem 0;
                border-top: 0.1rem solid #dadada;
                border-bottom: 0.1rem solid #dadada;
            }
    
            .profile-stats li {
                flex: 1;
                margin: 0;
            }
    
            .profile-stat-count {
                display: block;
            }
        }
    
        /* Spinner Animation */
    
        @keyframes loader {
            to {
                transform: rotate(360deg);
            }
        }
    
        /*
    
        The following code will only run if your browser supports CSS grid.
    
        Remove or comment-out the code block below to see how the browser will fall-back to flexbox & floated styling. 
    
        */
    
        @supports (display: grid) {
            .profile {
                display: grid;
                grid-template-columns: 1fr 2fr;
                grid-template-rows: repeat(3, auto);
                grid-column-gap: 3rem;
                align-items: center;
            }
    
            .profile-image {
                grid-row: 1 / -1;
            }
    
            .gallery {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(22rem, 1fr));
                grid-gap: 2rem;
            }
    
            .profile-image,
            .profile-user-settings,
            .profile-stats,
            .profile-bio,
            .gallery-item,
            .gallery {
                width: auto;
                margin: 0;
            }
    
            @media (max-width: 40rem) {
                .profile {
                    grid-template-columns: auto 1fr;
                    grid-row-gap: 1.5rem;
                }
    
                .profile-image {
                    grid-row: 1 / 2;
                }
    
                .profile-user-settings {
                    display: grid;
                    grid-template-columns: auto 1fr;
                    grid-gap: 1rem;
                }
    
                .profile-edit-btn,
                .profile-stats,
                .profile-bio {
                    grid-column: 1 / -1;
                }
    
                .profile-user-settings,
                .profile-edit-btn,
                .profile-settings-btn,
                .profile-bio,
                .profile-stats {
                    margin: 0;
                }
            }
        }
    </style>
@stop

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
                                    @if($row->unit_name != "INEWS (4TV News)")
                                        <option value="{{$row->id}}" @if($unit==$row->id) selected='selected' @endif>{{$row->unit_name}}</option>
                                    @endif
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
                                    @if($row->ig_profile_picture_url !=null)
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="profile-image">
                                                    <br><br>
                                                    <img src="{{$row->ig_profile_picture_url}}" alt="" class="img-responsive img-circle">
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                    <div class="profile-user-settings">
                                                        <h1 class="profile-user-name">{{$row->ig_username}}</h1>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <span class="profile-stat-count">{{hitungk($row->ig_published_post)}}</span> posts
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <span class="profile-stat-count">{{hitungk($row->ig_follows)}}</span> followers
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <span class="profile-stat-count">{{hitungk($row->ig_followers)}}</span> following
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{$row->ig_fullname}} <br>
                                                        {{$row->ig_biography}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                        <hr style="border:0.3px solid lightgray">

                                        <div class="row" style="max-height:400px; overflow:scroll">
                                            @foreach ($medias as $media)
                                                <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="{{$media->get_link}}/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="13" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                                                    <div style="padding:16px;"> 
                                                        <a href="{{$media->get_link}}/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> 
                                                            <div style=" display: flex; flex-direction: row; align-items: center;"> 
                                                                <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> 
                                                                <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> 
                                                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> 
                                                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                                                                </div>
                                                            </div>
                                                            <div style="padding: 19% 0;"></div> 
                                                            <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                                                                <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                                                                            <g>
                                                                                <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div style="padding-top: 8px;"> 
                                                                <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div>
                                                            </div>
                                                            <div style="padding: 12.5% 0;"></div> 
                                                            <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">
                                                                <div> 
                                                                    <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> 
                                                                    <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> 
                                                                    <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>
                                                                </div>
                                                                <div style="margin-left: 8px;"> 
                                                                    <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> 
                                                                    <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>
                                                                </div>
                                                                <div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> 
                                                                <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> 
                                                                <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>
                                                            </div>
                                                        </div> 
                                                        <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> 
                                                            <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> 
                                                            <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>
                                                        </div>
                                                        </a>
                                                        <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">
                                                            <a href="{{$media->get_link}}/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">
                                                                A post shared by {{$row->ig_fullname}} (@{{$row->ig_username}})
                                                            </a>
                                                        </p>
                                                    </div>
                                                </blockquote> <script async src="//www.instagram.com/embed.js"></script>	
                                            @endforeach
                                        </div>
                                    @else 
                                        <div class="alert alert-danger">Instagram Not Found</div>
                                    @endif
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

                <div class="col-lg-6">
                    <div class="card card-default" style="overflow:scroll">
                        <div class="card-header">Youtube</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    @if($youtube_json!=null)
                                        <img src="{{$youtube_json['snippet']['thumbnails']['default']['url']}}" alt="" class="img-responsive">
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    @if($youtube_json!=null)
                                        @if(isset($youtube_json['snippet']['customUrl']))
                                            @php 
                                                $url=$youtube_json['snippet']['customUrl'];
                                            @endphp 
                                        @else 
                                            @php 
                                                $url="";
                                            @endphp
                                        @endif
                                        <a href="https://youtube.com/{{$url}}" target="new target">
                                            <h3>{{$youtube_json['snippet']['title']}}</h3>
                                        </a>
                                        <p class="text-muted">{{number_format($youtube_json['statistics']['subscriberCount'])}} subscriber</p>
                                    @endif
                                </div>
                                <div class="col-lg-3">
                                    @if($youtube_json!=null)
                                        <a href="#" class="btn btn-youtube btn-danger">SUBSCRIBE {{number_format($youtube_json['statistics']['subscriberCount'])}}</a></a>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    @if($youtube_json!=null)
                                        <h5>Statistik</h5>
                                        <p class="small">Bergabung pada : {{date('d F Y',strtotime($youtube_json['snippet']['publishedAt']))}}</p>
                                        <p>{{number_format($youtube_json['statistics']['viewCount'])}} x penayangan</p>
                                    @endif
                                </div>

                                @if($youtube_json!=null)
                                    @if(isset($youtube_json['snippet']['country']))
                                        <div class="col-lg-6">
                                            <h5>Detail</h5>
                                            <p class="text-muted">Lokasi : {{$youtube_json['snippet']['country']}}</p>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <hr>
                            <div id="showYoutube">
                                <div class="row">
                                    @if(is_array($youtube_activity))
                                        @foreach($youtube_activity as $key=>$row)
                                            @if($key<4)
                                                <div class="col-lg-6" style="margin-bottom:10px;">
                                                    @if(isset($row['contentDetails']['upload']))
                                                        {{youtubeUrl($row['contentDetails']['upload']['videoId'])}}
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