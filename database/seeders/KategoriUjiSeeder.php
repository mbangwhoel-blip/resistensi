<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriUji;

class KategoriUjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nyamuks = [
            'Ae. aegypti' => 'Vektor utama demam berdarah dengue (DBD)',
            'Culex sp' => 'Vektor filariasis dan ensefalitis jepang',
            'Anhopheles' => 'Vektor penular malaria',
            'Aedes sp' => 'Vektor arbovirus umum',
            'An. Farauti' => 'Vektor malaria wilayah pesisir/kepulauan',
            'An. Vagus' => 'Spesies vektor malaria sekunder',
            'An. tessellatus' => 'Spesies nyamuk anopheles',
            'An. sundaicus s.I' => 'Vektor malaria air payau/pesisir',
            'An. punctulatus s.I.' => 'Vektor malaria di wilayah timur',
            'An. peditaeniatus' => 'Spesies nyamuk vektor',
            'An. parensis' => 'Spesies nyamuk anopheles',
            'An. letifer' => 'Vektor malaria dataran rendah/hutan',
            'An. koliensis' => 'Vektor malaria regional',
            'An. kochi' => 'Spesies anopheles area perbukitan',
            'An. indefinitus' => 'Spesies nyamuk vektor',
            'An. hyrcanus s.I.' => 'Kelompok spesies hyrcanus',
            'An. farauti s.s' => 'Vektor malaria pesisir timur',
            'An. barbirostris' => 'Vektor malaria dan filariasis',
            'An. aconitus' => 'Vektor malaria sawah dataran rendah',
            'An. Albopictus' => 'Vektor sekunder DBD dan chikungunya',
        ];

        foreach ($nyamuks as $nama => $keterangan) {
            KategoriUji::firstOrCreate(
                ['kategori' => 'nyamuk', 'nama' => $nama],
                ['keterangan' => $keterangan, 'is_active' => true]
            );
        }

        $insektisidas = [
            'Cypermethrin' => 'Piretroid sintetik spektrum luas',
            'Lamdacyhalothrin' => 'Piretroid sintetik efektif residu tinggi',
            'Deltamethrin' => 'Piretroid sintetik untuk kelambu dan IRS',
            'Alphacypermethrin' => 'Isomer aktif sipermetrin',
            'Cyfluthrin' => 'Insektisida piretroid untuk pengendalian vektor',
            'Permethrin' => 'Piretroid umum untuk pencelupan kelambu',
            'Malathion' => 'Organofosfat untuk pengasapan (fogging)',
            'Deltamethrin 0,025%' => 'Formulasi standar kertas uji WHO',
            'Lambda-cyhalothrin 0,0025%' => 'Formulasi dosis diagnostik',
            'Temefos (Abate)' => 'Larvasida organofosfat untuk air bersih',
            'Bendiocarb' => 'Karbamat untuk penyemprotan dinding (IRS)',
            'Sipermethrin' => 'Formulasi varian sipermetrin',
        ];

        foreach ($insektisidas as $nama => $keterangan) {
            KategoriUji::firstOrCreate(
                ['kategori' => 'insektisida', 'nama' => $nama],
                ['keterangan' => $keterangan, 'is_active' => true]
            );
        }

        $metodes = [
            'Sequencing' => 'Deteksi mutasi genetik resistensi (kdr)',
            'WHO Tube Bioassay' => 'Uji kerentanan standar WHO menggunakan tabung uji',
            'WHO larval bioassay' => 'Bioassay larva standar WHO untuk larvasida',
            'WHO susceptibilitity test' => 'Protokol diagnostik kerentanan vektor WHO',
            'WHO test kit_adults' => 'Paket uji standar WHO untuk nyamuk dewasa',
            'CDC bottle_adults' => 'Bioassay botol CDC untuk nyamuk dewasa',
            'CDC bottle bioassay' => 'Protokol uji resistensi botol CDC diagnostik waktu',
            'WHO standards bioassay' => 'Bioassay acuan standar laboratorium WHO',
        ];

        foreach ($metodes as $nama => $keterangan) {
            KategoriUji::firstOrCreate(
                ['kategori' => 'metode', 'nama' => $nama],
                ['keterangan' => $keterangan, 'is_active' => true]
            );
        }
    }
}
