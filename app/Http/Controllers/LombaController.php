<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Pengaturan;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LombaController extends Controller
{
    public function index()
{
    $listKategori = \App\Models\KategoriLomba::all();
    $user = auth()->user();

    // LOGIKA FILTER DATA
    if ($user->role == 'admin') {
        // Jika admin, ambil semua data pendaftar beserta relasi timnya
        $datas = Pendaftar::with('tim', 'kategori')->get();
    } else {
        // Jika user biasa, hanya ambil data milik user_id tersebut
        $datas = Pendaftar::with('tim', 'kategori')->where('user_id', $user->id)->get();
    }

    $pengaturan = Pengaturan::first() ?? (object)[
        'status_pendaftaran_ditutup' => 0,
        'status_upload_postervideo_ditutup' => 0
    ];

    return view('lomba.index', compact('listKategori', 'datas', 'pengaturan'));
}
   public function store(Request $request)
{
    // 1. Simpan ke tabel Tim
    $tim = new \App\Models\Tim;
    $tim->nama_tim = $request->nama_tim;
    $tim->asal_sekolah = $request->asal_sekolah;
    $tim->guru_pembimbing = $request->guru_pembimbing;
    // Tambahkan baris ini agar kolom no_hp di tabel tim terisi
    $tim->no_hp = $request->hp_ketua; 
    $tim->save();

    // 2. Simpan ke tabel Pendaftar
    $pendaftar = new \App\Models\Pendaftar;
    $pendaftar->user_id = auth()->id();
    $pendaftar->tim_id = $tim->id;
    $pendaftar->id_lomba = $request->id_lomba;
    $pendaftar->nama_ketua = $request->nama_ketua;
    $pendaftar->hp_ketua = $request->hp_ketua;
    $pendaftar->anggota_1 = $request->anggota_1;
    $pendaftar->hp_1 = $request->hp_1;
    $pendaftar->anggota_2 = $request->anggota_2;
    $pendaftar->hp_2 = $request->hp_2;
    $pendaftar->anggota_3 = $request->anggota_3;
    $pendaftar->hp_3 = $request->hp_3;

    if ($request->hasFile('bukti_bayar')) {
        $file = $request->file('bukti_bayar');
        $namaFile = 'bayar_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/pembayaran'), $namaFile);
        $pendaftar->bukti_bayar = $namaFile;
    }

    $pendaftar->save();

    return back()->with('success', 'Pendaftaran tim berhasil dikirim!');
}
    // --- FUNGSI BARU UNTUK EDIT ---
    public function edit($id)
    {
        try {
            $id_pendaftar = Crypt::decrypt($id);
            $data = Pendaftar::where('id_pendaftar', $id_pendaftar)
                             ->where('user_id', Auth::id())
                             ->firstOrFail();
            
            return view('lomba.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
    }

    // --- FUNGSI UNTUK UPLOAD PROPOSAL / VIDEO ---
    public function tambahproposal(Request $request, $user_id)
{
    $request->validate([
        'proposal' => 'nullable|file|mimes:pdf|max:2048',
        'linkvideo' => 'nullable|url',
    ]);

    // Ambil data berdasarkan user_id (karena id_user kamu NULL di gambar)
    $data = Pendaftar::where('user_id', $user_id)->firstOrFail();

    if ($request->hasFile('proposal')) {
        $file = $request->file('proposal');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/proposal'), $nama_file);
        
        $data->proposal = $nama_file;
    }

    if ($request->linkvideo) {
        $data->proposal = $request->linkvideo;
    }

    $data->save(); // Sekarang tidak akan error 'id_pendaftar not found'

    return back()->with('success', 'Berkas proposal berhasil diunggah!');
}

public function hapusproposal($user_id)
{
    // Cari data berdasarkan user_id (sesuai kolom di phpMyAdmin kamu)
    $data = \App\Models\Pendaftar::where('user_id', $user_id)->first();

    if ($data && $data->proposal) {
        // Path file yang akan dihapus
        $filePath = public_path('uploads/proposal/' . $data->proposal);

        // Hapus file fisik dari folder public/uploads/proposal jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Update database: set kolom proposal jadi NULL
        $data->proposal = null;
        $data->save();

        return back()->with('success', 'Berkas proposal berhasil dihapus.');
    }

    return back()->with('error', 'Berkas tidak ditemukan atau sudah dihapus.');
}

    // --- FUNGSI UNTUK UPLOAD ORISINALITAS ---
    public function tambahorisinalitas(Request $request, $id)
{
    $request->validate([
        'orisinalitas' => 'required|mimes:pdf|max:2048',
    ]);

    $data = Pendaftar::where('user_id', $id)->firstOrFail();

    if ($request->hasFile('orisinalitas')) {
        $file = $request->file('orisinalitas');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/orisinalitas'), $nama_file);
        
        $data->update(['orisinalitas' => $nama_file]);
    }

    return back()->with('success', 'Lembar Orisinalitas berhasil diupload!');
}

public function hapusorisinalitas($id)
{
    $data = Pendaftar::where('user_id', $id)->firstOrFail();
    
    // Hapus file fisik jika ada
    if ($data->orisinalitas && file_exists(public_path('uploads/orisinalitas/' . $data->orisinalitas))) {
        unlink(public_path('uploads/orisinalitas/' . $data->orisinalitas));
    }

    $data->update(['orisinalitas' => null]);

    return back()->with('success', 'Lembar Orisinalitas berhasil dihapus!');
}

    public function destroy($id)
{
    try {
        // Dekripsi ID yang dikirim dari Blade
        $realId = \Illuminate\Support\Facades\Crypt::decrypt($id);
        
        // Cari data pendaftar
        $pendaftar = \App\Models\Pendaftar::findOrFail($realId);

        // Hapus file proposal jika ada di folder
        if ($pendaftar->proposal && file_exists(public_path('uploads/proposal/' . $pendaftar->proposal))) {
            unlink(public_path('uploads/proposal/' . $pendaftar->proposal));
        }

        // Hapus data pendaftar (Data tim akan ikut terhapus jika kamu pakai onDelete cascade di DB, 
        // jika tidak, hapus manual tim-nya)
        $pendaftar->delete();

        return back()->with('success', 'Pendaftaran tim berhasil dibatalkan dan dihapus.');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
}