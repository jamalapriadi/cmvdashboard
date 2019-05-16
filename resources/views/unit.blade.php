@extends('layouts.cloud.main')

@section('css')
    <style>
        img.rcti{
            width:130px;
            height:50px;
        }

        img.mnctv{
            width:160px;
            height:50px;
        }

        img.gtv{
            width:130px;
            height:50px;
        }

        img.inews{
            width:180px;
            height:50px;
        }

        img.okezone{
            width:290px;
            height:150px;
            margin-top:-50px;
        }

        img.sindonews{
            width:230px;
            height:50px;
        }

        img.inews_01{
            width:180px;
            height:50px;
        }

        img.mncpicture{
            width:180px;
            height:80px;
        }

        img.smn{
            width:180px;
            height:80px;
        }

        img.mnc_channel{
            width:180px;
            height:60px;
        }

        img.mnc_vision{
            width:180px;
            height:60px;
        }

        img.mnc_play{
            width:180px;
            height:60px;
        }

        img.logonya{
            width:180px;
            height:60px;
        }

        img.globalradio{
            width:180px;
            height:80px;
        }

        img.rdi{
            width:180px;
            height:80px;
        }

        img.sindo_trijaya{
            width:180px;
            height:80px;
        }

        img.vradio{
            width:180px;
            height:80px;
        }

        img.mnc_animation{
            width:180px;
            height:80px;
        }

        img.highend{
            width:160px;
            height:80px;
        }

        img.just_for_kids{
            width:160px;
            height:80px;
        }

        img.sindo{
            width:180px;
            height:50px;
            margin-top:20px;
        }

        @media (min-width: 1281px) {
            
        }

        /* 
        ##Device = Laptops, Desktops
        ##Screen = B/w 1025px to 1280px
        */

        @media (min-width: 1025px) and (max-width: 1280px) {
            
        }

        /* 
        ##Device = Tablets, Ipads (portrait)
        ##Screen = B/w 768px to 1024px
        */

        @media (min-width: 768px) and (max-width: 1024px) {
            
        }

        /* 
        ##Device = Tablets, Ipads (landscape)
        ##Screen = B/w 768px to 1024px
        */

        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
            
        }

        /* 
        ##Device = Low Resolution Tablets, Mobiles (Landscape)
        ##Screen = B/w 481px to 767px
        */

        @media (min-width: 481px) and (max-width: 767px) {
            img.rcti{
                width:80px;
                height:30px;
            }   

            img.mnctv{
                width:110px;
                height:30px;
            }

            img.gtv{
                width:80px;
                height:30px;
            }

            img.inews{
                width:130px;
                height:30px;
            }

            img.okezone{
                width:120px;
                height:100px;
                margin-top:-35px;
            }

            img.sindonews{
                width:130px;
                height:30px;
            }

            img.inews_01{
                width:100px;
                height:30px;
            }

            img.mncpicture{
                width:130px;
                height:50px;
            }

            img.smn{
                width:130px;
                height:50px;
            }

            img.mnc_channel{
                width:110px;
                height:30px;
            }

            img.mnc_vision{
                width:110px;
                height:30px;
            }

            img.mnc_play{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.logonya{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.globalradio{
                width:110px;
                height:30px;
            }

            img.rdi{
                width:110px;
                height:30px;
            }

            img.sindo_trijaya{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.vradio{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.highend{
                width:130px;
                height:50px;
            }

            img.just_for_kids{
                width:130px;
                height:50px;
            }

            img.sindo{
                width:110px;
                height:30px;
                margin-top:20px;
            }
        }

        /* 
        ##Device = Most of the Smartphones Mobiles (Portrait)
        ##Screen = B/w 320px to 479px
        */

        @media (min-width: 320px) and (max-width: 480px) {
            img.rcti{
                width:80px;
                height:30px;
            }   

            img.mnctv{
                width:110px;
                height:30px;
            }

            img.gtv{
                width:80px;
                height:30px;
            }

            img.inews{
                width:130px;
                height:30px;
            }

            img.okezone{
                width:120px;
                height:100px;
                margin-top:-35px;
            }

            img.sindonews{
                width:130px;
                height:30px;
            }

            img.inews_01{
                width:100px;
                height:30px;
            }

            img.mncpicture{
                width:130px;
                height:50px;
            }

            img.smn{
                width:130px;
                height:50px;
            }

            img.mnc_channel{
                width:110px;
                height:30px;
            }

            img.mnc_vision{
                width:110px;
                height:30px;
            }

            img.mnc_play{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.logonya{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.globalradio{
                width:110px;
                height:30px;
            }

            img.rdi{
                width:110px;
                height:30px;
            }

            img.sindo_trijaya{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.vradio{
                width:110px;
                height:30px;
                margin-top:10px;
            }

            img.highend{
                width:130px;
                height:50px;
            }

            img.just_for_kids{
                width:130px;
                height:50px;
            }

            img.sindo{
                width:110px;
                height:30px;
                margin-top:20px;
            }

        }
    </style>
@stop

@section('content')
    <div id="domain" class="parallax section noover" data-stellar-background-ratio="0.7" style="background-image:url({{asset("template/cloud/uploads/parallax_11.jpg")}});">
        <div class="container">
            <div class="row text-center">
                <div class="customwidget text-center">
                        <h1 class="text-center">SOCIAL MEDIA UNIT DASHBOARD</h1>

                        <div class="col-lg-12 text-center">
                            <p>
                                    Portal Analytics untuk meningkatkan performance, memperkuat strategi,<br>
                                    dan menghemat waktu dalam mengontrol dan memonitor social media MNC Media Group Unit dan Competitor
                            </p>
                        </div>
                        
                        <br><br><br><br>
                        <div class="col-lg-6 col-md-offset-3" id="buttonnya">
                            <a class="btn unit btn-primary" style="margin-top:10px;" kode="1">TV</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="2">HARDNEWS</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="3">PRODUCTION HOUSE</a>
                            {{-- <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="4">NEWSPAPER</a> --}}
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="5">ARTIS MANAGEMENT</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="6">PAY TV</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="7">RADIO</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="8">ANIMATION PRODUCTION</a>
                            <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="10">MAGAZINE</a>
                            {{-- <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="10">KOL</a> --}}
                        </div>
                        
                        <!-- end list -->
                        <!--
                        <a href="#hosting" data-scroll class="btn btn-light grd1 effect-1 btn-radius btn-brd">Hosting Packages</a>
                        -->
                    </div>
                <!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
    
    <div class="parallax section db parallax-off" style="background:#fff;padding:25px;">
        <div class="container">
            <div class="row" id="listLogo">
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                        <a href="#">
                            <img src="{{asset('img/bu180x80/rcti.png')}}" alt="" class="img-repsonsive rcti">
                        </a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                        <a href="#">
                            <img src="{{asset('img/bu180x80/mnctv.png')}}" alt="" class="img-repsonsive mnctv">
                        </a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                    <a href="#"><img src="{{asset('img/bu180x80/gtv.png')}}" alt="" class="img-repsonsive gtv"></a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                    <a href="#"><img src="{{asset('img/bu180x80/inews.png')}}" alt="" class="img-repsonsive inews"></a>
                    </center>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="message-box">
                    <h2>Unit - Social Media Chart</h2>
                    <ul style="color:#222">
                        <li>
                            Mengetahui competitive mapping social media antara group media.
                        </li>
                        <li>
                            Mengetahui competitive mapping social media antara unit media.
                        </li>
                        <li>
                            Mengetahui competitive mapping social media antara media platform.
                        </li>
                    </ul>

                </div><!-- end messagebox -->
            </div><!-- end col -->
            
            <div class="col-md-6">
                <div class="post-media wow fadeIn">
                    <img src="{{asset('template/cloud/uploads/tes.png')}}" alt="" class="img-responsive img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
        </div><!-- end row -->

        <hr class="invis"> 

        <div class="row">
            <div class="col-md-6">
                <div class="post-media wow fadeIn">
                    <img src="{{asset('template/cloud/uploads/sosmedlive.png')}}" alt="" class="img-responsive img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
            <div class="col-md-6">
                <div class="message-box" style="margin-top:100px;">
                    <h2>Unit -Social Media Live</h2>
                    <ul style="color:#222">
                        <li>
                            Mengetahui jenis konten yang disukai oleh audiens social media MNC Media Group dan Competitor.
                        </li>
                        <li>
                            Mengetahui campaign dan activity terbaru yang dipublikasikan di social media MNC Media Group dan Competitor.
                        </li>
                        <li>
                            Mengetahui peluang kerjasama antar unit MNC Media Group, seperti Unit TV dengan Unit TV yg lain atau dengan unit - unit lain (Radio, Artis Management, Pay TV, dan lain lain).
                        </li>
                    </ul>

                </div><!-- end messagebox -->
            </div><!-- end col -->
        </div><!-- end row -->

        <hr class="hr3"> 
        
        <div class="row">
            <div class="col-md-6">
                <div class="message-box" style="margin-top:100px;">
                    <h2>Unit - Social Media Chart</h2>
                    <ul style="color:#222">
                        <li>
                            Mengetahui lonjakan followers social media yang dapat disebabkan dengan berbagai hal (partnership, campaign, konten social media).
                        </li>
                        <li>
                            Sebagai benchmark untuk meningkatkan performance social media masing – masing unit.
                        </li>
                    </ul>

                </div><!-- end messagebox -->
            </div><!-- end col -->
            
            <div class="col-md-6">
                <div class="post-media wow fadeIn">
                    <img src="{{asset('template/cloud/uploads/mediareport.png')}}" alt="" class="img-responsive img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
        </div><!-- end row -->
        
        <hr class="hr3">
        <div class="row">
            <div class="col-md-6">
                <div class="post-media wow fadeIn">
                    <img src="{{asset('template/cloud/uploads/mediainsight.png')}}" alt="" class="img-responsive img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
            <div class="col-md-6">
                <div class="message-box" style="margin-top:100px;">
                    <h2>Unit - Social Media Insight</h2>
                    <ul style="color:#222">
                        <li>
                            Memaparkan segala insight media digital lokal maupun internasional, yang concern terhadap strategi dan inovasi.
                        </li>
                    </ul>

                </div><!-- end messagebox -->
            </div><!-- end col -->
        </div><!-- end row -->
        
    </div><!-- end container -->
@stop

@section('js')
    <script>
        $(function(){
            function changeUnit(unit){
                var el="";
                if(unit==1){
                    /* tv */
                    el+='<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/rcti.png')}}" alt="" class="img-repsonsive rcti"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/mnctv.png')}}" alt="" class="img-repsonsive mnctv"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/gtv.png')}}" alt="" class="img-repsonsive gtv"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/inews.png')}}" alt="" class="img-repsonsive inews"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==2){
                    /* hardnews publisher*/
                    el+='<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/okezonenew.png')}}" alt="" class="img-repsonsive okezone"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/sindonews.png')}}" alt="" class="img-repsonsive sindonews"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-12 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/inews_01.png')}}" alt="" class="img-repsonsive inews_01"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==3){
                    /* production house */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/mncpicture.png')}}" alt="" class="img-repsonsive mncpicture"></a>'+
                    '</div>';
                }else if(unit==4){
                    /* news paper */
                }else if(unit==5){
                    /* artist management */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/smn.png')}}" alt="" class="img-repsonsive smn"></a>'+
                    '</div>';
                }else if(unit==6){
                    /* pay tv */
                    el+='<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_channel.png')}}" alt="" class="img-repsonsive mnc_channel"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_vision.png')}}" alt="" class="img-repsonsive mnc_vision"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_play.png')}}" alt="" class="img-repsonsive mnc_play"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/logo.png')}}" alt="" class="img-repsonsive logonya"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==7){
                    /* radio */
                    el+='<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/globalradio.png')}}" alt="" class="img-repsonsive globalradio"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/rdi.png')}}" alt="" class="img-repsonsive rdi"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/radio/sindo_trijaya.png')}}" alt="" class="img-repsonsive sindo_trijaya"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/vradio.png')}}" alt="" class="img-repsonsive vradio"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==8){
                    /* animation production */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/animation/mnc_animation.png')}}" alt="" class="img-repsonsive mnc_animation"></a>'+
                    '</div>';
                }else if(unit==9){
                    
                }else if(unit==10){
                    /* magazine */
                    el+='<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/highend.png')}}" alt="" class="img-repsonsive highend"></a>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/just_for_kids.png')}}" alt="" class="img-repsonsive just_for_kids"></a>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/sindo.png')}}" alt="" class="img-repsonsive sindo"></a>'+
                    '</div>';
                }
                $("#listLogo").empty().html(el);
            }

            $(document).on("click",".unit",function(){
                var unit=$(this).attr("kode");
                $("#buttonnya").find('div, ul, li, span, a').removeClass('btn-primary').addClass("btn-default");

                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');

                changeUnit(unit);
            })
        })
    </script>
@stop