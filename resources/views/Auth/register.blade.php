<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - EPIM 2026</title>

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

        .box {
            width: 400px;
            background: #111;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .title {
            font-family: 'Montserrat';
            font-weight: 800;
            font-size: 1.8rem;
        }

        .title span { color: #F97316; }

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

        .bottom {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.8rem;
        }

        .link {
            color: #F97316;
            text-decoration: none;
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
            margin: 1rem 0;
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="box">
    <div class="title">EPIM <span>Register</span></div>

    @if($errors->any())
        <div class="alert">Mohon lengkapi data registrasi dengan benar.</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required pattern="^[^<>]+$" title="Tidak boleh berisi tag HTML.">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top:1rem;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top:1rem;">
            <label>Password</label>
            <div class="password-wrap">
                <input id="registerPassword" type="password" name="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('registerPassword', this)" title="Lihat password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top:1rem;">
            <label>Konfirmasi Password</label>
            <div class="password-wrap">
                <input id="registerPasswordConfirmation" type="password" name="password_confirmation" required>
                <button type="button" class="toggle-password" onclick="togglePassword('registerPasswordConfirmation', this)" title="Lihat password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>

        <button class="btn">Register</button>
    </form>

    <div class="bottom">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link">Login</a>
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
