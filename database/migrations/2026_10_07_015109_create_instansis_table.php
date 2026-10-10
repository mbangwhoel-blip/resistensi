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
        Schema::create('instansis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('kode_unit')->nullable();
            $table->string('kategori')->default('Balai / Laboratorium');
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsis')->nullOnDelete();
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens')->nullOnDelete();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansis');
    }
};
