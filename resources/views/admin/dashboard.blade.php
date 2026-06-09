@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    @php

        $totalUsers = \App\Models\User::count();
        $totalCandidates = \App\Models\Candidate::count();
        $totalEmployers = \App\Models\Employer::count();
        $totalJobs = \App\Models\Job::count();

        $pendingJobs = \App\Models\Job::where('status', 0)->count();
        $approvedJobs = \App\Models\Job::where('status', 1)->count();
        $rejectedJobs = \App\Models\Job::where('status', 2)->count();

        $totalApplications = \App\Models\Application::count();

        $todayApplications = \App\Models\Application::whereDate('created_at', now())->count();

        $latestApplications = \App\Models\Application::with(['candidate', 'job', 'job.employer'])
            ->latest()
            ->take(8)
            ->get();

        $topJobs = \App\Models\Job::withCount('applications')->orderByDesc('applications_count')->take(5)->get();

    @endphp

    <style>
        .report-card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            transition: .3s;
        }

        .report-card:hover {
            transform: translateY(-4px);
        }

        .report-icon {
            width: 65px;
            height: 65px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
        }

        .gradient-blue {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .gradient-red {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .gradient-dark {
            background: linear-gradient(135deg, #111827, #374151);
        }

        .chart-box {
            height: 320px;
        }

        .progress {
            height: 10px;
            border-radius: 20px;
        }

        .application-item {
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 18px;
            margin-bottom: 18px;
        }

        .application-item:last-child {
            border: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .avatar-sm {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .top-job-card {
            border: 1px solid #eee;
            border-radius: 18px;
            padding: 18px;
            transition: .3s;
        }

        .top-job-card:hover {
            border-color: #4f46e5;
            transform: translateY(-3px);
        }

        .dashboard-title {
            font-weight: 800;
            font-size: 32px;
        }

        .report-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 28px;
            overflow: hidden;
            color: #fff;
        }

        .report-header::before {
            content: '';
            position: absolute;
            right: -100px;
            top: -100px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }
    </style>

    <div class="container-fluid">

        {{-- HERO --}}
        <div class="report-header position-relative p-5 mb-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h1 class="dashboard-title mb-3">

                        Trang quản trị

                    </h1>

                    <p class="mb-0 opacity-75">

                        Theo dõi dữ liệu ứng viên, nhà tuyển dụng,
                        việc làm và hiệu suất hệ thống JobConnect

                    </p>

                </div>

                <div class="col-lg-4 text-end">

                    <div class="bg-white text-dark rounded-4 d-inline-block px-4 py-3 shadow-sm">

                        <div class="small text-muted">

                            Hôm nay

                        </div>

                        <h4 class="fw-bold mb-0">

                            {{ now()->format('d/m/Y') }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

        {{-- STATS --}}
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="report-card p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted mb-2">
                                Tổng Users
                            </div>

                            <h2 class="fw-bold mb-1">

                                {{ $totalUsers }}

                            </h2>

                            <small class="text-success">

                                <i class="fa fa-arrow-up"></i>
                                Active system

                            </small>

                        </div>

                        <div class="report-icon gradient-blue">

                            <i class="fa fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="report-card p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted mb-2">
                                Việc làm
                            </div>

                            <h2 class="fw-bold mb-1">

                                {{ $totalJobs }}

                            </h2>

                            <small class="text-primary">

                                {{ $approvedJobs }}
                                jobs approved

                            </small>

                        </div>

                        <div class="report-icon gradient-green">

                            <i class="fa fa-briefcase"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="report-card p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted mb-2">
                                Ứng tuyển
                            </div>

                            <h2 class="fw-bold mb-1">

                                {{ $totalApplications }}

                            </h2>

                            <small class="text-warning">

                                {{ $todayApplications }}
                                hôm nay

                            </small>

                        </div>

                        <div class="report-icon gradient-orange">

                            <i class="fa fa-file-signature"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="report-card p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted mb-2">
                                Employers
                            </div>

                            <h2 class="fw-bold mb-1">

                                {{ $totalEmployers }}

                            </h2>

                            <small class="text-danger">

                                {{ $pendingJobs }}
                                jobs pending

                            </small>

                        </div>

                        <div class="report-icon gradient-red">

                            <i class="fa fa-building"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        {{-- ========================================================= --}}
        {{-- CANDIDATE + EMPLOYER ANALYTICS --}}
        {{-- ========================================================= --}}

        @php

            /*
    |--------------------------------------------------------------------------
    | CANDIDATE ANALYTICS
    |--------------------------------------------------------------------------
    */

            $completedProfiles = \App\Models\Candidate::whereNotNull('full_name')
                ->whereNotNull('phone')
                ->whereNotNull('skills')
                ->whereNotNull('experience')
                ->whereNotNull('education')
                ->count();

            $profileCompletionRate = $totalCandidates > 0 ? round(($completedProfiles / $totalCandidates) * 100) : 0;

            $hotCategories = \App\Models\Category::withCount([
                'jobs as applications_count' => function ($q) {
                    $q->join('applications', 'jobs.id', '=', 'applications.job_id');
                },
            ])
                ->take(5)
                ->get();

            /*
    |--------------------------------------------------------------------------
    | EMPLOYER ANALYTICS
    |--------------------------------------------------------------------------
    */

            $monthlyJobsAvg = $totalEmployers > 0 ? round($totalJobs / $totalEmployers, 1) : 0;

            $approveRate = $totalJobs > 0 ? round(($approvedJobs / $totalJobs) * 100) : 0;

            $rejectRate = $totalJobs > 0 ? round(($rejectedJobs / $totalJobs) * 100) : 0;

            $topViewedJobs = \App\Models\Job::with('employer')->orderByDesc('views')->take(5)->get();

        @endphp

        <div class="row">

            {{-- ========================================================= --}}
            {{-- CANDIDATE ANALYTICS --}}
            {{-- ========================================================= --}}
            <div class="col-lg-6 mb-4">

                <div class="report-card p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h4 class="fw-bold mb-1">

                                Candidate Analytics

                            </h4>

                            <small class="text-muted">

                                Phân tích hành vi và chất lượng ứng viên

                            </small>

                        </div>

                        <div class="report-icon gradient-blue">

                            <i class="fa fa-user-graduate"></i>

                        </div>

                    </div>

                    {{-- PROFILE COMPLETION --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Tỷ lệ hoàn thiện hồ sơ

                            </span>

                            <span class="fw-bold text-primary">

                                {{ $profileCompletionRate }}%

                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-primary" style="width:{{ $profileCompletionRate }}%"></div>

                        </div>

                    </div>

                    {{-- STATS --}}
                    <div class="row text-center mb-4">

                        <div class="col-6">

                            <div class="border rounded-4 p-3">

                                <h3 class="fw-bold text-success">

                                    {{ $completedProfiles }}

                                </h3>

                                <div class="small text-muted">

                                    Hồ sơ hoàn chỉnh

                                </div>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded-4 p-3">

                                <h3 class="fw-bold text-danger">

                                    {{ $totalCandidates - $completedProfiles }}

                                </h3>

                                <div class="small text-muted">

                                    Hồ sơ chưa đủ

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- HOT CATEGORIES --}}
                    <h6 class="fw-bold mb-3">

                        Nhóm ngành HOT

                    </h6>

                    @foreach ($hotCategories as $category)
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <div class="fw-semibold">

                                    {{ $category->name }}

                                </div>

                            </div>

                            <span class="badge bg-primary rounded-pill px-3 py-2">

                                {{ $category->applications_count }}
                                apply

                            </span>

                        </div>
                    @endforeach

                    {{-- SEARCH KEYWORDS --}}
                    <div class="mt-4">

                        <h6 class="fw-bold mb-3">

                            Top từ khóa tìm kiếm

                        </h6>

                        <div class="d-flex flex-wrap gap-2">

                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                PHP Developer
                            </span>

                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                Laravel
                            </span>

                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                Frontend
                            </span>

                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                ReactJS
                            </span>

                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                Java
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- EMPLOYER ANALYTICS --}}
            {{-- ========================================================= --}}
            <div class="col-lg-6 mb-4">

                <div class="report-card p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h4 class="fw-bold mb-1">

                                Employer Analytics

                            </h4>

                            <small class="text-muted">

                                Theo dõi nhu cầu tuyển dụng doanh nghiệp

                            </small>

                        </div>

                        <div class="report-icon gradient-green">

                            <i class="fa fa-building"></i>

                        </div>

                    </div>

                    {{-- POST FREQUENCY --}}
                    <div class="border rounded-4 p-4 mb-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted mb-1">

                                    Tần suất đăng tin trung bình

                                </div>

                                <h2 class="fw-bold mb-0">

                                    {{ $monthlyJobsAvg }}

                                </h2>

                            </div>

                            <div class="text-primary">

                                jobs / employer

                            </div>

                        </div>

                    </div>

                    {{-- APPROVE RATE --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Tỷ lệ duyệt tin

                            </span>

                            <span class="fw-bold text-success">

                                {{ $approveRate }}%

                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-success" style="width:{{ $approveRate }}%"></div>

                        </div>

                    </div>

                    {{-- REJECT RATE --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Tin bị từ chối

                            </span>

                            <span class="fw-bold text-danger">

                                {{ $rejectRate }}%

                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-danger" style="width:{{ $rejectRate }}%"></div>

                        </div>

                    </div>

                    {{-- TOP VIEWED JOBS --}}
                    <h6 class="fw-bold mb-3 mt-4">

                        Hiệu quả tin tuyển dụng

                    </h6>

                    @foreach ($topViewedJobs as $job)
                        <div class="border rounded-4 p-3 mb-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <div class="fw-semibold">

                                        {{ $job->title }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $job->employer->company_name ?? '---' }}

                                    </small>

                                </div>

                                <div class="text-end">

                                    <div class="fw-bold text-primary">

                                        {{ $job->views }}

                                    </div>

                                    <small class="text-muted">

                                        views

                                    </small>

                                </div>

                            </div>

                        </div>
                    @endforeach

                    {{-- RESPONSE TIME --}}
                    <div class="mt-4 border-top pt-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="fw-bold mb-1">

                                    Tỷ lệ phản hồi

                                </h6>

                                <small class="text-muted">

                                    Thời gian phản hồi trung bình

                                </small>

                            </div>

                            <div class="text-end">

                                <h3 class="fw-bold text-success mb-0">

                                    ~2h

                                </h3>

                                <small class="text-muted">

                                    trung bình

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- CHART + STATUS --}}
        <div class="row">

            {{-- CHART --}}
            <div class="col-lg-8 mb-4">

                <div class="report-card p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h4 class="fw-bold mb-1">

                                Thống kê Jobs

                            </h4>

                            <small class="text-muted">

                                Tổng quan trạng thái bài tuyển dụng

                            </small>

                        </div>

                    </div>

                    <div class="chart-box">

                        <canvas id="jobChart"></canvas>

                    </div>

                </div>

            </div>

            {{-- STATUS --}}
            <div class="col-lg-4 mb-4">

                <div class="report-card p-4 h-100">

                    <h4 class="fw-bold mb-4">

                        Tình trạng hệ thống

                    </h4>

                    {{-- APPROVED --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span>Jobs đã duyệt</span>

                            <strong>{{ $approvedJobs }}</strong>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-success"
                                style="width:{{ $totalJobs > 0 ? ($approvedJobs / $totalJobs) * 100 : 0 }}%"></div>

                        </div>

                    </div>

                    {{-- PENDING --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span>Jobs chờ duyệt</span>

                            <strong>{{ $pendingJobs }}</strong>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-warning"
                                style="width:{{ $totalJobs > 0 ? ($pendingJobs / $totalJobs) * 100 : 0 }}%"></div>

                        </div>

                    </div>

                    {{-- REJECT --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span>Jobs từ chối</span>

                            <strong>{{ $rejectedJobs }}</strong>

                        </div>

                        <div class="progress">

                            <div class="progress-bar bg-danger"
                                style="width:{{ $totalJobs > 0 ? ($rejectedJobs / $totalJobs) * 100 : 0 }}%"></div>

                        </div>

                    </div>

                    <hr>

                    <div class="text-center mt-4">

                        <div class="report-icon gradient-dark mx-auto mb-3">

                            <i class="fa fa-chart-line"></i>

                        </div>

                        <h3 class="fw-bold">

                            {{ $totalCandidates }}

                        </h3>

                        <p class="text-muted mb-0">

                            Tổng ứng viên trên hệ thống

                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- TOP JOBS + LATEST APPLICATIONS --}}
        <div class="row">

            {{-- TOP JOBS --}}
            <div class="col-lg-5 mb-4">

                <div class="report-card p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4 class="fw-bold mb-0">

                            Top Jobs

                        </h4>

                        <span class="badge bg-primary rounded-pill">

                            HOT

                        </span>

                    </div>

                    @foreach ($topJobs as $job)
                        <div class="top-job-card mb-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h6 class="fw-bold mb-1">

                                        {{ $job->title }}

                                    </h6>

                                    <small class="text-muted">

                                        {{ $job->employer->company_name ?? '---' }}

                                    </small>

                                </div>

                                <div class="text-end">

                                    <h5 class="fw-bold text-primary mb-0">

                                        {{ $job->applications_count }}

                                    </h5>

                                    <small class="text-muted">

                                        applications

                                    </small>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            {{-- LATEST APPLICATIONS --}}
            <div class="col-lg-7 mb-4">

                <div class="report-card p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4 class="fw-bold mb-0">

                            Ứng tuyển gần đây

                        </h4>

                        <a href="/admin/applications" class="btn btn-primary rounded-pill px-4">

                            Xem thêm

                        </a>

                    </div>

                    @foreach ($latestApplications as $application)
                        <div class="application-item">

                            <div class="d-flex justify-content-between align-items-center">

                                <div class="d-flex align-items-center gap-3">

                                    <img src="{{ $application->candidate->avatar
                                        ? asset($application->candidate->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($application->candidate->full_name) }}"
                                        class="avatar-sm">

                                    <div>

                                        <h6 class="fw-bold mb-1">

                                            {{ $application->candidate->full_name }}

                                        </h6>

                                        <div class="text-muted small">

                                            Apply:
                                            {{ $application->job->title ?? '---' }}

                                        </div>

                                    </div>

                                </div>

                                <div class="text-end">

                                    @if ($application->status == 0)
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                                            Pending

                                        </span>
                                    @elseif($application->status == 2)
                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            Approved

                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 py-2">

                                            Rejected

                                        </span>
                                    @endif

                                    <div class="small text-muted mt-2">

                                        {{ $application->created_at->diffForHumans() }}

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('jobChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: [

                    'Approved',
                    'Pending',
                    'Rejected'

                ],

                datasets: [{

                    label: 'Jobs',

                    data: [

                        {{ $approvedJobs }},
                        {{ $pendingJobs }},
                        {{ $rejectedJobs }}

                    ],

                    borderRadius: 12

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        display: false

                    }

                },

                scales: {

                    y: {

                        beginAtZero: true

                    }

                }

            }

        });
    </script>

@endsection
