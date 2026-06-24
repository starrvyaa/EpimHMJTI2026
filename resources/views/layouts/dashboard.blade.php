<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Dashboard - EPIM')</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* === RESET & BASE === */
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex;
            min-height: 100vh;
        }

        /* === SIDEBAR (Desktop) === */
        .sidebar {
            width: 260px;
            background: #111;
            height: 100vh;
            padding: 2rem 1.5rem;
            border-right: 1px solid rgba(255,255,255,0.08);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        .logo {
            font-weight: 800;
            font-family: 'Montserrat', sans-serif;
            color: #F97316;
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            display: block;
            text-decoration: none;
        }
        .menu {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            color: #FFFFFF;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: 0.3s;
        }
        .menu a:hover,
        .menu a.active {
            background: rgba(249,115,22,0.15);
            color: #F97316;
        }
        .logout-form { margin-top: auto; }
        .logout-btn {
            background: none;
            border: none;
            color: #ef4444;
            padding: 0.85rem 1rem;
            text-align: left;
            width: 100%;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
            border-radius: 10px;
        }
        .logout-btn:hover {
            background: rgba(239,68,68,0.1);
        }

        /* === SIDEBAR CLOSE (mobile) === */
        .sidebar-close {
            display: none;
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            color: #9CA3AF;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 51;
            transition: 0.3s;
        }
        .sidebar-close:hover { color: #fff; }

        /* === MAIN CONTAINER === */
        .main-container {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        /* === TOPBAR / HEADER === */
        .topbar {
            height: 70px;
            background: rgba(10,10,10,0.8);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            z-index: 30;
        }
        .topbar h2 {
            font-size: 1.25rem;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
        }
        .user-info {
            color: #fff;
            text-decoration: none;
            margin-right: 1.5rem;
            padding: 0.55rem 0.85rem;
            border-radius: 10px;
            transition: 0.3s;
        }
        .user-info:hover {
            background: rgba(249,115,22,0.12);
        }
        .username { color: #F97316; font-weight: 600; }

        /* === HAMBURGER (hidden desktop) === */
        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.6rem;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 31;
        }

        /* === SIDEBAR OVERLAY === */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
        }
        .sidebar-overlay.open { display: block; }

        body.sidebar-open { overflow: hidden; }

        /* === CONTENT AREA === */
        .content {
            padding: 2.5rem 2rem;
            width: 100%;
        }

        /* === CARD === */
        .card {
            background: #111;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* === SETTINGS OVERRIDE === */
        .settings-card {
            max-width: 600px;
            width: 100%;
        }
        @media (max-width: 768px) {
            .settings-card { max-width: 100%; }
        }

        /* === ALERT === */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            width: 100%;
            max-width: 100%;
            word-break: break-word;
        }

        /* === MODAL === */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px);
            overflow-y: auto;
        }
        .modal-content {
            background: #161616;
            margin: 3rem auto;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.1);
            width: 90%;
            max-width: 600px;
            border-radius: 20px;
        }

        /* === COMMON UTILITIES === */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.85rem;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }
        .btn-orange { background: #F97316; }
        .btn-orange:hover { background: #ea580c; transform: translateY(-2px); }
        .btn-outline { border: 1px solid #374151; color: #9CA3AF; background: transparent; }
        .btn-danger { background: #EF4444; }

        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.6rem; color: #9CA3AF; font-size: 0.85rem; }
        .form-control {
            width: 100%;
            padding: 0.9rem;
            background: #222;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }
        .form-control:focus { border-color: #F97316; }

        .form-error {
            color: #FCA5A5;
            font-size: 0.78rem;
            margin-top: 0.45rem;
            display: block;
        }

        .alert-success {
            background: rgba(16,185,129,0.1);
            color: #10B981;
            border: 1px solid rgba(16,185,129,0.2);
        }
        .alert-danger {
            background: rgba(239,68,68,0.1);
            color: #FCA5A5;
            border: 1px solid rgba(239,68,68,0.2);
        }

        /* === RESPONSIVE: TABLET & MOBILE === */
        @media (max-width: 768px) {
            .hamburger { display: block; }
            .sidebar {
                transform: translateX(-100%);
                width: 75%;
                max-width: 300px;
                background: #111 !important;
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-close { display: block; }
            .main-container { margin-left: 0; }
            .topbar h2 { font-size: 1rem; }
            .content { padding: 1.25rem; }

            .sidebar .menu a,
            .sidebar .logout-btn {
                padding: 1rem 1.25rem;
                font-size: 1rem;
            }

            .modal-content {
                margin: 2rem 1rem;
                padding: 1.5rem;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .content { padding: 0.75rem; }
            .modal-content { margin: 1rem 0.5rem; padding: 1rem; }
            .topbar { padding: 0 1rem; height: 60px; }
            .user-info { margin-right: 0; }
        }

        @yield('extraCss')
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<nav class="sidebar" id="mainSidebar">
    <button class="sidebar-close" onclick="toggleSidebar()" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <a href="{{ route('home') }}" class="logo">EPIM.TI</a>
    <div class="menu">
        <a href="{{ route('dashboard') }}" class="@yield('menuDashboard', '')">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="{{ route('Lomba.peserta.index') }}" class="@yield('menuLomba', '')">
            <i class="fa-solid fa-trophy"></i> Daftar Lomba
        </a>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('Pengaturan.index') }}" class="@yield('menuPengaturan', '')">
            <i class="fa-solid fa-gear"></i> Pengaturan
        </a>
        <a href="{{ route('admin.log.index') }}" class="@yield('menuLog', '')">
            <i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas
        </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="button" class="logout-btn" onclick="openModal('modalLogout')">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</nav>

{{-- ===== MAIN WRAPPER ===== --}}
<div class="main-container" id="mainContainer">

    {{-- ===== TOPBAR ===== --}}
    <header class="topbar">
        <button class="hamburger" onclick="toggleSidebar()" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h2>@yield('pageTitle', 'Dashboard')</h2>
        <a href="{{ route('profile.edit') }}" class="user-info" title="Edit data diri">
            Hello, <span class="username">{{ Auth::user()->name }}</span>
        </a>
    </header>

    {{-- ===== OVERLAY ===== --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ===== PAGE CONTENT ===== --}}
    <main class="content">
        @yield('content')
    </main>

</div>

{{-- ===== MODAL LOGOUT (shared) ===== --}}
<div id="modalLogout" class="modal">
    <div class="modal-content" style="text-align:center; max-width:450px;">
        <i class="fa-solid fa-right-from-bracket" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
        <h3>Yakin ingin keluar?</h3>
        <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6; margin:10px 0 0;">
            Sesi akun kamu akan diakhiri.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalLogout')">Batal</button>
                <button type="submit" class="btn btn-danger" style="flex:1;">Ya, Logout</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== SHARED JAVASCRIPT ===== --}}
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('mainSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
        body.classList.toggle('sidebar-open');
    }

    // Auto-close sidebar on nav link click (mobile only)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sidebar .menu a, .sidebar .logout-btn').forEach(function (el) {
            el.addEventListener('click', function () {
                if (window.innerWidth <= 768) toggleSidebar();
            });
        });
    });

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'block';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }

    window.onclick = function (e) {
        if (e.target.classList && e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    };
</script>

@yield('extraJs')

</body>
</html>
