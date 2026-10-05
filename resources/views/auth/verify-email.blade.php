<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập mã xác minh - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f4f6f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1b1f23;
        }

        .verify-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            padding: 40px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
            text-align: center;
        }

        .icon-badge {
            width: 68px;
            height: 68px;
            background: #fff8eb;
            color: #ff9900;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 20px;
            border: 2px solid #ffe8cc;
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        .subtext {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .subtext strong {
            color: #111827;
            word-break: break-all;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            line-height: 1.5;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-info {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .code-input-group {
            margin-bottom: 22px;
        }

        .code-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            text-align: center;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .otp-input {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            display: block;
            padding: 14px;
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            letter-spacing: 12px;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s ease;
            font-family: "Courier New", Courier, monospace;
            background: #fafafa;
        }

        .otp-input:focus {
            background: #ffffff;
            border-color: #ff9900;
            box-shadow: 0 0 0 4px rgba(255, 153, 0, 0.15);
        }

        .btn-primary {
            width: 100%;
            padding: 13px;
            background: #ff9900;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            background: #e88a00;
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .resend-box {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
            font-size: 14px;
            color: #6b7280;
        }

        .btn-link {
            background: none;
            border: none;
            color: #ff9900;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            padding: 4px 6px;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .logout-box {
            margin-top: 14px;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-logout:hover {
            color: #4b5563;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="verify-card">
        <div class="icon-badge">
            <i class="fa-solid fa-envelope-circle-check"></i>
        </div>

        <h1>Nhập mã xác minh</h1>
        <p class="subtext">
            Mã OTP gồm <strong>6 chữ số</strong> đã được gửi tới hòm thư Gmail:<br>
            <strong>{{ Auth::user()->email }}</strong>
        </p>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> {{ session('info') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Form nhập mã xác minh -->
        <form method="POST" action="{{ route('verification.verify_code') }}">
            @csrf

            <div class="code-input-group">
                <label for="code">Nhập mã 6 chữ số</label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    class="otp-input" 
                    maxlength="6" 
                    inputmode="numeric" 
                    pattern="[0-9]*" 
                    placeholder="------" 
                    autocomplete="one-time-code" 
                    required 
                    autofocus
                    value="{{ old('code') }}"
                >
            </div>

            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-check"></i> Xác minh tài khoản
            </button>
        </form>

        <!-- Form gửi lại mã -->
        <div class="resend-box">
            Chưa nhận được mã xác minh? 
            <form method="POST" action="{{ route('verification.resend_code') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-link">Gửi lại mã</button>
            </form>
        </div>

        <!-- Đăng xuất -->
        <div class="logout-box">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng nhập tài khoản khác
                </button>
            </form>
        </div>
    </div>
</body>
</html>
