@extends('layouts.employer')
@section('title', 'Hồ sơ công ty')
@section('content')

    <div class="container-fluid py-4">

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0">

                <i class="fas fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif


        <div class="row">

            {{-- LEFT --}}
            <div class="col-lg-4">

                {{-- COMPANY CARD --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                    {{-- BANNER --}}
                    <div style="height:180px; overflow:hidden;">

                        <img src="{{ !empty($company?->banner)
                            ? asset($company->banner)
                            : 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=1200' }}"
                            class="w-100 h-100 object-fit-cover">

                    </div>

                    <div class="card-body text-center p-4">

                        {{-- LOGO --}}
                        <img src="{{ !empty($company?->logo)
                            ? asset($company->logo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($company?->company_name ?? 'Company') }}"
                            width="110" height="110"
                            class="rounded-circle border border-4 border-white shadow-sm object-fit-cover mt-n5 bg-white">

                        <h3 class="fw-bold mt-3 mb-1">

                            {{ $company->company_name }}

                        </h3>

                        <p class="text-muted mb-3">

                            {{ $company->industry }}

                        </p>

                        {{-- INFO --}}
                        <div class="text-start mt-4">

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-users me-2 text-primary"></i>

                                    Quy mô công ty

                                </small>

                                <strong>

                                    {{ $company->company_size ?: 'Chưa cập nhật' }}

                                </strong>

                            </div>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-calendar me-2 text-primary"></i>

                                    Thành lập

                                </small>

                                <strong>

                                    {{ $company->founded_year ?: 'Chưa cập nhật' }}

                                </strong>

                            </div>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-globe me-2 text-primary"></i>

                                    Website

                                </small>

                                @if ($company->website)
                                    <a href="{{ $company->website }}" target="_blank" class="text-decoration-none">

                                        {{ $company->website }}

                                    </a>
                                @else
                                    <span>

                                        Chưa cập nhật

                                    </span>
                                @endif

                            </div>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-envelope me-2 text-primary"></i>

                                    Email

                                </small>

                                <strong>

                                    {{ $company->email ?: 'Chưa cập nhật' }}

                                </strong>

                            </div>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-phone me-2 text-primary"></i>

                                    Số điện thoại

                                </small>

                                <strong>

                                    {{ $company->phone ?: 'Chưa cập nhật' }}

                                </strong>

                            </div>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-1">

                                    <i class="fa fa-location-dot me-2 text-primary"></i>

                                    Địa chỉ

                                </small>

                                <strong>

                                    {{ $company->address ?: 'Chưa cập nhật' }}

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h3 class="fw-bold mb-1">

                                    Company Profile

                                </h3>

                                <p class="text-muted mb-0">

                                    Cập nhật thông tin công ty tuyển dụng

                                </p>

                            </div>

                        </div>

                        <form action="/employer/company/update" method="POST" enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                {{-- COMPANY NAME --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Tên công ty

                                    </label>

                                    <input type="text" name="company_name" class="form-control rounded-3"
                                        value="{{ $company->company_name }}">

                                </div>

                                {{-- INDUSTRY --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Ngành nghề

                                    </label>

                                    <input type="text" name="industry" class="form-control rounded-3"
                                        value="{{ $company->industry }}">

                                </div>

                                {{-- PHONE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Số điện thoại

                                    </label>

                                    <input type="text" name="phone" class="form-control rounded-3"
                                        value="{{ $company->phone }}">

                                </div>

                                {{-- EMAIL --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Email

                                    </label>

                                    <input type="email" name="email" class="form-control rounded-3"
                                        value="{{ $company->email }}">

                                </div>

                                {{-- WEBSITE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Website

                                    </label>

                                    <input type="text" name="website" class="form-control rounded-3"
                                        value="{{ $company->website }}">

                                </div>

                                {{-- COMPANY SIZE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Quy mô công ty

                                    </label>

                                    <select name="company_size" class="form-select rounded-3">

                                        <option value="">
                                            Chọn quy mô
                                        </option>

                                        <option value="1-10" {{ $company->company_size == '1-10' ? 'selected' : '' }}>
                                            1-10 nhân viên
                                        </option>

                                        <option value="10-50" {{ $company->company_size == '10-50' ? 'selected' : '' }}>
                                            10-50 nhân viên
                                        </option>

                                        <option value="50-100" {{ $company->company_size == '50-100' ? 'selected' : '' }}>
                                            50-100 nhân viên
                                        </option>

                                        <option value="100+" {{ $company->company_size == '100+' ? 'selected' : '' }}>
                                            100+ nhân viên
                                        </option>

                                    </select>

                                </div>

                                {{-- FOUNDED --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Năm thành lập

                                    </label>

                                    <input type="text" name="founded_year" class="form-control rounded-3"
                                        value="{{ $company->founded_year }}">

                                </div>

                                {{-- FACEBOOK --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Facebook

                                    </label>

                                    <input type="text" name="facebook" class="form-control rounded-3"
                                        value="{{ $company->facebook }}">

                                </div>

                                {{-- LINKEDIN --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Linkedin

                                    </label>

                                    <input type="text" name="linkedin" class="form-control rounded-3"
                                        value="{{ $company->linkedin }}">

                                </div>

                                {{-- ADDRESS --}}
                                <div class="col-12 mb-3">

                                    <label class="form-label fw-semibold">

                                        Địa chỉ

                                    </label>

                                    <input type="text" name="address" class="form-control rounded-3"
                                        value="{{ $company->address }}">

                                </div>

                                {{-- LOGO --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Logo công ty

                                    </label>

                                    <input type="file" name="logo" class="form-control rounded-3">

                                </div>

                                {{-- BANNER --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold">

                                        Banner công ty

                                    </label>

                                    <input type="file" name="banner" class="form-control rounded-3">

                                </div>

                                {{-- DESCRIPTION --}}
                                <div class="col-12 mb-4">

                                    <label class="form-label fw-semibold">

                                        Giới thiệu công ty

                                    </label>

                                    <textarea name="description" rows="8" class="form-control rounded-3">{{ $company->description }}</textarea>

                                </div>

                            </div>

                            <button class="btn btn-primary px-5 py-2 rounded-3">

                                <i class="fa fa-save me-2"></i>

                                Lưu thông tin công ty

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
