<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar'; // Sesuaikan nama tabel di gambar
    protected $primaryKey = 'id';    // Di gambar kolomnya bernama 'id'

    protected $fillable = [
        'user_id', 'tim_id', 'id_lomba', 'proposal', 'orisinalitas'
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
