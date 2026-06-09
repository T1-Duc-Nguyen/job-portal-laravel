<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'JobConnect')</title>

    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {

            background: #f5f7fb;
            color: #1e293b;

        }

        a {
            text-decoration: none;
        }

        /* =========================
            NAVBAR
        ========================= */

        .main-navbar {

            background: #fff;
            border-bottom: 1px solid #eef2f7;
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(12px);

        }

        .navbar-brand {

            font-size: 28px;
            font-weight: 800;
            color: #2563eb !important;

        }

        .navbar-brand span {

            color: #0f172a;

        }

        /* =========================
    NAV MENU
========================= */

        .nav-menu {

            display: flex;
            align-items: center;
            gap: 10px;

        }

        .nav-link-custom {

            position: relative;

            padding: 10px 18px !important;

            border-radius: 14px;

            font-weight: 600;

            color: #475569 !important;

            transition: .25s;

        }

        .nav-link-custom i {

            margin-right: 8px;

        }

        .nav-link-custom:hover {

            background: #eff6ff;

            color: #2563eb !important;

        }

        /* ACTIVE */

        .nav-link-custom.active {

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);

            color: #fff !important;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .22);

        }

        .nav-btn {

            height: 44px;
            border-radius: 14px;
            padding: 0 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;

        }

        .btn-login {

            background: #eff6ff;
            color: #2563eb;
            border: none;

        }

        .btn-login:hover {

            background: #dbeafe;
            color: #1d4ed8;

        }

        .btn-register {

            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            border: none;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .25);

        }

        .btn-register:hover {

            opacity: .95;
            color: #fff;

        }

        .btn-employer {

            background: #f59e0b;
            color: #fff;
            border: none;

        }

        .btn-admin {

            background: #ef4444;
            color: #fff;
            border: none;

        }

        /* =========================
            NOTIFICATION
        ========================= */

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

        /* =========================
    MESSAGE BUTTON
========================= */

        .header-btn {

            width: 46px;
            height: 46px;

            border: none;

            border-radius: 16px;

            background: #f8fafc;

            display: flex;
            align-items: center;
            justify-content: center;

            position: relative;

            color: #0f172a;

            transition: .25s;

            box-shadow: 0 4px 12px rgba(15, 23, 42, .05);

        }

        .header-btn:hover {

            background: #eff6ff;

            color: #2563eb;

            transform: translateY(-2px);

        }

        /* BADGE */

        .header-badge {

            position: absolute;

            top: -4px;
            right: -4px;

            min-width: 22px;
            height: 22px;

            padding: 0 6px;

            border-radius: 999px;

            background: #ef4444;

            color: #fff;

            font-size: 11px;
            font-weight: 700;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow: 0 4px 10px rgba(239, 68, 68, .3);

        }

        /* CHAT DROPDOWN */

        .dropdown-modern {

            width: 380px;

            border: none;

            border-radius: 24px;

            overflow: hidden;

            background: #fff;

            box-shadow: 0 18px 50px rgba(15, 23, 42, .12);

            padding: 0;

        }

        /* HEADER */

        .dropdown-header-modern {

            padding: 20px;

            background: #fff;

            border-bottom: 1px solid #f1f5f9;

        }

        /* CHAT ITEM */

        .dropdown-item-modern {

            padding: 16px 20px;

            display: flex;

            gap: 14px;

            align-items: center;

            text-decoration: none;

            transition: .2s;

            border-bottom: 1px solid #f8fafc;

            color: #0f172a;

        }

        .dropdown-item-modern:hover {

            background: #f8fafc;

        }

        /* USER AVATAR */

        .chat-avatar {

            width: 52px;
            height: 52px;

            border-radius: 18px;

            object-fit: cover;

            flex-shrink: 0;

            box-shadow: 0 4px 14px rgba(15, 23, 42, .08);

        }

        /* USER NAME */

        .chat-user-name {

            font-size: 14px;

            font-weight: 700;

            color: #0f172a;

        }

        /* LAST MESSAGE */

        .chat-last-message {

            font-size: 13px;

            color: #64748b;

            margin-top: 3px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }

        /* TIME */

        .chat-time {

            font-size: 12px;

            color: #94a3b8;

            white-space: nowrap;

        }

        /* SEARCH BOX */

        .chat-search {

            border-radius: 999px;

            border: 1px solid #e2e8f0;

            padding: 10px 16px;

            font-size: 14px;

        }

        .chat-search:focus {

            border-color: #2563eb;

            box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);

        }

        /* EMPTY */

        .chat-empty {

            padding: 50px 20px;

            text-align: center;

            color: #94a3b8;

        }

        /* SCROLL */

        .chat-scroll {

            max-height: 450px;

            overflow-y: auto;

        }

        .chat-scroll::-webkit-scrollbar {

            width: 6px;

        }

        .chat-scroll::-webkit-scrollbar-thumb {

            background: #cbd5e1;

            border-radius: 999px;

        }



        /* =========================
            USER MENU
        ========================= */

        .user-dropdown {

            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 6px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, .08);

        }

        .dropdown-item {

            border-radius: 12px;
            padding: 12px 14px;
            font-weight: 500;
            transition: 0.3s;

        }

        .dropdown-item:hover {

            background: #f1f5f9;

        }

        .dropdown-avatar {

            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(37, 99, 235, .25);

        }

        .dropdown-avatar img {

            width: 100%;
            height: 100%;
            object-fit: cover;

        }


        .default-avatar-text {

            color: #fff;
            font-size: 18px;
            font-weight: 700;

        }

        .user-btn {

            border: none;
            background: #fff;
            border-radius: 18px;
            padding: 6px 12px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .06);

        }

        /* =========================
            ALERT
        ========================= */

        .custom-alert {

            border: none;
            border-radius: 20px;
            padding: 18px 22px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .06);

        }

        /* =========================
            FOOTER
        ========================= */

        .footer {

            background: #0f172a;
            color: #cbd5e1;
            margin-top: 80px;

        }

        .footer-title {

            color: #fff;
            font-weight: 700;
            margin-bottom: 20px;

        }

        .footer-link {

            color: #cbd5e1;
            display: block;
            margin-bottom: 10px;
            transition: 0.3s;

        }

        .footer-link:hover {

            color: #fff;
            transform: translateX(3px);

        }

        .footer-bottom {

            border-top: 1px solid rgba(255, 255, 255, .08);
            margin-top: 40px;
            padding-top: 25px;
            text-align: center;
            color: #94a3b8;

        }

        /* =========================
            GLOBAL CARD
        ========================= */

        .modern-card {

            background: #fff;
            border-radius: 24px;
            box-shadow: 0 6px 24px rgba(15, 23, 42, .05);
            border: none;

        }
    </style>
    @vite(['resources/js/app.js'])
    @stack('styles')

