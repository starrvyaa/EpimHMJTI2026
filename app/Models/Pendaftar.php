<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar'; // Sesuaikan nama tabel di gambar
    protected $primaryKey = 'id';    // Di gambar kolomnya bernama 'id'

    protected $fillable = [
        'user_id', 'tim_id', 'id_lomba', 'proposal', 'orisinalitas',
        'bukti_bayar', 'status_pembayaran', 'alasan_penolakan',
        'nama_ketua', 'hp_ketua', 'anggota_1', 'hp_1', 'anggota_2', 'hp_2',
        'anggota_3', 'hp_3', 'anggota_nis_3',
        'judul_karya', 'subtema', 'link_video_karya', 'gambar_karya', 'proposal_nama_file',
        'nis_nim_ketua', 'anggota_nis_1', 'anggota_nis_2',
        'bukti_status_aktif', 'bukti_sosmed',
        'accepted_integrity', 'status_kelulusan',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id');
    }

    public function kategori()
    {
        // id_lomba di tabel pendaftar merujuk ke id di tabel kategori_lomba
        return $this->belongsTo(KategoriLomba::class, 'id_lomba');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
