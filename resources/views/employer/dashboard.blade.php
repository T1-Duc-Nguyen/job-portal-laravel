@extends('layouts.employer')
@section('title', 'Nhà tuyển dụng - Dashboard')
@section('content')

    <div class="container-fluid py-4">

        {{-- HERO --}}
        <div class="dashboard-hero mb-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <span class="hero-badge">

                        Employer Dashboard

                    </span>

                    <h1 class="hero-title mt-3">

                        Xin chào {{ auth()->user()->name }} 👋

                    </h1>

                    <p class="hero-subtitle mb-0">

                        Quản lý tin tuyển dụng, ứng viên và hoạt động tuyển dụng của doanh nghiệp.

                    </p>

                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                    <a href="/employer/jobs/create" class="btn btn-light hero-btn">

                        <i class="fa fa-plus me-2"></i>

                        Đăng tin tuyển dụng

                    </a>

                </div>

            </div>

        </div>


        {{-- STATS --}}
        <div class="row g-4 mb-4">

            {{-- TOTAL JOBS --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card stats-blue">

                    <div class="stats-icon">

                        <i class="fa fa-briefcase"></i>

                    </div>

                    <div>

                        <div class="stats-number">

                            {{ $totalJobs }}

                        </div>

                        <div class="stats-label">

                            Tổng tin tuyển dụng

                        </div>

                    </div>

                </div>

            </div>


            {{-- ACTIVE JOBS --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card stats-success">

                    <div class="stats-icon">

                        <i class="fa fa-check-circle"></i>

                    </div>

                    <div>

                        <div class="stats-number">

                            {{ $activeJobs }}

                        </div>

                        <div class="stats-label">

                            Tin đang hoạt động

                        </div>

                    </div>

                </div>

            </div>


            {{-- APPLICATIONS --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card stats-warning">

                    <div class="stats-icon">

                        <i class="fa fa-users"></i>

                    </div>

                    <div>

                        <div class="stats-number">

                            {{ $totalApplications }}

                        </div>

                        <div class="stats-label">

                            Lượt ứng tuyển

                        </div>

                    </div>

                </div>

            </div>


            {{-- APPROVED --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card stats-danger">

                    <div class="stats-icon">

                        <i class="fa fa-user-check"></i>

                    </div>

                    <div>

                        <div class="stats-number">

                            {{ $approvedApplications }}

                        </div>

                        <div class="stats-label">

                            Ứng viên phù hợp

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">

                {{-- RECENT JOBS --}}
                <div class="dashboard-card mb-4">

                    <div class="dashboard-card-header">

                        <div>

                            <h4 class="dashboard-title mb-1">

                                Tin tuyển dụng gần đây

                            </h4>

                            <p class="text-muted mb-0 small">

                                Quản lý nhanh các tin tuyển dụng của doanh nghiệp

                            </p>

                        </div>

                        <a href="/employer/jobs" class="btn btn-primary rounded-3 px-4">

                            Xem tất cả

                        </a>

                    </div>


                    @forelse($jobs ?? [] as $job)
                        <div class="job-item">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                <div>

                                    <h5 class="job-name">

                                        {{ $job->title }}

                                    </h5>

                                    <div class="job-meta d-flex flex-wrap gap-3">

                                        <span>

                                            <i class="fa fa-location-dot"></i>

                                            {{ $job->location->name ?? 'Đang cập nhật' }}

                                        </span>

                                        <span>

                                            <i class="fa fa-money-bill-wave"></i>

                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            {{ $job->currency }}

                                        </span>

                                        <span>

                                            <i class="fa fa-users"></i>

                                            {{ $job->applications_count ?? 0 }} ứng viên

                                        </span>

                                    </div>

                                </div>


                                <div class="d-flex gap-2">

                                    <a href="/employer/jobs/{{ $job->id }}/edit" class="btn btn-light action-btn">

                                        <i class="fa fa-pen"></i>

                                    </a>

                                    <a href="/employer/jobs/{{ $job->id }}/applications"
                                        class="btn btn-primary action-btn">

                                        <i class="fa fa-users"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-box text-center py-5">

                            <i class="fa fa-briefcase mb-3"></i>

                            <h5 class="fw-bold">

                                Chưa có tin tuyển dụng

                            </h5>

                            <p class="text-muted mb-4">

                                Hãy đăng tin tuyển dụng đầu tiên của bạn.

                            </p>

                            <a href="/employer/jobs/create" class="btn btn-primary rounded-3 px-4 py-2">

                                Đăng tin ngay

                            </a>

                        </div>
                    @endforelse

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-lg-4">

                {{-- QUICK ACTIONS --}}
                <div class="dashboard-card mb-4">

                    <h4 class="dashboard-title mb-4">

                        Thao tác nhanh

                    </h4>

                    <div class="quick-actions">

                        <a href="/employer/jobs/create" class="quick-item">

                            <div class="quick-icon bg-primary-subtle text-primary">

                                <i class="fa fa-plus"></i>

                            </div>

                            <div>

                                <h6 class="mb-1 fw-bold">

                                    Đăng tuyển dụng

                                </h6>

                                <small class="text-muted">

                                    Tạo bài đăng mới

                                </small>

                            </div>

                        </a>


                        <a href="/employer/jobs" class="quick-item">

                            <div class="quick-icon bg-success-subtle text-success">

                                <i class="fa fa-briefcase"></i>

                            </div>

                            <div>

                                <h6 class="mb-1 fw-bold">

                                    Quản lý jobs

                                </h6>

                                <small class="text-muted">

                                    Xem danh sách tuyển dụng

                                </small>

                            </div>

                        </a>


                        <a href="/employer/applications" class="quick-item">

                            <div class="quick-icon bg-warning-subtle text-warning">

                                <i class="fa fa-users"></i>

                            </div>

                            <div>

                                <h6 class="mb-1 fw-bold">

                                    Quản lý ứng viên

                                </h6>

                                <small class="text-muted">

                                    Xem CV ứng tuyển

                                </small>

                            </div>

                        </a>

                    </div>

                </div>


                {{-- COMPANY BOX --}}
                <div class="dashboard-card">

                    <div class="text-center">

                        <div class="company-avatar mx-auto mb-3">

                            @if (auth()->user()->employer && auth()->user()->employer->logo)
                                <img src="{{ asset(auth()->user()->employer->logo) }}"
                                    class="img-fluid w-100 h-100 object-fit-cover rounded-circle">
                            @else
                                <i class="fa fa-building"></i>
                            @endif

                        </div>

                        <h5 class="fw-bold mb-2">

                            {{ auth()->user()->employer->company_name ?? 'Employer Company' }}

                        </h5>

                        <p class="text-muted small mb-4">

                            {{ auth()->user()->employer->industry ?? 'Doanh nghiệp tuyển dụng' }}

                        </p>

                        <a href="/employer/company" class="btn btn-outline-primary rounded-3 px-4">

                            <i class="fa fa-pen me-2"></i>

                            Cập nhật hồ sơ

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <style>
        body {
            background: #f3f6fb;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 28px;
            padding: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.18);
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.18);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
        }

        .hero-title {
            font-size: 40px;
            font-weight: 800;
        }

        .hero-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .hero-btn {
            border-radius: 16px;
            padding: 14px 24px;
            font-weight: 700;
        }

        .stats-card {
            background: white;
            border-radius: 24px;
            padding: 26px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
            transition: 0.3s;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-4px);
        }

        .stats-icon {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
        }

        .stats-blue .stats-icon {
            background: #2563eb;
        }

        .stats-success .stats-icon {
            background: #16a34a;
        }

        .stats-warning .stats-icon {
            background: #f59e0b;
        }

        .stats-danger .stats-icon {
            background: #dc2626;
        }

        .stats-number {
            font-size: 34px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stats-label {
            color: #64748b;
            margin-top: 6px;
            font-weight: 500;
        }

        .dashboard-card {
            background: white;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
        }

        .dashboard-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .dashboard-title {
            font-weight: 800;
            color: #0f172a;
        }

        .job-item {
            border: 1px solid #edf2f7;
            border-radius: 20px;
            padding: 22px;
            margin-bottom: 18px;
            transition: 0.3s;
        }

        .job-item:hover {
            border-color: #2563eb;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.08);
        }

        .job-name {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .job-meta span {
            color: #64748b;
            font-size: 14px;
            margin-right: 30px;
        }

        .job-meta i {
            color: #2563eb;
            margin-right: 5px;
        }

        .action-btn {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .quick-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px;
            border-radius: 18px;
            text-decoration: none;
            border: 1px solid #edf2f7;
            transition: 0.3s;
        }

        .quick-item:hover {
            background: #f8fbff;
            transform: translateY(-2px);
        }

        .quick-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .company-avatar {
            width: 110px;
            height: 110px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: #2563eb;
            overflow: hidden;
        }

        .empty-box i {
            font-size: 60px;
            color: #94a3b8;
        }

        @media(max-width:768px) {

            .hero-title {
                font-size: 30px;
            }

            .dashboard-hero {
                padding: 28px;
            }

        }
    </style>

@endsection
