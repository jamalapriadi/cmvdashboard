@extends('layouts.cloud.main')

@section('content')
    <div id="domain" class="parallax section noover" data-stellar-background-ratio="0.7" style="background-image:url({{asset("template/cloud/uploads/parallax_11.jpg")}});">
        <div class="container">
            <div class="row text-center">
                <div class="customwidget text-center">
                        <h1 class="text-center" style="margin-top:-80px;">SOCIAL MEDIA UNIT DASHBOARD</h1>

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
                    <a href="#"><img src="{{asset('img/bu180x80/rcti.png')}}" alt="" class="img-repsonsive" style="width:130px;height:50px;"></a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                    <a href="#"><img src="{{asset('img/bu180x80/mnctv.png')}}" alt="" class="img-repsonsive" style="width:160px;height:50px;"></a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                    <a href="#"><img src="{{asset('img/bu180x80/gtv.png')}}" alt="" class="img-repsonsive" style="width:130px;height:50px;"></a>
                    </center>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">
                    <center>
                    <a href="#"><img src="{{asset('img/bu180x80/inews.png')}}" alt="" class="img-repsonsive" style="width:180px;height:50px;"></a>
                    </center>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="message-box" style="margin-top:100px;">
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
    </div><!-- end section -->
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
                        '<a href="#"><img src="{{asset('img/bu180x80/rcti.png')}}" alt="" class="img-repsonsive" style="width:130px;height:50px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/mnctv.png')}}" alt="" class="img-repsonsive" style="width:160px;height:50px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/gtv.png')}}" alt="" class="img-repsonsive" style="width:130px;height:50px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/inews.png')}}" alt="" class="img-repsonsive" style="width:180px;height:50px;"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==2){
                    /* hardnews publisher*/
                    el+='<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/okezonenew.png')}}" alt="" class="img-repsonsive" style="width:290px;height:150px;margin-top:-50px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/sindonews.png')}}" alt="" class="img-repsonsive" style="width:230px;height:50px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/inews_01.png')}}" alt="" class="img-repsonsive" style="width:180px;height:50px;"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==3){
                    /* production house */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/mncpicture.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                    '</div>';
                }else if(unit==4){
                    /* news paper */
                }else if(unit==5){
                    /* artist management */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/smn.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                    '</div>';
                }else if(unit==6){
                    /* pay tv */
                    el+='<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_channel.png')}}" alt="" class="img-repsonsive" style="width:180px;height:60px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_vision.png')}}" alt="" class="img-repsonsive" style="width:180px;height:60px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/mnc_play.png')}}" alt="" class="img-repsonsive" style="width:180px;height:60px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/pay_tv/logo.png')}}" alt="" class="img-repsonsive" style="width:180px;height:60px;"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==7){
                    /* radio */
                    el+='<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/globalradio.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/rdi.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/radio/sindo_trijaya.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                        '</center>'+
                    '</div>'+
                    '<div class="col-md-3 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<center>'+
                        '<a href="#"><img src="{{asset('img/bu180x80/vradio.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                        '</center>'+
                    '</div>';
                }else if(unit==8){
                    /* animation production */
                    el+='<div class="col-md-8 col-sm-2 col-xs-6 col-md-offset-2 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/animation/mnc_animation.png')}}" alt="" class="img-repsonsive" style="width:180px;height:80px;"></a>'+
                    '</div>';
                }else if(unit==9){
                    
                }else if(unit==10){
                    /* magazine */
                    el+='<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/highend.png')}}" alt="" class="img-repsonsive" style="width:160px;height:80px;"></a>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/just_for_kids.png')}}" alt="" class="img-repsonsive" style="width:160px;height:80px;"></a>'+
                    '</div>'+
                    '<div class="col-md-4 col-sm-2 col-xs-6 wow fadeInUp">'+
                        '<a href="#"><img src="{{asset('img/bu180x80/magazine/sindo.png')}}" alt="" class="img-repsonsive" style="width:180px;height:50px;margin-top:20px;"></a>'+
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