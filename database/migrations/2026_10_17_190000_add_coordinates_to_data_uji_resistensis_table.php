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
            if (!Schema::hasColumn('data_uji_resistensis', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('address');
            }
            if (!Schema::hasColumn('data_uji_resistensis', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            if (Schema::hasColumn('data_uji_resistensis', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });
    }
};
