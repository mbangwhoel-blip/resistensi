<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provinsi;
use App\Models\Kabupaten;

class KoordinatKabupatenSeeder extends Seeder
{
    public function run(): void
    {
        // Koordinat referensi per provinsi (pusat provinsi)
        $provinsiCoords = [
            'ACEH' => ['lat' => 4.695135, 'lng' => 96.749399],
            'SUMATERA UTARA' => ['lat' => 2.115354, 'lng' => 99.545097],
            'SUMATERA BARAT' => ['lat' => -0.739940, 'lng' => 100.800005],
            'RIAU' => ['lat' => 0.293347, 'lng' => 101.706825],
            'JAMBI' => ['lat' => -1.610123, 'lng' => 103.613120],
            'SUMATERA SELATAN' => ['lat' => -3.319437, 'lng' => 104.914716],
            'BENGKULU' => ['lat' => -3.577847, 'lng' => 102.346388],
            'LAMPUNG' => ['lat' => -4.558585, 'lng' => 105.406808],
            'KEPULAUAN BANGKA BELITUNG' => ['lat' => -2.741051, 'lng' => 106.440587],
            'KEPULAUAN RIAU' => ['lat' => 3.945651, 'lng' => 108.142867],
            'DKI JAKARTA' => ['lat' => -6.208763, 'lng' => 106.845599],
            'JAWA BARAT' => ['lat' => -6.917464, 'lng' => 107.619123],
            'JAWA TENGAH' => ['lat' => -7.150975, 'lng' => 110.140259],
            'DI YOGYAKARTA' => ['lat' => -7.795580, 'lng' => 110.369490],
            'JAWA TIMUR' => ['lat' => -7.536064, 'lng' => 112.238402],
            'BANTEN' => ['lat' => -6.405817, 'lng' => 106.064018],
            'BALI' => ['lat' => -8.409518, 'lng' => 115.188916],
            'NUSA TENGGARA BARAT' => ['lat' => -8.652933, 'lng' => 117.361648],
            'NUSA TENGGARA TIMUR' => ['lat' => -8.657382, 'lng' => 121.079371],
            'KALIMANTAN BARAT' => ['lat' => -0.278781, 'lng' => 111.475285],
            'KALIMANTAN TENGAH' => ['lat' => -1.681488, 'lng' => 113.382355],
            'KALIMANTAN SELATAN' => ['lat' => -3.092641, 'lng' => 115.283759],
            'KALIMANTAN TIMUR' => ['lat' => 0.538659, 'lng' => 116.419389],
            'KALIMANTAN UTARA' => ['lat' => 3.073093, 'lng' => 116.041390],
            'SULAWESI UTARA' => ['lat' => 0.624693, 'lng' => 123.975002],
            'SULAWESI TENGAH' => ['lat' => -1.430025, 'lng' => 121.445618],
            'SULAWESI SELATAN' => ['lat' => -3.668799, 'lng' => 119.974053],
            'SULAWESI TENGGARA' => ['lat' => -4.144910, 'lng' => 122.174605],
            'GORONTALO' => ['lat' => 0.699937, 'lng' => 122.446724],
            'SULAWESI BARAT' => ['lat' => -2.844137, 'lng' => 119.232078],
            'MALUKU' => ['lat' => -3.238462, 'lng' => 130.145273],
            'MALUKU UTARA' => ['lat' => 1.570999, 'lng' => 127.808769],
            'PAPUA BARAT' => ['lat' => -1.336115, 'lng' => 133.174716],
            'PAPUA' => ['lat' => -4.269928, 'lng' => 138.080353],
        ];

        // Koordinat spesifik untuk beberapa kabupaten penting / yang sudah digunakan
        $spesifikKabupaten = [
            // Aceh
            'ACEH BARAT' => ['lat' => 4.144900, 'lng' => 96.152700],
            'ACEH SELATAN' => ['lat' => 3.279800, 'lng' => 97.288500],
            'ACEH TENGGARA' => ['lat' => 3.376800, 'lng' => 97.809100],
            'ACEH TIMUR' => ['lat' => 4.793200, 'lng' => 97.761700],
            'ACEH TENGAH' => ['lat' => 4.544500, 'lng' => 96.852200],
            'ACEH BESAR' => ['lat' => 5.378600, 'lng' => 95.530300],
            'PIDIE' => ['lat' => 5.234600, 'lng' => 95.961000],
            'ACEH UTARA' => ['lat' => 5.011700, 'lng' => 97.142000],
            'BANDA ACEH' => ['lat' => 5.548300, 'lng' => 95.323800],
            'SABANG' => ['lat' => 5.892000, 'lng' => 95.322000],
            'LHOKSEUMAWE' => ['lat' => 5.180100, 'lng' => 97.150700],
            'LANGSA' => ['lat' => 4.471600, 'lng' => 97.967800],

            // Bali
            'BANGLI' => ['lat' => -8.454300, 'lng' => 115.354900],
            'BADUNG' => ['lat' => -8.581900, 'lng' => 115.177100],
            'BULELENG' => ['lat' => -8.241500, 'lng' => 114.970100],
            'GIANYAR' => ['lat' => -8.543400, 'lng' => 115.326200],
            'JEMBRANA' => ['lat' => -8.307900, 'lng' => 114.665700],
            'KARANGASEM' => ['lat' => -8.448500, 'lng' => 115.612800],
            'KLUNGKUNG' => ['lat' => -8.535800, 'lng' => 115.403800],
            'TABANAN' => ['lat' => -8.538500, 'lng' => 115.124500],
            'DENPASAR' => ['lat' => -8.670500, 'lng' => 115.212600],

            // Gorontalo
            'BOALEMO' => ['lat' => 0.655500, 'lng' => 122.337400],
            'GORONTALO' => ['lat' => 0.543500, 'lng' => 123.056800],
            'POHUWATO' => ['lat' => 0.518600, 'lng' => 121.751600],
            'BONE BOLANGO' => ['lat' => 0.531200, 'lng' => 123.238400],
            'GORONTALO UTARA' => ['lat' => 0.771200, 'lng' => 122.868700],
            'KOTA GORONTALO' => ['lat' => 0.543500, 'lng' => 123.056800],

            // Jawa Barat
            'BOGOR' => ['lat' => -6.597100, 'lng' => 106.806000],
            'SUKABUMI' => ['lat' => -6.927700, 'lng' => 106.930000],
            'CIANJUR' => ['lat' => -6.817300, 'lng' => 107.142700],
            'BANDUNG' => ['lat' => -6.917500, 'lng' => 107.619100],
            'GARUT' => ['lat' => -7.227900, 'lng' => 107.908700],
            'TASIKMALAYA' => ['lat' => -7.327400, 'lng' => 108.220700],
            'CIAMIS' => ['lat' => -7.326200, 'lng' => 108.353300],
            'KUNINGAN' => ['lat' => -6.976500, 'lng' => 108.483100],
            'CIREBON' => ['lat' => -6.732000, 'lng' => 108.552300],
            'MAJALENGKA' => ['lat' => -6.836100, 'lng' => 108.227400],
            'SUMEDANG' => ['lat' => -6.858700, 'lng' => 107.926600],
            'INDRAMAYU' => ['lat' => -6.326400, 'lng' => 108.320000],
            'SUBANG' => ['lat' => -6.571600, 'lng' => 107.758700],
            'PURWAKARTA' => ['lat' => -6.556900, 'lng' => 107.443300],
            'KARAWANG' => ['lat' => -6.304200, 'lng' => 107.307500],
            'BEKASI' => ['lat' => -6.238300, 'lng' => 106.975600],
            'BANDUNG BARAT' => ['lat' => -6.843900, 'lng' => 107.502900],
            'PANGANDARAN' => ['lat' => -7.684200, 'lng' => 108.650800],

            // Jawa Timur
            'SURABAYA' => ['lat' => -7.257500, 'lng' => 112.752100],
            'MALANG' => ['lat' => -7.966600, 'lng' => 112.632600],
            'SIDOARJO' => ['lat' => -7.447800, 'lng' => 112.718300],
            'GRESIK' => ['lat' => -7.156600, 'lng' => 112.655500],
            'BANYUWANGI' => ['lat' => -8.219200, 'lng' => 114.369200],
            'JEMBER' => ['lat' => -8.172400, 'lng' => 113.699500],
            'KEDIRI' => ['lat' => -7.848000, 'lng' => 112.017800],
            'MADIUN' => ['lat' => -7.629800, 'lng' => 111.523900],
            'PASURUAN' => ['lat' => -7.645300, 'lng' => 112.907500],
            'PROBOLINGGO' => ['lat' => -7.754300, 'lng' => 113.215900],
            'BLITAR' => ['lat' => -8.095400, 'lng' => 112.160900],
            'MOJOKERTO' => ['lat' => -7.472600, 'lng' => 112.438100],

            // Jawa Tengah
            'SEMARANG' => ['lat' => -6.966700, 'lng' => 110.416700],
            'SURAKARTA' => ['lat' => -7.575500, 'lng' => 110.824300],
            'BANYUMAS' => ['lat' => -7.514400, 'lng' => 109.294300],
            'CILACAP' => ['lat' => -7.703200, 'lng' => 109.015900],
            'MAGELANG' => ['lat' => -7.479700, 'lng' => 110.217700],
            'PEKALONGAN' => ['lat' => -6.888600, 'lng' => 109.675300],
            'TEGAL' => ['lat' => -6.869400, 'lng' => 109.140200],
            'KUDUS' => ['lat' => -6.804800, 'lng' => 110.840500],
            'PATI' => ['lat' => -6.754700, 'lng' => 111.038200],
            'JEPARA' => ['lat' => -6.593600, 'lng' => 110.677800],

            // DI Yogyakarta
            'KOTA YOGYAKARTA' => ['lat' => -7.795600, 'lng' => 110.369500],
            'SLEMAN' => ['lat' => -7.716700, 'lng' => 110.355600],
            'BANTUL' => ['lat' => -7.889700, 'lng' => 110.329700],
            'KULON PROGO' => ['lat' => -7.828600, 'lng' => 110.158300],
            'GUNUNGKIDUL' => ['lat' => -7.962800, 'lng' => 110.604200],

            // DKI Jakarta
            'JAKARTA PUSAT' => ['lat' => -6.180500, 'lng' => 106.828400],
            'JAKARTA UTARA' => ['lat' => -6.121400, 'lng' => 106.774100],
            'JAKARTA BARAT' => ['lat' => -6.168300, 'lng' => 106.758900],
            'JAKARTA SELATAN' => ['lat' => -6.261500, 'lng' => 106.810600],
            'JAKARTA TIMUR' => ['lat' => -6.225000, 'lng' => 106.900400],
            'KEPULAUAN SERIBU' => ['lat' => -5.612200, 'lng' => 106.562200],
        ];

        // Ambil semua kabupaten dan update koordinatnya
        $kabupatens = Kabupaten::with('provinsi')->get();

        foreach ($kabupatens as $index => $kab) {
            $namaKabClean = strtoupper(trim(str_replace(['KABUPATEN ', 'KOTA '], '', $kab->nama_kabupaten)));
            $namaProvClean = strtoupper(trim($kab->provinsi->nama_provinsi ?? ''));

            if (isset($spesifikKabupaten[$namaKabClean])) {
                $lat = $spesifikKabupaten[$namaKabClean]['lat'];
                $lng = $spesifikKabupaten[$namaKabClean]['lng'];
            } elseif (isset($provinsiCoords[$namaProvClean])) {
                // Generate sebaran halus berbasis urutan kabupaten di dalam provinsi agar tidak bertumpuk
                $center = $provinsiCoords[$namaProvClean];
                $angle = ($index * 137.5) * (M_PI / 180); // golden angle distribution
                $radius = 0.15 + (fmod($index, 5) * 0.12); // radius antara ~15km - 70km

                $lat = $center['lat'] + ($radius * sin($angle));
                $lng = $center['lng'] + ($radius * cos($angle) * 1.05);
            } else {
                $lat = -2.5 + (sin($index) * 4.0);
                $lng = 118.0 + (cos($index) * 10.0);
            }

            $kab->update([
                'latitude' => round($lat, 6),
                'longitude' => round($lng, 6),
            ]);
        }
    }
}
