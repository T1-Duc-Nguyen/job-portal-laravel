@extends('layouts.employer')

@section('title', $job->title)

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div>

                    <div class="d-flex align-items-center gap-3 mb-3">

                        {{-- LOGO --}}
                        <img
                            src="{{ $job->employer->logo
                                ? asset($job->employer->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($job->employer->company_name)
                            }}"
                            width="90"
                            height="90"
                            class="rounded-4 border object-fit-cover">

                        <div>

                            <h2 class="fw-bold mb-2">

                                {{ $job->title }}

                            </h2>

                            <div class="text-primary fw-semibold fs-5">

                                {{ $job->employer->company_name }}

                            </div>

                        </div>

                    </div>

                    {{-- BADGES --}}
                    <div class="d-flex flex-wrap gap-2">

                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                            <i class="fa fa-location-dot text-danger me-1"></i>

                            {{ $job->location->name ?? 'Đang cập nhật' }}

                        </span>

                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                            <i class="fa fa-briefcase text-primary me-1"></i>

                            {{ $job->jobType->name ?? 'Fulltime' }}

                        </span>

                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                            <i class="fa fa-layer-group text-success me-1"></i>

                            {{ $job->category->name ?? 'Danh mục' }}

                        </span>

                    </div>

                </div>

                {{-- STATUS --}}
                <div>

                    @if($job->status == 0)

                        <span class="badge bg-warning fs-6 px-4 py-3 rounded-pill">

                            Chờ duyệt

                        </span>

                    @elseif($job->status == 1)

                        <span class="badge bg-success fs-6 px-4 py-3 rounded-pill">

                            Đã duyệt

                        </span>

                    @else

    <div class="text-end">

        {{-- STATUS --}}
        <span class="badge bg-danger fs-6 px-4 py-3 rounded-pill shadow-sm">

            <i class="fa fa-circle-xmark me-2"></i>

            Bị từ chối

        </span>

        {{-- REASON --}}
        @if($job->reject_reason)

            <div class="mt-3 reject-box">

                <div class="reject-title">

                    <i class="fa fa-triangle-exclamation me-2"></i>

                    Lý do từ chối

                </div>

                <div class="reject-content">

                    {{ $job->reject_reason }}

                </div>

            </div>

        @endif

    </div>

@endif

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- DESCRIPTION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        Mô tả công việc

                    </h4>

                    <div style="line-height: 1.9">

                        {!! nl2br(e($job->description)) !!}

                    </div>

                </div>

            </div>

            {{-- REQUIREMENTS --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        Yêu cầu ứng viên

                    </h4>

                    <div style="line-height: 1.9">

                        {!! nl2br(e($job->requirements)) !!}

                    </div>

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

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        Thông tin tuyển dụng

                    </h4>

                    {{-- SALARY --}}
                    <div class="mb-4">

                        <div class="text-muted small mb-1">

                            Mức lương

                        </div>

                        <div class="fw-bold text-success fs-4">

                            {{ number_format($job->salary_min) }}
                            -
                            {{ number_format($job->salary_max) }}
                            VNĐ

                        </div>

                    </div>

                    {{-- CREATED --}}
                    <div class="mb-4">

                        <div class="text-muted small mb-1">

                            Ngày đăng

                        </div>

                        <div class="fw-semibold">

                            {{ $job->created_at->format('d/m/Y') }}

                        </div>

                    </div>

                    {{-- EXPIRED --}}
                    <div class="mb-4">

                        <div class="text-muted small mb-1">

                            Hạn tuyển dụng

                        </div>

                        <div class="fw-semibold">

                            {{ $job->expired_at
                                ? \Carbon\Carbon::parse($job->expired_at)->format('d/m/Y')
                                : 'Không giới hạn'
                            }}

                        </div>

                    </div>

                    <hr>

                    {{-- ACTION --}}
                    <div class="d-grid gap-2">

                        <a href="/employer/jobs/{{ $job->id }}/edit"
                           class="btn btn-warning rounded-3">

                            <i class="fa fa-pen me-2"></i>

                            Chỉnh sửa

                        </a>

                        <a href="/employer/jobs/{{ $job->id }}/applications"
                           class="btn btn-primary rounded-3">

                            <i class="fa fa-users me-2"></i>

                            Xem ứng viên

                        </a>

                        <a href="/employer/jobs"
                           class="btn btn-light border rounded-3">

                            <i class="fa fa-arrow-left me-2"></i>

                            Quay lại

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<style>

.reject-box{

    background: linear-gradient(
        135deg,
        #fff1f2,
        #ffe4e6
    );

    border:1px solid #fecdd3;

    border-radius:18px;

    padding:16px;

    max-width:320px;

    box-shadow:
        0 4px 14px rgba(239,68,68,0.08);

}

.reject-title{

    font-size:14px;

    font-weight:700;

    color:#dc2626;

    margin-bottom:8px;

}

.reject-content{

    color:#7f1d1d;

    line-height:1.7;

    font-size:14px;

}

</style>
@endsection