<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        @if (Auth::guard('admin')->user()->image_url == null || empty(Auth::guard('admin')->user()->image_url))
                        <img src="{{ asset('assets/admin/images/user.png') }}" alt="">
                        @else
                        <img src="{{ asset('assets/admin/upload/' . Auth::guard('admin')->user()->image_url) }}" alt="">
                        @endif
                    {{ Auth::guard('admin')->user()->name }}<br/>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                        </a>
                        <a class="dropdown-item"  href="javascript:;">Help</a>
                        <a class="dropdown-item"  href="{{ route('auth.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                </li>
                <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        @if (!empty(Auth::user()->notifications))
                        <span class="badge bg-green">{{ Auth::user()->unreadNotifications()->groupBy('notifiable_type')->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        <li class="nav-item">
                            <a class="dropdown-item" style="text-align: center">
                                You Have {{ Auth::user()->unreadNotifications()->groupBy('notifiable_type')->count() }} Notifications
                            </a>
                        </li>
                        @forelse (Auth::user()->unreadNotifications as $notification)
                        <li class="nav-item">
                            <a href="{{ route('parameter.read.notification', ['id' => $notification['id'], 'notifyId' => $notification['notifiable_id']]) }}" class="dropdown-item">
                                <span class="image">
                                    @if ($notification['data']['sender_image'] == null || empty($notification['data']['sender_image']))
                                    <img src="{{ asset('assets/admin/images/user.png') }}" alt="">
                                    @else
                                    <img src="{{ asset('assets/admin/upload/' . $notification['data']['sender_image']) }}" alt="">
                                    @endif
                                </span>
                                <span style="font-weight: bold">{{ $notification['data']['sender'] }}</span>
                                <span class="message">
                                    {{ $notification['data']['message'] }}
                                </span>
                            </a>
                        </li>
                        @empty
                        <li class="nav-item">
                            <a class="dropdown-item">
                                <span>No Notification Found</span>
                            </a>
                        </li>
                        @endforelse
                        <li class="nav-item">
                            <a href="{{ route('parameter.view.notification') }}" class="dropdown-item" style="text-align: center">
                                View All Unread Notifications
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>