<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftar', 'anggota_3')) {
                $table->string('anggota_3', 150)->nullable()->after('anggota_2');
            }
            if (!Schema::hasColumn('pendaftar', 'hp_3')) {
                $table->string('hp_3', 20)->nullable()->after('anggota_3');
            }
            if (!Schema::hasColumn('pendaftar', 'anggota_nis_3')) {
                $table->string('anggota_nis_3', 50)->nullable()->after('hp_3');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['anggota_3', 'hp_3', 'anggota_nis_3']);
        });
    }
};
