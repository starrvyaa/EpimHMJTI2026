<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPO PEKAN ILMIAH MAHASISWA - HMJTI 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --orange: #F97316;
            --orange-dark: #EA580C;
            --dark: #0A0A0A;
            --dark-card: #111111;
            --dark-navy: #0F172A;
            --dark-section: #111827;
            --text-white: #FFFFFF;
            --text-gray: #9CA3AF;
            --border: rgba(255,255,255,0.08);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dark);
            color: var(--text-white);
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
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
            background: transparent;
            border: 1px solid var(--orange);
            color: var(--orange) !important;
            padding: 0.4rem 1.2rem;
            border-radius: 6px;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.08em;
            transition: background 0.2s, color 0.2s !important;
        }

        .btn-login:hover {
            background: var(--orange) !important;
            color: #fff !important;
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 65px;
            background: radial-gradient(ellipse 70% 60% at 60% 50%, rgba(249,115,22,0.08) 0%, transparent 70%),
                        radial-gradient(ellipse 40% 40% at 20% 80%, rgba(249,115,22,0.05) 0%, transparent 60%),
                        var(--dark);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 380px;
            height: 380px;
            border: 1.5px solid rgba(249,115,22,0.15);
            border-radius: 50%;
            top: 15%;
            right: 12%;
            pointer-events: none;
            animation: pulseRing 4s ease-in-out infinite;
        }

        .hero-diamond {
            position: absolute;
            width: 110px;
            height: 110px;
            border: 1.5px solid rgba(249,115,22,0.2);
            transform: rotate(45deg);
            bottom: 22%;
            left: 35%;
            pointer-events: none;
        }

        @keyframes pulseRing {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.04); opacity: 1; }
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 4rem;
            width: 100%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(249,115,22,0.12);
            border: 1px solid rgba(249,115,22,0.3);
            color: var(--orange);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .hero-badge i { font-size: 0.65rem; }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(3rem, 5vw, 4.5rem);
            line-height: 1.0;
            margin-bottom: 1.5rem;
        }

        .hero-title .line-orange { color: var(--orange); }
        .hero-title .line-dash {
            color: var(--text-gray);
            font-size: 0.7em;
        }

        .hero-desc {
            color: var(--text-gray);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 480px;
        }

        .hero-desc strong { color: var(--orange); font-weight: 600; }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--orange);
            color: #fff;
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.03em;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s, transform 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--orange-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: #fff;
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1.5px solid rgba(255,255,255,0.25);
            transition: border-color 0.2s, transform 0.2s;
        }

        .btn-outline:hover {
            border-color: var(--orange);
            color: var(--orange);
            transform: translateY(-2px);
        }

        .hero-image-wrap {
            position: relative;
        }

        /* Hero slider */
        .hero-slider-container {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            max-width: 520px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }

        .hero-slider-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .hero-slide-item {
            min-width: 100%;
            height: 360px;
            flex-shrink: 0;
            background: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-slide-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hero-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50%;
            color: #fff;
            font-size: 0.85rem;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s, border-color 0.3s;
            opacity: 0;
        }

        .hero-slider-container:hover .hero-slider-btn {
            opacity: 1;
        }

        .hero-slider-btn:hover {
            background: var(--orange);
            border-color: var(--orange);
        }

        .hero-slider-btn-prev { left: 12px; }
        .hero-slider-btn-next { right: 12px; }

        .hero-slider-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .hero-slider-dots .hdot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .hero-slider-dots .hdot.active {
            background: var(--orange);
            transform: scale(1.3);
        }

        .hero-img-placeholder {
            width: 100%;
            max-width: 520px;
            height: 360px;
            border-radius: 18px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background: var(--orange);
            padding: 1rem 0;
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.8);
        }

        /* ===== ABOUT SECTION ===== */
        .about {
            padding: 6rem 0;
            background: var(--dark);
        }

        .about-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .about-img {
            width: 100%;
            height: 340px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .about-img-placeholder {
            width: 100%;
            height: 340px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1c1c1e, #2a2a2e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
        }

        .section-eyebrow {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--orange);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-eyebrow i { font-size: 0.65rem; }

        .about-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.2rem;
        }

        .about-title span { color: var(--orange); }

        .about-desc {
            color: var(--text-gray);
            font-size: 0.9rem;
            line-height: 1.75;
            margin-bottom: 1.5rem;
        }

        .about-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .about-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #e5e7eb;
        }

        .about-list li .bullet {
            width: 22px;
            height: 22px;
            background: var(--orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.6rem;
        }

        /* ===== BENEFITS ===== */
        .benefits {
            padding: 6rem 0;
            background: var(--dark-section);
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-eyebrow-center {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            color: var(--orange);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-eyebrow-center::before,
        .section-eyebrow-center::after {
            content: '';
            flex: 1;
            max-width: 60px;
            height: 1px;
            background: var(--orange);
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .section-title span { color: var(--orange); }

        .section-subtitle {
            color: var(--text-gray);
            font-size: 0.9rem;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .benefits-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .benefit-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            transition: border-color 0.3s, transform 0.3s;
        }

        .benefit-card:hover {
            border-color: rgba(249,115,22,0.4);
            transform: translateY(-4px);
        }

        .benefit-icon {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            display: block;
        }

        .benefit-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.6rem;
        }

        .benefit-desc {
            color: var(--text-gray);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        /* ===== LOMBA SECTION ===== */
        .lomba {
            padding: 6rem 0;
            background: var(--dark);
        }

        .lomba-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
        }

        .lomba-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .lomba-card {
            background: #0f0f0f;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            transition: transform 0.3s, border-color 0.3s;
        }

        .lomba-card:hover {
            transform: translateY(-6px);
            border-color: rgba(249,115,22,0.4);
        }

        .lomba-card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            position: relative;
        }

        .lomba-card-img-wrap {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .lomba-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lomba-card-img-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .lomba-card-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 42px;
            height: 42px;
            background: var(--orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .lomba-card-body {
            padding: 1.5rem;
        }

        .lomba-card-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .lomba-tag {
            display: inline-block;
            padding: 0.2rem 0.7rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .lomba-tag.design { background: rgba(249,115,22,0.15); color: var(--orange); border: 1px solid rgba(249,115,22,0.3); }

        .lomba-card-desc {
            color: var(--text-gray);
            font-size: 0.85rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .lomba-deadline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-gray);
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .lomba-deadline i { color: var(--orange); }
        .lomba-deadline strong { color: var(--orange); }

        .lomba-prize {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(249,115,22,0.15);
            color: var(--orange);
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.88rem;
            margin-bottom: 1.25rem;
        }

        .lomba-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-detail {
            flex: 1;
            background: var(--orange);
            color: #fff;
            text-align: center;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-detail:hover { background: var(--orange-dark); }

        .btn-daftar {
            flex: 1;
            background: transparent;
            color: var(--orange);
            text-align: center;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1.5px solid var(--orange);
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .btn-daftar:hover { background: var(--orange); color: #fff; }

       /* ===== TIMELINE SIMETRIS V2 ===== */
.timeline {
    padding: 6rem 0;
    background: var(--dark);
}

/* Tab Buttons */
.timeline-tabs {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3.5rem;
    flex-wrap: wrap; /* Supaya aman di mobile jika tab banyak */
}

.timeline-tab {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    color: var(--text-gray, #94a3b8);
    padding: 0.75rem 1.75rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.timeline-tab:hover, .timeline-tab.active {
    background: var(--orange, #ea580c);
    color: #fff;
    border-color: var(--orange, #ea580c);
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2);
    transform: translateY(-2px);
}

/* Content Animation */
.timeline-content {
    display: none;
}
.timeline-content.active {
    display: block;
    animation: fadeIn 0.5s ease-in-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.timeline-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.timeline-list {
    display: flex;
    flex-direction: column;
    position: relative;
}

/* Garis Tengah Mobile (Lurus Pas ditengah Bulatan) */
.timeline-list::before {
    content: '';
    position: absolute;
    left: 29px; /* Setengah dari Lebar Ikon 58px */
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(255,255,255,0.1);
    z-index: 0;
}

.timeline-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 0;
    width: 100%;
}

.tl-icon-wrap {
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 2;
}

.tl-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #27272a;
    border: 3px solid #09090b; /* Sesuaikan dengan warna background utama website Anda */
    color: #fff;
    z-index: 2;
}

.tl-year-text {
    font-size: 11px;
    font-weight: 800;
    color: #a1a1aa;
}

/* Pewarnaan Status yang Jelas */
.tl-icon.done { background: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.3); }
.tl-icon.active { background: var(--orange, #ea580c); box-shadow: 0 0 15px rgba(234, 88, 12, 0.4); }
.tl-icon.upcoming { background: #64748b; }

.tl-card-side {
    flex: 1;
    z-index: 1;
}

.tl-card {
    width: 100%;
    background: rgba(255,255,255,0.02);
    border: 1px solid var(--border, rgba(255,255,255,0.08));
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
}

.tl-card:hover {
    transform: translateY(-3px);
    border-color: var(--orange, #ea580c);
    background: rgba(255,255,255,0.04);
}

.tl-card-header {
    background: linear-gradient(90deg, #1e3a8a, #3b82f6);
    color: #fff;
    padding: 0.65rem 1.25rem;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.tl-card-header.last {
    background: linear-gradient(90deg, #991b1b, #ef4444);
}

.tl-card-body {
    padding: 1.25rem;
    color: #fff;
}

/* Judul khusus mobile */
.tl-mobile-title {
    display: block;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    line-height: 1.4;
}

.tl-mobile-desc {
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    font-size: 0.825rem;
    color: var(--text-gray, #94a3b8);
    margin-top: 0.5rem;
    line-height: 1.5;
}

.tl-text-side { display: none; }
.tl-card-body { display: block; padding: 1.25rem; }
/* ===== BREAKPOINT DESKTOP (MIN-WIDTH: 769px) ===== */
@media (min-width: 769px) {
    .timeline-list::before {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        display: grid;
        grid-template-columns: 1fr 58px 1fr;
        gap: 3rem;
        align-items: center;
        padding: 2rem 0;
    }
    
    .tl-icon-wrap {
        grid-column: 2;
        justify-self: center;
    }
    
    .tl-text-side {
        display: block; /* Muncul di desktop */
    }
    
    .tl-mobile-title {
        display: none; /* Di dalam card tidak perlu judul lagi */
    }
    
    .tl-mobile-desc {
        margin-top: 0; /* Merapikan isi deskripsi di dalam card */
    }

    .tl-text-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .tl-text-desc {
        font-size: 0.875rem;
        color: var(--text-gray, #94a3b8);
        line-height: 1.6;
        max-width: 360px;
    }

    /* ITEM GANJIL: Teks Kiri, Card Kanan */
    .timeline-item:nth-child(odd) .tl-text-side {
        grid-column: 1;
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    .timeline-item:nth-child(odd) .tl-card-side {
        grid-column: 3;
        display: flex;
        justify-content: flex-start;
    }

    /* ITEM GENAP: Card Kiri, Teks Kanan */
    .timeline-item:nth-child(even) .tl-card-side {
        grid-column: 1;
        display: flex;
        justify-content: flex-end;
    }
    .timeline-item:nth-child(even) .tl-text-side {
        grid-column: 3;
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .tl-card {
        max-width: 400px; /* Batasi lebar card agar tidak terlalu mulur di layar besar */
    }
}

        /* ===== FOOTER ===== */
        .footer {
            background: #050505;
            padding: 4rem 0 2rem;
            border-top: 1px solid var(--border);
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr;
            gap: 4rem;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .footer-logo {
            max-width: 70px;
            height: 70px;
        }

        .footer-logo img{
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .footer-brand-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: var(--orange);
            line-height: 1.2;
        }

        .footer-brand-sub {
            font-size: 0.7rem;
            color: var(--text-gray);
        }

        .footer-desc {
            color: var(--text-gray);
            font-size: 0.85rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-social {
            display: flex;
            gap: 0.75rem;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 0.85rem;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .footer-social a:hover {
            background: var(--orange);
            color: #fff;
            border-color: var(--orange);
        }

        .footer-col-title {
            display: inline-flex;
            align-items: center;
            background: var(--orange);
            color: #fff;
            padding: 0.35rem 1rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            margin-bottom: 1.25rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .footer-links a {
            text-decoration: none;
            color: var(--text-gray);
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--orange); }

        .footer-contact-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            margin-bottom: 1rem;
        }

        .footer-contact-item a {
            color: var(--orange);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .footer-contact-addr {
            color: var(--text-gray);
            font-size: 0.82rem;
            line-height: 1.6;
        }

        .footer-btn-app {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text-gray);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
            margin-top: 0.5rem;
        }

        .footer-btn-app:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 2.5rem auto 0;
            padding: 1.5rem 3rem 0;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-bottom p {
            color: var(--text-gray);
            font-size: 0.8rem;
        }

        /* ===== HAMBURGER (mobile) ===== */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
        }

        .hamburger span {
            width: 24px;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            display: block;
            transition: transform 0.3s, opacity 0.3s;
        }
        .hamburger.active span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ===== GALLERY SLIDER ===== */
        .gallery-slider {
            padding: 5rem 0;
            background: var(--dark);
        }

        .slider-section-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 3rem;
        }

        .slider-container {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            margin-top: 2.5rem;
        }

        .slider-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide-item {
            min-width: 100%;
            height: 380px;
            flex-shrink: 0;
            padding: 0 40px;
        }

        .slide-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .slide-item {
                height: 240px;
                padding: 0 12px;
            }
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50%;
            color: #fff;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s, border-color 0.3s;
        }

        .slider-btn:hover {
            background: var(--orange);
            border-color: var(--orange);
        }

        .slider-btn-prev { left: 16px; }
        .slider-btn-next { right: 16px; }

        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 1.5rem;
        }

        .slider-dots .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .slider-dots .dot.active {
            background: var(--orange);
            transform: scale(1.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .hero-inner { grid-template-columns: 1fr; gap: 2.5rem; }
            .hero-image-wrap { display: none; }
            .about-inner { grid-template-columns: 1fr; }
            .about-img-placeholder { display: none; }
            .lomba-grid { grid-template-columns: 1fr; }
            .benefits-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-inner { grid-template-columns: 1fr 1fr; gap: 2.5rem; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
        }
        /* ===== HERO SLIDER REVISED ===== */
        .hero-slider-container {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            max-width: 520px;
            width: 100%;
            /* Menggunakan aspect-ratio agar proporsi slider otomatis rapi di semua ukuran layar */
            aspect-ratio: 4 / 3; 
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
            border: 1px solid var(--border);
            background: var(--dark-card);
        }

        .hero-slider-track {
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-slide-item {
            min-width: 100%;
            width: 100%;
            height: 100%;
            flex-shrink: 0;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-slide-item img {
            width: 100%;
            height: 100%;
            /* Mengubah contain menjadi cover agar gambar mengisi penuh ruang slider tanpa merusak rasio */
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }

        /* Efek hover opsional untuk mempercantik tampilan */
        .hero-slider-container:hover .hero-slide-item img {
            transform: scale(1.03);
        }

        @media (max-width: 768px) {
            .navbar { padding: 0 1.5rem; }
            .navbar-nav { display: none; }
            .hamburger { display: flex; }
            .hero-inner, .about-inner, .lomba-inner, .slider-section-inner, .timeline-inner, .footer-inner { padding: 0 1.5rem; }
            .benefits-grid { padding: 0 1.5rem; }
            .stats-inner { padding: 0 1.5rem; grid-template-columns: repeat(2, 1fr); }
            .benefits-grid { grid-template-columns: 1fr; }
            .footer-inner { grid-template-columns: 1fr; gap: 2rem; }
            .slider-btn { width: 36px; height: 36px; font-size: 0.9rem; }
            .hero-slide-item { height: 250px; }
            
        }

        /* mobile menu overlay */
        .nav-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 998;
            cursor: pointer;
        }
        .nav-overlay.open { display: block; }

        /* mobile menu */
        .navbar-nav.open {
            display: flex !important;
            flex-direction: column;
            position: fixed;
            top: 0;
            right: 0;
            width: 280px;
            height: 100vh;
            background: #111 !important;
            padding: 5rem 2rem 2rem;
            z-index: 999;
            box-shadow: -5px 0 20px rgba(0,0,0,0.5);
            gap: 0.5rem;
            pointer-events: auto;
        }
        .navbar-nav.open a {
            font-size: 0.9rem;
            padding: 0.75rem 0;
            display: block;
            position: relative;
            z-index: 1;
            pointer-events: auto;
        }
        .navbar-nav.open a:hover { color: #fff; }
        .navbar-nav.open .btn-login { margin-top: 1rem; text-align: center; }
        body.sidebar-open { overflow: hidden; }

        /* Fade in animation */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.7s forwards;
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-up:nth-child(1) { animation-delay: 0.1s; }
        .fade-up:nth-child(2) { animation-delay: 0.2s; }
        .fade-up:nth-child(3) { animation-delay: 0.3s; }
        .fade-up:nth-child(4) { animation-delay: 0.4s; }
        .fade-up:nth-child(5) { animation-delay: 0.5s; }
        .fade-up:nth-child(6) { animation-delay: 0.6s; }

        /* ===== MODAL DETAIL LOMBA ===== */
        .wmodal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
        }
        .wmodal-content {
            background-color: #111;
            margin: auto;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.08);
            width: 90%;
            max-width: 600px;
            border-radius: 16px;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
            color: #fff;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .wmodal-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            color: #9CA3AF;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }
        .wmodal-close:hover { color: #fff; }
        .wmodal-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--orange);
            margin-bottom: 1rem;
        }
        .wmodal-body {
            line-height: 1.6;
            font-size: 0.92rem;
            color: #d1d5db;
        }
        .wmodal-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 1.5rem 0;
            background: #1a1a1a;
            padding: 1.2rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.03);
        }
        .wmodal-info-item label {
            display: block;
            font-size: 0.72rem;
            text-transform: uppercase;
            color: #6B7280;
            margin-bottom: 4px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .wmodal-info-item span {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }
        .wmodal-actions {
            display: flex;
            gap: 12px;
            margin-top: 2rem;
        }
        .wmodal-actions .btn {
            flex: 1;
            padding: 0.8rem;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: 0.2s;
        }
        .wmodal-actions .btn-close {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.15);
        }
        .wmodal-actions .btn-close:hover {
            border-color: rgba(255,255,255,0.4);
        }
        .wmodal-actions .btn-daftar {
            background: var(--orange);
            color: #fff;
            border: none;
            display: inline-block;
        }
        .wmodal-actions .btn-daftar:hover {
            background: var(--orange-dark);
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
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
            <li><a href="#beranda" class="active">BERANDA</a></li>
  <li><a href="#lomba">LOMBA</a></li>
            <li><a href="{{ url('/template') }}">TEMPLATE</a></li>
            <li><a href="#timeline">TIMELINE</a></li>
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

    {{-- ===== HERO ===== --}}
    <section class="hero" id="beranda">
        <div class="hero-diamond"></div>
        <div class="hero-inner">
            <div class="hero-content">
                <div class="hero-badge fade-up">
                    <i class="fas fa-bolt"></i>
                    EVENT TAHUNAN HMJTI
                    <i class="fas fa-bolt"></i>
                </div>
                <h1 class="hero-title fade-up">
                    EXPO<br>
                    PEKAN<span class="line-orange"></span><br>
                    <span class="line-orange">ILMIAH</span><br>
                    <span class="line-dash"></span>MAHASISWA
                </h1>
                <p class="hero-desc fade-up">
                    Ajang kompetisi tahunan untuk mahasiswa se-Indonesia yang menampilkan
                    <strong>kreativitas</strong> dan <strong>inovasi</strong> di bidang teknologi informasi dan desain.
                </p>
                <div class="hero-actions fade-up">
                    <a href="#lomba" class="btn-primary">
                        LIHAT LOMBA <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ url('/lomba') }}" class="btn-outline">
                        SUBMIT KARYA
                    </a>
                    {{-- <a href="https://drive.google.com/drive/folders/1x07zL_FzBVwIIwEdqBpsiQXYE9ODxItl" target="_blank" rel="noopener noreferrer" class="btn-outline" style="border-color:var(--orange);color:var(--orange);">
                        <i class="fas fa-download"></i> GUIDEBOOK
                    </a> --}}
                </div>
            </div>
            <div class="hero-image-wrap fade-up">
                <div class="hero-slider-container">
                    <div class="hero-slider-track" id="heroSliderTrack">
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/image.png') }}" alt="EPIM 1">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/DSC02634.avif') }}" alt="EPIM 2">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/DSC02839.avif') }}" alt="EPIM 3">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/DSC02847.avif') }}" alt="EPIM 4">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/DSC02852.avif') }}" alt="EPIM 5">
                        </div>
                    </div>
                    <button class="hero-slider-btn hero-slider-btn-prev" id="heroSliderPrev"><i class="fas fa-chevron-left"></i></button>
                    <button class="hero-slider-btn hero-slider-btn-next" id="heroSliderNext"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="hero-slider-dots" id="heroSliderDots"></div>
            </div>
        </div>
    </section>

    {{-- ===== STATS BAR ===== --}}
    <section class="stats-bar" id="statsBar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <span class="stat-value" data-target="4" data-suffix="">0</span>
                <span class="stat-label">Kategori Lomba</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <span class="stat-value" data-target="600" data-suffix="+">0</span>
                <span class="stat-label">Peserta</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-award"></i></div>
                <span class="stat-value" data-target="20" data-suffix="Jt">0</span>
                <span class="stat-label">Total Hadiah</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <span class="stat-value" data-target="6" data-suffix="">0</span>
                <span class="stat-label">Hari Lagi</span>
            </div>
        </div>
    </section>

    {{-- ===== ABOUT ===== --}}
    <section class="about" id="tentang">
        <div class="about-inner">
            <div>
                {{-- Ganti src dengan gambar yang sesuai --}}
                <img
                    src="{{ asset('images/epim.png') }}"
                    alt="Tentang EPIM"
                    class="about-img"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >
                <div class="about-img-placeholder" style="display:none;">...</div>
            </div>
            <div>
                <div class="section-eyebrow">
                    <i class="fas fa-bolt"></i> TENTANG EVENT
                </div>
                <h2 class="about-title">
                    <span>EPIM2026 ?</span><br>
                    Mengapa Harus Ikut
                </h2>
                <p class="about-desc">
                    <strong>EXPO PEKAN ILMIAH MAHASISWA</strong> adalah ajang kompetisi bergengsi
                    yang telah diselenggarakan selama bertahun-tahun oleh HMJTI. Event ini
                    memberikan kesempatan bagi mahasiswa untuk menunjukkan kemampuan,
                    bersaing dengan mahasiswa terbaik se-Indonesia, dan memenangkan hadiah
                    total puluhan juta rupiah.
                </p>
                <ul class="about-list">
                    <li>
                        <span class="bullet">✓</span>
                        Kompetisi berkualitas dengan juri profesional
                    </li>
                    <li>
                        <span class="bullet">✓</span>
                        Sertifikat peserta &amp; pemenang
                    </li>
                    <li>
                        <span class="bullet">✓</span>
                        Networking dengan mahasiswa se-Indonesia
                    </li>
                    <li>
                        <span class="bullet">✓</span>
                        Pengalaman kompetisi nasional
                    </li>
                </ul>
            </div>
        </div>
    </section>

@php
    // 1. Definisikan array data langsung di dalam Blade
    $timelineUmum = [
        [
            "title" => "Launching EPIM 2026",
            "subtitle" => "Pembukaan resmi kompetisi.",
            "date" => "28 JUNI 2026",
            "cardTitle" => "Launching EPIM 2026",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Tahap Pendaftaran",
            "subtitle" => "Pendaftaran dan Submit Proposal",
            "date" => "28 JUNI - 8 AGUSTUS 2026",
            "cardTitle" => "Pendaftaran dan Submit Proposal",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Batas Akhir Submit Proposal/Karya",
            "subtitle" => "Batas akhir penyerahan proposal/karya tim.",
            "date" => "8 Agustus 2026",
            "cardTitle" => "Batas Akhir Submit Proposal/Karya",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Pengumuman Finalis",
            "subtitle" => "Tim yang lolos menuju Polije.",
            "date" => "12 AGUSTUS 2026",
            "cardTitle" => "Pengumuman Finalis",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Technical Meeting Finalis",
            "subtitle" => "Technical Meeting Finalis",
            "date" => "13 AGUSTUS 2026",
            "cardTitle" => "Technical Meeting Finalis",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Final Lomba",
            "subtitle" => "Pelaksanaan Final Lomba",
            "date" => "19 AGUSTUS 2026",
            "cardTitle" => "Pelaksanaan Final Lomba",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Puncak Acara",
            "subtitle" => "Berlokasi di kampus Politeknik Negeri Jember",
            "date" => "20 Agustus 2026",
            "cardTitle" => "Pelaksanaan Lomba (Onsite dan Online)",
            "cardSubtitle" => "Berlokasi Di Politeknik Negeri Jember",
            "year" => "🏆",
            "isHighlight" => true
        ]
    ];

    $timelineVideography = [
        [
            "title" => "Pendaftaran",
            "subtitle" => "Registrasi akun dan pengisian data peserta videography.",
            "date" => "28 JUNI - 8 AGUSTUS 2026",
            "cardTitle" => "Pendaftaran Lomba Videography",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Pengumpulan Karya",
            "subtitle" => "Batas akhir pengumpulan karya video kreatif.",
            "date" => "28 JUNI - 8 AGUSTUS 2026",
            "cardTitle" => "Pengumpulan Karya Video",
            "cardSubtitle" => "Video dikumpulkan via tautan Google Drive",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Pengumuman Juara",
            "subtitle" => "Penilaian karya oleh juri profesional dan pengumuman pemenang.",
            "date" => "19 AGUSTUS 2026",
            "cardTitle" => "Pengumuman Juara Lomba Videography",
            "cardSubtitle" => "",
            "year" => "2026",
            "isHighlight" => false
        ],
        [
            "title" => "Puncak Acara",
            "subtitle" => "Puncak acara EPIM 2026 dan pembagian hadiah bagi para juara.",
            "date" => "20 AGUSTUS 2026",
            "cardTitle" => "Puncak Acara & Pembagian Hadiah",
            "cardSubtitle" => "Berlokasi di Kampus Politeknik Negeri Jember",
            "year" => "🏆",
            "isHighlight" => true
        ]
    ];
@endphp

<section id="timeline" style="background-color: var(--dark);" class="font-sans antialiased text-gray-800">

  <div class="max-w-6xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">TIMELINE <span style="color: var(--orange);">KEGIATAN</span></h1>
      <div class="mt-3 border-t-4 border-orange-600 w-16 mx-auto rounded-full mb-8"></div>
    </div>

    <!-- Timeline Tab Buttons -->
    <div class="timeline-tabs">
      <button class="timeline-tab active" data-target="umum">
        <i class="fas fa-calendar-alt"></i> UMUM / KATEGORI LAIN
      </button>
      <button class="timeline-tab" data-target="videography">
        <i class="fas fa-video"></i> VIDEOGRAPHY
      </button>
    </div>

    <!-- Timeline Content: UMUM -->
    <div class="timeline-content active" id="timeline-umum">
      <div class="relative">
        <div class="absolute inset-0 flex justify-center pointer-events-none">
          <div class="w-0.5 bg-gray-200 h-full"></div>
        </div>
        
        @foreach($timelineUmum as $item)
          @php
            // Mengatur posisi otomatis zig-zag: Genap di Kiri, Ganjil di Kanan
            $isLeft = $loop->index % 2 === 0;
          @endphp

          <div class="relative grid grid-cols-[1fr,auto,1fr] gap-x-4 md:gap-x-8 items-center min-h-[150px] {{ $item['isHighlight'] ? 'mt-8' : 'mt-4' }}">
            
            <div class="{{ $isLeft ? 'text-right' : 'text-left order-3' }}">
              <h2 class="text-lg md:text-xl font-bold {{ $item['isHighlight'] ? 'text-red-600 text-2xl' : 'text-white' }}">
                {{ $item['title'] }}
              </h2>
              <p class="text-xs md:text-sm text-white mt-1">{{ $item['subtitle'] }}</p>
            </div>

            <div class="relative flex items-center justify-center z-10 order-2">
              @php
                $badgeColor = $item['isHighlight'] ? 'bg-yellow-500' : ($loop->first ? 'bg-red-600' : 'bg-orange-500');
              @endphp
              <div class="w-16 h-16 {{ $badgeColor }} rounded-full flex items-center justify-center border-4 border-orange-800/50 shadow-md">
                <span class="text-xs md:text-sm font-bold text-white tracking-wider">{{ $item['year'] }}</span>
              </div>
            </div>

            <div class="order-1 {{ $isLeft ? 'order-3' : '' }} shadow-md overflow-hidden max-w-xl w-full {{ $isLeft ? 'justify-self-start' : 'justify-self-end' }}">
              
              {{-- Header Card --}}
              <div class="{{ $item['isHighlight'] ? 'bg-red-800' : 'bg-orange-500' }} px-4 py-1.5 flex items-center space-x-2">
                <span class="text-[16px] font-bold text-white tracking-wide">{{ $item['date'] }}</span>
              </div>

              {{-- Body Card --}}
              <div class="{{ $item['isHighlight'] ? 'bg-red-50' : 'bg-gray-800' }} p-4">
                <h3 class="text-xl md:text-lg font-semibold {{ $item['isHighlight'] ? 'text-red-900' : 'text-white' }}">
                  {{ $item['cardTitle'] }}
                </h3>
                @if($item['cardSubtitle'])
                  <p class="text-xs text-gray-700 mt-1">{{ $item['cardSubtitle'] }}</p>
                @endif
              </div>

            </div>

          </div>
        @endforeach
      </div>
    </div>

    <!-- Timeline Content: VIDEOGRAPHY -->
    <div class="timeline-content" id="timeline-videography">
      <div class="relative">
        <div class="absolute inset-0 flex justify-center pointer-events-none">
          <div class="w-0.5 bg-gray-200 h-full"></div>
        </div>
        
        @foreach($timelineVideography as $item)
          @php
            // Mengatur posisi otomatis zig-zag: Genap di Kiri, Ganjil di Kanan
            $isLeft = $loop->index % 2 === 0;
          @endphp

          <div class="relative grid grid-cols-[1fr,auto,1fr] gap-x-4 md:gap-x-8 items-center min-h-[150px] {{ $item['isHighlight'] ? 'mt-8' : 'mt-4' }}">
            
            <div class="{{ $isLeft ? 'text-right' : 'text-left order-3' }}">
              <h2 class="text-lg md:text-xl font-bold {{ $item['isHighlight'] ? 'text-red-600 text-2xl' : 'text-white' }}">
                {{ $item['title'] }}
              </h2>
              <p class="text-xs md:text-sm text-white mt-1">{{ $item['subtitle'] }}</p>
            </div>

            <div class="relative flex items-center justify-center z-10 order-2">
              @php
                $badgeColor = $item['isHighlight'] ? 'bg-yellow-500' : ($loop->first ? 'bg-red-600' : 'bg-orange-500');
              @endphp
              <div class="w-16 h-16 {{ $badgeColor }} rounded-full flex items-center justify-center border-4 border-orange-800/50 shadow-md">
                <span class="text-xs md:text-sm font-bold text-white tracking-wider">{{ $item['year'] }}</span>
              </div>
            </div>

            <div class="order-1 {{ $isLeft ? 'order-3' : '' }} shadow-md overflow-hidden max-w-xl w-full {{ $isLeft ? 'justify-self-start' : 'justify-self-end' }}">
              
              {{-- Header Card --}}
              <div class="{{ $item['isHighlight'] ? 'bg-red-800' : 'bg-orange-500' }} px-4 py-1.5 flex items-center space-x-2">
                <span class="text-[16px] font-bold text-white tracking-wide">{{ $item['date'] }}</span>
              </div>

              {{-- Body Card --}}
              <div class="{{ $item['isHighlight'] ? 'bg-red-50' : 'bg-gray-800' }} p-4">
                <h3 class="text-xl md:text-lg font-semibold {{ $item['isHighlight'] ? 'text-red-900' : 'text-white' }}">
                  {{ $item['cardTitle'] }}
                </h3>
                @if($item['cardSubtitle'])
                  <p class="text-xs text-gray-700 mt-1">{{ $item['cardSubtitle'] }}</p>
                @endif
              </div>

            </div>

          </div>
        @endforeach
      </div>
    </div>

  </div>
</section>

    {{-- ===== KATEGORI LOMBA ===== --}}
    <section class="lomba" id="lomba">
        <div class="lomba-inner">
            <div class="section-header">
                <div class="section-eyebrow-center">
                    <i class="fas fa-bolt"></i> PILIH KATEGORI <i class="fas fa-bolt"></i>
                </div>
                <h2 class="section-title">KATEGORI <span>LOMBA</span></h2>
                <p class="section-subtitle">
                    Pilih kategori lomba yang sesuai dengan minat dan keahlianmu.
                    Setiap kategori memiliki kriteria dan hadiah yang menarik.
                </p>
            </div>
            <div class="lomba-grid">
                @php
                $list_lomba = [
                    [
                        'id' => 'wmodalPackaging',
                        'title' => 'Desain Packaging',
                        'tag_class' => 'design',
                        'tag_label' => 'design',
                        'card_desc' => 'Desain kemasan sangat penting dalam mempengaruhi persepsi konsumen, menarik perhatian mereka, dan membedakan produk dari pesaing di rak toko.',
                        'modal_desc' => 'Lomba Desain Kemasan Produk Kreatif bertujuan untuk menantang kreativitas dan ketajaman desain peserta dalam merancang kemasan produk yang estetik, inovatif, ramah lingkungan, serta memiliki nilai jual tinggi untuk sektor UMKM/industri.',
                        'img' => asset('images/despack.avif'),
                        'emoji' => '📦',
                        'icon' => 'fas fa-cube',
                        'biaya' => 'Rp 65.000',
                        'hadiah' => 'Rp 3.000.000',
                        'batas' => '8 Agustus 2026',
                        'tipe' => 'Individu',
                        'deliverables' => 'Peserta wajib mengumpulkan proposal berisi cover dengan judul, nama, asal sekolah, serta penempatan logo Polije, JTI, EPIM, dan sekolah sesuai ketentuan, yang dilengkapi isi berupa deskripsi filosofi, elemen desain, target pasar, kelebihan kemasan, serta lampiran gambar dieline dan mockup packaging menyeluruh.',
                        'deadline' => '28 Juni - 8 Agustus 2026',
                        'prize' => 'Rp 3.000.000',
                        'guidebook' => 'https://drive.google.com/drive/u/1/folders/189TmZ9NCeEgzyImoEfoFU6lZT5m9jxu3'
                    ],
                    [
                        'id' => 'wmodalWebProg',
                        'title' => 'Web Programming',
                        'tag_class' => 'design',
                        'tag_label' => 'technology',
                        'card_desc' => 'Front-end web programming fokus pada pembuatan tampilan yang menarik, responsif, dan fungsional untuk situs web.',
                        'modal_desc' => 'Lomba Pemrograman Web menantang kreativitas dan ketangkasan tim dalam mengembangkan aplikasi web yang responsif, fungsional, dan inovatif untuk memecahkan permasalahan nyata di lingkungan sekolah atau masyarakat umum.',
                        'img' => asset('images/webpro.webp'),
                        'emoji' => '💻',
                        'icon' => 'fas fa-code',
                        'biaya' => 'Rp 85.000',
                        'hadiah' => 'Rp 3.000.000',
                        'batas' => '8 Agustus 2026',
                        'tipe' => 'Tim (SMA/SMK Maks. 3 Orang)',
                        'deliverables' => 'Peserta wajib mengumpulkan proposal proyek yang berisi draf rancangan sistem, flowchart sistem, serta desain awal website berupa wireframe atau mockup.',
                        'deadline' => '28 Juni - 8 Agustus 2026',
                        'prize' => 'Rp 3.000.000',
                        'guidebook' => 'https://drive.google.com/drive/u/1/folders/189TmZ9NCeEgzyImoEfoFU6lZT5m9jxu3'
                    ],
                    [
                        'id' => 'wmodalPoster',
                        'title' => 'Network Engineering',
                        'tag_class' => 'design',
                        'tag_label' => 'design',
                        'card_desc' => 'Ekspresikan kreativitas melalui desain visual yang menarik, komunikatif, dan berkarakter kuat dalam berbagai media.',
                        'modal_desc' => 'Lomba Desain Jaringan mengajak peserta merancang infrastruktur jaringan komputer yang aman, handal, dan efisien untuk kebutuhan konektivitas modern.',
                        'img' => asset('images/desjar.avif'),
                        'emoji' => '🎨',
                        'icon' => 'fas fa-image',
                        'biaya' => 'Rp 85.000',
                        'hadiah' => 'Rp 3.000.000',
                        'batas' => '8 Agustus 2026',
                        'tipe' => 'Tim(SMA/SMK Maks 3)',
                        'deliverables' => 'File desain topologi jaringan format PDF/Cisco Packet Tracer, lembar orisinalitas.',
                        'deadline' => '28 Juni - 8 Agustus 2026',
                        'prize' => 'Rp 3.000.000',
                        'guidebook' => 'https://drive.google.com/drive/u/1/folders/189TmZ9NCeEgzyImoEfoFU6lZT5m9jxu3'
                    ],
                    [
                        'id' => 'wmodalVideography',
                        'title' => 'Videography',
                        'tag_class' => 'design',
                        'tag_label' => 'videography',
                        'card_desc' => 'Buat karya video kreatif yang memukau — ceritakan ide dan inovasi melalui visual bergerak yang impactful.',
                        'modal_desc' => 'Lomba Pembuatan Video Pendek/Kreatif menantang sineas muda bercerita secara sinematik mengenai ide, inovasi, atau pesan sosial kemasyarakatan melalui visual bergerak yang menggugah emosi penonton.',
                        'img' => asset('images/videografi.jpeg'),
                        'emoji' => '🎥',
                        'icon' => 'fas fa-video',
                        'biaya' => 'Rp 60.000',
                        'hadiah' => 'Rp 3.000.000',
                        'batas' => '8 Agustus 2026',
                        'tipe' => 'Individu',
                        'deliverables' => 'Peserta Lomba Videography wajib mengumpulkan video bertema "Innovative Visual Motion" berdurasi 2 hingga 5 menit format MP4 resolusi minimal 1080p dengan cara mencantumkan tautan Google Drive pribadi yang aksesnya telah diatur ke opsi “Siapa saja yang memiliki link dapat melihat”.',
                        'deadline' => '28 Juni - 8 Agustus 2026',
                        'prize' => 'Rp 3.000.000',
                        'guidebook' => 'https://drive.google.com/drive/u/1/folders/189TmZ9NCeEgzyImoEfoFU6lZT5m9jxu3'
                    ]
                ];
                @endphp

                @foreach ($list_lomba as $lomba)
                <div class="lomba-card">
                    <div class="lomba-card-img-wrap">
                        <img
                            src="{{ $lomba['img'] }}"
                            alt="{{ $lomba['title'] }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="lomba-card-img-placeholder" style="display:none;">{{ $lomba['emoji'] }}</div>
                        <div class="lomba-card-icon"><i class="{{ $lomba['icon'] }}"></i></div>
                    </div>
                    <div class="lomba-card-body">
                        <h3 class="lomba-card-title">{{ $lomba['title'] }}</h3>
                        <span class="lomba-tag {{ $lomba['tag_class'] }}">{{ $lomba['tag_label'] }}</span>
                        <p class="lomba-card-desc">
                            {{ $lomba['card_desc'] }}
                        </p>
                        <div class="lomba-deadline">
                            <i class="fas fa-calendar"></i>
                            Deadline: <strong>{{ $lomba['deadline'] }}</strong>
                        </div>
                        <div class="lomba-prize">
                            <i class="fas fa-trophy"></i> {{ $lomba['prize'] }}
                        </div>
                        <div class="lomba-actions">
                            <a href="javascript:void(0)" onclick="openWModal('{{ $lomba['id'] }}')" class="btn-detail">Detail Lomba</a>
                            @if(!auth()->check() || strtolower(auth()->user()->role ?? '') !== 'admin')
                                <a href="{{ url('/lomba') }}" class="btn-daftar">Daftar</a>
                            @endif
                        </div>
                        <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.78rem;color:var(--text-gray);"><i class="fas fa-book"></i> Guidebook</span>
                            <a href="{{ $lomba['guidebook'] }}" target="_blank" rel="noopener noreferrer" style="font-size:0.75rem;color:var(--orange);font-weight:600;text-decoration:none;">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ===== GALLERY SLIDER ===== --}}
    <section class="gallery-slider">
        <div class="slider-section-inner">
            <div class="section-header">
                <div class="section-eyebrow-center">
                    <i class="fas fa-images"></i> GALERI KEGIATAN <i class="fas fa-images"></i>
                </div>
                <h2 class="section-title">DOKUMENTASI <span>EPIM</span></h2>
                <p class="section-subtitle">Abadikan momen-momen terbaik dari rangkaian acara EPIM</p>
            </div>
            <div class="slider-container">
                <div class="slider-track" id="sliderTrack">
                    <div class="slide-item">
                        <img src="{{ asset('images/image.png') }}" alt="Dokumentasi 1">
                    </div>
                    <div class="slide-item">
                            <img src="{{ asset('images/DSC02634.avif') }}" alt="EPIM 2">
                        </div>
                        <div class="slide-item">
                            <img src="{{ asset('images/DSC02839.avif') }}" alt="EPIM 3">
                        </div>
                        <div class="slide-item">
                            <img src="{{ asset('images/DSC02847.avif') }}" alt="EPIM 4">
                        </div>
                        <div class="slide-item">
                            <img src="{{ asset('images/DSC02852.avif') }}" alt="EPIM 5">
                        </div>
                </div>
                <button class="slider-btn slider-btn-prev" id="sliderPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-btn slider-btn-next" id="sliderNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="slider-dots" id="sliderDots"></div>
        </div>
    </section>



    {{-- ===== BENEFITS ===== --}}
    <section class="benefits">
        <div class="section-header">
            <div class="section-eyebrow-center">
                <i class="fas fa-bolt"></i> KEUNTUNGAN <i class="fas fa-bolt"></i>
            </div>
            <h2 class="section-title">Apa yang <span>Kamu Dapatkan?</span></h2>
            <p class="section-subtitle">
                Bergabunglah dengan ratusan peserta lainnya dan raih kesempatan untuk
                mengembangkan skill dan memenangkan hadiah menarik!
            </p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-trophy" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Total Hadiah 30 Juta</div>
                <p class="benefit-desc">Hadiah menarik untuk juara 1, 2, 3 di setiap kategori lomba</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-certificate" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Sertifikat Resmi</div>
                <p class="benefit-desc">Sertifikat peserta dan pemenang yang dapat digunakan untuk portofolio</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-users" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Networking Luas</div>
                <p class="benefit-desc">Kesempatan bertemu dan berkolaborasi dengan mahasiswa se-Indonesia</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-star" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Pengalaman Berharga</div>
                <p class="benefit-desc">Asah kemampuan dan tingkatkan kepercayaan diri melalui kompetisi nyata</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-robot" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Juri Profesional</div>
                <p class="benefit-desc">Dinilai langsung oleh para profesional dan pakar di bidangnya</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon"><i class="fas fa-rocket" style="color: var(--orange);"></i></span>
                <div class="benefit-title">Karier Lebih Baik</div>
                <p class="benefit-desc">Portofolio kompetisi yang dapat memperkuat profil profesional kamu</p>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <div class="footer-inner">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/maskot1.png') }}" alt="EPIM Logo" class="footer-logo"
                         onerror="this.style.display='none'">
                    <div>
                        <div class="footer-brand-name">EPIM.TI</div>
                        <div class="footer-brand-sub">IT STUDENT COMPETITION</div>
                    </div>
                </div>
                <p class="footer-desc">
                    EXPO dan Pekan Ilmiah Mahasiswa (EPIM) adalah kegiatan perwujudan kreativitas mahasiswa
                    yang dilaksanakan perguruan tinggi yang terjadwal, guna meningkatkan budaya kompetisi
                    akademik dan untuk prestasi di kalangan mahasiswa.
                </p>
                <div class="footer-social">
                    <a href="#" title="Google+"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">EPIM 2026</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/#tentang') }}">Tentang EPIM</a></li>
                    <!-- <li><a href="{{ url('/informasi') }}">Informasi</a></li> -->
                    <li><a href="{{ url('/#lomba') }}">Kategori Lomba</a></li>
                    <li><a href="{{ url('/#timeline') }}">Timeline</a></li>
                    <!-- <li><a href="{{ url('/pengumuman') }}">Pengumuman</a></li> -->
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Contact Us</div>
                <div class="footer-contact-item">
                    <a href="mailto:hmjti@polije.ac.id">hmjti@polije.ac.id</a>
                </div>
                <p class="footer-contact-addr">
                    Jl. Mastrip No 164, Lingkungan Panji, Tegalgede, Kec. Sumbersari,
                    Kabupaten Jember, Jawa Timur 68121
                </p>
                <a href="#" class="footer-contact-item" style="display:block; margin-top:0.5rem; color: var(--orange); font-size:0.85rem; text-decoration:none;">
                    hmjtipolije2026.com
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 &nbsp; Designed by Departemen Kominfo</p>
        </div>
    </footer>

    <script>
        // Mobile hamburger menu
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.getElementById('hamburger');
            const nav = document.querySelector('.navbar-nav');
            const overlay = document.getElementById('navOverlay');
            if (hamburger && nav && overlay) {
                hamburger.addEventListener('click', function () {
                    nav.classList.toggle('open');
                    overlay.classList.toggle('open');
                    hamburger.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                });
                nav.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', closeMobileNav);
                });
            }
        });
        function closeMobileNav() {
            document.querySelector('.navbar-nav')?.classList.remove('open');
            document.getElementById('navOverlay')?.classList.remove('open');
            document.getElementById('hamburger')?.classList.remove('active');
            document.body.classList.remove('sidebar-open');
        }

        // Smooth scroll highlight active nav
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.navbar-nav a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(s => {
                if (window.scrollY >= s.offsetTop - 80) current = s.id;
            });
            navLinks.forEach(a => {
                a.classList.remove('active');
                if (a.getAttribute('href').includes(current)) a.classList.add('active');
            });
        });

        // Intersection Observer for fade-up animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeUp 0.7s forwards';
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.benefit-card, .lomba-card, .timeline-item').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });

        // ===== HERO SLIDER =====
        const heroTrack = document.getElementById('heroSliderTrack');
        const heroPrev = document.getElementById('heroSliderPrev');
        const heroNext = document.getElementById('heroSliderNext');
        const heroDotsContainer = document.getElementById('heroSliderDots');
        if (heroTrack) {
            const heroSlides = heroTrack.querySelectorAll('.hero-slide-item');
            let heroCurrent = 0;
            const heroTotal = heroSlides.length;

            for (let i = 0; i < heroTotal; i++) {
                const dot = document.createElement('div');
                dot.className = 'hdot' + (i === 0 ? ' active' : '');
                dot.addEventListener('click', () => {
                    heroCurrent = i;
                    heroTrack.style.transform = `translateX(-${heroCurrent * 100}%)`;
                    heroDotsContainer.querySelectorAll('.hdot').forEach((d, idx) => d.classList.toggle('active', idx === heroCurrent));
                });
                heroDotsContainer.appendChild(dot);
            }

            heroNext.addEventListener('click', () => {
                heroCurrent = (heroCurrent + 1) % heroTotal;
                heroTrack.style.transform = `translateX(-${heroCurrent * 100}%)`;
                heroDotsContainer.querySelectorAll('.hdot').forEach((d, i) => d.classList.toggle('active', i === heroCurrent));
            });

            heroPrev.addEventListener('click', () => {
                heroCurrent = (heroCurrent - 1 + heroTotal) % heroTotal;
                heroTrack.style.transform = `translateX(-${heroCurrent * 100}%)`;
                heroDotsContainer.querySelectorAll('.hdot').forEach((d, i) => d.classList.toggle('active', i === heroCurrent));
            });

            let heroAuto = setInterval(() => {
                heroCurrent = (heroCurrent + 1) % heroTotal;
                heroTrack.style.transform = `translateX(-${heroCurrent * 100}%)`;
                heroDotsContainer.querySelectorAll('.hdot').forEach((d, i) => d.classList.toggle('active', i === heroCurrent));
            }, 4000);

            heroTrack.addEventListener('mouseenter', () => clearInterval(heroAuto));
            heroTrack.addEventListener('mouseleave', () => {
                heroAuto = setInterval(() => {
                    heroCurrent = (heroCurrent + 1) % heroTotal;
                    heroTrack.style.transform = `translateX(-${heroCurrent * 100}%)`;
                    heroDotsContainer.querySelectorAll('.hdot').forEach((d, i) => d.classList.toggle('active', i === heroCurrent));
                }, 4000);
            });
        }

        // ===== GALLERY SLIDER =====
        const track = document.getElementById('sliderTrack');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');
        const dotsContainer = document.getElementById('sliderDots');
        if (track) {
            const slides = track.querySelectorAll('.slide-item');
            let currentSlide = 0;
            const totalSlides = slides.length;

            // Create dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.dataset.index = i;
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }

            function goToSlide(index) {
                currentSlide = index;
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                document.querySelectorAll('.slider-dots .dot').forEach((d, i) => {
                    d.classList.toggle('active', i === currentSlide);
                });
            }

            function nextSlide() {
                goToSlide((currentSlide + 1) % totalSlides);
            }

            function prevSlide() {
                goToSlide((currentSlide - 1 + totalSlides) % totalSlides);
            }

            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Auto-slide every 4 seconds
            let autoSlide = setInterval(nextSlide, 4000);

            // Pause on hover
            track.addEventListener('mouseenter', () => clearInterval(autoSlide));
            track.addEventListener('mouseleave', () => { autoSlide = setInterval(nextSlide, 4000); });
        }

        // ===== STATS COUNTER =====
        const statsSection = document.getElementById('statsBar');
        if (statsSection) {
            const statValues = statsSection.querySelectorAll('.stat-value');
            let statsAnimated = false;

            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !statsAnimated) {
                        statsAnimated = true;
                        statValues.forEach(stat => {
                            const target = parseInt(stat.dataset.target);
                            const suffix = stat.dataset.suffix || '';
                            const duration = 2000;
                            const startTime = performance.now();

                            function updateCounter(currentTime) {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);
                                // Ease out cubic
                                const eased = 1 - Math.pow(1 - progress, 3);
                                const current = Math.floor(eased * target);
                                stat.textContent = current + suffix;
                                if (progress < 1) {
                                    requestAnimationFrame(updateCounter);
                                } else {
                                    stat.textContent = target + suffix;
                                }
                            }
                            requestAnimationFrame(updateCounter);
                        });
                        statsObserver.unobserve(statsSection);
                    }
                });
            }, { threshold: 0.3 });

            statsObserver.observe(statsSection);
        }

        document.querySelectorAll('.timeline-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.target;

                document.querySelectorAll('.timeline-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.timeline-content').forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(`timeline-${target}`).classList.add('active');
            });
        });

        // Welcome Detail Modals handlers
        function openWModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }
        function closeWModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        window.addEventListener('click', function (e) {
            if (e.target.classList && e.target.classList.contains('wmodal')) {
                e.target.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    </script>

    @foreach ($list_lomba as $m)
    <div id="{{ $m['id'] }}" class="wmodal">
        <div class="wmodal-content">
            <span class="wmodal-close" onclick="closeWModal('{{ $m['id'] }}')">&times;</span>
            <h3 class="wmodal-title">{{ $m['title'] }}</h3>
            <div class="wmodal-body">
                <p>{{ $m['modal_desc'] }}</p>
                <div class="wmodal-info-grid">
                    <div class="wmodal-info-item">
                        <label>Biaya Registrasi</label>
                        <span>{{ $m['biaya'] }}</span>
                    </div>
                    <div class="wmodal-info-item">
                        <label>Total Hadiah</label>
                        <span style="color:#F97316;">{{ $m['hadiah'] }}</span>
                    </div>
                    <div class="wmodal-info-item">
                        <label>Batas Pendaftaran</label>
                        <span>{{ $m['batas'] }}</span>
                    </div>
                    <div class="wmodal-info-item">
                        <label>Tipe Peserta</label>
                        <span>{{ $m['tipe'] }}</span>
                    </div>
                </div>
                <p style="font-size:0.85rem; color:#9CA3AF;"><strong>Deliverables:</strong> {{ $m['deliverables'] }}</p>
            </div>
            <div class="wmodal-actions">
                <button class="btn btn-close" onclick="closeWModal('{{ $m['id'] }}')">Tutup</button>
                @if(!auth()->check() || strtolower(auth()->user()->role ?? '') !== 'admin')
                    <a href="{{ url('/lomba') }}" class="btn btn-daftar">Daftar Sekarang</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

</body>
</html>