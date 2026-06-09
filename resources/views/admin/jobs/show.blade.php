@extends('layouts.admin')

@section('title', 'Chi tiết Job')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="job-header-card mb-4">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="d-flex align-items-center gap-4">

                    {{-- LOGO --}}
                    <div class="company-logo">

                        @if($job->employer && $job->employer->logo)

                            <img src="{{ asset($job->employer->logo) }}"
                                 alt="logo">

                        @else

                            <i class="fa fa-building"></i>

                        @endif

                    </div>

                    {{-- INFO --}}
                    <div>

                        <div class="d-flex align-items-center gap-2 mb-2">

                            @if($job->status == 0)

                                <span class="status-badge pending">

                                    <i class="fa fa-clock me-1"></i>
                                    Chờ duyệt

                                </span>

                            @elseif($job->status == 1)

                                <span class="status-badge approved">

                                    <i class="fa fa-circle-check me-1"></i>
                                    Đã duyệt

                                </span>

                            @else

                                <span class="status-badge rejected">

                                    <i class="fa fa-circle-xmark me-1"></i>
                                    Từ chối

                                </span>

                            @endif

                        </div>

                        <h1 class="job-title">

                            {{ $job->title }}

                        </h1>

                        <div class="company-name">

                            {{ $job->employer->company_name ?? '---' }}

                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="col-lg-4">

                <div class="d-flex justify-content-lg-end gap-2 mt-4 mt-lg-0">

                    <a href="/admin/jobs/{{ $job->id }}/approve"
                       class="btn-action success">

                        <i class="fa fa-check"></i>

                        Duyệt

                    </a>

                    <a href="/admin/jobs/{{ $job->id }}/reject"
                       class="btn-action warning">

                        <i class="fa fa-xmark"></i>

                        Từ chối

                    </a>

                    <a href="/admin/jobs"
                       class="btn-action secondary">

                        <i class="fa fa-arrow-left"></i>

                        Quay lại

                    </a>

                </div>

            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="info-card">

                <div class="info-icon blue">

                    <i class="fa fa-money-bill-wave"></i>

                </div>

                <div>

                    <div class="info-label">

                        Mức lương

                    </div>

                    <div class="info-value text-success">

                        {{ number_format($job->salary_min) }}
                        -
                        {{ number_format($job->salary_max) }}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="info-card">

                <div class="info-icon green">

                    <i class="fa fa-location-dot"></i>

                </div>

                <div>

                    <div class="info-label">

                        Địa điểm

                    </div>

                    <div class="info-value">

                        {{ $job->location->name ?? '---' }}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="info-card">

                <div class="info-icon orange">

                    <i class="fa fa-briefcase"></i>

                </div>

                <div>

                    <div class="info-label">

                        Loại công việc

                    </div>

                    <div class="info-value">

                        {{ $job->jobType->name ?? '---' }}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="info-card">

                <div class="info-icon red">

                    <i class="fa fa-eye"></i>

                </div>

                <div>

                    <div class="info-label">

                        Lượt xem

                    </div>

                    <div class="info-value">

                        {{ $job->views }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="row">

        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- DESCRIPTION --}}
            <div class="content-card mb-4">

                <div class="card-title-custom">

                    <i class="fa fa-file-lines"></i>

                    Mô tả công việc

                </div>

                <div class="job-content">

                    {!! nl2br(e($job->description)) !!}

                </div>

            </div>

            {{-- REQUIREMENTS --}}
            <div class="content-card mb-4">

                <div class="card-title-custom">

                    <i class="fa fa-list-check"></i>

                    Yêu cầu ứng viên

                </div>

                <div class="job-content">

                    {!! nl2br(e($job->requirements)) !!}

                </div>

            </div>
            {{-- SKILLS --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        Kỹ năng yêu cầu

                    </h4>

                    <div class="d-flex flex-wrap gap-2">

                        @forelse($job->skills as $skill)

                            <span class="badge bg-primary px-3 py-2 rounded-pill">

                                {{ $skill->name }}

                            </span>

                        @empty

                            <span class="text-muted">

                                Không có kỹ năng

                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- JOB INFO --}}
            <div class="sidebar-card mb-4">

                <div class="sidebar-title">

                    Thông tin Job

                </div>

                <div class="sidebar-item">

                    <span>ID Job</span>

                    <strong>#{{ $job->id }}</strong>

                </div>

                <div class="sidebar-item">

                    <span>Ngành nghề</span>

                    <strong>

                        {{ $job->category->name ?? '---' }}

                    </strong>

                </div>

                <div class="sidebar-item">

                    <span>Ngày đăng</span>

                    <strong>

                        {{ $job->created_at->format('d/m/Y') }}

                    </strong>

                </div>

                <div class="sidebar-item">

                    <span>Hết hạn</span>

                    <strong>

                        {{ $job->expired_at }}

                    </strong>

                </div>

            </div>

            {{-- COMPANY --}}
            <div class="sidebar-card">

                <div class="sidebar-title">

                    Doanh nghiệp

                </div>

                <div class="company-box">

                    @if($job->employer && $job->employer->logo)

                        <img src="{{ asset($job->employer->logo) }}"
                             class="mini-logo">

                    @endif

                    <div>

                        <h6 class="fw-bold mb-1">

                            {{ $job->employer->company_name ?? '---' }}

                        </h6>

                        <small class="text-muted">

                            {{ $job->employer->industry ?? '---' }}

                        </small>

                    </div>

                </div>

                <hr>

                <div class="small text-muted">

                    {{ $job->employer->address ?? '---' }}

                </div>

            </div>

        </div>

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

