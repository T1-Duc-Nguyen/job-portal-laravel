@extends('layouts.admin')

@section('title', 'Quản lý hình thức làm việc')

@section('content')

<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Quản lý hình thức làm việc

            </h2>

            <p class="text-muted mb-0">

                Quản lý loại hình tuyển dụng và hình thức làm việc trên hệ thống

            </p>

        </div>

        <a href="/admin/jobtypes/create"
           class="btn btn-primary add-btn">

            <i class="fa fa-plus me-2"></i>

            Thêm hình thức

        </a>

    </div>

    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-lg-4 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Tổng hình thức

                    </p>

                    <h3 class="stats-number">

                        {{ \App\Models\JobType::count() }}

                    </h3>

                </div>

                <div class="stats-icon primary">

                    <i class="fa fa-briefcase"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-4 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Có jobs

                    </p>

                    <h3 class="stats-number text-success">

                        {{ \App\Models\JobType::has('jobs')->count() }}

                    </h3>

                </div>

                <div class="stats-icon success">

                    <i class="fa fa-circle-check"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-4 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Chưa có jobs

                    </p>

                    <h3 class="stats-number text-warning">

                        {{ \App\Models\JobType::doesntHave('jobs')->count() }}

                    </h3>

                </div>

                <div class="stats-icon warning">

                    <i class="fa fa-folder-open"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <form method="GET">

    <div class="row g-3">

        {{-- SEARCH --}}
        <div class="col-lg-4">

            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Tên hình thức làm việc..."
                   value="{{ request('keyword') }}">

        </div>

        {{-- HAS JOBS --}}
        <div class="col-lg-3">

            <select name="has_jobs"
                    class="form-select">

                <option value="">
                    Tất cả
                </option>

                <option value="1"
                    {{ request('has_jobs') == '1' ? 'selected' : '' }}>

                    Có jobs

                </option>

                <option value="0"
                    {{ request('has_jobs') == '0' ? 'selected' : '' }}>

                    Chưa có jobs

                </option>

            </select>

        </div>

        {{-- SORT --}}
        <div class="col-lg-3">

            <select name="sort"
                    class="form-select">

                <option value="">
                    Sắp xếp
                </option>

                <option value="jobs"
                    {{ request('sort') == 'jobs' ? 'selected' : '' }}>

                    Nhiều jobs nhất

                </option>

                <option value="applications"
                    {{ request('sort') == 'applications' ? 'selected' : '' }}>

                    Nhiều apply nhất

                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <div class="col-lg-2">

            <button class="btn btn-primary w-100">

                <i class="fa fa-filter"></i>

                Lọc

            </button>

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

                            <th>Hình thức làm việc</th>

                            <th>Số lượng Jobs</th>

                            <th>Lượt Apply</th>

                            <th>Ngày tạo</th>

                            <th width="180">

                                Thao tác

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($jobTypes as $jobType)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="fw-bold text-primary">

                                    #{{ $jobType->id }}

                                </span>

                            </td>

                            {{-- TYPE --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="jobtype-icon">

                                        <i class="fa fa-briefcase"></i>

                                    </div>

                                    <div>

                                        <h6 class="fw-bold mb-1">

                                            {{ $jobType->name }}

                                        </h6>

                                        <small class="text-muted">

                                            Hình thức tuyển dụng

                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- JOB COUNT --}}
                            <td>

                                @if($jobType->jobs_count > 0)

                                    <span class="jobs-badge active">

                                        <i class="fa fa-briefcase me-1"></i>

                                        {{ $jobType->jobs_count }} jobs

                                    </span>

                                @else

                                    <span class="jobs-badge empty">

                                        <i class="fa fa-folder-open me-1"></i>

                                        Chưa có jobs

                                    </span>

                                @endif

                            </td>
                            {{-- APPLY COUNT --}}
<td>

    <span class="jobs-badge active">

        <i class="fa fa-users me-1"></i>

        {{ $jobType->applications_count ?? 0 }} apply

    </span>

</td>
                            

                            {{-- DATE --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ $jobType->created_at->format('d/m/Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ $jobType->created_at->diffForHumans() }}

                                </small>

                            </td>

                            {{-- ACTION --}}
                            <td>

                                <div class="d-flex gap-2">

                                    <a href="/admin/jobtypes/{{ $jobType->id }}/edit"
                                       class="action-btn warning">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                    <form action="/admin/jobtypes/{{ $jobType->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn danger"
                                                onclick="return confirm('Xóa hình thức này?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="empty-state">

                                    <i class="fa fa-folder-open"></i>

                                    <h5>

                                        Không có dữ liệu

                                    </h5>

                                    <p>

                                        Hệ thống chưa có hình thức làm việc nào

                                    </p>

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
            <strong>{{ $jobTypes->firstItem() }}</strong>
            -
            <strong>{{ $jobTypes->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $jobTypes->total() }}</strong>
            hình thức

        </div>

        <div>

            {{ $jobTypes->onEachSide(1)->links('pagination::bootstrap-5') }}

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
    box-shadow:0 4px 20px rgba(15,23,42,0.06);

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

.stats-icon.primary{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

}

.stats-icon.success{

    background:linear-gradient(135deg,#10b981,#34d399);

}

.stats-icon.warning{

    background:linear-gradient(135deg,#f59e0b,#fbbf24);

}

.search-box{

    position:relative;

}

.search-box i{

    position:absolute;
    left:14px;
    top:16px;
    color:#9ca3af;

}

.search-box input{

    padding-left:42px;
    height:50px;
    border-radius:16px;
    border:1px solid #e5e7eb;

}

.form-select{

    height:50px;
    border-radius:16px;
    border:1px solid #e5e7eb;

}

.filter-btn{

    height:50px;
    border-radius:16px;
    font-weight:600;

}

.add-btn{

    height:50px;
    border-radius:16px;
    display:flex;
    align-items:center;
    padding:0 22px;
    font-weight:600;

}

.custom-table thead{

    background:#f8fafc;

}

.custom-table thead th{

    border:none;
    padding:18px;
    color:#6b7280;
    font-size:13px;
    text-transform:uppercase;

}

.custom-table tbody td{

    padding:20px 18px;
    border-top:1px solid #f1f5f9;
    vertical-align:middle;

}

.jobtype-icon{

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

.jobs-badge{

    padding:10px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;

}

.jobs-badge.active{

    background:#dcfce7;
    color:#166534;

}

.jobs-badge.empty{

    background:#fef3c7;
    color:#92400e;

}

.action-btn{

    width:42px;
    height:42px;
    border:none;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-decoration:none;

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

.empty-state p{

    color:#94a3b8;

}

</style>

@endsection