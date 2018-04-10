<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard Sosial Media Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{URL::asset('klorofil/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('klorofil/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('klorofil/vendor/linearicons/style.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{URL::asset('klorofil/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	{{ Html::style('klorofil/css/demo.css')}}

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{URL::asset('klorofil/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{URL::asset('klorofil/img/favicon.png')}}">
</head>
<body>
    <div class="container">
        <div class="col-lg-8 col-lg-offset-2 text-center">
            <div class="logo">
                <h1>404</h1>
            </div>
            <p class="lead text-muted">Oops, Page is not found!</p>
            <div class="clearfix"></div>
            <div class="col-lg-6 col-lg-offset-3">
                <form action="#">
                    <div class="input-group">
                        <input type="text" placeholder="search ..." class="form-control">
                        <span class="input-group-btn">
              <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="sr-only">
                &nbsp;

            </div>
            <br>
            <div class="col-lg-6 col-lg-offset-3">
                <div class="btn-group btn-group-justified">
                    <a href="{{URL::to('home')}}" class="btn btn-info">Return Dashboard</a>
                </div>
            </div>
        </div>
        <!-- /.col-lg-8 col-offset-2 -->
    </div>
</body>
</html>