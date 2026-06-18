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

    /* === PREMIUM TOGGLE === */
    .toggle-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .toggle-status {
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 42px;
        text-align: center;
        padding: 3px 8px;
        border-radius: 6px;
        transition: 0.3s;
    }
    .toggle-status.on {
        color: #16a34a;
        background: rgba(22,163,74,0.12);
    }
    .toggle-status.off {
        color: #6b7280;
        background: rgba(107,114,128,0.12);
    }

    .toggle {
        position: relative;
        width: 52px;
        height: 28px;
        flex-shrink: 0;
        cursor: pointer;
    }
    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .toggle .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #374151;
        border-radius: 28px;
        transition: 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.3);
    }
    .toggle .slider::before {
        content: '';
        position: absolute;
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background: #9CA3AF;
        border-radius: 50%;
        transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 1px 4px rgba(0,0,0,0.3);
    }
    .toggle input:checked + .slider {
        background: linear-gradient(135deg, #F97316, #EA580C);
        box-shadow: 0 0 12px rgba(249,115,22,0.35);
    }
    .toggle input:checked + .slider::before {
        transform: translateX(24px);
        background: #fff;
    }
    .toggle:hover .slider::before {
        transform: scale(1.1);
    }
    .toggle input:checked:hover + .slider::before {
        transform: translateX(24px) scale(1.1);
    }

    .card h3 { font-family: 'Montserrat', sans-serif; margin-top: 0; color: #F97316; }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

<div class="card settings-card">
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
            <div class="toggle-wrap">
                <span class="toggle-status {{ ($data->status_pendaftaran_ditutup ?? 0) ? 'off' : 'on' }}">
                    {{ ($data->status_pendaftaran_ditutup ?? 0) ? 'TUTUP' : 'BUKA' }}
                </span>
                <label class="toggle">
                    <input type="checkbox" name="status_pendaftaran_buka" value="on" id="togPendaftaran"
                        {{ !($data->status_pendaftaran_ditutup ?? 0) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Upload Proposal / Karya</div>
                <div class="setting-desc">Tutup akses upload proposal dan karya oleh peserta</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-status {{ ($data->status_upload_postervideo_ditutup ?? 0) ? 'off' : 'on' }}">
                    {{ ($data->status_upload_postervideo_ditutup ?? 0) ? 'TUTUP' : 'BUKA' }}
                </span>
                <label class="toggle">
                    <input type="checkbox" name="status_upload_postervideo_buka" value="on" id="togUpload"
                        {{ !($data->status_upload_postervideo_ditutup ?? 0) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Pengumpulan Karya</div>
                <div class="setting-desc">Tutup akses pengumpulan dan edit karya oleh peserta</div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-status {{ ($data->status_pengumpulan_karya ?? 0) ? 'on' : 'off' }}">
                    {{ ($data->status_pengumpulan_karya ?? 0) ? 'BUKA' : 'TUTUP' }}
                </span>
                <label class="toggle">
                    <input type="checkbox" name="status_pengumpulan_karya_buka" value="on" id="togKarya"
                        {{ ($data->status_pengumpulan_karya ?? 0) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-orange">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
