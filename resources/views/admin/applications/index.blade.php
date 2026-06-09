@extends('layouts.admin')

@section('title', 'Quản lý đơn ứng tuyển')

@section('content')
    @php

        $totalApplications = \App\Models\Application::count();

        $applyApplications = \App\Models\Application::where('status', 0)->count();

        $approvedApplications = \App\Models\Application::where('status', 2)->count();

        $rejectedApplications = \App\Models\Application::where('status', 3)->count();

    @endphp

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h2 class="fw-bold mb-2">

                            Tất cả đơn ứng tuyển

                        </h2>

                        <p class="text-muted mb-0">

                            Admin chỉ được xem trạng thái ứng tuyển

                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- STATS --}}
        <div class="row g-4 mb-4">

            {{-- TOTAL --}}
            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted mb-2">

                                    Tổng đơn

                                </div>

                                <h2 class="fw-bold mb-0">

                                    {{ $totalApplications }}

                                </h2>

                            </div>

                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;">

                                <i class="fa fa-file-lines text-primary" style="font-size:28px;"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- APPLY --}}
            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted mb-2">

                                    Chưa xử lý

                                </div>

                                <h2 class="fw-bold text-warning mb-0">

                                    {{ $applyApplications }}

                                </h2>

                            </div>

                            <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;">

                                <i class="fa fa-paper-plane text-warning" style="font-size:28px;"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- APPROVED --}}
            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted mb-2">

                                    Đã duyệt

                                </div>

                                <h2 class="fw-bold text-success mb-0">

                                    {{ $approvedApplications }}

                                </h2>

                            </div>

                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;">

                                <i class="fa fa-circle-check text-success" style="font-size:28px;"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- REJECT --}}
            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted mb-2">

                                    Từ chối

                                </div>

                                <h2 class="fw-bold text-danger mb-0">

                                    {{ $rejectedApplications }}

                                </h2>

                            </div>

                            <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;">

                                <i class="fa fa-circle-xmark text-danger" style="font-size:28px;"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- FILTER --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        {{-- SEARCH --}}
                        <div class="col-md-5">

                            <input type="text" name="keyword" value="{{ request('keyword') }}"
                                class="form-control rounded-3" placeholder="Tìm ứng viên...">

                        </div>

                        {{-- STATUS --}}
                        <div class="col-md-4">

                            <select name="status" class="form-select rounded-3">

                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>

                                    Đã apply

                                </option>

                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>

                                    Đang xem xét

                                </option>

                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>

                                    Đã duyệt

                                </option>

                                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>

                                    Từ chối

                                </option>

                            </select>

                        </div>

                        {{-- BUTTON --}}
                        <div class="col-md-3">

                            <button class="btn btn-primary w-100 rounded-3">

                                <i class="fa fa-search me-2"></i>

                                Lọc dữ liệu

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- LIST --}}
        @forelse($applications as $application)
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="row align-items-center">

                        {{-- LEFT --}}
                        <div class="col-lg-7">

                            <div class="d-flex gap-3">

                                {{-- AVATAR --}}
                                <img src="{{ $application->candidate->avatar
                                    ? asset($application->candidate->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($application->candidate->full_name) }}"
                                    width="80" height="80" class="rounded-circle border object-fit-cover">

                                <div>

                                    {{-- NAME --}}
                                    <h4 class="fw-bold mb-2">

                                        {{ $application->candidate->full_name }}

                                    </h4>

                                    {{-- POSITION --}}
                                    <div class="text-muted mb-2">

                                        {{ $application->candidate->desired_position }}

                                    </div>

                                    {{-- JOB --}}
                                    <div class="mb-2">

                                        <span class="badge bg-primary-subtle text-primary border px-3 py-2 rounded-pill">

                                            <i class="fa fa-briefcase me-2"></i>

                                            {{ $application->job->title }}

                                        </span>

                                    </div>

                                    {{-- COMPANY --}}
                                    <div class="small text-muted mb-2">

                                        <i class="fa fa-building me-2"></i>

                                        {{ $application->job->employer->company_name }}

                                    </div>

                                    {{-- INFO --}}
                                    <div class="d-flex flex-wrap gap-2">

                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            <i class="fa fa-phone me-1"></i>

                                            {{ $application->candidate->phone }}

                                        </span>

                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            <i class="fa fa-location-dot me-1"></i>

                                            {{ $application->candidate->address }}

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="col-lg-5">

                            <div class="d-flex flex-column gap-2">

                                {{-- STATUS --}}
                                @if ($application->status == 0)
                                    <div class="alert alert-warning rounded-4 mb-0">

                                        <i class="fa fa-paper-plane me-2"></i>

                                        Đã ứng tuyển

                                    </div>
                                @elseif($application->status == 1)
                                    <div class="alert alert-info rounded-4 mb-0">

                                        <i class="fa fa-eye me-2"></i>

                                        Đang xem xét

                                    </div>
                                @elseif($application->status == 2)
                                    <div class="alert alert-success rounded-4 mb-0">

                                        <i class="fa fa-check-circle me-2"></i>

                                        Đã duyệt

                                    </div>
                                @else
                                    <div class="alert alert-danger rounded-4 mb-0" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Lý do từ chối : {{ $application->reject_reason }}">

                                        <i class="fa fa-xmark-circle me-2"></i>

                                        Hồ sơ bị từ chối

                                    </div>
                                @endif

                                {{-- VIEW CV --}}
                                @if ($application->cv)
                                    <a href="{{ asset('storage/' . $application->cv->file_path) }}" target="_blank"
                                        class="btn btn-outline-primary rounded-3">

                                        <i class="fa fa-file-pdf me-2"></i>

                                        Xem CV ứng viên

                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary rounded-3" disabled>

                                        <i class="fa fa-file-circle-xmark me-2"></i>

                                        Không có CV

                                    </button>
                                @endif

                                {{-- VIEW JOB --}}
                                <a href="/jobs/{{ $application->job->slug }}" target="_blank"
                                    class="btn btn-primary rounded-3">

                                    <i class="fa fa-eye me-2"></i>

                                    Xem tin tuyển dụng

                                </a>

                                {{-- APPLY DATE --}}
                                <div class="small text-muted mt-2">

                                    <i class="fa fa-clock me-2"></i>

                                    Ứng tuyển lúc:
                                    {{ $application->created_at->format('d/m/Y H:i') }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="fa fa-folder-open text-secondary mb-3" style="font-size:60px;"></i>

                    <h4 class="fw-bold">

                        Không có đơn ứng tuyển nào

                    </h4>

                </div>

            </div>
        @endforelse

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 gap-3">

            <div class="text-muted small">

                Hiển thị
                <strong>{{ $applications->firstItem() }}</strong>
                -
                <strong>{{ $applications->lastItem() }}</strong>

                trong tổng số
                <strong>{{ $applications->total() }}</strong>
                đơn ứng tuyển

            </div>

            <div>

                {{ $applications->onEachSide(1)->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

    {{-- TOOLTIP --}}
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const tooltipTriggerList = [].slice.call(
                    document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'
                    )
                );

                tooltipTriggerList.map(function(tooltipTriggerEl) {

                    return new bootstrap.Tooltip(
                        tooltipTriggerEl
                    );

                });

            }
        );
    </script>

@endsection
