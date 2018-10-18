@extends('layouts.cloud.main')

@section('content')
    <div id="domain" class="parallax section noover" data-stellar-background-ratio="0.7" style="background-image:url({{asset("template/cloud/uploads/parallax_11.jpg")}});">
        <div class="container">
            <div class="row text-center">
                <div class="customwidget text-center">
                        <h1 class="text-center" style="margin-top:-80px;">Unit Dashboard</h1>

                        <div class="col-lg-12 text-center">
                            <p>
                                Social Media Unit Dashboard adalah Portal Analytics untuk meningkatkan performance, memperkuat strategi, <br>dan menghemat waktu dalam mengontrol dan memonitor social media MNC Media Group Unit dan Competitor.
                            </p>
                        </div>
                        
                        <br><br><br><br>
                        <div class="col-lg-6 col-md-offset-3">
                            <a class="btn btn-primary" style="margin-top:10px;">TV</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">HARDNEWS</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">PRODUCTION HOUSE</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">NEWSPAPER</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">ARTIS MANAGEMENT</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">PAY TV</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">RADIO</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">ANIMATION PRODUCTION</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">MAGAZINE</a>
                            <a class="btn btn-default text-white" style="margin-top:10px;">KOL</a>
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
    
    <div class="parallax section db parallax-off" style="background:#0d91d3;padding:25px;">
        <div class="container">
            <div class="row logos">
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_01.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_02.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_03.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_04.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_05.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('template/cloud/uploads/logo_06.png')}}" alt="" class="img-repsonsive"></a>
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
						<ul>
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
						<ul>
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
						<ul>
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
						<ul>
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