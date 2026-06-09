@extends('layouts.admin')

@section('title', 'Quản lý doanh nghiệp')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Quản lý doanh nghiệp

            </h2>

            <p class="text-muted mb-0">

                Quản lý nhà tuyển dụng, trạng thái duyệt và thông tin doanh nghiệp

            </p>

        </div>

        <div class="d-flex gap-2">

            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">

                Approved:
                {{ \App\Models\Employer::where('is_approved',1)->count() }}

            </span>

            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">

                Pending:
                {{ \App\Models\Employer::where('is_approved',0)->count() }}

            </span>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <form method="GET">

                <div class="row g-3">

                    {{-- SEARCH --}}
                    <div class="col-lg-5">

                        <label class="form-label fw-semibold">

                            Tìm kiếm doanh nghiệp

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white border-end-0 rounded-start-4">

                                <i class="fa fa-search text-muted"></i>

                            </span>

                            <input type="text"
                                   name="keyword"
                                   class="form-control border-start-0 rounded-end-4"
                                   placeholder="Tên công ty, email..."
                                   value="{{ request('keyword') }}">

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Trạng thái

                        </label>

                        <select name="status"
                                class="form-select rounded-4">

                            <option value="">
                                Tất cả
                            </option>

                            <option value="1"
                                {{ request('status') == '1' ? 'selected' : '' }}>

                                Approved

                            </option>

                            <option value="0"
                                {{ request('status') == '0' ? 'selected' : '' }}>

                                Pending

                            </option>

                        </select>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-lg-2 d-flex align-items-end">

                        <button class="btn btn-primary rounded-4 w-100">

                            <i class="fa fa-filter me-2"></i>

                            Lọc dữ liệu

                        </button>

                    </div>

                    {{-- RESET --}}
                    <div class="col-lg-2 d-flex align-items-end">

                        <a href="/admin/employers"
                           class="btn btn-light border rounded-4 w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm rounded-4">

            <i class="fa fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="bg-light">

                        <tr>

                            <th class="ps-4 py-3">
                                ID
                            </th>

                            <th>
                                Doanh nghiệp
                            </th>

                            <th>
                                Ngành nghề
                            </th>

                            <th>
                                Liên hệ
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th class="text-center">
                                Thao tác
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($employers as $employer)

                        <tr>

                            {{-- ID --}}
                            <td class="ps-4 fw-semibold">

                                #{{ $employer->id }}

                            </td>

                            {{-- COMPANY --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    {{-- LOGO --}}
                                    @if($employer->logo)

                                        <img src="{{ asset($employer->logo) }}"
                                             class="rounded-4 border object-fit-cover"
                                             width="60"
                                             height="60">

                                    @else

                                        <div class="rounded-4 bg-light d-flex align-items-center justify-content-center border"
                                             style="width:60px;height:60px;">

                                            <i class="fa fa-building text-secondary"></i>

                                        </div>

                                    @endif

                                    {{-- INFO --}}
                                    <div>

                                        <div class="fw-bold mb-1">

                                            {{ $employer->company_name }}

                                        </div>

                                        <div class="small text-muted">

                                            {{ $employer->user->email ?? '---' }}

                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- INDUSTRY --}}
                            <td>

                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                    {{ $employer->industry ?? '---' }}

                                </span>

                            </td>

                            {{-- CONTACT --}}
                            <td>

                                <div class="small">

                                    <div class="mb-1">

                                        <i class="fa fa-phone text-muted me-2"></i>

                                        {{ $employer->phone ?? '---' }}

                                    </div>

                                    <div>

                                        <i class="fa fa-globe text-muted me-2"></i>

                                        {{ $employer->website ?? '---' }}

                                    </div>

                                </div>

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($employer->is_approved)

                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">

                                        <i class="fa fa-circle-check me-1"></i>

                                        Approved

                                    </span>

                                @else

                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">

                                        <i class="fa fa-clock me-1"></i>

                                        Pending

                                    </span>

                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td>

                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    {{-- VIEW --}}
                                    <a href="/admin/employers/{{ $employer->id }}"
                                       class="btn btn-light border rounded-3">

                                        <i class="fa fa-eye"></i>

                                    </a>

                                    {{-- APPROVE --}}
                                    <a href="/admin/employers/{{ $employer->id }}/approve"
                                       class="btn btn-success rounded-3">

                                        <i class="fa fa-check"></i>

                                    </a>

                                    {{-- REJECT --}}
                                    <a href="/admin/employers/{{ $employer->id }}/reject"
                                       class="btn btn-warning rounded-3 text-white">

                                        <i class="fa fa-xmark"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="/admin/employers/{{ $employer->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger rounded-3"
                                                onclick="return confirm('Xóa doanh nghiệp này?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="text-center py-5">

                                    <i class="fa fa-building text-secondary mb-3"
                                       style="font-size:60px;"></i>

                                    <h5 class="fw-bold">

                                        Không có doanh nghiệp nào

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
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">

        <div class="text-muted small">

            Hiển thị
            <strong>{{ $employers->firstItem() }}</strong>
            -
            <strong>{{ $employers->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $employers->total() }}</strong>
            doanh nghiệp

        </div>

        <div>

            {{ $employers->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection