@extends('layouts.dashboard')

@section('title', 'Edit Profile - EPIM')
@section('pageTitle', 'Edit Data Diri')

@section('extraCss')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(320px, 0.8fr);
        gap: 1.5rem;
        align-items: start;
    }
    .card h3 {
        margin: 0 0 0.5rem;
        font-family: 'Montserrat', sans-serif;
        color: #F97316;
    }
    .card p {
        margin: 0 0 1.5rem;
        color: #9CA3AF;
        font-size: 0.9rem;
        line-height: 1.6;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .form-group.full {
        grid-column: 1 / -1;
    }
    .password-wrap {
        position: relative;
    }
    .password-wrap .form-control {
        padding-right: 2.8rem;
    }
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
        padding: 0;
    }
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    @media (max-width: 768px) {
        .profile-grid,
        .form-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@if(session('status') === 'profile-updated')
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> Data diri berhasil diperbarui.</div>
@endif

@if(session('status') === 'password-updated')
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> Password berhasil diperbarui.</div>
@endif

@if($errors->any() || $errors->updatePassword->any())
    <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i> Mohon periksa kembali data yang kamu isi.</div>
@endif

<div class="profile-grid">
    <section class="card">
        <h3>Data Diri</h3>
        <p>Perbarui informasi akun peserta agar data panitia tetap akurat.</p>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required pattern="^[^<>]+$">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ old('nim', $user->nim) }}" required pattern="^[^<>]+$">
                    @error('nim') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Telp</label>
                    <input type="text" name="nomor_telp" class="form-control" value="{{ old('nomor_telp', $user->nomor_telp) }}" required pattern="^[0-9+\-\s]+$">
                    @error('nomor_telp') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label>Institusi/Sekolah</label>
                    <input type="text" name="institusi" class="form-control" value="{{ old('institusi', $user->institusi) }}" required pattern="^[^<>]+$">
                    @error('institusi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-orange"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
        </form>
    </section>

    <section class="card">
        <h3>Password</h3>
        <p>Gunakan password baru yang kuat dan mudah kamu ingat.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Password Saat Ini</label>
                <div class="password-wrap">
                    <input id="currentPassword" type="password" name="current_password" class="form-control" autocomplete="current-password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('currentPassword', this)" title="Lihat password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <div class="password-wrap">
                    <input id="newPassword" type="password" name="password" class="form-control" autocomplete="new-password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('newPassword', this)" title="Lihat password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('password', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="password-wrap">
                    <input id="confirmPassword" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', this)" title="Lihat password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('password_confirmation', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-orange" style="width:100%;"><i class="fa-solid fa-key"></i> Ubah Password</button>
        </form>
    </section>
</div>
@endsection

@section('extraJs')
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        const visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        icon.className = visible ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
        button.title = visible ? 'Lihat password' : 'Sembunyikan password';
    }
</script>
@endsection
