@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/home.css') }}">

<section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1 class="dashboard-title">

                             @yield('title', 'Danh sách việc làm')

                        </h1>

                    </div>

                </div>

            </div>

        </section>
<div class="row">

        @foreach($jobs as $job)

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
        <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">

                <div class="text-muted small">

                    Hiển thị
                    <strong>{{ $jobs->firstItem() }}</strong>
                    -
                    <strong>{{ $jobs->lastItem() }}</strong>

                    trong tổng số
                    <strong>{{ $jobs->total() }}</strong>
                    việc làm

                </div>

                <div>

                    {{ $jobs->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

        </div>

    </div>
@endsection