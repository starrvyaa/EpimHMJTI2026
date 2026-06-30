<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password - EPIM 2026</title>

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

        .forgot-box {
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
            font-weight: 500;
        }

        .bottom {
            margin-top: 1.5rem;
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
            padding: 0.85rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #A7F3D0;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
    </style>
</head>
<body>

<div class="forgot-box">
    <div class="title">EPIM <span>Recovery</span></div>
    <div class="subtitle">Kami akan mengirimkan link ke email kamu untuk mengatur ulang password.</div>

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif 

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('Forgot.auth') }}" method="POST" autocomplete="off">
        @csrf
        <div>
            <label for="email-address">Email Terdaftar</label>
            <input type="email" name="email" id="email-address" value="{{ old('email') }}" required placeholder="Masukkan email kamu">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="btn" type="submit">Kirim Link Reset</button>
    </form>

    <div class="bottom">
        <a href="{{ route('login') }}" class="link">
            <i class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Kembali ke Login
        </a>
    </div>
</div>

</body>
</html>