-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Okt 2026 pada 14.37
-- Versi server: 8.0.30
-- Versi PHP: 8.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_simpel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_uji_resistensis`
--

CREATE TABLE `data_uji_resistensis` (
  `id` bigint UNSIGNED NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `provinsi_id` bigint UNSIGNED NOT NULL,
  `kabupaten_id` bigint UNSIGNED NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `jenis_nyamuk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insektisida` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sampel_diperiksa` int NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_uji_resistensis`
--

INSERT INTO `data_uji_resistensis` (`id`, `no`, `bulan`, `tahun`, `provinsi_id`, `kabupaten_id`, `alamat`, `jenis_nyamuk`, `insektisida`, `metode`, `sampel_diperiksa`, `status`, `mutasi`, `publikasi`, `created_at`, `updated_at`) VALUES
(7, '1', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Cypermethrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(8, '2', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Lamdacyhalothrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(9, '3', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Deltamethrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(10, '4', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Alphacypermethrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(11, '5', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Cyfluthrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(12, '6', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Permethrin', 'Sequencing', 1, 'resisten', 'Ya', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(13, '7', 'November', 2024, 13, 158, 'Kab Kudus', 'Ae. aegypti', 'Malathion', 'Sequencing', 1, 'rentan', 'Tidak', 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(14, '8', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(15, '9', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(16, '10', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(17, '11', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(18, '12', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(19, '13', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(20, '14', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(21, '15', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(22, '16', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(23, '17', 'Juni', 2026, 13, 154, 'Kab Grobogan', 'Culex sp', 'Deltamethrin 0,025%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(24, '18', 'Juni', 2026, 13, 147, 'Kab Magelang', 'Culex sp', 'Lambda-cyhalothrin 0,0025%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(25, '19', 'Juni', 2026, 13, 147, 'Kab Magelang', 'Culex sp', 'Lambda-cyhalothrin 0,0025%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(26, '20', 'Juni', 2026, 13, 147, 'Kab Magelang', 'Culex sp', 'Lambda-cyhalothrin 0,0025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(27, '21', 'Juni', 2026, 13, 147, 'Kab Magelang', 'Culex sp', 'Lambda-cyhalothrin 0,0025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(28, '22', 'Juni', 2026, 13, 147, 'Kab Magelang', 'Culex sp', 'Lambda-cyhalothrin 0,0025%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data Simpel', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(29, '23', 'Desember', 2024, 28, 418, 'Baruga', 'Ae. aegypti', 'Temefos (Abate)', 'WHO larval bioassay', 1, 'resisten', NULL, 'https://jurnal.peki.or.id/index.php/aspirator/article/view/129', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(30, '24', 'Desember', 2024, 28, 418, 'Kadia', 'Ae. aegypti', 'Temefos (Abate)', 'WHO larval bioassay', 1, 'resisten', NULL, 'https://jurnal.peki.or.id/index.php/aspirator/article/view/130', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(31, '25', 'Desember', 2024, 28, 418, 'Poasia', 'Ae. aegypti', 'Temefos (Abate)', 'WHO larval bioassay', 1, 'resisten', NULL, 'https://jurnal.peki.or.id/index.php/aspirator/article/view/131', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(32, '26', 'Juni', 2023, 35, 385, 'Naena Muktipura', 'Ae. aegypti', 'Temefos (Abate)', 'WHO larval bioassay', 80, 'rentan', NULL, 'https://e-journal.unair.ac.id/JKL/article/view/46533/27837', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(33, '27', 'Juni', 2023, 35, 385, 'Naena Muktipura', 'Culex', 'Temefos (Abate)', 'WHO larval bioassay', 80, 'rentan', NULL, 'https://e-journal.unair.ac.id/JKL/article/view/46533/27838', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(34, '28', 'Juni', 2023, 35, 385, 'Naena Muktipura', 'Anopheles', 'Temefos (Abate)', 'WHO larval bioassay', 80, 'rentan', NULL, 'https://e-journal.unair.ac.id/JKL/article/view/46533/27839', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(35, '29', 'Mei', 2021, 27, 419, 'Paccerakkang', 'Culex', 'Temefos (Abate)', 'WHO larval bioassay', 100, 'rentan', NULL, 'https://journal.uin-alauddin.ac.id/index.php/higiene/article/view/30897/16608', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(36, '30', 'September', 2024, 15, 197, 'Pelabuhan Gresik', 'Aedes sp', 'Temefos (Abate)', 'WHO larval bioassay', 125, 'rentan', NULL, 'https://garuda.kemdiktisaintek.go.id/documents/detail/4194513', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(37, '31', 'November', 2024, 28, 418, 'Kota Kendari', 'Aedes sp', 'Temefos (Abate)', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(38, '32', 'September', 2025, 18, 217, 'Desa Ropang', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'resisten', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29925', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(39, '33', 'September', 2025, 18, 217, 'Desa Lawin', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'resisten', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29926', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(40, '34', 'September', 2025, 18, 217, 'Desa Ranan Tambang', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'resisten', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29927', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(41, '35', 'September', 2025, 18, 217, 'Desa Ranan', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'rentan', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29928', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(42, '36', 'September', 2025, 18, 217, 'Desa Lebin', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'rentan', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29929', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(43, '37', 'September', 2025, 18, 217, 'Desa Lebangkar', 'Anhopeles', 'Bendiocarb 80%', 'WHO standard bioassay', 1, 'rentan', NULL, 'https://ejournal.undip.ac.id/index.php/jkli/article/view/78923/29930', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(44, '38', 'November', 2024, 19, 239, 'Sumba Barat Daya', 'Anhopeles', 'Lamdacyhalothrin', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(45, '39', 'November', 2024, 19, 239, 'Sumba Barat Daya', 'Anhopeles', 'Deltamethrin', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(46, '40', 'November', 2024, 19, 239, 'Sumba Barat Daya', 'Anhopeles', 'Alphacypermethrin', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(47, '41', 'November', 2024, 19, 239, 'Sumba Barat Daya', 'Anhopeles', 'Permethrin', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(48, '42', 'November', 2024, 19, 239, 'Sumba Barat Daya', 'Anhopeles', 'Bendiocarb', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(49, '43', 'November', 2024, 36, 392, 'Boven Digoel', 'An. Farauti', 'Deltamethrin', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(50, '44', 'November', 2024, 36, 392, 'Boven Digoel', 'An. Farauti', 'Permethrin', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(51, '45', 'November', 2024, 36, 392, 'Boven Digoel', 'An. Farauti', 'Bendiocarb', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(52, '46', 'November', 2024, 33, 386, 'Sarmi', 'An. Farauti', 'Deltamethrin', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(53, '47', 'November', 2024, 33, 386, 'Sarmi', 'An. Farauti', 'Permethrin', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(54, '48', 'November', 2024, 33, 386, 'Sarmi', 'An. Farauti', 'Bendiocarb', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(55, '49', 'April', 2022, 2, 31, 'Desa Kota Siantar', 'An. Vagus', 'Permethrin 21.5µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(56, '50', 'April', 2022, 2, 31, 'Desa Kota Siantar', 'An. Vagus', 'Bendiocarb 12.5µg', 'CDC bottle_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(57, '51', 'April', 2022, 2, 31, 'Desa Kota Siantar', 'An. Vagus', 'Alphacypermethrin 12.5µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(58, '52', 'Juni', 2022, 33, 380, 'Desa Wadio', 'An. Vagus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(59, '53', 'Juni', 2022, 33, 380, 'Desa Wadio', 'An. Vagus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(60, '54', 'Juni', 2022, 33, 380, 'Desa Wadio', 'An. Vagus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(61, '55', 'September', 2025, 27, 333, 'Desa Saloso', 'An. Vagus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(62, '56', 'September', 2025, 27, 333, 'Desa Saloso', 'An. Vagus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(63, '57', 'April', 2026, 19, 232, 'Desa Watupuda', 'An. Vagus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(64, '58', 'April', 2026, 19, 232, 'Desa Watupuda', 'An. Vagus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(65, '59', 'April', 2026, 19, 232, 'Desa Watupuda', 'An. Vagus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(66, '60', 'April', 2026, 19, 232, 'Desa Watupuda', 'An. Vagus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(67, '61', 'April', 2026, 19, 232, 'Desa Watuhadang', 'An. Vagus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(68, '62', 'April', 2026, 19, 232, 'Desa Watuhadang', 'An. Vagus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(69, '63', 'April', 2026, 19, 232, 'Desa Watuhadang', 'An. Vagus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(70, '64', 'April', 2026, 19, 232, 'Desa Watuhadang', 'An. Vagus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(71, '65', 'Desember', 2023, 33, 385, 'Desa Seberang Kali', 'An. tessellatus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(72, '66', 'Desember', 2023, 33, 385, 'Desa Seberang Kali', 'An. tessellatus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(73, '67', 'Desember', 2023, 33, 385, 'Desa Seberang Kali', 'An. tessellatus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(74, '68', 'Desember', 2023, 33, 385, 'Desa Seberang Kali', 'An. tessellatus', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(75, '69', 'September', 2022, 8, 97, 'Desa Sukaraja (Way Muli)', 'An. sundaicus s.l.', 'Lambda-cyhalothrin 12.5µg', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(76, '70', 'September', 2022, 8, 97, 'Desa Sukaraja (Way Muli)', 'An. sundaicus s.l.', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(77, '71', 'September', 2022, 8, 97, 'Desa Sukaraja (Way Muli)', 'An. sundaicus s.l.', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(78, '72', 'September', 2022, 8, 97, 'Desa Sukaraja (Way Muli)', 'An. sundaicus s.l.', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(79, '73', 'September', 2022, 4, 62, 'Desa Penipahan Darat', 'An. sundaicus s.l.', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(80, '74', 'September', 2022, 4, 62, 'Desa Penipahan Darat', 'An. sundaicus s.l.', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(81, '75', 'September', 2022, 4, 62, 'Desa Penipahan Darat', 'An. sundaicus s.l.', 'Alphacypermethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(82, '76', 'Desember', 2023, 33, 379, 'Sentani Kota', 'An. punctulatus s.l.', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(83, '77', 'Desember', 2023, 33, 379, 'Sentani Kota', 'An. punctulatus s.l.', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(84, '78', 'April', 2022, 34, 406, 'Desa SP4, Udapi Hilir', 'An. peditaeniatus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(85, '79', 'April', 2022, 34, 406, 'Desa SP4, Udapi Hilir', 'An. peditaeniatus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(86, '80', 'April', 2022, 34, 406, 'Desa SP4, Udapi Hilir', 'An. peditaeniatus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(87, '81', 'Juni', 2022, 25, 296, 'Desa Silian', 'An. parensis', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(88, '82', 'Juni', 2022, 25, 296, 'Desa Silian', 'An. parensis', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(89, '83', 'Juni', 2023, 21, 257, 'Desa Aruk', 'An. letifer', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(90, '84', 'Juni', 2023, 21, 257, 'Desa Aruk', 'An. letifer', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(91, '85', 'Juni', 2023, 21, 257, 'Desa Aruk', 'An. letifer', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(92, '86', 'Juni', 2023, 21, 257, 'Desa Aruk', 'An. letifer', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(93, '87', 'Juli', 2025, 33, 379, 'Desa Apo Pantai', 'An. koliensis', 'Cypermethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(94, '88', 'Juli', 2026, 33, 381, 'Desa Ariepi II', 'An. koliensis', 'Permethrin 0,25%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(95, '89', 'Juli', 2026, 33, 381, 'Desa Ariepi II', 'An. koliensis', 'Deltamethrin 0.03%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(96, '90', 'Juli', 2026, 33, 381, 'Desa Ariepi II', 'An. koliensis', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(97, '91', 'Juli', 2026, 33, 381, 'Desa Ariepi II', 'An. koliensis', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(98, '92', 'Juli', 2026, 33, 381, 'Desa Ariepi II', 'An. koliensis', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(99, '93', 'Agustus', 2026, 33, 379, 'Desa Koya Tengah', 'An. koliensis', 'Deltamethrin 0.02%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(100, '94', 'Agustus', 2026, 33, 379, 'Desa Koya Tengah', 'An. koliensis', 'Deltamethrin 0.03%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(101, '95', 'Agustus', 2026, 33, 379, 'Desa Koya Tengah', 'An. koliensis', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(102, '96', 'Agustus', 2026, 33, 379, 'Desa Koya Tengah', 'An. koliensis', 'Bendiocarb 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(103, '97', 'Agustus', 2026, 33, 379, 'Desa Koya Tengah', 'An. koliensis', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(104, '98', 'September', 2022, 5, 420, 'Desa Mata Gaul', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(105, '99', 'September', 2022, 5, 420, 'Desa Mata Gaul', 'An. kochi', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(106, '100', 'September', 2022, 5, 420, 'Desa Mata Gaul', 'An. kochi', 'Pirimiphos-methyl 0.25%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(107, '101', 'September', 2022, 5, 420, 'Desa Mata Gaul', 'An. kochi', 'Alphacypermethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(108, '102', 'September', 2022, 5, 420, 'Desa Mata Gaul', 'An. kochi', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(109, '103', 'September', 2022, 5, 420, 'Desa Hajran', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(110, '104', 'September', 2022, 5, 420, 'Desa Hajran', 'An. kochi', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(111, '105', 'September', 2022, 5, 420, 'Desa Hajran', 'An. kochi', 'Pirimiphos-methyl 0.25%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(112, '106', 'September', 2022, 5, 420, 'Desa Hajran', 'An. kochi', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(113, '107', 'Juni', 2022, 23, 284, 'Desa Sotik', 'An. kochi', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(114, '108', 'Juni', 2022, 23, 284, 'Desa Sotik', 'An. kochi', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(115, '109', 'Juni', 2022, 23, 284, 'Desa Sotik', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(116, '110', 'Juni', 2022, 23, 284, 'Desa Sotik', 'An. kochi', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(117, '111', 'Agustus', 2022, 23, 279, 'Desa Suweto', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(118, '112', 'Agustus', 2022, 23, 279, 'Desa Petangis', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(119, '113', 'Juni', 2026, 33, 386, 'Desa Kasukwae', 'An. kochi', 'Permethrin 1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(120, '114', 'Juni', 2026, 33, 386, 'Desa Kasukwae', 'An. kochi', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(121, '115', 'Juni', 2026, 33, 386, 'Desa Kasukwae', 'An. kochi', 'Bendiocarb 0.05%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(122, '116', 'Maret', 2022, 26, 309, 'Desa Bulan Jaya', 'An. indefinitus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(123, '117', 'Maret', 2022, 26, 309, 'Desa Bulan Jaya', 'An. indefinitus', 'Deltamethrin 12.5µg', 'CDC bottle_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(124, '118', 'Agustus', 2024, 19, 239, 'Desa Karuni dan Desa Letekonda Selatan', 'An. indefinitus', 'Alphacypermethrin 0.05%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(125, '119', 'Agustus', 2024, 19, 239, 'Desa Karuni dan Desa Letekonda Selatan', 'An. indefinitus', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(126, '120', 'Agustus', 2024, 19, 239, 'Desa Karuni dan Desa Letekonda Selatan', 'An. indefinitus', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(127, '121', 'Agustus', 2024, 19, 239, 'Desa Karuni dan Desa Letekonda Selatan', 'An. indefinitus', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(128, '122', 'Agustus', 2024, 19, 239, 'Desa Karuni dan Desa Letekonda Selatan', 'An. indefinitus', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(129, '123', 'Agustus', 2022, 23, 279, 'Desa Mendik', 'An. hyrcanus s.l.', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(130, '124', 'Agustus', 2022, 23, 279, 'Desa Mendik', 'An. hyrcanus s.l.', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(131, '125', 'Agustus', 2022, 23, 279, 'Desa Mendik', 'An. hyrcanus s.l.', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(132, '126', 'Agustus', 2022, 23, 279, 'Desa Mendik', 'An. hyrcanus s.l.', 'Pirimiphos-methyl 0.25%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(133, '127', 'Juni', 2026, 33, 391, 'Desa Khemon Jaya SP V', 'An. farauti s.s.', 'Deltamethrin 0.03%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(134, '128', 'Juni', 2026, 33, 391, 'Desa Khemon Jaya SP V', 'An. farauti s.s.', 'Bendiocarb 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(135, '129', 'Juni', 2026, 33, 391, 'Desa Khemon Jaya SP V', 'An. farauti s.s.', 'Permethrin 0.25%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(136, '130', 'Juni', 2026, 33, 391, 'Desa Khemon Jaya SP V', 'An. farauti s.s.', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(137, '131', 'Juli', 2026, 33, 382, 'Desa Tanjung Barari dan Desa Dernafi', 'An. farauti s.s.', 'Bendiocarb 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(138, '132', 'Agustus', 2026, 33, 396, 'Danau Bira', 'An. farauti s.s.', 'Deltamethrin 0.03%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(139, '133', 'Juni', 2022, 34, 405, 'Desa Klamalu', 'An. farauti s.l.', 'Deltamethrin 0.05%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(140, '134', 'Juni', 2022, 34, 405, 'Desa Klamalu', 'An. farauti s.l.', 'Permethrin 0.75%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(141, '135', 'Juni', 2022, 34, 405, 'Desa Klamalu', 'An. farauti s.l.', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(142, '136', 'Juni', 2022, 34, 405, 'Desa Klamalu', 'An. farauti s.l.', 'Bendiocarb 0.1%', 'WHO test kit_adults', 1, 'rentan', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(143, '137', 'Juni', 2022, 25, 296, 'Desa Silian', 'An. barbirostris', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(144, '138', 'Juni', 2022, 25, 296, 'Desa Silian', 'An. barbirostris', 'Lambda-cyhalothrin 0.05%', 'WHO test kit_adults', 1, 'toleran', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(145, '139', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Cypermethrin 12.5µg', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(146, '140', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Malathion 5.0%', 'WHO test kit_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(147, '141', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Alphacypermethrin 12.5µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(148, '142', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Deltamethrin 12.5µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(149, '143', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Permethrin 21.5µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(150, '144', 'November', 2022, 13, 144, 'Desa Sindoro', 'An. aconitus', 'Malathion 50µg', 'CDC bottle_adults', 1, 'resisten', NULL, 'WMR_IR_discriminating_concentration_bioassays_200826.xlsm', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(151, '145', 'April', 2021, 13, 149, 'Ngawonggo', 'Ae. aegypti', 'Cypermethrin 10 μg/ml', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://ejurnal.poltekkes-tjk.ac.id/index.php/JKESLING/article/view/Nur%20Bebi%20Ulfah%20Irawati%2C%20Novita%20Eka%20Putri', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(152, '146', 'April', 2021, 13, 149, 'Kajen', 'Ae. aegypti', 'Cypermethrin 10 μg/ml', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://ejurnal.poltekkes-tjk.ac.id/index.php/JKESLING/article/view/Nur%20Bebi%20Ulfah%20Irawati%2C%20Novita%20Eka%20Putri', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(153, '147', 'April', 2021, 13, 149, 'Meger', 'Ae. aegypti', 'Cypermethrin 10 μg/ml', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://ejurnal.poltekkes-tjk.ac.id/index.php/JKESLING/article/view/Nur%20Bebi%20Ulfah%20Irawati%2C%20Novita%20Eka%20Putri', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(154, '148', 'Desember', 2021, 10, 421, 'Pinang Kencana', 'Aedes sp', 'Deltametrin 10  μg/botol', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://www.jurnalpoltekkesmaluku.com/index.php/JKT/article/view/199', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(155, '149', 'Maret', 2022, 15, 179, 'Turen', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4614/2/qibtyah%20nuryady%20susetyarini%20permana%20sasongkojati%20-%20aedes%20aegypti%20insektisida%20resistensi%20suseptibiliti.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(156, '150', 'Maret', 2022, 15, 179, 'Kepanjen', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4614/2/qibtyah%20nuryady%20susetyarini%20permana%20sasongkojati%20-%20aedes%20aegypti%20insektisida%20resistensi%20suseptibiliti.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(157, '151', 'Maret', 2022, 15, 179, 'Karangploso', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4614/2/qibtyah%20nuryady%20susetyarini%20permana%20sasongkojati%20-%20aedes%20aegypti%20insektisida%20resistensi%20suseptibiliti.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(158, '152', 'Maret', 2022, 15, 179, 'Dau', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4614/2/qibtyah%20nuryady%20susetyarini%20permana%20sasongkojati%20-%20aedes%20aegypti%20insektisida%20resistensi%20suseptibiliti.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(159, '153', 'Juni', 2023, 4, 422, 'Pelabuhan Sungai Duku', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 125, 'toleran', NULL, 'https://jurnal.htp.ac.id/index.php/keskom/id/article/view/1574/595', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(160, '154', 'Februari', 2026, 14, 423, 'Sorosutan', 'Ae. aegypti', 'Permethrin', 'CDC Bottle Bioassay', 1, 'resisten', NULL, 'https://journal.ugm.ac.id/v3/bib/article/view/31125', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(161, '155', 'April', 2024, 26, 424, 'Palu Utara', 'Ae. aegypti', 'Malation 0,7%', 'CDC bottle bioassay', 320, 'toleran', NULL, 'https://journal.unpacti.ac.id/index.php/JPP/article/view/1491/855', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(162, '156', 'April', 2024, 26, 424, 'Palu Utara', 'Ae. aegypti', 'Malation 0,8%', 'CDC bottle bioassay', 320, 'rentan', NULL, 'https://journal.unpacti.ac.id/index.php/JPP/article/view/1491/855', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(163, '157', 'April', 2024, 26, 424, 'Palu Utara', 'Ae. aegypti', 'Malation 0,9%', 'CDC bottle bioassay', 320, 'rentan', NULL, 'https://journal.unpacti.ac.id/index.php/JPP/article/view/1491/855', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(164, '158', 'April', 2024, 26, 424, 'Palu Utara', 'Ae. aegypti', 'Malation 1%', 'CDC bottle bioassay', 320, 'rentan', NULL, 'https://journal.unpacti.ac.id/index.php/JPP/article/view/1491/855', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(165, '159', 'September', 2023, 29, 351, 'Suwawa', 'Aedes sp', 'Malathion 0,08%', 'WHO susceptibilitity test', 120, 'rentan', NULL, 'https://ejurnal.ung.ac.id/index.php/jjhsr/article/view/27110/pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(166, '160', 'September', 2023, 29, 351, 'Suwawa', 'Aedes sp', 'Sipermethrin 0,05%', 'WHO susceptibilitity test', 120, 'rentan', NULL, 'https://ejurnal.ung.ac.id/index.php/jjhsr/article/view/27110/pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(167, '161', 'September', 2023, 13, 161, 'Mranggen', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 75, 'resisten', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(168, '162', 'September', 2023, 13, 161, 'Kembangarum', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 75, 'toleran', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(169, '163', 'September', 2023, 13, 161, 'Brumbung', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO standard bioassay', 75, 'resisten', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(170, '164', 'September', 2023, 13, 161, 'Mranggen', 'Ae. aegypti', 'Malathion 5%', 'WHO standard bioassay', 75, 'resisten', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(171, '165', 'September', 2023, 13, 161, 'Kembangarum', 'Ae. aegypti', 'Malathion 5%', 'WHO standard bioassay', 75, 'resisten', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(172, '166', 'September', 2023, 13, 161, 'Brumbung', 'Ae. aegypti', 'Malathion 5%', 'WHO standard bioassay', 75, 'toleran', NULL, 'https://jurnalnew.unimus.ac.id/index.php/prosidingfkm/article/view/223', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(173, '167', 'Agustus', 2021, 15, 179, 'Kepanjen', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'https://eprints.umm.ac.id/id/eprint/4672/', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(174, '168', 'Agustus', 2021, 15, 179, 'Gondanglegi', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4672/', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(175, '169', 'Agustus', 2021, 15, 179, 'Bantur', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'https://eprints.umm.ac.id/id/eprint/4672/', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(176, '170', 'Agustus', 2022, 2, 425, 'Kelurahan Helvetia Tengah', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 120, 'rentan', NULL, 'https://brida.medan.go.id/storage/berita/files/33%20SKRIPSI_Elisa%20Mei%20Dina%20Purba_181000170_BAS.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(177, '171', 'Februari', 2021, 4, 422, 'Pelabuhan Sungai Duku', 'Ae. aegypti', 'Sipermetrin 0,05%', 'WHO susceptibilitity test', 250, 'toleran', NULL, 'https://sehati.pelantarpress.co.id/index.php/Sehati/article/view/3/pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(178, '172', 'Februari', 2021, 4, 422, 'Bandara Sultan Syarif Kasim II', 'Ae. aegypti', 'Sipermetrin 0,05%', 'WHO susceptibilitity test', 250, 'toleran', NULL, 'https://sehati.pelantarpress.co.id/index.php/Sehati/article/view/3/pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(179, '173', 'Desember', 2022, 17, 206, 'jembrana', 'Ae. aegypti', 'permethrin 0,25%', 'WHO susceptibilitity test', 120, 'rentan', NULL, 'https://pdfs.semanticscholar.org/4f33/bb62c5c05a72263b1ea9405dd846b21a40dd.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(180, '174', 'Juni', 2025, 19, 229, 'Kelurahan Onekore', 'Ae. aegypti', 'cypermethrin', 'CDC bottle bioassay', 1, 'rentan', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/256611', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(181, '175', 'NA', 2022, 2, 425, 'Helvetia Timur', 'Ae. aegypti', 'permethrin', 'CDC bottle bioassay', 120, 'resisten', NULL, 'https://repositori.usu.ac.id/handle/123456789/80101', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(182, '176', 'Juli', 2022, 22, 426, 'Sungai Andai', 'Ae. aegypti', 'Malation', 'CDC bottle bioassay', 1, 'toleran', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/215550', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(183, '177', 'Oktober', 2024, 15, 427, 'Puskesmas Sememi', 'Ae. aegypti', 'Cypermethrin 1%', 'CDC bottle bioassay', 1, 'rentan', NULL, 'https://repo.poltekkes-surabaya.ac.id/9088/', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(184, '178', 'Desember', 2022, 13, 147, 'Rejowinangun Utara', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/222460', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(185, '179', 'September', 2025, 3, 48, 'Pelabbuhan Laut', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'https://journal.ugm.ac.id/jsv/article/view/112339/45397', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(186, '180', 'April', 2026, 37, 405, 'Kota Sorong', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/276765', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(187, '181', 'April', 2026, 37, 405, 'Kota Sorong', 'Ae. aegypti', 'Malathion 5 μg/mL', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/276765', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(188, '182', 'Februari', 2025, 15, 179, 'Kota Malang', 'Ae. aegypti', 'Cypermethrin 0,05%', 'WHO susceptibilitity test', 80, 'toleran', NULL, 'https://journal.unnes.ac.id/journals/kemas/article/view/21666/6281', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(189, '183', 'Februari', 2025, 15, 179, 'Kota Malang', 'Ae. aegypti', 'Malathion 0,8%', 'WHO susceptibilitity test', 80, 'resisten', NULL, 'https://journal.unnes.ac.id/journals/kemas/article/view/21666/6282', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(190, '184', 'Juni', 2025, 27, 328, 'Kabupaten enrekang', 'Ae. aegypti', 'Malathion 0,8%', 'WHO standard bioassay', 240, 'resisten', NULL, 'https://www.researchgate.net/publication/392568888_Susceptibility_of_Aedes_aegypti_to_malathion_and_permethrin_insecticides_in_Enrekang_Regency_an_experimental_study', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(191, '185', 'Juni', 2025, 27, 328, 'Kabupaten enrekang', 'Ae. aegypti', 'Permethrin 0,25%', 'WHO standard bioassay', 240, 'rentan', NULL, 'https://www.researchgate.net/publication/392568888_Susceptibility_of_Aedes_aegypti_to_malathion_and_permethrin_insecticides_in_Enrekang_Regency_an_experimental_study', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(192, '186', 'Juli', 2023, 13, 158, 'Kaliwungu', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 80, 'resisten', NULL, 'https://www.bio-conferences.org/articles/bioconf/pdf/2024/13/bioconf_icbs2024_02001.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(193, '187', 'Juli', 2023, 14, 423, 'Kotagede', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 80, 'resisten', NULL, 'https://www.bio-conferences.org/articles/bioconf/pdf/2024/13/bioconf_icbs2024_02001.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(194, '188', 'Juli', 2023, 13, 158, 'Kaliwungu', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 80, 'resisten', NULL, 'https://www.bio-conferences.org/articles/bioconf/pdf/2024/13/bioconf_icbs2024_02001.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(195, '189', 'Juli', 2023, 14, 423, 'Kotagede', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 80, 'resisten', NULL, 'https://www.bio-conferences.org/articles/bioconf/pdf/2024/13/bioconf_icbs2024_02001.pdf', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(196, '190', 'Juni', 2023, 13, 145, 'Pangenrejo', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'resisten', NULL, 'https://etd.repository.ugm.ac.id/penelitian/detail/227741', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(197, '191', 'September', 2024, 15, 197, 'Pelabuhan Gresik', 'Aedes sp', 'lamdasilothrin', 'CDC bottle bioassay', 125, 'rentan', NULL, 'https://garuda.kemdiktisaintek.go.id/documents/detail/4194513', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(198, '192', 'November', 2024, 13, 417, 'Salatiga', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(199, '193', 'November', 2024, 13, 417, 'Salatiga', 'Ae. aegypti', 'Cyfluthrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(200, '194', 'November', 2024, 13, 417, 'Salatiga', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(201, '195', 'November', 2024, 13, 150, 'Sukoharjo', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(202, '196', 'November', 2024, 13, 150, 'Sukoharjo', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(203, '197', 'November', 2024, 13, 163, 'Kendal', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(204, '198', 'November', 2024, 13, 163, 'Kendal', 'Ae. aegypti', 'Cyfluthrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(205, '199', 'November', 2024, 13, 163, 'Kendal', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(206, '200', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(207, '201', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(208, '202', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Cyfluthrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(209, '203', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(210, '204', 'November', 2024, 13, 156, 'Rembang', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(211, '205', 'November', 2024, 13, 156, 'Rembang', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(212, '206', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(213, '207', 'November', 2024, 13, 159, 'Jepara', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06');
INSERT INTO `data_uji_resistensis` (`id`, `no`, `bulan`, `tahun`, `provinsi_id`, `kabupaten_id`, `alamat`, `jenis_nyamuk`, `insektisida`, `metode`, `sampel_diperiksa`, `status`, `mutasi`, `publikasi`, `created_at`, `updated_at`) VALUES
(214, '208', 'November', 2024, 13, 148, 'Boyolali', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(215, '209', 'November', 2024, 13, 148, 'Boyolali', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(216, '210', 'November', 2024, 13, 149, 'Klaten', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(217, '211', 'November', 2024, 13, 149, 'Klaten', 'Ae. aegypti', 'Deltamethrin', 'CDC bottle bioassay', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(218, '212', 'November', 2024, 13, 149, 'Klaten', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(219, '213', 'November', 2024, 13, 165, 'Pekalongan', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(220, '214', 'November', 2024, 13, 165, 'Pekalongan', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(221, '215', 'November', 2024, 13, 167, 'Kabupaten Tegal', 'Ae. aegypti', 'Cypermethrin', 'CDC bottle bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(222, '216', 'November', 2024, 13, 167, 'Kabupaten Tegal', 'Ae. aegypti', 'Malathion', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(223, '217', 'November', 2024, 11, 428, 'Jakarta Timur', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(224, '218', 'November', 2024, 15, 197, 'Gresik', 'Ae. aegypti', 'Lamdacyhalothrin', 'CDC bottle bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(225, '219', 'November', 2024, 20, 245, 'Sanggau', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(226, '220', 'November', 2024, 20, 245, 'Sanggau', 'Ae. aegypti', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(227, '221', 'November', 2024, 20, 245, 'Sanggau', 'Ae. aegypti', 'Deltamethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(228, '222', 'November', 2024, 20, 245, 'Sanggau', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(229, '223', 'November', 2024, 25, 429, 'Manado', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(230, '224', 'November', 2024, 29, 349, 'Gorontalo', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(231, '225', 'November', 2024, 18, 214, 'Lombok Barat', 'Ae. aegypti', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(232, '226', 'November', 2024, 18, 214, 'Lombok Barat', 'Ae. aegypti', 'Permetrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(233, '227', 'November', 2024, 18, 214, 'Lombok Barat', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(234, '228', 'November', 2024, 18, 221, 'Lombok Utara', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(235, '229', 'November', 2024, 18, 221, 'Lombok Utara', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(236, '230', 'November', 2024, 18, 221, 'Lombok Utara', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(237, '231', 'November', 2024, 22, 272, 'Tapin', 'Aedes sp', 'Temefos', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(238, '232', 'November', 2024, 22, 272, 'Tapin', 'Aedes sp', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(239, '233', 'November', 2024, 22, 272, 'Tapin', 'Aedes sp', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(240, '234', 'November', 2024, 16, 204, 'Tangerang', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(241, '235', 'November', 2024, 16, 204, 'Tangerang', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(242, '236', 'November', 2024, 16, 204, 'Tangerang', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(243, '237', 'November', 2024, 17, 208, 'Badung', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(244, '238', 'November', 2024, 17, 208, 'Badung', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(245, '239', 'November', 2024, 17, 208, 'Badung', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(246, '240', 'November', 2024, 27, 324, 'Kab. Soppeng', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(247, '241', 'November', 2024, 27, 324, 'Kab. Soppeng', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(248, '242', 'November', 2024, 27, 324, 'Kab. Soppeng', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(249, '243', 'November', 2024, 6, 81, 'Kab. Banyuasin', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(250, '244', 'November', 2024, 6, 81, 'Kab. Banyuasin', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(251, '245', 'November', 2024, 6, 81, 'Kab. Banyuasin', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(252, '246', 'November', 2024, 23, 430, 'Kab. Kutai Kertanegara', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(253, '247', 'November', 2024, 23, 430, 'Kab. Kutai Kertanegara', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(254, '248', 'November', 2024, 23, 430, 'Kab. Kutai Kertanegara', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(255, '249', 'November', 2024, 31, 431, 'Kota Ambon', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(256, '250', 'November', 2024, 31, 431, 'Kota Ambon', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(257, '251', 'November', 2024, 31, 431, 'Kota Ambon', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(258, '252', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Malathion', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(259, '253', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Deltamethrin', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(260, '254', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(261, '255', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(262, '256', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Malathion', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(263, '257', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Deltamethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(264, '258', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(265, '259', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(266, '260', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(267, '261', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Deltamethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(268, '262', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(269, '263', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(270, '264', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(271, '265', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Deltamethrin', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(272, '266', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Lamdacyhalothrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(273, '267', 'November', 2024, 13, 159, 'Kab Jepara', 'Aedes sp', 'Cypermethrin', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(274, '268', 'November', 2024, 12, 432, 'Kota Depok', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(275, '269', 'November', 2024, 12, 432, 'Kota Depok', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(276, '270', 'November', 2024, 12, 432, 'Kota Depok', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'toleran', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(277, '271', 'November', 2024, 13, 159, 'Kab Jepara', 'Ae. aegypti', 'Temefos', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(278, '272', 'November', 2024, 28, 418, 'Kota Kendari', 'Ae. aegypti', 'Alphacypermethrin', 'WHO susceptibilitity test', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(279, '273', 'November', 2024, 28, 418, 'Kota Kendari', 'Ae. aegypti', 'Malathion', 'WHO susceptibilitity test', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(280, '274', 'Maret', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(281, '275', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(282, '276', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(283, '277', 'April', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(284, '278', 'April', 2026, 13, 161, 'Kab Semarang', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(285, '279', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(286, '280', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(287, '281', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Bendiocarb 0,20%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(288, '282', 'Maret', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(289, '283', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(290, '284', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(291, '285', 'April', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(292, '286', 'April', 2026, 13, 161, 'Kab Semarang', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(293, '287', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(294, '288', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(295, '289', 'April', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Deltamethrin 0,03%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(296, '290', 'Maret', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(297, '291', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(298, '292', 'Maret', 2026, 13, 417, 'Kota Salatiga', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(299, '293', 'April', 2026, 13, 148, 'Kab Boyolali', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(300, '294', 'April', 2026, 13, 161, 'Kab Semarang', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'resisten', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(301, '295', 'April', 2026, 13, 417, 'Kota salatiga', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(302, '296', 'April', 2026, 13, 417, 'Kota salatiga', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(303, '297', 'April', 2026, 13, 417, 'Kota salatiga', 'Ae. aegypti', 'Malathion 1,5%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(304, '298', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(305, '299', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'rentan', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(306, '300', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(307, '301', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(308, '302', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(309, '303', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(310, '304', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(311, '305', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(312, '306', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(313, '307', 'Juni', 2026, 13, 191, 'Kab Madiun', 'Ae. aegypti', 'Permetrin 0,40%', 'WHO Tube Bioassay', 1, 'toleran', NULL, 'Data simpel', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(314, '308', 'November', 2024, 13, 159, 'Kab Jepara', 'Ae. Albopictus', 'Alphacypermethrin', 'WHO standard bioassay', 1, 'resisten', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(315, '309', 'November', 2024, 13, 159, 'Kab Jepara', 'Ae. Albopictus', 'Malathion', 'WHO standard bioassay', 1, 'rentan', NULL, 'DATA RESISTENSI UNTUK RK 2024 _Gabung.xlsx', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(316, '310', 'November', 2022, 10, 117, 'Pelabuhan Meral', 'Ae. Albopictus', 'Sipermetrin 0,05%', 'WHO standard bioassay', 100, 'rentan', NULL, 'https://jurnal.uinsu.ac.id/index.php/kesmas/article/view/13418/6435', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(317, '311', 'Juni', 2021, 13, 161, 'Pelabuhan Tanjung Emas', 'Ae. aegypti', 'Sipermetrin 0,05%', 'WHO standard bioassay', 240, 'rentan', NULL, 'https://www.researchgate.net/publication/357832809_STATUS_KERENTANAN_NYAMUK_Aedes_aegypti_TERHADAP_INSEKTISIDA_SIPERMETRIN_DI_AREA_PERIMETER_DAN_BUFFER_PELABUHAN_TANJUNG_EMAS_KOTA_SEMARANG', '2026-10-11 02:42:07', '2026-10-11 02:42:07'),
(318, '312', 'Januari', 2022, 15, 187, 'bandara juanda', 'Aedes aegypti', 'Lamdacyhalothrin', 'WHO standard bioassay', 150, 'rentan', NULL, 'https://journal.umg.ac.id/index.php/jphsr/article/view/4479/2590', '2026-10-11 02:42:07', '2026-10-11 02:42:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `delete_requests`
--

CREATE TABLE `delete_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `data_uji_resistensi_id` bigint UNSIGNED DEFAULT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `instansis`
--

