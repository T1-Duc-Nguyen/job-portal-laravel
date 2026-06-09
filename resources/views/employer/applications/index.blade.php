@extends('layouts.employer')

@section('title', 'Danh sách ứng viên')

@section('content')

    <div class="container py-4">

        ```
        {{-- HEADER --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h2 class="fw-bold mb-2">

                            Danh sách ứng viên

                        </h2>

                        <p class="text-muted mb-0">

                            Quản lý danh sách ứng viên đã apply

                        </p>

                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-3">

                        <i class="fa fa-arrow-left me-2"></i>

                        Quay lại

                    </a>

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

        {{-- APPLICATION LIST --}}
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

                                    <h4 class="fw-bold mb-2">

                                        {{ $application->candidate->full_name }}

                                    </h4>

                                    <p class="text-muted mb-2">

                                        {{ $application->candidate->desired_position }}

                                    </p>

                                    <div class="mb-2">

                                        <span class="badge bg-primary-subtle text-primary border px-3 py-2 rounded-pill">

                                            <i class="fa fa-briefcase me-2"></i>

                                            {{ $application->job->title }}

                                        </span>

                                    </div>

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
                                {{-- STATUS --}}
                                @if ($application->status == 0)
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">

                                        Đã ứng tuyển

                                    </span>
                                @elseif($application->status == 2)
                                    <span class="badge bg-success px-3 py-2 rounded-pill">

                                        Đã duyệt

                                    </span>
                                @elseif($application->status == 3)
                                    <span class="badge bg-danger px-3 py-2 rounded-pill" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="Lý do từ chối: {{ $application->reject_reason ?: 'Không có lý do' }}"
                                        style="cursor:pointer;">

                                        Đã từ chối

                                    </span>
                                @endif

                                {{-- CV --}}
                                @if ($application->cv)
                                    <a href="{{ asset('storage/' . $application->cv->file_path) }}" target="_blank"
                                        class="btn btn-outline-primary rounded-3">

                                        <i class="fa fa-file-pdf me-2"></i>

                                        Xem CV

                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary rounded-3" disabled>

                                        <i class="fa fa-file-circle-xmark me-2"></i>

                                        Không có CV

                                    </button>
                                @endif

                                {{-- ACTIONS --}}
                                <div class="d-flex gap-2">

                                    {{-- APPROVE --}}
                                    <form method="POST" action="/employer/applications/{{ $application->id }}/approve"
                                        class="w-50">

                                        @csrf

                                        <button class="btn btn-success w-100 rounded-3">

                                            <i class="fa fa-check me-2"></i>

                                            Duyệt

                                        </button>

                                    </form>

                                    {{-- REJECT --}}
                                    <div class="w-50">

                                        <button class="btn btn-danger w-100 rounded-3" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $application->id }}">

                                            <i class="fa fa-xmark me-2"></i>

                                            Từ chối

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- REJECT MODAL --}}
            <div class="modal fade" id="rejectModal{{ $application->id }}" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content rounded-4 border-0">

                        <form method="POST" action="/employer/applications/{{ $application->id }}/reject">

                            @csrf

                            <div class="modal-header">

                                <h5 class="modal-title fw-bold">

                                    Lý do từ chối

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                            </div>

                            <div class="modal-body">

                                <textarea name="reject_reason" class="form-control rounded-3" rows="5" placeholder="Nhập lý do từ chối..."
                                    required></textarea>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                                    Hủy

                                </button>

                                <button class="btn btn-danger rounded-3">

                                    Xác nhận từ chối

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="fa fa-users text-secondary mb-3" style="font-size:60px;"></i>

                    <h4 class="fw-bold">

                        Chưa có ứng viên

                    </h4>

                </div>

            </div>
        @endforelse

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">

            <div class="text-muted small">

                Hiển thị
                <strong>{{ $applications->firstItem() }}</strong>
                -
                <strong>{{ $applications->lastItem() }}</strong>

                trong tổng số
                <strong>{{ $applications->total() }}</strong>
                ứng viên

            </div>

            <div>

                {{ $applications->onEachSide(1)->links('pagination::bootstrap-5') }}

            </div>

        </div>
        ```

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

        });
    </script>

@endsection
