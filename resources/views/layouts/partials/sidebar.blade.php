<div class="sidebar">
    <div class="brand">
        <a href="{{URL::to('home')}}">
            <img src="{{URL::asset('klorofil/img/mnc.png')}}" alt="Klorofil Logo" class="img-responsive logo">
        </a>
    </div>
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                @if(auth()->user()->can('Dashboard'))
                    <li><a href="{{URL::to('home')}}" class="{{ Request::path() == 'home' ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                @endif

                @if(auth()->user()->can('Master'))
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="icon-books"></i> <span>Master</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            @if(auth()->user()->can('Read Group'))
                                <li><a href="{{URL::to('sosmed/group')}}" class="{{ Request::path() == 'sosmed/group' ? 'active' : '' }}">Group</a></li>
                            @endif 

                            @if(auth()->user()->can('Read Unit'))
                                <li><a href="{{URL::to('sosmed/businness-unit')}}" class="{{ Request::path() == 'sosmed/businness-unit' ? 'active' : '' }}">Business Unit</a></li>
                            @endif 

                            @if(auth()->user()->can('Read Sosmed'))
                                <li><a href="{{URL::to('sosmed/sosial-media')}}" class="{{ Request::path() == 'sosmed/sosial-media' ? 'active' : '' }}">Sosial Media</a></li>
                            @endif 

                            @if(auth()->user()->can('Read Program'))
                                <li><a href="{{URL::to('sosmed/program')}}" class="{{ Request::path() == 'sosmed/program' ? 'active' : '' }}">Program</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                
                @if(auth()->user()->can('Users'))
                <li>
                    <a href="#subUser" data-toggle="collapse" class="collapsed"><i class="icon-users"></i> <span>Users</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subUser" class="collapse ">
                        <ul class="nav">
                            @if(auth()->user()->can('Read User'))
                                <li><a href="{{URL::to('sosmed/user')}}" class="{{ Request::path() == 'sosmed/user' ? 'active' : '' }}">User</a></li>
                            @endif

                            @if(auth()->user()->can('Read Role'))
                                <li><a href="{{URL::to('sosmed/role')}}" class="{{ Request::path() == 'sosmed/role' ? 'active' : '' }}">Role</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->user()->can('Input Report'))
                    <li>
                        <a href="#subR" data-toggle="collapse" class="collapsed"><i class="lnr lnr-location"></i> <span>Input Report</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subR" class="collapse ">
                            <ul class="nav">
                                <li><a href="{{URL::to('sosmed/input-report/twitter')}}"><i class="icon-twitter2"></i> Twitter</a></li>
                                <li><a href="{{URL::to('sosmed/input-report/facebook')}}"><i class="icon-facebook2"></i> Facebook</a></li>
                                <li><a href="{{URL::to('sosmed/input-report/instagram')}}"><i class="icon-instagram"></i> Instagram</a></li>
                            </ul>
                        </div>
                    </li>
                    <!-- <li><a href="{{URL::to('sosmed/input-report-harian')}}" class="{{ Request::path() == 'sosmed/input-report-harian' ? 'active' : '' }}"><i class="lnr lnr-location"></i> <span>Input Report</span></a></li> -->
                @endif

                @if(auth()->user()->can('Backup'))
                <li>
                    <a href="#subPrint" data-toggle="collapse" class="collapsed"><i class="icon-shredder"></i> <span>Export Data</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPrint" class="collapse ">
                        <ul class="nav">
                            @if(auth()->user()->can('Pdf Daily Report'))
                            <li><a href="{{URL::to('sosmed/daily-report')}}">
                                    Daily Report
                                </a>
                            </li>
                            @endif 

                            @if(auth()->user()->can('Pdf Rank'))
                            <li><a href="{{URL::to('sosmed/ranking-soc-med')}}">
                                    Rank Social Media
                                </a>
                            </li>
                            @endif 

                            @if(auth()->user()->can('Backup Excel'))
                                <li><a href="{{URL::to('sosmed/data/backup-excel')}}">
                                        <i class="icon-file-excel"></i> Backup Data
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                
                @if(auth()->user()->can('Access Log'))
                <li>
                    <a href="#subLog" data-toggle="collapse" class="collapsed"><i class="icon-list"></i> <span>Recent Activity</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subLog" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('sosmed/log/login')}}">
                                    Log
                                </a>
                            </li>
                            <li><a href="{{URL::to('sosmed/log/activity')}}">
                                    Activity
                                </a>
                            </li>
                            <li><a href="{{URL::to('sosmed/log/access-log')}}">
                                    Access Log
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->user()->can('Highlight'))
                    <li><a href="{{URL::to('sosmed/highlight')}}" class="{{ Request::path() == 'sosmed/highlight' ? 'active' : '' }}"><i class="icon-highlight"></i> <span>Highlight</span></a></li>
                @endif
            </ul>
        </nav>
    </div>
</div>