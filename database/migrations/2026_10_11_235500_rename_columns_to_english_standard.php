<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to rename columns to standard English.
     */
    public function up(): void
    {
        // 1. provinsis
        Schema::table('provinsis', function (Blueprint $table) {
            if (Schema::hasColumn('provinsis', 'nama_provinsi') && !Schema::hasColumn('provinsis', 'name')) {
                $table->renameColumn('nama_provinsi', 'name');
            }
        });

        // 2. kabupatens
        Schema::table('kabupatens', function (Blueprint $table) {
            if (Schema::hasColumn('kabupatens', 'nama_kabupaten') && !Schema::hasColumn('kabupatens', 'name')) {
                $table->renameColumn('nama_kabupaten', 'name');
            }
        });

        // 3. data_uji_resistensis
        Schema::table('data_uji_resistensis', function (Blueprint $table) {
            if (Schema::hasColumn('data_uji_resistensis', 'bulan') && !Schema::hasColumn('data_uji_resistensis', 'month')) {
                $table->renameColumn('bulan', 'month');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'tahun') && !Schema::hasColumn('data_uji_resistensis', 'year')) {
                $table->renameColumn('tahun', 'year');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'alamat') && !Schema::hasColumn('data_uji_resistensis', 'address')) {
                $table->renameColumn('alamat', 'address');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'jenis_nyamuk') && !Schema::hasColumn('data_uji_resistensis', 'mosquito_type')) {
                $table->renameColumn('jenis_nyamuk', 'mosquito_type');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'insektisida') && !Schema::hasColumn('data_uji_resistensis', 'insecticide')) {
                $table->renameColumn('insektisida', 'insecticide');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'metode') && !Schema::hasColumn('data_uji_resistensis', 'method')) {
                $table->renameColumn('metode', 'method');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'sampel_diperiksa') && !Schema::hasColumn('data_uji_resistensis', 'sample_count')) {
                $table->renameColumn('sampel_diperiksa', 'sample_count');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'mutasi') && !Schema::hasColumn('data_uji_resistensis', 'mutation')) {
                $table->renameColumn('mutasi', 'mutation');
            }
            if (Schema::hasColumn('data_uji_resistensis', 'publikasi') && !Schema::hasColumn('data_uji_resistensis', 'publication')) {
                $table->renameColumn('publikasi', 'publication');
            }
        });

        // 4. instansis
        if (Schema::hasTable('instansis')) {
            Schema::table('instansis', function (Blueprint $table) {
                if (Schema::hasColumn('instansis', 'nama_instansi') && !Schema::hasColumn('instansis', 'name')) {
                    $table->renameColumn('nama_instansi', 'name');
                }
                if (Schema::hasColumn('instansis', 'kode_unit') && !Schema::hasColumn('instansis', 'unit_code')) {
                    $table->renameColumn('kode_unit', 'unit_code');
                }
                if (Schema::hasColumn('instansis', 'kategori') && !Schema::hasColumn('instansis', 'category')) {
                    $table->renameColumn('kategori', 'category');
                }
                if (Schema::hasColumn('instansis', 'alamat') && !Schema::hasColumn('instansis', 'address')) {
                    $table->renameColumn('alamat', 'address');
                }
                if (Schema::hasColumn('instansis', 'telepon') && !Schema::hasColumn('instansis', 'phone')) {
                    $table->renameColumn('telepon', 'phone');
                }
                if (Schema::hasColumn('instansis', 'penanggung_jawab') && !Schema::hasColumn('instansis', 'person_in_charge')) {
                    $table->renameColumn('penanggung_jawab', 'person_in_charge');
                }
            });
        }

        // 5. kategori_ujis
        if (Schema::hasTable('kategori_ujis')) {
            Schema::table('kategori_ujis', function (Blueprint $table) {
                if (Schema::hasColumn('kategori_ujis', 'kategori') && !Schema::hasColumn('kategori_ujis', 'category')) {
                    $table->renameColumn('kategori', 'category');
                }
                if (Schema::hasColumn('kategori_ujis', 'nama') && !Schema::hasColumn('kategori_ujis', 'name')) {
                    $table->renameColumn('nama', 'name');
                }
                if (Schema::hasColumn('kategori_ujis', 'keterangan') && !Schema::hasColumn('kategori_ujis', 'description')) {
                    $table->renameColumn('keterangan', 'description');
                }
            });
        }

        // 6. users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'telepon') && !Schema::hasColumn('users', 'phone')) {
                    $table->renameColumn('telepon', 'phone');
                }
            });
        }

        // 7. delete_requests
        if (Schema::hasTable('delete_requests')) {
            Schema::table('delete_requests', function (Blueprint $table) {
                if (Schema::hasColumn('delete_requests', 'alasan') && !Schema::hasColumn('delete_requests', 'reason')) {
                    $table->renameColumn('alasan', 'reason');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert columns if needed
    }
};
