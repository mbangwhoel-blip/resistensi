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
        if (!Schema::hasColumn('data_uji_resistensis', 'alamat')) {
            Schema::table('data_uji_resistensis', function (Blueprint $table) {
                $table->text('alamat')->nullable()->after('kabupaten_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
    }
};
