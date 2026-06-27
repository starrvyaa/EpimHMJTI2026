<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template — EPIM JTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --orange: #F97316;
            --orange-dark: #EA580C;
            --dark: #0A0A0A;
            --dark-card: #111111;
            --text-white: #FFFFFF;
            --text-gray: #9CA3AF;
            --border: rgba(255,255,255,0.08);
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text-white);
        }

        /* Navbar */
                .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 3rem;
            height: 65px;
            background: rgba(10,10,10,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .navbar-logo {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px;
            border-color: #ffffff;
        }
        .navbar-logo img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 30px;
            
        }

        .navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-brand-text span:first-child {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            color: #fff;
            line-height: 1.1;
        }

        .navbar-brand-text span:last-child {
            font-size: 0.7rem;
            color: var(--orange);
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .navbar-nav a {
            text-decoration: none;
            color: var(--text-gray);
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .navbar-logo-img {
    height: 40px; /* Atur tinggi gambar */
    width: auto;  /* Lebar otomatis menyesuaikan agar tidak gepeng */
    display: block;
    margin-right: 10px; /* Memberi jarak antara logo dan teks */
}

/* Pastikan container navbar-brand menggunakan flex agar sejajar */
.navbar-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
}
        .navbar-nav a:hover, .navbar-nav a.active {
            color: #fff;
        }
        .btn-login {
            background:transparent; border:1px solid var(--orange); color:var(--orange)!important;
            padding:0.4rem 1.2rem; border-radius:6px; font-size:0.78rem!important; font-weight:600!important;
            transition:background 0.2s,color 0.2s!important;
        }
        .btn-login:hover { background:var(--orange)!important; color:#fff!important; }

        /* Hero kecil */
        .page-hero {
            padding: 120px 0 60px;
            background: radial-gradient(ellipse 60% 50% at 50% 40%, rgba(249,115,22,0.08) 0%, transparent 70%);
            text-align: center;
        }
        .page-hero h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(2rem,4vw,3.5rem);
        }
        .page-hero h1 span { color: var(--orange); }
        .page-hero p { color: var(--text-gray); font-size:0.95rem; margin-top:0.75rem; }

        /* Timeline Download */
        .timeline-section { padding: 40px 0 100px; }
        .timeline-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .tl-vertical-line {
            position: absolute;
            left: 27px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(249,115,22,0.25);
        }
        .tl-item {
            position: relative;
            padding-left: 70px;
            margin-bottom: 2rem;
        }
        .tl-icon {
            position: absolute;
            left: 0;
            top: 6px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            z-index: 1;
            box-shadow: 0 0 0 4px rgba(249,115,22,0.15);
            transition: transform 0.3s;
        }
        .tl-item:hover .tl-icon { transform: scale(1.1); }
        .tl-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: border-color 0.3s;
        }
        .tl-card:hover { border-color: rgba(249,115,22,0.3); }
        .tl-card h3 { font-size:1rem; font-weight:700; margin-bottom:0.2rem; }
        .tl-card p { font-size:0.82rem; color:var(--text-gray); }
        .btn-download {
            flex-shrink:0;
            display:inline-flex; align-items:center; gap:0.5rem;
            background:#2563eb; color:#fff;
            padding:0.6rem 1.2rem; border-radius:8px;
            font-weight:600; font-size:0.82rem; text-decoration:none;
            transition:background 0.2s,transform 0.2s;
        }
        .btn-download:hover { background:#1d4ed8; transform:translateY(-2px); }

        /* Back button */
        .btn-back {
            display:inline-flex; align-items:center; gap:0.5rem;
            color:var(--text-gray); text-decoration:none;
            font-size:0.85rem; font-weight:500;
            margin: 0 0 2rem; transition:color 0.2s;
        }
        .btn-back:hover { color: var(--orange); }

        /* Footer */
        .footer {
            background:#050505; padding:2.5rem 0;
            border-top:1px solid var(--border);
            text-align:center;
        }
        .footer p { color:var(--text-gray); font-size:0.8rem; }

        /* Hamburger */
        .hamburger {
            display:none; flex-direction:column; gap:5px;
            cursor:pointer; background:none; border:none;
        }
        .hamburger span {
            width:24px; height:2px; background:#fff; border-radius:2px; display:block;
            transition:transform 0.3s,opacity 0.3s;
        }
        .nav-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:998; cursor:pointer; }

        @media(max-width:768px) {
            .navbar { padding:0 1.5rem; }
            .navbar-nav { display:none; }
            .hamburger { display:flex; }
            .navbar-nav.open {
                display:flex!important; flex-direction:column; position:fixed; top:0; right:0;
                width:280px; height:100vh; background:#111!important; padding:5rem 2rem 2rem;
                z-index:999; box-shadow:-5px 0 20px rgba(0,0,0,0.5); gap:0.5rem;
            }
            .nav-overlay.open { display:block; }
            .tl-card { flex-direction:column; align-items:flex-start; }
            .tl-card .btn-download { width:100%; justify-content:center; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="navbar-logo">
                <img src="{{ asset('images/maskot2.png') }}" alt="Logo EPIM">
            </div>
            <div class="navbar-brand-text">
                <span>EXPO PEKAN ILMIAH MAHASISWA</span>
                <span>HMJTI 2025-2026</span>
            </div>
        </a>
        <ul class="navbar-nav">
            <li><a href="{{ url('/') }}">BERANDA</a></li>
            <li><a href="{{ url('/') }}#lomba">LOMBA</a></li>
            <li><a href="{{ url('/template') }}" class="active">TEMPLATE</a></li>
            <li><a href="{{ url('/') }}#timeline">TIMELINE</a></li>
            @guest
                <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
            @else
                <li><a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a></li>
            @endguest
        </ul>
        <button class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </button>
    </nav>
    <div class="nav-overlay" id="navOverlay" onclick="closeMobileNav()"></div>

    {{-- HERO --}}
    <section class="page-hero">
        <h1>FILE <span>PENDUKUNG</span></h1>
        <p>Unduh dokumen dan template resmi untuk kelengkapan administrasi lomba</p>
    </section>

    {{-- TIMELINE DOWNLOAD --}}
    <section class="timeline-section">
        <div class="timeline-container">
            <a href="{{ url('/') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>

            <div style="position:relative;">
                <div class="tl-vertical-line"></div>

                @php
                    $driveLink = 'https://drive.google.com/drive/folders/1qsrQK_RA7XW2RPx_U00IVsqosO7ZUsa0?usp=sharinghttps://drive.google.com/drive/folders/1qsrQK_RA7XW2RPx_U00IVsqosO7ZUsa0?usp=sharing';
                    $files = [
                        ['name' => 'Logo EPIM 2026', 'desc' => 'Format PNG & SVG — Resmi'],
                        /* ['name' => 'Template Poster Lomba', 'desc' => 'Canva & PSD editable'], */
                        ['name' => 'Template Proposal', 'desc' => 'DOCX — Format proposal resmi'],
                        ['name' => 'Panduan Teknis Lomba', 'desc' => 'PDF — Buku panduan lengkap'],
                        /* ['name' => 'Form Pendaftaran', 'desc' => 'PDF — Isi & upload kembali'], */
                        ['name' => 'Surat Pernyataan Orisinalitas', 'desc' => 'DOCX — Tanda tangan basah'],
                    ];
                @endphp

                @foreach($files as $file)
                <div class="tl-item">
                    <div class="tl-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="tl-card">
                        <div>
                            <h3>{{ $file['name'] }}</h3>
                            <p>{{ $file['desc'] }}</p>
                        </div>
                        <a href="{{ $driveLink }}" target="_blank" rel="noopener noreferrer" class="btn-download">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="timeline-container">
            <p>&copy; {{ date('Y') }} EPIM HMJTI. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const hamburger = document.getElementById('hamburger');
        const navOverlay = document.getElementById('navOverlay');
        const navbarNav = document.querySelector('.navbar-nav');

        function toggleMobileNav() {
            navbarNav.classList.toggle('open');
            hamburger.classList.toggle('active');
            navOverlay.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        }
        function closeMobileNav() {
            navbarNav.classList.remove('open');
            hamburger.classList.remove('active');
            navOverlay.classList.remove('open');
            document.body.classList.remove('sidebar-open');
        }
        hamburger.addEventListener('click', toggleMobileNav);
    </script>
</body>
</html>
