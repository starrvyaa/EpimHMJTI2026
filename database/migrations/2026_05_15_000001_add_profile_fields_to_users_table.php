<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'nim')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nim')->nullable()->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'institusi')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('institusi')->nullable()->after('nim');
            });
        }

        if (! Schema::hasColumn('users', 'nomor_telp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nomor_telp')->nullable()->after('institusi');
            });
        }

        if (! Schema::hasColumn('users', 'alamat')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('alamat')->nullable()->after('nomor_telp');
            });
        }
    }

    public function down(): void
    {
        $columns = array_filter(
            ['nim', 'institusi', 'nomor_telp', 'alamat'],
            fn ($column) => Schema::hasColumn('users', $column)
        );

        if (empty($columns)) {
            return;
        }

        Schema::table('users', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
