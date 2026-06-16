@extends('layouts.dashboard')

@section('title', 'Daftar Lomba - EPIM')
@section('menuLomba', 'active')
@section('pageTitle', 'Panel ' . (auth()->user()->role == 'admin' ? 'Admin' : 'Peserta'))

@section('extraCss')
<style>
    .card-table {
        background: #111;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .table-responsive { width: 100%; overflow-x: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
        min-width: 900px;
    }
    th {
        text-align: left;
        color: #6B7280;
        padding: 1rem;
        border-bottom: 2px solid rgba(255,255,255,0.05);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    td {
        padding: 1.2rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        font-size: 0.9rem;
    }
    .btn-info-outline { border: 1px solid #60A5FA; color: #60A5FA; background: transparent; }
    .btn-danger-outline { border: 1px solid #EF4444; color: #EF4444; background: transparent; }
    .action-icons { display: flex; gap: 15px; align-items: center; }
    .icon-btn {
        font-size: 1.2rem;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        color: #9CA3AF;
        transition: 0.2s;
    }
    .icon-btn:hover { transform: scale(1.1); color: #fff; }
    .badge-status { padding: 5px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
    .step-indicator { display: flex; gap: 10px; margin-bottom: 30px; }
    .step-indicator div { flex: 1; height: 5px; border-radius: 10px; }
    .input-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px; }
    .detail-grid {
        display: grid;
        gap: 15px;
        background: #222;
        padding: 20px;
        border-radius: 12px;
    }
    .detail-item label {
        color: #6B7280;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .detail-item strong {
        display: block;
        margin-top: 4px;
        color: #fff;
    }
    .detail-separator {
        border: 0;
        border-top: 1px solid #333;
        width: 100%;
    }
    @media (max-width: 768px) {
        .card-table { padding: 1rem; }
        table { min-width: 800px; }
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        form[style*="display:flex"] { flex-direction: column; align-items: stretch !important; }
        form[style*="display:flex"] select { width: 100% !important; }
    }
    @media (max-width: 480px) {
        .card-table { padding: 0.75rem; border-radius: 12px; }
    }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

@if(session('wa_group'))
    <div style="background: rgba(37, 211, 102, 0.1); color: #25D366; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(37, 211, 102, 0.3); display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <i class="fa-brands fa-whatsapp" style="font-size:1.5rem;"></i>
        <span style="flex:1;">Bergabung dengan grup WhatsApp resmi EPIM 2026 untuk info lebih lanjut:</span>
        <a href="{{ session('wa_group') }}" target="_blank" class="btn" style="background:#25D366; color:#fff; padding:0.6rem 1.2rem; border-radius:8px; text-decoration:none; font-weight:700; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-brands fa-whatsapp"></i> Gabung Grup WA
        </a>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i> Mohon lengkapi data pendaftaran dengan benar.</div>
@endif

{{-- ALERT: Pendaftaran ditutup — hanya untuk yg BELUM punya pendaftaran --}}
@if(($pengaturan->status_pendaftaran_ditutup ?? false) && !$userHasPendaftaran)
<div class="alert alert-danger" style="display:flex; align-items:center; gap:12px;">
    <i class="fa-solid fa-circle-exclamation" style="font-size:1.3rem;"></i>
    <span>Maaf, pendaftaran lomba saat ini sudah <strong>ditutup</strong> oleh Admin.</span>
</div>
@endif

{{-- ALERT: Upload proposal/karya ditutup — hanya jika belum submit karya --}}
@if(($pengaturan->status_upload_postervideo_ditutup ?? false) && (auth()->user()->role == 'admin' || $userHasUnsubmittedKarya))
<div class="alert alert-danger" style="display:flex; align-items:center; gap:12px;">
    <i class="fa-solid fa-circle-exclamation" style="font-size:1.3rem;"></i>
    <span>Maaf, pengumpulan proposal/karya saat ini sudah <strong>ditutup</strong> oleh Admin.</span>
</div>
@endif

<div class="card-table">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h3 style="margin:0; font-family:'Montserrat';">Status Pendaftaran</h3>
        @if($datas->isEmpty())
            @if($pengaturan->status_pendaftaran_ditutup ?? false)
                <span style="color:#6B7280; font-size:0.85rem; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-ban"></i> Pendaftaran ditutup
                </span>
            @else
                <button class="btn btn-orange" onclick="openModal('modalCreate')">
                    <i class="fa-solid fa-plus"></i> Daftar Sekarang
                </button>
            @endif
        @endif
    </div>

    {{-- Admin: Filter Kategori --}}
    @if(auth()->user()->role == 'admin')
    <form method="GET" action="{{ route('Lomba.peserta.index') }}" style="margin-bottom:1.5rem; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <label style="color:#9CA3AF; font-size:0.85rem; font-weight:600;">
            <i class="fa-solid fa-filter"></i> Filter Kategori:
        </label>
        <select name="filter_kategori" onchange="this.form.submit()" style="padding:0.6rem 1rem; background:#222; border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; outline:none; min-width:200px;">
            <option value="">— Semua Kategori —</option>
            @foreach($listKategori as $kat)
                <option value="{{ $kat->id }}" {{ ($filterKategori ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_lomba }}</option>
            @endforeach
        </select>
        @if($filterKategori)
            <a href="{{ route('Lomba.peserta.index') }}" style="color:#9CA3AF; font-size:0.8rem; text-decoration:none;">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
        @endif
        <span style="color:#6B7280; font-size:0.8rem; margin-left:auto;">
            <i class="fa-solid fa-list"></i> {{ $datas->total() ?? $datas->count() }} data
        </span>
    </form>
    @endif

    <div class="table-responsive">
            <table>
                @php
                    if (auth()->user()->role == 'admin') {
                        $colHideProposal   = $filterKategori && in_array($filterKategori, [2,4]);
                        $colHideSubtema    = $filterKategori && $filterKategori != 1;
                        $colHideLihatKarya = $filterKategori && !in_array($filterKategori, [2,4]);
                    } else {
                        $userLombaIds = $datas->pluck('id_lomba')->unique();
                        $colHideProposal   = !$userLombaIds->intersect([1,3])->count();
                        $colHideSubtema    = !$userLombaIds->contains(1);
                        $colHideLihatKarya = !$userLombaIds->intersect([2,4])->count();
                    }
                @endphp
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Info Tim & Lomba</th>
                        @if(auth()->user()->role == 'admin')
                            <th>Pendaftar (User)</th>
                            <th>Status Bayar</th>
                        @else
                            <th>Status Bayar</th>
                        @endif
                        <th>Kelulusan</th>
                        <th @if($colHideProposal) style="display:none;" @endif>Proposal</th>
                        <th @if($colHideSubtema) style="display:none;" @endif>Sub Tema</th>
                        <th>Orisinalitas</th>
                        <th>Karya</th>
                        <th @if($colHideLihatKarya) style="display:none;" @endif>Lihat Karya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
               <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $data->tim->nama_tim ?? 'N/A' }}</div>
                            <div style="font-size: 0.8rem; color: #F97316;">{{ $data->kategori->nama_lomba ?? 'N/A' }}</div>
                        </td>

                        @if(auth()->user()->role == 'admin')
                            <td>
                                <div style="font-weight: 700; color: #fff;">{{ $data->user->name ?? 'N/A' }}</div>
                                <div style="font-size: 0.8rem; color: #9CA3AF;">{{ $data->user->email ?? '-' }}</div>
                            </td>
                        @endif

                        {{-- Status Bayar --}}
                        <td>
                            @php
                                $status = $data->status_pembayaran ?? 'pending';
                                $badgeColor = match($status) {
                                    'verified' => '#10B981',
                                    'ditolak' => '#EF4444',
                                    default => '#F59E0B',
                                };
                                $badgeBg = match($status) {
                                    'verified' => 'rgba(16,185,129,0.15)',
                                    'ditolak' => 'rgba(239,68,68,0.15)',
                                    default => 'rgba(245,158,11,0.15)',
                                };
                                $label = match($status) {
                                    'verified' => 'Lunas / Verified',
                                    'ditolak' => 'Ditolak',
                                    default => 'Pending',
                                };
                            @endphp
                            <span style="display:inline-block; padding:4px 12px; border-radius:6px; font-size:0.75rem; font-weight:600; background:{{ $badgeBg }}; color:{{ $badgeColor }};">
                                {{ $label }}
                            </span>
                            @if($status == 'ditolak' && $data->alasan_penolakan)
                                <div style="font-size:0.7rem; color:#FCA5A5; margin-top:4px;">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $data->alasan_penolakan }}
                                </div>
                            @endif

                            @if(auth()->user()->role == 'admin' && $data->bukti_bayar)
                                <div style="margin-top:6px;">
                                    <a href="{{ asset('uploads/pembayaran/' . $data->bukti_bayar) }}" target="_blank" style="font-size:0.7rem; color:#60A5FA; text-decoration:none;">
                                        <i class="fa-solid fa-receipt"></i> Lihat bukti
                                    </a>
                                </div>
                            @endif

                            @if(auth()->user()->role == 'admin' && $data->bukti_bayar && $status == 'pending')
                                <div style="display:flex; gap:5px; margin-top:8px;">
                                    <form action="{{ route('admin.pembayaran.verifikasi', $data->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn" style="padding:4px 10px; font-size:0.7rem; background:#10B981; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                            <i class="fa-solid fa-check"></i> Verif
                                        </button>
                                    </form>
                                    <button type="button" class="btn" style="padding:4px 10px; font-size:0.7rem; background:#EF4444; color:#fff; border:none; border-radius:6px; cursor:pointer;" onclick="openModal('modalTolak{{ $data->id }}')">
                                        <i class="fa-solid fa-times"></i> Tolak
                                    </button>
                                </div>
                            @endif
                        </td>

                        {{-- Kelulusan --}}
                        <td>
                            @php
                                $kl = $data->status_kelulusan ?? 'pending';
                                $klBadge = match($kl) {
                                    'lolos' => ['bg'=>'rgba(16,185,129,0.15)','color'=>'#10B981','text'=>'Lolos'],
                                    'tidak_lolos' => ['bg'=>'rgba(239,68,68,0.15)','color'=>'#EF4444','text'=>'Tidak Lolos'],
                                    default => ['bg'=>'rgba(245,158,11,0.15)','color'=>'#F59E0B','text'=>'Pending'],
                                };
                            @endphp
                            <span style="display:inline-block; padding:4px 10px; border-radius:6px; font-size:0.72rem; font-weight:600; background:{{ $klBadge['bg'] }}; color:{{ $klBadge['color'] }};">
                                {{ $klBadge['text'] }}
                            </span>
                            @if($kl == 'lolos')
                                @if(auth()->user()->role != 'admin')
                                <div style="margin-top:4px;">
                                    <a href="{{ route('tiket.finalis') }}" style="font-size:0.7rem; color:#10B981; text-decoration:none;">
                                        <i class="fa-solid fa-ticket"></i> Cetak Tiket
                                    </a>
                                </div>
                                @endif
                            @endif
                            @if(auth()->user()->role == 'admin')
                                <div style="display:flex; gap:4px; margin-top:6px;">
                                    @if($kl != 'lolos')
                                    <form action="{{ route('admin.kelulusan.atur', [$data->id, 'lolos']) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn" style="padding:3px 8px; font-size:0.65rem; background:#10B981; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                                            Loloskan
                                        </button>
                                    </form>
                                    @endif
                                    @if($kl != 'tidak_lolos' && $kl != 'pending')
                                    <form action="{{ route('admin.kelulusan.atur', [$data->id, 'tidak_lolos']) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn" style="padding:3px 8px; font-size:0.65rem; background:#EF4444; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                                            Gugurkan
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <td @if($colHideProposal) style="display:none;" @endif>
                            @php
                                $isLocked = auth()->user()->role != 'admin' && ($data->status_pembayaran ?? 'pending') != 'verified';
                                $uploadTutup = auth()->user()->role != 'admin' && ($pengaturan->status_upload_postervideo_ditutup ?? false);
                                $hasProposal = $data->proposal;
                            @endphp
                            @if(in_array($data->id_lomba, [1,3]))
                                @if($hasProposal)
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <a href="{{ asset('uploads/proposal/' . $data->proposal) }}" target="_blank" class="btn btn-info-outline" style="padding: 5px 10px;">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        @if(!$uploadTutup)
                                        <button class="btn btn-orange" style="padding: 5px 10px;" onclick="openModal('modalProposal{{ $data->id }}')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-danger-outline" style="padding: 5px 10px;" onclick="openModal('modalHapusProposal{{ $data->id }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @elseif($isLocked)
                                    <span style="color:#6B7280; font-size:0.78rem;">
                                        <i class="fa-solid fa-lock"></i> Verifikasi pembayaran dulu
                                    </span>
                                @elseif($uploadTutup)
                                    <span style="color:#EF4444; font-size:0.78rem;">
                                        <i class="fa-solid fa-ban"></i> Upload ditutup
                                    </span>
                                @else
                                    <button class="btn btn-orange" onclick="openModal('modalProposal{{ $data->id }}')">
                                        <i class="fa-solid fa-upload"></i> Upload
                                    </button>
                                @endif
                            @else
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @endif
                        </td>

                        <td @if($colHideSubtema) style="display:none;" @endif>
                            @if($data->id_lomba == 1 && $data->subtema)
                                <span style="color:#fff; font-size:0.85rem;">{{ $data->subtema }}</span>
                            @elseif($data->id_lomba == 1)
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @else
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @endif
                        </td>

                        <td>
                            @if(auth()->user()->role == 'admin')
                                @if($data->orisinalitas)
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <a href="{{ asset('uploads/orisinalitas/' . $data->orisinalitas) }}" target="_blank" class="btn btn-info-outline" style="padding: 5px 10px;">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <button class="btn btn-danger-outline" style="padding: 5px 10px;" onclick="openModal('modalHapusOrisinalitas{{ $data->id }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @else
                                    <span style="color:#6B7280; font-size:0.78rem;">-</span>
                                @endif
                            @else
                                @if($data->orisinalitas)
                                    <div style="display:flex; flex-direction:column; gap:4px;">
                                        <span style="color:#10B981; font-size:0.78rem;">
                                            <i class="fa-solid fa-check-circle"></i> Terkumpul
                                        </span>
                                        @if(!$uploadTutup)
                                            <button class="btn btn-danger-outline" style="padding:3px 8px; font-size:0.7rem;" onclick="openModal('modalHapusOrisinalitas{{ $data->id }}')">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                @elseif(!$isLocked && !$uploadTutup)
                                    <button class="btn btn-orange" style="padding:10px 20px; font-size:0.72rem;" onclick="openModal('modalOrisinalitas{{ $data->id }}')">
                                        <i class="fa-solid fa-file-signature"></i> Upload
                                    </button>
                                @elseif($uploadTutup)
                                    <span style="color:#EF4444; font-size:0.7rem;"><i class="fa-solid fa-ban"></i> Ditutup</span>
                                @else
                                    <span style="color:#6B7280; font-size:0.78rem;">-</span>
                                @endif
                            @endif
                        </td>

                        <td>
                            @if(auth()->user()->role != 'admin')
                                @php
                                    $idLomba = $data->id_lomba;
                                    $hasGambar = $data->gambar_karya;
                                    $hasLinkVideo = $data->link_video_karya;
                                    $hasSpecificKarya = ($idLomba == 1 && $data->judul_karya) || ($idLomba == 2 && $hasGambar) || ($idLomba == 3 && $data->judul_karya) || ($idLomba == 4 && $hasLinkVideo);
                                    $karyaSubmitted = $data->judul_karya && $hasSpecificKarya;
                                    $karyaEditBuka = ($pengaturan->status_pengumpulan_karya ?? 0) && !$uploadTutup;
                                @endphp
                                @if(($data->status_pembayaran ?? 'pending') != 'verified')
                                    <span style="color:#6B7280; font-size:0.78rem;"><i class="fa-solid fa-lock"></i></span>
                                @elseif($isExpired)
                                    <span style="color:#EF4444; font-size:0.78rem;"><i class="fa-solid fa-clock"></i> Ditutup</span>
                                @elseif($karyaSubmitted)
                                    <div style="display:flex; flex-direction:column; gap:2px;">
                                        <span style="color:#10B981; font-size:0.78rem;">
                                            <i class="fa-solid fa-check-circle"></i> Terkumpul
                                        </span>
                                        @if($data->judul_karya)
                                            <span style="color:#F97316; font-size:0.82rem; font-weight:600;">
                                                <i class="fa-solid fa-quote-left"></i> {{ $data->judul_karya }}
                                            </span>
                                        @endif
                                        @if($karyaEditBuka)
                                            <button class="btn btn-orange" style="padding:3px 10px; font-size:0.7rem; margin-top:4px;" onclick="openModal('modalEditKarya{{ $data->id }}')">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                        @endif
                                    </div>
                                @elseif($uploadTutup)
                                    <span style="color:#EF4444; font-size:0.78rem;"><i class="fa-solid fa-ban"></i> Upload ditutup</span>
                                @else
                                    <button class="btn btn-orange" style="padding:5px 10px; font-size:0.78rem;" onclick="openModal('modalKarya{{ $data->id }}')">
                                        <i class="fa-solid fa-upload"></i> Kumpulkan Karya
                                    </button>
                                @endif
                            @else
                                @if($data->judul_karya)
                                    <div style="display:flex; flex-direction:column; gap:2px;">
                                        <span style="color:#10B981; font-size:0.78rem;">
                                            <i class="fa-solid fa-check-circle"></i> Terkumpul
                                        </span>
                                        <span style="color:#F97316; font-size:0.82rem; font-weight:600;">
                                            <i class="fa-solid fa-quote-left"></i> {{ $data->judul_karya }}
                                        </span>
                                    </div>
                                @else
                                    <span style="color:#6B7280; font-size:0.78rem;">—</span>
                                @endif
                            @endif
                        </td>

                        <td @if($colHideLihatKarya) style="display:none;" @endif>
                            @php
                                $lkIdLomba = $data->id_lomba;
                                $lkHasGambar = $data->gambar_karya;
                                $lkHasLinkVideo = $data->link_video_karya;
                            @endphp
                            @if($lkIdLomba == 2 && $lkHasGambar)
                                <a href="{{ asset('uploads/karya/' . $data->gambar_karya) }}" target="_blank" class="btn btn-info-outline" style="padding:5px 12px;">
                                    <i class="fa-solid fa-image"></i> Lihat Karya
                                </a>
                            @elseif($lkIdLomba == 4 && $lkHasLinkVideo)
                                <a href="{{ $data->link_video_karya }}" target="_blank" class="btn btn-info-outline" style="padding:5px 12px;">
                                    <i class="fa-solid fa-video"></i> Lihat Video
                                </a>
                            @else
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-icons">
                                <button class="icon-btn" style="color:#60A5FA" onclick="openModal('modalDetail{{ $data->id }}')" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="https://wa.me/{{ $data->hp_ketua }}" target="_blank" class="icon-btn" style="color:#25D366" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <button type="button" class="icon-btn" style="color:#EF4444" onclick="openModal('modalHapusPendaftaran{{ $data->id }}')" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? 11 : 10 }}" style="text-align:center; padding:60px; color:#4B5563;">
                            Anda belum mendaftarkan tim manapun.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>

        {{-- Pagination — Admin only --}}
        @if(auth()->user()->role == 'admin' && method_exists($datas, 'links'))
        <div style="margin-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <span style="color:#6B7280; font-size:0.8rem;">
                Menampilkan {{ $datas->firstItem() ?? 0 }} – {{ $datas->lastItem() ?? 0 }} dari {{ $datas->total() }} data
            </span>
            <div style="display:flex; gap:6px; align-items:center;">
                @if($datas->onFirstPage())
                    <span style="padding:6px 12px; background:#222; color:#6B7280; border-radius:8px; font-size:0.8rem;">« Prev</span>
                @else
                    <a href="{{ $datas->previousPageUrl() }}&filter_kategori={{ $filterKategori }}" style="padding:6px 12px; background:#333; color:#fff; border-radius:8px; font-size:0.8rem; text-decoration:none;">« Prev</a>
                @endif

                @php
                    $currentPage = $datas->currentPage();
                    $lastPage = $datas->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp
                @for($i = $start; $i <= $end; $i++)
                    @if($i == $currentPage)
                        <span style="padding:6px 14px; background:#F97316; color:#fff; border-radius:8px; font-size:0.8rem; font-weight:700;">{{ $i }}</span>
                    @else
                        <a href="{{ $datas->url($i) }}&filter_kategori={{ $filterKategori }}" style="padding:6px 14px; background:#333; color:#9CA3AF; border-radius:8px; font-size:0.8rem; text-decoration:none;">{{ $i }}</a>
                    @endif
                @endfor

                @if($datas->hasMorePages())
                    <a href="{{ $datas->nextPageUrl() }}&filter_kategori={{ $filterKategori }}" style="padding:6px 12px; background:#333; color:#fff; border-radius:8px; font-size:0.8rem; text-decoration:none;">Next »</a>
                @else
                    <span style="padding:6px 12px; background:#222; color:#6B7280; border-radius:8px; font-size:0.8rem;">Next »</span>
                @endif
            </div>
        </div>
        @endif

    </div>

