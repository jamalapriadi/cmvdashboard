<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Consumer Media View</title>
  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  {{Html::style('limitless1/assets/css/icons/icomoon/styles.css')}}
  
  <script src="{{URL::asset('limitless1/assets/js/core/libraries/jquery.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery.sparkline.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/selectize.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery.tablesorter.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-2.0.3.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-de-merc.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-world-mill.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/circle-progress.min.js')}}"></script>

  <!--DATATABLE AND CKEDITOR -->
  {{Html::script('limitless1/ckeditor/ckeditor.js')}}

  <!-- Theme JS files -->
  {{Html::script('limitless1/assets/js/plugins/tables/datatables/datatables.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/tables/datatables/extensions/col_vis.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/uniform.min.js')}}
  {{Html::script('limitless1/assets/js/core/libraries/jquery_ui/interactions.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/selects/select2.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/notifications/pnotify.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/switchery.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/switch.min.js')}}

  {{Html::style('limitless1/assets/js/plugins/sweetalert/dist/sweetalert.css')}}
  {{Html::script('limitless1/assets/js/plugins/sweetalert/dist/sweetalert.min.js')}}
  
  <!-- Dashboard Core -->
  <link href="{{URL::asset('tabler/assets/css/dashboard.css')}}" rel="stylesheet" />
  <link href="{{URL::asset('tabler/assets/css/cmv.css')}}" rel="stylesheet" />
  @yield('css')
</head>
<body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="{{URL::to('cmv')}}">
                <!-- <img src="{{URL::asset('tabler/demo/brand/tabler.svg')}}" class="header-brand-img" alt="tabler logo"> -->
                <img src="{{URL::asset('klorofil/img/mnc2.png')}}" class="header-brand-img">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex">
                  <a class="nav-link icon" data-toggle="dropdown">
                    <i class="fe fe-bell"></i>
                    <span class="nav-unread"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/male/41.jpg)"></span>
                      <div>
                        <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                        <div class="small text-muted">10 minutes ago</div>
                      </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/1.jpg)"></span>
                      <div>
                        <strong>Alice</strong> started new task: Tabler UI design.
                        <div class="small text-muted">1 hour ago</div>
                      </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/18.jpg)"></span>
                      <div>
                        <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                        <div class="small text-muted">2 hours ago</div>
                      </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                  </div>
                </div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{auth()->user()->name}}</span>
                      <small class="text-muted d-block mt-1">Administrator</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a href="{{ route('logout') }}" class="dropdown-item"
                              onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"><i class="dropdown-icon fe fe-log-out"></i> Sign out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="{{URL::to('cmv')}}" class="{{ Request::path() == 'cmv' ? 'nav-link active' : 'nav-link' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/brand')}}"  class="{{ Request::path() == 'cmv/chart/brand' ? 'nav-link active' : 'nav-link' }}"><i class="fe fe-pie-chart"></i> Brand</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/competitive-map')}}"  class="{{ Request::path() == 'cmv/chart/competitive-map' ? 'nav-link active' : 'nav-link' }}"><i class="fa fa-newspaper-o"></i>  Competitive Map</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/by-target-audience')}}"  class="{{ Request::path() == 'cmv/chart/by-target-audience' ? 'nav-link active' : 'nav-link' }}"><i class="fa fa-street-view"></i> Target Audience</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="@if(Request::path()=='cmv/sector' || Request::path()=='cmv/category' ||  Request::path()=='cmv/brand'
                     ||  Request::path()=='cmv/demography' ||  Request::path()=='cmv/target-audience' ||  Request::path()=='cmv/variabel' ) nav-link active @else nav-link @endif" data-toggle="dropdown"><i class="fe fe-box"></i> Master Data</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="{{URL::to('cmv/sector')}}" class="{{ Request::path() == 'cmv/sector' ? 'dropdown-item active' : 'dropdown-item' }}">Sector</a>
                      <a href="{{URL::to('cmv/category')}}" class="{{ Request::path() == 'cmv/category' ? 'dropdown-item active' : 'dropdown-item' }}">Category</a>
                      <a href="{{URL::to('cmv/brand')}}" class="{{ Request::path() == 'cmv/brand' ? 'dropdown-item active' : 'dropdown-item' }}">Brand</a>
                      <a href="{{URL::to('cmv/demography')}}" class="{{ Request::path() == 'cmv/demography' ? 'dropdown-item active' : 'dropdown-item' }}">Demography</a>
                      <a href="{{URL::to('cmv/target-audience')}}" class="{{ Request::path() == 'cmv/target-audience' ? 'dropdown-item active' : 'dropdown-item' }}">Target Audience</a>
                      <a href="{{URL::to('cmv/variabel')}}" class="{{ Request::path() == 'cmv/variabel' ? 'dropdown-item active' : 'dropdown-item' }}">Variabel</a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
            @yield('content')
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © {{date('Y')}} <a href="#">MNC Marketing Strategic</a>. Theme by <a href="https://codecalm.net" target="_blank">codecalm.net</a> All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
    @yield('js')
  </body>
</html>