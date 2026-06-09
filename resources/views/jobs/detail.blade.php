{{-- =========================
    JOB DETAIL - JOBSGO STYLE
========================= --}}
@extends('layouts.app')

@section('content')
<link rel="stylesheet"
      href="{{ asset('css/jobdetail.css') }}">
<div class="container py-4">

    <div class="row g-4">

        {{-- LEFT CONTENT --}}
        <div class="col-lg-8">

            {{-- JOB TOP CARD --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-body p-4">

                    {{-- TITLE --}}
                    <div class="mb-4">

                        <h1 class="job-title fw-bold mb-3">
                            {{ $job->title }}
                        </h1>

                        {{-- COMPANY --}}
                        <div class="d-flex align-items-center gap-3">

                            <div class="company-logo">

                                @if($job->employer->logo)

                                    <img src="{{ asset($job->employer->logo) }}"
                                         class="img-fluid">

                                @else

                                    <i class="fa fa-building"></i>

                                @endif

                            </div>

                            <div>

                                <h5 class="mb-1 fw-bold">
                                    <a href="{{ route('company.show', $job->employer->slug) }}"
                                class="text-decoration-none fw-semibold">

                                    {{ $job->employer->company_name }}

                                </a>
                                </h5>

                                <span class="text-muted small">
                                    {{ $job->category->name ?? 'Tuyển dụng' }}
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- INFO --}}
                    <div class="row g-3 mb-4">

                        {{-- SALARY --}}
                        <div class="col-md-6">

                            <div class="job-info-item">

                                <div class="job-icon bg-primary-subtle text-primary">
                                    <i class="fa fa-money"></i>
                                </div>

                                <div>

                                    <small>Mức lương</small>

                                    <h6>

                                        {{ number_format($job->salary_min) }}
                                        -
                                        {{ number_format($job->salary_max) }}
                                        {{ $job->currency }}

                                    </h6>

                                </div>

                            </div>

                        </div>

                        {{-- LOCATION --}}
                        <div class="col-md-6">

                            <div class="job-info-item">

                                <div class="job-icon bg-info-subtle text-info">
                                    <i class="fa fa-map-marker"></i>
                                </div>

                                <div>

                                    <small>Địa điểm</small>

                                    <h6>
                                        {{ $job->location->name ?? 'Đang cập nhật' }}
                                    </h6>

                                </div>

                            </div>

                        </div>

                        {{-- TYPE --}}
                        <div class="col-md-6">

                            <div class="job-info-item">

                                <div class="job-icon bg-success-subtle text-success">
                                    <i class="fa fa-briefcase"></i>
                                </div>

                                <div>

                                    <small>Hình thức</small>

                                    <h6>
                                        {{ $job->jobType->name ?? 'Fulltime' }}
                                    </h6>

                                </div>

                            </div>

                        </div>

                        {{-- DEADLINE --}}
                        <div class="col-md-6">

                            <div class="job-info-item">

                                <div class="job-icon bg-danger-subtle text-danger">
                                    <i class="fa fa-clock-o"></i>
                                </div>

                                <div>

                                    <small>Hạn nộp hồ sơ</small>

                                    <h6>

                                        {{ $job->expired_at
                                            ? \Carbon\Carbon::parse($job->expired_at)->format('d/m/Y')
                                            : 'Không giới hạn'
                                        }}

                                    </h6>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTONS --}}
                    <div class="d-grid gap-3">

                        {{-- ALERT --}}
                        @if(session('success'))

                            <div class="alert alert-success rounded-4 border-0">
                                {{ session('success') }}
                            </div>

                        @endif

                        @if(session('error'))

                            <div class="alert alert-danger rounded-4 border-0">
                                {{ session('error') }}
                            </div>

                        @endif


                        {{-- APPLY --}}
                        @auth

                            @if(auth()->user()->role == 1)

                                @php

                                    $candidate = \App\Models\Candidate::where(
                                        'user_id',
                                        auth()->id()
                                    )->first();

                                    $myCvs = [];

                                    if($candidate){

                                        $myCvs = \App\Models\CV::where(
                                            'candidate_id',
                                            $candidate->id
                                        )->latest()->get();

                                    }

                                    $applied = false;

                                    if($candidate){

                                        $applied = \App\Models\Application::where(
                                            'job_id',
                                            $job->id
                                        )
                                        ->where(
                                            'candidate_id',
                                            $candidate->id
                                        )
                                        ->exists();

                                    }

                                @endphp


                                @if($applied)

                                    <button class="btn btn-success apply-btn"
                                            disabled>

                                        <i class="fa fa-check-circle me-2"></i>

                                        Đã ứng tuyển

                                    </button>

                                @else

                                    <button class="btn btn-primary apply-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#applyModal">

                                        <i class="fa fa-paper-plane me-2"></i>

                                        Ứng tuyển ngay

                                    </button>

                                @endif

                            @endif

                        @endauth


                        {{-- ACTIONS --}}
                        <div class="row g-3">

                            {{-- BACK --}}
                            <div class="col-4">

                                <a href="{{ url()->previous() }}"
                                   class="btn btn-outline-primary w-100 action-btn">

                                    <i class="fa fa-arrow-left"></i>

                                </a>

                            </div>

                            {{-- SAVE --}}
                            <div class="col-4">

                                @auth

                                    @if(auth()->user()->role == 1)

                                        <form method="POST"
                                              action="/jobs/{{ $job->id }}/save">

                                            @csrf

                                            <button class="btn btn-outline-primary w-100 action-btn">

                                                <i class="fa fa-heart"></i>

                                            </button>

                                        </form>

                                    @endif

                                @endauth

                            </div>

                            {{-- SHARE --}}
                            {{-- SHARE --}}
                                <div class="col-4">

                                    <button
                                        class="btn btn-outline-primary w-100 action-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#shareModal">

                                        <i class="fa fa-share-alt"></i>

                                    </button>

                                </div>
                                {{-- SHARE MODAL --}}
