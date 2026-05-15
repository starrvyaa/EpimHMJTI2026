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

    if ($user->role == 'admin') {
        $datas = Pendaftar::with('tim', 'kategori', 'user')->get();
    } else {
        $datas = Pendaftar::with('tim', 'kategori', 'user')
            ->where('user_id', $user->id)
            ->get();
    }

    $pengaturan = Pengaturan::first() ?? (object)[
        'status_pendaftaran_ditutup' => 0,
        'status_upload_postervideo_ditutup' => 0
    ];

    return view('lomba.index', compact('listKategori', 'datas', 'pengaturan'));
}

   public function store(Request $request)
{
    $noHtmlText = 'required|string|max:150|not_regex:/<[^>]*>/';
    $phoneRule = 'required|string|max:20|regex:/^[0-9+\-\s]+$/|not_regex:/<[^>]*>/';

    $validated = $request->validate([
        'nama_tim' => $noHtmlText,
        'asal_sekolah' => $noHtmlText,
        'guru_pembimbing' => $noHtmlText,
        'id_lomba' => 'required|exists:kategori_lomba,id',
        'nama_ketua' => $noHtmlText,
        'hp_ketua' => $phoneRule,
        'anggota_1' => $noHtmlText,
        'hp_1' => $phoneRule,
        'anggota_2' => $noHtmlText,
        'hp_2' => $phoneRule,
        'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png',
    ], [
        '*.required' => ':attribute wajib diisi.',
        '*.not_regex' => ':attribute tidak boleh berisi tag HTML.',
        '*.max' => ':attribute terlalu panjang.',
        '*.regex' => ':attribute hanya boleh berisi angka, spasi, +, atau -.',
        'id_lomba.exists' => 'Kategori lomba tidak valid.',
        'bukti_bayar.image' => 'Bukti bayar harus berupa gambar.',
        'bukti_bayar.mimes' => 'Bukti bayar harus JPG, JPEG, atau PNG.',
    ], [
        'nama_tim' => 'Nama tim',
        'asal_sekolah' => 'Asal sekolah',
        'guru_pembimbing' => 'Guru pembimbing',
        'id_lomba' => 'Kategori lomba',
        'nama_ketua' => 'Nama ketua',
        'hp_ketua' => 'No WA ketua',
        'anggota_1' => 'Nama anggota 1',
        'hp_1' => 'WA anggota 1',
        'anggota_2' => 'Nama anggota 2',
        'hp_2' => 'WA anggota 2',
        'bukti_bayar' => 'Bukti bayar',
    ]);

    // 1. Simpan ke tabel Tim
    $tim = new \App\Models\Tim;
    $tim->nama_tim = $validated['nama_tim'];
    $tim->asal_sekolah = $validated['asal_sekolah'];
    $tim->guru_pembimbing = $validated['guru_pembimbing'];
    // Tambahkan baris ini agar kolom no_hp di tabel tim terisi
    $tim->no_hp = $validated['hp_ketua'];
    $tim->save();

    // 2. Simpan ke tabel Pendaftar
    $pendaftar = new \App\Models\Pendaftar;
    $pendaftar->user_id = auth()->id();
    $pendaftar->tim_id = $tim->id;
    $pendaftar->id_lomba = $validated['id_lomba'];
    $pendaftar->nama_ketua = $validated['nama_ketua'];
    $pendaftar->hp_ketua = $validated['hp_ketua'];
    $pendaftar->anggota_1 = $validated['anggota_1'];
    $pendaftar->hp_1 = $validated['hp_1'];
    $pendaftar->anggota_2 = $validated['anggota_2'];
    $pendaftar->hp_2 = $validated['hp_2'];

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

    $query = Pendaftar::where('user_id', $user_id);

    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    $data = $query->firstOrFail();

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
    $query = \App\Models\Pendaftar::where('user_id', $user_id);

    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    $data = $query->first();

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

    $query = Pendaftar::where('user_id', $id);

    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    $data = $query->firstOrFail();

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
    $query = Pendaftar::where('user_id', $id);

    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    $data = $query->firstOrFail();
    
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

        if (auth()->user()->role !== 'admin' && $pendaftar->user_id !== Auth::id()) {
            abort(403);
        }

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
