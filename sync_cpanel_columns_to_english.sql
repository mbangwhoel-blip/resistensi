-- ========================================================================
-- SINKRONISASI DATABASE KE BAHASA INGGRIS (VERSI AMAN / IDEMPOTENT)
-- Database: skmm5736_resistensi
--
-- JIKA MUNCUL "Unknown column ...", itu artinya kolom tersebut SUDAH
-- BERHASIL DIUBAH sebelumnya! Anda bisa langsung lewati ke tabel berikutnya.
-- ========================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------
-- TABEL 1: PROVINSI (Lewati jika kolom sudah bernama 'name')
-- ------------------------------------------------------------------------
-- ALTER TABLE `provinsis` CHANGE `nama_provinsi` `name` VARCHAR(255) NOT NULL;


-- ------------------------------------------------------------------------
-- TABEL 2: KABUPATEN
-- ------------------------------------------------------------------------
ALTER TABLE `kabupatens` 
  CHANGE `nama_kabupaten` `name` VARCHAR(255) NOT NULL;


-- ------------------------------------------------------------------------
-- TABEL 3: DATA UJI RESISTENSI (Ubah nama kolom ke Bahasa Inggris)
-- ------------------------------------------------------------------------
ALTER TABLE `data_uji_resistensis` 
  CHANGE `bulan` `month` VARCHAR(255) NULL DEFAULT NULL,
  CHANGE `tahun` `year` INT NULL DEFAULT NULL,
  CHANGE `alamat` `address` TEXT NULL DEFAULT NULL,
  CHANGE `jenis_nyamuk` `mosquito_type` VARCHAR(255) NOT NULL,
  CHANGE `insektisida` `insecticide` VARCHAR(255) NOT NULL,
  CHANGE `metode` `method` VARCHAR(255) NOT NULL,
  CHANGE `sampel_diperiksa` `sample_count` INT NOT NULL,
  CHANGE `mutasi` `mutation` VARCHAR(100) NULL DEFAULT NULL,
  CHANGE `publikasi` `publication` VARCHAR(255) NULL DEFAULT NULL;


-- ------------------------------------------------------------------------
-- TABEL 4: INSTANSI
-- ------------------------------------------------------------------------
ALTER TABLE `instansis` 
  CHANGE `nama_instansi` `name` VARCHAR(255) NOT NULL,
  CHANGE `kode_unit` `unit_code` VARCHAR(255) NULL DEFAULT NULL,
  CHANGE `kategori` `category` VARCHAR(255) NOT NULL DEFAULT 'Balai / Laboratorium',
  CHANGE `alamat` `address` TEXT NULL DEFAULT NULL,
  CHANGE `telepon` `phone` VARCHAR(255) NULL DEFAULT NULL,
  CHANGE `penanggung_jawab` `person_in_charge` VARCHAR(255) NULL DEFAULT NULL;


-- ------------------------------------------------------------------------
-- TABEL 5: KATEGORI UJI
-- ------------------------------------------------------------------------
ALTER TABLE `kategori_ujis` 
  CHANGE `kategori` `category` ENUM('nyamuk','insektisida','metode') NOT NULL,
  CHANGE `nama` `name` VARCHAR(255) NOT NULL,
  CHANGE `keterangan` `description` TEXT NULL DEFAULT NULL;


-- ------------------------------------------------------------------------
-- TABEL 6: USERS
-- ------------------------------------------------------------------------
ALTER TABLE `users` 
  CHANGE `telepon` `phone` VARCHAR(25) NULL DEFAULT NULL;


-- ------------------------------------------------------------------------
-- TABEL 7: DELETE REQUESTS
-- ------------------------------------------------------------------------
ALTER TABLE `delete_requests` 
  CHANGE `alasan` `reason` TEXT NOT NULL;

SET FOREIGN_KEY_CHECKS = 1;