<div class="modal fade"
     id="shareModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content share-modal border-0">

            <div class="modal-header border-0 pb-0">

                <h5 class="fw-bold mb-0">
                    Chia sẻ việc làm
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body pt-3">

                {{-- SOCIAL --}}
                <div class="share-grid">

                    {{-- FACEBOOK --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="share-item">

                        <div class="share-icon facebook">

                            <i class="fab fa-facebook-f"></i>

                        </div>

                        <span>Facebook</span>

                    </a>

                    {{-- ZALO --}}
                    <a href="https://zalo.me/share?url={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="share-item">

                        <div class="share-icon zalo">

                            <i class="fa fa-comment"></i>

                        </div>

                        <span>Zalo</span>

                    </a>

                    {{-- MESSENGER --}}
                    <a href="https://www.facebook.com/dialog/send?link={{ urlencode(url()->current()) }}&app_id=291494419107518&redirect_uri={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="share-item">

                        <div class="share-icon messenger">

                            <i class="fab fa-facebook-messenger"></i>

                        </div>

                        <span>Messenger</span>

                    </a>

                    {{-- WHATSAPP --}}
                    <a href="https://wa.me/?text={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="share-item">

                        <div class="share-icon whatsapp">

                            <i class="fab fa-whatsapp"></i>

                        </div>

                        <span>WhatsApp</span>

                    </a>

                    {{-- X --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="share-item">

                        <div class="share-icon twitter">

                            <i class="fab fa-x-twitter"></i>

                        </div>

                        <span>X</span>

                    </a>

                </div>

                {{-- LINK --}}
                <div class="share-link-box mt-4">

                    <input type="text"
                           id="shareLink"
                           value="{{ url()->current() }}"
                           readonly>

                    <button onclick="copyShareLink()">

                        Sao chép

                    </button>

                </div>

                {{-- SUCCESS --}}
                <div id="copySuccess"
                     class="text-success text-center mt-3 d-none fw-semibold">

                    Đã sao chép liên kết

                </div>

            </div>

        </div>

    </div>

</div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h3 class="section-title">
                        Chi tiết công việc
                    </h3>

                    {{-- DESCRIPTION --}}
                    <div class="mb-5">

                        <h5 class="fw-bold mb-3">
                            Mô tả công việc
                        </h5>

                        <div class="job-content">

                            {!! nl2br(e($job->description)) !!}

                        </div>

                    </div>

                    {{-- REQUIREMENTS --}}
                    <div>

                        <h5 class="fw-bold mb-3">
                            Yêu cầu ứng viên
                        </h5>

                        <div class="job-content">

                            {!! nl2br(e($job->requirements)) !!}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- COMPANY --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="text-center mb-3">

                        <div class="sidebar-logo mx-auto mb-3">

                            @if($job->employer->logo)

                                <img src="{{ asset($job->employer->logo) }}"
                                     class="img-fluid">

                            @else

                                <i class="fa fa-building"></i>

                            @endif

                        </div>

                        <h5 class="fw-bold">
                            <a href="{{ route('company.show', $job->employer->slug) }}"
                                class="text-decoration-none fw-semibold">

                                    {{ $job->employer->company_name }}

                                </a>
                        </h5>

                    </div>

                    <ul class="list-unstyled company-info">

                        <li>

                            <i class="fa fa-industry"></i>

                            {{ $job->employer->industry ?? 'Doanh nghiệp' }}

                        </li>

                        <li>

                            <i class="fa fa-map-marker"></i>

                            {{ $job->employer->address ?? 'Đang cập nhật' }}

                        </li>

                        <li>

                            <i class="fa fa-globe"></i>

                            {{ $job->employer->website ?? 'Không có website' }}

                        </li>

                    </ul>

                </div>
               @auth

                    @if(auth()->user()->role == 1)

                        <a href="/chat/{{ $job->employer->user_id }}"
                        class="btn btn-primary rounded-4 px-4 py-2 fw-semibold">

                            <i class="fa fa-comments me-2"></i>

                            Chat với nhà tuyển dụng

                        </a>

                    @endif

                @endauth

            </div>

            {{-- SKILLS --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Kỹ năng yêu cầu
                    </h5>

                    <div class="d-flex flex-wrap gap-2">

                        @forelse($job->skills as $skill)

                            <span class="skill-badge">
                                {{ $skill->name }}
                            </span>

                        @empty

                            <span class="text-muted">
                                Chưa cập nhật
                            </span>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- APPLY MODAL --}}
<div class="modal fade"
     id="applyModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">

                <h5 class="fw-bold mb-0">
                    Chọn CV để ứng tuyển
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                @if(isset($myCvs) && count($myCvs) > 0)

                    <form method="POST"
                          action="/jobs/{{ $job->id }}/apply">

                        @csrf

                        <div class="mb-4">

                            @foreach($myCvs as $cv)

                                <label class="cv-item">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <input type="radio"
                                                   name="cv_id"
                                                   value="{{ $cv->id }}"
                                                   required>

                                            <span class="ms-2 fw-semibold">

                                                {{ basename($cv->file_path) }}

                                            </span>

                                        </div>

                                        <a href="/storage/{{ $cv->file_path }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary rounded-3">

                                            Xem CV

                                        </a>

                                    </div>

                                </label>

                            @endforeach

                        </div>

                        <button class="btn btn-primary w-100 rounded-4 py-3 fw-bold">

                            <i class="fa fa-paper-plane me-2"></i>

                            Xác nhận ứng tuyển

                        </button>

                    </form>

                @else

                    <div class="text-center py-4">

                        <i class="fa fa-file-pdf text-danger mb-3"
                           style="font-size:60px;"></i>

                        <h5 class="fw-bold">
                            Bạn chưa upload CV
                        </h5>

                        <p class="text-muted">
                            Hãy upload CV trước khi ứng tuyển
                        </p>

                        <a href="/candidate/profile/edit"
                           class="btn btn-primary rounded-4">

                            Upload CV

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
<script>

function copyShareLink(){

    let copyText = document.getElementById("shareLink");

    copyText.select();

    copyText.setSelectionRange(0, 99999);

    navigator.clipboard.writeText(copyText.value);

    document
        .getElementById('copySuccess')
        .classList
        .remove('d-none');

    setTimeout(() => {

        document
            .getElementById('copySuccess')
            .classList
            .add('d-none');

    }, 2000);
}

</script>
@endsection