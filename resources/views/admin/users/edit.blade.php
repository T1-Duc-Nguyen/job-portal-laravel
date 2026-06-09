@extends('layouts.admin')
@section('title', 'Chỉnh sửa người dùng')
@section('content')

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="alert alert-danger rounded-4 border-0">

                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                </div>

            @endif

            <form method="POST" action="/admin/users/{{ $user->id }}">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- NAME --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Họ tên

                        </label>

                        <input type="text" name="name" class="form-control rounded-3"
                            value="{{ old('name', $user->name) }}">

                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Email

                        </label>

                        <input type="email" name="email" class="form-control rounded-3"
                            value="{{ old('email', $user->email) }}">

                    </div>

                    {{-- PHONE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Số điện thoại

                        </label>

                        <input type="text" name="phone" class="form-control rounded-3"
                            value="{{ old('phone', $user->phone ?? '') }}">

                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Mật khẩu mới

                        </label>

                        <input type="password" name="password" class="form-control rounded-3"
                            placeholder="Để trống nếu không đổi">

                    </div>

                    {{-- ROLE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Vai trò

                        </label>

                        <select name="role" class="form-select rounded-3">

                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>

                                Candidate

                            </option>

                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>

                                Employer

                            </option>

                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>

                                Admin

                            </option>

                        </select>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Trạng thái

                        </label>

                        <select name="status" class="form-select rounded-3">

                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>

                                Hoat động

                            </option>

                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>

                                Bị khóa

                            </option>

                        </select>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-3 d-flex gap-2">

                    <a href="/admin/users" class="btn btn-secondary rounded-3 px-4">

                        <i class="fa fa-arrow-left me-2"></i>

                        Quay lại

                    </a>

                    <button class="btn btn-primary rounded-3 px-4">

                        <i class="fa fa-save me-2"></i>

                        Lưu thay đổi

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
