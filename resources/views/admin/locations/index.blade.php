@extends('layouts.admin')

@section('title', 'Quản lý địa điểm')

@section('content')

<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Quản lý địa điểm

            </h2>

            <p class="text-muted mb-0">

                Quản lý khu vực tuyển dụng và địa điểm làm việc trên hệ thống

            </p>

        </div>

        <a href="/admin/locations/create"
           class="btn btn-primary add-btn">

            <i class="fa fa-plus me-2"></i>

            Thêm địa điểm

        </a>

    </div>

    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Tổng địa điểm

                    </p>

                    <h3 class="stats-number">

                        {{ \App\Models\Location::count() }}

                    </h3>

                </div>

                <div class="stats-icon primary">

                    <i class="fa fa-location-dot"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Có jobs

                    </p>

                    <h3 class="stats-number text-success">

                        {{ \App\Models\Location::has('jobs')->count() }}

                    </h3>

                </div>

                <div class="stats-icon success">

                    <i class="fa fa-briefcase"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Tổng Apply

                    </p>

                    <h3 class="stats-number text-danger">

                        {{ \App\Models\Application::count() }}

                    </h3>

                </div>

                <div class="stats-icon danger">

                    <i class="fa fa-users"></i>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="stats-card">

                <div>

                    <p class="stats-label">

                        Chưa có jobs

                    </p>

                    <h3 class="stats-number text-warning">

                        {{ \App\Models\Location::doesntHave('jobs')->count() }}

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

                        <div class="search-box">

                            <i class="fa fa-search"></i>

                            <input type="text"
                                   name="keyword"
                                   class="form-control"
                                   placeholder="Tên địa điểm..."
                                   value="{{ request('keyword') }}">

                        </div>

                    </div>

                    {{-- HAS JOBS --}}
                    <div class="col-lg-3">

                        <select name="has_jobs"
                                class="form-select">

                            <option value="">
                                Tất cả địa điểm
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

                                Apply nhiều nhất

                            </option>

                            <option value="latest"
                                {{ request('sort') == 'latest' ? 'selected' : '' }}>

                                Mới nhất

                            </option>

                        </select>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-lg-2">

                        <button class="btn btn-primary w-100 filter-btn">

                            <i class="fa fa-filter me-2"></i>

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

                            <th>Địa điểm</th>

                            <th>Số lượng Jobs</th>

                            <th>Số lượng Apply</th>

                            <th>Ngày tạo</th>

                            <th width="180">

                                Thao tác

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($locations as $location)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="fw-bold text-primary">

                                    #{{ $location->id }}

                                </span>

                            </td>

                            {{-- LOCATION --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="location-icon">

                                        <i class="fa fa-location-dot"></i>

                                    </div>

                                    <div>

                                        <h6 class="fw-bold mb-1">

                                            {{ $location->name }}

                                        </h6>

                                        <small class="text-muted">

                                            Khu vực tuyển dụng

                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- JOB COUNT --}}
                            <td>

                                @if($location->jobs_count > 0)

                                    <span class="jobs-badge active">

                                        <i class="fa fa-briefcase me-1"></i>

                                        {{ $location->jobs_count }} jobs

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

                                @if($location->applications_count > 0)

                                    <span class="jobs-badge apply">

                                        <i class="fa fa-users me-1"></i>

                                        {{ $location->applications_count }} apply

                                    </span>

                                @else

                                    <span class="jobs-badge empty">

                                        <i class="fa fa-user-xmark me-1"></i>

                                        0 apply

                                    </span>

                                @endif

                            </td>

                            {{-- DATE --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ \Carbon\Carbon::parse($location->created_at)->format('d/m/Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ \Carbon\Carbon::parse($location->created_at)->diffForHumans() }}

                                </small>

                            </td>

                            {{-- ACTION --}}
                            <td>

                                <div class="d-flex gap-2">

                                    <a href="/admin/locations/{{ $location->id }}/edit"
                                       class="action-btn warning">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                    <form action="/admin/locations/{{ $location->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn danger"
                                                onclick="return confirm('Xóa địa điểm này?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty-state">

                                    <i class="fa fa-location-dot"></i>

                                    <h5>

                                        Không có địa điểm nào

                                    </h5>

                                    <p>

                                        Hệ thống chưa có dữ liệu địa điểm

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
            <strong>{{ $locations->firstItem() }}</strong>
            -
            <strong>{{ $locations->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $locations->total() }}</strong>
            địa điểm

        </div>

        <div>

            {{ $locations->onEachSide(1)->links('pagination::bootstrap-5') }}

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

.stats-icon.danger{

    background:linear-gradient(135deg,#ef4444,#f87171);

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

.location-icon{

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

.jobs-badge.apply{

    background:#dbeafe;
    color:#1d4ed8;

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