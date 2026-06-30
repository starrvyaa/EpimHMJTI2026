<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Set New Password - EPIM 2026</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { box-sizing: border-box; }

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

        .reset-box {
            width: min(400px, 100%);
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
            line-height: 1.5;
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
            width: 100%;
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

        .error {
            color: #FCA5A5;
            font-size: 0.78rem;
            display: block;
            margin-top: 0.45rem;
        }

        .alert {
            padding: 0.85rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
    </style>
</head>
<body>

<div class="reset-box">
    <div class="title">New <span>Password</span></div>
    <div class="subtitle">Buat password baru untuk akun kamu.</div>

    @if (session()->has('loginError'))
        <div class="alert alert-danger">
            {{ session('loginError') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ForgotReset.post') }}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label>Password Baru</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>
                <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Lihat password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 1rem;">
            <label>Konfirmasi Password Baru</label>
            <div class="password-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password baru" required>
                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)" title="Lihat password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="btn" type="submit">Ubah Password</button>
    </form>
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
