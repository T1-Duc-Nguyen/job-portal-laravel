@extends('layouts.admin')

@section('title', 'Chi tiết doanh nghiệp')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Chi tiết doanh nghiệp

            </h2>

            <p class="text-muted mb-0">

                Quản lý và xem đầy đủ thông tin nhà tuyển dụng

            </p>

        </div>

        <div class="d-flex gap-2">

            @if($employer->is_approved)

                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">

                    <i class="fa fa-circle-check me-2"></i>

                    Đã duyệt

                </span>

            @else

                <span class="badge bg-warning-subtle text-warning px-4 py-2 rounded-pill">

                    <i class="fa fa-clock me-2"></i>

                    Chờ duyệt

                </span>

            @endif

        </div>

    </div>

    <div class="row">

        {{-- LEFT --}}
        <div class="col-lg-4 mb-4">

            {{-- COMPANY CARD --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- BANNER --}}
                <div class="position-relative">

                    @if($employer->banner)

                        <img src="{{ asset($employer->banner) }}"
                             class="w-100 object-fit-cover"
                             style="height:180px;">

                    @else

                        <div class="bg-primary"
                             style="height:180px;"></div>

                    @endif

                    {{-- LOGO --}}
                    <div class="position-absolute start-50 translate-middle"
                         style="bottom:-60px;">

                        @if($employer->logo)

                            <img src="{{ asset($employer->logo) }}"
                                 class="rounded-4 border border-4 border-white bg-white object-fit-cover shadow"
                                 width="120"
                                 height="120">

                        @else

                            <div class="rounded-4 bg-white shadow d-flex align-items-center justify-content-center border"
                                 style="width:120px;height:120px;">

                                <i class="fa fa-building text-secondary"
                                   style="font-size:40px;"></i>

                            </div>

                        @endif

                    </div>

                </div>

                <div class="card-body pt-5 mt-4 text-center">

                    <h3 class="fw-bold mb-2">

                        {{ $employer->company_name }}

                    </h3>

                    <p class="text-muted mb-3">

                        {{ $employer->industry ?? 'Chưa cập nhật ngành nghề' }}

                    </p>

                    {{-- STATS --}}
                    <div class="row g-3 mt-3">

                        <div class="col-6">

                            <div class="border rounded-4 p-3">

                                <h4 class="fw-bold text-primary mb-1">

                                    {{ $employer->jobs->count() }}

                                </h4>

                                <small class="text-muted">

                                    Jobs

                                </small>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded-4 p-3">

                                <h4 class="fw-bold text-success mb-1">

                                    {{ $employer->jobs->sum(function($job){
                                        return $job->applications->count();
                                    }) }}

                                </h4>

                                <small class="text-muted">

                                    Apply

                                </small>

                            </div>

                        </div>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-grid gap-2 mt-4">

                        <a href="/admin/employers/{{ $employer->id }}/approve"
                           class="btn btn-success rounded-4">

                            <i class="fa fa-check me-2"></i>

                            Duyệt doanh nghiệp

                        </a>

                        <a href="/admin/employers/{{ $employer->id }}/reject"
                           class="btn btn-warning text-white rounded-4">

                            <i class="fa fa-xmark me-2"></i>

                            Từ chối

                        </a>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-8">

            {{-- COMPANY INFO --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h4 class="fw-bold mb-0">

                        Thông tin công ty

                    </h4>

                </div>

                <div class="card-body pt-0 px-4 pb-4">

                    <div class="row g-4">

                        {{-- EMAIL --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Email

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->email ?? ($employer->user->email ?? '---') }}

                                </div>

                            </div>

                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Số điện thoại

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->phone ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- WEBSITE --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Website

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->website ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- COMPANY SIZE --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Quy mô công ty

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->company_size ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- FOUNDED YEAR --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Năm thành lập

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->founded_year ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Địa chỉ

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->address ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- FACEBOOK --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    Facebook

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->facebook ?? '---' }}

                                </div>

                            </div>

                        </div>

                        {{-- LINKEDIN --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="text-muted small mb-2">

                                    LinkedIn

                                </div>

                                <div class="fw-semibold">

                                    {{ $employer->linkedin ?? '---' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h4 class="fw-bold mb-0">

                        Giới thiệu công ty

                    </h4>

                </div>

                <div class="card-body pt-0 px-4 pb-4">

                    <div class="border rounded-4 p-4 bg-light">

                        {!! nl2br(e($employer->description)) !!}

                    </div>

                </div>

            </div>

            {{-- JOB LIST --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <h4 class="fw-bold mb-0">

                            Danh sách tin tuyển dụng

                        </h4>

                        <span class="badge bg-primary rounded-pill px-3 py-2">

                            {{ $employer->jobs->count() }} jobs

                        </span>

                    </div>

                </div>

                <div class="card-body pt-0 px-4 pb-4">

                    @forelse($employer->jobs as $job)

                        <div class="border rounded-4 p-4 mb-3">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                <div>

                                    <h5 class="fw-bold mb-2">

                                        {{ $job->title }}

                                    </h5>

                                    <div class="d-flex flex-wrap gap-2">

                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            {{ $job->category->name ?? '---' }}

                                        </span>

                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            {{ $job->location->name ?? '---' }}

                                        </span>

                                    </div>

                                </div>

                                <div class="text-end">

                                    <div class="fw-bold text-primary mb-1">

                                        {{ number_format($job->salary_min) }}
                                        -
                                        {{ number_format($job->salary_max) }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $job->applications->count() }}
                                        ứng tuyển

                                    </small>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5">

                            <i class="fa fa-briefcase text-secondary mb-3"
                               style="font-size:60px;"></i>

                            <h5 class="fw-bold">

                                Chưa có tin tuyển dụng

                            </h5>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection