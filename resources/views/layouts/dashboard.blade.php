
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sales Activity Management</title>

	<!-- Global stylesheets -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	{{Html::style('limitless1/assets/css/icons/icomoon/styles.css')}}
	{{Html::style('limitless1/assets/css/minified/bootstrap.min.css')}}
	{{Html::style('limitless1/assets/css/minified/core.min.css')}}
	{{Html::style('limitless1/assets/css/minified/components.min.css')}}
	{{Html::style('limitless1/assets/css/minified/colors.min.css')}}
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	{{Html::script('limitless1/assets/js/plugins/loaders/pace.min.js')}}
	{{Html::script('limitless1/assets/js/core/libraries/jquery.min.js')}}
	{{Html::script('limitless1/assets/js/core/libraries/bootstrap.min.js')}}
	{{Html::script('limitless1/assets/js/plugins/loaders/blockui.min.js')}}
	{{Html::script('limitless1/assets/js/plugins/ui/nicescroll.min.js')}}
	{{Html::script('limitless1/assets/js/plugins/ui/drilldown.js')}}
	<!-- /core JS files -->

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


	<!-- Theme JS files -->
	{{Html::script('limitless1/assets/js/core/app.js')}}
	<!-- /theme JS files -->

	@yield('css')

</head>

<body class="pace-done sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{URL::to('home')}}">
               
            </a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li>
					<a class="sidebar-control sidebar-main-toggle hidden-xs">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="http://sm.mncgroup.com/mam1.1/uploads/public/user/thumb/{{Auth::user()->IMAGES}}" alt="Profile">
						<span>{{Auth::user()->name}}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{URL::to('home/profile')}}"><i class="icon-user-plus"></i> My profile</a></li>
						<li class="divider"></li>
						<li>
							<a href="{{ route('logout') }}"
								onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
								<i class="icon-switch2"></i> Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left">
                                    <img src="http://sm.mncgroup.com/mam1.1/uploads/public/user/thumb/{{Auth::user()->IMAGES}}" class='img-circle img-sm'>
                                </a>
								<div class="media-body">
									<span class="media-heading text-semibold">{{\Auth::user()->name}}</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;{{\Auth::user()->POSITION}}
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="#"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<li class="{{ Request::path() == 'cmv' ? 'active' : '' }}"><a href="{{URL::to('cmv')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
									<li>
										<a href="#"><i class="icon-pie-chart3"></i> <span>Master Data</span></a>
										<ul>
											<li class="{{ Request::path() == 'cmv/sector' ? 'active' : '' }}"><a href="{{URL::to('cmv/sector')}}">Sector</a></li>
											<li class="{{ Request::path() == 'cmv/category' ? 'active' : '' }}"><a href="{{URL::to('cmv/category')}}">Category</a></li>
											<li class="{{ Request::path() == 'cmv/brand' ? 'active' : '' }}"><a href="{{URL::to('cmv/brand')}}">Brand</a></li>
											<li class="{{ Request::path() == 'cmv/demography' ? 'active' : '' }}"><a href="{{URL::to('cmv/demography')}}">Demography</a></li>
										</ul>
									</li>
									<li class="{{ Request::path() == 'cmv/variabel' ? 'active' : '' }}"><a href="{{URL::to('cmv/variabel')}}"><i class="icon-import"></i> <span>Import Variabel</span></a></li>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$home}}</span> - {{$title}}</h4>
						</div>

						@yield('heading-element')
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="{{URL::to('sam/package')}}"><i class="icon-home2 position-left"></i> {{$home}}</a></li>
							<li class="active">{{$title}}</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

                    @yield('content')
					<!-- Footer -->
					<div class="footer text-muted">
						&copy; {{date('Y')}}. <a href="{{URL::to('team-development')}}">INTRANET SALES MARKETING</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<script>
		$(function(){

			$.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{ 
                    orderable: false,
                    width: '100px',
                    targets: [ 2 ]
                }],
                dom: '<"datatable-header"fCl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });
		})
	</script>

    @yield('js')

</body>
</html>
