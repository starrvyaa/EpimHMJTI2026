<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('admin_name');
            $table->string('action');           // e.g. 'loloskan', 'tolak', 'verifikasi_bayar'
            $table->string('target_type');      // e.g. 'pendaftar'
            $table->unsignedBigInteger('target_id');
            $table->string('target_name')->nullable(); // e.g. nama tim
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
