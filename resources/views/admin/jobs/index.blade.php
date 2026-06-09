@extends('layouts.admin')

@section('title', 'Quản lý Jobs')

@section('content')

<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Quản lý tin tuyển dụng

            </h2>

            <p class="text-muted mb-0">

                Quản lý, kiểm duyệt và theo dõi toàn bộ tin tuyển dụng trên hệ thống

            </p>

        </div>

        <div class="d-flex gap-2">

            <div class="dashboard-badge success">

                <i class="fa fa-circle-check me-2"></i>
                {{ $jobs->total() }} Jobs

            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Tổng Jobs

                    </p>

                    <h3 class="stats-number">

                        {{ \App\Models\Job::count() }}

                    </h3>

                </div>

                <div class="stats-icon primary">

                    <i class="fa fa-briefcase"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Chờ duyệt

                    </p>

                    <h3 class="stats-number text-warning">

                        {{ \App\Models\Job::where('status',0)->count() }}

                    </h3>

                </div>

                <div class="stats-icon warning">

                    <i class="fa fa-clock"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Đã duyệt

                    </p>

                    <h3 class="stats-number text-success">

                        {{ \App\Models\Job::where('status',1)->count() }}

                    </h3>

                </div>

                <div class="stats-icon success">

                    <i class="fa fa-circle-check"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Từ chối

                    </p>

                    <h3 class="stats-number text-danger">

                        {{ \App\Models\Job::where('status',2)->count() }}

                    </h3>

                </div>

                <div class="stats-icon danger">

                    <i class="fa fa-circle-xmark"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    {{-- FILTER --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body p-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- SEARCH --}}
                <div class="col-lg-5">

                    <label class="form-label fw-semibold mb-2">

                        Tìm kiếm jobs

                    </label>

                    <div class="modern-search">

                        <i class="fa fa-search"></i>

                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Tên công việc hoặc công ty..."
                               value="{{ request('keyword') }}">

                    </div>

                </div>

                {{-- STATUS --}}
                <div class="col-lg-3">

                    <label class="form-label fw-semibold mb-2">

                        Trạng thái

                    </label>

                    <select name="status"
                            class="form-select modern-select">

                        <option value="">
                            Tất cả trạng thái
                        </option>

                        <option value="0"
                            {{ request('status') == '0' ? 'selected' : '' }}>

                             Chờ duyệt

                        </option>

                        <option value="1"
                            {{ request('status') == '1' ? 'selected' : '' }}>

                             Đã duyệt

                        </option>

                        <option value="2"
                            {{ request('status') == '2' ? 'selected' : '' }}>

                             Từ chối

                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="col-lg-4">

                    <div class="d-flex gap-2">

                        <button class="btn btn-primary flex-fill filter-btn">

                            <i class="fa fa-filter me-2"></i>

                            Lọc dữ liệu

                        </button>

                        <a href="/admin/jobs"
                           class="btn btn-light reset-btn">

                            <i class="fa fa-rotate-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle custom-table mb-0">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Thông tin Job</th>
                            <th>Doanh nghiệp</th>
                            <th>Mức lương</th>
                            <th>Views</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng</th>
                            <th width="240">Thao tác</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($jobs as $job)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="fw-bold text-primary">

                                    #{{ $job->id }}

                                </span>

                            </td>

                            {{-- JOB --}}
                            <td>

                                <div class="d-flex align-items-start gap-3">

                                    <div class="job-logo">

                                        <i class="fa fa-briefcase"></i>

                                    </div>

                                    <div>

                                        <h6 class="fw-bold mb-1">

                                            {{ $job->title }}

                                        </h6>

                                        <div class="d-flex flex-wrap gap-2">

                                            <span class="table-badge">

                                                <i class="fa fa-layer-group me-1"></i>

                                                {{ $job->category->name ?? '---' }}

                                            </span>

                                            <span class="table-badge">

                                                <i class="fa fa-location-dot me-1"></i>

                                                {{ $job->location->name ?? '---' }}

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- COMPANY --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ $job->employer->company_name ?? '---' }}

                                </div>

                            </td>

                            {{-- SALARY --}}
                            <td>

                                <div class="fw-bold text-success">

                                    {{ number_format($job->salary_min) }}
                                    -
                                    {{ number_format($job->salary_max) }}

                                </div>

                                <small class="text-muted">

                                    {{ $job->currency }}

                                </small>

                            </td>

                            {{-- VIEWS --}}
                            <td>

                                <span class="views-box">

                                    <i class="fa fa-eye me-1"></i>

                                    {{ $job->views }}

                                </span>

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($job->status == 0)

                                    <span class="status-badge pending">

                                        <i class="fa fa-clock me-1"></i>

                                        Chờ duyệt

                                    </span>

                                @elseif($job->status == 1)

                                    <span class="status-badge approved">

                                        <i class="fa fa-circle-check me-1"></i>

                                        Đã duyệt

                                    </span>

                                @else

                                    
                                    <span class="status-badge rejected"
                                            data-bs-toggle="tooltip"
                                            title="{{ $job->reject_reason }}">

                                        <i class="fa fa-circle-xmark me-1"></i>

                                        Từ chối

                                    </span>

                                @endif

                            </td>

                            {{-- DATE --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ $job->created_at->format('d/m/Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ $job->created_at->diffForHumans() }}

                                </small>

                            </td>

                            {{-- ACTION --}}
                            <td>

                                <div class="d-flex gap-2 flex-wrap">

                                    <a href="/admin/jobs/{{ $job->id }}"
                                       class="action-btn info">

                                        <i class="fa fa-eye"></i>

                                    </a>

                                    <a href="/admin/jobs/{{ $job->id }}/approve"
                                       class="action-btn success">

                                        <i class="fa fa-check"></i>

                                    </a>

                                
                                    <button
                                        class="action-btn warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $job->id }}">

                                        <i class="fa fa-xmark"></i>

                                    </button>

                                    <form action="/admin/jobs/{{ $job->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn danger"
                                                onclick="return confirm('Xóa job này?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>
                        {{-- REJECT MODAL --}}
<div class="modal fade"
     id="rejectModal{{ $job->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content border-0 rounded-4">

            <form method="POST"
                  action="/admin/jobs/{{ $job->id }}/reject">

                @csrf

                <div class="modal-header border-0">

                    <h5 class="modal-title fw-bold">

                        Từ chối tin tuyển dụng

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Lý do từ chối

                        </label>

                        <textarea
                            name="reject_reason"
                            rows="5"
                            class="form-control rounded-4"
                            placeholder="Nhập lý do từ chối..."
                            required></textarea>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">

                        Hủy

                    </button>

                    <button class="btn btn-danger rounded-3">

                        <i class="fa fa-xmark me-2"></i>

                        Xác nhận từ chối

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <i class="fa fa-folder-open"></i>

                                    <h5>

                                        Không có dữ liệu jobs

                                    </h5>

                                </div>

                            </td>

                        </tr>
                        

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 gap-3">

        <div class="text-muted small">

            Hiển thị
            <strong>{{ $jobs->firstItem() }}</strong>
            -
            <strong>{{ $jobs->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $jobs->total() }}</strong>
            jobs

        </div>

        <div>

            {{ $jobs->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

.stats-card{

    background:#fff;
    border-radius:24px;
    padding:24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);

}

.stats-label{

    color:#6b7280;
    margin-bottom:8px;
    font-size:15px;

}

.stats-number{

    font-size:32px;
    font-weight:800;
    margin:0;

}

.stats-icon{

    width:70px;
    height:70px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:28px;

}

.primary{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

}

.success{

    background:linear-gradient(135deg,#10b981,#34d399);

}

.warning{

    background:linear-gradient(135deg,#f59e0b,#fbbf24);

}

.danger{

    background:linear-gradient(135deg,#ef4444,#f87171);

}

.modern-search{

    position:relative;

}

.modern-search i{

    position:absolute;
    top:50%;
    left:16px;
    transform:translateY(-50%);
    color:#9ca3af;
    font-size:14px;

}

.modern-search input{

    height:54px;
    border-radius:18px;
    border:1px solid #e5e7eb;
    padding-left:46px;
    font-size:15px;
    font-weight:500;
    transition:0.25s;

}

.modern-search input:focus{

    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,0.1);

}

.modern-select{

    height:54px;
    border-radius:18px;
    border:1px solid #e5e7eb;
    font-weight:600;
    transition:0.25s;

}

.modern-select:focus{

    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,0.1);

}

.filter-btn{

    height:54px;
    border:none;
    border-radius:18px;
    font-weight:700;
    background:linear-gradient(135deg,#2563eb,#3b82f6);
    transition:0.25s;

}

.filter-btn:hover{

    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(37,99,235,0.25);

}

.reset-btn{

    width:54px;
    height:54px;
    border-radius:18px;
    border:none;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;

}

.reset-btn:hover{

    background:#e5e7eb;

}

.custom-table thead{

    background:#f9fafb;

}

.custom-table thead th{

    border:none;
    padding:18px;
    font-size:14px;
    color:#6b7280;
    text-transform:uppercase;

}

.custom-table tbody td{

    padding:20px 18px;
    border-top:1px solid #f1f5f9;
    vertical-align:middle;

}

.job-logo{

    width:55px;
    height:55px;
    border-radius:18px;
    background:linear-gradient(135deg,#2563eb,#60a5fa);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;

}

.table-badge{

    background:#eff6ff;
    color:#2563eb;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;

}

.views-box{

    background:#f3f4f6;
    padding:8px 14px;
    border-radius:12px;
    font-weight:600;
    display:inline-flex;
    align-items:center;

}

.status-badge{

    padding:10px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;

}

.status-badge.pending{

    background:#fef3c7;
    color:#b45309;

}

.status-badge.approved{

    background:#dcfce7;
    color:#166534;

}

.status-badge.rejected{

    background:#fee2e2;
    color:#991b1b;

}

.action-btn{

    width:40px;
    height:40px;
    border:none;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-decoration:none;

}

.action-btn.info{

    background:#0ea5e9;

}

.action-btn.success{

    background:#10b981;

}

.action-btn.warning{

    background:#f59e0b;

}

.action-btn.danger{

    background:#ef4444;

}

.empty-state{

    text-align:center;
    padding:70px 20px;

}

.empty-state i{

    font-size:60px;
    color:#cbd5e1;
    margin-bottom:20px;

}

.dashboard-badge{

    background:#dcfce7;
    color:#166534;
    padding:12px 18px;
    border-radius:999px;
    font-weight:700;

}

</style>
<script>

document.addEventListener('DOMContentLoaded', function () {

    var tooltipTriggerList =
        [].slice.call(
            document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'
            )
        );

    tooltipTriggerList.map(function (tooltipTriggerEl) {

        return new bootstrap.Tooltip(
            tooltipTriggerEl
        );

    });

});

</script>
@endsection