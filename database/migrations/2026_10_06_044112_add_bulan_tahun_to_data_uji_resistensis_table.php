<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            if (!Schema::hasColumn('data_uji_resistensis', 'bulan')) {
                $table->string('bulan')->nullable()->after('no');
            }
            if (!Schema::hasColumn('data_uji_resistensis', 'tahun')) {
                $table->integer('tahun')->nullable()->after('bulan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            if (Schema::hasColumn('data_uji_resistensis', 'bulan')) {
                $table->dropColumn('bulan');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'tahun')) {
                $table->dropColumn('tahun');
            }
        });
    }
};