CREATE TABLE `instansis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Balai / Laboratorium',
  `provinsi_id` bigint UNSIGNED DEFAULT NULL,
  `kabupaten_id` bigint UNSIGNED DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `instansis`
--

INSERT INTO `instansis` (`id`, `nama_instansi`, `kode_unit`, `kategori`, `provinsi_id`, `kabupaten_id`, `alamat`, `telepon`, `email`, `penanggung_jawab`, `created_at`, `updated_at`) VALUES
(1, 'Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL)', 'BBLKL-01', 'Balai / Laboratorium', 13, 417, 'Jl. Hasanudin No 123 Salatiga', '085196695758', 'bblkl.salatiga@kemkes.go.id', 'Kepala Balai BBLKL', '2026-10-06 18:51:59', '2026-10-06 19:03:24'),
(3, 'Kementerian Kesehatan RI', 'KEMKES-PST', 'Kementerian / Lembaga', 11, NULL, 'Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Jakarta', '(021) 5201590', 'kontak@kemkes.go.id', 'Direktorat Kesling', '2026-10-06 18:51:59', '2026-10-06 18:51:59'),
(4, 'DKK Semarang', 'DKK-01', 'Dinas Kesehatan', 13, 161, NULL, NULL, NULL, NULL, '2026-10-06 19:18:38', '2026-10-06 19:19:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kabupatens`
--

