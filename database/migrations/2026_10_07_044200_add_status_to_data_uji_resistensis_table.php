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
        if (!Schema::hasColumn('data_uji_resistensis', 'status')) {
            Schema::table('data_uji_resistensis', function (Blueprint $table) {
                $table->string('status', 50)->nullable()->after('sampel_diperiksa');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
