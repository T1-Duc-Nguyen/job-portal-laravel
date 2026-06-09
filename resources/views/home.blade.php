@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<link rel="stylesheet"
      href="{{ asset('css/home.css') }}">
{{-- HERO --}}
<section class="hero-section mb-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <div class="hero-content">

                    <span class="hero-badge">

                        🔥 Hơn 10.000+ việc làm chất lượng
                    </span>

                    <h1 class="hero-title">

                        Tìm việc làm mơ ước
                        <span class="text-primary">
                            nhanh chóng
                        </span>

                    </h1>

                    <p class="hero-desc">

                        Khám phá hàng ngàn cơ hội việc làm hấp dẫn từ các công ty hàng đầu Việt Nam.

                    </p>

                    {{-- SEARCH --}}
                    <form action="/jobs"
                          class="hero-search">

                        <div class="row g-2">

                            <div class="col-md-10">

                                <input type="text"
                                       name="keyword"
                                       class="form-control search-input"
                                       placeholder="Tên công việc, kỹ năng, công ty...">

                            </div>

                            <div class="col-md-2">

                                <button class="btn btn-primary search-btn w-100">

                                    <i class="fa fa-search me-2"></i>

                                    Tìm

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <div class="col-lg-5 text-center">

                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                     class="img-fluid hero-image">

            </div>

        </div>

    </div>

</section>


{{-- FEATURED JOBS --}}
<section class="mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                Việc làm nổi bật

            </h2>

            <p class="text-muted mb-0">

                Những công việc hot nhất hôm nay

            </p>

        </div>

        <a href="/jobs"
           class="btn btn-outline-primary rounded-pill px-4">

            Xem tất cả

        </a>

    </div>


    <div class="row">

        @foreach($jobs->take(8) as $job)

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="job-card">

                    {{-- TOP --}}
                    <div class="d-flex align-items-center gap-3 mb-3">

                        <img
                            src="{{ $job->employer->logo
                                ? asset($job->employer->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($job->employer->company_name)
                            }}"
                            class="company-logo">

                        <div>

                            <div class="small text-muted">

                                {{ $job->employer->company_name ?? '' }}

                            </div>

                            <div class="job-time">

                                {{ $job->created_at->diffForHumans() }}

                            </div>

                        </div>

                    </div>

                    {{-- TITLE --}}
                    <h5 class="job-title">

                        <a href="/jobs/{{ $job->slug }}">

                            {{ $job->title }}

                        </a>

                    </h5>

                    {{-- SALARY --}}
                    <div class="salary-box">

                        {{ number_format($job->salary_min) }}
                        -
                        {{ number_format($job->salary_max) }}
                        VNĐ

                    </div>

                    {{-- INFO --}}
                    <div class="job-meta">

                        <span>

                            <i class="fa fa-location-dot"></i>

                            {{ $job->location->name ?? '' }}

                        </span>

                        <span>

                            <i class="fa fa-briefcase"></i>

                            {{ $job->jobType->name ?? '' }}

                        </span>

                    </div>

                    {{-- BUTTON --}}
                    <a href="/jobs/{{ $job->slug }}"
                       class="btn btn-primary w-100 rounded-3">

                        Xem chi tiết

                    </a>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- RECOMMENDED --}}
<section class="mb-5">

    <div class="mb-4">

        <h2 class="fw-bold">

            Việc làm đề xuất cho bạn

        </h2>

        <p class="text-muted">

            Dựa trên xu hướng tuyển dụng mới nhất

        </p>

    </div>

    <div class="row">

        @foreach($jobs->shuffle()->take(4) as $job)

            <div class="col-lg-6 mb-4">

                <div class="recommend-card">

                    <div class="d-flex gap-3">

                        <img
                            src="{{ $job->employer->logo
                                ? asset($job->employer->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($job->employer->company_name)
                            }}"
                            class="recommend-logo">

                        <div class="flex-grow-1">

                            <h5 class="fw-bold">

                                {{ $job->title }}

                            </h5>

                            <div class="text-primary fw-semibold mb-2">

                                <a href="{{ route('company.show', $job->employer->slug) }}"
                                class="text-decoration-none fw-semibold">

                                    {{ $job->employer->company_name }}

                                </a>

                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">

                                <span class="badge bg-light text-dark">

                                    {{ $job->location->name ?? '' }}

                                </span>

                                <span class="badge bg-light text-dark">

                                    {{ $job->jobType->name ?? '' }}

                                </span>

                            </div>

                            <a href="/jobs/{{ $job->slug }}"
                               class="btn btn-sm btn-primary rounded-pill px-3">

                                Ứng tuyển ngay

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- TOP CATEGORIES --}}
<section class="mb-5">

    <div class="mb-4">

        <h2 class="fw-bold">

            Ngành nghề nổi bật

        </h2>

        <p class="text-muted">

            Khám phá lĩnh vực tuyển dụng hot nhất

        </p>

    </div>

    <div class="row">

        @foreach(\App\Models\Category::take(8)->get() as $category)

            <div class="col-lg-3 col-md-4 col-6 mb-4">

                <div class="category-card text-center">

                    <div class="category-icon">

                        <i class="fa fa-briefcase"></i>

                    </div>

                    <h6 class="fw-bold">

                        {{ $category->name }}

                    </h6>

                    <small class="text-muted">

                        {{ \App\Models\Job::where('category_id', $category->id)->count() }}
                        việc làm

                    </small>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- TOP EMPLOYERS --}}
<section>

    <div class="mb-4">

        <h2 class="fw-bold">

            Nhà tuyển dụng tiêu biểu

        </h2>

        <p class="text-muted">

            Các doanh nghiệp tuyển dụng hàng đầu

        </p>

    </div>

    <div class="row">

        @foreach(\App\Models\Employer::where('is_approved',1)->take(6)->get() as $company)

            <div class="col-lg-2 col-md-4 col-6 mb-4">

                <div class="company-card text-center">

                    <img 
                        src="{{ $company->logo
                            ? asset($company->logo)
                            : 'https://ui-avatars.com/api/?name='.urlencode($company->company_name)
                        }}"
                        class="top-company-logo">
                    
                    <h6 class="fw-bold mt-3">

                        {{ $company->company_name }}

                    </h6>

                </div>

            </div>

        @endforeach

    </div>

</section>

@endsection