CREATE TABLE `kabupatens` (
  `id` bigint UNSIGNED NOT NULL,
  `provinsi_id` bigint UNSIGNED NOT NULL,
  `nama_kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kabupatens`
--

INSERT INTO `kabupatens` (`id`, `provinsi_id`, `nama_kabupaten`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aceh Selatan', 3.2798000, 97.2885000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(2, 1, 'Aceh Tenggara', 3.3768000, 97.8091000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(3, 1, 'Aceh Timur', 4.7932000, 97.7617000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(4, 1, 'Aceh Tengah', 4.5445000, 96.8522000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(5, 1, 'Aceh Barat', 4.1449000, 96.1527000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(6, 1, 'Aceh Besar', 5.3786000, 95.5303000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(7, 1, 'Pidie', 5.2346000, 95.9610000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(8, 1, 'Aceh Utara', 5.0117000, 97.1420000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(9, 1, 'Simeulue', 4.8695650, 97.2526040, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(10, 1, 'Aceh Singkil', 4.9362260, 96.1382530, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(11, 1, 'Bireuen', 4.5591890, 96.8159610, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(12, 1, 'Aceh Barat Daya', 4.9526390, 96.8346490, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(13, 1, 'Gayo Lues', 4.5001350, 96.3947620, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(14, 1, 'Aceh Jaya', 4.5847510, 97.2722060, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(15, 1, 'Nagan Raya', 5.2112010, 96.3699780, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(16, 1, 'Aceh Tamiang', 4.5464180, 96.7288410, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(17, 1, 'Bener Meriah', 4.8686880, 96.9665730, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(18, 1, 'Pidie Jaya', 4.7121470, 96.3402890, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(19, 2, 'Tapanuli Tengah', 1.7547300, 99.9237530, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(20, 2, 'Tapanuli Utara', 2.7447540, 99.5162430, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(21, 2, 'Tapanuli Selatan', 2.0004470, 99.4438580, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(22, 2, 'Nias', 2.1505960, 99.8261720, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(23, 2, 'Langkat', 2.3390490, 99.2096540, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(24, 2, 'Karo', 1.6174430, 99.6610000, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(25, 2, 'Deli Serdang', 2.6609500, 99.8758470, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(26, 2, 'Simalungun', 2.0702480, 99.3948870, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(27, 2, 'Asahan', 2.0012470, 99.8020350, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(28, 2, 'Labuhanbatu', 2.4756670, 99.3883880, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(29, 2, 'Dairi', 1.6361110, 99.3619450, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(30, 2, 'Toba', 2.4062560, 100.1318550, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(31, 2, 'Mandailing Natal', 2.1541770, 99.3929640, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(32, 2, 'Nias Selatan', 1.8876380, 99.6974210, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(33, 2, 'Pakpak Bharat', 2.4994290, 99.6162060, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(34, 2, 'Humbang Hasundutan', 1.8048860, 99.1202560, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(35, 2, 'Samosir', 2.0604460, 100.2040800, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(36, 2, 'Serdang Bedagai', 2.2259460, 99.4386920, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(37, 2, 'Batu Bara', 1.8453540, 99.5450970, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(38, 2, 'Padang Lawas Utara', 2.4028920, 99.8217510, '2026-10-06 18:37:48', '2026-10-06 19:29:16'),
(39, 2, 'Padang Lawas', 2.0709050, 99.0116350, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(40, 2, 'Labuhanbatu Selatan', 1.7318340, 100.0699000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(41, 2, 'Labuhanbatu Utara', 2.2630750, 99.5177470, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(42, 2, 'Nias Utara', 1.8876380, 99.3927730, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(43, 2, 'Nias Barat', 2.2162930, 99.9406440, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(44, 3, 'Pesisir Selatan', -0.5044480, 100.3250110, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(45, 3, 'Solok', -1.3319460, 101.0262510, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(46, 3, 'Sijunjung', -0.6013580, 100.8602780, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(47, 3, 'Tanah Datar', -0.8540470, 100.5430670, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(48, 3, 'Padang Pariaman', -0.8572150, 101.1905520, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(49, 3, 'Agam', -0.2982670, 100.5322550, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(50, 3, 'Lima Puluh Kota', -1.3550060, 100.6568300, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(51, 3, 'Pasaman', -0.6539040, 100.9290210, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(52, 3, 'Kepulauan Mentawai', -0.7046980, 100.5189300, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(53, 3, 'Dharmasraya', -1.0386970, 101.0632270, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(54, 3, 'Solok Selatan', -0.2304250, 100.8233630, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(55, 3, 'Pasaman Barat', -1.1854170, 100.3322540, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(56, 4, 'Kampar', 0.2998900, 101.8641750, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(57, 4, 'Indragiri Hulu', 0.4669000, 101.4896510, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(58, 4, 'Bengkalis', -0.0933160, 101.7602750, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(59, 4, 'Indragiri Hilir', 0.7111150, 102.0139750, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(60, 4, 'Pelalawan', 0.1569900, 101.0610050, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(61, 4, 'Rokan Hulu', 0.2183470, 101.8432240, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(62, 4, 'Rokan Hilir', 0.5508510, 101.6215750, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(63, 4, 'Siak', -0.0601130, 101.5337630, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(64, 4, 'Kuantan Singingi', 0.4885160, 102.2015620, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(65, 4, 'Kepulauan Meranti', 0.5088200, 101.0852180, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(66, 5, 'Kerinci', -1.7431750, 103.6858450, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(67, 5, 'Merangin', -1.3493230, 103.6864950, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(68, 5, 'Sarolangun', -1.8196700, 103.2677510, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(69, 5, 'Batanghari', -1.6986840, 104.1404850, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(70, 5, 'Muaro Jambi', -1.1103100, 103.2104240, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(71, 5, 'Tanjung Jabung Barat', -1.7595520, 103.5993930, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(72, 5, 'Tanjung Jabung Timur', -1.4277140, 103.8221380, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(73, 5, 'Bungo', -1.6101230, 103.2036200, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(74, 5, 'Tebo', -1.9546740, 104.0079320, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(75, 6, 'Ogan Komering Ulu', -2.6918340, 104.8570620, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(76, 6, 'Ogan Komering Ilir', -3.4384400, 104.8188360, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(77, 6, 'Muara Enim', -3.2725520, 105.1939090, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(78, 6, 'Lahat', -3.1098900, 104.5693470, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(79, 6, 'Musi Rawas', -3.8120590, 105.0533140, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(80, 6, 'Musi Banyuasin', -2.7606200, 105.2201630, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(81, 6, 'Banyuasin', -3.3707400, 104.7667140, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(82, 6, 'Ogan Komering Ulu Timur', -3.4227620, 105.1766360, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(83, 6, 'Ogan Komering Ulu Selatan', -2.9659770, 104.7416540, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(84, 6, 'Ogan Ilir', -3.8058330, 104.7536880, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(85, 6, 'Empat Lawang', -3.0044370, 105.4875920, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(86, 6, 'Penukal Abab Lematang Ilir', -3.2869710, 104.7609490, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(87, 6, 'Musi Rawas Utara', -3.5406080, 105.0773250, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(88, 7, 'Bengkulu Selatan', -3.1911840, 102.3998380, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(89, 7, 'Rejang Lebong', -3.9056690, 101.9361710, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(90, 7, 'Bengkulu Utara', -3.6053270, 103.0072580, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(91, 7, 'Kaur', -3.4717810, 102.2350190, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(92, 7, 'Seluma', -3.8475900, 102.3587540, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(93, 7, 'Muko-Muko', -3.2790900, 102.6096100, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(94, 7, 'Lebong', -3.6444150, 101.8154690, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(95, 7, 'Kepahiang', -3.9392000, 102.8882570, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(96, 7, 'Bengkulu Tengah', -3.4314030, 102.3122990, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(97, 8, 'Lampung Selatan', -4.7924120, 105.2650580, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(98, 8, 'Lampung Tengah', -4.4413100, 105.7973550, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(99, 8, 'Lampung Utara', -4.3430500, 104.9214800, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(100, 8, 'Lampung Barat', -5.1406290, 105.6599530, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(101, 8, 'Tulang Bawang', -4.4176310, 105.4606760, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(102, 8, 'Tanggamus', -4.6832570, 105.1553400, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(103, 8, 'Lampung Timur', -4.6595240, 105.8023550, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(104, 8, 'Way Kanan', -4.1284550, 105.1190840, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(105, 8, 'Pesawaran', -5.1790140, 105.2919400, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(106, 8, 'Pringsewu', -4.4672710, 105.5317610, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(107, 8, 'Mesuji', -4.5350530, 105.1243870, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(108, 8, 'Tulangbawang Barat', -4.8461230, 105.6834620, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(109, 8, 'Pesisir Barat', -4.0485850, 105.4068080, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(110, 9, 'Bangka', -3.2055360, 105.9936840, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(111, 9, 'Belitung', -2.7279780, 106.5974880, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(112, 9, 'Bangka Selatan', -2.5766850, 106.2156710, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(113, 9, 'Bangka Tengah', -3.1251260, 106.5116960, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(114, 9, 'Bangka Barat', -2.3109210, 106.7283110, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(115, 9, 'Belitung Timur', -2.9041070, 105.8016270, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(116, 10, 'Bintan', 3.8763890, 108.2825710, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(117, 10, 'Karimun', 4.1993680, 108.0459040, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(118, 10, 'Natuna', 3.5853380, 107.9861580, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(119, 10, 'Lingga', 4.1611860, 108.6281950, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(120, 10, 'Kepulauan Anambas', 4.1350960, 107.5119830, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(121, 11, 'Kepulauan Seribu', -5.6122000, 106.5622000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(122, 12, 'Bogor', -6.5971000, 106.8060000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(123, 12, 'Sukabumi', -6.9277000, 106.9300000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(124, 12, 'Cianjur', -6.8173000, 107.1427000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(125, 12, 'Bandung', -6.9175000, 107.6191000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(126, 12, 'Garut', -7.2279000, 107.9087000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(127, 12, 'Tasikmalaya', -7.3274000, 108.2207000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(128, 12, 'Ciamis', -7.3262000, 108.3533000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(129, 12, 'Kuningan', -6.9765000, 108.4831000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(130, 12, 'Cirebon', -6.7320000, 108.5523000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(131, 12, 'Majalengka', -6.8361000, 108.2274000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(132, 12, 'Sumedang', -6.8587000, 107.9266000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(133, 12, 'Indramayu', -6.3264000, 108.3200000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(134, 12, 'Subang', -6.5716000, 107.7587000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(135, 12, 'Purwakarta', -6.5569000, 107.4433000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(136, 12, 'Karawang', -6.3042000, 107.3075000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(137, 12, 'Bekasi', -6.2383000, 106.9756000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(138, 12, 'Bandung Barat', -6.8439000, 107.5029000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(139, 12, 'Pangandaran', -7.6842000, 108.6508000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(140, 13, 'Cilacap', -7.7032000, 109.0159000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(141, 13, 'Banyumas', -7.5144000, 109.2943000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(142, 13, 'Purbalingga', -7.3651800, 110.3128430, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(143, 13, 'Banjarnegara', -6.7624590, 110.1759490, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(144, 13, 'Kebumen', -7.4955260, 109.7454470, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(145, 13, 'Purworejo', -7.1509750, 110.8017590, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(146, 13, 'Wonosobo', -7.0496360, 110.0241380, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(147, 13, 'Magelang', -7.4797000, 110.2177000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(148, 13, 'Boyolali', -6.8415670, 110.3895470, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(149, 13, 'Klaten', -7.2395360, 109.6128940, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(150, 13, 'Sukoharjo', -7.4894740, 110.6981620, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(151, 13, 'Wonogiri', -7.0060860, 110.0994950, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(152, 13, 'Karanganyar', -7.3904680, 110.0093530, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(153, 13, 'Sragen', -7.0175870, 110.5250630, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(154, 13, 'Grobogan', -6.9558060, 109.6455220, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(155, 13, 'Blora', -7.7219490, 110.4198210, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(156, 13, 'Rembang', -7.0079170, 110.1876200, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(157, 13, 'Pati', -6.7547000, 111.0382000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(158, 13, 'Kudus', -6.8048000, 110.8405000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(159, 13, 'Jepara', -6.5936000, 110.6778000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(160, 13, 'Demak', -7.7755850, 110.0539160, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(161, 13, 'Semarang', -6.9667000, 110.4167000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(162, 13, 'Temanggung', -7.1391980, 109.8570290, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(163, 13, 'Kendal', -7.4267470, 110.4298190, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(164, 13, 'Batang', -6.6414600, 110.1169010, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(165, 13, 'Pekalongan', -6.8886000, 109.6753000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(166, 13, 'Pemalang', -7.1313960, 110.2964120, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(167, 13, 'Tegal', -6.8694000, 109.1402000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(168, 13, 'Brebes', -7.5317300, 110.2288910, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(169, 14, 'Kulon Progo', -7.8286000, 110.1583000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(170, 14, 'Bantul', -7.8897000, 110.3297000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(171, 14, 'Gunungkidul', -7.9628000, 110.6042000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(172, 14, 'Sleman', -7.7167000, 110.3556000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(173, 15, 'Pacitan', -7.9025440, 112.0983450, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(174, 15, 'Ponorogo', -7.3005720, 112.7133960, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(175, 15, 'Trenggalek', -7.3730080, 111.5994420, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(176, 15, 'Tulungagung', -7.6625730, 112.3230270, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(177, 15, 'Blitar', -8.0954000, 112.1609000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(178, 15, 'Kediri', -7.8480000, 112.0178000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(179, 15, 'Malang', -7.9666000, 112.6326000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(180, 15, 'Lumajang', -7.0715790, 111.7914990, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(181, 15, 'Jember', -8.1724000, 113.6995000, '2026-10-06 18:37:48', '2026-10-06 19:29:17'),
(182, 15, 'Banyuwangi', -8.2192000, 114.3692000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(183, 15, 'Bondowoso', -7.5700550, 111.8304600, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(184, 15, 'Situbondo', -7.8465320, 112.6632430, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(185, 15, 'Probolinggo', -7.7543000, 113.2159000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(186, 15, 'Pasuruan', -7.6453000, 112.9075000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(187, 15, 'Sidoarjo', -7.4478000, 112.7183000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(188, 15, 'Mojokerto', -7.4726000, 112.4381000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(189, 15, 'Jombang', -8.0153070, 112.4215540, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(190, 15, 'Nganjuk', -6.9540200, 112.4915470, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(191, 15, 'Madiun', -7.6298000, 111.5239000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(192, 15, 'Magetan', -7.6172550, 112.5087810, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(193, 15, 'Ngawi', -7.1983140, 112.0336520, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(194, 15, 'Bojonegoro', -8.0339750, 112.1224990, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(195, 15, 'Tuban', -7.1747110, 112.7802710, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(196, 15, 'Lamongan', -7.5164850, 112.0822490, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(197, 15, 'Gresik', -7.1566000, 112.6555000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(198, 15, 'Bangkalan', -7.1464350, 112.2562640, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(199, 15, 'Sampang', -7.8966880, 111.8597460, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(200, 15, 'Pamekasan', -7.5085840, 112.8992720, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(201, 15, 'Sumenep', -7.4396460, 112.1177500, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(202, 16, 'Pandeglang', -6.6735070, 106.1010220, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(203, 16, 'Lebak', -6.0863480, 106.2988980, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(204, 16, 'Tangerang', -6.5162010, 105.5412110, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(205, 16, 'Serang', -6.7208170, 106.6368940, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(206, 17, 'Jembrana', -8.3079000, 114.6657000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(207, 17, 'Tabanan', -8.5385000, 115.1245000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(208, 17, 'Badung', -8.5819000, 115.1771000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(209, 17, 'Gianyar', -8.5434000, 115.3262000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(210, 17, 'Klungkung', -8.5358000, 115.4038000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(211, 17, 'Bangli', -8.4543000, 115.3549000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(212, 17, 'Karangasem', -8.4485000, 115.6128000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(213, 17, 'Buleleng', -8.2415000, 114.9701000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(214, 18, 'Lombok Barat', -8.2483230, 117.0356560, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(215, 18, 'Lombok Tengah', -9.2805360, 117.3039940, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(216, 18, 'Lombok Timur', -8.5515940, 117.4777690, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(217, 18, 'Sumbawa', -8.6529330, 117.0781480, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(218, 18, 'Dompu', -8.9164130, 117.6635630, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(219, 18, 'Bima', -8.1448740, 117.3149760, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(220, 18, 'Sumbawa Barat', -9.1527460, 116.9589520, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(221, 18, 'Lombok Utara', -8.6268860, 117.5167550, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(222, 19, 'Kupang', -8.5123110, 120.8402700, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(223, 19, 'Timor Tengah Selatan', -9.0340930, 121.1853570, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(224, 19, 'Timor Tengah Utara', -8.2050060, 121.3266370, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(225, 19, 'Belu', -8.8728550, 120.4577640, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(226, 19, 'Alor', -8.7147850, 121.2248820, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(227, 19, 'Flores Timur', -8.4126790, 120.9595590, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(228, 19, 'Sikka', -9.0293320, 120.9562320, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(229, 19, 'Ende', -8.4023820, 121.5431280, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(230, 19, 'Ngada', -8.5210250, 120.4335510, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(231, 19, 'Manggarai', -8.7802550, 121.1697090, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(232, 19, 'Sumba Timur', -8.3896920, 121.1163750, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(233, 19, 'Sumba Barat', -8.9080690, 120.7656760, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(234, 19, 'Lembata', -8.6796280, 121.6143610, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(235, 19, 'Rote Ndao', -8.2119050, 120.6116200, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(236, 19, 'Manggarai Barat', -8.8072390, 121.0862410, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(237, 19, 'Nagekeo', -8.4505500, 121.2616010, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(238, 19, 'Sumba Tengah', -8.7082870, 120.6733740, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(239, 19, 'Sumba Barat Daya', -8.9499060, 121.5180270, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(240, 19, 'Manggarai Timur', -8.0423160, 120.9361960, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(241, 19, 'Sabu Raijua', -8.7872860, 121.0006210, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(242, 19, 'Malaka', -8.5761910, 121.3497500, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(243, 20, 'Sambas', -0.1139600, 111.1041520, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(244, 20, 'Mempawah', -0.7499600, 111.6802120, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(245, 20, 'Sanggau', 0.3132250, 111.7015310, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(246, 20, 'Ketapang', -0.3480430, 111.3355810, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(247, 20, 'Sintang', -0.3486620, 111.7491250, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(248, 20, 'Kapuas Hulu', 0.0501420, 111.2552610, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(249, 20, 'Bengkayang', -0.7810330, 111.3822960, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(250, 20, 'Landak', 0.1047390, 112.0000880, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(251, 20, 'Sekadau', -0.2657080, 111.3183840, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(252, 20, 'Melawi', -0.4778460, 111.6668150, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(253, 20, 'Kayong Utara', 0.1112190, 111.4752850, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(254, 20, 'Kubu Raya', -0.6547920, 111.1135060, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(255, 21, 'Kotawaringin Barat', -1.6265800, 114.0413380, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(256, 21, 'Kotawaringin Timur', -1.5901740, 113.2574020, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(257, 21, 'Kapuas', -1.9473860, 113.4315840, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(258, 21, 'Barito Selatan', -1.3525650, 113.6023790, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(259, 21, 'Barito Utara', -1.8134860, 112.8651020, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(260, 21, 'Katingan', -1.9723900, 113.9691130, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(261, 21, 'Seruyan', -1.5405340, 113.3284870, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(262, 21, 'Sukamara', -1.9309350, 113.2738640, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(263, 21, 'Lamandau', -1.5166670, 113.7534880, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(264, 21, 'Gunung Mas', -1.5281280, 112.8716400, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(265, 21, 'Pulang Pisau', -2.2270840, 113.7131050, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(266, 21, 'Murung Raya', -1.5350440, 113.4164440, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(267, 21, 'Barito Timur', -1.8363540, 113.1501250, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(268, 22, 'Tanah Laut', -3.1435460, 115.6897560, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(269, 22, 'Kotabaru', -2.7019580, 114.9395460, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(270, 22, 'Banjar Baru', -3.7220410, 115.2549050, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(271, 22, 'Barito Kuala', -2.9865750, 115.3951280, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(272, 22, 'Tapin', -3.1044180, 115.0005290, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(273, 22, 'Hulu Sungai Selatan', -3.3433280, 115.5974540, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(274, 22, 'Hulu Sungai Tengah', -2.5870040, 115.2138620, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(275, 22, 'Hulu Sungai Utara', -3.6087070, 114.9043380, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(276, 22, 'Tabalong', -3.0601750, 115.4375260, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(277, 22, 'Tanah Bumbu', -2.9576410, 115.0382410, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(278, 22, 'Balangan', -3.4645910, 115.4068980, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(279, 23, 'Paser', 1.0008760, 116.6457010, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(280, 23, 'Kutai Kartanegara', 0.2975680, 115.8082430, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(281, 23, 'Berau', 0.4873560, 116.5673910, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(282, 23, 'Kutai Barat', 0.7781520, 116.2884830, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(283, 23, 'Kutai Timur', 0.1619480, 116.3134030, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(284, 23, 'Penajam Paser Utara', 0.8126820, 116.8710250, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(285, 23, 'Mahakam Ulu', 0.6480570, 115.7679390, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(286, 24, 'Bulungan', 2.9540900, 116.1372700, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(287, 24, 'Malinau', 3.3420660, 116.0660990, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(288, 24, 'Nunukan', 2.8096130, 115.7394750, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(289, 24, 'Tana Tidung', 3.0730930, 116.5768900, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(290, 25, 'Bolaang Mongondow', 1.0503150, 123.4872930, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(291, 25, 'Minahasa', 0.4752640, 123.9887290, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(292, 25, 'Kepulauan Sangihe', 0.8388980, 124.1475860, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(293, 25, 'Kepulauan Talaud', 0.5569700, 123.5717230, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(294, 25, 'Minahasa Selatan', 0.3506700, 124.4266380, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(295, 25, 'Minahasa Utara', 1.2332260, 123.8037930, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(296, 25, 'Minahasa Tenggara', 0.4916410, 123.9022770, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(297, 25, 'Bolaang Mongondow Utara', 0.7170380, 124.2414050, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(298, 25, 'Kepulauan Siau Tagulandang Biaro', 0.7739400, 123.5966730, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(299, 25, 'Bolaang Mongondow Timur', 0.1624760, 124.2013140, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(300, 25, 'Bolaang Mongondow Selatan', 1.2255350, 124.1739190, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(301, 26, 'Banggai', -1.5050250, 121.3092190, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(302, 26, 'Poso', -1.4884640, 121.7223980, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(303, 26, 'Donggala', -1.1105560, 121.2107380, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(304, 26, 'Toli-Toli', -1.9356620, 121.3757210, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(305, 26, 'Buol', -1.0250690, 121.9523560, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(306, 26, 'Morowali', -1.4234820, 121.2882680, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(307, 26, 'Banggai Kepulauan', -1.6209440, 121.6460830, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(308, 26, 'Parigi Moutong', -1.0403960, 121.4277560, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(309, 26, 'Tojo Una-Una', -1.8207080, 121.1014050, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(310, 26, 'Sigi', -1.3477930, 122.1014590, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(311, 26, 'Banggai Laut', -1.3439890, 121.3166020, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(312, 26, 'Morowali Utara', -1.6936250, 121.5069790, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(313, 27, 'Kepulauan Selayar', -3.3310490, 120.1788030, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(314, 27, 'Bulukumba', -3.8221590, 119.4633380, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(315, 27, 'Bantaeng', -3.9350490, 120.5735760, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(316, 27, 'Jeneponto', -3.5302170, 119.9137800, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(317, 27, 'Takalar', -3.9225160, 119.8770900, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(318, 27, 'Gowa', -3.4887170, 120.3372840, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(319, 27, 'Sinjai', -3.5368010, 119.4568000, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(320, 27, 'Bone', -4.2001360, 120.3294770, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(321, 27, 'Maros', -3.5210780, 120.0014030, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(322, 27, 'Pangkajene Kepulauan', -3.8331650, 119.7491370, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(323, 27, 'Barru', -3.7027900, 120.3819950, '2026-10-06 18:37:49', '2026-10-06 19:29:17'),
(324, 27, 'Soppeng', -3.2927880, 119.6122740, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(325, 27, 'Wajo', -4.2987990, 119.9740530, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(326, 27, 'Sidenreng Rappang', -3.5582070, 120.0804580, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(327, 27, 'Pinrang', -3.6923310, 119.6916320, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(328, 27, 'Enrekang', -3.9062160, 120.2989310, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(329, 27, 'Luwu', -3.1665470, 119.8810640, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(330, 27, 'Tana Toraja', -4.2001360, 119.6186290, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(331, 27, 'Luwu Utara', -3.6299760, 120.1261860, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(332, 27, 'Luwu Timur', -3.5441270, 119.7225850, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(333, 27, 'Toraja Utara', -4.0352790, 120.1141100, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(334, 28, 'Kolaka', -3.6737310, 122.3795320, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(335, 28, 'Konawe', -4.4111600, 121.5750820, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(336, 28, 'Muna', -4.1900160, 122.3248150, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(337, 28, 'Buton', -3.9110830, 122.0328550, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(338, 28, 'Konawe Selatan', -4.5256650, 122.0859730, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(339, 28, 'Bombana', -3.8523860, 122.6132610, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(340, 28, 'Wakatobi', -4.0626780, 121.5187640, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(341, 28, 'Kolaka Utara', -4.2598170, 122.2758440, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(342, 28, 'Konawe Utara', -3.8751670, 122.1869710, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(343, 28, 'Buton Utara', -4.4206820, 121.8850450, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(344, 28, 'Kolaka Timur', -4.1226640, 122.7095950, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(345, 28, 'Konawe Kepulauan', -3.7399540, 121.6678670, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(346, 28, 'Muna Barat', -4.2936270, 122.1951630, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(347, 28, 'Buton Tengah', -3.9237390, 122.3372140, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(348, 28, 'Buton Selatan', -4.2293210, 121.7748120, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(349, 29, 'Gorontalo', 0.5435000, 123.0568000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(350, 29, 'Boalemo', 0.6555000, 122.3374000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(351, 29, 'Bone Bolango', 0.5312000, 123.2384000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(352, 29, 'Pohuwato', 0.5186000, 121.7516000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(353, 29, 'Gorontalo Utara', 0.7712000, 122.8687000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(354, 30, 'Pasangkayu', -3.2965130, 119.4793440, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(355, 30, 'Mamuju', -2.2356040, 119.4032870, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(356, 30, 'Mamasa', -2.9247320, 119.0992440, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(357, 30, 'Majene', -2.8910220, 119.5112710, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(358, 30, 'Polewali Mandar', -2.5347290, 118.9827900, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(359, 30, 'Mamuju Tengah', -3.3521960, 119.1854060, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(360, 31, 'Maluku Tengah', -2.8128400, 130.6329820, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(361, 31, 'Maluku Tenggara', -3.2384620, 129.9877730, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(362, 31, 'Kepulauan Tanimbar', -3.4208710, 130.3542910, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(363, 31, 'Buru', -2.8499460, 130.1095830, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(364, 31, 'Seram Bagian Timur', -3.6430720, 129.8192810, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(365, 31, 'Seram Bagian Barat', -3.1290640, 130.7967230, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(366, 31, 'Kepulauan Aru', -3.1578670, 130.0124390, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(367, 31, 'Maluku Barat Daya', -3.4992620, 130.2186480, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(368, 31, 'Buru Selatan', -2.8925280, 130.3343590, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(369, 32, 'Halmahera Barat', 1.3965690, 127.3055640, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(370, 32, 'Halmahera Tengah', 1.3299080, 128.4199150, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(371, 32, 'Halmahera Utara', 1.7069450, 127.7422070, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(372, 32, 'Halmahera Selatan', 1.3134950, 127.7235190, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(373, 32, 'Kepulauan Sula', 1.7659990, 128.1634060, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(374, 32, 'Halmahera Timur', 1.6813830, 127.2859620, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(375, 32, 'Pulau Morotai', 1.0549330, 128.1881900, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(376, 32, 'Pulau Taliabu', 1.7197160, 127.8293270, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(377, 33, 'Merauke', -4.4434810, 137.8631790, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(378, 33, 'Jayawijaya', -4.2869400, 138.4894630, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(379, 33, 'Jayapura', -3.9093040, 137.7016970, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(380, 33, 'Nabire', -4.8993280, 138.1092070, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(381, 33, 'Kepulauan Yapen', -4.1550210, 138.1815920, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(382, 33, 'Biak Numfor', -4.3051700, 137.7992780, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(383, 33, 'Puncak Jaya', -4.4936230, 138.4157960, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(384, 33, 'Paniai', -3.7720170, 137.9644500, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(385, 33, 'Mimika', -4.8155240, 137.7496030, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(386, 33, 'Sarmi', -4.2248220, 138.2305630, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(387, 33, 'Keerom', -4.1558210, 137.8234150, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(388, 33, 'Pegunungan Bintang', -4.6302410, 138.2370620, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(389, 33, 'Yahukimo', -3.7906850, 138.2635050, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(390, 33, 'Tolikara', -4.5608300, 137.4935950, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(391, 33, 'Waropen', -4.3087510, 138.2324860, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(392, 33, 'Boven Digoel', -4.0422120, 137.9280290, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(393, 33, 'Mappi', -4.6540030, 138.0092440, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(394, 33, 'Asmat', -3.9594600, 138.5051940, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(395, 33, 'Supiori', -4.2150200, 137.4213700, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(396, 33, 'Mamberamo Raya', -4.3805200, 138.1867580, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(397, 33, 'Mamberamo Tengah', -3.9999280, 138.0803530, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(398, 33, 'Yalimo', -4.5574660, 137.8036990, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(399, 33, 'Lanny Jaya', -4.2254790, 138.6138150, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(400, 33, 'Nduga', -3.8864080, 137.5555500, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(401, 33, 'Puncak', -4.4176490, 138.1077030, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(402, 33, 'Dogiyai', -4.0422120, 138.2326770, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(403, 33, 'Intan Jaya', -4.3708670, 137.6848060, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(404, 33, 'Deiyai', -4.5054200, 138.5553470, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(405, 34, 'Sorong', -0.7441090, 132.9484700, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(406, 34, 'Manokwari', -1.4746970, 133.1144430, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(407, 34, 'Fak Fak', -1.2220080, 133.4316540, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(408, 34, 'Sorong Selatan', -1.2188400, 132.7841690, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(409, 34, 'Raja Ampat', -1.7777880, 133.4424660, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(410, 34, 'Teluk Bintuni', -0.7210490, 133.3178910, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(411, 34, 'Teluk Wondama', -1.4221510, 133.0457000, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(412, 34, 'Kaimana', -1.3713570, 133.4557910, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(413, 34, 'Tambrauw', -1.0373580, 132.9114940, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(414, 34, 'Maybrat', -1.8456300, 133.1513580, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(415, 34, 'Manokwari Selatan', -0.8906380, 133.6424670, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(416, 34, 'Pegunungan Arfak', -1.3426580, 133.0173660, '2026-10-06 18:37:49', '2026-10-06 19:29:18'),
(417, 13, 'Salatiga', -7.3245280, 110.3574330, '2026-10-06 19:03:10', '2026-10-06 19:29:18'),
(418, 28, 'Kendari', NULL, NULL, '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(419, 27, 'Makasar', NULL, NULL, '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(420, 5, 'Batang Hari', NULL, NULL, '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(421, 10, 'Tanjung Pinang', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(422, 4, 'Pekanbaru', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(423, 14, 'Yogyakarta', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(424, 26, 'Palu', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(425, 2, 'Medan', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(426, 22, 'Banjarmasin Utara', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(427, 15, 'Surabaya', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(428, 11, 'Jakarta Timur', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(429, 25, 'Manado', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(430, 23, 'Kutai Kertanegara', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(431, 31, 'Ambon', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06'),
(432, 12, 'Depok', NULL, NULL, '2026-10-11 02:42:06', '2026-10-11 02:42:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_ujis`
--

CREATE TABLE `kategori_ujis` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` enum('nyamuk','insektisida','metode') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_ujis`
--

INSERT INTO `kategori_ujis` (`id`, `kategori`, `nama`, `keterangan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'nyamuk', 'Ae. aegypti', 'Vektor utama demam berdarah dengue (DBD)', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(2, 'nyamuk', 'Culex sp', 'Vektor filariasis dan ensefalitis jepang', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(3, 'nyamuk', 'Anhopheles', 'Vektor penular malaria', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(4, 'nyamuk', 'Aedes sp', 'Vektor arbovirus umum', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(5, 'nyamuk', 'An. Farauti', 'Vektor malaria wilayah pesisir/kepulauan', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(6, 'nyamuk', 'An. Vagus', 'Spesies vektor malaria sekunder', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(7, 'nyamuk', 'An. tessellatus', 'Spesies nyamuk anopheles', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(8, 'nyamuk', 'An. sundaicus s.I', 'Vektor malaria air payau/pesisir', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(9, 'nyamuk', 'An. punctulatus s.I.', 'Vektor malaria di wilayah timur', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(10, 'nyamuk', 'An. peditaeniatus', 'Spesies nyamuk vektor', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(11, 'nyamuk', 'An. parensis', 'Spesies nyamuk anopheles', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(12, 'nyamuk', 'An. letifer', 'Vektor malaria dataran rendah/hutan', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(13, 'nyamuk', 'An. koliensis', 'Vektor malaria regional', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(14, 'nyamuk', 'An. kochi', 'Spesies anopheles area perbukitan', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(15, 'nyamuk', 'An. indefinitus', 'Spesies nyamuk vektor', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(16, 'nyamuk', 'An. hyrcanus s.I.', 'Kelompok spesies hyrcanus', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(17, 'nyamuk', 'An. farauti s.s', 'Vektor malaria pesisir timur', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(18, 'nyamuk', 'An. barbirostris', 'Vektor malaria dan filariasis', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(19, 'nyamuk', 'An. aconitus', 'Vektor malaria sawah dataran rendah', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(20, 'nyamuk', 'An. Albopictus', 'Vektor sekunder DBD dan chikungunya', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(21, 'insektisida', 'Cypermethrin', 'Piretroid sintetik spektrum luas', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(22, 'insektisida', 'Lamdacyhalothrin', 'Piretroid sintetik efektif residu tinggi', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(23, 'insektisida', 'Deltamethrin', 'Piretroid sintetik untuk kelambu dan IRS', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(24, 'insektisida', 'Alphacypermethrin', 'Isomer aktif sipermetrin', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(25, 'insektisida', 'Cyfluthrin', 'Insektisida piretroid untuk pengendalian vektor', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(26, 'insektisida', 'Permethrin', 'Piretroid umum untuk pencelupan kelambu', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(27, 'insektisida', 'Malathion', 'Organofosfat untuk pengasapan (fogging)', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(28, 'insektisida', 'Deltamethrin 0,025%', 'Formulasi standar kertas uji WHO', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(29, 'insektisida', 'Lambda-cyhalothrin 0,0025%', 'Formulasi dosis diagnostik', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(30, 'insektisida', 'Temefos (Abate)', 'Larvasida organofosfat untuk air bersih', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(31, 'insektisida', 'Bendiocarb', 'Karbamat untuk penyemprotan dinding (IRS)', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(32, 'insektisida', 'Sipermethrin', 'Formulasi varian sipermetrin', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(33, 'metode', 'Sequencing', 'Deteksi mutasi genetik resistensi (kdr)', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(34, 'metode', 'WHO Tube Bioassay', 'Uji kerentanan standar WHO menggunakan tabung uji', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(35, 'metode', 'WHO larval bioassay', 'Bioassay larva standar WHO untuk larvasida', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(36, 'metode', 'WHO susceptibilitity test', 'Protokol diagnostik kerentanan vektor WHO', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(37, 'metode', 'WHO test kit_adults', 'Paket uji standar WHO untuk nyamuk dewasa', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(38, 'metode', 'CDC bottle_adults', 'Bioassay botol CDC untuk nyamuk dewasa', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(39, 'metode', 'CDC bottle bioassay', 'Protokol uji resistensi botol CDC diagnostik waktu', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02'),
(40, 'metode', 'WHO standards bioassay', 'Bioassay acuan standar laboratorium WHO', 1, '2026-10-06 20:36:02', '2026-10-06 20:36:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_10_02_042253_create_provinsis_table', 1),
(6, '2026_10_02_042405_create_kabupatens_table', 1),
(7, '2026_10_02_042603_create_data_uji_resistensis_table', 1),
(8, '2026_10_03_154503_add_bulan_tahun_to_data_uji_resistensis_table', 1),
(9, '2026_10_05_064035_hapus_bulan_tahun_dari_data_uji_resistensis', 1),
(10, '2026_10_05_070843_hapus_sampel_dari_data_uji_resistensis', 1),
(11, '2026_10_05_071004_hapus_sampel_dan_rekap_dari_data_uji_resistensis', 1),
(12, '2026_10_05_072912_tambah_koordinat_ke_kabupaten', 1),
(13, '2026_10_06_020741_create_delete_requests_table', 1),
(14, '2026_10_06_044112_add_bulan_tahun_to_data_uji_resistensis_table', 1),
(15, '2026_10_07_015109_create_instansis_table', 2),
(16, '2026_10_07_021151_add_alamat_to_data_uji_resistensis_table', 3),
(17, '2026_10_07_033500_create_kategori_ujis_table', 4),
(18, '2026_10_07_044200_add_status_to_data_uji_resistensis_table', 5),
(19, '2026_10_07_053307_add_columns_to_users_table', 6),
(20, '2026_10_11_164500_add_mutasi_and_publikasi_to_data_uji_resistensis_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinsis`
--

CREATE TABLE `provinsis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `provinsis`
--

INSERT INTO `provinsis` (`id`, `nama_provinsi`, `created_at`, `updated_at`) VALUES
(1, 'Aceh', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(2, 'Sumatera Utara', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(3, 'Sumatera Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(4, 'Riau', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(5, 'Jambi', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(6, 'Sumatera Selatan', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(7, 'Bengkulu', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(8, 'Lampung', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(9, 'Kepulauan Bangka Belitung', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(10, 'Kepulauan Riau', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(11, 'DKI Jakarta', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(12, 'Jawa Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(13, 'Jawa Tengah', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(14, 'DI Yogyakarta', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(15, 'Jawa Timur', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(16, 'Banten', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(17, 'Bali', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(18, 'Nusa Tenggara Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(19, 'Nusa Tenggara Timur', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(20, 'Kalimantan Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(21, 'Kalimantan Tengah', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(22, 'Kalimantan Selatan', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(23, 'Kalimantan Timur', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(24, 'Kalimantan Utara', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(25, 'Sulawesi Utara', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(26, 'Sulawesi Tengah', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(27, 'Sulawesi Selatan', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(28, 'Sulawesi Tenggara', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(29, 'Gorontalo', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(30, 'Sulawesi Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(31, 'Maluku', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(32, 'Maluku Utara', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(33, 'Papua', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(34, 'Papua Barat', '2026-10-06 18:37:48', '2026-10-06 18:37:48'),
(35, 'Papua Tengah', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(36, 'Papua Selatan', '2026-10-11 02:42:05', '2026-10-11 02:42:05'),
(37, 'Papua Barat Daya', '2026-10-11 02:42:06', '2026-10-11 02:42:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `telepon` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `status`, `telepon`, `remember_token`, `last_login_at`, `last_login_ip`, `created_at`, `updated_at`) VALUES
(1, 'Administrator BBLKL', 'admin', 'admin@bblkl.go.id', NULL, '$2y$10$2EUnKoNwv2NsH6XE3zzAf.3.KnMhYlHkJh1TgwB2aWSUFqCb6p.bC', 'admin', 'aktif', '081234567890', NULL, '2026-10-11 02:35:05', '127.0.0.1', '2026-10-06 22:34:19', '2026-10-11 02:35:05'),
(2, 'Petugas Laboratorium Vektor', 'petugas', 'petugas@bblkl.go.id', NULL, '$2y$10$qYZYE9ZrKxs/Hpu8Dscpueu3Iup1BveTdYotxRxIaEtDundi9lqTi', 'petugas', 'aktif', '081234567891', NULL, '2026-10-07 18:04:17', '127.0.0.1', '2026-10-06 22:34:19', '2026-10-07 18:04:17');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `data_uji_resistensis`
--
ALTER TABLE `data_uji_resistensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_uji_resistensis_provinsi_id_foreign` (`provinsi_id`),
  ADD KEY `data_uji_resistensis_kabupaten_id_foreign` (`kabupaten_id`);

--
-- Indeks untuk tabel `delete_requests`
--
ALTER TABLE `delete_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delete_requests_data_uji_resistensi_id_foreign` (`data_uji_resistensi_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `instansis`
--
ALTER TABLE `instansis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instansis_provinsi_id_foreign` (`provinsi_id`),
  ADD KEY `instansis_kabupaten_id_foreign` (`kabupaten_id`);

--
-- Indeks untuk tabel `kabupatens`
--
ALTER TABLE `kabupatens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kabupatens_provinsi_id_nama_kabupaten_unique` (`provinsi_id`,`nama_kabupaten`);

--
-- Indeks untuk tabel `kategori_ujis`
--
ALTER TABLE `kategori_ujis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `provinsis`
--
ALTER TABLE `provinsis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_uji_resistensis`
--
ALTER TABLE `data_uji_resistensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT untuk tabel `delete_requests`
--
ALTER TABLE `delete_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `instansis`
--
ALTER TABLE `instansis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kabupatens`
--
ALTER TABLE `kabupatens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT untuk tabel `kategori_ujis`
--
ALTER TABLE `kategori_ujis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `provinsis`
--
ALTER TABLE `provinsis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_uji_resistensis`
--
ALTER TABLE `data_uji_resistensis`
  ADD CONSTRAINT `data_uji_resistensis_kabupaten_id_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupatens` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `data_uji_resistensis_provinsi_id_foreign` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsis` (`id`) ON DELETE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `delete_requests`
--
ALTER TABLE `delete_requests`
  ADD CONSTRAINT `delete_requests_data_uji_resistensi_id_foreign` FOREIGN KEY (`data_uji_resistensi_id`) REFERENCES `data_uji_resistensis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `instansis`
--
ALTER TABLE `instansis`
  ADD CONSTRAINT `instansis_kabupaten_id_foreign` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupatens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `instansis_provinsi_id_foreign` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kabupatens`
--
ALTER TABLE `kabupatens`
  ADD CONSTRAINT `kabupatens_provinsi_id_foreign` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
