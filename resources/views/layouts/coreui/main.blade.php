<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="{{asset('template/coreui/node_modules/@coreui/icons/css/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{asset('template/coreui/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="{{asset('js/pickadate/lib/themes/default.css')}}" id="theme_base">
    <link rel="stylesheet" href="{{asset('js/pickadate/lib/themes/default.date.css')}}" id="theme_date">
    <link rel="stylesheet" href="{{asset('js/pickadate/lib/themes/default.time.css')}}" id="theme_time">

    {{Html::style('css/icons/icomoon/styles.css')}}

    @yield('extra-style')

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.coreui.partials.header')

    <div class="app-body">
        @include('layouts.coreui.partials.sidebar')
        <main class="main">
            <!-- Breadcrumb-->
            @include('layouts.coreui.partials.breadcrumbs')
            
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

        @include('layouts.coreui.partials.right-sidebar')
    </div>

    <footer class="app-footer">
        <div>
            <a href="#">Dashboard Analytics</a>
            <span>&copy; M3S</span>
        </div>
        <div class="ml-auto">
            <span>Powered by</span>
            <a href="#">CoreUI</a>
        </div>
    </footer>

    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('template/coreui/node_modules/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/pace-progress/pace.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/@coreui/coreui/dist/js/coreui.min.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.uniform@4.2.2/dist/js/jquery.uniform.standalone.min.js"></script>


    <!-- pickadate -->
    <script src="{{asset('js/pickadate/lib/picker.js')}}"></script>
    <script src="{{asset('js/pickadate/lib/picker.date.js')}}"></script>
    <script src="{{asset('js/pickadate/lib/picker.time.js')}}"></script>
    <script src="{{asset('js/pickadate/lib/legacy.js')}}"></script>

    <!-- pnotify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>

    @yield('js')
</body>
</html>