<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/Lomba.php
class Lomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bidang_lomba',
        'nama_tim',
        'nama_ketua',
        'proposal',
        'karya'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}