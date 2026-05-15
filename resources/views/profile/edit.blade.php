<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - EPIM</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #111;
            height: 100vh;
            padding: 2rem 1.5rem;
            border-right: 1px solid rgba(255,255,255,0.08);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-weight: 800;
            font-family: 'Montserrat';
            color: #F97316;
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            display: block;
            text-decoration: none;
        }

        .menu {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            color: #9CA3AF;
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: 0.3s;
        }

        .menu a:hover, .menu a.active {
            background: rgba(249,115,22,0.15);
            color: #F97316;
        }

        .logout-form { margin-top: auto; }

        .logout-btn {
            background: none;
            border: none;
            color: #ef4444;
            padding: 0.85rem 1rem;
            text-align: left;
            width: 100%;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-radius: 10px;
        }

        .main-container {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 70px;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            z-index: 90;
        }

        .topbar h2 {
            font-size: 1.25rem;
            margin: 0;
            font-family: 'Montserrat';
        }

        .user-info {
            color: #fff;
            text-decoration: none;
            margin-right: 1.5rem;
            padding: 0.55rem 0.85rem;
            border-radius: 10px;
            transition: 0.3s;
        }

        .user-info:hover {
            background: rgba(249,115,22,0.12);
        }

        .username {
            color: #F97316;
            font-weight: 600;
        }

        .content {
            padding: 2.5rem 2rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(320px, 0.8fr);
            gap: 1.5rem;
            align-items: start;
        }

        .card {
            background: #111;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .card h3 {
            margin: 0 0 0.5rem;
            font-family: 'Montserrat';
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

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            color: #9CA3AF;
            font-size: 0.85rem;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem;
            background: #222;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: 0.3s;
            font-family: 'Inter', sans-serif;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #F97316;
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

        .btn {
            padding: 0.75rem 1.2rem;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .btn-orange {
            background: #F97316;
        }

        .btn-orange:hover {
            background: #ea580c;
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 1px solid #374151;
            color: #9CA3AF;
            background: transparent;
        }

        .btn-danger {
            background: #EF4444;
        }

        .form-error {
            color: #FCA5A5;
            font-size: 0.78rem;
            margin-top: 0.45rem;
            display: block;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: #161616;
            margin: 10rem auto;
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.1);
            width: 90%;
            max-width: 480px;
            border-radius: 20px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .profile-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <a href="{{ route('dashboard') }}" class="logo">EPIM.TI</a>
    <div class="menu">
        <a href="{{ route('dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="{{ route('Lomba.peserta.index') }}"><i class="fa-solid fa-trophy"></i> Daftar Lomba</a>
        <a href="{{ route('profile.edit') }}" class="active"><i class="fa-solid fa-user"></i> Profile</a>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="button" class="logout-btn" onclick="openModal('modalLogout')">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="main-container">
    <header class="topbar">
        <h2>Edit Data Diri</h2>
        <a href="{{ route('profile.edit') }}" class="user-info">
            Halo, <span class="username">{{ $user->name }}</span>
        </a>
    </header>

    <main class="content">
        @if(session('status') === 'profile-updated')
            <div class="alert-success"><i class="fa-solid fa-circle-check"></i> Data diri berhasil diperbarui.</div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="alert-success"><i class="fa-solid fa-circle-check"></i> Password berhasil diperbarui.</div>
        @endif

        @if($errors->any() || $errors->updatePassword->any())
            <div class="alert-danger"><i class="fa-solid fa-circle-exclamation"></i> Mohon periksa kembali data yang kamu isi.</div>
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
    </main>
</div>

<div id="modalLogout" class="modal">
    <div class="modal-content">
        <i class="fa-solid fa-right-from-bracket" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
        <h3>Yakin ingin keluar?</h3>
        <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6;">Sesi akun kamu akan diakhiri.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalLogout')">Batal</button>
                <button type="submit" class="btn btn-danger" style="flex:1;">Ya, Logout</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'block';
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target.classList && e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    }

    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        const visible = input.type === 'text';

        input.type = visible ? 'password' : 'text';
        icon.className = visible ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
        button.title = visible ? 'Lihat password' : 'Sembunyikan password';
    }
</script>

</body>
</html>
