<!DOCTYPE html>
<html lang="vi">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập</title>

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

            padding:30px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

        }

        .login-card{

            width:100%;
            max-width:450px;

            background:#fff;

            border-radius:28px;

            padding:40px;

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

            margin:auto auto 18px;

            border-radius:22px;

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

            margin-top:8px;

            color:#64748b;

            font-size:14px;

        }

        .form-label{

            font-size:14px;
            font-weight:600;

            color:#334155;

        }

        .form-control{

            height:52px;

            border-radius:16px;

            border:1px solid #e2e8f0;

            font-size:14px;

            padding:0 16px;

            transition:.25s;

        }

        .form-control:focus{

            border-color:#2563eb;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.12);

        }

        .input-group-text{

            border-radius:16px 0 0 16px;

            border:1px solid #e2e8f0;

            background:#f8fafc;

        }

        .form-check-label{

            font-size:14px;
            color:#475569;

        }

        .login-btn{

            width:100%;

            height:54px;

            border:none;

            border-radius:18px;

            font-weight:700;

            color:#fff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            transition:.25s;

            box-shadow:
                0 10px 25px rgba(37,99,235,.25);

        }

        .login-btn:hover{

            transform:translateY(-2px);

            opacity:.95;

        }

        .bottom-link{

            text-align:center;

            margin-top:24px;

            color:#64748b;

            font-size:14px;

        }

        .bottom-link a{

            color:#2563eb;

            text-decoration:none;

            font-weight:700;

        }

        .bottom-link a:hover{

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

<div class="login-card">

    {{-- LOGO --}}
    <div class="logo">

        <div class="logo-icon">

            <i class="fa fa-briefcase"></i>

        </div>

        <h2>JobConnect</h2>

        <p>

            Nền tảng tìm việc hàng đầu

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

    {{-- SUCCESS --}}
    @if(session('status'))

        <div class="alert alert-success">

            <i class="fa fa-circle-check me-1"></i>

            {{ session('status') }}

        </div>

    @endif

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('login') }}">

        @csrf

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

        {{-- REMEMBER --}}
        <div class="form-check mb-4">

            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember">

            <label
                class="form-check-label"
                for="remember">

                Ghi nhớ đăng nhập

            </label>

        </div>

        {{-- BUTTON --}}
        <button
            type="submit"
            class="login-btn">

            <i class="fa fa-right-to-bracket me-2"></i>

            Đăng nhập

        </button>

    </form>

    {{-- REGISTER --}}
    <div class="bottom-link">

        Chưa có tài khoản?

        <a href="{{ route('register') }}">

            Đăng ký ngay

        </a>

    </div>

</div>

</body>
</html>