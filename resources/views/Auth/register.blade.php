<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - EPIM 2026</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
    </style>
</head>
<body>

<div class="box">
    <div class="title">EPIM <span>Register</span></div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" required>
        </div>

        <div style="margin-top:1rem;">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div style="margin-top:1rem;">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div style="margin-top:1rem;">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="btn">Register</button>
    </form>

    <div class="bottom">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link">Login</a>
    </div>
</div>

</body>
</html>