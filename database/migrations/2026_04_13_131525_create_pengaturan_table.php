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
    Schema::create('pengaturan', function (Blueprint $table) {
        $table->id();
        $table->integer('status_pendaftaran_ditutup')->default(0); // 0: Buka, 1: Tutup
        $table->integer('status_upload_postervideo_ditutup')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pengaturan');
}
};
