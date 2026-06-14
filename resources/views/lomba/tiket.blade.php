<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Finalis - EPIM 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background:#0A0A0A; color:#fff;
            display:flex; align-items:center; justify-content:center;
            min-height:100vh; padding:2rem;
        }
        .ticket {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border: 2px solid #F97316;
            border-radius: 24px;
            max-width: 520px;
            width:100%;
            padding:2.5rem;
            text-align:center;
            position:relative;
            box-shadow: 0 30px 80px rgba(249,115,22,0.15);
        }
        .ticket::before {
            content: '';
            position:absolute;
            top:-1px; left:-1px; right:-1px;
            height:6px;
            background: linear-gradient(90deg, #F97316, #EA580C, #F97316);
            border-radius: 24px 24px 0 0;
        }
        .ticket h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: #F97316;
            margin-bottom: 0.25rem;
        }
        .ticket .sub {
            font-size: 0.75rem;
            color: #9CA3AF;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .ticket .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(249,115,22,0.4), transparent);
            margin: 1.5rem 0;
        }
        .ticket .field {
            display:flex;
            justify-content:space-between;
            padding:0.5rem 0;
            font-size: 0.9rem;
        }
        .ticket .field .label { color:#6B7280; }
        .ticket .field .value { color:#fff; font-weight:600; }
        .ticket .badge-finalis {
            display:inline-block;
            background:rgba(249,115,22,0.15);
            color:#F97316;
            padding:0.3rem 1rem;
            border-radius:50px;
            font-size:0.75rem;
            font-weight:700;
            letter-spacing:0.1em;
            margin:1rem 0;
        }
        .btn {
            display:inline-flex; align-items:center; gap:8px;
            padding:0.75rem 1.5rem; border-radius:8px;
            font-weight:700; font-size:0.85rem;
            cursor:pointer; border:none; text-decoration:none;
            transition:0.3s; margin:0.5rem;
        }
        .btn-orange { background:#F97316; color:#fff; }
        .btn-orange:hover { background:#ea580c; }
        .btn-outline { border:1px solid #374151; color:#9CA3AF; background:transparent; }
        .btn-outline:hover { border-color:#F97316; color:#F97316; }
        .btn-print { background:#fff; color:#F97316; }
        .btn-print:hover { background:#f3f4f6; }
    </style>
</head>
<body>
<div class="ticket">
    <h1>🏆 EPIM 2026</h1>
    <div class="sub">KARTU TANDA PESERTA — BABAK FINAL (LURING)</div>

    <div class="badge-finalis">✅ FINALIS</div>

    <div class="divider"></div>

    <div class="field">
        <span class="label">Nama Tim</span>
        <span class="value">{{ $pendaftar->tim->nama_tim ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">Kategori</span>
        <span class="value">{{ $pendaftar->kategori->nama_lomba ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">Ketua</span>
        <span class="value">{{ $pendaftar->nama_ketua ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">NIS/NIM</span>
        <span class="value">{{ $pendaftar->nis_nim_ketua ?? '-' }}</span>
    </div>
    @if($pendaftar->anggota_1)
    <div class="field">
        <span class="label">Anggota 1</span>
        <span class="value">{{ $pendaftar->anggota_1 }}</span>
    </div>
    @endif
    @if($pendaftar->anggota_2)
    <div class="field">
        <span class="label">Anggota 2</span>
        <span class="value">{{ $pendaftar->anggota_2 }}</span>
    </div>
    @endif
    @if($pendaftar->anggota_3)
    <div class="field">
        <span class="label">Anggota 3</span>
        <span class="value">{{ $pendaftar->anggota_3 }}</span>
    </div>
    @endif
    <div class="field">
        <span class="label">Asal Sekolah</span>
        <span class="value">{{ $pendaftar->tim->asal_sekolah ?? '-' }}</span>
    </div>

    <div class="divider"></div>

    <p style="font-size:0.75rem; color:#9CA3AF; line-height:1.6;">
        Tiket ini berlaku sebagai bukti peserta babak final luring EPIM 2026.<br>
        Harap dibawa saat hari pelaksanaan.
    </p>

    <div style="margin-top:1.5rem; display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
        <button onclick="window.print()" class="btn btn-print">
            <i class="fa-solid fa-print"></i> Cetak Tiket
        </button>
        <a href="{{ route('Lomba.peserta.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
