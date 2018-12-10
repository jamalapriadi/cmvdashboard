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
            <i class="icon-underline2"></i>  Unit
        </a>
        <a class="btn" href="{{URL::to('brand')}}">
            <i class="icon-bold2"></i> Brand
        </a>
    </div>
    </li>
</ol>