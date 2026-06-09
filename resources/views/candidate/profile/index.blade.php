@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row g-4">

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden profile-sidebar sticky-top">

                {{-- COVER --}}
                <div class="profile-cover"></div>

                <div class="card-body text-center mt-n5">

                    {{-- AVATAR --}}
                    <img
                        src="{{ $candidate->avatar
                            ? asset($candidate->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->full_name)
                        }}"
                        width="130"
                        height="130"
                        class="rounded-circle border border-4 border-white shadow profile-avatar">

                    <h3 class="fw-bold mt-3 mb-1">

                        {{ $candidate->full_name ?: 'Chưa cập nhật' }}

                    </h3>

                    <p class="text-muted mb-2">

                        {{ $candidate->desired_position ?: 'Chưa cập nhật vị trí' }}

                    </p>

                    <span class="badge bg-success px-3 py-2 rounded-pill">

                        {{ $candidate->status ?: 'Open To Work' }}

                    </span>

                    <div class="d-grid mt-4">

                        <a href="/candidate/profile/edit"
                           class="btn btn-primary rounded-3">

                            <i class="fa fa-pen me-2"></i>

                            Cập nhật hồ sơ

                        </a>

                    </div>

                    <hr>

                    {{-- INFO --}}
                    <div class="text-start small profile-info">

                        <p class="mb-3">

                            <i class="fa fa-phone text-primary me-2"></i>

                            {{ $candidate->phone ?: 'Chưa cập nhật' }}

                        </p>

                        <p class="mb-3">

                            <i class="fa fa-location-dot text-danger me-2"></i>

                            {{ $candidate->address ?: 'Chưa cập nhật' }}

                        </p>

                        <p class="mb-3">

                            <i class="fa fa-calendar text-success me-2"></i>

                            {{ $candidate->birthday ?: 'Chưa cập nhật' }}

                        </p>

                        <p class="mb-0">

                            <i class="fa fa-venus-mars text-warning me-2"></i>

                            {{ $candidate->gender ?: 'Chưa cập nhật' }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="col-lg-8">

            {{-- STATS --}}
            <div class="row g-3 mb-4">

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm rounded-4 stat-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <p class="text-muted mb-1">

                                        Ứng tuyển

                                    </p>

                                    <h2 class="fw-bold mb-0">

                                        {{ $applications }}

                                    </h2>

                                </div>

                                <div class="stat-icon bg-warning-subtle text-warning">

                                    <i class="fa fa-file-lines"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm rounded-4 stat-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <p class="text-muted mb-1">

                                        Việc đã lưu

                                    </p>

                                    <h2 class="fw-bold mb-0">

                                        {{ $savedJobs }}

                                    </h2>

                                </div>

                                <div class="stat-icon bg-danger-subtle text-danger">

                                    <i class="fa fa-heart"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm rounded-4 stat-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <p class="text-muted mb-1">

                                        CV Upload

                                    </p>

                                    <h2 class="fw-bold mb-0">

                                        {{ $cvCount }}

                                    </h2>

                                </div>

                                <div class="stat-icon bg-success-subtle text-success">

                                    <i class="fa fa-file-pdf"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ABOUT --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 section-card">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        <i class="fa fa-user text-primary me-2"></i>

                        Giới thiệu

                    </h4>

                    <div class="section-content">

                        {{ $candidate->description ?: 'Chưa cập nhật giới thiệu bản thân.' }}

                    </div>

                </div>

            </div>

            {{-- SKILLS --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 section-card">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        <i class="fa fa-code text-success me-2"></i>

                        Kỹ năng

                    </h4>

                    @if($candidate->skills)

                        @foreach(explode(',', $candidate->skills) as $skill)

                            <span class="badge skill-badge">

                                {{ trim($skill) }}

                            </span>

                        @endforeach

                    @else

                        <p class="text-muted">

                            Chưa cập nhật kỹ năng

                        </p>

                    @endif

                </div>

            </div>

            {{-- EXPERIENCE --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 section-card">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        <i class="fa fa-briefcase text-warning me-2"></i>

                        Kinh nghiệm

                    </h4>

                    @if(count($experience))

                        @foreach($experience as $exp)

                            <div class="timeline-card">

                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                                    <div>

                                        <h5 class="fw-bold mb-1">

                                            {{ $exp['position'] ?? '' }}

                                        </h5>

                                        <div class="text-primary fw-semibold">

                                            {{ $exp['company'] ?? '' }}

                                        </div>

                                    </div>

                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">

                                        {{ $exp['time'] ?? '' }}

                                    </span>

                                </div>

                                <div class="mt-3 section-content">

                                    {{ $exp['description'] ?? '' }}

                                </div>

                            </div>

                        @endforeach

                    @else

                        <p class="text-muted">

                            Chưa cập nhật kinh nghiệm.

                        </p>

                    @endif

                </div>

            </div>

            {{-- EDUCATION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 section-card">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4">

                        <i class="fa fa-graduation-cap text-danger me-2"></i>

                        Học vấn

                    </h4>

                    @if(count($education))

                        @foreach($education as $edu)

                            <div class="timeline-card">

                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                                    <div>

                                        <h5 class="fw-bold mb-1">

                                            {{ $edu['school'] ?? '' }}

                                        </h5>

                                        <div class="text-primary fw-semibold">

                                            {{ $edu['major'] ?? '' }}

                                        </div>

                                    </div>

                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">

                                        {{ $edu['time'] ?? '' }}

                                    </span>

                                </div>

                            </div>

                        @endforeach

                    @else

                        <p class="text-muted">

                            Chưa cập nhật học vấn.

                        </p>

                    @endif

                </div>

            </div>

            {{-- CV LIST --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- HEADER --}}
                <div class="cv-header">

                    <div>

                        <h4 class="fw-bold mb-1 text-white">

                            <i class="fa fa-file-pdf me-2"></i>

                            Danh sách CV

                        </h4>

                        <p class="text-white-50 mb-0">

                            Quản lý CV đã upload của bạn

                        </p>

                    </div>

                    {{-- UPLOAD --}}
                    <form action="/candidate/cv/upload-normal"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <input type="file"
                               name="cv"
                               id="cvInput"
                               accept=".pdf"
                               hidden
                               onchange="this.form.submit()">

                        <button type="button"
                                onclick="document.getElementById('cvInput').click()"
                                class="btn btn-light rounded-3 fw-semibold px-4">

                            <i class="fa fa-upload me-2"></i>

                            Upload CV

                        </button>

                    </form>

                </div>

                <div class="card-body p-4">

                    @if($candidate->cvs->count() > 0)

                        <div class="row">

                            @foreach($candidate->cvs as $cv)

                                <div class="col-lg-6 mb-4">

                                    <div class="cv-card">

                                        <div class="d-flex align-items-center gap-3 mb-3">

                                            <div class="cv-file-icon">

                                                <i class="fa fa-file-pdf"></i>

                                            </div>

                                            <div class="flex-grow-1">

                                                <h6 class="fw-bold mb-1 text-truncate">

                                                    {{ \Illuminate\Support\Str::limit(basename($cv->file_path), 28) }}

                                                </h6>

                                                <small class="text-muted">

                                                    PDF Document

                                                </small>

                                            </div>

                                        </div>

                                        <div class="cv-date mb-3">

                                            <i class="fa fa-clock me-2 text-primary"></i>

                                            @if($cv->created_at)

                                                {{ \Carbon\Carbon::parse($cv->created_at)->format('d/m/Y H:i') }}

                                            @else

                                                Không xác định

                                            @endif

                                        </div>

                                        <div class="d-flex gap-2 flex-wrap">

                                            <a href="/storage/{{ $cv->file_path }}"
                                               target="_blank"
                                               class="btn btn-outline-primary rounded-3 flex-fill">

                                                <i class="fa fa-eye me-1"></i>

                                                Xem

                                            </a>

                                            <a href="/storage/{{ $cv->file_path }}"
                                               download
                                               class="btn btn-outline-success rounded-3 flex-fill">

                                                <i class="fa fa-download me-1"></i>

                                                Tải

                                            </a>

                                        </div>

                                        <form action="/candidate/cv/{{ $cv->id }}"
                                              method="POST"
                                              class="mt-2"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa CV này?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger rounded-3 w-100">

                                                <i class="fa fa-trash me-1"></i>

                                                Xóa CV

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty-cv-state">

                            <div class="empty-cv-icon mb-4">

                                <i class="fa fa-file-circle-xmark"></i>

                            </div>

                            <h4 class="fw-bold mb-2">

                                Chưa có CV nào

                            </h4>

                            <p class="text-muted mb-4">

                                Upload CV để bắt đầu ứng tuyển việc làm

                            </p>

                            <button type="button"
                                    onclick="document.getElementById('cvInput').click()"
                                    class="btn btn-primary rounded-3 px-4 py-2">

                                <i class="fa fa-upload me-2"></i>

                                Upload CV đầu tiên

                            </button>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

.profile-sidebar{

    top:90px;
    z-index:10;

}

.profile-cover{

    height:140px;
    background:linear-gradient(135deg,#0d6efd,#4dabff);

}

.profile-avatar{

    object-fit:cover;

}

.profile-info p{

    font-size:15px;

}

.stat-card{

    transition:0.3s;

}

.stat-card:hover{

    transform:translateY(-4px);

}

.stat-icon{

    width:60px;
    height:60px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;

}

.section-card{

    transition:0.3s;

}

.section-card:hover{

    transform:translateY(-2px);

}

.section-content{

    line-height:1.9;
    color:#475569;

}

.skill-badge{

    background:#f8fafc;
    color:#334155;
    border:1px solid #e2e8f0;
    padding:10px 16px;
    border-radius:999px;
    margin-right:10px;
    margin-bottom:10px;
    font-size:14px;

}

.timeline-card{

    border:1px solid #eef2f7;
    border-radius:20px;
    padding:24px;
    margin-bottom:20px;
    background:#fff;

}

.cv-header{

    background:linear-gradient(135deg,#0d6efd,#4dabff);
    padding:28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;

}

.cv-card{

    background:#fff;
    border:1px solid #eef2f7;
    border-radius:24px;
    padding:24px;
    height:100%;
    transition:0.3s;

}

.cv-card:hover{

    transform:translateY(-4px);
    box-shadow:0 10px 30px rgba(15,23,42,0.08);

}

.cv-file-icon{

    width:65px;
    height:65px;
    border-radius:18px;
    background:#fff1f2;
    color:#dc2626;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;

}

.cv-date{

    background:#f8fafc;
    border-radius:14px;
    padding:12px 14px;
    color:#64748b;
    font-size:14px;

}

.empty-cv-state{

    text-align:center;
    padding:60px 20px;

}

.empty-cv-icon{

    width:110px;
    height:110px;
    border-radius:50%;
    background:#f8fafc;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    font-size:55px;
    color:#cbd5e1;

}

@media(max-width:991px){

    .profile-sidebar{

        position:relative !important;
        top:0 !important;

    }

}

</style>

@endsection