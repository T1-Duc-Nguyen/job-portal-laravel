<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>
        Đăng nhập Admin - JobConnect
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(135deg,
                    #2563eb,
                    #60a5fa);

            font-family: Inter, sans-serif;
        }

        .login-card {
            width: 420px;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-weight: 800;
            color: #2563eb;
        }

        .btn-login {
            height: 50px;
            border-radius: 14px;
            font-weight: 700;
        }
    </style>

</head>

<body>

    <div class="login-card">

        <div class="logo">

            <h1>
                JobConnect
            </h1>

            <p class="text-muted">

                Admin Dashboard

            </p>

        </div>

        @if ($errors->any())
            <div class="alert alert-danger">

                {{ $errors->first() }}

            </div>
        @endif

        <form method="POST" action="/admin/login">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Email

                </label>

                <input type="email" name="email" class="form-control form-control-lg">

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Password

                </label>

                <input type="password" name="password" class="form-control form-control-lg">

            </div>

            <button class="btn btn-primary w-100 btn-login">

                <i class="fa fa-lock me-2"></i>

                Đăng nhập Admin

            </button>

        </form>

    </div>

</body>

</html>
