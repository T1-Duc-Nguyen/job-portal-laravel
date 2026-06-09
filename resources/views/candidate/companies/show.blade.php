@extends('layouts.app')

@section('title', $company->company_name)

@section('content')

<div class="container py-5">

    {{-- COMPANY HEADER --}}
    <div class="company-header mb-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="d-flex align-items-center gap-4 flex-wrap">

                    {{-- LOGO --}}
                    <div>

                        <img
                            src="{{ $company->logo
                                ? asset($company->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($company->company_name)
                            }}"
                            class="company-logo">
                    </div>

                    {{-- INFO --}}
                    <div>

                        <h1 class="fw-bold mb-2">

                            {{ $company->company_name }}

                        </h1>

                        <div class="d-flex flex-wrap gap-3 text-muted mb-3">

                            @if($company->location)

                                <span>

                                    <i class="fa fa-location-dot me-1"></i>

                                    {{ $company->location }}

                                </span>

                            @endif

                            <span>

                                <i class="fa fa-briefcase me-1"></i>

                                {{ $company->jobs()->count() }} việc làm

                            </span>

                        </div>

                        @if($company->website)

                            <a href="https://{{ str_replace(['http://','https://'], '', $company->website) }}"
                               target="_blank"
                               class="btn btn-outline-primary rounded-pill px-4">

                                <i class="fa fa-globe me-2"></i>

                                Website công ty

                            </a>

                        @endif

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="company-stats">

                    <div class="stat-box">

                        <h3>

                            {{ $company->jobs()->count() }}

                        </h3>

                        <p>

                            Việc làm đang tuyển

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ABOUT --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">

        <div class="card-body p-4">

            <h4 class="fw-bold mb-4">

                Giới thiệu công ty

            </h4>

            <div class="company-description">

                {!! $company->description
                    ? nl2br($company->description)
                    : '<p class="text-muted">Chưa có mô tả công ty.</p>' !!}

            </div>

        </div>

    </div>

    {{-- JOBS --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Việc làm đang tuyển

            </h3>

            <p class="text-muted mb-0">

                Danh sách việc làm mới nhất từ công ty

            </p>

        </div>

    </div>

    <div class="row">

        @forelse($company->jobs as $job)

            <div class="col-lg-6 mb-4">

                <div class="job-card">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div>

                            <h5 class="fw-bold mb-2">

                                <a href="/jobs/{{ $job->slug }}"
                                   class="text-decoration-none text-dark">

                                    {{ $job->title }}

                                </a>

                            </h5>

                            <div class="text-primary fw-semibold">

                                {{ $company->company_name }}

                            </div>

                        </div>

                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">

                            {{ $job->jobType->name ?? '' }}

                        </span>

                    </div>

                    <div class="job-meta mb-3">

                        <span>

                            <i class="fa fa-location-dot me-1"></i>

                            {{ $job->location->name ?? '' }}

                        </span>

                    </div>

                    <div class="salary-box mb-3">

                        {{ number_format($job->salary_min) }}
                        -
                        {{ number_format($job->salary_max) }}
                        VNĐ

                    </div>

                    <div class="d-flex justify-content-between align-items-center">

                        <small class="text-muted">

                            {{ $job->created_at->diffForHumans() }}

                        </small>

                        <a href="/jobs/{{ $job->slug }}"
                           class="btn btn-primary rounded-pill px-4">

                            Xem chi tiết

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="empty-box">

                    <i class="fa fa-briefcase"></i>

                    <h4>

                        Chưa có việc làm nào

                    </h4>

                    <p>

                        Công ty hiện chưa đăng tuyển việc làm.

                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

.company-header{

    background:#fff;
    border-radius:28px;
    padding:40px;
    box-shadow:0 4px 20px rgba(15,23,42,0.06);

}

.company-logo{

    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:24px;
    border:1px solid #e5e7eb;
    background:#fff;

}

.company-stats{

    display:flex;
    justify-content:end;

}

.stat-box{

    background:linear-gradient(135deg,#2563eb,#3b82f6);
    color:#fff;
    padding:28px;
    border-radius:24px;
    min-width:220px;
    text-align:center;

}

.stat-box h3{

    font-size:38px;
    font-weight:800;
    margin-bottom:6px;

}

.stat-box p{

    margin:0;
    opacity:.9;

}

.job-card{

    background:#fff;
    border-radius:24px;
    padding:24px;
    height:100%;
    box-shadow:0 4px 20px rgba(15,23,42,0.05);
    transition:.25s;

}

.job-card:hover{

    transform:translateY(-4px);

}

.job-meta{

    display:flex;
    gap:18px;
    color:#6b7280;
    font-size:14px;

}

.salary-box{

    background:#eff6ff;
    color:#2563eb;
    padding:12px 18px;
    border-radius:14px;
    display:inline-block;
    font-weight:700;

}

.company-description{

    line-height:1.8;
    color:#374151;

}

.empty-box{

    background:#fff;
    border-radius:24px;
    padding:70px 20px;
    text-align:center;
    box-shadow:0 4px 20px rgba(15,23,42,0.05);

}

.empty-box i{

    font-size:60px;
    color:#cbd5e1;
    margin-bottom:20px;

}

.empty-box p{

    color:#94a3b8;

}

</style>

@endsection