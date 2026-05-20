<header class="navbar{!! $admin_template['header_navbar'] ? ' ' . $admin_template['header_navbar'] : '' !!}{!! $admin_template['header'] ? ' ' . $admin_template['header'] : '' !!}">
    @if ( $admin_template['header_content'] == 'horizontal-menu' )

    @else
        <ul class="nav navbar-nav-custom">
            <li>
                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                    <i class="fa fa-bars fa-fw"></i>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav-custom pull-right">
            <li class="dropdown">
                <a><strong class="server-time"></strong></a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    @if (auth()->user()->profile_image != '')
                        <img src="{{ asset(auth()->user()->profile_image) }}" alt="avatar"> <i class="fa fa-angle-down"></i>
                    @else
                        <img src="{{asset('public/images/placeholders/avatars/avatar2.jpg')}}" alt="avatar"> <i class="fa fa-angle-down"></i>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                    <li class="dropdown-header text-center">Account</li>
                    <li>
                        <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-ban fa-fw pull-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    @endif
</header>
