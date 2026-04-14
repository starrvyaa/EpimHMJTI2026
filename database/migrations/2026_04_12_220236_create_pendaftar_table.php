<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id('id_pendaftar');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('tim')->onDelete('cascade');
            $table->unsignedBigInteger('id_lomba');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};