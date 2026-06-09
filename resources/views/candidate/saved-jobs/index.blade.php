@extends('layouts.app')

@section('title', 'Việc làm đã lưu')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h2 class="fw-bold mb-2">

                    Việc làm đã lưu

                </h2>

                <p class="text-muted mb-0">

                    Danh sách công việc bạn đã bookmark

                </p>

            </div>

            <a href="/jobs"
               class="btn btn-primary rounded-3 px-4">

                <i class="fa fa-search me-2"></i>

                Tìm việc mới

            </a>

        </div>

    </div>


    {{-- LIST --}}
    @forelse($savedJobs as $saved)

        @php
            $job = $saved->job;
        @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-4 job-card">

            <div class="card-body p-4">

                <div class="row align-items-center">

                    {{-- LEFT --}}
                    <div class="col-lg-8">

                        <div class="d-flex gap-3">

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

                                {{-- TITLE --}}
                                <h4 class="fw-bold mb-2">

                                    <a href="/jobs/{{ $job->slug }}"
                                       class="text-dark text-decoration-none">

                                        {{ $job->title }}

                                    </a>

                                </h4>

                                {{-- COMPANY --}}
                                <div class="text-primary fw-semibold mb-3">

                                    {{ $job->employer->company_name }}

                                </div>

                                {{-- INFO --}}
                                <div class="d-flex flex-wrap gap-2 mb-3">

                                    {{-- SALARY --}}
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                        <i class="fa fa-money-bill-wave text-success me-1"></i>

                                        {{ number_format($job->salary_min) }}
                                        -
                                        {{ number_format($job->salary_max) }}
                                        VNĐ

                                    </span>

                                    {{-- LOCATION --}}
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                        <i class="fa fa-location-dot text-danger me-1"></i>

                                        {{ $job->location->name ?? 'Đang cập nhật' }}

                                    </span>

                                    {{-- TYPE --}}
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                        <i class="fa fa-briefcase text-primary me-1"></i>

                                        {{ $job->jobType->name ?? 'Fulltime' }}

                                    </span>

                                </div>

                                {{-- DATE --}}
                                <small class="text-muted">

                                    Đã lưu:
                                    {{ $saved->created_at
                                        ? $saved->created_at->diffForHumans()
                                        : 'Gần đây'
                                    }}

                                </small>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-lg-4">

                        <div class="d-flex flex-column gap-3">

                            {{-- APPLY --}}
                            <a href="/jobs/{{ $job->slug }}"
                               class="btn btn-primary rounded-3">

                                <i class="fa fa-paper-plane me-2"></i>

                                Ứng tuyển ngay

                            </a>

                            {{-- DETAIL --}}
                            <a href="/jobs/{{ $job->slug }}"
                               class="btn btn-outline-dark rounded-3">

                                <i class="fa fa-eye me-2"></i>

                                Xem chi tiết

                            </a>

                            {{-- REMOVE --}}
                            <form method="POST"
                                  action="/jobs/{{ $job->id }}/unsave">

                                @csrf

                                <button class="btn btn-outline-danger rounded-3 w-100">

                                    <i class="fa fa-heart-crack me-2"></i>

                                    Bỏ lưu việc làm

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @empty

        {{-- EMPTY --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <i class="fa fa-heart text-danger mb-3"
                   style="font-size:70px;"></i>

                <h3 class="fw-bold mb-3">

                    Chưa có việc làm đã lưu

                </h3>

                <p class="text-muted mb-4">

                    Lưu việc làm để xem lại nhanh hơn

                </p>

                <a href="/jobs"
                   class="btn btn-primary rounded-3 px-4">

                    Khám phá việc làm

                </a>

            </div>

        </div>

    @endforelse


    {{-- PAGINATION --}}
    <div class="mt-4">

        {{ $savedJobs->links() }}

    </div>

</div>


<style>

.job-card{
    transition: 0.3s;
}

.job-card:hover{
    transform: translateY(-4px);
}

</style>

@endsection