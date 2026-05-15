<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - EPIM 2026</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .login-box {
            width: 400px;
            background: #111;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .title span { color: #F97316; }

        .subtitle {
            font-size: 0.85rem;
            color: #9CA3AF;
            margin-bottom: 2rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            background: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #fff;
            margin-top: 0.5rem;
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 2.8rem;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-35%);
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            padding: 0;
        }

        label {
            font-size: 0.8rem;
            color: #9CA3AF;
        }

        .btn {
            width: 100%;
            margin-top: 1.5rem;
            padding: 0.8rem;
            background: #F97316;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            cursor: pointer;
        }

        .btn:hover {
            background: #EA580C;
        }

        .link {
            font-size: 0.8rem;
            color: #F97316;
            text-decoration: none;
        }

        .bottom {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.8rem;
        }

        .error {
            color: #FCA5A5;
            font-size: 0.78rem;
            display: block;
            margin-top: 0.45rem;
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            padding: 0.85rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="title">EPIM <span>Login</span></div>
    <div class="subtitle">Masuk ke akun kamu</div>

    @if($errors->any())
        <div class="alert">Mohon periksa email dan password kamu.</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top:1rem;">
            <label>Password</label>
            <div class="password-wrap">
                <input id="loginPassword" type="password" name="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('loginPassword', this)" title="Lihat password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="btn">Login</button>
    </form>

    <div class="bottom">
        Belum punya akun?
        <a href="{{ route('register') }}" class="link">Register</a>
    </div>
</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        const visible = input.type === 'text';

        input.type = visible ? 'password' : 'text';
        icon.className = visible ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
        button.title = visible ? 'Lihat password' : 'Sembunyikan password';
    }
</script>

</body>
</html>
