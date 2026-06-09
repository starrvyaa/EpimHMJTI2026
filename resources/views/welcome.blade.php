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
            width: 38px;
            height: 38px;
            background: var(--orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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
            padding: 2.5rem 0;
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

        .lomba-tag.design { background: rgba(249,115,22,0.2); color: var(--orange); }
        .lomba-tag.technology { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .lomba-tag.science { background: rgba(16,185,129,0.2); color: #34d399; }
        .lomba-tag.writing { background: rgba(139,92,246,0.2); color: #a78bfa; }

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

        /* ===== TIMELINE ===== */
        .timeline {
            padding: 6rem 0;
            background: var(--dark-section);
        }

        .timeline-inner {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 3rem;
        }

        .timeline-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            position: relative;
        }

        .timeline-list::before {
            content: '';
            position: absolute;
            left: 28px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(255,255,255,0.08);
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            padding: 1.25rem 0;
        }

        .tl-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.3rem;
            position: relative;
            z-index: 1;
        }

        .tl-icon.done { background: #10b981; }
        .tl-icon.active { background: var(--orange); }
        .tl-icon.upcoming { background: #1f2937; }

        .tl-card {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            position: relative;
            transition: border-color 0.3s;
        }

        .tl-card.active {
            background: rgba(249,115,22,0.06);
            border-color: rgba(249,115,22,0.3);
        }

        .tl-date {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 0.25rem;
        }

        .tl-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.25rem;
        }

        .tl-desc {
            color: var(--text-gray);
            font-size: 0.82rem;
        }

        .tl-badge {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.06em;
        }

        .tl-badge.done { background: #10b981; color: #fff; }
        .tl-badge.active { background: var(--orange); color: #fff; }

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
            width: 50px;
            height: 50px;
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
        }

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
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="navbar-logo">
                {{-- <img src="{{ asset('images/rudo.png') }}" alt="Logo EPIM" class="navbar-logo-img" width="40"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trophy-fill" viewBox="0 0 16 16">
  <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5q0 .807-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33 33 0 0 1 2.5.5m.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935m10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935"/>
</svg>
            </div>
            <div class="navbar-brand-text">
                <span>EXPO PEKAN ILMIAH MAHASISWA</span>
                <span>HMJTI 2025-2026</span>
            </div>
        </a>
        <ul class="navbar-nav">
            <li><a href="{{ url('/') }}" class="active">BERANDA</a></li>
            <li><a href="{{ url('/lomba') }}">LOMBA</a></li>
            <li><a href="{{ url('/timeline') }}">TIMELINE</a></li>
            @guest
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a>
            @endguest
        </ul>
        <button class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </button>
    </nav>

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
                    <a href="{{ url('/lomba') }}" class="btn-primary">
                        LIHAT LOMBA <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ url('/daftar') }}" class="btn-outline">
                        SUBMIT KARYA
                    </a>
                </div>
            </div>
            <div class="hero-image-wrap fade-up">
                <div class="hero-slider-container">
                    <div class="hero-slider-track" id="heroSliderTrack">
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/image.png') }}" alt="EPIM 1">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/epim.png') }}" alt="EPIM 2">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/poster_ai.png') }}" alt="EPIM 3">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/videografi.jpeg') }}" alt="EPIM 4">
                        </div>
                        <div class="hero-slide-item">
                            <img src="{{ asset('images/LogoEPIM.png') }}" alt="EPIM 5">
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
                <span class="stat-value" data-target="40" data-suffix="Jt">0</span>
                <span class="stat-label">Total Hadiah</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <span class="stat-value" data-target="15" data-suffix="">0</span>
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
                <span class="benefit-icon">🏆</span>
                <div class="benefit-title">Total Hadiah 30 Juta</div>
                <p class="benefit-desc">Hadiah menarik untuk juara 1, 2, 3 di setiap kategori lomba</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon">📜</span>
                <div class="benefit-title">Sertifikat Resmi</div>
                <p class="benefit-desc">Sertifikat peserta dan pemenang yang dapat digunakan untuk portofolio</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon">🤝</span>
                <div class="benefit-title">Networking Luas</div>
                <p class="benefit-desc">Kesempatan bertemu dan berkolaborasi dengan mahasiswa se-Indonesia</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon">⭐</span>
                <div class="benefit-title">Pengalaman Berharga</div>
                <p class="benefit-desc">Asah kemampuan dan tingkatkan kepercayaan diri melalui kompetisi nyata</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon">🤖</span>
                <div class="benefit-title">Juri Profesional</div>
                <p class="benefit-desc">Dinilai langsung oleh para profesional dan pakar di bidangnya</p>
            </div>
            <div class="benefit-card fade-up">
                <span class="benefit-icon">🚀</span>
                <div class="benefit-title">Karier Lebih Baik</div>
                <p class="benefit-desc">Portofolio kompetisi yang dapat memperkuat profil profesional kamu</p>
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
                <h2 class="section-title">DOKUMENTASI <span>EPIM 2026</span></h2>
                <p class="section-subtitle">Abadikan momen-momen terbaik dari rangkaian acara EPIM</p>
            </div>
            <div class="slider-container">
                <div class="slider-track" id="sliderTrack">
                    <div class="slide-item">
                        <img src="{{ asset('images/image.png') }}" alt="Dokumentasi 1">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('images/epim.png') }}" alt="Dokumentasi 2">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('images/poster_ai.png') }}" alt="Dokumentasi 3">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('images/videografi.jpeg') }}" alt="Dokumentasi 4">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('images/LogoEPIM.png') }}" alt="Dokumentasi 5">
                    </div>
                </div>
                <button class="slider-btn slider-btn-prev" id="sliderPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-btn slider-btn-next" id="sliderNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="slider-dots" id="sliderDots"></div>
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

                {{-- Card 1: Desain Packaging --}}
                <div class="lomba-card">
                    <div class="lomba-card-img-wrap">
                        <img
                            src="{{ asset('images/LogoEPIM.png') }}"
                            alt="Desain Packaging"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="lomba-card-img-placeholder" style="display:none;">📦</div>
                        <div class="lomba-card-icon"><i class="fas fa-cube"></i></div>
                    </div>
                    <div class="lomba-card-body">
                        <h3 class="lomba-card-title">Desain Packaging</h3>
                        <span class="lomba-tag design">design</span>
                        <p class="lomba-card-desc">
                            Desain kemasan sangat penting dalam mempengaruhi persepsi konsumen,
                            menarik perhatian mereka, dan membedakan produk dari pesaing di rak toko.
                        </p>
                        <div class="lomba-deadline">
                            <i class="fas fa-calendar"></i>
                            Deadline: <strong>15 Maret 2026</strong>
                        </div>
                        <div class="lomba-prize">
                            <i class="fas fa-trophy"></i> Rp 3.000.000
                        </div>
                        <div class="lomba-actions">
                            <a href="{{ url('/lomba/desain-packaging') }}" class="btn-detail">Detail Lomba</a>
                            <a href="{{ url('/daftar/desain-packaging') }}" class="btn-daftar">Daftar</a>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Web Programming --}}
                <div class="lomba-card">
                    <div class="lomba-card-img-wrap">
                        <img
                            src="{{ asset('images/webpro.webp') }}"
                            alt="Web Programming"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="lomba-card-img-placeholder" style="display:none;">💻</div>
                        <div class="lomba-card-icon"><i class="fas fa-code"></i></div>
                    </div>
                    <div class="lomba-card-body">
                        <h3 class="lomba-card-title">Web Programming</h3>
                        <span class="lomba-tag technology">technology</span>
                        <p class="lomba-card-desc">
                            Front-end web programming fokus pada pembuatan tampilan yang menarik,
                            responsif, dan fungsional untuk situs web.
                        </p>
                        <div class="lomba-deadline">
                            <i class="fas fa-calendar"></i>
                            Deadline: <strong>15 Maret 2026</strong>
                        </div>
                        <div class="lomba-prize">
                            <i class="fas fa-trophy"></i> Rp 5.000.000
                        </div>
                        <div class="lomba-actions">
                            <a href="{{ url('/lomba/web-programming') }}" class="btn-detail">Detail Lomba</a>
                            <a href="{{ url('/daftar/web-programming') }}" class="btn-daftar">Daftar</a>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Desain Grafis --}}
                <div class="lomba-card">
                    <div class="lomba-card-img-wrap">
                        <img
                            src="{{ asset('images/poster_ai.png') }}"
                            alt="Desain Grafis"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="lomba-card-img-placeholder" style="display:none;">🎨</div>
                        <div class="lomba-card-icon"><i class="fas fa-image"></i></div>
                    </div>
                    <div class="lomba-card-body">
                        <h3 class="lomba-card-title">Desain Poster</h3>
                        <span class="lomba-tag design">design</span>
                        <p class="lomba-card-desc">
                            Ekspresikan kreativitas melalui desain visual yang menarik,
                            komunikatif, dan berkarakter kuat dalam berbagai media.
                        </p>
                        <div class="lomba-deadline">
                            <i class="fas fa-calendar"></i>
                            Deadline: <strong>15 Maret 2026</strong>
                        </div>
                        <div class="lomba-prize">
                            <i class="fas fa-trophy"></i> Rp 3.000.000
                        </div>
                        <div class="lomba-actions">
                            <a href="{{ url('/lomba/desain-grafis') }}" class="btn-detail">Detail Lomba</a>
                            <a href="{{ url('/daftar/desain-grafis') }}" class="btn-daftar">Daftar</a>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Videography --}}
                <div class="lomba-card">
                    <div class="lomba-card-img-wrap">
                        <img
                            src="{{ asset('images/videografi.jpeg') }}"
                            alt="Videography"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="lomba-card-img-placeholder" style="display:none;">🎥</div>
                        <div class="lomba-card-icon"><i class="fas fa-video"></i></div>
                    </div>
                    <div class="lomba-card-body">
                        <h3 class="lomba-card-title">Videography</h3>
                        <span class="lomba-tag design">videography</span>
                        <p class="lomba-card-desc">
                            Buat karya video kreatif yang memukau — ceritakan ide dan
                            inovasi melalui visual bergerak yang impactful.
                        </p>
                        <div class="lomba-deadline">
                            <i class="fas fa-calendar"></i>
                            Deadline: <strong>15 Maret 2026</strong>
                        </div>
                        <div class="lomba-prize">
                            <i class="fas fa-trophy"></i> Rp 4.000.000
                        </div>
                        <div class="lomba-actions">
                            <a href="{{ url('/lomba/videography') }}" class="btn-detail">Detail Lomba</a>
                            <a href="{{ url('/daftar/videography') }}" class="btn-daftar">Daftar</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== TIMELINE ===== --}}
    <section class="timeline" id="timeline">
        <div class="timeline-inner">
            <div class="section-header">
                <div class="section-eyebrow-center">
                    <i class="fas fa-calendar"></i> JADWAL EVENT <i class="fas fa-calendar"></i>
                </div>
                <h2 class="section-title">TIMELINE <span>EVENT</span></h2>
                <p class="section-subtitle">Catat tanggal penting untuk setiap tahapan kompetisi</p>
            </div>
            <div class="timeline-list">

                <div class="timeline-item">
                    <div class="tl-icon done">📅</div>
                    <div class="tl-card">
                        <div class="tl-date">1 FEBRUARI 2026</div>
                        <div class="tl-title">Pembukaan Pendaftaran</div>
                        <div class="tl-desc">Mulai daftar sekarang!</div>
                        <span class="tl-badge done">✓ SELESAI</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="tl-icon active">📅</div>
                    <div class="tl-card active">
                        <div class="tl-date">15 MARET 2026</div>
                        <div class="tl-title">Penutupan Pendaftaran</div>
                        <div class="tl-desc">Deadline untuk mendaftar</div>
                        <span class="tl-badge active">AKTIF SEKARANG</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="tl-icon upcoming">📅</div>
                    <div class="tl-card">
                        <div class="tl-date">20 MARET 2026</div>
                        <div class="tl-title">Pengumuman Finalis</div>
                        <div class="tl-desc">10 finalis terbaik akan diumumkan</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="tl-icon upcoming">📅</div>
                    <div class="tl-card">
                        <div class="tl-date">25–26 MARET 2026</div>
                        <div class="tl-title">Grand Final &amp; Awarding</div>
                        <div class="tl-desc">Presentasi finalis dan pengumuman pemenang</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <div class="footer-inner">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-epim.png') }}" alt="EPIM Logo" class="footer-logo"
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
                <div class="footer-col-title">EPIM 2025</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/tentang') }}">Tentang EPIM</a></li>
                    <li><a href="{{ url('/informasi') }}">Informasi</a></li>
                    <li><a href="{{ url('/pendaftaran') }}">Pendaftaran</a></li>
                    <li><a href="{{ url('/pengumuman') }}">Pengumuman</a></li>
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
                    hmjtipolije2025.com
                </a>
                <a href="#" class="footer-btn-app">
                    <i class="fas fa-download"></i> Download Our App
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 &nbsp; Designed by Departemen Kominfo</p>
        </div>
    </footer>

    <script>
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
    </script>

</body>
</html>