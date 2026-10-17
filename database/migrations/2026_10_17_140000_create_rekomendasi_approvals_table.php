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
        if (!Schema::hasTable('rekomendasi_approvals')) {
            Schema::create('rekomendasi_approvals', function (Blueprint $table) {
                $table->id();
                $table->string('doc_hash', 64)->index();
                $table->string('filter_scope', 64)->index();
                $table->string('template', 50)->default('all');
                $table->string('tahun', 20)->default('Semua');
                $table->string('jenis_nyamuk', 100)->default('Semua');
                $table->string('provinsi_id', 50)->default('Semua');
                $table->string('kabupaten_id', 50)->default('Semua');
                $table->string('nama_wilayah', 255)->nullable();
                $table->string('status', 20)->default('draft'); // 'draft', 'approved', 'rejected'
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('approver_name', 150)->nullable();
                $table->string('approver_nip', 50)->nullable();
                $table->string('approver_jabatan', 255)->nullable();
                $table->string('nomor_surat', 100)->nullable();
                $table->text('notes')->nullable();
                $table->string('verification_token', 64)->nullable()->index();
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();

                $table->index(['filter_scope', 'status']);
                $table->index(['doc_hash', 'status']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_approvals');
    }
};
