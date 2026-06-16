<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Pengaturan;
use App\Models\Pendaftar;
use App\Helpers\PembayaranHelper;
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

        $pengaturan = Pengaturan::first() ?? (object)[
            'status_pendaftaran_ditutup' => 0,
            'status_upload_postervideo_ditutup' => 0,
            'status_pengumpulan_karya' => 0,
        ];

        $deadline = \Carbon\Carbon::parse('2026-08-13 23:59:00', 'Asia/Jakarta');
        $isExpired = now()->setTimezone('Asia/Jakarta')->gt($deadline);

        // Check if user has any pendaftaran (for alert logic)
        $userHasPendaftaran = Pendaftar::where('user_id', $user->id)->exists();

        $filterKategori = $request->filter_kategori;

        // Check if user has any pendaftaran with incomplete karya (for alert logic)
        $userHasUnsubmittedKarya = false;
        if ($user->role != 'admin') {
            $userPendaftarans = Pendaftar::where('user_id', $user->id)->get();
            foreach ($userPendaftarans as $p) {
                $karyaComplete = match ($p->id_lomba) {
                    1 => (bool) $p->judul_karya,
                    2 => (bool) $p->gambar_karya,
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

        return view('lomba.index', compact('listKategori', 'datas', 'pengaturan', 'deadline', 'isExpired', 'filterKategori', 'userHasPendaftaran', 'userHasUnsubmittedKarya'));
    }

    public function store(Request $request)
    {
        // ► GATEKEEP: cek pendaftaran ditutup
        $pengaturan = Pengaturan::first();
        if ($pengaturan && $pengaturan->status_pendaftaran_ditutup) {
            return back()->with('error', 'Maaf, pendaftaran lomba saat ini sudah ditutup oleh Admin.');
        }

        $noHtmlText = 'required|string|max:150|not_regex:/<[^>]*>/';
        $phoneRule = 'required|string|max:20|regex:/^[0-9+\-\s]+$/|not_regex:/<[^>]*>/';

        $rules = [
            'nama_tim' => $noHtmlText,
            'asal_sekolah' => $noHtmlText,
            'guru_pembimbing' => $noHtmlText,
            'id_lomba' => 'required|exists:kategori_lomba,id',
            'nama_ketua' => $noHtmlText,
            'hp_ketua' => $phoneRule,
            'nis_nim_ketua' => 'required|string|max:50|not_regex:/<[^>]*>/',
            'anggota_1' => 'nullable|string|max:150|not_regex:/<[^>]*>/',
            'hp_1' => 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/|not_regex:/<[^>]*>/',
            'anggota_nis_1' => 'nullable|string|max:50|not_regex:/<[^>]*>/',
            'anggota_2' => 'nullable|string|max:150|not_regex:/<[^>]*>/',
            'hp_2' => 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/|not_regex:/<[^>]*>/',
            'anggota_nis_2' => 'nullable|string|max:50|not_regex:/<[^>]*>/',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'bukti_status_aktif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_sosmed' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'accepted_integrity' => 'required|accepted',
        ];

        $msgs = [
            '*.required' => ':attribute wajib diisi.',
            '*.not_regex' => ':attribute tidak boleh berisi tag HTML.',
            '*.max' => ':attribute terlalu panjang.',
            '*.regex' => ':attribute hanya boleh berisi angka, spasi, +, atau -.',
            'id_lomba.exists' => 'Kategori lomba tidak valid.',
            'bukti_status_aktif.required' => 'Bukti status aktif (kartu pelajar/KTM) wajib diupload.',
            'bukti_sosmed.required' => 'Bukti follow sosial media wajib diupload.',
            'accepted_integrity.required' => 'Anda wajib menyetujui pernyataan integritas.',
            'accepted_integrity.accepted' => 'Anda wajib menyetujui pernyataan integritas.',
        ];

        $attrs = [
            'nama_tim' => 'Nama tim', 'asal_sekolah' => 'Asal sekolah',
            'guru_pembimbing' => 'Guru pembimbing', 'id_lomba' => 'Kategori lomba',
            'nama_ketua' => 'Nama ketua', 'hp_ketua' => 'No WA ketua',
            'nis_nim_ketua' => 'NIS/NIM ketua',
            'anggota_1' => 'Nama anggota 1', 'hp_1' => 'WA anggota 1',
            'anggota_nis_1' => 'NIS/NIM anggota 1',
            'anggota_2' => 'Nama anggota 2', 'hp_2' => 'WA anggota 2',
            'anggota_nis_2' => 'NIS/NIM anggota 2',
            'bukti_bayar' => 'Bukti bayar', 'bukti_status_aktif' => 'Bukti status aktif',
            'bukti_sosmed' => 'Bukti sosial media',
        ];

        // Web Programming: anggota opsional (sama seperti lomba lain)
        if ($request->id_lomba == 1) {
            $rules['anggota_1'] = 'nullable|string|max:150|not_regex:/<[^>]*>/';
            $rules['hp_1'] = 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/|not_regex:/<[^>]*>/';
            $rules['anggota_nis_1'] = 'nullable|string|max:50|not_regex:/<[^>]*>/';

            $rules['anggota_2'] = 'nullable|string|max:150|not_regex:/<[^>]*>/';
            $rules['hp_2'] = 'nullable|string|max:20|regex:/^[0-9+\-\s]*$/|not_regex:/<[^>]*>/';
            $rules['anggota_nis_2'] = 'nullable|string|max:50|not_regex:/<[^>]*>/';
        }

        $validated = $request->validate($rules, $msgs, $attrs);

        $tim = new Tim;
        $tim->nama_tim = $validated['nama_tim'];
        $tim->asal_sekolah = $validated['asal_sekolah'];
        $tim->guru_pembimbing = $validated['guru_pembimbing'];
        $tim->no_hp = $validated['hp_ketua'];
        $tim->save();

        $pendaftar = new Pendaftar;
        $pendaftar->user_id = auth()->id();
        $pendaftar->tim_id = $tim->id;
        $pendaftar->id_lomba = $validated['id_lomba'];
        $pendaftar->nama_ketua = $validated['nama_ketua'];
        $pendaftar->hp_ketua = $validated['hp_ketua'];
        $pendaftar->nis_nim_ketua = $validated['nis_nim_ketua'];
        $pendaftar->anggota_1 = $validated['anggota_1'] ?? null;
        $pendaftar->hp_1 = $validated['hp_1'] ?? null;
        $pendaftar->anggota_nis_1 = $validated['anggota_nis_1'] ?? null;
        $pendaftar->anggota_2 = $validated['anggota_2'] ?? null;
        $pendaftar->hp_2 = $validated['hp_2'] ?? null;
        $pendaftar->anggota_nis_2 = $validated['anggota_nis_2'] ?? null;
        $pendaftar->anggota_3 = $validated['anggota_3'] ?? null;
        $pendaftar->hp_3 = $validated['hp_3'] ?? null;
        $pendaftar->anggota_nis_3 = $validated['anggota_nis_3'] ?? null;
        $pendaftar->status_pembayaran = 'pending';
        $pendaftar->accepted_integrity = true;

        if ($request->hasFile('bukti_bayar')) {
            $f = $request->file('bukti_bayar');
            $f->move(public_path('uploads/pembayaran'), 'bayar_'.time().'.'.$f->getClientOriginalExtension());
            $pendaftar->bukti_bayar = 'bayar_'.time().'.'.$f->getClientOriginalExtension();
        }
        if ($request->hasFile('bukti_status_aktif')) {
            $f = $request->file('bukti_status_aktif');
            $f->move(public_path('uploads/status_aktif'), 'status_'.time().'.'.$f->getClientOriginalExtension());
            $pendaftar->bukti_status_aktif = 'status_'.time().'.'.$f->getClientOriginalExtension();
        }
        if ($request->hasFile('bukti_sosmed')) {
            $f = $request->file('bukti_sosmed');
            $f->move(public_path('uploads/sosmed'), 'sosmed_'.time().'.'.$f->getClientOriginalExtension());
            $pendaftar->bukti_sosmed = 'sosmed_'.time().'.'.$f->getClientOriginalExtension();
        }

        $pendaftar->save();

        // WA Group link
        $waMap = [1 => 'EPIM2026-WEB', 2 => 'EPIM2026-POSTER', 3 => 'EPIM2026-PACKAGING', 4 => 'EPIM2026-VIDEO'];
        $waLink = 'https://chat.whatsapp.com/' . ($waMap[$validated['id_lomba']] ?? 'EPIM2026');

        return redirect()->route('Lomba.peserta.index')
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
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Maaf, pengumpulan proposal saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
            'linkvideo' => 'nullable|url',
        ]);

        $query = Pendaftar::where('user_id', $user_id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->firstOrFail();

        // ► GATEKEEP: cek pembayaran verified
        if (auth()->user()->role !== 'admin' && $data->status_pembayaran !== 'verified') {
            return back()->with('error', 'Pembayaran belum diverifikasi. Anda belum bisa mengunggah proposal/karya.');
        }

        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $nama_file = time() . "_" . $file->getClientOriginalName();
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
        if ($pengaturan && $pengaturan->status_upload_postervideo_ditutup && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Maaf, pengumpulan berkas saat ini sudah ditutup oleh Admin.');
        }

        $request->validate([
            'orisinalitas' => 'required|mimes:pdf|max:2048',
        ]);

        $query = Pendaftar::where('user_id', $id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->firstOrFail();

        // ► GATEKEEP: cek pembayaran verified
        if (auth()->user()->role !== 'admin' && $data->status_pembayaran !== 'verified') {
            return back()->with('error', 'Pembayaran belum diverifikasi. Anda belum bisa mengunggah lembar orisinalitas.');
        }

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

            if (auth()->user()->role !== 'admin' && $pendaftar->user_id !== Auth::id()) {
                abort(403);
            }

            if ($pendaftar->proposal && file_exists(public_path('uploads/proposal/' . $pendaftar->proposal))) {
                unlink(public_path('uploads/proposal/' . $pendaftar->proposal));
            }

            $pendaftar->delete();

            return back()->with('success', 'Pendaftaran tim berhasil dibatalkan dan dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // ================================================================
    //  ADMIN: Verifikasi / Tolak Pembayaran
    // ================================================================

    public function verifikasiPembayaran($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->status_pembayaran = 'verified';
        $pendaftar->alasan_penolakan = null;
        $pendaftar->save();

        return back()->with('success', 'Pembayaran ' . ($pendaftar->tim->nama_tim ?? 'Tim #'.$id) . ' telah diverifikasi ✅');
    }

    public function tolakPembayaran(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'nullable|string|max:500',
        ]);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->status_pembayaran = 'ditolak';
        $pendaftar->alasan_penolakan = $request->alasan_penolakan ?? 'Bukti pembayaran tidak valid.';
        $pendaftar->save();

        return back()->with('success', 'Pembayaran ' . ($pendaftar->tim->nama_tim ?? 'Tim #'.$id) . ' ditolak.');
    }

    public function tiketFinalis()
    {
        $user = auth()->user();
        $pendaftar = Pendaftar::with('tim', 'kategori')
            ->where('user_id', $user->id)
            ->where('status_kelulusan', 'lolos')
            ->first();

        if (!$pendaftar) {
            return redirect()->route('Lomba.peserta.index')
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
        return back()->with('success', 'Status kelulusan ' . ($pendaftar->tim->nama_tim ?? 'Tim #'.$id) . ': ' . strtoupper($status));
    }

    public function updateStatusAktif(Request $request, $id)
    {
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
            $filename = 'status_'.time().'.'.$f->getClientOriginalExtension();
            $f->move(public_path('uploads/status_aktif'), $filename);
            
            $data->bukti_status_aktif = $filename;
            $data->save();
        }

        return back()->with('success', 'Bukti KTM/Status Aktif berhasil diperbarui!');
    }

    public function updateSosmed(Request $request, $id)
    {
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
            $filename = 'sosmed_'.time().'.'.$f->getClientOriginalExtension();
            $f->move(public_path('uploads/sosmed'), $filename);
            
            $data->bukti_sosmed = $filename;
            $data->save();
        }

        return back()->with('success', 'Bukti Follow Sosial Media berhasil diperbarui!');
    }
}
