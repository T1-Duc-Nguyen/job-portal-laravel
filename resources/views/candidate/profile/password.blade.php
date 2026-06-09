@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-7">

                {{-- HEADER --}}
                <div class="text-center mb-4">

                    <h2 class="fw-bold mb-2">

                        Đổi mật khẩu

                    </h2>

                    <p class="text-muted">

                        Cập nhật mật khẩu để bảo mật tài khoản của bạn

                    </p>

                </div>


                {{-- CARD --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- TOP BAR --}}
                    <div class="bg-primary text-white p-4">

                        <div class="d-flex align-items-center gap-3">

                            <div class="password-icon">

                                <i class="fa fa-lock"></i>

                            </div>

                            <div>

                                <h4 class="fw-bold mb-1">

                                    Bảo mật tài khoản

                                </h4>

                                <small>

                                    Hãy sử dụng mật khẩu mạnh

                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- BODY --}}
                    <div class="card-body p-5">

                        <form method="POST" action="{{ url()->current() }}">

                            @csrf


                            {{-- CURRENT PASSWORD --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Mật khẩu hiện tại

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light">

                                        <i class="fa fa-key"></i>

                                    </span>

                                    <input type="password" name="current_password"
                                        class="form-control form-control-lg rounded-end-3"
                                        placeholder="Nhập mật khẩu hiện tại">

                                </div>

                                @error('current_password')
                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>
                                @enderror

                            </div>


                            {{-- NEW PASSWORD --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Mật khẩu mới

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light">

                                        <i class="fa fa-lock"></i>

                                    </span>

                                    <input type="password" name="password"
                                        class="form-control form-control-lg rounded-end-3" placeholder="Nhập mật khẩu mới">

                                </div>

                                @error('password')
                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>
                                @enderror

                            </div>


                            {{-- CONFIRM --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Xác nhận mật khẩu

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light">

                                        <i class="fa fa-shield"></i>

                                    </span>

                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-lg rounded-end-3" placeholder="Nhập lại mật khẩu">

                                </div>

                            </div>


                            {{-- PASSWORD RULES --}}
                            <div class="alert alert-light border rounded-4 mb-4">

                                <div class="fw-semibold mb-2">

                                    Mật khẩu nên có:

                                </div>

                                <ul class="mb-0 small text-muted">

                                    <li>Ít nhất 6 ký tự</li>

                                    <li>Chữ hoa và chữ thường</li>

                                    <li>Số và ký tự đặc biệt</li>

                                </ul>

                            </div>


                            {{-- BUTTON --}}
                            <button class="btn btn-primary btn-lg w-100 rounded-3">

                                <i class="fa fa-floppy-disk me-2"></i>

                                Cập nhật mật khẩu

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <style>
        .password-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px;
        }

        .input-group-text {
            border-radius: 14px 0 0 14px;
        }

        .card {
            border-radius: 24px;
        }
    </style>

@endsection
