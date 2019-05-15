@extends('layouts.cloud.main')

@section('content')
<div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="false" >
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <!--
        <li data-target="#bootstrap-touch-slider" data-slide-to="0" class="active"></li>
        <li data-target="#bootstrap-touch-slider" data-slide-to="1"></li>
        <li data-target="#bootstrap-touch-slider" data-slide-to="2"></li>
        -->
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div id="home" class="first-section" style="background-image:url({{asset("template/cloud/uploads/slider-01.jpg")}});">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-center">
                            <div class="big-tagline" style="margin-top:-80px;">
                                <h2 data-animation="animated zoomInRight">SOCIAL MEDIA DASHBOARD</h2>
                                <p class="lead" data-animation="animated fadeInLeft">
                                    Portal Analytics untuk meningkatkan performance, memperkuat strategi, <br>
                                    melihat peluang kerjasama dan menghemat waktu dalam mengontrol dan memonitor social media
                                </p>
                                
                                <a data-scroll href="{{URL::to('unit')}}" class="btn btn-light btn-radius btn-brd effect-1 slide-btn" data-animation="animated fadeInLeft">UNIT</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a data-scroll href="{{URL::to('brands')}}" class="btn btn-light btn-radius btn-brd effect-1 slide-btn" data-animation="animated fadeInRight">BRAND</a>
                                
                            </div>
                        </div>
                    </div><!-- end row -->            
                </div><!-- end container -->
            </div><!-- end section -->
        </div>
    </div>
</div>
@stop