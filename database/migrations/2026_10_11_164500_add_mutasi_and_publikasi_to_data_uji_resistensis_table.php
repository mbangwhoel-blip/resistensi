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
            if (!Schema::hasColumn('data_uji_resistensis', 'mutasi')) {
                $table->string('mutasi', 100)->nullable()->after('status');
            }
            if (!Schema::hasColumn('data_uji_resistensis', 'publikasi')) {
                $table->string('publikasi', 255)->nullable()->after('mutasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            if (Schema::hasColumn('data_uji_resistensis', 'publikasi')) {
                $table->dropColumn('publikasi');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'mutasi')) {
                $table->dropColumn('mutasi');
            }
        });
    }
};