</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg main-navbar py-3">

        <div class="container">

            {{-- LOGO --}}
            <a class="navbar-brand" href="/">

                <i class="fa fa-briefcase me-1"></i>

                Job<span>Connect</span>

            </a>

            {{-- MOBILE --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                {{-- MENU --}}
                <ul class="navbar-nav mx-auto nav-menu">

                    {{-- HOME --}}
                    <li class="nav-item">

                        <a href="/"
                            class="nav-link nav-link-custom
           {{ request()->is('/') ? 'active' : '' }}">

                            Trang chủ

                        </a>

                    </li>

                    {{-- JOBS --}}
                    <li class="nav-item">

                        <a href="/jobs"
                            class="nav-link nav-link-custom
           {{ request()->is('jobs*') ? 'active' : '' }}">

                            Việc làm

                        </a>

                    </li>

                    {{-- COMPANY --}}
                    <li class="nav-item">

                        <a href="/candidate/companies"
                            class="nav-link nav-link-custom
           {{ request()->is('candidate/companies*') ? 'active' : '' }}">

                            Công ty

                        </a>

                    </li>

                </ul>

                {{-- RIGHT --}}
                <div class="d-flex align-items-center gap-3">

                    @auth

                        @php
                            $candidate = \App\Models\Candidate::where('user_id', auth()->id())->first();
                            /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

                            $chatConversations = \App\Models\Conversation::with(['candidate.user', 'employer.user'])
                                ->where('candidate_id', $candidate?->id)
                                ->latest('updated_at')
                                ->take(8)
                                ->get();

                            $unreadMessages = \App\Models\Message::whereHas('conversation', function ($q) use (
                                $candidate,
                            ) {
                                $q->where('candidate_id', $candidate?->id);
                            })
                                ->where('sender_id', '!=', auth()->id())
                                ->where('is_read', 0)
                                ->count();

                            $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                ->latest()
                                ->take(5)
                                ->get();

                            $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                ->where('is_read', 0)
                                ->count();

                        @endphp
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

                                            Trò chuyện với nhà tuyển dụng

                                        </small>

                                    </div>

                                    <a href="/chat" class="btn btn-sm btn-primary rounded-pill">

                                        Xem tất cả

                                    </a>

                                </div>

                                {{-- SEARCH --}}
                                <div class="p-3 border-bottom">

                                    <input type="text" id="chatSearch" class="form-control rounded-pill"
                                        placeholder="Tìm kiếm...">

                                </div>

                                {{-- LIST --}}
                                <div id="navbarChatList" style="max-height:450px;overflow-y:auto;">

                                    @forelse($chatConversations as $conversation)
                                        @php

                                            /*
        |--------------------------------------------------------------------------
        | LẤY ĐÚNG NGƯỜI CHAT
        |--------------------------------------------------------------------------
        */

                                            if (auth()->user()->role == 1) {
                                                // candidate -> hiện employer
                                                $chatUser = $conversation->employer?->user;
                                            } else {
                                                // employer -> hiện candidate
                                                $chatUser = $conversation->candidate?->user;
                                            }

                                            /*
        |--------------------------------------------------------------------------
        | LAST MESSAGE
        |--------------------------------------------------------------------------
        */

                                            $lastMessage = \App\Models\Message::where(
                                                'conversation_id',
                                                $conversation->id,
                                            )
                                                ->latest()
                                                ->first();

                                        @endphp

                                        <a id="navbar-chat-{{ $conversation->id }}"
                                            href="/chat?conversation={{ $conversation->id }}"
                                            class="dropdown-item-modern chat-user-item">

                                            {{-- AVATAR --}}
                                            <div class="position-relative">

                                                <img src="https://ui-avatars.com/api/?background=2563eb&color=fff&name={{ urlencode($chatUser->name ?? 'User') }}"
                                                    width="52" height="52" class="rounded-circle object-fit-cover">

                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="flex-grow-1 overflow-hidden">

                                                <div class="d-flex justify-content-between">

                                                    <div class="fw-semibold text-truncate">

                                                        {{ $chatUser->name ?? 'User' }}

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

                    {{-- GUEST --}}
                    @guest

                        <a href="/login" class="btn nav-btn btn-login">

                            <i class="fa fa-right-to-bracket"></i>

                            Đăng nhập

                        </a>

                        <a href="/register" class="btn nav-btn btn-register">

                            <i class="fa fa-user-plus"></i>

                            Đăng ký

                        </a>

                    @endguest

                    {{-- AUTH --}}
                    @auth

                        {{-- CANDIDATE --}}
                        @if (auth()->user()->role == 1)
                            @php

                                $candidate = \App\Models\Candidate::where('user_id', auth()->id())->first();

                            @endphp

                            <div class="dropdown">

                                <button class="user-btn d-flex align-items-center gap-2" data-bs-toggle="dropdown">

                                    {{-- AVATAR --}}
                                    <div class="dropdown-avatar overflow-hidden p-0">

                                        @if ($candidate && $candidate->avatar)
                                            <img src="{{ asset($candidate->avatar) }}" alt="avatar"
                                                style="
                            width:100%;
                            height:100%;
                            object-fit:cover;
                        ">
                                        @else
                                            <div class="default-avatar-text">

                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                                            </div>
                                        @endif

                                    </div>

                                    {{-- INFO --}}
                                    <div class="text-start">

                                        <div class="fw-bold small">

                                            {{ auth()->user()->name }}

                                        </div>

                                        <small class="text-muted">

                                            Candidate

                                        </small>

                                    </div>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end user-dropdown">

                                    <li>

                                        <a class="dropdown-item" href="/candidate/profile">

                                            <i class="fa fa-id-card me-2"></i>

                                            Hồ sơ cá nhân

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="/candidate/profile/edit">

                                            <i class="fa fa-user-pen me-2"></i>

                                            Cập nhật hồ sơ

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="/candidate/applications">

                                            <i class="fa fa-file-lines me-2"></i>

                                            Việc làm đã ứng tuyển

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="/candidate/saved-jobs">

                                            <i class="fa fa-heart me-2"></i>

                                            Việc làm đã lưu

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="/candidate/profile/password">

                                            <i class="fa fa-key me-2"></i>

                                            Đổi mật khẩu

                                        </a>

                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>

                                        <form action="/logout" method="POST">

                                            @csrf

                                            <button class="dropdown-item text-danger">

                                                <i class="fa fa-right-from-bracket me-2"></i>

                                                Đăng xuất

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>
                        @endif

                        {{-- EMPLOYER --}}
                        @if (auth()->user()->role == 2)
                            <a href="/employer/jobs" class="btn nav-btn btn-employer">

                                <i class="fa fa-building"></i>

                                Employer Panel

                            </a>
                        @endif

                        {{-- ADMIN --}}
                        @if (auth()->user()->role == 0)
                            <a href="/admin" class="btn nav-btn btn-admin">

                                <i class="fa fa-user-shield"></i>

                                Admin Panel

                            </a>
                        @endif

                    @endauth

                </div>

            </div>

        </div>

    </nav>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="container mt-4">

            <div class="alert alert-success alert-dismissible fade show custom-alert">

                <i class="fa fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="container mt-4">

            <div class="alert alert-danger alert-dismissible fade show custom-alert">

                <i class="fa fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        </div>
    @endif

    {{-- CONTENT --}}
    <main>

        <div class="container py-4">

            @yield('content')

        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="footer">

        <div class="container py-5">

            <div class="row">

                <div class="col-lg-4 mb-4">

                    <h4 class="footer-title">

                        <i class="fa fa-briefcase me-2"></i>

                        JobConnect

                    </h4>

                    <p>

                        Nền tảng tuyển dụng hiện đại giúp kết nối ứng viên và doanh nghiệp nhanh chóng.

                    </p>

                </div>

                <div class="col-lg-2 col-md-4 mb-4">

                    <h6 class="footer-title">

                        Việc làm

                    </h6>

                    <a href="/jobs" class="footer-link">

                        Tìm việc

                    </a>

                    <a href="#" class="footer-link">

                        Việc HOT

                    </a>

                    <a href="#" class="footer-link">

                        Remote

                    </a>

                </div>

                <div class="col-lg-2 col-md-4 mb-4">

                    <h6 class="footer-title">

                        Ứng viên

                    </h6>

                    <a href="#" class="footer-link">

                        Tạo CV

                    </a>

                    <a href="#" class="footer-link">

                        Hồ sơ

                    </a>

                </div>

                <div class="col-lg-2 col-md-4 mb-4">

                    <h6 class="footer-title">

                        Doanh nghiệp

                    </h6>

                    <a href="#" class="footer-link">

                        Đăng tuyển

                    </a>

                    <a href="#" class="footer-link">

                        Quản lý ứng viên

                    </a>

                </div>

                <div class="col-lg-2 mb-4">

                    <h6 class="footer-title">

                        Kết nối

                    </h6>

                    <div class="d-flex gap-3 fs-5">

                        <a href="#" class="text-white">

                            <i class="fab fa-facebook"></i>

                        </a>

                        <a href="#" class="text-white">

                            <i class="fab fa-linkedin"></i>

                        </a>

                        <a href="#" class="text-white">

                            <i class="fab fa-github"></i>

                        </a>

                    </div>

                </div>

            </div>

            <div class="footer-bottom">

                © {{ date('Y') }} JobConnect — Website tuyển dụng việc làm chuyên nghiệp

            </div>

        </div>

    </footer>

    {{-- BOOTSTRAP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    @if (auth()->check())
        <script>
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
    @endif

</body>

</html>
