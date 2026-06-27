<?php

namespace App\Http\Controllers;

use App\Helpers\PembayaranHelper;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use App\Models\Tim;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LombaController extends Controller
{
    public function index(Request $request)
    {
        $listKategori = \App\Models\KategoriLomba::all();
        $user = auth()->user();

        $query = Pendaftar::with('tim', 'kategori', 'user');

        if ($user->role == 'admin') {
            // Filter by kategori
            if ($request->filled('filter_kategori')) {
                $query->where('id_lomba', $request->filter_kategori);
            }
            // Filter by status
            if ($request->filled('filter_status')) {
                $query->where('status_kelulusan', $request->filter_status);
            }
            // Search by nama_tim
            if ($request->filled('search_tim')) {
                $search = $request->search_tim;
                $query->whereHas('tim', function ($q) use ($search) {
                    $q->where('nama_tim', 'like', '%' . $search . '%');
                });
            }
            $query->orderBy('updated_at', 'desc');
            $datas = $query->paginate(10)->withQueryString();
        } else {
            $datas = $query->where('user_id', $user->id)->get();
        }

        // Inject payment info per pendaftar (only for non-paginated collection)
        if ($user->role != 'admin') {
            foreach ($datas as $d) {
                $d->payment_info = PembayaranHelper::getInfo($d->id_lomba);
            }
        } else {
            foreach ($datas as $d) {
                $d->payment_info = PembayaranHelper::getInfo($d->id_lomba);
            }
        }

        $pengaturan = Pengaturan::first() ?? (object) [
            'status_pendaftaran_ditutup' => 0,
            'status_upload_postervideo_ditutup' => 0,
            'status_pengumpulan_karya' => 0,
        ];

        $deadline = \Carbon\Carbon::parse('2026-08-13 23:59:00', 'Asia/Jakarta');
        $isExpired = now()->setTimezone('Asia/Jakarta')->gt($deadline);

        // Check if user has any pendaftaran (for alert logic)
        $userHasPendaftaran = Pendaftar::where('user_id', $user->id)->exists();

        $filterKategori = $request->filter_kategori;
        $filterStatus = $request->filter_status;

        // Check if user has any pendaftaran with incomplete karya (for alert logic)
        $userHasUnsubmittedKarya = false;
        if ($user->role != 'admin') {
            $userPendaftarans = Pendaftar::where('user_id', $user->id)->get();
            foreach ($userPendaftarans as $p) {
                $karyaComplete = match ($p->id_lomba) {
                    1 => (bool) $p->judul_karya,
                    2 => (bool) $p->judul_karya,
                    3 => (bool) $p->judul_karya,
                    4 => (bool) $p->link_video_karya,
                    default => false,
                };
                if (!$karyaComplete) {
                    $userHasUnsubmittedKarya = true;
                    break;
                }
            }
        }

        $paymentMap = [
            1 => \App\Helpers\PembayaranHelper::getInfo(1),
            2 => \App\Helpers\PembayaranHelper::getInfo(2),
            3 => \App\Helpers\PembayaranHelper::getInfo(3),
            4 => \App\Helpers\PembayaranHelper::getInfo(4),
            5 => \App\Helpers\PembayaranHelper::getInfo(5),
        ];

        return view('lomba.index', compact('listKategori', 'datas', 'pengaturan', 'deadline', 'isExpired', 'filterKategori', 'filterStatus', 'userHasPendaftaran', 'userHasUnsubmittedKarya', 'paymentMap'));
    }

    public function store(Request $request)
    {
        // ► GATEKEEP: cek pendaftaran ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_pendaftaran_ditutup) {
            return back()->with('error', 'Maaf, pendaftaran lomba saat ini sudah ditutup oleh Admin.');
        }

        // ► FITUR 8: Batas 1 pendaftaran per user
        $sudahDaftar = Pendaftar::where('user_id', auth()->id())->exists();
        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah terdaftar di salah satu lomba. Setiap akun hanya dapat mendaftar 1 lomba.');
        }

        $idLomba = $request->input('id_lomba');

        $rules = [
            'id_lomba' => 'required|exists:kategori_lomba,id',
            'orisinalitas' => 'required|file|mimes:pdf|max:10240',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'bukti_status_aktif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_sosmed' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_twibon' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'judul_karya' => 'required|string|max:255|not_regex:/<[^>]*>/',
            'accepted_integrity' => 'required|accepted',
        ];

        $noHtmlText = 'required|string|max:150|not_regex:/<[^>]*>/';
        $phoneRule = 'required|string|max:20|regex:/^[0-9+\-\s]+$/|not_regex:/<[^>]*>/';  // Required for all categories
        $rules['nama_ketua'] = $noHtmlText;
        $rules['nis_nim_ketua'] = 'required|string|max:50|not_regex:/<[^>]*>/';
        $rules['hp_ketua'] = $phoneRule;

        if ($idLomba == 1 || $idLomba == 2) {
            $rules['nama_tim'] = $noHtmlText;
            $rules['asal_sekolah'] = $noHtmlText;
            $rules['guru_pembimbing'] = $noHtmlText;
            $rules['proposal'] = 'required|file|mimes:pdf|max:10240';
            // $rules['subtema'] = 'required|string|in:Manajemen absensi,Perpustakaan,Ekstrakurikuler,Kantin sehat';

            // Anggota 1 is required for Web Programming/Network Engineering because min 2 people (Ketua + Anggota 1)
            $rules['anggota_1'] = $noHtmlText;
            $rules['anggota_nis_1'] = 'required|string|max:50|not_regex:/<[^>]*>/';
            $rules['hp_1'] = $phoneRule;

            // Anggota 2 is optional (nullable)
            $rules['anggota_2'] = 'nullable|string|max:150|not_regex:/<[^>]*>/';
            $rules['anggota_nis_2'] = 'nullable|string|max:50|not_regex:/<[^>]*>/';
            $rules['hp_2'] = 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/|not_regex:/<[^>]*>/';
        } else {
            // ID 3 (Design Packaging), ID 5 (Cyber Security) require proposal/berkas
            if (in_array($idLomba, [3, 5])) {
                $rules['proposal'] = 'required|file|mimes:pdf|max:10240';
            } else {
                $rules['proposal'] = 'nullable|file|mimes:pdf|max:10240';
            }

            if ($idLomba == 4) {
                $rules['link_video_karya'] = 'required|url|max:500';
            }
        }

        $validated = $request->validate($rules, [
            '*.required' => ':attribute wajib diisi.',
            '*.not_regex' => ':attribute tidak boleh berisi tag HTML.',
            '*.max' => ':attribute terlalu panjang.',
            '*.regex' => ':attribute hanya boleh berisi angka, spasi, +, atau -.',
            'id_lomba.exists' => 'Kategori lomba tidak valid.',
            'accepted_integrity.required' => 'Anda wajib menyetujui pernyataan integritas.',
            'accepted_integrity.accepted' => 'Anda wajib menyetujui pernyataan integritas.',
        ], [
            'nama_tim' => 'Nama tim',
            'asal_sekolah' => 'Sekolah',
            'guru_pembimbing' => 'Pendamping',
            'id_lomba' => 'Kategori lomba',
            'nama_ketua' => 'Nama',
            'hp_ketua' => 'No WA',
            'nis_nim_ketua' => 'NIM',
            'proposal' => 'Proposal',
            'orisinalitas' => 'Lembar orisinalitas',
            'bukti_bayar' => 'Bukti pembayaran',
            'bukti_status_aktif' => 'Bukti status aktif',
            'bukti_sosmed' => 'Bukti follow sosmed',
            'bukti_twibon' => 'Bukti twibon',
            'judul_karya' => 'Judul karya',
            'subtema' => 'Subtema',
            'gambar_karya' => 'File poster',
            'link_video_karya' => 'Link video',
            'anggota_1' => 'Nama anggota 1',
            'anggota_nis_1' => 'NIS/NIM anggota 1',
            'hp_1' => 'WA anggota 1',
            'anggota_2' => 'Nama anggota 2',
            'anggota_nis_2' => 'NIS/NIM anggota 2',
            'hp_2' => 'WA anggota 2',
        ]);

        $tim = new Tim;
        if ($idLomba == 1) {
            $tim->nama_tim = $validated['nama_tim'];
            $tim->asal_sekolah = $validated['asal_sekolah'];
            $tim->guru_pembimbing = $validated['guru_pembimbing'];
            $tim->no_hp = auth()->user()->nomor_telp ?? '08xxxxxxxxxx';
        } else if ($idLomba == 2) {
            $tim->nama_tim = $validated['nama_tim'];
            $tim->asal_sekolah = $validated['asal_sekolah'];
            $tim->guru_pembimbing = $validated['guru_pembimbing'];
            $tim->no_hp = auth()->user()->nomor_telp ?? '08xxxxxxxxxx';
        } else {
            $tim->nama_tim = $validated['nama_ketua'];
            $tim->asal_sekolah = auth()->user()->institusi ?? '-';
            $tim->guru_pembimbing = '-';
            $tim->no_hp = $validated['hp_ketua'];
        }
        $tim->save();

        $pendaftar = new Pendaftar;
        $pendaftar->user_id = auth()->id();
        $pendaftar->tim_id = $tim->id;
        $pendaftar->id_lomba = $idLomba;

        $pendaftar->nama_ketua = $validated['nama_ketua'];
        $pendaftar->hp_ketua = $validated['hp_ketua'];
        $pendaftar->nis_nim_ketua = $validated['nis_nim_ketua'];

        if ($idLomba == 1) {
            $pendaftar->anggota_1 = $validated['anggota_1'];
            $pendaftar->anggota_nis_1 = $validated['anggota_nis_1'];
            $pendaftar->hp_1 = $validated['hp_1'];
            $pendaftar->anggota_2 = $request->anggota_2 ?? null;
            $pendaftar->anggota_nis_2 = $request->anggota_nis_2 ?? null;
            $pendaftar->hp_2 = $request->hp_2 ?? null;
        } else if ($idLomba == 2) {
            $pendaftar->anggota_1 = $validated['anggota_1'];
            $pendaftar->anggota_nis_1 = $validated['anggota_nis_1'];
            $pendaftar->hp_1 = $validated['hp_1'];
            $pendaftar->anggota_2 = $request->anggota_2 ?? null;
            $pendaftar->anggota_nis_2 = $request->anggota_nis_2 ?? null;
            $pendaftar->hp_2 = $request->hp_2 ?? null;
        }


        $pendaftar->status_pembayaran = 'verified';
        $pendaftar->accepted_integrity = true;
        $pendaftar->judul_karya = $validated['judul_karya'];

        if ($idLomba == 1 && $request->filled('subtema')) {
            $pendaftar->subtema = $request->subtema;
        } elseif ($idLomba == 4) {
            $pendaftar->link_video_karya = $validated['link_video_karya'];
        }

        // Simpan pendaftar terlebih dahulu agar mendapatkan database ID (sebagai No Pendaftaran)
        $pendaftar->save();

        // Ambil nama kategori lomba secara dinamis untuk penamaan file
        $kategoriModel = \App\Models\KategoriLomba::find($idLomba);
        $slugLomba = \Illuminate\Support\Str::slug($kategoriModel->nama_lomba ?? 'lomba', '_');
        $namaIdentifier = $idLomba == 1 || $idLomba == 2 ? $validated['nama_ketua'] . '_' . $validated['nama_tim'] : $validated['nama_ketua'];
        $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');

        $updateData = [];

        if ($request->hasFile('proposal')) {
            $f = $request->file('proposal');
            $filename = 'proposal_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/proposal'), $filename);
            $pendaftar->proposal = $filename;
            $updateData['proposal'] = $filename;
        }
        if ($request->hasFile('orisinalitas')) {
            $f = $request->file('orisinalitas');
            $filename = 'orisinalitas_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/orisinalitas'), $filename);
            $pendaftar->orisinalitas = $filename;
            $updateData['orisinalitas'] = $filename;
        }
        if ($request->hasFile('bukti_bayar')) {
            $f = $request->file('bukti_bayar');
            $filename = 'bayar_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/pembayaran'), $filename);
            $pendaftar->bukti_bayar = $filename;
            $updateData['bukti_bayar'] = $filename;
        }
        if ($request->hasFile('bukti_status_aktif')) {
            $f = $request->file('bukti_status_aktif');
            $filename = 'status_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/status_aktif'), $filename);
            $pendaftar->bukti_status_aktif = $filename;
            $updateData['bukti_status_aktif'] = $filename;
        }
        if ($request->hasFile('bukti_sosmed')) {
            $f = $request->file('bukti_sosmed');
            $filename = 'sosmed_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/sosmed'), $filename);
            $pendaftar->bukti_sosmed = $filename;
            $updateData['bukti_sosmed'] = $filename;
        }
        if ($request->hasFile('bukti_twibon')) {
            $f = $request->file('bukti_twibon');
            $filename = 'twibon_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/twibon'), $filename);
            $pendaftar->bukti_twibon = $filename;
            $updateData['bukti_twibon'] = $filename;
        }
        if ($request->hasFile('gambar_karya')) {
            $f = $request->file('gambar_karya');
            $filename = 'POSTER_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/karya'), $filename);
            $pendaftar->gambar_karya = $filename;
            $updateData['gambar_karya'] = $filename;
        }

        if (!empty($updateData)) {
            $pendaftar->save();
        }

        // WA Group link
        $waMap = [1 => 'DqYNGG634VO7zEkYmczuVM', 2 => 'Edj1nHP9pYOH3dEHKK5kZQ', 3 => 'EQWLSjH6VBmBXeoWy3cTZO', 4 => 'EGjLe4LcTUGFJNSUZP2u2H'];
        $waLink = 'https://chat.whatsapp.com/' . ($waMap[$idLomba] ?? 'EPIM2026');

        return redirect()
            ->route('Lomba.peserta.index')
            ->with('success', 'Pendaftaran berhasil dikirim!')
            ->with('wa_group', $waLink);
    }

    public function edit($id)
    {
        try {
            $id_pendaftar = Crypt::decrypt($id);
            $data = Pendaftar::where('id', $id_pendaftar)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('lomba.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
    }

    public function tambahproposal(Request $request, $user_id)
    {
        // ► GATEKEEP: cek upload proposal ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup) {
            return back()->with('error', 'Maaf, pengumpulan proposal saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'proposal' => 'nullable|file|mimes:pdf|max:10240',
            'linkvideo' => 'nullable|url',
        ]);

        $query = Pendaftar::where('user_id', $user_id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->firstOrFail();

        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $slugLomba = \Illuminate\Support\Str::slug($data->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $data->id_lomba == 1 || $data->id_lomba == 2 ? $data->nama_ketua . '_' . ($data->tim->nama_tim ?? '') : $data->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $nama_file = 'proposal_' . $slugLomba . '_' . $slugNama . '_reg' . $data->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/proposal'), $nama_file);

            $data->proposal = $nama_file;
        }

        if ($request->linkvideo) {
            $data->proposal = $request->linkvideo;
        }

        $data->save();

        return back()->with('success', 'Berkas proposal berhasil diunggah!');
    }

    public function hapusproposal($user_id)
    {
        // ► GATEKEEP: cek upload ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup) {
            return back()->with('error', 'Maaf, penghapusan berkas saat ini sudah ditutup oleh Admin.');
        }

        $query = Pendaftar::where('user_id', $user_id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->first();

        if ($data && $data->proposal) {
            $filePath = public_path('uploads/proposal/' . $data->proposal);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $data->proposal = null;
            $data->save();

            return back()->with('success', 'Berkas proposal berhasil dihapus.');
        }

        return back()->with('error', 'Berkas tidak ditemukan atau sudah dihapus.');
    }

    public function tambahorisinalitas(Request $request, $id)
    {
        // ► GATEKEEP: cek upload ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup) {
            return back()->with('error', 'Maaf, pengumpulan berkas saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'orisinalitas' => 'required|mimes:pdf|max:10240',
        ]);

        $query = Pendaftar::where('user_id', $id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->firstOrFail();

        if ($request->hasFile('orisinalitas')) {
            // Delete old file if exists
            if ($data->orisinalitas && file_exists(public_path('uploads/orisinalitas/' . $data->orisinalitas))) {
                unlink(public_path('uploads/orisinalitas/' . $data->orisinalitas));
            }

            $file = $request->file('orisinalitas');
            $slugLomba = \Illuminate\Support\Str::slug($data->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $data->id_lomba == 1 || $data->id_lomba == 2 ? $data->nama_ketua . '_' . ($data->tim->nama_tim ?? '') : $data->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $nama_file = 'orisinalitas_' . $slugLomba . '_' . $slugNama . '_reg' . $data->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/orisinalitas'), $nama_file);

            $data->update(['orisinalitas' => $nama_file]);
        }

        return back()->with('success', 'Lembar Orisinalitas berhasil diupload!');
    }

    public function hapusorisinalitas($id)
    {
        // ► GATEKEEP: cek upload ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup) {
            return back()->with('error', 'Maaf, penghapusan berkas saat ini sudah ditutup oleh Admin.');
        }

        $query = Pendaftar::where('user_id', $id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->firstOrFail();

        if ($data->orisinalitas && file_exists(public_path('uploads/orisinalitas/' . $data->orisinalitas))) {
            unlink(public_path('uploads/orisinalitas/' . $data->orisinalitas));
        }

        $data->update(['orisinalitas' => null]);

        return back()->with('success', 'Lembar Orisinalitas berhasil dihapus!');
    }

    public function destroy($id)
    {
        try {
            $realId = Crypt::decrypt($id);
            $pendaftar = Pendaftar::findOrFail($realId);

            if (auth()->user()->role !== 'admin') {
                abort(403);
            }

            // Hapus semua file berkas di public/uploads jika ada
            $filesToDelete = [
                'proposal' => 'proposal',
                'orisinalitas' => 'orisinalitas',
                'bukti_bayar' => 'pembayaran',
                'bukti_status_aktif' => 'status_aktif',
                'bukti_sosmed' => 'sosmed',
                'bukti_twibon' => 'twibon',
                'gambar_karya' => 'karya',
            ];

            foreach ($filesToDelete as $field => $folder) {
                if ($pendaftar->$field && file_exists(public_path("uploads/{$folder}/" . $pendaftar->$field))) {
                    unlink(public_path("uploads/{$folder}/" . $pendaftar->$field));
                }
            }

            $timId = $pendaftar->tim_id;
            $namaTim = $pendaftar->tim->nama_tim ?? 'Tim #' . $realId;
            $pendaftar->delete();

            // Hapus record tim terkait agar tidak membebani database
            if ($timId) {
                \App\Models\Tim::where('id', $timId)->delete();
            }

            // ► FITUR 9: Log aktivitas admin
            $admin = auth()->user();
            ActivityLog::create([
                'admin_id'    => $admin->id,
                'admin_name'  => $admin->name,
                'action'      => 'Hapus Peserta',
                'target_type' => 'pendaftar',
                'target_id'   => $realId,
                'target_name' => $namaTim,
                'keterangan'  => 'Menghapus pendaftaran tim dan berkas terkait',
            ]);

            return back()->with('success', 'Pendaftaran tim dan seluruh berkasnya berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function tiketFinalis()
    {
        $user = auth()->user();
        $pendaftar = Pendaftar::with('tim', 'kategori')
            ->where('user_id', $user->id)
            ->where('status_kelulusan', 'lolos')
            ->first();

        if (!$pendaftar) {
            return redirect()
                ->route('Lomba.peserta.index')
                ->with('error', 'Anda belum dinyatakan lolos penyisihan.');
        }

        return view('lomba.tiket', compact('pendaftar'));
    }

    public function aturKelulusan($id, $status)
    {
        if (!in_array($status, ['lolos', 'tidak_lolos'])) {
            return back()->with('error', 'Status kelulusan tidak valid.');
        }
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->status_kelulusan = $status;
        $pendaftar->save();

        // ► FITUR 9: Log aktivitas admin
        $admin = Auth::user();
        $namaTim = $pendaftar->tim->nama_tim ?? 'Tim #' . $id;
        ActivityLog::create([
            'admin_id'    => $admin->id,
            'admin_name'  => $admin->name,
            'action'      => $status === 'lolos' ? 'Loloskan Peserta' : 'Tolak Peserta',
            'target_type' => 'pendaftar',
            'target_id'   => $id,
            'target_name' => $namaTim,
            'keterangan'  => 'Status kelulusan diubah menjadi ' . strtoupper($status),
        ]);

        return back()->with('success', 'Status kelulusan ' . $namaTim . ': ' . strtoupper($status));
    }

    public function updateStatusAktif(Request $request, $id)
    {
        // ► GATEKEEP: cek pendaftaran ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && ($pengaturan->status_pendaftaran_ditutup || $pengaturan->status_upload_postervideo_ditutup) && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Maaf, pengeditan berkas pendaftaran saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'bukti_status_aktif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $query = Pendaftar::where('user_id', $id);
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
        $data = $query->firstOrFail();

        if ($request->hasFile('bukti_status_aktif')) {
            // Hapus file lama jika ada
            if ($data->bukti_status_aktif && file_exists(public_path('uploads/status_aktif/' . $data->bukti_status_aktif))) {
                unlink(public_path('uploads/status_aktif/' . $data->bukti_status_aktif));
            }

            $f = $request->file('bukti_status_aktif');
            $slugLomba = \Illuminate\Support\Str::slug($data->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $data->id_lomba == 1 || $data->id_lomba == 2 ? $data->nama_ketua . '_' . ($data->tim->nama_tim ?? '') : $data->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $filename = 'status_' . $slugLomba . '_' . $slugNama . '_reg' . $data->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/status_aktif'), $filename);

            $data->bukti_status_aktif = $filename;
            $data->save();
        }

        return back()->with('success', 'Bukti KTM/Status Aktif berhasil diperbarui!');
    }

    public function updateSosmed(Request $request, $id)
    {
        // ► GATEKEEP: cek pendaftaran ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && ($pengaturan->status_pendaftaran_ditutup || $pengaturan->status_upload_postervideo_ditutup) && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Maaf, pengeditan berkas pendaftaran saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'bukti_sosmed' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $query = Pendaftar::where('user_id', $id);
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
        $data = $query->firstOrFail();

        if ($request->hasFile('bukti_sosmed')) {
            // Hapus file lama jika ada
            if ($data->bukti_sosmed && file_exists(public_path('uploads/sosmed/' . $data->bukti_sosmed))) {
                unlink(public_path('uploads/sosmed/' . $data->bukti_sosmed));
            }

            $f = $request->file('bukti_sosmed');
            $slugLomba = \Illuminate\Support\Str::slug($data->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $data->id_lomba == 1 || $data->id_lomba == 2 ? $data->nama_ketua . '_' . ($data->tim->nama_tim ?? '') : $data->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $filename = 'sosmed_' . $slugLomba . '_' . $slugNama . '_reg' . $data->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $f->getClientOriginalExtension();
            $f->move(public_path('uploads/sosmed'), $filename);

            $data->bukti_sosmed = $filename;
            $data->save();
        }

        return back()->with('success', 'Bukti Follow Sosial Media berhasil diperbarui!');
    }

    public function updateBukti(Request $request, $id)
    {
        // ► GATEKEEP: cek pendaftaran ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && ($pengaturan->status_pendaftaran_ditutup || $pengaturan->status_upload_postervideo_ditutup)) {
            return back()->with('error', 'Maaf, pengeditan berkas pendaftaran saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bukti_status_aktif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_sosmed' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_twibon' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            '*.image' => ':attribute harus berupa gambar.',
            '*.mimes' => ':attribute formatnya tidak valid.',
            '*.max' => ':attribute maksimal 2MB.',
        ], [
            'bukti_bayar' => 'Bukti Pembayaran',
            'bukti_status_aktif' => 'Bukti Status Aktif',
            'bukti_sosmed' => 'Bukti Sosial Media',
        ]);

        $pendaftar = Pendaftar::where('id', $id);
        if (auth()->user()->role !== 'admin') {
            $pendaftar->where('user_id', auth()->id());
        }
        $pendaftar = $pendaftar->firstOrFail();

        $updateData = [];

        $slugLomba = \Illuminate\Support\Str::slug($pendaftar->kategori->nama_lomba ?? 'lomba', '_');
        $namaIdentifier = $pendaftar->id_lomba == 1 || $pendaftar->id_lomba == 2 ? $pendaftar->nama_ketua . '_' . ($pendaftar->tim->nama_tim ?? '') : $pendaftar->nama_ketua;
        $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');

        if ($request->hasFile('bukti_bayar')) {
            // Delete old file
            if ($pendaftar->bukti_bayar && file_exists(public_path('uploads/pembayaran/' . $pendaftar->bukti_bayar))) {
                unlink(public_path('uploads/pembayaran/' . $pendaftar->bukti_bayar));
            }
            $file = $request->file('bukti_bayar');
            $filename = 'bayar_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pembayaran'), $filename);
            $updateData['bukti_bayar'] = $filename;
        }

        if ($request->hasFile('bukti_status_aktif')) {
            // Delete old file
            if ($pendaftar->bukti_status_aktif && file_exists(public_path('uploads/status_aktif/' . $pendaftar->bukti_status_aktif))) {
                unlink(public_path('uploads/status_aktif/' . $pendaftar->bukti_status_aktif));
            }
            $file = $request->file('bukti_status_aktif');
            $filename = 'status_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/status_aktif'), $filename);
            $updateData['bukti_status_aktif'] = $filename;
        }

        if ($request->hasFile('bukti_sosmed')) {
            // Delete old file
            if ($pendaftar->bukti_sosmed && file_exists(public_path('uploads/sosmed/' . $pendaftar->bukti_sosmed))) {
                unlink(public_path('uploads/sosmed/' . $pendaftar->bukti_sosmed));
            }
            $file = $request->file('bukti_sosmed');
            $filename = 'sosmed_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sosmed'), $filename);
            $updateData['bukti_sosmed'] = $filename;
        }
        if ($request->hasFile('bukti_twibon')) {
            if ($pendaftar->bukti_twibon && file_exists(public_path('uploads/twibon/' . $pendaftar->bukti_twibon))) {
                unlink(public_path('uploads/twibon/' . $pendaftar->bukti_twibon));
            }
            $file = $request->file('bukti_twibon');
            $filename = 'twibon_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/twibon'), $filename);
            $updateData['bukti_twibon'] = $filename;
        }

        if (!empty($updateData)) {
            $pendaftar->update($updateData);
            return back()->with('success', 'Berkas bukti pendaftaran berhasil diperbarui!');
        }

        return back()->with('info', 'Tidak ada berkas yang diubah.');
    }
}
