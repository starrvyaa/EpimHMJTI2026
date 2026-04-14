<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tim';

    protected $fillable = [
        'nama_tim',
        'guru_pembimbing',
        'asal_sekolah',
        'no_hp'
    ];
}