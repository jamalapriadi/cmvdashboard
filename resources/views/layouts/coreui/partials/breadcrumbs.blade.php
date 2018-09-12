<ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">
        <a href="#">{{auth()->user()->name}}</a>
    </li>
    <li class="breadcrumb-item active">Dashboard</li>
    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu d-md-down-none">
    <div class="btn-group" role="group" aria-label="Button group">
        <a class="btn" href="{{URL::to('home')}}">
            <i class="icon-graph"></i>  Dashboard
        </a>
        <a class="btn" href="#">
            <i class="icon-gear"></i>  Settings
        </a>
    </div>
    </li>
</ol>