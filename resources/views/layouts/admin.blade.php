<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - JobConnect Admin</title>

    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f7fb;
            overflow-x: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .sidebar {
            width: 270px;
            height: 100vh;
            background: #0f172a;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            overflow-y: auto;
            transition: .3s;
        }

        .sidebar-logo {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo h3 {
            color: white;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-logo span {
            color: #94a3b8;
            font-size: 14px;
        }

        .sidebar-menu {
            padding: 18px;
        }

        .sidebar-menu .menu-title {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 12px;
            padding-left: 14px;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 8px;
            transition: .25s;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            box-shadow: 0 8px 25px rgba(37, 99, 235, .25);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .notification-btn {

            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #0f172a;
            transition: 0.3s;

        }

        .notification-btn:hover {

            background: #eff6ff;
            color: #2563eb;

        }

        .notification-count {

            position: absolute;
            top: -2px;
            right: -2px;
            min-width: 22px;
            height: 22px;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;

        }

        /* =========================
    /* =========================
    NOTIFICATION ITEM
========================= */

        .notification-item {

            transition: 0.25s;
            border-radius: 14px;

        }

        .notification-item:hover {

            background: #f8fafc;

        }

        /* CONTENT */

        .notification-text {

            font-size: 14px;
            line-height: 1.5;

        }

        /* CHƯA ĐỌC */

        .notification-text.unread {

            color: #0f172a;
            font-weight: 700;

        }

        .unread-time {

            color: #2563eb;
            font-size: 13px;
            font-weight: 600;

        }

        /* ĐÃ ĐỌC */

        .notification-text.read {

            color: #94a3b8;
            font-weight: 500;

        }

        .read-time {

            color: #0f172a;
            font-size: 13px;
            font-weight: 500;

        }

        /*
        |--------------------------------------------------------------------------
        | MAIN CONTENT
        |--------------------------------------------------------------------------
        */

        .main-content {
            margin-left: 270px;
            min-height: 100vh;
            transition: .3s;
        }

        /*
        |--------------------------------------------------------------------------
        | TOPBAR
        |--------------------------------------------------------------------------
        */

        .topbar {
            background: white;
            padding: 18px 30px;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .menu-btn {
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 12px;
            background: #f1f5f9;
            transition: .2s;
        }

        .menu-btn:hover {
            background: #e2e8f0;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .page-content {
            padding: 30px;
        }

        .card-modern {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .05);
        }

        .footer-admin {
            padding: 20px 30px;
            color: #64748b;
            font-size: 14px;
        }

        .badge-role {
            background: #eff6ff;
            color: #2563eb;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN
        |--------------------------------------------------------------------------
        */

        .dropdown-menu {
            border-radius: 18px;
            border: none;
        }

        .dropdown-item {
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 500;
            transition: .2s;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media(max-width:991px) {

            .sidebar {
                left: -100%;
                width: 280px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 16px;
            }

            .page-content {
                padding: 16px;
            }

        }
    </style>

</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">

        {{-- LOGO --}}
        <div class="sidebar-logo">

            <h3>
                JobConnect
            </h3>

            <span>
                Admin Dashboard
            </span>

        </div>

        {{-- MENU --}}
        <div class="sidebar-menu">

            <div class="menu-title">
                Main Menu
            </div>

            <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">

                <i class="fa fa-chart-line"></i>

                Dashboard

            </a>

            <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}">

                <i class="fa fa-users"></i>

                Quản lý người dùng

            </a>

            <a href="/admin/employers" class="{{ request()->is('admin/employers*') ? 'active' : '' }}">

                <i class="fa fa-building"></i>

                Quản lý doanh nghiệp

            </a>

            <a href="/admin/jobs" class="{{ request()->is('admin/jobs*') ? 'active' : '' }}">

                <i class="fa fa-briefcase"></i>

                Quản lý Jobs

            </a>

            <a href="/admin/categories" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">

                <i class="fa fa-layer-group"></i>

                Quản lý ngành nghề

            </a>
            <a href="/admin/applications" class="{{ request()->is('admin/applications*') ? 'active' : '' }}">

                <i class="fa fa-business-time"></i>

                Quản lý đơn ứng tuyển

            </a>

            <a href="/admin/locations" class="{{ request()->is('admin/locations*') ? 'active' : '' }}">

                <i class="fa fa-location-dot"></i>

                Quản lý địa điểm

            </a>

            <a href="/admin/jobtypes" class="{{ request()->is('admin/jobtypes*') ? 'active' : '' }}">

                <i class="fa fa-business-time"></i>

                Quản lý loại việc làm

            </a>

            <a href="/admin/skills" class="{{ request()->is('admin/skills*') ? 'active' : '' }}">

                <i class="fa fa-code"></i>

                Quản lý kỹ năng

            </a>

        </div>

    </div>

    {{-- MAIN --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <div class="topbar d-flex justify-content-between align-items-center">

            {{-- LEFT --}}
            <div class="d-flex align-items-center gap-3">

                <button class="menu-btn d-lg-none" id="toggleSidebar">

                    <i class="fa fa-bars"></i>

                </button>

                <div>

                    <h4 class="fw-bold mb-1">
                        @yield('title')
                    </h4>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="d-flex align-items-center gap-3">
                @auth

                    @php

                        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
                            ->latest()
                            ->take(5)
                            ->get();

                        $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', 0)
                            ->count();

                    @endphp

                    {{-- NOTIFICATION --}}
                    <div class="dropdown">

                        <a class="notification-btn" data-bs-toggle="dropdown" href="#">

                            <i class="fa fa-bell"></i>

                            @if ($countNotifications > 0)
                                <span class="notification-count">

                                    {{ $countNotifications }}

                                </span>
                            @endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-end user-dropdown p-2" style="width:360px;">

                            <div class="d-flex justify-content-between align-items-center px-2 py-2">

                                <h6 class="fw-bold mb-0">

                                    Thông báo

                                </h6>

                                <a href="/notifications" class="small text-primary fw-semibold">

                                    Xem tất cả

                                </a>

                            </div>

                            @forelse($unreadNotifications as $notification)
                                <a href="{{ $notification->link ?? '#' }}"
                                    class="
            notification-item
            d-block
            p-3
            border-bottom
            text-decoration-none
       "
                                    onclick="
            fetch('/notifications/{{ $notification->id }}/read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
       ">

                                    {{-- CONTENT --}}
                                    <div
                                        class="
            notification-text
            {{ $notification->is_read ? 'read' : 'unread' }}
        ">

                                        {{ $notification->content }}

                                    </div>

                                    {{-- TIME --}}
                                    <div
                                        class="
            notification-time mt-1
            {{ $notification->is_read ? 'read-time' : 'unread-time' }}
        ">

                                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}

                                    </div>

                                </a>

                            @empty

                                <div class="text-center py-5 text-muted">

                                    Chưa có thông báo

                                </div>
                            @endforelse

                        </div>

                    </div>

                @endauth

                <div class="dropdown">

                    <button class="btn border-0 bg-transparent d-flex align-items-center gap-3"
                        data-bs-toggle="dropdown">

                        {{-- INFO --}}
                        <div class="text-end d-none d-md-block">

                            <div class="fw-semibold">

                                {{ auth()->user()->name }}

                            </div>

                            <div class="badge-role">

                                Administrator

                            </div>

                        </div>

                        {{-- AVATAR --}}
                        <div class="avatar">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </button>

                    {{-- DROPDOWN MENU --}}
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2" style="min-width:220px;">

                        {{-- CHANGE PASSWORD --}}
                        <li>

                            <a href="/admin/profile/password" class="dropdown-item">

                                <i class="fa fa-key me-2 text-warning"></i>

                                Đổi mật khẩu

                            </a>

                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        {{-- LOGOUT --}}
                        <li>

                            <form action="/admin/logout" method="POST">

                                @csrf

                                <button class="dropdown-item text-danger">

                                    <i class="fa fa-right-from-bracket me-2"></i>

                                    Đăng xuất

                                </button>

                            </form>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="page-content">

            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm">

                    {{ session('success') }}

                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 rounded-4 shadow-sm">

                    {{ session('error') }}

                </div>
            @endif

            @yield('content')

        </div>

        {{-- FOOTER --}}
        <div class="footer-admin">

            © {{ date('Y') }} JobConnect Admin Dashboard

        </div>

    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleSidebar =
            document.getElementById('toggleSidebar');

        const sidebar =
            document.querySelector('.sidebar');

        toggleSidebar?.addEventListener('click', function() {

            sidebar.classList.toggle('show');

        });
    </script>

</body>

</html>
