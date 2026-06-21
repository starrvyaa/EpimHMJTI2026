<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EXPO PEKAN ILMIAH MAHASISWA - HMJTI 2026')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#0A0A0A] text-white overflow-x-hidden">

    {{-- ===== NAVBAR ===== --}}
    <nav class="fixed top-0 inset-x-0 z-50 h-[65px] flex items-center justify-between px-6 md:px-12 bg-black/95 backdrop-blur-md border-b border-white/8">
        {{-- Brand --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
            <img src="{{ asset('images/maskot2.png') }}" alt="Logo EPIM"
                 class="w-[50px] h-[50px] object-cover rounded-full"
                 onerror="this.style.display='none'">
            <div class="leading-tight">
                <div class="font-heading font-extrabold text-[0.85rem] text-white tracking-[0.05em] leading-snug">
                    EXPO PEKAN ILMIAH<br>MAHASISWA
                </div>
                <div class="text-[0.7rem] font-semibold text-orange tracking-[0.05em]">
                    HMJTI 2025-2026
                </div>
            </div>
        </a>

        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-8 list-none m-0 p-0">
            <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">BERANDA</a></li>
            <li><a href="{{ url('/#lomba') }}" class="nav-link">LOMBA</a></li>
            <li><a href="{{ url('/template') }}" class="nav-link {{ request()->is('template') ? 'active' : '' }}">TEMPLATE</a></li>
            <li><a href="{{ url('/#timeline') }}" class="nav-link">TIMELINE</a></li>
            @guest
                <li><a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-1.5 border border-orange text-orange text-[0.78rem] font-semibold rounded-md bg-transparent hover:bg-orange hover:text-white transition-all duration-200 no-underline">
                    DASHBOARD
                </a></li>
            @else
                <li><a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-1.5 border border-orange text-orange text-[0.78rem] font-semibold rounded-md bg-transparent hover:bg-orange hover:text-white transition-all duration-200 no-underline">
                    DASHBOARD
                </a></li>
            @endguest
        </ul>

        {{-- Hamburger --}}
        <button id="hamburger" class="md:hidden flex flex-col gap-[5px] bg-transparent border-none cursor-pointer p-1" aria-label="Toggle menu">
            <span class="block w-6 h-[2px] bg-white rounded transition-all duration-300"></span>
            <span class="block w-6 h-[2px] bg-white rounded transition-all duration-300"></span>
            <span class="block w-6 h-[2px] bg-white rounded transition-all duration-300"></span>
        </button>
    </nav>
    <div id="navOverlay" class="fixed inset-0 bg-black/60 z-[998] hidden cursor-pointer" onclick="closeMobileNav()"></div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu"
         class="fixed top-0 right-0 w-[280px] h-screen bg-[#111] z-[999] pt-20 pb-10 px-8 shadow-[-5px_0_20px_rgba(0,0,0,0.5)] flex flex-col gap-4 transform translate-x-full transition-transform duration-300 md:hidden">
        <a href="{{ url('/') }}" class="nav-link text-base py-3">BERANDA</a>
        <a href="{{ url('/#lomba') }}" class="nav-link text-base py-3">LOMBA</a>
        <a href="{{ url('/template') }}" class="nav-link text-base py-3">TEMPLATE</a>
        <a href="{{ url('/#timeline') }}" class="nav-link text-base py-3">TIMELINE</a>
        <hr class="border-white/10 my-2">
        @guest
            <a href="{{ route('dashboard') }}" class="text-center px-4 py-3 border border-orange text-orange text-sm font-semibold rounded-md bg-transparent">DASHBOARD</a>
        @else
            <a href="{{ route('dashboard') }}" class="text-center px-4 py-3 border border-orange text-orange text-sm font-semibold rounded-md bg-transparent">DASHBOARD</a>
        @endguest
    </div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    <style>
        .nav-link {
            text-decoration: none;
            color: #9CA3AF;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .nav-link:hover,
        .nav-link.active {
            color: #fff;
        }
        .mobile-nav-link {
            text-decoration: none;
            color: #9CA3AF;
            font-weight: 500;
            transition: color 0.2s;
        }
        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            color: #fff;
        }
        .border-white\/8 { border-color: rgba(255,255,255,0.08); }
        .border-white\/10 { border-color: rgba(255,255,255,0.1); }
    </style>

    <script>
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const navOverlay = document.getElementById('navOverlay');

        function toggleMobileNav() {
            const isOpen = mobileMenu.classList.toggle('translate-x-0');
            mobileMenu.classList.toggle('translate-x-full', !isOpen);
            navOverlay.classList.toggle('hidden', !isOpen);
            document.body.classList.toggle('overflow-hidden', isOpen);
            hamburger.classList.toggle('active', isOpen);
        }
        function closeMobileNav() {
            mobileMenu.classList.remove('translate-x-0');
            mobileMenu.classList.add('translate-x-full');
            navOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            hamburger.classList.remove('active');
        }
        hamburger.addEventListener('click', toggleMobileNav);

        // Hamburger active style
        hamburger.addEventListener('click', function() {
            const spans = this.querySelectorAll('span');
            if (this.classList.contains('active')) {
                spans[0].style.transform = 'translateY(7px) rotate(45deg)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'translateY(-7px) rotate(-45deg)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        });

        // Close mobile menu on link click
        mobileMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', closeMobileNav);
        });
    </script>

    @stack('scripts')
</body>
</html>
