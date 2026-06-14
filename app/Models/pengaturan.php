<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    // Tambahkan ini jika nama tabel di DB adalah 'pengaturan' (tanpa 's')
    protected $table = 'pengaturan';

    protected $fillable = [
        'status_pendaftaran_ditutup',
        'status_upload_postervideo_ditutup',
        'status_pengumpulan_karya',
    ];
}