@extends('layouts.cloud.main')

@section('content')
    <div id="domain" class="parallax section noover" data-stellar-background-ratio="0.7" style="background-image:url({{asset("template/cloud/uploads/parallax_11.jpg")}});">
        <div class="container">
            <div class="row text-center">
                <div class="customwidget text-center">
                    <h1 class="text-center" style="margin-top:-80px;">Social Media Brand Dashboard</h1>
                    <div class="col-lg-12 text-center">
                        <p>Social Media Brands adalah Portal Analytics untuk melihat peluang kerjasama <br>campaign antara MNC Media dengan Brand.</p>
                    </div>
                    
                    <br><br><br><br>
                    <div class="col-lg-8 col-md-offset-2">
                        <a class="btn btn-primary" style="margin-top:10px;">Unilever</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Mayora Indah Group</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Wings Group</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Indofood Group</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Djarum Kudus</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">P&G Home Product Indonesia</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Kalbe Group</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">Danone Group</a>
                        <a class="btn btn-default text-white" style="margin-top:10px;">dan lainnya</a>
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
                        <h2>Brand - Social Media Chart</h2>
                        <ul>
                            <li>
                                Mengetahui competitive mapping social media antara brand.
                            </li>
                            <li>
                                Mengetahui competitive mapping social media antara advertiser brand.
                            </li>
                            <li>
                                Mengetahui competitive mapping social media antara category brand.
                            </li>
                            <li>
                                Mengetahui competitive mapping social media antara sector brand
                            </li>
                        </ul>

                    </div><!-- end messagebox -->
                </div><!-- end col -->
                
                <div class="col-md-6">
                    <div class="post-media wow fadeIn">
                        <img src="{{asset('template/cloud/uploads/brandunit.png')}}" alt="" class="img-responsive img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-md-6">
                    <div class="post-media wow fadeIn">
                        <img src="{{asset('template/cloud/uploads/brandlive.png')}}" alt="" class="img-responsive img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="message-box" style="margin-top:100px;">
                        <h2>Unit - Social Media Live</h2>
                        <ul>
                            <li>
                                Mengetahui jenis konten yang disukai oleh audiens social media brand Indonesia.
                            </li>
                            <li>
                                Mengetahui campaign dan activity terbaru yang dipublikasikan di social media brand Indonesia.
                            </li>
                            <li>
                                Mengetahui peluang kerjasama antar brand dengan unit MNC Media Group (TV, Radio, Hardnews, SMN Artist, dan lain lain).
                            </li>
                        </ul>

                    </div><!-- end messagebox -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-md-6">
                    <div class="message-box" style="margin-top:100px;">
                        <h2>Brand - Social Media Report</h2>
                        <ul>
                            <li>
                                Mengetahui lonjakan followers social media brand yang dapat disebabkan oleh berbagai faktor (partnership, campaign, konten social media).
                            </li>
                        </ul>

                    </div><!-- end messagebox -->
                </div><!-- end col -->
                
                <div class="col-md-6">
                    <div class="post-media wow fadeIn">
                        <img src="{{asset('template/cloud/uploads/brandreport.png')}}" alt="" class="img-responsive img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div>
@stop