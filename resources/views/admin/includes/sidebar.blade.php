<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('dashboard.index') }}" class="site_title"><img src="{{ asset('assets/admin/images/logo.png') }}" width="40px" /> <span>My Health Coach</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                @if (Auth::guard('admin')->user()->image_url == null || empty(Auth::guard('admin')->user()->image_url))
                <img src="{{ asset('assets/admin/images/user.png') }}" alt="..." class="img-circle profile_img">
                @else
                <img src="{{ asset('assets/admin/upload/' . Auth::guard('admin')->user()->image_url) }}" alt="..." class="img-circle profile_img">
                @endif
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::guard('admin')->user()->name }}</h2>
                <h2>{{ date('d-m-Y H:i') }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Operation</h3>
                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-heartbeat"></i> Health Care <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('complex.index') }}">Complex</a></li>
                            <li><a href="{{ route('coach.index') }}">Health Coach</a></li>
                            <li><a href="{{ route('patient.index') }}">Patient</a></li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-comments-o"></i> Chat <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('chat-room.index') }}">Chat Rooms</a></li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('usertype.index') }}">User Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a href="{{ route('usertype.index') }}" data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Help">
            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('auth.logout') }}">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>