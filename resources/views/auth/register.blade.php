<!DOCTYPE html>
<html lang="vi">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Đăng ký</title>

    {{-- BOOTSTRAP --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- FONT AWESOME --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- GOOGLE FONT --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>

        *{
            font-family:'Inter',sans-serif;
        }

        body{

            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            padding:30px;

        }

        .register-card{

            width:100%;
            max-width:460px;

            background:#fff;

            border-radius:28px;

            padding:38px;

            box-shadow:
                0 20px 60px rgba(0,0,0,.12);

        }

        .logo{

            text-align:center;
            margin-bottom:30px;

        }

        .logo-icon{

            width:72px;
            height:72px;

            border-radius:22px;

            margin:auto auto 18px;

            display:flex;
            align-items:center;
            justify-content:center;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            color:#fff;
            font-size:28px;

            box-shadow:
                0 10px 25px rgba(37,99,235,.25);

        }

        .logo h2{

            font-size:32px;
            font-weight:800;
            color:#0f172a;

        }

        .logo p{

            color:#64748b;
            margin-top:8px;
            font-size:14px;

        }

        .form-label{

            font-size:14px;
            font-weight:600;
            color:#334155;

        }

        .form-control,
        .form-select{

            height:52px;

            border-radius:16px;

            border:1px solid #e2e8f0;

            padding:0 16px;

            font-size:14px;

            transition:.25s;

        }

        .form-control:focus,
        .form-select:focus{

            border-color:#2563eb;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.12);

        }

        .input-group-text{

            border-radius:16px 0 0 16px;

            border:1px solid #e2e8f0;

            background:#f8fafc;

        }

        .register-btn{

            height:54px;

            border:none;

            border-radius:18px;

            width:100%;

            font-weight:700;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            color:#fff;

            transition:.25s;

            box-shadow:
                0 10px 25px rgba(37,99,235,.25);

        }

        .register-btn:hover{

            transform:translateY(-2px);

            opacity:.95;

        }

        .login-link{

            text-align:center;

            margin-top:22px;

            color:#64748b;

            font-size:14px;

        }

        .login-link a{

            color:#2563eb;

            font-weight:700;

            text-decoration:none;

        }

        .login-link a:hover{

            text-decoration:underline;

        }

        .alert{

            border:none;

            border-radius:18px;

            font-size:14px;

        }

    </style>

</head>

<body>

<div class="register-card">

    {{-- LOGO --}}
    <div class="logo">

        <div class="logo-icon">

            <i class="fa fa-briefcase"></i>

        </div>

        <h2>JobConnect</h2>

        <p>

            Tạo tài khoản để bắt đầu tìm việc

        </p>

    </div>

    {{-- ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                <div>

                    <i class="fa fa-circle-exclamation me-1"></i>

                    {{ $error }}

                </div>

            @endforeach

        </div>

    @endif

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('register') }}">

        @csrf

        {{-- NAME --}}
        <div class="mb-3">

            <label class="form-label">

                Họ tên

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fa fa-user"></i>

                </span>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    placeholder="Nhập họ tên"
                    required>

            </div>

        </div>

        {{-- EMAIL --}}
        <div class="mb-3">

            <label class="form-label">

                Email

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fa fa-envelope"></i>

                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    placeholder="Nhập email"
                    required>

            </div>

        </div>

        {{-- PHONE --}}
        <div class="mb-3">

            <label class="form-label">

                Số điện thoại

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fa fa-phone"></i>

                </span>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    placeholder="Nhập số điện thoại"
                    required>

            </div>

        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">

            <label class="form-label">

                Mật khẩu

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fa fa-lock"></i>

                </span>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Nhập mật khẩu"
                    required>

            </div>

        </div>

        {{-- CONFIRM --}}
        <div class="mb-3">

            <label class="form-label">

                Xác nhận mật khẩu

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fa fa-shield"></i>

                </span>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Nhập lại mật khẩu"
                    required>

            </div>

        </div>

        {{-- ROLE --}}
        <div class="mb-4">

            <label class="form-label">

                Đăng ký với tư cách

            </label>

            <select
                name="role"
                class="form-select">

                <option value="1">

                    Ứng viên

                </option>

                <option value="2">

                    Nhà tuyển dụng

                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <button
            type="submit"
            class="register-btn">

            <i class="fa fa-user-plus me-2"></i>

            Đăng ký

        </button>

    </form>

    {{-- LOGIN --}}
    <div class="login-link">

        Đã có tài khoản?

        <a href="{{ route('login') }}">

            Đăng nhập

        </a>

    </div>

</div>

</body>
</html>