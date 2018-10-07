<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Login</title>
    <link href="{{asset('template/coreui/node_modules/@coreui/icons/css/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/node_modules/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{asset('template/coreui/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('template/coreui/vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">
</head>
<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2>Sign up</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <button class="btn btn-primary active mt-3" type="button">Register Now!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('template/coreui/node_modules/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/pace-progress/pace.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('template/coreui/node_modules/@coreui/coreui/dist/js/coreui.min.js')}}"></script>
</body>
</html>