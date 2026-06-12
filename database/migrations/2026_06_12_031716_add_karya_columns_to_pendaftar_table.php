<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->string('judul_karya', 255)->nullable()->after('alasan_penolakan');
            $table->string('subtema', 100)->nullable()->after('judul_karya');
            $table->string('link_video_karya', 500)->nullable()->after('subtema');
            $table->string('gambar_karya', 255)->nullable()->after('link_video_karya');
            $table->string('proposal_nama_file', 255)->nullable()->after('gambar_karya');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['judul_karya', 'subtema', 'link_video_karya', 'gambar_karya', 'proposal_nama_file']);
        });
    }
};
