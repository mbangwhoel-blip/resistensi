<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DataUjiResistensiController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\KategoriUjiController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\BackupRestoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\RekomendasiKebijakanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// =========================================================================
// RUTE AUTENTIKASI (PUBLIK / GUEST)
// =========================================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman utama: jika sudah login langsung ke dashboard, jika belum login wajib ke login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// =========================================================================
// RUTE SINKRONISASI DATABASE 1-KLIK (AMAN & OTOMATIS)
// =========================================================================
Route::get('/sync-db', function () {
    $actions = [];

    // 1. provinsis
    if (\Illuminate\Support\Facades\Schema::hasColumn('provinsis', 'nama_provinsi')) {
        \Illuminate\Support\Facades\Schema::table('provinsis', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn('nama_provinsi', 'name'));
        $actions[] = 'Tabel provinsis: nama_provinsi -> name';
    }

    // 2. kabupatens
    if (\Illuminate\Support\Facades\Schema::hasColumn('kabupatens', 'nama_kabupaten')) {
        \Illuminate\Support\Facades\Schema::table('kabupatens', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn('nama_kabupaten', 'name'));
        $actions[] = 'Tabel kabupatens: nama_kabupaten -> name';
    }

    // 3. data_uji_resistensis
    $duCols = [
        'bulan' => 'month',
        'tahun' => 'year',
        'alamat' => 'address',
        'jenis_nyamuk' => 'mosquito_type',
        'insektisida' => 'insecticide',
        'metode' => 'method',
        'sampel_diperiksa' => 'sample_count',
        'mutasi' => 'mutation',
        'publikasi' => 'publication',
    ];
    foreach ($duCols as $old => $new) {
        if (\Illuminate\Support\Facades\Schema::hasColumn('data_uji_resistensis', $old)) {
            \Illuminate\Support\Facades\Schema::table('data_uji_resistensis', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn($old, $new));
            $actions[] = "Tabel data_uji_resistensis: $old -> $new";
        }
    }

    // 4. instansis
    $instCols = [
        'nama_instansi' => 'name',
        'kode_unit' => 'unit_code',
        'kategori' => 'category',
        'alamat' => 'address',
        'telepon' => 'phone',
        'penanggung_jawab' => 'person_in_charge',
    ];
    foreach ($instCols as $old => $new) {
        if (\Illuminate\Support\Facades\Schema::hasColumn('instansis', $old)) {
            \Illuminate\Support\Facades\Schema::table('instansis', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn($old, $new));
            $actions[] = "Tabel instansis: $old -> $new";
        }
    }

    // 5. kategori_ujis
    $katCols = [
        'kategori' => 'category',
        'nama' => 'name',
        'keterangan' => 'description',
    ];
    foreach ($katCols as $old => $new) {
        if (\Illuminate\Support\Facades\Schema::hasColumn('kategori_ujis', $old)) {
            \Illuminate\Support\Facades\Schema::table('kategori_ujis', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn($old, $new));
            $actions[] = "Tabel kategori_ujis: $old -> $new";
        }
    }

    // 6. users
    if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'telepon')) {
        \Illuminate\Support\Facades\Schema::table('users', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn('telepon', 'phone'));
        $actions[] = 'Tabel users: telepon -> phone';
    }
    try {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY role VARCHAR(50) NOT NULL DEFAULT 'petugas'");
        $actions[] = 'Tabel users: kolom role diperluas ke VARCHAR(50)';
    } catch (\Throwable $e) {}

    // 7. delete_requests
    if (\Illuminate\Support\Facades\Schema::hasTable('delete_requests') && \Illuminate\Support\Facades\Schema::hasColumn('delete_requests', 'alasan')) {
        \Illuminate\Support\Facades\Schema::table('delete_requests', fn(\Illuminate\Database\Schema\Blueprint $t) => $t->renameColumn('alasan', 'reason'));
        $actions[] = 'Tabel delete_requests: alasan -> reason';
    }

    // 8. Sinkronisasi nama Kota Administratif (Depok, Jaktim, Surabaya, dsb.)
    $kotaRenames = [
        417 => 'Kota Salatiga',
        418 => 'Kota Kendari',
        419 => 'Kota Makassar',
        421 => 'Kota Tanjung Pinang',
        422 => 'Kota Pekanbaru',
        423 => 'Kota Yogyakarta',
        424 => 'Kota Palu',
        425 => 'Kota Medan',
        426 => 'Kota Banjarmasin',
        427 => 'Kota Surabaya',
        428 => 'Kota Jakarta Timur',
        429 => 'Kota Manado',
        431 => 'Kota Ambon',
        432 => 'Kota Depok',
    ];
    $kotaUpdates = 0;
    foreach ($kotaRenames as $kId => $kName) {
        $kObj = \App\Models\Kabupaten::find($kId);
        if ($kObj && $kObj->name !== $kName) {
            $kObj->name = $kName;
            $kObj->save();
            $kotaUpdates++;
        }
    }
    if ($kotaUpdates > 0) {
        $actions[] = "Tabel kabupatens: {$kotaUpdates} nama kota administratif disinkronkan (awalan 'Kota')";
    }

    // 9. Pastikan seluruh Kota Administrasi DKI Jakarta lengkap
    $dkiProv = \App\Models\Provinsi::where('name', 'like', '%jakarta%')->first();
    if ($dkiProv) {
        $dkiCities = [
            'Kota Jakarta Pusat' => ['lat' => -6.1805, 'lng' => 106.8284],
            'Kota Jakarta Utara' => ['lat' => -6.1384, 'lng' => 106.8640],
            'Kota Jakarta Barat' => ['lat' => -6.1683, 'lng' => 106.7588],
            'Kota Jakarta Selatan' => ['lat' => -6.2615, 'lng' => 106.8106],
        ];
        $dkiCreated = 0;
        foreach ($dkiCities as $cName => $coords) {
            $exists = \App\Models\Kabupaten::where('provinsi_id', $dkiProv->id)->where('name', $cName)->first();
            if (!$exists) {
                \App\Models\Kabupaten::create([
                    'provinsi_id' => $dkiProv->id,
                    'name' => $cName,
                    'latitude' => (string)$coords['lat'],
                    'longitude' => (string)$coords['lng'],
                ]);
                $dkiCreated++;
            }
        }
        if ($dkiCreated > 0) {
            $actions[] = "Tabel kabupatens: {$dkiCreated} kota administrasi DKI Jakarta ditambahkan";
        }
    }

    // 10. Penyelarasan Wilayah Pemekaran Papua (DOB) di Master Tabel Kabupatens
    $papuaDOBUpdates = 0;
    $mimika = \App\Models\Kabupaten::find(385);
    if ($mimika && $mimika->provinsi_id != 35) {
        $mimika->provinsi_id = 35;
        $mimika->save();
        $papuaDOBUpdates++;
    }
    $boven = \App\Models\Kabupaten::find(392);
    if ($boven && $boven->provinsi_id != 36) {
        $boven->provinsi_id = 36;
        $boven->save();
        $papuaDOBUpdates++;
    }
    if ($papuaDOBUpdates > 0) {
        $actions[] = "Tabel kabupatens: {$papuaDOBUpdates} kabupaten pemekaran Papua diselaraskan ke provinsinya";
    }

    // 11. Penyelarasan Otomatis data_uji_resistensis.provinsi_id mengikuti master kabupatens (termasuk Kab Madiun -> Jatim)
    $mismatches = \Illuminate\Support\Facades\DB::table('data_uji_resistensis')
        ->join('kabupatens', 'data_uji_resistensis.kabupaten_id', '=', 'kabupatens.id')
        ->whereColumn('data_uji_resistensis.provinsi_id', '!=', 'kabupatens.provinsi_id')
        ->select('data_uji_resistensis.id', 'kabupatens.provinsi_id as master_prov_id')
        ->get();

    $syncCount = 0;
    foreach ($mismatches as $mis) {
        \App\Models\DataUjiResistensi::where('id', $mis->id)->update(['provinsi_id' => $mis->master_prov_id]);
        $syncCount++;
    }
    if ($syncCount > 0) {
        $actions[] = "Tabel data_uji_resistensis: {$syncCount} data uji diselaraskan provinsi_id nya agar 100% inline dengan kabupaten";
    }

    $msg = count($actions) > 0 
        ? "Berhasil menyinkronkan " . count($actions) . " perubahan:<br>- " . implode("<br>- ", $actions)
        : "Semua struktur kolom dan data wilayah sudah 100% sinkron dan termutakhir!";

    return "<div style='font-family:sans-serif;padding:30px;max-width:700px;margin:50px auto;border:1px solid #10b981;border-radius:12px;background:#f0fdf4;color:#065f46;'>
        <h2 style='margin-top:0;'>✅ Sinkronisasi Database Selesai</h2>
        <p>{$msg}</p>
        <p><a href='" . url('/') . "' style='display:inline-block;padding:10px 20px;background:#10b981;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;'>Buka Aplikasi</a></p>
    </div>";
});

