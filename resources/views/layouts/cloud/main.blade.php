<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
     <!-- Site Metas -->
    <title>SOCIAL MEDIA DASHBOARD</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{asset('template/cloud/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('template/cloud/images/apple-touch-icon.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/css/bootstrap.min.css')}}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/style.css')}}">
    <!-- Colors CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/css/colors.css')}}">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/css/versions.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/css/responsive.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('template/cloud/css/custom.css')}}">

    <!-- Modernizer for Portfolio -->
    <script src="{{asset('template/cloud/js/modernizer.js')}}"></script>

    {{Html::style('css/icons/icomoon/styles.css')}}

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('css')
</head>
<body class="host_version"> 

	<!-- Modal -->
	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header tit-up">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Login</h4>
			</div>
			<div class="modal-body customer-box row">
				<div class="col-md-12">
                    <div id="pesanlogin"></div>
                    <form role="form" class="form-horizontal" onsubmit="return false;" id="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" name="email" id="email" placeholder="Email" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" id="exampleInputPassword1" placeholder="Password" type="password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="unit" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Unit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="brand">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Brand
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                    Submit
                                </button>
                                {{-- <a class="for-pwd" href="javascript:;">Forgot your password?</a> --}}
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	  </div>
	</div>

    <!-- LOADER -->
	<div id="preloader">
		<div class="loading">
			<div class="finger finger-1">
				<div class="finger-item">
				<span></span><i></i>
				</div>
			</div>
  			<div class="finger finger-2">
				<div class="finger-item">
				<span></span><i></i>
				</div>
			</div>
  			<div class="finger finger-3">
				<div class="finger-item">
				  <span></span><i></i>
				</div>
			</div>
  			<div class="finger finger-4">
				<div class="finger-item">
				<span></span><i></i>
				</div>
			</div>
  			<div class="last-finger">
				<div class="last-finger-item"><i></i></div>
			</div>
		</div>
	</div>
	<!-- END LOADER -->

    <header class="header header_style_01">
        <nav class="megamenu navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{URL::asset('klorofil/img/mnc2.png')}}" alt="image" style="width:110px;height:40px;"></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        @if(Request::path() == 'unit')
                            <li><a href="#">MNC Media Unit</a></li>
                            <li><a href="#">Media Competitor Unit</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if(auth()->check())
                            @if(Request::path() == 'unit')
                                <li><a class="btn-light bg-primary btn-radius btn-brd log" href="{{URL::to('home')}}"><i class="flaticon-server"></i> Home</a></li>
                            @elseif(Request::path() == 'brands')
                                <li><a class="btn-light btn-radius btn-brd log" href="{{URL::to('brand')}}"><i class="flaticon-server"></i> Home</a></li>
                            @else 
                                <li><a class="btn-light btn-radius btn-brd bg-primary log" href="{{URL::to('home')}}" target="new target"><i class="flaticon-server"></i> Home</a></li>
                            @endif
                        @else 
                            <li>
                                <a class="btn-light btn-radius btn-brd log" href="#" data-toggle="modal" data-target="#login"><i class="flaticon-padlock"></i> Login</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
	
    @yield('content')
    
    @if(Request::path() != '/')
        <section class="section nopad cac text-center">
            {{-- <a href="#"><h3>Interesting our awesome web design services? Just drop an email to us and get quote for free!</h3></a> --}}
        </section>
    
        <div class="copyrights">
            <div class="container">
                <div class="footer-distributed">
                    <div class="footer-left">                   
                        <p class="footer-company-name">All Rights Reserved. &copy; {{date('Y')}} Design By: <a href="{{URL::to('/')}}">System Process Development</a> Distributed By: <a href="#">Sales and Marketing MNC Media</a></p> 
                    </div>
    
                    <div class="footer-right">
                        <p class="footer-company-name">Contact Us: <a href="#">Rega Mulya Akbar<rega.akbar@mncgroup.com></a></p>
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->
    @endif

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="{{asset('template/cloud/js/all.js')}}"></script>
    <!-- ALL PLUGINS -->
    <script src="{{asset('template/cloud/js/custom.js')}}"></script>
    
    @yield('js')

</body>
</html>