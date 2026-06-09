<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>

        @yield('title') | Employer Dashboard

    </title>

    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
            width: 280px;
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
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .sidebar-logo h3 {
            color: white;
            font-weight: 800;
            margin: 0;
        }

        .sidebar-logo span {
            color: #94a3b8;
            font-size: 14px;
        }

        .sidebar-menu {
            padding: 18px;
        }

        .menu-title {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 12px;
            padding-left: 14px;
            font-weight: 700;
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
            background: rgba(255, 255, 255, .08);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg,
                    #2563eb,
                    #4f46e5);
            color: white;
            box-shadow: 0 8px 25px rgba(37, 99, 235, .25);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | MAIN
        |--------------------------------------------------------------------------
        */

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | TOPBAR
        |--------------------------------------------------------------------------
        */

        .topbar {
            background: rgba(255, 255, 255, .95);
            padding: 18px 30px;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .menu-btn {
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 14px;
            background: #f1f5f9;
            transition: .2s;
        }

        .menu-btn:hover {
            background: #e2e8f0;
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
        | USER
        |--------------------------------------------------------------------------
        */

        .top-user-avatar {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg,
                    #2563eb,
                    #4f46e5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 17px;
            box-shadow: 0 6px 20px rgba(37, 99, 235, .25);
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER BUTTON
        |--------------------------------------------------------------------------
        */

        .header-btn {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #f8fafc;
            border: none;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
            color: #334155;
            font-size: 18px;
        }

        .header-btn:hover {
            background: #eff6ff;
            color: #2563eb;
            transform: translateY(-2px);
        }

        .header-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN
        |--------------------------------------------------------------------------
        */

        .dropdown-modern {
            width: 380px;
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .12);
            padding: 0;
        }

        .dropdown-header-modern {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            background: white;
        }

        .dropdown-item-modern {
            padding: 18px 20px;
            display: flex;
            gap: 14px;
            text-decoration: none;
            transition: .2s;
            border-bottom: 1px solid #f8fafc;
            color: #111827;
        }

        .dropdown-item-modern:hover {
            background: #f8fafc;
        }

        .dropdown-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .dropdown-menu {
            border: none;
            border-radius: 22px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .12);
        }

        .dropdown-item {
            padding: 14px 18px;
            border-radius: 14px;
            transition: .2s;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: #f3f6fb;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .page-content {
            padding: 30px;
        }

        .footer-admin {
            padding: 20px 30px;
            color: #64748b;
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media(max-width:991px) {

            .sidebar {
                left: -100%;
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
    @vite(['resources/js/app.js'])

</head>

<body>

    @php

        $employer = \App\Models\Employer::where('user_id', auth()->id())->first();

        /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

        $chatConversations = \App\Models\Conversation::with(['candidate.user'])
            ->where('employer_id', $employer?->id)
            ->latest('updated_at')
            ->take(8)
            ->get();

        $unreadMessages = \App\Models\Message::whereHas('conversation', function ($q) use ($employer) {
            $q->where('employer_id', $employer?->id);
        })
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', 0)
            ->count();

        /*
    |--------------------------------------------------------------------------
    | NOTIFICATION
    |--------------------------------------------------------------------------
    */

        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->count();

    @endphp

    {{-- SIDEBAR --}}
    <div class="sidebar">

        {{-- LOGO --}}
        <div class="sidebar-logo">

            <h3>

                JobConnect

            </h3>

            <span>

                Nhà tuyển dụng - Dashboard

            </span>

        </div>

        {{-- MENU --}}
        <div class="sidebar-menu">

            <div class="menu-title">

                MAIN MENU

            </div>

            <a href="/employer/dashboard" class="{{ request()->is('employer/dashboard') ? 'active' : '' }}">

                <i class="fa fa-chart-line"></i>

                Dashboard

            </a>

            <a href="/employer/jobs" class="{{ request()->is('employer/jobs*') ? 'active' : '' }}">

                <i class="fa fa-briefcase"></i>

                Viêc làm đã đăng

            </a>

            <a href="/employer/jobs/create">

                <i class="fa fa-plus-circle"></i>

                Đăng tuyển dụng

            </a>

            <a href="/employer/applications">

                <i class="fa fa-users"></i>

                Danh sách ứng viên

            </a>

            <a href="/chat">

                <i class="fa fa-comments"></i>

                Tin nhắn

            </a>

            <a href="/employer/company">

                <i class="fa fa-building"></i>

                Hồ sơ công ty

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

                    <h4 class="fw-bold mb-0">

                        @yield('title', 'Dashboard')

                    </h4>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="d-flex align-items-center gap-3">

                {{-- MESSAGE --}}
                <div class="dropdown">

                    <button class="header-btn" data-bs-toggle="dropdown">

                        <i class="fa fa-comments"></i>

                        @if ($unreadMessages > 0)
                            <span id="messageBadge" class="header-badge">

                                {{ $unreadMessages }}

                            </span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end dropdown-modern">

                        {{-- HEADER --}}
                        <div class="dropdown-header-modern d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="fw-bold mb-1">

                                    Tin nhắn

                                </h6>

                                <small class="text-muted">

                                    Trò chuyện với ứng viên

                                </small>

                            </div>

                            <a href="/chat" class="btn btn-sm btn-primary rounded-pill">

                                Xem tất cả

                            </a>

                        </div>

                        {{-- SEARCH --}}
                        <div class="p-3 border-bottom">

                            <input type="text" id="chatSearch" class="form-control rounded-pill"
                                placeholder="Tìm ứng viên...">

                        </div>

                        {{-- LIST --}}
                        <div id="navbarChatList" style="max-height:450px;overflow-y:auto;">

                            @forelse($chatConversations as $conversation)
                                @php

                                    $candidateUser = $conversation->candidate?->user;

                                    $lastMessage = \App\Models\Message::where('conversation_id', $conversation->id)
                                        ->latest()
                                        ->first();

                                @endphp

                                <a id="navbar-chat-{{ $conversation->id }}"
                                    href="/chat?conversation={{ $conversation->id }}"
                                    class="dropdown-item-modern chat-user-item">

                                    {{-- AVATAR --}}
                                    <div class="position-relative">

                                        <img src="https://ui-avatars.com/api/?background=2563eb&color=fff&name={{ urlencode($candidateUser->name ?? 'User') }}"
                                            width="52" height="52" class="rounded-circle object-fit-cover">

                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="flex-grow-1 overflow-hidden">

                                        <div class="d-flex justify-content-between">

                                            <div class="fw-semibold text-truncate">

                                                {{ $candidateUser->name ?? 'Ứng viên' }}

                                            </div>

                                            <small class="text-muted">

                                                {{ optional($lastMessage?->created_at)->diffForHumans() }}

                                            </small>

                                        </div>

                                        <div class="small text-muted text-truncate">

                                            {{ $lastMessage?->message ?? 'Chưa có tin nhắn' }}

                                        </div>

                                    </div>

                                </a>

                            @empty

                                <div class="text-center py-5 text-muted">

                                    Chưa có cuộc trò chuyện

                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

                {{-- NOTIFICATION --}}
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

                {{-- USER --}}
                <div class="dropdown">

                    <a href="#" class="text-decoration-none" data-bs-toggle="dropdown">

                        <div class="d-flex align-items-center">

                            <div class="top-user-avatar me-3">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>

                            <div class="d-none d-md-block text-end me-2">

                                <div class="fw-semibold text-dark">

                                    {{ auth()->user()->name }}

                                </div>

                                <small class="text-muted">

                                    Employer

                                </small>

                            </div>

                            <i class="fa fa-chevron-down text-muted small"></i>

                        </div>

                    </a>

                    {{-- DROPDOWN --}}
                    <div class="dropdown-menu dropdown-menu-end p-2" style="min-width:260px;">

                        <a href="/employer/company" class="dropdown-item">

                            <i class="fa fa-building text-primary me-2"></i>

                            Hồ sơ công ty

                        </a>

                        <a href="/employer/profile/password" class="dropdown-item">

                            <i class="fa fa-lock text-warning me-2"></i>

                            Đổi mật khẩu

                        </a>

                        <hr>

                        <form action="/logout" method="POST">

                            @csrf

                            <button class="dropdown-item text-danger">

                                <i class="fa fa-right-from-bracket me-2"></i>

                                Đăng xuất

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="page-content">

            @if (session('success'))
                <div class="alert alert-success rounded-4 border-0 shadow-sm">

                    {{ session('success') }}

                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger rounded-4 border-0 shadow-sm">

                    {{ session('error') }}

                </div>
            @endif

            @yield('content')

        </div>

        {{-- FOOTER --}}
        <div class="footer-admin">

            © {{ date('Y') }} JobConnect Employer Dashboard

        </div>

    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /*
                                    |--------------------------------------------------------------------------
                                    | MOBILE SIDEBAR
                                    |--------------------------------------------------------------------------
                                    */

        const toggleSidebar =
            document.getElementById('toggleSidebar');

        const sidebar =
            document.querySelector('.sidebar');

        toggleSidebar?.addEventListener('click', function() {

            sidebar.classList.toggle('show');

        });

        /*
        |--------------------------------------------------------------------------
        | CHAT SEARCH
        |--------------------------------------------------------------------------
        */

        document.getElementById('chatSearch')
            ?.addEventListener('keyup', function() {

                let value =
                    this.value.toLowerCase();

                document.querySelectorAll('.chat-user-item')
                    .forEach(function(item) {

                        item.style.display =
                            item.innerText.toLowerCase()
                            .includes(value)

                            ?
                            'flex' :
                            'none';

                    });

            });
        document.addEventListener('DOMContentLoaded', function() {

            if (!window.Echo) {

                console.error('Echo chưa load');

                return;
            }

            window.Echo
                .private('user.{{ auth()->id() }}')

                .listen('.new.message.notification', (e) => {

                    console.log('Badge update', e);

                    let badge =
                        document.getElementById('messageBadge');

                    if (!badge) return;

                    badge.innerText = e.count;

                    badge.style.display =
                        e.count > 0 ?
                        'flex' :
                        'none';

                })

                .listen('.chat.list.updated', (e) => {

                    console.log(
                        'Sidebar Update',
                        e
                    );

                    let chatList =
                        document.getElementById(
                            'navbarChatList'
                        );

                    if (!chatList) {

                        return;

                    }

                    let id =
                        e.conversation.id;

                    let item =
                        document.getElementById(
                            'navbar-chat-' + id
                        );

                    if (item) {

                        let messageDiv =
                            item.querySelector(
                                '.small.text-muted.text-truncate'
                            );

                        if (messageDiv) {

                            messageDiv.innerText =
                                e.conversation.last_message;

                        }

                        chatList.prepend(item);
                    }

                });
        });
    </script>

    @stack('scripts')

</body>

</html>
