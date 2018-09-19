<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      @if(auth()->user()->can('Dashboard'))
        <li class="nav-item">
          <a class="nav-link {{ Request::path() == 'home' ? 'active' : '' }}" href="{{URL::to('home')}}">
            <i class="nav-icon icon-home"></i> Home
            <span class="badge badge-primary">NEW</span>
          </a>
        </li>
      @endif
      <li class="nav-title">Dashboard</li>
      <li class="nav-item">
        <a class="nav-link {{ Request::path() == 'sosmed/live-socmed' ? 'active' : '' }}" href="{{URL::to('sosmed/live-socmed')}}">
          <i class="nav-icon icon-tv"></i> Live Socmed</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::path() == 'sosmed/dashboard-summary' ? 'active' : '' }}" href="{{URL::to('sosmed/dashboard-summary')}}">
          <i class="nav-icon icon-stats-growth"></i> Summary</a>
      </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-books"></i> Chart
        </a>
        <ul class="nav-dropdown-items">
            <li class="nav-item {{ Request::path() == 'sosmed/dashboard-chart/twitter' ? 'active' : '' }}">
              <a class="nav-link" href="{{URL::to('sosmed/dashboard-chart/twitter')}}">
                <i class="nav-icon icon-arrow-right22"></i> Twitter
              </a>
            </li>
            <li class="nav-item {{ Request::path() == 'sosmed/dashboard-chart/facebook' ? 'active' : '' }}">
              <a class="nav-link" href="{{URL::to('sosmed/dashboard-chart/facebook')}}">
                <i class="nav-icon icon-arrow-right22"></i> Facebook
              </a>
            </li>
            <li class="nav-item {{ Request::path() == 'sosmed/dashboard-chart/instagram' ? 'active' : '' }}">
              <a class="nav-link" href="{{URL::to('sosmed/dashboard-chart/instagram')}}">
                <i class="nav-icon icon-arrow-right22"></i> Instagram
              </a>
            </li>
            <li class="nav-item {{ Request::path() == 'sosmed/dashboard-chart/youtube' ? 'active' : '' }}">
              <a class="nav-link" href="{{URL::to('sosmed/dashboard-chart/youtube')}}">
                <i class="nav-icon icon-arrow-right22"></i> Youtube
              </a>
            </li>
        </ul>
      </li>
      
      <li class="nav-title">Backend</li>
      @if(auth()->user()->can('Master'))
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-books"></i> Master
          </a>
          <ul class="nav-dropdown-items">
            @if(auth()->user()->can('Read Group'))
              <li class="nav-item {{ Request::path() == 'sosmed/group' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/group')}}">
                  <i class="nav-icon icon-arrow-right22"></i> Group
                </a>
              </li>
            @endif

            @if(auth()->user()->can('Read Unit'))
              <li class="nav-item {{ Request::path() == 'sosmed/businness-unit' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/businness-unit')}}">
                  <i class="nav-icon icon-arrow-right22"></i> Business Unit
                </a>
              </li>
            @endif

            @if(auth()->user()->can('Read Sosmed'))
              <li class="nav-item {{ Request::path() == 'sosmed/sosial-media' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/sosial-media')}}">
                  <i class="nav-icon icon-arrow-right22"></i> Social Media
                </a>
              </li>
            @endif

            @if(auth()->user()->can('Read Program'))
              <li class="nav-item {{ Request::path() == 'sosmed/program' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/program')}}">
                  <i class="nav-icon icon-arrow-right22"></i> Program
                </a>
              </li>
            @endif
          </ul>
        </li>
      @endif

      @if(auth()->user()->can('Users'))
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-users"></i> Users</a>
          <ul class="nav-dropdown-items">
            @if(auth()->user()->can('Read User'))
              <li class="nav-item {{ Request::path() == 'sosmed/user' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/user')}}">
                <i class="nav-icon icon-arrow-right22"></i> User</a>
              </li>
            @endif

            @if(auth()->user()->can('Read Role'))
              <li class="nav-item {{ Request::path() == 'sosmed/role' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/role')}}">
                <i class="nav-icon icon-arrow-right22"></i> Role</a>
              </li>
            @endif
          </ul>
      </li>
      @endif

      @if(auth()->user()->can('Input Report'))
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon  icon-database-insert"></i> Input Report</a>
          <ul class="nav-dropdown-items">
            @if(auth()->user()->can('Input Twitter'))
              <li class="nav-item {{ Request::path() == 'sosmed/input-report/twitter' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/input-report/twitter')}}">
                <i class="nav-icon icon-arrow-right22"></i> Twitter</a>
              </li>
            @endif

            @if(auth()->user()->can('Input Facebook'))
              <li class="nav-item {{ Request::path() == 'sosmed/input-report/facebook' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/input-report/facebook')}}">
                <i class="nav-icon icon-arrow-right22"></i> Facebook</a>
              </li>
            @endif

            @if(auth()->user()->can('Input Instagram'))
              <li class="nav-item {{ Request::path() == 'sosmed/input-report/instagram' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/input-report/instagram')}}">
                <i class="nav-icon icon-arrow-right22"></i> Instagram</a>
              </li>
            @endif

            @if(auth()->user()->can('Input Youtube'))
              <li class="nav-item {{ Request::path() == 'sosmed/input-report/youtube' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/input-report/youtube')}}">
                <i class="nav-icon icon-arrow-right22"></i> Youtube</a>
              </li>
            @endif
          </ul>
      </li>
      @endif

      @if(auth()->user()->can('Backup'))
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-shredder"></i> Export Data</a>
          <ul class="nav-dropdown-items">
            @if(auth()->user()->can('Pdf Daily Report'))
              <li class="nav-item {{ Request::path() == 'sosmed/daily-report' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/daily-report')}}">
                <i class="nav-icon icon-arrow-right22"></i> Daily Report</a>
              </li>
            @endif

            @if(auth()->user()->can('Pdf Rank'))
              <li class="nav-item {{ Request::path() == 'sosmed/ranking-soc-med' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/ranking-soc-med')}}">
                <i class="nav-icon icon-arrow-right22"></i> Rank Social Media</a>
              </li>
            @endif

            <li class="nav-item {{ Request::path() == 'sosmed/export-excel' ? 'active' : '' }}">
              <a class="nav-link" href="{{URL::to('sosmed/export-excel')}}">
              <i class="nav-icon icon-arrow-right22"></i> Export Excel</a>
            </li>

            @if(auth()->user()->can('Backup Excel'))
              <li class="nav-item {{ Request::path() == 'sosmed/data/backup-excel' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/data/backup-excel')}}">
                <i class="nav-icon icon-arrow-right22"></i> Backup Data</a>
              </li>
            @endif
          </ul>
      </li>
      @endif

      @if(auth()->user()->can('Access Log'))
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-list"></i> Recent Activity</a>
          <ul class="nav-dropdown-items">
              <li class="nav-item {{ Request::path() == 'sosmed/log/login' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/log/login')}}">
                <i class="nav-icon icon-arrow-right22"></i> Log</a>
              </li>

              <li class="nav-item {{ Request::path() == 'sosmed/log/activity' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/log/activity')}}">
                <i class="nav-icon icon-arrow-right22"></i> Activity</a>
              </li>

              <li class="nav-item {{ Request::path() == 'sosmed/log/access-log' ? 'active' : '' }}">
                <a class="nav-link" href="{{URL::to('sosmed/log/access-log')}}">
                <i class="nav-icon icon-arrow-right22"></i> Access Log</a>
              </li>
          </ul>
      </li>
      @endif

      @if(auth()->user()->can('Highlight'))
      <li class="nav-item {{ Request::path() == 'sosmed/highlight' ? 'active' : '' }}">
        <a class="nav-link" href="{{URL::to('sosmed/highlight')}}">
          <i class="nav-icon icon-highlight"></i> Highlight</a>
      </li>
      @endif
    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>