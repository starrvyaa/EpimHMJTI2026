<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_berkas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pendaftar_gambar';
    protected $primaryKey = 'id_user_gambar';
    protected $fillable = [
        'id_user',
        'id_tim',
        'kartu_pelajar',
        'foto_formal',
        'follow_ig_epim',
        'follow_ig_hmj',
        'follow_tiktok',
        'subscribe',
    ];
    
}
