<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('') }}/favicon.ico">
    <title>@yield('Title')</title>
  <link rel="stylesheet" href="{{ asset('dashboard_asset/css/dashlite.css') }}">
<link id="skin-default" rel="stylesheet" href="{{ asset('dashboard_asset/css/theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .blur {
            filter: blur(5px);
        }
    </style>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            @include('components.ComponentDashPeserta.sidebar')
            <div class="nk-wrap ">
                @include('components.ComponentDashPeserta.header')
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            @yield('content')
                        </div>
                    </div>
                </div>
                @include('components.ComponentDashPeserta.footer')
            </div>
            </div>
        </div>
    <script src="{{ asset('dashboard_asset/js/bundle.js') }}"></script>
<script src="{{ asset('dashboard_asset/js/scripts.js') }}"></script>
    @stack('script')

    <script>
        // {{-- 
        //    GANTI DISINI:
        //    1. Jangan pakai View v_tim_lomba karena rusak.
        //    2. Pakai tabel pendaftar (biasanya nama tabelnya 'pendaftars').
        //    3. Pastikan kolom user_id sesuai dengan tabel pendaftars kamu.
        // --}}
        var hasData = @if (\App\Models\Pendaftar::where('user_id', Auth::id())->exists()) true @else false @endif;

        function checkData() {
            if (hasData) {
                window.location.href = "/profile";
            } else {
                alert("Anda belum mendaftarkan tim. Silakan daftarkan tim terlebih dahulu untuk melihat profil.");
            }
        }
    </script>
</body>
</html>