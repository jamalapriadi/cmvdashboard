<!doctype html>
<html lang="en">

<head>
    <title>Dashboard | Social Media - @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="apple-touch-icon" sizes="76x76" href="klorofil/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="klorofil/img/favicon.png">

    @section('css')
        <!-- CSS -->
        {{Html::style('css/icons/icomoon/styles.css')}}
        {{ Html::style('klorofil/css/bootstrap.min.css')}}
        {{ Html::style('klorofil/css/vendor/icon-sets.css')}}
        {{ Html::style('klorofil/css/main.min.css')}}
        {{ Html::style('klorofil/css/demo.css')}}
        <link rel="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />

        @yield('extra-style')

        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @show
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- SIDEBAR -->
        @include("layouts/partials/sidebar")
        <!-- END SIDEBAR -->
        <!-- MAIN -->
        <div class="main">
            <!-- NAVBAR -->
            @include('layouts/partials/header')
            <!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
            <div class="main-content">
                @yield('content')
            </div>
            <!-- END MAIN CONTENT -->
            <footer>
                @include('layouts/partials/footer')
            </footer>
        </div>
        <!-- END MAIN -->
    </div>
    <!-- END WRAPPER -->

    @section('script')
    <!-- Javascript -->
        {{ Html::script('klorofil/js/jquery/jquery-2.1.0.min.js') }}
        {{ Html::script('klorofil/js/bootstrap/bootstrap.min.js') }}
        {{ Html::script('klorofil/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
        {{ Html::script('klorofil/js/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}
        {{ Html::script('klorofil/js/plugins/chartist/chartist.min.js') }}

        {{Html::script('assets/js/plugins/tables/datatables/datatables.min.js')}}
        {{Html::script('assets/js/plugins/tables/datatables/extensions/col_vis.min.js')}}
        <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
	    <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
        {{Html::script('assets/js/plugins/forms/styling/uniform.min.js')}}
        {{Html::script('assets/js/plugins/tables/datatables/extensions/tools.min.js')}}
        {{Html::script('assets/js/plugins/forms/styling/uniform.min.js')}}
        {{Html::script('assets/js/core/libraries/jquery_ui/interactions.min.js')}}
        {{Html::script('assets/js/plugins/forms/selects/select2.min.js')}}
        {{Html::script('assets/js/plugins/notifications/pnotify.min.js')}}

        {{Html::style('assets/js/plugins/sweetalert/dist/sweetalert.css')}}
        {{Html::script('assets/js/plugins/sweetalert/dist/sweetalert.min.js')}}

        {{ Html::script('klorofil/js/klorofil.min.js') }}

        @stack('extra-script')
    @show


</body>

</html>