.job-header-card{

    background:#fff;
    border-radius:28px;
    padding:35px;
    box-shadow:0 2px 14px rgba(0,0,0,0.06);

}

.company-logo{

    width:90px;
    height:90px;
    border-radius:24px;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    flex-shrink:0;

}

.company-logo img{

    width:100%;
    height:100%;
    object-fit:cover;

}

.company-logo i{

    font-size:36px;
    color:#6b7280;

}

.job-title{

    font-size:34px;
    font-weight:800;
    margin-bottom:10px;

}

.company-name{

    color:#6b7280;
    font-size:16px;

}

.status-badge{

    padding:10px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;

}

.pending{

    background:#fef3c7;
    color:#b45309;

}

.approved{

    background:#dcfce7;
    color:#166534;

}

.rejected{

    background:#fee2e2;
    color:#991b1b;

}

.btn-action{

    padding:12px 18px;
    border-radius:16px;
    text-decoration:none;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:8px;
    color:#fff;

}

.btn-action.success{

    background:#10b981;

}

.btn-action.warning{

    background:#f59e0b;

}

.btn-action.secondary{

    background:#64748b;

}

.info-card{

    background:#fff;
    border-radius:24px;
    padding:24px;
    display:flex;
    gap:18px;
    align-items:center;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);

}

.info-icon{

    width:60px;
    height:60px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:24px;

}

.blue{

    background:linear-gradient(135deg,#2563eb,#60a5fa);

}

.green{

    background:linear-gradient(135deg,#10b981,#34d399);

}

.orange{

    background:linear-gradient(135deg,#f59e0b,#fbbf24);

}

.red{

    background:linear-gradient(135deg,#ef4444,#f87171);

}

.info-label{

    color:#6b7280;
    font-size:14px;
    margin-bottom:4px;

}

.info-value{

    font-size:18px;
    font-weight:800;

}

.content-card{

    background:#fff;
    border-radius:28px;
    padding:30px;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);

}

.card-title-custom{

    font-size:22px;
    font-weight:800;
    margin-bottom:24px;
    display:flex;
    align-items:center;
    gap:12px;

}

.job-content{

    color:#374151;
    line-height:1.9;
    font-size:15px;

}

.sidebar-card{

    background:#fff;
    border-radius:28px;
    padding:28px;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);

}

.sidebar-title{

    font-size:20px;
    font-weight:800;
    margin-bottom:24px;

}

.sidebar-item{

    display:flex;
    justify-content:space-between;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;

}

.company-box{

    display:flex;
    gap:14px;
    align-items:center;

}

.mini-logo{

    width:60px;
    height:60px;
    border-radius:16px;
    object-fit:cover;

}

</style>

@endsection