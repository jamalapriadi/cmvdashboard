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
                    <div class="col-lg-8 col-md-offset-2" id="buttonnya">
                        <a class="btn unit btn-primary" style="margin-top:10px;" kode="1">Unilever</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Mayora Indah Group</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Wings Group</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Indofood Group</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Djarum Kudus</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">P&G Home Product Indonesia</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Kalbe Group</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">Danone Group</a>
                        <a class="btn unit btn-default text-white" style="margin-top:10px;" kode="1">dan lainnya</a>
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

    <div class="parallax section db parallax-off" style="background:#ffffff;padding:25px;">
        <div class="container">
            <div class="row logos" id="listLogo">
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/brand.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/domestos.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/lipton.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/dove.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/vaseline.png')}}" alt="" class="img-repsonsive"></a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                    <a href="#"><img src="{{asset('img/brand180x80/ponds.png')}}" alt="" class="img-repsonsive"></a>
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
                        <h2>Brand - Social Media Live</h2>
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

@section('js')
    <script>
        $(function(){
            function changeUnit(unit){
                var el="";
                
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