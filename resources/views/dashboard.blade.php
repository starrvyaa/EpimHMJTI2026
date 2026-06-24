@extends('layouts.dashboard')

@section('title', 'Dashboard - EPIM')
@section('menuDashboard', 'active')
@section('pageTitle', 'Dashboard Overview')

@section('extraCss')
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
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
        font-family: 'Montserrat', sans-serif;
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
    .btn-group {
        display: flex;
        gap: 10px;
    }
    .btn-white {
        background: #fff;
        color: #F97316;
    }
    .btn-white:hover {
        background: #f3f4f6;
    }
    @media (max-width: 768px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }
@endsection

@section('content')
<div class="dashboard-grid">
    <div class="card orange">
        <div>
            <h3>Web Programming</h3>
            <p>Front-end web programming fokus pada pembuatan tampilan menarik, responsif, dan performa tinggi.</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-white" onclick="openModal('modalWebProgramming')">Selengkapnya</button>
            <a href="https://drive.google.com/drive/folders/1x07zL_FzBVwIIwEdqBpsiQXYE9ODxItl" target="_blank" rel="noopener noreferrer" class="btn btn-white">Guidebook</a>
        </div>
    </div>

    <div class="card orange">
        <div>
            <h3>Design Packaging</h3>
            <p>Desain kemasan kreatif untuk meningkatkan nilai jual produk dan memperkuat branding identitas.</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-white" onclick="openModal('modalPackaging')">Selengkapnya</button>
            <a href="https://drive.google.com/drive/folders/1x07zL_FzBVwIIwEdqBpsiQXYE9ODxItl" target="_blank" rel="noopener noreferrer" class="btn btn-white">Guidebook</a>
        </div>
    </div>

    <div class="card orange">
        <div>
            <h3>Network Engineering</h3>
            <p>Cabang ini menantang peserta untuk merancang, mengonfigurasi, dan mengamankan jaringan komputer.</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-white" onclick="openModal('modalNetworkEngineering')">Selengkapnya</button>
            <a href="https://drive.google.com/drive/folders/1x07zL_FzBVwIIwEdqBpsiQXYE9ODxItl" target="_blank" rel="noopener noreferrer" class="btn btn-white">Guidebook</a>
        </div>
    </div>
    <div class="card orange">
        <div>
            <h3>Videography</h3>
            <p>Pembuatan karya video cinematic dengan teknik storytelling visual yang mendalam.</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-white" onclick="openModal('modalVideography')">Selengkapnya</button>
            <a href="https://drive.google.com/drive/folders/1x07zL_FzBVwIIwEdqBpsiQXYE9ODxItl" target="_blank" rel="noopener noreferrer" class="btn btn-white">Guidebook</a>
        </div>
    </div>
</div>

{{-- Modals --}}
@php
$modals = [
    'modalWebProgramming' => ['fa-code', 'Web Programming', 'Cabang ini menantang peserta membuat website yang rapi, responsif, mudah digunakan, dan sesuai tema. Penilaian biasanya mencakup tampilan antarmuka, struktur kode, kreativitas fitur, performa, serta kesesuaian solusi dengan kebutuhan pengguna.'],
    'modalPackaging' => ['fa-box-open', 'Design Packaging', 'Cabang ini berfokus pada rancangan kemasan produk yang menarik, informatif, dan punya nilai jual. Peserta perlu memadukan identitas visual, komposisi, warna, tipografi, dan fungsi kemasan agar produk terlihat profesional.'],
    'modalNetworkEngineering' => ['fa-image', 'Poster Competition', 'Cabang ini menilai kemampuan peserta menyampaikan pesan melalui poster visual. Karya yang kuat harus punya ide jelas, hierarki informasi yang mudah dibaca, komposisi matang, dan visual yang relevan dengan tema.'],
    'modalVideography' => ['fa-video', 'Videography', 'Cabang ini menguji kemampuan membuat video yang komunikatif dan sinematik. Penilaian dapat mencakup konsep cerita, kualitas pengambilan gambar, editing, audio, ritme visual, dan kekuatan pesan yang disampaikan.'],
];
@endphp
@foreach($modals as $id => [$icon, $title, $desc])
<div id="{{ $id }}" class="modal">
    <div class="modal-content" style="text-align:center; max-width:480px;">
        <i class="fa-solid {{ $icon }}" style="font-size:3rem; color:#F97316; margin-bottom:15px;"></i>
        <h3>{{ $title }}</h3>
        <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.7;">{{ $desc }}</p>
        <div style="margin-top:20px;">
            <button type="button" class="btn btn-outline" onclick="closeModal('{{ $id }}')">Tutup</button>
        </div>
    </div>
</div>
@endforeach
@endsection
