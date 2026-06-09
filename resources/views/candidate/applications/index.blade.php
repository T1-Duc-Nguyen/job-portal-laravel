@extends('layouts.app')

@section('title', 'Việc làm đã ứng tuyển')

@section('content')

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="mb-4">

            <h2 class="fw-bold mb-2">

                Việc làm đã ứng tuyển

            </h2>

            <p class="text-muted">

                Theo dõi trạng thái ứng tuyển của bạn

            </p>

        </div>

        {{-- LIST --}}
        @forelse($applications as $application)
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="row align-items-center">

                        {{-- LEFT --}}
                        <div class="col-lg-8">

                            <div class="d-flex gap-3">

                                {{-- LOGO --}}
                                <img src="{{ $application->job->employer->logo
                                    ? asset($application->job->employer->logo)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($application->job->employer->company_name) }}"
                                    width="80" height="80" class="rounded-4 border object-fit-cover">

                                <div>

                                    {{-- JOB TITLE --}}
                                    <h4 class="fw-bold mb-2">

                                        {{ $application->job->title }}

                                    </h4>

                                    {{-- COMPANY --}}
                                    <div class="text-primary fw-semibold mb-2">

                                        {{ $application->job->employer->company_name }}

                                    </div>

                                    {{-- INFO --}}
                                    <div class="d-flex flex-wrap gap-2 mb-3">

                                        {{-- LOCATION --}}
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            <i class="fa fa-location-dot me-1 text-danger"></i>

                                            {{ $application->job->location->name ?? 'Đang cập nhật' }}

                                        </span>

                                        {{-- JOB TYPE --}}
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            <i class="fa fa-briefcase me-1 text-primary"></i>

                                            {{ $application->job->jobType->name ?? 'Fulltime' }}

                                        </span>

                                        {{-- SALARY --}}
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            <i class="fa fa-money-bill-wave me-1 text-success"></i>

                                            {{ number_format($application->job->salary_min) }}
                                            -
                                            {{ number_format($application->job->salary_max) }}
                                            VNĐ

                                        </span>

                                    </div>

                                    {{-- APPLY DATE --}}
                                    <small class="text-muted">

                                        Ứng tuyển:
                                        {{ $application->created_at->format('d/m/Y H:i') }}

                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="col-lg-4">

                            <div class="d-flex flex-column gap-3">

                                {{-- STATUS --}}
                                @if ($application->status == 0)
                                    <div class="alert alert-warning rounded-4 mb-0">

                                        <i class="fa fa-paper-plane me-2"></i>

                                        Đã ứng tuyển

                                    </div>
                                @elseif($application->status == 1)
                                    <div class="alert alert-info rounded-4 mb-0">

                                        <i class="fa fa-eye me-2"></i>

                                        Nhà tuyển dụng đang xem xét

                                    </div>
                                @elseif($application->status == 2)
                                    <div class="alert alert-success rounded-4 mb-0">

                                        <i class="fa fa-circle-check me-2"></i>

                                        Hồ sơ đã được chấp nhận

                                    </div>
                                @else
                                    {{-- REJECT STATUS --}}
                                    <button type="button"
                                        class="alert alert-danger rounded-4 mb-0 border-0 text-start w-100"
                                        data-bs-toggle="modal" data-bs-target="#rejectReasonModal{{ $application->id }}">

                                        <i class="fa fa-circle-xmark me-2"></i>

                                        Hồ sơ bị từ chối

                                        <div class="small mt-2 text-dark">

                                            Bấm để xem lý do

                                        </div>

                                    </button>
                                @endif

                                {{-- CV --}}
                                @if ($application->cv)
                                    <a href="/storage/{{ $application->cv->file_path }}" target="_blank"
                                        class="btn btn-outline-primary rounded-3">

                                        <i class="fa fa-file-pdf me-2"></i>

                                        Xem CV đã gửi

                                    </a>
                                @else
                                    <div class="border rounded-4 p-3 bg-light">

                                        <div class="text-danger fw-semibold mb-3">

                                            <i class="fa fa-triangle-exclamation me-2"></i>

                                            CV đã bị xóa, vui lòng upload lại

                                        </div>

                                        <form action="/candidate/application/{{ $application->id }}/reupload-cv"
                                            method="POST" enctype="multipart/form-data">

                                            @csrf

                                            <input type="file" name="cv" class="form-control mb-3" required>

                                            <button class="btn btn-primary w-100 rounded-3">

                                                <i class="fa fa-upload me-2"></i>

                                                Upload lại CV

                                            </button>

                                        </form>

                                    </div>
                                @endif

                                {{-- JOB DETAIL --}}
                                <a href="/jobs/{{ $application->job->slug }}" class="btn btn-primary rounded-3">

                                    <i class="fa fa-eye me-2"></i>

                                    Xem tin tuyển dụng

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- REJECT REASON MODAL --}}
            @if ($application->status == 3)
                <div class="modal fade" id="rejectReasonModal{{ $application->id }}" tabindex="-1">

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content border-0 rounded-4">

                            <div class="modal-header border-0 pb-0">

                                <h5 class="modal-title fw-bold text-danger">

                                    <i class="fa fa-circle-xmark me-2"></i>

                                    Lý do từ chối

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                            </div>

                            <div class="modal-body pt-3">

                                <div class="bg-light rounded-4 p-4">

                                    {{ $application->reject_reason ?? 'Nhà tuyển dụng chưa nhập lý do từ chối.' }}

                                </div>

                            </div>

                            <div class="modal-footer border-0">

                                <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">

                                    Đóng

                                </button>

                            </div>

                        </div>

                    </div>

                </div>
            @endif

        @empty

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="fa fa-briefcase text-secondary mb-3" style="font-size:70px;"></i>

                    <h4 class="fw-bold mb-3">

                        Bạn chưa ứng tuyển công việc nào

                    </h4>

                    <p class="text-muted mb-4">

                        Hãy khám phá hàng ngàn việc làm hấp dẫn

                    </p>

                    <a href="/jobs" class="btn btn-primary rounded-3 px-4">

                        Tìm việc ngay

                    </a>

                </div>

            </div>
        @endforelse

        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $applications->links() }}

        </div>

    </div>

@endsection