// =========================================================================
// RUTE SISTEM INTERNAL (WAJIB LOGIN / AUTH MIDDLEWARE)
// =========================================================================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [
        DataUjiResistensiController::class,
        'dashboard'
    ])->name('dashboard');

    Route::get('/input', [
        DataUjiResistensiController::class,
        'index'
    ])->name('input');

    // Rute Input / Edit / Hapus Data Uji Resistensi (Khusus Non-Viewer)
    Route::middleware('not_viewer')->group(function () {
        Route::post('/input', [
            DataUjiResistensiController::class,
            'store'
        ])->name('input.store');

        Route::put('/input/{id}', [
            DataUjiResistensiController::class,
            'update'
        ])->name('input.update');

        Route::delete('/input/{id}', [
            DataUjiResistensiController::class,
            'destroy'
        ])->name('input.destroy');
    });

    Route::get('/kabupaten/{provinsi_id}', [
        DataUjiResistensiController::class,
        'getKabupaten'
    ])->name('kabupaten');

    // Laporan Hasil Uji Resistensi (View, Preview & PDF Export)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/preview', [LaporanController::class, 'preview'])->name('preview');
        Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
    });
    Route::redirect('/laporan-redirect', '/laporan')->name('laporan');

    // Analisis Data Hasil Uji Resistensi (Grafik & Statistik Interaktif)
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');

    // Rekomendasi Kebijakan Otomatis (Policy Brief & Insecticide Rotation Decision Support)
    Route::prefix('rekomendasi-kebijakan')->name('rekomendasi.')->group(function () {
        Route::get('/', [RekomendasiKebijakanController::class, 'index'])->name('index');
        Route::get('/preview', [RekomendasiKebijakanController::class, 'preview'])->name('preview');
    });

    // Export Data (Khusus Pengguna Non-Viewer)
    Route::middleware('not_viewer')->prefix('export')->name('export.')->group(function () {
        Route::get('/', [ExportImportController::class, 'exportIndex'])->name('index');
        Route::get('/download', [ExportImportController::class, 'exportDownload'])->name('download');
    });

    // Import Data (Khusus Petugas / Pengguna Non-Viewer)
    Route::middleware('not_viewer')->prefix('import')->name('import.')->group(function () {
        Route::get('/', [ExportImportController::class, 'importIndex'])->name('index');
        Route::get('/template', [ExportImportController::class, 'downloadTemplate'])->name('template');
        Route::post('/process', [ExportImportController::class, 'importProcess'])->name('process');
    });

    // Backup & Restore Database (Khusus Pengguna Non-Viewer)
    Route::middleware('not_viewer')->prefix('backup-restore')->name('backup.')->group(function () {
        Route::get('/', [BackupRestoreController::class, 'index'])->name('index');
        Route::post('/create', [BackupRestoreController::class, 'createBackup'])->name('create');
        Route::post('/auto-now', [BackupRestoreController::class, 'runAutoBackupNow'])->name('auto_now');
        Route::get('/download/{filename}', [BackupRestoreController::class, 'downloadBackup'])->name('download');
        Route::delete('/delete/{filename}', [BackupRestoreController::class, 'deleteBackup'])->name('delete');
        Route::post('/restore', [BackupRestoreController::class, 'restoreBackup'])->name('restore');
    });

    // =========================================================================
    // MENU MASTER DATA & KELOLA USER (KHUSUS ROLE ADMINISTRATOR)
    // =========================================================================
    Route::middleware('admin')->group(function () {

        // Master Data Wilayah
        Route::prefix('wilayah')->name('wilayah.')->group(function () {
            Route::get('/', [WilayahController::class, 'index'])->name('index');
            Route::post('/provinsi', [WilayahController::class, 'storeProvinsi'])->name('provinsi.store');
            Route::put('/provinsi/{id}', [WilayahController::class, 'updateProvinsi'])->name('provinsi.update');
            Route::delete('/provinsi/{id}', [WilayahController::class, 'destroyProvinsi'])->name('provinsi.destroy');

            Route::post('/kabupaten', [WilayahController::class, 'storeKabupaten'])->name('kabupaten.store');
            Route::put('/kabupaten/{id}', [WilayahController::class, 'updateKabupaten'])->name('kabupaten.update');
            Route::delete('/kabupaten/{id}', [WilayahController::class, 'destroyKabupaten'])->name('kabupaten.destroy');
        });

        // Master Data Unit / Instansi
        Route::prefix('instansi')->name('instansi.')->group(function () {
            Route::get('/', [InstansiController::class, 'index'])->name('index');
            Route::post('/', [InstansiController::class, 'store'])->name('store');
            Route::put('/{id}', [InstansiController::class, 'update'])->name('update');
            Route::delete('/{id}', [InstansiController::class, 'destroy'])->name('destroy');
        });

        // Master Data Kategori / Parameter Uji (Jenis Nyamuk, Insektisida, Metode Pengendalian)
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [KategoriUjiController::class, 'index'])->name('index');
            Route::post('/', [KategoriUjiController::class, 'store'])->name('store');
            Route::post('/sync', [KategoriUjiController::class, 'sync'])->name('sync');
            Route::put('/{id}', [KategoriUjiController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriUjiController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Pengguna (Kelola User Admin)
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

    });

});

