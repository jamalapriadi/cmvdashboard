<div class="sidebar">
    <div class="brand">
        <a href="{{URL::to('home')}}">
            <img src="{{URL::asset('klorofil/img/logo.png')}}" alt="Klorofil Logo" class="img-responsive logo">
        </a>
    </div>
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{URL::to('home')}}" class="{{ Request::path() == 'home' ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="icon-books"></i> <span>Master</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('sosmed/group')}}" class="{{ Request::path() == 'sosmed/group' ? 'active' : '' }}">Group</a></li>
                            <li><a href="{{URL::to('sosmed/businness-unit')}}" class="{{ Request::path() == 'sosmed/businness-unit' ? 'active' : '' }}">Business Unit</a></li>
                            <li><a href="{{URL::to('sosmed/sosial-media')}}" class="{{ Request::path() == 'sosmed/sosial-media' ? 'active' : '' }}">Sosial Media</a></li>
                            <li><a href="{{URL::to('sosmed/program')}}" class="{{ Request::path() == 'sosmed/program' ? 'active' : '' }}">Program</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="{{URL::to('sosmed/input-report-harian')}}" class="{{ Request::path() == 'sosmed/input-report-harian' ? 'active' : '' }}"><i class="lnr lnr-location"></i> <span>Input Report</span></a></li>
            </ul>
        </nav>
    </div>
</div>