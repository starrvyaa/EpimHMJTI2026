<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
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

        if ($now->gt($deadline)) {
            return back()->with('error', 'Batas waktu pengumpulan karya sudah berakhir (13 Agustus 2026 pukul 23:59 WIB).');
        }

        $pendaftar = Pendaftar::with('tim', 'kategori')
            ->where('user_id', $user->id)
            ->where('status_pembayaran', 'verified')
            ->firstOrFail();

        $idLomba = $pendaftar->id_lomba;
        $tim = $pendaftar->tim;
        $rules = [];
        $messages = [];

        // Judul — Semua cabang
        $rules['judul_karya'] = 'required|string|max:255|not_regex:/<[^>]*>/';
        $messages['judul_karya.required'] = 'Judul karya wajib diisi.';
        $messages['judul_karya.not_regex'] = 'Judul tidak boleh berisi tag HTML.';

        // Orisinalitas — Semua cabang
        $rules['orisinalitas'] = 'required|file|mimes:pdf|max:2048';
        $messages['orisinalitas.required'] = 'Surat orisinalitas (materai 10rb) wajib diupload.';
        $messages['orisinalitas.mimes'] = 'Surat orisinalitas harus PDF.';
        $messages['orisinalitas.max'] = 'Surat orisinalitas maksimal 2MB.';

        // Integritas checkbox
        $rules['accepted_integrity_karya'] = 'required|accepted';
        $messages['accepted_integrity_karya.required'] = 'Anda wajib menyetujui pernyataan integritas.';
        $messages['accepted_integrity_karya.accepted'] = 'Anda wajib menyetujui pernyataan integritas.';

        switch ($idLomba) {
            case 1: // Web Programming
                $rules['subtema'] = 'required|string|in:Manajemen absensi,Perpustakaan,Ekstrakurikuler,Kantin sehat';
                $rules['proposal'] = 'required|file|mimes:pdf|max:10240';
                $messages['subtema.required'] = 'Pilih subtema lomba.';
                $messages['subtema.in'] = 'Subtema tidak valid.';
                $messages['proposal.required'] = 'Proposal wajib diupload.';
                $messages['proposal.mimes'] = 'Proposal harus PDF.';
                $messages['proposal.max'] = 'Proposal maksimal 10MB.';
                break;

            case 2: // Design Poster
                $rules['gambar_karya'] = 'required|file|mimes:jpg,jpeg,png|max:15360';
                $messages['gambar_karya.required'] = 'Gambar poster wajib diupload.';
                $messages['gambar_karya.mimes'] = 'Poster harus JPG/JPEG/PNG (min 300dpi, wajib logo Polije/HMJTI/EPIM).';
                $messages['gambar_karya.max'] = 'Poster maksimal 15MB.';
                break;

            case 3: // Design Packaging
                $rules['proposal'] = 'required|file|mimes:pdf|max:10240';
                $messages['proposal.required'] = 'Proposal wajib diupload.';
                $messages['proposal.mimes'] = 'Proposal harus PDF.';
                $messages['proposal.max'] = 'Proposal maksimal 10MB.';
                break;

            case 4: // Videography
                $rules['link_video_karya'] = 'required|url|max:500';
                $messages['link_video_karya.required'] = 'Link Google Drive wajib diisi.';
                $messages['link_video_karya.url'] = 'Format URL tidak valid (pastikan link diawali https://).';
                $messages['link_video_karya.max'] = 'Link terlalu panjang.';
                break;
        }

        $request->validate($rules, $messages);

        $updateData = [
            'judul_karya' => $request->judul_karya,
            'subtema' => $request->subtema,
            'link_video_karya' => $request->link_video_karya,
            'accepted_integrity' => true,
        ];

        // Upload orisinalitas
        if ($request->hasFile('orisinalitas')) {
            $file = $request->file('orisinalitas');
            $nama = 'ORISINALITAS_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/orisinalitas'), $nama);
            $updateData['orisinalitas'] = $nama;
        }

        // Upload gambar poster
        if ($request->hasFile('gambar_karya')) {
            $file = $request->file('gambar_karya');
            $nama = 'POSTER_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/karya'), $nama);
            $updateData['gambar_karya'] = $nama;
        }

        // Upload proposal (dengan autoname untuk Packaging)
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $ext = $file->getClientOriginalExtension();

            if ($idLomba == 3) {
                $namaPeserta = str_replace(' ', '_', trim($user->name));
                $asalSekolah = str_replace(' ', '_', trim($tim->asal_sekolah ?? 'Unknown'));
                $namaFile = "Lomba Design Packaging_Proposal_{$namaPeserta}_{$asalSekolah}_EPIM 2026.{$ext}";
            } else {
                $namaFile = 'PROPOSAL_' . time() . '_' . $file->getClientOriginalName();
            }

            $file->move(public_path('uploads/proposal'), $namaFile);
            $updateData['proposal'] = $namaFile;
            $updateData['proposal_nama_file'] = $namaFile;
        }

        $pendaftar->update($updateData);

        return redirect()->route('Lomba.peserta.index')->with('success', 'Karya berhasil dikumpulkan! ✅');
    }
}
