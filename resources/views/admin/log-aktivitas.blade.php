@extends('layouts.dashboard')

@section('title', 'Log Aktivitas - EPIM Admin')
@section('menuLog', 'active')
@section('pageTitle', 'Panel Admin — Log Aktivitas')

@section('extraCss')
<style>
    .log-table { width: 100%; border-collapse: collapse; }
    .log-table th {
        background: #1a1a1a;
        color: #9CA3AF;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 10px 14px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .log-table td {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        font-size: 0.84rem;
        color: #E5E7EB;
        vertical-align: middle;
    }
    .log-table tr:hover td { background: rgba(249,115,22,0.04); }

    .badge-action {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .badge-lolos    { background: rgba(16,185,129,0.15); color: #10B981; }
    .badge-tolak    { background: rgba(239,68,68,0.15);  color: #EF4444; }
    .badge-ubah     { background: rgba(245,158,11,0.15);  color: #F59E0B; }
    .badge-default  { background: rgba(99,102,241,0.15); color: #818CF8; }

    .filter-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        align-items: flex-end;
    }
    .filter-bar input, .filter-bar select {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 8px 12px;
        font-size: 0.85rem;
        outline: none;
        transition: 0.2s;
    }
    .filter-bar input:focus, .filter-bar select:focus { border-color: #F97316; }
    .filter-bar input { min-width: 220px; }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6B7280;
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 1rem; display: block; color: #374151; }
</style>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

<div class="card" style="padding: 1.5rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:10px;">
        <div>
            <h3 style="font-family:'Montserrat',sans-serif; margin:0; color:#F97316; font-size:1.1rem;">
                <i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas Admin
            </h3>
            <p style="color:#6B7280; font-size:0.8rem; margin:4px 0 0;">Rekam jejak semua tindakan yang dilakukan admin.</p>
        </div>
        <span style="font-size:0.8rem; color:#6B7280;">Total: {{ $logs->total() }} entri</span>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.log.index') }}">
        <div class="filter-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama admin, tim, aksi...">
            <select name="action">
                <option value="">Semua Aksi</option>
                <option value="Loloskan Peserta" {{ request('action') == 'Loloskan Peserta' ? 'selected' : '' }}>Loloskan Peserta</option>
                <option value="Tolak Peserta"    {{ request('action') == 'Tolak Peserta'    ? 'selected' : '' }}>Tolak Peserta</option>
                <option value="Hapus Peserta"    {{ request('action') == 'Hapus Peserta'    ? 'selected' : '' }}>Hapus Peserta</option>
                <option value="Mengubah Pengaturan" {{ request('action') == 'Mengubah Pengaturan' ? 'selected' : '' }}>Mengubah Pengaturan</option>
            </select>
            <button type="submit" class="btn btn-orange" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>
            @if(request()->hasAny(['search','action']))
                <a href="{{ route('admin.log.index') }}" class="btn btn-outline" style="padding: 8px 16px;">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div style="overflow-x: auto;">
        <table class="log-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                    <th>Target Tim</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    @php
                        $badgeClass = match(true) {
                            str_contains($log->action, 'Lolos') => 'badge-lolos',
                            str_contains($log->action, 'Tolak') || str_contains($log->action, 'Hapus') => 'badge-tolak',
                            str_contains($log->action, 'Mengubah') || str_contains($log->action, 'Pengaturan') => 'badge-ubah',
                            default                             => 'badge-default',
                        };
                    @endphp
                    <tr>
                        <td style="color:#6B7280;">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                        <td>
                            <div style="font-size:0.82rem; color:#fff;">
                                {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Jakarta')->format('d M Y') }}
                            </div>
                            <div style="font-size:0.72rem; color:#6B7280;">
                                {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Jakarta')->format('H:i:s') }} WIB
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600; color:#F97316;">{{ $log->admin_name }}</div>
                        </td>
                        <td>
                            <span class="badge-action {{ $badgeClass }}">{{ $log->action }}</span>
                        </td>
                        <td style="font-weight:600;">{{ $log->target_name ?? '-' }}</td>
                        <td style="color:#9CA3AF; font-size:0.8rem;">{{ $log->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa-solid fa-inbox"></i>
                                Belum ada log aktivitas.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
