<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->string('nis_nim_ketua', 50)->nullable()->after('hp_ketua');
            $table->string('anggota_nis_1', 50)->nullable()->after('anggota_1');
            $table->string('anggota_nis_2', 50)->nullable()->after('anggota_2');
            $table->string('bukti_status_aktif', 255)->nullable()->after('bukti_bayar');
            $table->string('bukti_sosmed', 255)->nullable()->after('bukti_status_aktif');
            $table->boolean('accepted_integrity')->default(false)->after('proposal_nama_file');
            $table->enum('status_kelulusan', ['pending', 'lolos', 'tidak_lolos'])->default('pending')->after('accepted_integrity');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn([
                'nis_nim_ketua', 'anggota_nis_1', 'anggota_nis_2',
                'bukti_status_aktif', 'bukti_sosmed',
                'accepted_integrity', 'status_kelulusan',
            ]);
        });
    }
};
