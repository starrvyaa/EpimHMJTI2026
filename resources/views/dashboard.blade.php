<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EPIM</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex; /* Membuat Sidebar dan Main Container bersampingan */
            min-height: 100vh;
        }

        /* ===== SIDEBAR (Tetap di Kiri) ===== */
        .sidebar {
            width: 260px;
            background: #111;
            height: 100vh;
            padding: 2rem 1.5rem;
            border-right: 1px solid rgba(255,255,255,0.08);
            position: fixed; /* Mengunci sidebar agar tidak ikut scroll */
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-weight: 800;
            font-family: 'Montserrat';
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
            color: #9CA3AF;
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: 0.3s;
        }

        .menu a:hover, .menu a.active {
            background: rgba(249,115,22,0.15);
            color: #F97316;
        }

        /* ===== MAIN CONTAINER (Area Sebelah Sidebar) ===== */
        .main-container {
            flex: 1;
            margin-left: 260px; /* Jarak pas selebar sidebar agar tidak tumpuk */
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR (Navigasi Atas) ===== */
        .topbar {
            height: 70px;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            position: sticky; /* Tetap di atas saat scroll */
            top: 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            z-index: 90;
        }

        .topbar h2 { font-size: 1.25rem; margin: 0; font-family: 'Montserrat'; }
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

        /* ===== CONTENT AREA ===== */
        .content {
            padding: 2.5rem 2rem;
        }

        /* ===== CARD GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: #111;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.08);
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: #F97316;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .card.orange {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            color: #fff;
            border: none;
        }

        .card h3 {
            font-family: 'Montserrat';
            margin: 0 0 1rem 0;
            font-size: 1.4rem;
        }

        .card p {
            font-size: 0.9rem;
            color: #9CA3AF;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .card.orange p { color: rgba(255,255,255,0.9); }

        /* ===== BUTTONS ===== */
        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            text-align: center;
            flex: 1;
        }

        /* Tombol untuk kartu Hitam */
        .btn-outline {
            border: 1px solid #F97316;
            color: #F97316;
        }
        .btn-outline:hover {
            background: #F97316;
            color: #fff;
        }

        /* Tombol untuk kartu Orange */
        .btn-white {
            background: #fff;
            color: #F97316;
        }
        .btn-white:hover {
            background: #f3f4f6;
        }

        /* Logout khusus */
        .logout-form {
            margin-top: auto;
        }

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
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <a href="#" class="logo">EPIM.TI</a>

    <div class="menu">
        <a href="#" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="/lomba" class="bg-orange-500 ..."><i class="fa-solid fa-trophy"></i> Daftar Lomba</a>
        
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="main-container">
    
    <header class="topbar">
        <h2>Dashboard Overview</h2>
        <a href="{{ route('profile.edit') }}" class="user-info" title="Edit data diri">
            Hello, <span class="username">{{ Auth::user()->name }}</span>
        </a>
    </header>

    <main class="content">
        <div class="grid">

            <div class="card orange">
                <div>
                    <h3>Web Programming</h3>
                    <p>Front-end web programming fokus pada pembuatan tampilan menarik, responsif, dan performa tinggi.</p>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn btn-white">Selengkapnya</a>
                    <a href="#" class="btn btn-white">Guidebook</a>
                </div>
            </div>

            <div class="card">
                <div>
                    <h3>Design Packaging</h3>
                    <p>Desain kemasan kreatif untuk meningkatkan nilai jual produk dan memperkuat branding identitas.</p>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn btn-outline">Selengkapnya</a>
                    <a href="#" class="btn btn-outline">Guidebook</a>
                </div>
            </div>

            <div class="card orange">
                <div>
                    <h3>Design Poster</h3>
                    <p>Poster visual yang kuat untuk menyampaikan pesan secara instan dan menarik perhatian audiens.</p>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn btn-white">Selengkapnya</a>
                    <a href="#" class="btn btn-white">Guidebook</a>
                </div>
            </div>

            <div class="card">
                <div>
                    <h3>Videography</h3>
                    <p>Pembuatan karya video cinematic dengan teknik storytelling visual yang mendalam.</p>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn btn-outline">Selengkapnya</a>
                    <a href="#" class="btn btn-outline">Guidebook</a>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>
