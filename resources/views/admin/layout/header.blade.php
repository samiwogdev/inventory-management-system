<div class="header">
    <div class="header-left active">
        <a href="index.html" class="logo">
            <img src="{{ url('assets/img/logo.png') }}" alt="">
        </a>
        <a href="index.html" class="logo-small">
            <img src="{{ url('assets/img/logo-small.png') }}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
        </a>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <ul class="nav user-menu">
        <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <img src="{{ url('assets/img/icons/notification-bing.svg') }}" alt="img">
                @if ($notificationCount > 0)
                <span class="badge rounded-pill">{{ $notificationCount }}</span>
                @endif
            </a>
            @if ($notificationCount > 0)
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title" style="font-weight: bolder;">Notifications</span>
                    <!-- <a href="javascript:void(0)" class="clear-noti"> Clear All </a> -->
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @foreach($notifications as $notification)
                        <li class="notification-message">
                            <a href="#">
                                <div class="media d-flex">
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details">
                                            <img src="{{ asset('assets/img/icons/checked.png') }}" style="width: 10px;" class="icon-success" alt="cart">
                                            <span class="noti-title">{{$notification->data }}</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time text-danger">{{ $notification->created_at->diffForHumans() }}</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <form id="form-delete" action="{{ url('admin/notifications') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <a href="javascript:void(0);" onclick="document.getElementById('form-delete').submit();"> Clear all Notifications</a>
                    </form>
                </div>
            </div>
            @endif
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{ url('assets/img/profiles/avator1.jpg') }}" style="width: 25px;" alt="">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ url('assets/img/profiles/avator1.jpg') }}" alt="">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>{{Auth::guard('admin')->user()->name}}</h6>
                            <h5>{{Auth::guard('admin')->user()->type}}</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="{{ url('admin/editUser') }}"> <i class="me-2" data-feather="user"></i> My Profile</a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="{{ url('admin/logout') }}"><img src="{{ url('assets/img/icons/log-out.svg') }}" class="me-2" alt="img">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</div>