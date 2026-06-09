@extends('layouts.app')

@section('title', $company->company_name)

@section('content')

<div class="company-page">

    {{-- BANNER --}}
    <div class="company-banner">

        <img
            src="{{ $company->banner
                ? asset($company->banner)
                : 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=2070'
            }}"
            class="banner-image">

    </div>


    {{-- COMPANY HEADER --}}
    <div class="company-header shadow-sm">

        <div class="row align-items-center">

            {{-- LEFT --}}
            <div class="col-lg-8">

                <div class="d-flex gap-4 align-items-center flex-wrap">

                    {{-- LOGO --}}
                    <div class="company-logo-wrapper">

                        <img
                            src="{{ $company->logo
                                ? asset($company->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($company->company_name)
                            }}"
                            class="company-logo">

                    </div>

                    {{-- INFO --}}
                    <div>

                        <h1 class="company-name">

                            {{ $company->company_name }}

                        </h1>

                        <div class="company-meta">

                            <span>

                                <i class="fa fa-briefcase"></i>

                                {{ $company->industry }}

                            </span>

                            <span>

                                <i class="fa fa-users"></i>

                                {{ $company->company_size }}

                            </span>

                            <span>

                                <i class="fa fa-calendar"></i>

                                {{ $company->founded_year }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <a href="#jobs"
                   class="btn btn-primary btn-lg rounded-pill px-4">

                    <i class="fa fa-briefcase me-2"></i>

                    {{ $jobs->count() }} việc đang tuyển

                </a>

            </div>

        </div>

    </div>


    {{-- CONTENT --}}
    <div class="row mt-4">

        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- JOBS --}}
            <div class="content-card mb-4"
                 id="jobs">

                <h3 class="section-title">

                    Việc làm đang tuyển

                </h3>

                @forelse($jobs as $job)

                    <div class="job-item">

                        <div class="d-flex gap-3">

                            <img
                                src="{{ $company->logo
                                    ? asset($company->logo)
                                    : 'https://ui-avatars.com/api/?name='.urlencode($company->company_name)
                                }}"
                                class="job-company-logo">

                            <div class="flex-grow-1">

                                <h5 class="mb-2">

                                    <a href="/jobs/{{ $job->slug }}"
                                       class="job-link">

                                        {{ $job->title }}

                                    </a>

                                </h5>

                                <div class="job-info">

                                    <span>

                                        <i class="fa fa-location-dot"></i>

                                        {{ $job->location->name ?? '' }}

                                    </span>

                                    <span>

                                        <i class="fa fa-money-bill"></i>

                                        {{ number_format($job->salary_min) }}
                                        -
                                        {{ number_format($job->salary_max) }}

                                    </span>

                                    <span>

                                        <i class="fa fa-clock"></i>

                                        {{ $job->created_at->diffForHumans() }}

                                    </span>

                                </div>

                                <div class="mt-3">

                                    <span class="badge rounded-pill bg-light text-dark">

                                        {{ $job->jobType->name ?? '' }}

                                    </span>

                                </div>

                            </div>

                            <div>

                                <a href="/jobs/{{ $job->slug }}"
                                   class="btn btn-outline-primary rounded-pill">

                                    Xem

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5 text-muted">

                        Chưa có việc làm

                    </div>

                @endforelse

            </div>


            {{-- ABOUT --}}
            <div class="content-card">

                <h3 class="section-title">

                    Giới thiệu công ty

                </h3>

                <div class="company-description">

                    {!! nl2br(e($company->description)) !!}

                </div>

            </div>

        </div>


        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- COMPANY INFO --}}
            <div class="content-card mb-4">

                <h4 class="section-title">

                    Thông tin công ty

                </h4>

                <div class="info-list">

                    <div class="info-item">

                        <i class="fa fa-location-dot"></i>

                        <div>

                            <strong>Địa chỉ</strong>

                            <p>

                                {{ $company->address }}

                            </p>

                        </div>

                    </div>

                    <div class="info-item">

                        <i class="fa fa-phone"></i>

                        <div>

                            <strong>Số điện thoại</strong>

                            <p>

                                {{ $company->phone }}

                            </p>

                        </div>

                    </div>

                    <div class="info-item">

                        <i class="fa fa-envelope"></i>

                        <div>

                            <strong>Email</strong>

                            <p>

                                {{ $company->email }}

                            </p>

                        </div>

                    </div>

                    <div class="info-item">

                        <i class="fa fa-globe"></i>

                        <div>

                            <strong>Website</strong>

                            <p>

                                <a href="https://{{ $company->website }}"
                                   target="_blank">

                                    {{ $company->website }}

                                </a>

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- SOCIAL --}}
            <div class="content-card">

                <h4 class="section-title">

                    Mạng xã hội

                </h4>

                <div class="d-grid gap-3">

                    @if($company->facebook)

                        <a href="https://{{ $company->facebook }}"
                           target="_blank"
                           class="social-btn facebook">

                            <i class="fab fa-facebook"></i>

                            Facebook

                        </a>

                    @endif

                    @if($company->linkedin)

                        <a href="https://{{ $company->linkedin }}"
                           target="_blank"
                           class="social-btn linkedin">

                            <i class="fab fa-linkedin"></i>

                            Linkedin

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>



<style>

.company-page{
    padding-bottom:40px;
}

.company-banner{
    height:320px;
    overflow:hidden;
    border-radius:30px;
}

.banner-image{
    width:100%;
    height:100%;
    object-fit:cover;
}

.company-header{
    background:white;
    border-radius:30px;
    padding:40px;
    margin-top:-80px;
    position:relative;
    z-index:10;
}

.company-logo-wrapper{
    width:160px;
    height:160px;
    background:white;
    border-radius:30px;
    padding:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.company-logo{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:20px;
}

.company-name{
    font-size:42px;
    font-weight:800;
    margin-bottom:15px;
}

.company-meta{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    color:#666;
}

.content-card{
    background:white;
    border-radius:24px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
}

.section-title{
    font-weight:700;
    margin-bottom:25px;
}

.job-item{
    padding:25px 0;
    border-bottom:1px solid #eee;
}

.job-item:last-child{
    border-bottom:none;
}

.job-company-logo{
    width:70px;
    height:70px;
    border-radius:18px;
    object-fit:cover;
    border:1px solid #eee;
}

.job-link{
    text-decoration:none;
    color:#111;
    font-weight:700;
}

.job-link:hover{
    color:#0d6efd;
}

.job-info{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    color:#666;
    font-size:14px;
}

.info-list{
    display:flex;
    flex-direction:column;
    gap:25px;
}

.info-item{
    display:flex;
    gap:15px;
}

.info-item i{
    width:45px;
    height:45px;
    background:#eef4ff;
    color:#0d6efd;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.info-item p{
    margin:0;
    color:#666;
}

.social-btn{
    padding:14px;
    border-radius:14px;
    text-decoration:none;
    color:white;
    font-weight:600;
    text-align:center;
}

.facebook{
    background:#1877f2;
}

.linkedin{
    background:#0a66c2;
}

.company-description{
    line-height:1.9;
    color:#555;
}

@media(max-width:768px){

    .company-name{
        font-size:28px;
    }

    .company-logo-wrapper{
        width:120px;
        height:120px;
    }

    .company-header{
        padding:25px;
    }

}

</style>

@endsection