{{-- All Modals --}}
@foreach ($datas as $data)
    <div id="modalDetail{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#F97316; margin-bottom:20px; font-family:'Montserrat';">Detail Tim</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Nama Tim</label>
                    <strong>{{ $data->tim->nama_tim ?? 'N/A' }}</strong>
                </div>
                <div class="detail-item">
                    <label>Kategori Lomba</label>
                    <strong>{{ $data->kategori->nama_lomba ?? 'N/A' }}</strong>
                </div>
                <div class="detail-item">
                    <label>Asal Sekolah</label>
                    <strong>{{ $data->tim->asal_sekolah ?? 'N/A' }}</strong>
                </div>
                <div class="detail-item">
                    <label>Pembimbing</label>
                    <strong>{{ $data->tim->guru_pembimbing ?? 'N/A' }}</strong>
                </div>
                <hr class="detail-separator">
                <div class="detail-item">
                    <label>Ketua</label>
                    <strong>{{ $data->nama_ketua ?? 'N/A' }}</strong>
                </div>
                <div class="detail-item">
                    <label>No WA Ketua</label>
                    <strong>{{ $data->hp_ketua ?? 'N/A' }}</strong>
                </div>
                @if($data->anggota_1)
                    <div class="detail-item">
                        <label>Anggota 1</label>
                        <strong>{{ $data->anggota_1 }}{{ $data->hp_1 ? ' - ' . $data->hp_1 : '' }}</strong>
                    </div>
                @endif
                @if($data->anggota_2)
                    <div class="detail-item">
                        <label>Anggota 2</label>
                        <strong>{{ $data->anggota_2 }}{{ $data->hp_2 ? ' - ' . $data->hp_2 : '' }}</strong>
                    </div>
                @endif
                @if($data->anggota_3)
                    <div class="detail-item">
                        <label>Anggota 3</label>
                        <strong>{{ $data->anggota_3 }}{{ $data->hp_3 ? ' - ' . $data->hp_3 : '' }}</strong>
                    </div>
                @endif
                <hr class="detail-separator">
                <div class="detail-item">
                    <label>Bukti KTM/Kartu Pelajar/Status Aktif</label>
                    @if($data->bukti_status_aktif)
                        @php
                            $extStatus = strtolower(pathinfo($data->bukti_status_aktif, PATHINFO_EXTENSION));
                            $isStatusImg = in_array($extStatus, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        @if($isStatusImg)
                            <div style="margin-top: 8px;">
                                <a href="{{ asset('uploads/status_aktif/' . $data->bukti_status_aktif) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset('uploads/status_aktif/' . $data->bukti_status_aktif) }}" alt="Bukti Status Aktif" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: block; object-fit: contain;">
                                </a>
                            </div>
                        @else
                            <strong>
                                <a href="{{ asset('uploads/status_aktif/' . $data->bukti_status_aktif) }}" target="_blank" style="color: #60A5FA; text-decoration: none;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat PDF Bukti Aktif
                                </a>
                            </strong>
                        @endif
                    @else
                        <strong style="color: #EF4444;">Belum diunggah</strong>
                    @endif

                    @if(auth()->user()->role == 'admin' || ($data->status_pembayaran ?? 'pending') == 'pending')
                    <div style="margin-top: 8px;">
                        <button type="button" class="btn btn-outline btn-edit-status-toggle-{{ $data->id }}" style="padding: 4px 8px; font-size: 0.75rem;" onclick="document.getElementById('editStatusForm{{ $data->id }}').style.display = 'block'; this.style.display = 'none';">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form id="editStatusForm{{ $data->id }}" action="{{ route('Lomba.peserta.updatestatusaktif', $data->user_id) }}" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 8px;">
                            @csrf @method('PATCH')
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="file" name="bukti_status_aktif" class="form-control" required accept=".pdf,.jpg,.jpeg,.png" style="padding: 4px; font-size: 0.8rem;">
                                <button type="submit" class="btn btn-orange" style="padding: 6px 12px; font-size: 0.8rem;">Simpan</button>
                                <button type="button" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;" onclick="document.getElementById('editStatusForm{{ $data->id }}').style.display = 'none'; document.querySelector('.btn-edit-status-toggle-{{ $data->id }}').style.display = 'inline-flex';">Batal</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
                <div class="detail-item">
                    <label>Bukti Follow Sosmed</label>
                    @if($data->bukti_sosmed)
                        @php
                            $extSosmed = strtolower(pathinfo($data->bukti_sosmed, PATHINFO_EXTENSION));
                            $isSosmedImg = in_array($extSosmed, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        @if($isSosmedImg)
                            <div style="margin-top: 8px;">
                                <a href="{{ asset('uploads/sosmed/' . $data->bukti_sosmed) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset('uploads/sosmed/' . $data->bukti_sosmed) }}" alt="Bukti Follow Sosmed" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: block; object-fit: contain;">
                                </a>
                            </div>
                        @else
                            <strong>
                                <a href="{{ asset('uploads/sosmed/' . $data->bukti_sosmed) }}" target="_blank" style="color: #60A5FA; text-decoration: none;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat PDF Follow Sosmed
                                </a>
                            </strong>
                        @endif
                    @else
                        <strong style="color: #EF4444;">Belum diunggah</strong>
                    @endif

                    @if(auth()->user()->role == 'admin' || ($data->status_pembayaran ?? 'pending') == 'pending')
                    <div style="margin-top: 8px;">
                        <button type="button" class="btn btn-outline btn-edit-sosmed-toggle-{{ $data->id }}" style="padding: 4px 8px; font-size: 0.75rem;" onclick="document.getElementById('editSosmedForm{{ $data->id }}').style.display = 'block'; this.style.display = 'none';">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form id="editSosmedForm{{ $data->id }}" action="{{ route('Lomba.peserta.updatesosmed', $data->user_id) }}" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 8px;">
                            @csrf @method('PATCH')
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="file" name="bukti_sosmed" class="form-control" required accept=".pdf,.jpg,.jpeg,.png" style="padding: 4px; font-size: 0.8rem;">
                                <button type="submit" class="btn btn-orange" style="padding: 6px 12px; font-size: 0.8rem;">Simpan</button>
                                <button type="button" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;" onclick="document.getElementById('editSosmedForm{{ $data->id }}').style.display = 'none'; document.querySelector('.btn-edit-sosmed-toggle-{{ $data->id }}').style.display = 'inline-flex';">Batal</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            <button class="btn btn-outline" style="width:100%; margin-top:20px;" onclick="closeModal('modalDetail{{ $data->id }}')">Tutup</button>
        </div>
    </div>

    <div id="modalProposal{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3>Upload / Edit Proposal</h3>
            @if($data->proposal)
            <p style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-info-circle"></i> File lama akan diganti dengan file baru.
            </p>
            @endif
            <form action="{{ route('Lomba.peserta.tambahproposal', $data->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group"><input type="file" name="proposal" class="form-control" required accept=".pdf"></div>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalProposal{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalHapusPendaftaran{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
            <h3>Hapus Pendaftaran?</h3>
            <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6; margin:10px 0 0;">
                Data pendaftaran tim {{ $data->tim->nama_tim ?? 'ini' }} akan dihapus.
            </p>
            <form action="{{ route('Lomba.peserta.destroy', Crypt::encrypt($data->id)) }}" method="POST">
                @csrf @method('DELETE')
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalHapusPendaftaran{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1; background:#EF4444;">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalHapusProposal{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
            <h3>Hapus Proposal?</h3>
            <form action="{{ route('Lomba.peserta.hapusproposal', $data->user_id) }}" method="POST">
                @csrf @method('DELETE')
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalHapusProposal{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1; background:#EF4444;">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalOrisinalitas{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3>Upload Lembar Orisinalitas</h3>
            <p style="color: #9CA3AF; font-size: 0.8rem; margin-bottom: 1rem;">Pastikan file dalam format PDF.</p>
            <form action="{{ route('Lomba.peserta.tambahorisinalitas', $data->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group"><input type="file" name="orisinalitas" class="form-control" required accept=".pdf"></div>
                <button type="submit" class="btn btn-orange" style="width:100%">Kirim Berkas</button>
            </form>
            <button class="btn btn-outline" style="width:100%; margin-top:10px;" onclick="closeModal('modalOrisinalitas{{ $data->id }}')">Batal</button>
        </div>
    </div>

    <div id="modalHapusOrisinalitas{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
            <h3>Hapus Lembar Orisinalitas?</h3>
            <form action="{{ route('Lomba.peserta.hapusorisinalitas', $data->user_id) }}" method="POST">
                @csrf @method('DELETE')
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalHapusOrisinalitas{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1; background:#EF4444;">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@foreach ($datas as $data)
    @if(auth()->user()->role == 'admin' && $data->bukti_bayar && ($data->status_pembayaran ?? 'pending') == 'pending')
    <div id="modalTolak{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#EF4444; font-family:'Montserrat';">Tolak Pembayaran</h3>
            <p style="color:#9CA3AF; font-size:0.85rem; margin-bottom:1rem;">
                Menolak pembayaran tim <strong>{{ $data->tim->nama_tim ?? '#' . $data->id }}</strong>
            </p>
            <form action="{{ route('admin.pembayaran.tolak', $data->id) }}" method="POST">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label>Alasan penolakan</label>
                    <textarea name="alasan_penolakan" class="form-control" rows="3" placeholder="Contoh: Bukti tidak jelas, nominal kurang..." required></textarea>
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalTolak{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn" style="flex:1; background:#EF4444; color:#fff; border:none; padding:0.75rem; border-radius:8px; font-weight:700; cursor:pointer;">
                        <i class="fa-solid fa-times"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach

{{-- Modal Karya per peserta --}}
@foreach ($datas as $data)
    @php $idLomba = $data->id_lomba; @endphp
    @if(auth()->user()->role != 'admin' && ($data->status_pembayaran ?? 'pending') == 'verified' && !$isExpired && !($pengaturan->status_upload_postervideo_ditutup ?? false)
        && !(($idLomba == 1 && $data->judul_karya) || ($idLomba == 2 && $data->gambar_karya) || ($idLomba == 3 && $data->judul_karya) || ($idLomba == 4 && $data->link_video_karya)))
    <div id="modalKarya{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#F97316; font-family:'Montserrat'; margin-bottom:4px;">Kumpulkan Karya</h3>
            <div style="font-size:0.8rem; color:#9CA3AF; margin-bottom:20px;">
                {{ $data->kategori->nama_lomba ?? '-' }}
                &nbsp;— Deadline: <strong>13 Agustus 2026 pukul 23:59 WIB</strong>
            </div>
            <form action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Judul Karya <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="judul_karya" class="form-control" placeholder="Masukkan judul karya" required>
                </div>
                @if($idLomba == 1)
                <div class="form-group">
                    <label>Pilih Subtema <span style="color:#EF4444;">*</span></label>
                    <select name="subtema" class="form-control" required>
                        <option value="">— Pilih Subtema —</option>
                        <option value="Manajemen absensi">Manajemen absensi</option>
                        <option value="Perpustakaan">Perpustakaan</option>
                        <option value="Ekstrakurikuler">Ekstrakurikuler</option>
                        <option value="Kantin sehat">Kantin sehat</option>
                    </select>
                </div>
                @endif
                @if($idLomba == 2)
                <div class="form-group">
                    <label>Upload File Poster <span style="color:#EF4444;">*</span> (JPG/JPEG/PNG, min 300dpi, maks 15MB, wajib logo Polije/HMJTI/EPIM)</label>
                    <input type="file" name="gambar_karya" class="form-control" accept=".jpg,.jpeg,.png" required>
                </div>
                @endif
                @if($idLomba == 4)
                <div class="form-group">
                    <label>Link Video <span style="color:#EF4444;">*</span> (Setting: "Siapa saja dengan link dapat melihat")</label>
                    <input type="url" name="link_video_karya" class="form-control" placeholder="https://drive.google.com/..." required>
                </div>
                @endif
                <div style="background:#1a1a1a; border:1px solid rgba(249,115,22,0.3); border-radius:12px; padding:1.2rem; margin-bottom:20px;">
                    <label style="display:flex; gap:12px; align-items:flex-start; cursor:pointer;">
                        <input type="checkbox" name="accepted_integrity_karya" value="1" required style="accent-color:#F97316; width:20px; height:20px; margin-top:2px;">
                        <span style="font-size:0.82rem; color:#d1d5db; line-height:1.6;">
                            <strong style="color:#F97316;">Pernyataan Integritas</strong><br>
                            Saya menyatakan bahwa karya ini adalah <strong>asli buatan sendiri/tim</strong>,
                            tidak menggunakan <strong>AI Generatif</strong> secara penuh, dan bersedia
                            <strong>didiskualifikasi</strong> jika terbukti melanggar.
                        </span>
                    </label>
                </div>
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalKarya{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Karya
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach

{{-- Modal Edit Karya per peserta --}}
@foreach ($datas as $data)
    @php $ekIdLomba = $data->id_lomba; @endphp
    @if(auth()->user()->role != 'admin' && $data->judul_karya && ($pengaturan->status_pengumpulan_karya ?? 0) && !$uploadTutup)
    <div id="modalEditKarya{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#F97316; font-family:'Montserrat'; margin-bottom:4px;">Edit Karya</h3>
            <div style="font-size:0.8rem; color:#9CA3AF; margin-bottom:20px;">
                {{ $data->kategori->nama_lomba ?? '-' }}
                &nbsp;— Deadline: <strong>13 Agustus 2026 pukul 23:59 WIB</strong>
            </div>
            <form action="{{ route('karya.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label>Judul Karya <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="judul_karya" class="form-control" value="{{ old('judul_karya', $data->judul_karya) }}" required>
                </div>
                @if($ekIdLomba == 1)
                <div class="form-group">
                    <label>Pilih Subtema <span style="color:#EF4444;">*</span></label>
                    <select name="subtema" class="form-control" required>
                        <option value="">— Pilih Subtema —</option>
                        @foreach(['Manajemen absensi','Perpustakaan','Ekstrakurikuler','Kantin sehat'] as $st)
                            <option value="{{ $st }}" {{ ($data->subtema ?? '') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label>Upload Bukti Orisinalitas (PDF, maks 10MB) <span style="color:#6B7280; font-size:0.75rem;">— kosongkan jika tidak diganti</span></label>
                    <input type="file" name="orisinalitas" class="form-control" accept=".pdf">
                    @if($data->orisinalitas)
                        <div style="margin-top:6px; display:flex; align-items:center; gap:8px;">
                            <span style="color:#10B981; font-size:0.78rem;"><i class="fa-solid fa-check-circle"></i> File sudah ada</span>
                            <a href="{{ asset('uploads/orisinalitas/' . $data->orisinalitas) }}" target="_blank" class="btn btn-info-outline" style="padding:3px 8px; font-size:0.7rem;">Lihat</a>
                        </div>
                    @endif
                </div>
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalEditKarya{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach

<div id="modalCreate" class="modal">
    <div class="modal-content">
        <h3 style="color:#F97316; margin-top:0; font-family:'Montserrat';">Registrasi Tim Baru</h3>
        <div class="step-indicator">
            <div id="ind1" style="background:#F97316;"></div>
            <div id="ind2" style="background:#333;"></div>
            <div id="ind3" style="background:#333;"></div>
        </div>

        <form id="formPendaftaran" action="{{ route('Lomba.peserta.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="step1">
                <div class="form-group">
                    <label>Nama Tim</label>
                    <input type="text" name="nama_tim" class="form-control" value="{{ old('nama_tim') }}" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                    @error('nama_tim') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}" required pattern="^[^<>]+$">
                    @error('asal_sekolah') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Guru Pembimbing</label>
                    <input type="text" name="guru_pembimbing" class="form-control" value="{{ old('guru_pembimbing') }}" required pattern="^[^<>]+$">
                    @error('guru_pembimbing') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Kategori Lomba</label>
                    <select name="id_lomba" class="form-control" required>
                        <option value="">-- Pilih Bidang Lomba --</option>
                        @foreach($listKategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('id_lomba') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_lomba }}</option>
                        @endforeach
                    </select>
                    @error('id_lomba') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <button type="button" class="btn btn-orange" style="width:100%" onclick="goToStep(2)">Lanjut <i class="fa-solid fa-arrow-right"></i></button>
            </div>

            <div id="step2" style="display:none;">
                <div class="input-grid">
                    <div class="form-group">
                        <label>Nama Ketua <span class="required">*</span></label>
                        <input type="text" name="nama_ketua" class="form-control" value="{{ old('nama_ketua') }}" required pattern="^[^<>]+$">
                        @error('nama_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>NIS/NIM Ketua <span class="required">*</span></label>
                        <input type="text" name="nis_nim_ketua" class="form-control" value="{{ old('nis_nim_ketua') }}" required placeholder="Contoh: 12345678">
                        @error('nis_nim_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="input-grid">
                    <div class="form-group">
                        <label>No WA Ketua <span class="required">*</span></label>
                        <input type="text" name="hp_ketua" class="form-control" value="{{ old('hp_ketua') }}" required placeholder="08xxx" pattern="^[0-9+\-\s]+$">
                        @error('hp_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <p style="color:#9CA3AF; font-size:0.75rem; border-top:1px solid #333; padding-top:15px;">Anggota Tim</p>
                <div id="anggotaContainer"></div>
                <button type="button" id="tambahAnggotaBtn" class="btn btn-outline" style="width:100%; margin-top:10px;" onclick="tambahAnggota()">
                    <i class="fa-solid fa-plus"></i> Tambah Anggota
                </button>
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="goToStep(1)">Kembali</button>
                    <button type="button" class="btn btn-orange" style="flex:1" onclick="goToStep(3)">Lanjut</button>
                </div>
            </div>

            <div id="step3" style="display:none;">
                <div id="paymentInfo" style="background:#1a1a1a; padding:20px; border-radius:12px; margin-bottom:20px; text-align:center; border: 1px dashed #444;">
                    <p style="font-size:0.85rem; color:#9CA3AF; margin-bottom:5px;">Tagihan <strong id="paymentLabel" style="color:#fff;">-</strong></p>
                    <strong id="paymentNominal" style="font-size:1.5rem; color:#F97316;">Rp 0</strong><br>
                    <div style="margin-top:12px; padding-top:12px; border-top:1px solid #333;">
                        <p style="font-size:0.8rem; color:#9CA3AF; margin-bottom:6px;">Transfer ke:</p>
                        <strong id="paymentRekening" style="font-size:1.1rem; color:#fff;"></strong><br>
                        <span id="paymentAn" style="font-size:0.8rem; color:#9CA3AF;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Upload Bukti Transfer <span style="color:#EF4444;">*</span> (JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" required accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    @error('bukti_bayar') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Upload Bukti Status Aktif <span style="color:#EF4444;">*</span> (Kartu Pelajar/KTM, PDF/JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_status_aktif" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_status_aktif') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Upload Bukti Follow Sosial Media EPIM <span style="color:#EF4444;">*</span> (PDF/JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_sosmed" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_sosmed') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div style="background:#1a1a1a; border:1px solid rgba(249,115,22,0.3); border-radius:12px; padding:1.2rem; margin-bottom:20px;">
                    <label style="display:flex; gap:12px; align-items:flex-start; cursor:pointer;">
                        <input type="checkbox" name="accepted_integrity" value="1" required style="accent-color:#F97316; width:20px; height:20px; margin-top:2px;">
                        <span style="font-size:0.82rem; color:#d1d5db; line-height:1.6;">
                            <strong style="color:#F97316;">Pernyataan Integritas</strong><br>
                            Saya menyatakan bahwa karya yang akan saya kumpulkan adalah <strong>asli buatan sendiri/tim</strong>,
                            tidak menggunakan <strong>AI Generatif</strong> secara penuh, dan siap
                            <strong>didiskualifikasi</strong> jika terbukti melanggar.
                        </span>
                    </label>
                    @error('accepted_integrity') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="goToStep(2)">Kembali</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">Daftar Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extraJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const PAYMENT_MAP = {
        1: { label: 'Web Programming', nominal: 75000, bank: 'BRI', rekening: '1234-5678-9012', an: 'JULIANA INTAN' },
        2: { label: 'Design Poster', nominal: 50000, bank: 'BRI', rekening: '1234-5678-9012', an: 'JULIANA INTAN' },
        3: { label: 'Design Packaging', nominal: 50000, bank: 'Mandiri', rekening: '9876-5432-1098', an: 'AGNESS SHERLYTA ANGG' },
        4: { label: 'Videography', nominal: 50000, bank: 'Mandiri', rekening: '9876-5432-1098', an: 'AGNESS SHERLYTA ANGG' },
    };

    function openModal(id) {
        if(id === 'modalCreate') goToStep(1);
        const el = document.getElementById(id);
        if (el) el.style.display = "block";
    }

    function closeModal(id) { const el = document.getElementById(id); if (el) el.style.display = "none"; }

    window.onclick = function(e) {
        if(e.target.classList && e.target.classList.contains('modal')) e.target.style.display = "none";
    }

    function validateStep(step) {
        const currentStep = document.getElementById('step' + step);
        const inputs = currentStep.querySelectorAll('input, select');
        for (const input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }
        }
        return true;
    }

    function goToStep(step) {
        const activeStep = document.querySelector('[id^="step"][style*="block"]');
        const activeStepNumber = activeStep ? Number(activeStep.id.replace('step', '')) : 1;
        if (step > activeStepNumber && !validateStep(activeStepNumber)) return;

        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'none';
        document.getElementById('step' + step).style.display = 'block';

        document.getElementById('ind1').style.background = (step >= 1) ? '#F97316' : '#333';
        document.getElementById('ind2').style.background = (step >= 2) ? '#F97316' : '#333';
        document.getElementById('ind3').style.background = (step >= 3) ? '#F97316' : '#333';
        if (step === 3) updatePaymentInfo();
    }

    function updatePaymentInfo() {
        const select = document.querySelector('select[name="id_lomba"]');
        const idLomba = parseInt(select?.value);
        const info = PAYMENT_MAP[idLomba];
        document.getElementById('paymentLabel').textContent = info ? info.label : '-';
        document.getElementById('paymentNominal').textContent = info ? 'Rp ' + info.nominal.toLocaleString('id-ID') : 'Rp 0';
        document.getElementById('paymentRekening').textContent = info ? info.bank + ' : ' + info.rekening : '-';
        document.getElementById('paymentAn').textContent = info ? 'A/N ' + info.an : '';
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function () { openModal('modalCreate'); });
    @endif

    function getAnggotaMax() {
        const sel = document.querySelector('select[name="id_lomba"]');
        return sel && sel.value == '1' ? 3 : 2;
    }
    function countAnggota() { return document.querySelectorAll('#anggotaContainer .anggota-block').length; }
    function refreshAnggotaBtn() {
        const btn = document.getElementById('tambahAnggotaBtn');
        if (!btn) return;
        btn.style.display = countAnggota() >= getAnggotaMax() ? 'none' : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        refreshAnggotaBtn();
        @if(old('anggota_1')) tambahAnggota(1); @endif
        @if(old('anggota_2')) tambahAnggota(2); @endif
        @if(old('anggota_3')) tambahAnggota(3); @endif
        @if(old('anggota_4')) tambahAnggota(4); @endif
    });

    function tambahAnggota(forceNumber) {
        if (countAnggota() >= getAnggotaMax()) {
            alert('Maksimal ' + getAnggotaMax() + ' anggota untuk lomba ini.');
            return;
        }
        const blocks = document.querySelectorAll('#anggotaContainer .anggota-block');
        const num = forceNumber || (blocks.length + 1);
        if (document.getElementById('anggotaBlock-' + num)) return;

        const div = document.createElement('div');
        div.className = 'anggota-block';
        div.id = 'anggotaBlock-' + num;
        div.style.cssText = 'background:#1a1a1a; border:1px solid #333; border-radius:12px; padding:15px; margin-top:12px; position:relative;';
        div.innerHTML =
            '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">' +
                '<span style="color:#F97316; font-weight:600; font-size:0.85rem;">Anggota ' + num + '</span>' +
                '<button type="button" onclick="hapusAnggota(' + num + ')" style="background:none; border:none; color:#EF4444; cursor:pointer; font-size:1.1rem;" title="Hapus anggota">' +
                    '<i class="fa-solid fa-xmark"></i>' +
                '</button>' +
            '</div>' +
            '<div class="input-grid">' +
                '<div class="form-group" style="margin-bottom:10px;">' +
                    '<input type="text" name="anggota_' + num + '" class="form-control" placeholder="Nama Anggota ' + num + '">' +
                '</div>' +
                '<div class="form-group" style="margin-bottom:10px;">' +
                    '<input type="text" name="anggota_nis_' + num + '" class="form-control" placeholder="NIS/NIM Anggota ' + num + '">' +
                '</div>' +
            '</div>' +
            '<div class="form-group" style="margin-bottom:0;">' +
                '<input type="text" name="hp_' + num + '" class="form-control" placeholder="WA Anggota ' + num + '" pattern="^[0-9+\\-\\s]*$" title="Hanya boleh angka, spasi, +, atau -.">' +
            '</div>';
        document.getElementById('anggotaContainer').appendChild(div);
        refreshAnggotaBtn();
    }

    function hapusAnggota(num) {
        const block = document.getElementById('anggotaBlock-' + num);
        if (block) block.remove();
        refreshAnggotaBtn();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('select[name="id_lomba"]')?.addEventListener('change', function() {
            document.getElementById('anggotaContainer').innerHTML = '';
            refreshAnggotaBtn();
        });
    });

    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    });
    @endif
</script>
@endsection
