@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success shadow-sm">

            {{ session('success') }}

        </div>

    @endif

    {{-- ERROR --}}

    @if(session('error'))

        <div class="alert alert-danger shadow-sm">

            {{ session('error') }}

        </div>

    @endif

    <form action="/candidate/profile/update"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- HEADER --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex
                            justify-content-between
                            align-items-center">

                    <div>

                        <h2 class="fw-bold mb-1">

                            Hồ sơ ứng viên

                        </h2>

                        <p class="text-muted mb-0">

                            Cập nhật hồ sơ cá nhân của bạn

                        </p>

                    </div>

                    <button class="btn btn-primary px-4 rounded-pill">

                        <i class="fa fa-save me-2"></i>

                        Lưu hồ sơ

                    </button>

                </div>

            </div>

        </div>

        {{-- PROFILE --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="row">

                    {{-- AVATAR --}}

                    <div class="col-lg-3 text-center">

                        <img
                            src="/{{ $candidate->avatar ?? 'default.png' }}"
                            class="rounded-circle shadow-sm border"
                            width="140"
                            height="140"
                            style="object-fit:cover">

                        <input type="file"
                               name="avatar"
                               class="form-control mt-3">

                    </div>

                    {{-- INFO --}}

                    <div class="col-lg-9">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Họ tên

                                </label>

                                <input type="text"
                                       name="full_name"
                                       class="form-control rounded-3"
                                       value="{{ $candidate->full_name }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Ngày sinh

                                </label>

                                <input type="date"
                                       name="birthday"
                                       class="form-control rounded-3"
                                       value="{{ $candidate->birthday }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Giới tính

                                </label>

                                <select name="gender"
                                        class="form-select rounded-3">

                                    <option value="Nam"
                                        {{ $candidate->gender == 'Nam' ? 'selected' : '' }}>
                                        Nam
                                    </option>

                                    <option value="Nữ"
                                        {{ $candidate->gender == 'Nữ' ? 'selected' : '' }}>
                                        Nữ
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Vị trí mong muốn

                                </label>

                                <input type="text"
                                       name="desired_position"
                                       class="form-control rounded-3"
                                       value="{{ $candidate->desired_position }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Cấp bậc

                                </label>

                                <input type="text"
                                       name="level"
                                       class="form-control rounded-3"
                                       value="{{ $candidate->level }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="fw-semibold mb-2">

                                    Số điện thoại

                                </label>

                                <input type="text"
                                       name="phone"
                                       class="form-control rounded-3"
                                       value="{{ $candidate->phone }}">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ABOUT --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">

                    Thông tin chi tiết

                </h5>

                <div class="mb-4">

                    <label class="fw-semibold mb-2">

                        Giới thiệu bản thân

                    </label>

                    <textarea name="description"
                              class="form-control rounded-3"
                              rows="5">{{ $candidate->description }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="fw-semibold mb-2">

                        Địa chỉ

                    </label>

                    <input type="text"
                           name="address"
                           class="form-control rounded-3"
                           value="{{ $candidate->address }}">

                </div>

                <div class="mb-4">

                    <label class="fw-semibold mb-2">

                        Kỹ năng

                    </label>

                    <textarea name="skills"
                              class="form-control rounded-3"
                              rows="4">{{ $candidate->skills }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="fw-semibold mb-2">

                        Kinh nghiệm

                    </label>

                    <textarea name="experience"
                              class="form-control rounded-3"
                              rows="6">{{ $candidate->experience }}</textarea>

                </div>

                <div>

                    <label class="fw-semibold mb-2">

                        Học vấn

                    </label>

                    <textarea name="education"
                              class="form-control rounded-3"
                              rows="6">{{ $candidate->education }}</textarea>

                </div>

            </div>

        </div>

    </form>

    {{-- CV SECTION --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex
                        justify-content-between
                        align-items-center
                        mb-4">

                <div>

                    <h4 class="fw-bold mb-1">

                        CV của tôi

                    </h4>

                    <p class="text-muted mb-0">

                        Upload và quản lý CV

                    </p>

                </div>

            </div>

            {{-- UPLOAD --}}

            <form action="/candidate/cv/upload"
                  method="POST"
                  enctype="multipart/form-data"
                  class="mb-4">

                @csrf

                <div class="input-group">

                    <input type="file"
                           name="cv"
                           class="form-control">

                    <button class="btn btn-primary">

                        <i class="fa fa-upload me-2"></i>

                        Upload CV AI

                    </button>

                </div>

            </form>

            {{-- LIST CV --}}

            @if($candidate->cvs->count() > 0)

                <div class="row">

                    @foreach($candidate->cvs as $cv)

                        <div class="col-lg-6 mb-3">

                            <div class="border
                                        rounded-4
                                        p-3
                                        d-flex
                                        justify-content-between
                                        align-items-center">

                                <div>

                                    <div class="fw-bold mb-1">

                                        <i class="fa fa-file-pdf text-danger me-2"></i>

                                        {{ basename($cv->file_path) }}

                                    </div>

                                    <small class="text-muted">

                                        Upload:
                                        {{ $cv->created_at }}

                                    </small>

                                </div>

                                <div class="d-flex gap-2">

                                    {{-- VIEW --}}

                                    <a href="/storage/{{ $cv->file_path }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary rounded-pill">

                                        Xem

                                    </a>

                                    {{-- DELETE --}}

                                    <form action="/candidate/cv/{{ $cv->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger rounded-pill"
                                                onclick="return confirm('Xóa CV này?')">

                                            Xóa

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa fa-file-pdf fa-3x text-muted mb-3"></i>

                    <h5>

                        Chưa có CV nào

                    </h5>

                    <p class="text-muted">

                        Upload CV để AI tự động đọc hồ sơ

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection