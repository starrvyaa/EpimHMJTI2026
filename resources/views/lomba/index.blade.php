<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lomba - EPIM</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS Dasar & Layout - Mengikuti Dashboard */
        * { box-sizing: border-box; }
        
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #0A0A0A;
            color: #fff;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
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
            flex-direction: column; /* Untuk menaruh logout di paling bawah */
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

        .logout-form {
            margin-top: auto;
        }

        /* ===== LOGOUT BUTTON (Identik Dashboard) ===== */
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

        /* ===== MAIN CONTAINER ===== */
        .main-container {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
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

        .topbar h2 { font-size: 1.25rem; margin: 0; font-family: 'Montserrat'; }
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
        .username { color: #F97316; font-weight: 600; }

        /* ===== CONTENT ===== */
        .content {
            padding: 2.5rem 2rem;
        }

        /* Card & Table Styling */
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

        /* Button Styling */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.85rem;
            color: #fff;
        }

        .btn-orange { background: #F97316; }
        .btn-orange:hover { background: #ea580c; transform: translateY(-2px); }
        
        .btn-outline { border: 1px solid #374151; color: #9CA3AF; background: transparent; }
        .btn-danger-outline { border: 1px solid #EF4444; color: #EF4444; background: transparent; }
        .btn-info-outline { border: 1px solid #60A5FA; color: #60A5FA; background: transparent; }

        /* Action Icons */
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

        /* Modal Styles */
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0; 
            width: 100%; height: 100%; 
            background: rgba(0,0,0,0.85); 
            backdrop-filter: blur(8px); 
            overflow-y: auto; 
        }
        .modal-content { 
            background: #161616; 
            margin: 3rem auto; 
            padding: 2.5rem; 
            border: 1px solid rgba(255,255,255,0.1); 
            width: 90%; 
            max-width: 600px; 
            border-radius: 20px; 
        }

        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.6rem; color: #9CA3AF; font-size: 0.85rem; }
        .form-control { 
            width: 100%; 
            padding: 0.9rem; 
            background: #222; 
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 10px; 
            color: #fff; 
            outline: none; 
            transition: 0.3s;
        }
        .form-control:focus { border-color: #F97316; }
        .form-error {
            color: #FCA5A5;
            font-size: 0.78rem;
            margin-top: 0.45rem;
            display: block;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .badge-status { 
            padding: 5px 10px; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            font-weight: 600; 
        }
        .bg-success-subtle { background: rgba(16, 185, 129, 0.1); color: #10B981; }

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
    </style>
</head>
<body>

<nav class="sidebar">
    <a href="#" class="logo">EPIM.TI</a>
    <div class="menu">
        <a href="{{ route('dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="{{ route('Lomba.peserta.index') }}" class="active"><i class="fa-solid fa-trophy"></i> Daftar Lomba</a>
        
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
        <h2>Panel Peserta</h2>
        <a href="{{ route('profile.edit') }}" class="user-info" title="Edit data diri">
            Halo, <span class="username">{{ Auth::user()->name }}</span>
        </a>
    </header>

    <main class="content">
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(16, 185, 129, 0.2);">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i> Mohon lengkapi data pendaftaran dengan benar.
            </div>
        @endif

        <div class="card-table">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="margin:0; font-family:'Montserrat';">Status Pendaftaran</h3>
                @if($datas->isEmpty())
                    <button class="btn btn-orange" onclick="openModal('modalCreate')">
                        <i class="fa-solid fa-plus"></i> Daftar Sekarang
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Info Tim & Lomba</th>
                            @if(auth()->user()->role == 'admin')
                                <th>Pendaftar (User)</th> @endif
                            <th>Proposal</th>
                            <th>Orisinalitas</th>
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

                            <td>
                                @if($data->proposal)
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <a href="{{ asset('uploads/proposal/' . $data->proposal) }}" target="_blank" class="btn btn-info-outline" style="padding: 5px 10px;">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <button class="btn btn-danger-outline" style="padding: 5px 10px;" onclick="openModal('modalHapusProposal{{ $data->id }}')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @else
                                    <button class="btn btn-orange" onclick="openModal('modalProposal{{ $data->id }}')">
                                        <i class="fa-solid fa-upload"></i> Upload
                                    </button>
                                @endif
                            </td>

                            <td>
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
                                    <button class="btn btn-orange" onclick="openModal('modalOrisinalitas{{ $data->id }}')">
                                        <i class="fa-solid fa-upload"></i> Upload
                                    </button>
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
                            <td colspan="{{ auth()->user()->role == 'admin' ? 6 : 5 }}" style="text-align:center; padding:60px; color:#4B5563;">
                                Anda belum mendaftarkan tim manapun.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>


                </table>

            </div>

        </div>

    </main>

</div>


<div id="modalLogout" class="modal">
    <div class="modal-content" style="text-align:center;">
        <i class="fa-solid fa-right-from-bracket" style="font-size:3rem; color:#EF4444; margin-bottom:15px;"></i>
        <h3>Yakin ingin keluar?</h3>
        <p style="color:#9CA3AF; font-size:0.9rem; line-height:1.6; margin:10px 0 0;">
            Sesi akun kamu akan diakhiri.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-outline" style="flex:1" onclick="closeModal('modalLogout')">Batal</button>
                <button type="submit" class="btn btn-orange" style="flex:1; background:#EF4444;">Ya, Logout</button>
            </div>
        </form>
    </div>
</div>


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
            </div>

            <button class="btn btn-outline" style="width:100%; margin-top:20px;" onclick="closeModal('modalDetail{{ $data->id }}')">Tutup</button>
        </div>
    </div>

    <div id="modalProposal{{ $data->id }}" class="modal">
        <div class="modal-content">
            <h3>Upload Proposal</h3>
            <form action="{{ route('Lomba.peserta.tambahproposal', $data->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group"><input type="file" name="proposal" class="form-control" required accept=".pdf"></div>
                <button type="submit" class="btn btn-orange" style="width:100%">Kirim Proposal</button>
            </form>
            <button class="btn btn-outline" style="width:100%; margin-top:10px;" onclick="closeModal('modalProposal{{ $data->id }}')">Batal</button>
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
                @csrf
                @method('DELETE')
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
                    <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                    @error('asal_sekolah') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Guru Pembimbing</label>
                    <input type="text" name="guru_pembimbing" class="form-control" value="{{ old('guru_pembimbing') }}" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
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
                        <label>Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" value="{{ old('nama_ketua') }}" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                        @error('nama_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>No WA Ketua</label>
                        <input type="text" name="hp_ketua" class="form-control" value="{{ old('hp_ketua') }}" required placeholder="08xxx" pattern="^[0-9+\-\s]+$" title="Hanya boleh angka, spasi, +, atau -.">
                        @error('hp_ketua') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                </div>

                <p style="color:#9CA3AF; font-size:0.75rem; border-top:1px solid #333; padding-top:15px;">Anggota</p>

                <div class="input-grid">
                    <div class="form-group">
                        <input type="text" name="anggota_1" class="form-control" value="{{ old('anggota_1') }}" placeholder="Nama Anggota 1" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                        @error('anggota_1') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="hp_1" class="form-control" value="{{ old('hp_1') }}" placeholder="WA Anggota 1" required pattern="^[0-9+\-\s]+$" title="Hanya boleh angka, spasi, +, atau -.">
                        @error('hp_1') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="input-grid">
                    <div class="form-group">
                        <input type="text" name="anggota_2" class="form-control" value="{{ old('anggota_2') }}" placeholder="Nama Anggota 2" required pattern="^[^<>]+$" title="Tidak boleh kosong atau berisi tag HTML.">
                        @error('anggota_2') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="hp_2" class="form-control" value="{{ old('hp_2') }}" placeholder="WA Anggota 2" required pattern="^[0-9+\-\s]+$" title="Hanya boleh angka, spasi, +, atau -.">
                        @error('hp_2') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:20px;">

                    <button type="button" class="btn btn-outline" style="flex:1" onclick="goToStep(1)">Kembali</button>

                    <button type="button" class="btn btn-orange" style="flex:1" onclick="goToStep(3)">Lanjut</button>

                </div>

            </div>



            <div id="step3" style="display:none;">

                <div style="background:#1a1a1a; padding:20px; border-radius:12px; margin-bottom:20px; text-align:center; border: 1px dashed #444;">

                    <p style="font-size:0.85rem; color:#9CA3AF; margin-bottom:10px;">Transfer Ke:</p>

                    <strong style="font-size:1.2rem; color:#F97316;">MANDIRI : 123-456-7890</strong><br>

                    <span style="font-size:0.75rem;">A/N PANITIA EPIM 2026</span>

                </div>

                <div class="form-group">

                    <label>Upload Bukti Bayar (JPG/PNG)</label>

                    <input type="file" name="bukti_bayar" class="form-control" required accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    @error('bukti_bayar') <span class="form-error">{{ $message }}</span> @enderror

                </div>

                <div style="display:flex; gap:10px;">

                    <button type="button" class="btn btn-outline" style="flex:1" onclick="goToStep(2)">Kembali</button>

                    <button type="submit" class="btn btn-orange" style="flex:1">Daftar Sekarang</button>

                </div>

            </div>

        </form>

    </div>

</div>



<script>

    function openModal(id) {

        if(id === 'modalCreate') goToStep(1);

        const modal = document.getElementById(id);
        if (modal) modal.style.display = "block";

    }

   

    function closeModal(id) { document.getElementById(id).style.display = "none"; }

   

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

        if (step > activeStepNumber && !validateStep(activeStepNumber)) {
            return;
        }

        document.getElementById('step1').style.display = 'none';

        document.getElementById('step2').style.display = 'none';

        document.getElementById('step3').style.display = 'none';

        document.getElementById('step' + step).style.display = 'block';



        document.getElementById('ind1').style.background = (step >= 1) ? '#F97316' : '#333';

        document.getElementById('ind2').style.background = (step >= 2) ? '#F97316' : '#333';

        document.getElementById('ind3').style.background = (step >= 3) ? '#F97316' : '#333';

    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            openModal('modalCreate');
        });
    @endif

</script>



</body>

</html>
