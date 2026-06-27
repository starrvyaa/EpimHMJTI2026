<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use App\Models\KategoriLomba;
use Illuminate\Support\Facades\Auth;

class KaryaController extends Controller
{
    const DEADLINE = '2026-08-13 23:59:00';

    public function index()
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Jakarta');
        $deadline = \Carbon\Carbon::parse(self::DEADLINE, 'Asia/Jakarta');
        $isExpired = $now->gt($deadline);

        $pendaftar = Pendaftar::with('tim', 'kategori')
            ->where('user_id', $user->id)
            ->where('status_pembayaran', 'verified')
            ->first();

        if (!$pendaftar) {
            return redirect()->route('Lomba.peserta.index')
                ->with('error', 'Pembayaran Anda belum diverifikasi. Tidak bisa mengakses halaman ini.');
        }

        return redirect()->route('Lomba.peserta.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Jakarta');
        $deadline = \Carbon\Carbon::parse(self::DEADLINE, 'Asia/Jakarta');

        if ($user->role !== 'admin' && $now->gt($deadline)) {
            return back()->with('error', 'Batas waktu pengumpulan karya sudah berakhir (13 Agustus 2026 pukul 23:59 WIB).');
        }

        // ► GATEKEEP: cek upload ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup) {
            return back()->with('error', 'Maaf, pengumpulan karya/proposal saat ini sudah ditutup oleh Admin.');
        }

        if ($user->role === 'admin' && $request->filled('pendaftar_id')) {
            $pendaftar = Pendaftar::with('tim', 'kategori')
                ->where('id', $request->pendaftar_id)
                ->firstOrFail();
        } else {
            $pendaftar = Pendaftar::with('tim', 'kategori')
                ->where('user_id', $user->id)
                ->where('status_pembayaran', 'verified')
                ->firstOrFail();
        }

        $idLomba = $pendaftar->id_lomba;
        $tim = $pendaftar->tim;
        $rules = [];
        $messages = [];

        // Judul — Semua cabang
        $rules['judul_karya'] = 'required|string|max:255|not_regex:/<[^>]*>/';
        $messages['judul_karya.required'] = 'Judul karya wajib diisi.';
        $messages['judul_karya.not_regex'] = 'Judul tidak boleh berisi tag HTML.';

        // Integritas checkbox
        $rules['accepted_integrity_karya'] = 'required|accepted';
        $messages['accepted_integrity_karya.required'] = 'Anda wajib menyetujui pernyataan integritas.';
        $messages['accepted_integrity_karya.accepted'] = 'Anda wajib menyetujui pernyataan integritas.';

        switch ($idLomba) {
            case 1: // Web Programming
                // Subtema di-comment sesuai permintaan agar mudah diaktifkan kembali
                // $rules['subtema'] = 'required|string|in:Manajemen absensi,Perpustakaan,Ekstrakurikuler,Kantin sehat';
                // $messages['subtema.required'] = 'Pilih subtema lomba.';
                // $messages['subtema.in'] = 'Subtema tidak valid.';
                break;

            case 2: // Design Poster (Lama) / Network Engineering (Baru)
                // $rules['gambar_karya'] = 'required|file|mimes:jpg,jpeg,png|max:15360';
                // $messages['gambar_karya.required'] = 'Gambar poster wajib diupload.';
                // $messages['gambar_karya.mimes'] = 'Poster harus JPG/JPEG/PNG (min 300dpi, wajib logo Polije/HMJTI/EPIM).';
                // $messages['gambar_karya.max'] = 'Poster maksimal 15MB.';
                
                // Network Engineering (Baru) - Hanya judul saja, file topologi lewat berkas/proposal
                break;

            case 3: // Design Packaging — judul saja
                break;

            case 4: // Videography
                $rules['link_video_karya'] = 'required|url|max:500';
                $messages['link_video_karya.required'] = 'Link Google Drive wajib diisi.';
                $messages['link_video_karya.url'] = 'Format URL tidak valid (pastikan link diawali https://).';
                $messages['link_video_karya.max'] = 'Link terlalu panjang.';
                break;

            case 5: // Cyber Security - Hanya judul saja, file write-up lewat berkas/proposal
                break;
        }

        $request->validate($rules, $messages);

        $updateData = [
            'judul_karya' => $request->judul_karya,
            'link_video_karya' => $request->link_video_karya,
            'accepted_integrity' => true,
        ];

        if ($request->filled('subtema')) {
            $updateData['subtema'] = $request->subtema;
        }

        // Upload gambar poster
        // if ($request->hasFile('gambar_karya')) {
        //     $file = $request->file('gambar_karya');
        //     $nama = 'POSTER_' . time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('uploads/karya'), $nama);
        //     $updateData['gambar_karya'] = $nama;
        // }

        $pendaftar->update($updateData);

        return redirect()->route('Lomba.peserta.index')->with('success', 'Karya berhasil dikumpulkan! ✅');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Jakarta');
        $deadline = \Carbon\Carbon::parse(self::DEADLINE, 'Asia/Jakarta');

        if ($user->role !== 'admin' && $now->gt($deadline)) {
            return back()->with('error', 'Batas waktu pengumpulan karya sudah berakhir (13 Agustus 2026 pukul 23:59 WIB).');
        }

        // ► GATEKEEP: cek pengumpulan karya ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && !$pengaturan->status_pengumpulan_karya) {
            return back()->with('error', 'Maaf, pengumpulan karya saat ini sedang ditutup oleh Admin.');
        }

        $query = Pendaftar::with('tim', 'kategori')->where('id', $id);
        
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id)->where('status_pembayaran', 'verified');
        }

        $pendaftar = $query->firstOrFail();

        $idLomba = $pendaftar->id_lomba;
        $rules = [];
        $messages = [];

        // Judul
        $rules['judul_karya'] = 'required|string|max:255|not_regex:/<[^>]*>/';
        $messages['judul_karya.required'] = 'Judul karya wajib diisi.';
        $messages['judul_karya.not_regex'] = 'Judul tidak boleh berisi tag HTML.';

        // Subtema — Web (di-comment sesuai permintaan)
        // if ($idLomba == 1) {
        //     $rules['subtema'] = 'required|string|in:Manajemen absensi,Perpustakaan,Ekstrakurikuler,Kantin sehat';
        //     $messages['subtema.required'] = 'Pilih subtema lomba.';
        //     $messages['subtema.in'] = 'Subtema tidak valid.';
        // }

        // Poster Artwork
        // if ($idLomba == 2) {
        //     $rules['gambar_karya'] = 'nullable|file|mimes:jpg,jpeg,png|max:15360';
        //     $messages['gambar_karya.mimes'] = 'Poster harus berupa JPG/JPEG/PNG.';
        //     $messages['gambar_karya.max'] = 'Poster maksimal 15MB.';
        // }

        // Video Link
        if ($idLomba == 4) {
            $rules['link_video_karya'] = 'required|url|max:500';
            $messages['link_video_karya.required'] = 'Link video wajib diisi.';
            $messages['link_video_karya.url'] = 'Format URL tidak valid.';
        }

        // Proposal (Web Programming = 1, Design Packaging = 3)
        // if (in_array($idLomba, [1, 3])) {
        //     $rules['proposal'] = 'nullable|file|mimes:pdf|max:10240';
        //     $messages['proposal.mimes'] = 'Proposal harus berupa PDF.';
        //     $messages['proposal.max'] = 'Proposal maksimal 10MB.';
        // }

        // Untuk lomba baru (ID 2 = Network Engineering, ID 5 = Cyber Security, ID 1 = Web, ID 3 = Packaging)
        if (in_array($idLomba, [1, 2, 3, 5])) {
            $allowedMimes = $idLomba == 2 ? 'pdf,zip,rar' : 'pdf';
            $allowedMimesMsg = $idLomba == 2 ? 'PDF, ZIP, atau RAR' : 'PDF';
            $rules['proposal'] = 'nullable|file|mimes:' . $allowedMimes . '|max:15360';
            $messages['proposal.mimes'] = 'Berkas/Proposal harus berupa ' . $allowedMimesMsg . '.';
            $messages['proposal.max'] = 'Berkas/Proposal maksimal 15MB.';
        }

        // Orisinalitas
        $rules['orisinalitas'] = 'nullable|file|mimes:pdf|max:10240';
        $messages['orisinalitas.mimes'] = 'Bukti Orisinalitas harus PDF.';
        $messages['orisinalitas.max'] = 'Bukti Orisinalitas maksimal 10MB.';

        $request->validate($rules, $messages);

        $updateData = [
            'judul_karya' => $request->judul_karya,
        ];

        if ($idLomba == 1 && $request->filled('subtema')) {
            $updateData['subtema'] = $request->subtema;
        }

        // Upload new poster file if provided
        // if ($idLomba == 2 && $request->hasFile('gambar_karya')) {
        //     if ($pendaftar->gambar_karya && file_exists(public_path('uploads/karya/' . $pendaftar->gambar_karya))) {
        //         unlink(public_path('uploads/karya/' . $pendaftar->gambar_karya));
        //     }
        //     $file = $request->file('gambar_karya');
        //     $nama = 'POSTER_' . time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('uploads/karya'), $nama);
        //     $updateData['gambar_karya'] = $nama;
        // }

        // Update video link
        if ($idLomba == 4) {
            $updateData['link_video_karya'] = $request->link_video_karya;
        }

        // Upload new proposal file if provided
        // if (in_array($idLomba, [1, 3]) && $request->hasFile('proposal')) {
        //     if ($pendaftar->proposal && file_exists(public_path('uploads/proposal/' . $pendaftar->proposal))) {
        //         unlink(public_path('uploads/proposal/' . $pendaftar->proposal));
        //     }
        //     $file = $request->file('proposal');
        //     $namaProposal = 'PROPOSAL_' . time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('uploads/proposal'), $namaProposal);
        //     $updateData['proposal'] = $namaProposal;
        // }
        
        // Untuk lomba baru (ID 1, 2, 3, 5)
        if (in_array($idLomba, [1, 2, 3, 5]) && $request->hasFile('proposal')) {
            if ($pendaftar->proposal && file_exists(public_path('uploads/proposal/' . $pendaftar->proposal))) {
                unlink(public_path('uploads/proposal/' . $pendaftar->proposal));
            }
            $file = $request->file('proposal');
            $slugLomba = \Illuminate\Support\Str::slug($pendaftar->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $pendaftar->id_lomba == 1 || $pendaftar->id_lomba == 2 ? $pendaftar->nama_ketua . '_' . ($pendaftar->tim->nama_tim ?? '') : $pendaftar->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $namaProposal = 'proposal_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/proposal'), $namaProposal);
            $updateData['proposal'] = $namaProposal;
        }

        // Upload orisinalitas if provided
        if ($request->hasFile('orisinalitas')) {
            if ($pendaftar->orisinalitas && file_exists(public_path('uploads/orisinalitas/' . $pendaftar->orisinalitas))) {
                unlink(public_path('uploads/orisinalitas/' . $pendaftar->orisinalitas));
            }
            $file = $request->file('orisinalitas');
            $slugLomba = \Illuminate\Support\Str::slug($pendaftar->kategori->nama_lomba ?? 'lomba', '_');
            $namaIdentifier = $pendaftar->id_lomba == 1 || $pendaftar->id_lomba == 2 ? $pendaftar->nama_ketua . '_' . ($pendaftar->tim->nama_tim ?? '') : $pendaftar->nama_ketua;
            $slugNama = \Illuminate\Support\Str::slug($namaIdentifier, '_');
            $namaFile = 'orisinalitas_' . $slugLomba . '_' . $slugNama . '_reg' . $pendaftar->id . '_' . \Illuminate\Support\Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/orisinalitas'), $namaFile);
            $updateData['orisinalitas'] = $namaFile;
        }

        $pendaftar->update($updateData);

        return redirect()->route('Lomba.peserta.index')->with('success', 'Karya berhasil diperbarui! ✅');
    }
}
