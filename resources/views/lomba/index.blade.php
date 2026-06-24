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
    .step-indicator {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }
    .step-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .step-line {
        height: 5px;
        border-radius: 10px;
        background: #333;
        transition: background-color 0.3s ease;
    }
    .step-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 4px;
    }
    .step-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: #6B7280;
        transition: color 0.3s ease;
        background-color: #F97316;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .step-text {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        transition: color 0.3s ease;
        line-height: 1.3;
        max-width: 120px;
    }
    /* Active & Completed States */
    .step-col.active .step-line,
    .step-col.completed .step-line {
        background: #F97316;
    }
    .step-col.active .step-number,
    .step-col.completed .step-number {
        color: #fff;
    }
    .step-col.active .step-text,
    .step-col.completed .step-text {
        color: #fff;
    }
    @media (max-width: 576px) {
        .step-text {
            font-size: 0.65rem;
        }
    }
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
    /* === Perlebar modal detail === */
    #modalDetail .modal-content,
    [id^="modalDetail"] .modal-content {
        max-width: 900px;
    }
    /* === Grid 2 kolom untuk Sosmed & Twibon === */
    .sosmed-twibon-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        grid-column: 1 / -1;
    }
    @media (max-width: 640px) {
        .sosmed-twibon-grid { grid-template-columns: 1fr; }
        [id^="modalDetail"] .modal-content { max-width: 100%; }
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

@if(($pengaturan->status_upload_postervideo_ditutup ?? false) && auth()->user()->role !== 'admin' && $userHasUnsubmittedKarya)
<div class="alert alert-danger" style="display:flex; align-items:center; gap:12px;">
    <i class="fa-solid fa-circle-exclamation" style="font-size:1.3rem;"></i>
    <span>Maaf, pengumpulan proposal/karya saat ini sudah <strong>ditutup</strong> oleh Admin.</span>
</div>
@endif

<div class="card-table">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
        <h3 style="margin:0; font-family:'Montserrat';">Status Pendaftaran</h3>
        @if(strtolower(auth()->user()->role ?? '') !== 'admin' && $datas->isEmpty())
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

    {{-- Admin: Filter Kategori & Status --}}
    @if(auth()->user()->role == 'admin')
    <form method="GET" action="{{ route('Lomba.peserta.index') }}" style="margin-bottom:1.5rem; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <!-- Filter Kategori -->
        <label style="color:#9CA3AF; font-size:0.85rem; font-weight:600;">
            <i class="fa-solid fa-filter"></i> Kategori:
        </label>
        <select name="filter_kategori" onchange="this.form.submit()" style="padding:0.6rem 1rem; background:#222; border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; outline:none; min-width:180px;">
            <option value="">— Semua Kategori —</option>
            @foreach($listKategori as $kat)
                <option value="{{ $kat->id }}" {{ ($filterKategori ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_lomba }}</option>
            @endforeach
        </select>

        <!-- Filter Status -->
        <label style="color:#9CA3AF; font-size:0.85rem; font-weight:600; margin-left:8px;">
            <i class="fa-solid fa-circle-info"></i> Status:
        </label>
        <select name="filter_status" onchange="this.form.submit()" style="padding:0.6rem 1rem; background:#222; border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; outline:none; min-width:180px;">
            <option value="">— Semua Status —</option>
            <option value="pending" {{ ($filterStatus ?? '') == 'pending' ? 'selected' : '' }}>Terdaftar (Pending)</option>
            <option value="lolos" {{ ($filterStatus ?? '') == 'lolos' ? 'selected' : '' }}>Lolos</option>
            <option value="tidak_lolos" {{ ($filterStatus ?? '') == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
        </select>

        <!-- Search Input -->
        <div style="position: relative; display: inline-flex; align-items: center; margin-left:8px;">
            <input type="text" name="search_tim" placeholder="Cari nama tim..." value="{{ request('search_tim') }}" 
                   style="padding: 0.6rem 1rem 0.6rem 2.2rem; background: #222; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; color: #fff; outline: none; min-width: 220px;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 0.8rem; color: #6B7280; font-size: 0.85rem;"></i>
        </div>

        <button type="submit" class="btn btn-orange" style="padding: 0.6rem 1.2rem; border-radius: 10px; font-weight: 600; border: none; cursor: pointer;">
            Cari
        </button>

        @if($filterKategori || $filterStatus || request('search_tim'))
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
                    $lombaIds = $datas->pluck('id_lomba')->unique();
                    // Original:
                    // $colHideProposal   = !$lombaIds->intersect([1,3])->count();
                    // $colHideKarya      = !$lombaIds->intersect([2,4])->count();
                    // $colHideLihatKarya = !$lombaIds->intersect([2,4])->count();
                    
                    // Lomba Baru (ID 2 = Network Engineering, ID 5 = Cyber Security):
                    $colHideProposal   = !$lombaIds->intersect([1,2,3,5])->count();
                    $colHideSubtema    = !$lombaIds->contains(1);
                    $colHideKarya      = !$lombaIds->intersect([4])->count();
                    $colHideLihatKarya = !$lombaIds->intersect([4])->count();
                @endphp
                <thead>
                    <tr>
                        <th>No</th>
                        @if(auth()->user()->role == 'admin')
                            <th>Tgl. Daftar</th>
                        @endif
                        <th>Info Tim & Lomba</th>
                        @if(auth()->user()->role == 'admin')
                            <th>Pendaftar (User)</th>
                        @endif
                        <th>Status</th>
                        {{-- Original: <th @if($colHideProposal) style="display:none;" @endif>Proposal</th> --}}
                        <th @if($colHideProposal) style="display:none;" @endif>Proposal / Berkas</th>
                        {{-- <th @if($colHideSubtema) style="display:none;" @endif>Sub Tema</th> --}}
                        <th>Orisinalitas</th>
                        <th @if($colHideKarya) style="display:none;" @endif>Karya</th>
                        <th @if($colHideLihatKarya) style="display:none;" @endif>Lihat Karya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
               <tbody>
                @forelse ($datas as $data)
                    @php
                        $isLocked = false;
                        $uploadTutup = ($pengaturan->status_upload_postervideo_ditutup ?? false);
                        $editAksiTutup = (($pengaturan->status_pendaftaran_ditutup ?? false) || ($pengaturan->status_upload_postervideo_ditutup ?? false));
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        @if(auth()->user()->role == 'admin')
                            <td>
                                @if($data->created_at)
                                    <div style="font-size: 0.82rem; color: #fff; font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($data->created_at)->timezone('Asia/Jakarta')->format('d M Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6B7280;">
                                        {{ \Carbon\Carbon::parse($data->created_at)->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                    </div>
                                @else
                                    <span style="color:#6B7280; font-size:0.8rem;">-</span>
                                @endif
                            </td>
                        @endif

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

                        {{-- Kelulusan --}}
                        <td>
                            @php
                                $kl = $data->status_kelulusan ?? 'pending';
                                $klBadge = match($kl) {
                                    'lolos' => ['bg'=>'rgba(16,185,129,0.15)','color'=>'#10B981','text'=>'Lolos'],
                                    'tidak_lolos' => ['bg'=>'rgba(239,68,68,0.15)','color'=>'#EF4444','text'=>'Tidak Lolos'],
                                    default => ['bg'=>'rgba(245,158,11,0.15)','color'=>'#F59E0B','text'=>'Terdaftar'],
                                };
                            @endphp
                            <span style="display:inline-block; padding:4px 10px; border-radius:6px; font-size:0.72rem; font-weight:600; background:{{ $klBadge['bg'] }}; color:{{ $klBadge['color'] }};">
                                {{ $klBadge['text'] }}
                            </span>
                            @if(auth()->user()->role != 'admin')
                                @if($kl == 'lolos')
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
                                    <button type="button" class="btn" onclick="openModal('modalLoloskan{{ $data->id }}')" style="padding:3px 8px; font-size:0.65rem; background:#10B981; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                                        Loloskan
                                    </button>
                                    @endif
                                    @if($kl != 'tidak_lolos' && $kl != 'pending')
                                    <button type="button" class="btn" onclick="openModal('modalGugurkan{{ $data->id }}')" style="padding:3px 8px; font-size:0.65rem; background:#EF4444; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                                        Gugurkan
                                    </button>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <td @if($colHideProposal) style="display:none;" @endif>
                            @php
                                $hasProposal = $data->proposal;
                            @endphp
                             {{-- Original: @if(in_array($data->id_lomba, [1,3])) --}}
                             @if(in_array($data->id_lomba, [1,2,3,5]))
                                @if($hasProposal)
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <a href="{{ asset('uploads/proposal/' . $data->proposal) }}" target="_blank" class="btn btn-info-outline" style="padding: 5px 10px;">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        @if(!$uploadTutup)
                                        <button class="btn btn-orange" style="padding: 5px 10px;" onclick="openModal('modalProposal{{ $data->id }}')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger-outline" style="padding: 5px 10px;" onclick="openModal('modalHapusProposal{{ $data->id }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        @endif
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

                        {{-- <td @if($colHideSubtema) style="display:none;" @endif>
                            @if($data->id_lomba == 1 && $data->subtema)
                                <span style="color:#fff; font-size:0.85rem;">{{ $data->subtema }}</span>
                            @elseif($data->id_lomba == 1)
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @else
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @endif
                        </td> --}}

                        <td>
                            @php
                                $hasOrisinalitas = $data->orisinalitas;
                            @endphp
                            @if($hasOrisinalitas)
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <a href="{{ asset('uploads/orisinalitas/' . $data->orisinalitas) }}" target="_blank" class="btn btn-info-outline" style="padding: 5px 10px;">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    @if(!$uploadTutup)
                                    <button class="btn btn-orange" style="padding: 5px 10px;" onclick="openModal('modalOrisinalitas{{ $data->id }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger-outline" style="padding: 5px 10px;" onclick="openModal('modalHapusOrisinalitas{{ $data->id }}')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                    @endif
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
                                <button class="btn btn-orange" style="padding:10px 20px; font-size:0.72rem;" onclick="openModal('modalOrisinalitas{{ $data->id }}')">
                                    <i class="fa-solid fa-file-signature"></i> Upload
                                </button>
                            @endif
                        </td>

                        <td @if($colHideKarya) style="display:none;" @endif>
                            @if(in_array($data->id_lomba, [1, 3]))
                                <span style="color:#6B7280; font-size:0.78rem;">—</span>
                            @else
                                    @php
                                        $idLomba = $data->id_lomba;
                                        $hasGambar = $data->gambar_karya;
                                        $hasLinkVideo = $data->link_video_karya;
                                        $hasSpecificKarya = ($idLomba == 2 && $hasGambar) || ($idLomba == 4 && $hasLinkVideo);
                                        $karyaSubmitted = $data->judul_karya && $hasSpecificKarya;
                                        $karyaEditBuka = ($pengaturan->status_pengumpulan_karya ?? 0);
                                        $adminOrNotExpired = auth()->user()->role == 'admin' || !$isExpired;
                                        $adminOrNotClosed = !$uploadTutup;
                                    @endphp
                                    @if(false)
                                        <span style="color:#6B7280; font-size:0.78rem;"><i class="fa-solid fa-lock"></i></span>
                                    @elseif(!$adminOrNotExpired)
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
                                    @elseif(!$adminOrNotClosed)
                                        <span style="color:#EF4444; font-size:0.78rem;"><i class="fa-solid fa-ban"></i> Upload ditutup</span>
                                    @else
                                        <button class="btn btn-orange" style="padding:5px 10px; font-size:0.78rem;" onclick="openModal('modalKarya{{ $data->id }}')">
                                            <i class="fa-solid fa-upload"></i> Kumpulkan Karya
                                        </button>
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
                                <button class="icon-btn" style="color:#60A5FA; display:flex; align-items:center;" onclick="openModal('modalDetail{{ $data->id }}')" title="Detail">
                                    <span style="margin-left:5px; font-weight:600; font-size:0.78rem;">Detail</span>
                                </button>
                                @if(auth()->user()->role == 'admin')
                                    <a href="https://wa.me/{{ $data->hp_ketua }}" target="_blank" class="icon-btn" style="color:#25D366" title="Hubungi Ketua (WhatsApp)">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @else
                                    @php
                                        $waMap = [
                                            1 => 'EPIM2026-WEB', 
                                            2 => 'Ia29F8LBbqR0Q69xF6zVor', 
                                            3 => 'EPIM2026-PACKAGING', 
                                            4 => 'Ia29F8LBbqR0Q69xF6zVor',
                                            5 => 'Ia29F8LBbqR0Q69xF6zVor'
                                        ];
                                        $waCode = $waMap[$data->id_lomba] ?? 'EPIM2026';
                                        $waGroupLink = 'https://chat.whatsapp.com/' . $waCode;
                                    @endphp
                                    @if(($data->status_kelulusan ?? 'pending') != 'tidak_lolos')
                                        <a href="{{ $waGroupLink }}" target="_blank" rel="noopener noreferrer" class="icon-btn" style="color:#25D366" title="Gabung Grup WhatsApp Kategori">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif
                                @endif
                                @if(!$editAksiTutup)
                                    <button class="icon-btn" style="color:#F97316" onclick="openModal('modalEditBukti{{ $data->id }}')" title="Edit Bukti">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </button>
                                @else
                                    <button class="icon-btn" style="color:#4B5563; cursor:not-allowed;" title="Edit Ditutup" disabled>
                                        <i class="fa-solid fa-lock"></i>
                                    </button>
                                @endif
                                @if(auth()->user()->role == 'admin')
                                <button type="button" class="icon-btn" style="color:#EF4444" onclick="openModal('modalHapusPendaftaran{{ $data->id }}')" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? 10 : 9 }}" style="text-align:center; padding:60px; color:#4B5563;">
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
                    <a href="{{ $datas->previousPageUrl() }}" style="padding:6px 12px; background:#333; color:#fff; border-radius:8px; font-size:0.8rem; text-decoration:none;">« Prev</a>
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
                        <a href="{{ $datas->url($i) }}" style="padding:6px 14px; background:#333; color:#9CA3AF; border-radius:8px; font-size:0.8rem; text-decoration:none;">{{ $i }}</a>
                    @endif
                @endfor

                @if($datas->hasMorePages())
                    <a href="{{ $datas->nextPageUrl() }}" style="padding:6px 12px; background:#333; color:#fff; border-radius:8px; font-size:0.8rem; text-decoration:none;">Next »</a>
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
            <h3>{{ in_array($data->id_lomba, [1, 2]) ? 'Detail Tim' : 'Detail Peserta' }}</h3>
            <div class="detail-grid">
                @if(in_array($data->id_lomba, [1, 2]))
                <div class="detail-item">
                    <label>Nama Tim</label>
                    <strong>{{ $data->tim->nama_tim ?? 'N/A' }}</strong>
                </div>
                @endif
                <div class="detail-item">
                    <label>Kategori Lomba</label>
                    <strong>{{ $data->kategori->nama_lomba ?? 'N/A' }}</strong>
                </div>
                @if(in_array($data->id_lomba, [1, 2]))
                <div class="detail-item">
                    <label>Asal Sekolah</label>
                    <strong>{{ $data->tim->asal_sekolah ?? 'N/A' }}</strong>
                </div>
                <div class="detail-item">
                    <label>Pembimbing</label>
                    <strong>{{ $data->tim->guru_pembimbing ?? 'N/A' }}</strong>
                </div>
                @endif
                <hr class="detail-separator">
                <div class="detail-item">
                    <label>{{ in_array($data->id_lomba, [1, 2]) ? 'Ketua' : 'Nama' }}</label>
                    <strong>{{ $data->nama_ketua ?? 'N/A' }}@if($data->nis_nim_ketua) (NIM/NIS: {{ $data->nis_nim_ketua }})@endif</strong>
                </div>
                <div class="detail-item">
                    <label>{{ in_array($data->id_lomba, [1, 2]) ? 'No WA Ketua' : 'No WA' }}</label>
                    <strong>{{ $data->hp_ketua ?? 'N/A' }}</strong>
                </div>
                @if($data->anggota_1)
                    <div class="detail-item">
                        <label>Anggota 1</label>
                        <strong>{{ $data->anggota_1 }}@if($data->anggota_nis_1) (NIM/NIS: {{ $data->anggota_nis_1 }})@endif{{ $data->hp_1 ? ' - ' . $data->hp_1 : '' }}</strong>
                    </div>
                @endif
                @if($data->anggota_2)
                    <div class="detail-item">
                        <label>Anggota 2</label>
                        <strong>{{ $data->anggota_2 }}@if($data->anggota_nis_2) (NIM/NIS: {{ $data->anggota_nis_2 }})@endif{{ $data->hp_2 ? ' - ' . $data->hp_2 : '' }}</strong>
                    </div>
                @endif
                @if($data->anggota_3)
                    <div class="detail-item">
                        <label>Anggota 3</label>
                        <strong>{{ $data->anggota_3 }}@if($data->anggota_nis_3) (NIM/NIS: {{ $data->anggota_nis_3 }})@endif{{ $data->hp_3 ? ' - ' . $data->hp_3 : '' }}</strong>
                    </div>
                @endif
                <hr class="detail-separator">
                <div class="sosmed-twibon-grid">
                <div class="detail-item">
                    <label>Bukti Pembayaran</label>
                    @if($data->bukti_bayar)
                        @php
                            $extBayar = strtolower(pathinfo($data->bukti_bayar, PATHINFO_EXTENSION));
                            $isBayarImg = in_array($extBayar, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        @if($isBayarImg)
                            <div style="margin-top: 8px;">
                                <a href="{{ asset('uploads/pembayaran/' . $data->bukti_bayar) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset('uploads/pembayaran/' . $data->bukti_bayar) }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: block; object-fit: contain;">
                                </a>
                            </div>
                        @else
                            <strong>
                                <a href="{{ asset('uploads/pembayaran/' . $data->bukti_bayar) }}" target="_blank" style="color: #60A5FA; text-decoration: none;">
                                    <i class="fa-solid fa-receipt"></i> Lihat Bukti Pembayaran
                                </a>
                            </strong>
                        @endif
                    @else
                        <strong style="color: #EF4444;">Belum diunggah</strong>
                    @endif
                </div>
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

                    @if(true)
                    <div style="margin-top: 8px;">
                        <!-- <button type="button" class="btn btn-outline btn-edit-status-toggle-{{ $data->id }}" style="padding: 4px 8px; font-size: 0.75rem;" onclick="document.getElementById('editStatusForm{{ $data->id }}').style.display = 'block'; this.style.display = 'none';">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button> -->
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
                </div>
                <div class="sosmed-twibon-grid">
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

                    @if(true)
                    <div style="margin-top: 8px;">
                        <!-- <button type="button" class="btn btn-outline btn-edit-sosmed-toggle-{{ $data->id }}" style="padding: 4px 8px; font-size: 0.75rem;" onclick="document.getElementById('editSosmedForm{{ $data->id }}').style.display = 'block'; this.style.display = 'none';">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button> -->
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
                <div class="detail-item">
                    <label>Bukti Twibon</label>
                    @if($data->bukti_twibon)
                        @php
                            $extTwibon = strtolower(pathinfo($data->bukti_twibon, PATHINFO_EXTENSION));
                            $isTwibonImg = in_array($extTwibon, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        @if($isTwibonImg)
                            <div style="margin-top: 8px;">
                                <a href="{{ asset('uploads/twibon/' . $data->bukti_twibon) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset('uploads/twibon/' . $data->bukti_twibon) }}" alt="Bukti Twibon" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: block; object-fit: contain;">
                                </a>
                            </div>
                        @else
                            <strong>
                                <a href="{{ asset('uploads/twibon/' . $data->bukti_twibon) }}" target="_blank" style="color: #60A5FA; text-decoration: none;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat PDF Bukti Twibon
                                </a>
                            </strong>
                        @endif
                    @else
                        <strong style="color: #EF4444;">Belum diunggah</strong>
                    @endif
                </div>
                </div>{{-- end sosmed-twibon-grid --}}
            </div>
            <button class="btn btn-outline" style="width:100%; margin-top:20px;" onclick="closeModal('modalDetail{{ $data->id }}')">Tutup</button>
        </div>
    </div>

    <div id="modalProposal{{ $data->id }}" class="modal">
        <div class="modal-content">
            <!-- Original: <h3>Upload / Edit Proposal</h3> -->
            @php
                $propTitle = match($data->id_lomba) {
                    2 => 'Upload / Edit Desain Topologi',
                    5 => 'Upload / Edit Write-up Penetrasi',
                    default => 'Upload / Edit Proposal'
                };
                $propAccept = '.pdf';
            @endphp
            <h3>{{ $propTitle }}</h3>
            @if($data->proposal)
            <p style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-info-circle"></i> File lama akan diganti dengan file baru.
            </p>
            @endif
            <form action="{{ route('Lomba.peserta.tambahproposal', $data->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <!-- Original: <div class="form-group"><input type="file" name="proposal" class="form-control" required accept=".pdf"></div> -->
                <div class="form-group"><input type="file" name="proposal" class="form-control" required accept="{{ $propAccept }}"></div>
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

    <div id="modalLoloskan{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center; max-width:450px;">
            <i class="fa-solid fa-circle-check" style="font-size:3rem; color:#10B981; margin-bottom:15px;"></i>
            <h3>Loloskan Peserta?</h3>
            <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6; margin:10px 0 0;">
                Apakah Anda yakin ingin meloloskan tim <strong style="color:#fff;">{{ $data->tim->nama_tim ?? 'ini' }}</strong>?
            </p>
            <form action="{{ route('admin.kelulusan.atur', [$data->id, 'lolos']) }}" method="POST">
                @csrf @method('PATCH')
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalLoloskan{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn" style="flex:1; background:#10B981;">Ya, Loloskan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalGugurkan{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center; max-width:450px;">
            <i class="fa-solid fa-circle-xmark" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
            <h3>Gugurkan Peserta?</h3>
            <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6; margin:10px 0 0;">
                Apakah Anda yakin ingin menggugurkan tim <strong style="color:#fff;">{{ $data->tim->nama_tim ?? 'ini' }}</strong>?
            </p>
            <form action="{{ route('admin.kelulusan.atur', [$data->id, 'tidak_lolos']) }}" method="POST">
                @csrf @method('PATCH')
                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalGugurkan{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-danger" style="flex:1; background:#EF4444;">Ya, Gugurkan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditBukti{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#F97316; font-family:'Montserrat'; margin-bottom:15px;">Edit Bukti Pendaftaran</h3>
            <p style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-info-circle"></i> Unggah berkas baru untuk mengganti berkas yang lama. Kosongkan jika tidak ingin diubah.
            </p>
            <form action="{{ route('Lomba.peserta.updatebukti', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem;">Bukti Pembayaran (JPG/JPEG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png" style="padding: 8px;">
                    @if($data->bukti_bayar)
                        <span style="color:#10B981; font-size:0.75rem; display:block; margin-top:4px;"><i class="fa-solid fa-circle-check"></i> Sudah ada berkas</span>
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem;">Bukti KTM/Status Aktif (PDF/JPG/JPEG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_status_aktif" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="padding: 8px;">
                    @if($data->bukti_status_aktif)
                        <span style="color:#10B981; font-size:0.75rem; display:block; margin-top:4px;"><i class="fa-solid fa-circle-check"></i> Sudah ada berkas</span>
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem;">Bukti Follow Sosmed (PDF/JPG/JPEG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_sosmed" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="padding: 8px;">
                    @if($data->bukti_sosmed)
                        <span style="color:#10B981; font-size:0.75rem; display:block; margin-top:4px;"><i class="fa-solid fa-circle-check"></i> Sudah ada berkas</span>
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.85rem;">Bukti Twibbon (PDF/JPG/JPEG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_twibon" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="padding: 8px;">
                    @if($data->bukti_twibon)
                        <span style="color:#10B981; font-size:0.75rem; display:block; margin-top:4px;"><i class="fa-solid fa-circle-check"></i> Sudah ada berkas</span>
                    @endif
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalEditBukti{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">Simpan Bukti</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalHapusProposal{{ $data->id }}" class="modal">
        <div class="modal-content" style="text-align:center;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
            <!-- Original: <h3>Hapus Proposal?</h3> -->
            @php
                $hapusTitle = match($data->id_lomba) {
                    2 => 'Hapus Desain Topologi?',
                    5 => 'Hapus Write-up?',
                    default => 'Hapus Proposal?'
                };
            @endphp
            <h3>{{ $hapusTitle }}</h3>
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
            <h3>Upload / Edit Lembar Orisinalitas</h3>
            @if($data->orisinalitas)
            <p style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-info-circle"></i> File lama akan diganti dengan file baru. Pastikan file dalam format PDF.
            </p>
            @else
            <p style="color: #9CA3AF; font-size: 0.8rem; margin-bottom: 1rem;">Pastikan file dalam format PDF.</p>
            @endif
            <form action="{{ route('Lomba.peserta.tambahorisinalitas', $data->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group"><input type="file" name="orisinalitas" class="form-control" required accept=".pdf"></div>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalOrisinalitas{{ $data->id }}')">Batal</button>
                    <button type="submit" class="btn btn-orange" style="flex:1">Simpan</button>
                </div>
            </form>
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



{{-- Modal Karya per peserta --}}
@foreach ($datas as $data)
    @php $idLomba = $data->id_lomba; @endphp
    {{-- Original check: && !(($idLomba == 1 && $data->judul_karya) || ($idLomba == 2 && $data->gambar_karya) || ($idLomba == 3 && $data->judul_karya) || ($idLomba == 4 && $data->link_video_karya))) --}}
    @if((auth()->user()->role == 'admin' || (($data->status_pembayaran ?? 'pending') == 'verified' && !$isExpired && !($pengaturan->status_upload_postervideo_ditutup ?? false)))
        && !( (in_array($idLomba, [1, 2, 3, 5]) && $data->judul_karya) || ($idLomba == 4 && $data->link_video_karya) ))
    <div id="modalKarya{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3 style="color:#F97316; font-family:'Montserrat'; margin-bottom:4px;">Kumpulkan Karya</h3>
            <div style="font-size:0.8rem; color:#9CA3AF; margin-bottom:20px;">
                {{ $data->kategori->nama_lomba ?? '-' }}
                &nbsp;— Deadline: <strong>13 Agustus 2026 pukul 23:59 WIB</strong>
            </div>
            <form action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pendaftar_id" value="{{ $data->id }}">
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
                {{-- Original Poster upload field commented out since ID 2 is now Network Engineering (documents/proposal-based)
                @if($idLomba == 2)
                <div class="form-group">
                    <label>Upload File Poster <span style="color:#EF4444;">*</span> (JPG/JPEG/PNG, min 300dpi, maks 15MB, wajib logo Polije/HMJTI/EPIM)</label>
                    <input type="file" name="gambar_karya" class="form-control" accept=".jpg,.jpeg,.png" required>
                </div>
                @endif
                --}}
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
    @if($data->judul_karya && (auth()->user()->role == 'admin' || ($pengaturan->status_pengumpulan_karya ?? 0)))
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
                {{-- 
                @if($ekIdLomba == 1)
                <div class="form-group">
                    <label>Pilih Subtema <span style="color:#EF4444;">*</span></label>
                    <select name="subtema" class="form-control">
                        <option value="">— Pilih Subtema —</option>
                        @foreach(['Manajemen absensi','Perpustakaan','Ekstrakurikuler','Kantin sehat'] as $st)
                            <option value="{{ $st }}" {{ ($data->subtema ?? '') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                --}}
                {{-- Original Poster input block (Commented out):
                @if($ekIdLomba == 2)
                <div class="form-group">
                    <label>Upload File Poster (JPG/JPEG/PNG, maks 15MB) <span style="color:#6B7280; font-size:0.75rem;">— kosongkan jika tidak diganti</span></label>
                    <input type="file" name="gambar_karya" class="form-control" accept=".jpg,.jpeg,.png">
                    @if($data->gambar_karya)
                        <div style="margin-top:6px; display:flex; align-items:center; gap:8px;">
                            <span style="color:#10B981; font-size:0.78rem;"><i class="fa-solid fa-check-circle"></i> File sudah ada</span>
                            <a href="{{ asset('uploads/karya/' . $data->gambar_karya) }}" target="_blank" class="btn btn-info-outline" style="padding:3px 8px; font-size:0.7rem;">Lihat</a>
                        </div>
                    @endif
                </div>
                @endif
                --}}
                @if($ekIdLomba == 4)
                <div class="form-group">
                    <label>Link Video (Drive Peserta) <span style="color:#EF4444;">*</span></label>
                    <input type="url" name="link_video_karya" class="form-control" value="{{ old('link_video_karya', $data->link_video_karya) }}" required>
                </div>
                @else
                @php
                    $proposalLabel = match($ekIdLomba) {
                        2 => 'Upload Topologi Jaringan (PDF, maks 10MB)',
                        5 => 'Upload Write-up Penetrasi (PDF, maks 15MB)',
                        default => 'Upload Proposal (PDF, maks 10MB)'
                    };
                    $proposalAccept = '.pdf';
                @endphp
                <div class="form-group">
                    <label>{{ $proposalLabel }} <span style="color:#6B7280; font-size:0.75rem;">— kosongkan jika tidak diganti</span></label>
                    <input type="file" name="proposal" class="form-control" accept="{{ $proposalAccept }}">
                    @if($data->proposal)
                        <div style="margin-top:6px; display:flex; align-items:center; gap:8px;">
                            <span style="color:#10B981; font-size:0.78rem;"><i class="fa-solid fa-check-circle"></i> File sudah ada</span>
                            <a href="{{ asset('uploads/proposal/' . $data->proposal) }}" target="_blank" class="btn btn-info-outline" style="padding:3px 8px; font-size:0.7rem;">Lihat</a>
                        </div>
                    @endif
                </div>

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
                @endif

                <!-- 
                {{-- 
                Cabang Web Programming (ID 1) & Design Packaging (ID 3) saat ini tidak memerlukan upload file karya.
                Jika ke depan ingin ditambahkan link/file karya pada edit karya, silakan aktifkan bagian di bawah ini:
                
                @if($ekIdLomba == 1)
                <div class="form-group">
                    <label>Link Hasil Karya Web (URL) <span style="color:#EF4444;">*</span></label>
                    <input type="url" name="link_karya_web" class="form-control" value="{{ old('link_karya_web', $data->link_karya_web ?? '') }}">
                </div>
                @elseif($ekIdLomba == 3)
                <div class="form-group">
                    <label>Upload File Desain Karya Packaging (ZIP/RAR/PDF, maks 15MB)</label>
                    <input type="file" name="file_karya_packaging" class="form-control">
                </div>
                @endif
                --}}
                -->
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
            <!-- Step 1 -->
            <div id="stepCol1" class="step-col active">
                <div class="step-line"></div>
                <div class="step-info">
                    <span class="step-number">1</span>
                    <span class="step-text">Data Diri/Tim</span>
                </div>
            </div>
            <!-- Step 2 -->
            <div id="stepCol2" class="step-col">
                <div class="step-line"></div>
                <div class="step-info">
                    <span class="step-number">2</span>
                    <span class="step-text">Pembayaran</span>
                </div>
            </div>
            <!-- Step 3 -->
            <div id="stepCol3" class="step-col">
                <div class="step-line"></div>
                <div class="step-info">
                    <span class="step-number">3</span>
                    <span class="step-text">Upload Proposal, Orisinalitas & Karya</span>
                </div>
            </div>
        </div>

        <form id="formPendaftaran" action="{{ route('Lomba.peserta.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="step1">
                <div class="form-group">
                    <label>Kategori Lomba <span style="color:#EF4444;">*</span></label>
                    <select name="id_lomba" class="form-control" required onchange="handleCategoryChange()">
                        <option value="">-- Pilih Bidang Lomba --</option>
                        @foreach($listKategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('id_lomba') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_lomba }}</option>
                        @endforeach
                    </select>
                    @error('id_lomba') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Web Programming Fields -->
                <div id="webProgFields" style="display:none;">
                    <div class="form-group">
                        <label>Nama Tim <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="nama_tim" class="form-control" value="{{ old('nama_tim') }}" pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                        @error('nama_tim') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Sekolah <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}" pattern="^[^<>]+$">
                        @error('asal_sekolah') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Pendamping <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="guru_pembimbing" class="form-control" value="{{ old('guru_pembimbing') }}" pattern="^[^<>]+$">
                        @error('guru_pembimbing') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ketua Tim -->
                    <div style="background: rgba(249,115,22,0.05); border: 1px solid rgba(249,115,22,0.2); border-radius:12px; padding:15px; margin-top:15px; margin-bottom:15px;">
                        <span style="color:#F97316; font-weight:700; font-size:0.9rem; display:block; margin-bottom:12px;">Ketua Tim</span>
                        <div class="form-group">
                            <label>Nama Ketua <span style="color:#EF4444;">*</span></label>
                            <input type="text" name="nama_ketua" class="form-control" value="{{ old('nama_ketua') }}" pattern="^[^<>]+$">
                            @error('nama_ketua') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="input-grid">
                            <div class="form-group">
                                <label>NIS/NIM Ketua <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="nis_nim_ketua" class="form-control" value="{{ old('nis_nim_ketua') }}" placeholder="Contoh: 12345678">
                                @error('nis_nim_ketua') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>No WA Ketua <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="hp_ketua" class="form-control" value="{{ old('hp_ketua') }}" placeholder="08xxx" pattern="^[0-9+\-\s]+$">
                                @error('hp_ketua') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Anggota 1 -->
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid #333; border-radius: 12px; padding:15px; margin-top:15px; margin-bottom:15px;">
                        <span style="color:#F97316; font-weight:700; font-size:0.9rem; display:block; margin-bottom:12px;">Anggota 1</span>
                        <div class="form-group">
                            <label>Nama Anggota 1 <span style="color:#EF4444;">*</span></label>
                            <input type="text" name="anggota_1" class="form-control" value="{{ old('anggota_1') }}" pattern="^[^<>]+$">
                            @error('anggota_1') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="input-grid">
                            <div class="form-group">
                                <label>NIS/NIM Anggota 1 <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="anggota_nis_1" class="form-control" value="{{ old('anggota_nis_1') }}" placeholder="Contoh: 12345678">
                                @error('anggota_nis_1') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>No WA Anggota 1 <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="hp_1" class="form-control" value="{{ old('hp_1') }}" placeholder="08xxx" pattern="^[0-9+\-\s]+$">
                                @error('hp_1') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div id="anggotaContainer"></div>
                    <button type="button" id="tambahAnggotaBtn" class="btn btn-outline" style="width:100%; margin-top:10px;" onclick="tambahAnggota()">
                        <i class="fa-solid fa-plus"></i> Tambah Anggota (Anggota 2)
                    </button>
                </div>

                <!-- Non-Web Programming Fields -->
                <div id="nonWebProgFields" style="display:none;">
                    <div class="form-group">
                        <label>Nama <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="nama_ketua" class="form-control" value="{{ old('nama_ketua') }}" pattern="^[^<>]+$">
                        @error('nama_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>NIM/NIS <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="nis_nim_ketua" class="form-control" value="{{ old('nis_nim_ketua') }}" placeholder="Contoh: 12345678">
                        @error('nis_nim_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>No WA <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="hp_ketua" class="form-control" value="{{ old('hp_ketua') }}" placeholder="08xxx" pattern="^[0-9+\-\s]+$">
                        @error('hp_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="button" class="btn btn-orange" style="width:100%; margin-top:15px;" onclick="goToStep(2)">Lanjut <i class="fa-solid fa-arrow-right"></i></button>
            </div>

            <div id="step2" style="display:none;">
                <!-- Payment Info Block -->
                <div id="paymentInfo" style="background:#1a1a1a; padding:20px; border-radius:12px; margin-bottom:20px; text-align:center; border: 1px dashed #444;">
                    <p style="font-size:0.85rem; color:#9CA3AF; margin-bottom:5px;">Tagihan <strong id="paymentLabel" style="color:#fff;">-</strong></p>
                    <strong id="paymentNominal" style="font-size:1.5rem; color:#F97316;">Rp 0</strong><br>
                    <div style="margin-top:12px; padding-top:12px; border-top:1px solid #333;">
                        <p style="font-size:0.8rem; color:#9CA3AF; margin-bottom:6px;">Transfer ke:</p>
                        <strong id="paymentRekening" style="font-size:1.1rem; color:#fff;"></strong><br>
                        <span id="paymentAn" style="font-size:0.8rem; color:#9CA3AF;"></span>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="form-group">
                    <label>Upload Bukti Transfer / Pembayaran <span style="color:#EF4444;">*</span> (JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" required accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    @error('bukti_bayar') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Bukti Status Aktif -->
                <div class="form-group">
                    <label>Upload Bukti Status Aktif <span style="color:#EF4444;">*</span> (KTM/Kartu Pelajar, PDF/JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_status_aktif" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_status_aktif') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Bukti Sosmed -->
                <div class="form-group">
                    <label>Upload Bukti Follow Instagram @hmjti_polije & @epim_polije, YouTube @hmjtipolije, serta TikTok @hmjti_polije <span style="color:#EF4444;">*</span> (Format PDF   , maks 2MB)</label>
                    <input type="file" name="bukti_sosmed" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_sosmed') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Bukti Twibon -->
                <div class="form-group">
                    <label>Upload Bukti Twibon <span style="color:#EF4444;">*</span> (PDF/JPG/PNG, maks 2MB)</label>
                    <input type="file" name="bukti_twibon" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_twibon') <span class="form-error">{{ $message }}</span> @enderror
                </div>  

                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" style="flex:1" onclick="goToStep(1)">Kembali</button>
                    <button type="button" class="btn btn-orange" style="flex:1" onclick="goToStep(3)">Lanjut</button>
                </div>
            </div>

            <div id="step3" style="display:none;">
                <div class="form-group">
                    <label>Judul Karya <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="judul_karya" class="form-control" placeholder="Masukkan judul karya">
                    @error('judul_karya') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Web Programming Subtema Selector (Di-comment sesuai permintaan) -->
                <!-- 
                <div class="form-group" id="subtemaInputGroup" style="display:none;">
                    <label>Pilih Subtema <span style="color:#EF4444;">*</span></label>
                    <select name="subtema" id="subtemaInput" class="form-control">
                        <option value="">— Pilih Subtema —</option>
                        <option value="Manajemen absensi">Manajemen absensi</option>
                        <option value="Perpustakaan">Perpustakaan</option>
                        <option value="Ekstrakurikuler">Ekstrakurikuler</option>
                        <option value="Kantin sehat">Kantin sehat</option>
                    </select>
                    @error('subtema') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                -->

                <!-- 
                {{-- 
                Cabang Web Programming (ID 1) & Design Packaging (ID 3) saat ini tidak memerlukan upload file karya.
                Jika ke depan ingin ditambahkan link/file karya pada pendaftaran, silakan aktifkan bagian di bawah ini:
                
                <div class="form-group" id="karyaTambahanGroup" style="display:none;">
                    <label>Upload Berkas Karya Tambahan (ZIP/RAR, maks 15MB)</label>
                    <input type="file" name="file_karya_tambahan" class="form-control">
                </div>
                --}}
                -->

                {{-- Design Poster Upload commented out since ID 2 is now Network Engineering (documents/proposal-based)
                <div class="form-group" id="gambarKaryaInputGroup" style="display:none;">
                    <label>Upload File Poster <span style="color:#EF4444;">*</span> (JPG/JPEG/PNG, maks 15MB)</label>
                    <input type="file" name="gambar_karya" id="gambarKaryaInput" class="form-control" accept=".jpg,.jpeg,.png">
                    @error('gambar_karya') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                --}}

                <!-- Videography Link Video -->
                <div class="form-group" id="linkVideoInputGroup" style="display:none;">
                    <label>Link Video YouTube/Drive <span style="color:#EF4444;">*</span></label>
                    <input type="url" name="link_video_karya" id="linkVideoInput" class="form-control" placeholder="https://...">
                    @error('link_video_karya') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Proposal Upload (only shown and required for web programming & packaging) -->
                <div class="form-group" id="proposalInputGroup" style="display:none;">
                    <label>Upload Proposal <span style="color:#EF4444;">*</span> (PDF, maks 2MB)</label>
                    <input type="file" name="proposal" id="proposalInput" class="form-control" accept=".pdf">
                    @error('proposal') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Orisinalitas Upload (required for all) -->
                <div class="form-group">
                    <label>Upload Lembar Orisinalitas <span style="color:#EF4444;">*</span> (PDF, maks 2MB)</label>
                    <input type="file" name="orisinalitas" class="form-control" accept=".pdf" required>
                    @error('orisinalitas') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- Integrity Statement Checkbox -->
                <div style="background:#1a1a1a; border:1px solid rgba(249,115,22,0.3); border-radius:12px; padding:1.2rem; margin-bottom:20px;">
                    <label style="display:flex; gap:12px; align-items:flex-start; cursor:pointer;">
                        <input type="checkbox" name="accepted_integrity" value="1" required style="accent-color:#F97316; width:20px; height:20px; margin-top:2px;">
                        <span style="font-size:0.82rem; color:#d1d5db; line-height:1.6;">
                            <strong style="color:#F97316;">Pernyataan Integritas</strong><br>
                            Saya menyatakan bahwa karya yang saya kumpulkan adalah <strong>asli buatan sendiri/tim</strong>,
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
    const PAYMENT_MAP = @json($paymentMap);
    function openModal(id) {
        if(id === 'modalCreate') {
            document.getElementById('formPendaftaran').reset();
            document.getElementById('anggotaContainer').innerHTML = '';
            refreshAnggotaBtn();
            handleCategoryChange();
            goToStep(1);
        }
        const el = document.getElementById(id);
        if (el) el.style.display = "block";
    }

    function closeModal(id) { const el = document.getElementById(id); if (el) el.style.display = "none"; }

    window.onclick = function(e) {
        if(e.target.classList && e.target.classList.contains('modal')) e.target.style.display = "none";
    }

    function handleCategoryChange() {
        const select = document.querySelector('select[name="id_lomba"]');
        if (!select) return;
        const val = select.value;
        
        const webProgFields = document.getElementById('webProgFields');
        const nonWebProgFields = document.getElementById('nonWebProgFields');
        const proposalInputGroup = document.getElementById('proposalInputGroup');
        const proposalInput = document.getElementById('proposalInput');
        
        const subtemaInputGroup = document.getElementById('subtemaInputGroup');
        const subtemaInput = document.getElementById('subtemaInput');
        const gambarKaryaInputGroup = document.getElementById('gambarKaryaInputGroup');
        const gambarKaryaInput = document.getElementById('gambarKaryaInput');
        const linkVideoInputGroup = document.getElementById('linkVideoInputGroup');
        const linkVideoInput = document.getElementById('linkVideoInput');

        // Reset all optional/dynamic inputs as hidden & disabled by default
        if (gambarKaryaInputGroup) gambarKaryaInputGroup.style.display = 'none';
        if (gambarKaryaInput) {
            gambarKaryaInput.required = false;
            gambarKaryaInput.disabled = true;
        }
        if (linkVideoInputGroup) linkVideoInputGroup.style.display = 'none';
        if (linkVideoInput) {
            linkVideoInput.required = false;
            linkVideoInput.disabled = true;
        }
        if (proposalInputGroup) proposalInputGroup.style.display = 'none';
        if (proposalInput) {
            proposalInput.required = false;
            proposalInput.disabled = true;
        }

        if (val == '1' || val == '2') {
            // Web Programming & Network Engineering
            webProgFields.style.display = 'block';
            nonWebProgFields.style.display = 'none';

            // Disable all inputs in nonWebProgFields to prevent naming collisions
            nonWebProgFields.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });

            // Enable Web Programming inputs
            webProgFields.querySelectorAll('input:not([name^="anggota_2"]):not([name^="hp_2"])').forEach(input => {
                input.required = true;
                input.disabled = false;
            });
            webProgFields.querySelectorAll('input[name^="anggota_2"], input[name^="hp_2"]').forEach(input => {
                input.required = false;
                input.disabled = false;
            });

            proposalInputGroup.style.display = 'block';
            proposalInput.required = true;
            proposalInput.disabled = false;
            
            proposalInput.accept = '.pdf';
            const label = proposalInputGroup.querySelector('label');
            if (val == '2') {
                if (label) label.innerHTML = 'Upload Proposal / Desain Topologi <span style="color:#EF4444;">*</span> (PDF, maks 10MB)';
            } else {
                if (label) label.innerHTML = 'Upload Proposal <span style="color:#EF4444;">*</span> (PDF, maks 10MB)';
            }

            if (subtemaInputGroup) {
                if (val == '1') {
                    subtemaInputGroup.style.display = 'block';
                    if (subtemaInput) {
                        subtemaInput.required = false;
                        subtemaInput.disabled = false;
                    }
                } else {
                    subtemaInputGroup.style.display = 'none';
                    if (subtemaInput) {
                        subtemaInput.required = false;
                        subtemaInput.disabled = true;
                    }
                }
            }
        } else {
            // Non Web-Programming / Non Network-Engineering
            webProgFields.style.display = 'none';
            nonWebProgFields.style.display = 'block';
            document.getElementById('anggotaContainer').innerHTML = '';
            refreshAnggotaBtn();

            // Disable all Web Programming inputs
            webProgFields.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });

            // Enable non-Web Programming inputs
            nonWebProgFields.querySelectorAll('input').forEach(input => {
                input.required = true;
                input.disabled = false;
            });

            if (val == '3' || val == '5') {
                // Design Packaging (3), Cyber Security (5) need proposal/berkas
                proposalInputGroup.style.display = 'block';
                proposalInput.required = true;
                proposalInput.disabled = false;
                proposalInput.accept = '.pdf';
                const label = proposalInputGroup.querySelector('label');
                if (label) label.innerHTML = 'Upload Proposal <span style="color:#EF4444;">*</span> (PDF, maks 10MB)';
            }

            if (subtemaInputGroup) subtemaInputGroup.style.display = 'none';
            if (subtemaInput) {
                subtemaInput.required = false;
                subtemaInput.disabled = true;
            }

            if (val == '4') { // Videography (in db, ID 4 is Videography)
                linkVideoInputGroup.style.display = 'block';
                linkVideoInput.required = true;
                linkVideoInput.disabled = false;
            }
        }
    }

    function countAnggota() { return document.querySelectorAll('#anggotaContainer .anggota-block').length; }
    
    function refreshAnggotaBtn() {
        const btn = document.getElementById('tambahAnggotaBtn');
        if (!btn) return;
        btn.style.display = countAnggota() >= 1 ? 'none' : 'block';
    }

    function tambahAnggota() {
        if (countAnggota() >= 1) {
            alert('Maksimal 3 anggota (Ketua + 2 Anggota) untuk Web Programming / Network Engineering.');
            return;
        }
        if (document.getElementById('anggotaBlock-2')) return;

        const div = document.createElement('div');
        div.className = 'anggota-block';
        div.id = 'anggotaBlock-2';
        div.style.cssText = 'background:#1a1a1a; border:1px solid #333; border-radius:12px; padding:15px; margin-top:12px; position:relative;';
        div.innerHTML =
            '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">' +
                '<span style="color:#F97316; font-weight:600; font-size:0.85rem;">Anggota 2</span>' +
                '<button type="button" onclick="hapusAnggota(2)" style="background:none; border:none; color:#EF4444; cursor:pointer; font-size:1.1rem;" title="Hapus anggota">' +
                    '<i class="fa-solid fa-xmark"></i>' +
                '</button>' +
            '</div>' +
            '<div class="input-grid">' +
                '<div class="form-group" style="margin-bottom:10px;">' +
                    '<input type="text" name="anggota_2" class="form-control" placeholder="Nama Anggota 2">' +
                '</div>' +
                '<div class="form-group" style="margin-bottom:10px;">' +
                    '<input type="text" name="anggota_nis_2" class="form-control" placeholder="NIS/NIM Anggota 2">' +
                '</div>' +
            '</div>' +
            '<div class="form-group" style="margin-bottom:0;">' +
                '<input type="text" name="hp_2" class="form-control" placeholder="WA Anggota 2" pattern="^[0-9+\\-\\s]*$">' +
            '</div>';
        document.getElementById('anggotaContainer').appendChild(div);
        refreshAnggotaBtn();
    }

    function hapusAnggota(num) {
        const block = document.getElementById('anggotaBlock-' + num);
        if (block) block.remove();
        refreshAnggotaBtn();
    }

    function validateStep(step) {
        const currentStep = document.getElementById('step' + step);
        const inputs = currentStep.querySelectorAll('input, select');
        for (const input of inputs) {
            if (input.required) {
                if (!input.value) {
                    input.reportValidity();
                    return false;
                }
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

        // Update step indicators
        const stepCol1 = document.getElementById('stepCol1');
        const stepCol2 = document.getElementById('stepCol2');
        const stepCol3 = document.getElementById('stepCol3');

        if (step === 1) {
            if (stepCol1) stepCol1.className = 'step-col active';
            if (stepCol2) stepCol2.className = 'step-col';
            if (stepCol3) stepCol3.className = 'step-col';
        } else if (step === 2) {
            if (stepCol1) stepCol1.className = 'step-col completed';
            if (stepCol2) stepCol2.className = 'step-col active';
            if (stepCol3) stepCol3.className = 'step-col';
            updatePaymentInfo();
        } else if (step === 3) {
            if (stepCol1) stepCol1.className = 'step-col completed';
            if (stepCol2) stepCol2.className = 'step-col completed';
            if (stepCol3) stepCol3.className = 'step-col active';
        }
    }

    function updatePaymentInfo() {
        const select = document.querySelector('select[name="id_lomba"]');
        const idLomba = parseInt(select?.value);
        const info = PAYMENT_MAP[idLomba];

        const labelEl = document.getElementById('paymentLabel');
        const nominalEl = document.getElementById('paymentNominal');
        const rekeningEl = document.getElementById('paymentRekening');
        const anEl = document.getElementById('paymentAn');

        if (labelEl) labelEl.textContent = info ? info.label : '-';
        if (nominalEl) nominalEl.textContent = info ? 'Rp ' + info.nominal.toLocaleString('id-ID') : 'Rp 0';
        if (rekeningEl) rekeningEl.textContent = info ? info.bank + ' : ' + info.rekening : '-';
        if (anEl) anEl.textContent = info ? 'A/N ' + info.an : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        handleCategoryChange();
        @if(old('id_lomba') == 1 && old('anggota_2'))
            tambahAnggota();
            const a2 = document.querySelector('input[name="anggota_2"]');
            const nis2 = document.querySelector('input[name="anggota_nis_2"]');
            const hp2 = document.querySelector('input[name="hp_2"]');
            if (a2) a2.value = "{{ old('anggota_2') }}";
            if (nis2) nis2.value = "{{ old('anggota_nis_2') }}";
            if (hp2) hp2.value = "{{ old('hp_2') }}";
        @endif
    });

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function () { openModal('modalCreate'); });
    @endif

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
