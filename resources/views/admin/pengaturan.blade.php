@extends('layouts.dashboard')

@section('title', 'Pengaturan - EPIM Admin')
@section('menuPengaturan', 'active')
@section('pageTitle', 'Panel Admin — Pengaturan')

@section('extraCss')
<style>
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .setting-item:last-child { border-bottom: none; }
    .setting-label { font-size: 0.95rem; color: #fff; }
    .setting-desc { font-size: 0.78rem; color: #6B7280; margin-top: 4px; }

    /* Toggle Switch */
    .toggle {
        position: relative;
        width: 50px;
        height: 26px;
        flex-shrink: 0;
        margin-left: 1rem;
    }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #374151;
        border-radius: 26px;
        transition: 0.3s;
    }
    .toggle .slider::before {
        content: '';
        position: absolute;
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background: #fff;
        border-radius: 50%;
        transition: 0.3s;
    }
    .toggle input:checked + .slider { background: #F97316; }
    .toggle input:checked + .slider::before { transform: translateX(24px); }

    .card h3 { font-family: 'Montserrat', sans-serif; margin-top: 0; color: #F97316; }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

<div class="card settings-card" style="max-width:600px;">
    <h3><i class="fa-solid fa-sliders"></i> Pengaturan Sistem</h3>
    <p style="color:#6B7280; font-size:0.85rem; margin-bottom:1.5rem;">
        Atur status pendaftaran dan upload untuk peserta.
    </p>

    <form action="{{ route('Pengaturan.store') }}" method="POST">
        @csrf

        <div class="setting-item">
            <div>
                <div class="setting-label">Pendaftaran Lomba</div>
                <div class="setting-desc">Tutup akses pendaftaran lomba baru oleh peserta</div>
            </div>
            <label class="toggle">
                <input type="checkbox" name="tutup_pendaftaran" value="on"
                    {{ ($data->status_pendaftaran_ditutup ?? 0) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Upload Proposal / Karya</div>
                <div class="setting-desc">Tutup akses upload proposal dan karya oleh peserta</div>
            </div>
            <label class="toggle">
                <input type="checkbox" name="status_upload_postervideo_ditutup" value="on"
                    {{ ($data->status_upload_postervideo_ditutup ?? 0) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Pengumpulan Karya</div>
                <div class="setting-desc">Tutup akses pengumpulan dan edit karya oleh peserta</div>
            </div>
            <label class="toggle">
                <input type="checkbox" name="status_pengumpulan_karya" value="on"
                    {{ ($data->status_pengumpulan_karya ?? 0) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-orange">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
