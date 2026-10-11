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
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            $table->index(['tahun', 'provinsi_id'], 'idx_tahun_provinsi');
            $table->index('kabupaten_id', 'idx_kabupaten');
            $table->index('status', 'idx_status');
            $table->index('jenis_nyamuk', 'idx_jenis_nyamuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            $table->dropIndex('idx_tahun_provinsi');
            $table->dropIndex('idx_kabupaten');
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_jenis_nyamuk');
        });
    }
};
