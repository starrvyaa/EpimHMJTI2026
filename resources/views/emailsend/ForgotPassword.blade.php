<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - EPIM 2026</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #0A0A0A;
            color: #FFFFFF;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        .email-wrapper {
            width: 100%;
            background-color: #0A0A0A;
            padding: 40px 10px;
            box-sizing: border-box;
        }
        .email-card {
            max-width: 500px;
            margin: 0 auto;
            background-color: #111111;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .email-header {
            background-color: #111111;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .email-header img {
            width: 80px;
            height: auto;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-title {
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 20px;
            color: #FFFFFF;
            text-align: center;
        }
        .email-title span {
            color: #F97316;
        }
        .email-text {
            font-size: 15px;
            line-height: 1.6;
            color: #9CA3AF;
            margin-bottom: 30px;
        }
        .btn-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-reset {
            display: inline-block;
            padding: 14px 30px;
            background-color: #F97316;
            color: #FFFFFF !important;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
            transition: background-color 0.2s;
        }
        .btn-reset:hover {
            background-color: #EA580C;
        }
        .email-footer {
            padding: 30px;
            background-color: #0d0d0d;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
        .email-footer a {
            color: #F97316;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            <!-- Header Logo -->
            <div class="email-header">
                <img src="https://i.ibb.co.com/84xTmdy/LogoEPIM.png" alt="Logo EPIM 2026">
            </div>

            <!-- Body -->
            <div class="email-body">
                <h1 class="email-title">Reset Kata Sandi <span>EPIM 2026</span></h1>
                <p class="email-text">
                    Halo,<br><br>
                    Kami menerima permintaan untuk mereset kata sandi akun Anda di portal pendaftaran **EXPO PEKAN ILMIAH MAHASISWA (EPIM) 2026**.
                    Silakan klik tombol di bawah ini untuk mengatur ulang kata sandi Anda:
                </p>
                
                <div class="btn-wrapper">
                    <a href="{{ route('Forgot.reset', ['token' => $token]) }}" class="btn-reset" target="_blank">Reset Password</a>
                </div>

                <p class="email-text" style="font-size: 13px; margin-bottom: 0;">
                    *Jika tombol di atas tidak berfungsi, Anda juga dapat menyalin dan menempelkan tautan berikut ke browser Anda:*<br>
                    <a href="{{ route('Forgot.reset', ['token' => $token]) }}" style="color: #F97316; word-break: break-all;">
                        {{ route('Forgot.reset', ['token' => $token]) }}
                    </a>
                </p>
                <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.05); margin: 30px 0;">
                <p class="email-text" style="font-size: 13px; margin-bottom: 0;">
                    Jika Anda tidak meminta pengaturan ulang kata sandi ini, abaikan saja email ini. Akun Anda akan tetap aman.
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>© 2026 EXPO PEKAN ILMIAH MAHASISWA - HMJTI Polije</p>
                <p>Jl. Mastrip No 164, Lingkungan Panji, Tegalgede, Sumbersari, Jember</p>
            </div>
        </div>
    </div>
</body>
</html>
