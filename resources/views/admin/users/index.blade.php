@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')

    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h2 class="fw-bold mb-1 text-dark">
                    Quản lý người dùng
                </h2>

                <p class="text-muted mb-0">
                    Quản lý tài khoản ứng viên, nhà tuyển dụng và admin
                </p>
            </div>

            <a href="/admin/users/create" class="btn btn-primary rounded-4 px-4 shadow-sm">

                <i class="fa fa-plus me-2"></i>
                Thêm người dùng

            </a>

        </div>

        {{-- STATS --}}
        <div class="row mb-4">

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-2">
                                    Tổng Users
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $users->total() }}
                                </h3>

                            </div>

                            <div class="dashboard-icon bg-primary">

                                <i class="fa fa-users"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-2">
                                    Candidates
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ \App\Models\User::where('role', 1)->count() }}
                                </h3>

                            </div>

                            <div class="dashboard-icon bg-info">

                                <i class="fa fa-user"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-2">
                                    Employers
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ \App\Models\User::where('role', 2)->count() }}
                                </h3>

                            </div>

                            <div class="dashboard-icon bg-success">

                                <i class="fa fa-building"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-2">
                                    Active Users
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ \App\Models\User::where('status', 1)->count() }}
                                </h3>

                            </div>

                            <div class="dashboard-icon bg-warning">

                                <i class="fa fa-check"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- MAIN CARD --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Danh sách người dùng
                        </h5>

                        <p class="text-muted small mb-0">
                            Quản lý và theo dõi toàn bộ tài khoản hệ thống
                        </p>

                    </div>

                </div>

            </div>

            {{-- FILTER --}}
            <div class="px-4 pb-3">

                <form method="GET">

                    <div class="row g-3">

                        {{-- SEARCH --}}
                        <div class="col-lg-4">

                            <div class="position-relative">

                                <i
                                    class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                                <input type="text" name="keyword" class="form-control rounded-4 ps-5"
                                    placeholder="Tìm tên hoặc email..." value="{{ request('keyword') }}">

                            </div>

                        </div>

                        {{-- ROLE --}}
                        <div class="col-lg-3">

                            <select name="role" class="form-select rounded-4">

                                <option value="">
                                    Tất cả vai trò
                                </option>

                                <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>
                                    Candidate
                                </option>

                                <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>
                                    Employer
                                </option>

                            </select>

                        </div>

                        {{-- STATUS --}}
                        <div class="col-lg-3">

                            <select name="status" class="form-select rounded-4">

                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                    Blocked
                                </option>

                            </select>

                        </div>

                        {{-- BUTTON --}}
                        <div class="col-lg-2">

                            <button class="btn btn-primary w-100 rounded-4">

                                <i class="fa fa-filter me-2"></i>
                                Lọc

                            </button>

                        </div>

                    </div>

                </form>

            </div>

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="px-4">

                    <div class="alert alert-success rounded-4 border-0 shadow-sm">

                        <i class="fa fa-circle-check me-2"></i>

                        {{ session('success') }}

                    </div>

                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="bg-light">

                        <tr>

                            <th class="ps-4 py-3">
                                User
                            </th>

                            <th>
                                Vai trò
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th>
                                Ngày tham gia
                            </th>

                            <th class="text-center">
                                Hành động
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)
                            <tr class="border-top">

                                {{-- USER --}}
                                <td class="ps-4 py-3">

                                    <div class="d-flex align-items-center">

                                        <div class="user-avatar me-3">

                                            {{ strtoupper(substr($user->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <div class="fw-semibold text-dark">

                                                {{ $user->name }}

                                            </div>

                                            <div class="text-muted small">

                                                {{ $user->email }}

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- ROLE --}}
                                <td>

                                    @if ($user->role == 0)
                                        <span class="badge bg-danger rounded-pill px-3 py-2">

                                            Admin

                                        </span>
                                    @elseif($user->role == 1)
                                        <span class="badge bg-primary rounded-pill px-3 py-2">

                                            Candidate

                                        </span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            Employer

                                        </span>
                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if ($user->status == 1)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                            <i class="fa fa-circle me-1 small"></i>
                                            Active

                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                            <i class="fa fa-circle me-1 small"></i>
                                            Blocked

                                        </span>
                                    @endif

                                </td>

                                {{-- DATE --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $user->created_at->format('d/m/Y') }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $user->created_at->format('H:i') }}

                                    </small>

                                </td>

                                {{-- ACTION --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="/admin/users/{{ $user->id }}/edit"
                                            class="btn btn-light border rounded-circle shadow-sm action-btn">

                                            <i class="fa fa-pen text-warning"></i>

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="/admin/users/{{ $user->id }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-light border rounded-circle shadow-sm action-btn"
                                                onclick="return confirm('Xóa user này?')">

                                                <i class="fa fa-trash text-danger"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <i class="fa fa-users text-secondary mb-3" style="font-size:60px;"></i>

                                    <h5 class="fw-bold">
                                        Không có dữ liệu users
                                    </h5>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer bg-white border-0 px-4 py-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div class="text-muted small">

                        Hiển thị
                        <strong>{{ $users->firstItem() }}</strong>
                        -
                        <strong>{{ $users->lastItem() }}</strong>

                        trong tổng số
                        <strong>{{ $users->total() }}</strong>
                        users

                    </div>

                    <div>

                        {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    <style>
        .dashboard-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .table tbody tr:hover {
            background: #f8fbff;
        }

        .form-control,
        .form-select {
            height: 48px;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #2563eb;
        }

        .card {
            border-radius: 24px;
        }
    </style>

@endsection
