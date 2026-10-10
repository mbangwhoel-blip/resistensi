<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instansi;
use App\Models\Provinsi;
use App\Models\Kabupaten;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        $jatim = Provinsi::where('nama_provinsi', 'like', '%JAWA TIMUR%')->first();
        $surabaya = Kabupaten::where('nama_kabupaten', 'like', '%SURABAYA%')->first();

        $dki = Provinsi::where('nama_provinsi', 'like', '%DKI JAKARTA%')->first();
        $jakpus = Kabupaten::where('nama_kabupaten', 'like', '%JAKARTA PUSAT%')->first();

        Instansi::firstOrCreate(
            ['nama_instansi' => 'Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL)'],
            [
                'kode_unit' => 'BBLKL-01',
                'kategori' => 'Balai / Laboratorium',
                'provinsi_id' => $jatim?->id,
                'kabupaten_id' => $surabaya?->id,
                'alamat' => 'Jl. Karang Menjangan No. 18, Surabaya',
                'telepon' => '(031) 5021450',
                'email' => 'info@bblkl.kemkes.go.id',
                'penanggung_jawab' => 'Kepala Balai BBLKL',
            ]
        );

        Instansi::firstOrCreate(
            ['nama_instansi' => 'Dinas Kesehatan Provinsi Jawa Timur'],
            [
                'kode_unit' => 'DINKES-JTM',
                'kategori' => 'Dinas Kesehatan',
                'provinsi_id' => $jatim?->id,
                'kabupaten_id' => $surabaya?->id,
                'alamat' => 'Jl. Ahmad Yani No. 118, Surabaya',
                'telepon' => '(031) 8280910',
                'email' => 'dinkes@jatimprov.go.id',
                'penanggung_jawab' => 'Bidang P2P',
            ]
        );

        Instansi::firstOrCreate(
            ['nama_instansi' => 'Kementerian Kesehatan RI'],
            [
                'kode_unit' => 'KEMKES-PST',
                'kategori' => 'Kementerian / Lembaga',
                'provinsi_id' => $dki?->id,
                'kabupaten_id' => $jakpus?->id,
                'alamat' => 'Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Jakarta',
                'telepon' => '(021) 5201590',
                'email' => 'kontak@kemkes.go.id',
                'penanggung_jawab' => 'Direktorat Kesling',
            ]
        );
    }
}
