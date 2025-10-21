-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 03:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensigps`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hadi admin', 'hadi@mail.com', '0000-00-00 00:00:00', '$2b$10$JfzA6kQ7OZ1GlK9iI/CjtOZweUWyR.7Csdwx4ctM/tIn8RaV1v8Au', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `kode_dept` char(5) NOT NULL,
  `nama_dept` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`kode_dept`, `nama_dept`) VALUES
('ENG', 'ENGINEERING'),
('IS', 'INFORMASI SISTEM'),
('LOG', 'LOGISTIK'),
('NFY', 'NYLON FILAMENT YARN'),
('PURC', 'PURCHESING');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_lokasi`
--

CREATE TABLE `konfigurasi_lokasi` (
  `id` int(11) NOT NULL,
  `lokasi_kantor` varchar(255) NOT NULL,
  `radius` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konfigurasi_lokasi`
--

INSERT INTO `konfigurasi_lokasi` (`id`, `lokasi_kantor`, `radius`) VALUES
(1, '-6.170984246980753,106.82988193399835', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_izin`
--

CREATE TABLE `pengajuan_izin` (
  `id` int(11) NOT NULL,
  `id_pkl` char(5) NOT NULL,
  `tgl_izin` date NOT NULL,
  `status` char(1) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_approved` char(1) NOT NULL DEFAULT '0',
  `tanda_bukti` varchar(255) DEFAULT NULL,
  `balasan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_izin`
--

INSERT INTO `pengajuan_izin` (`id`, `id_pkl`, `tgl_izin`, `status`, `keterangan`, `status_approved`, `tanda_bukti`, `balasan`) VALUES
(1, '11111', '2025-09-18', 'i', 'Acara Keluarga', '2', NULL, NULL),
(2, '11111', '2025-09-18', 'i', 'Acara Keluarga', '1', NULL, NULL),
(3, '11111', '2025-09-18', 'i', 'Acara Keluarga', '1', NULL, NULL),
(4, '54321', '2025-09-19', 'i', 'sakit wak', '1', NULL, NULL),
(5, '54321', '2025-09-19', 'i', 'acara', '1', NULL, ''),
(6, '54321', '2025-09-26', 's', 'sakit', '1', NULL, NULL),
(7, '54321', '2025-09-23', 'i', 'Kurang enak badan pak lagi skit', '1', NULL, NULL),
(8, '12345', '2025-09-22', 's', 'SAKIT KEPALA PAK JADI SAYA GA MASUK', '0', NULL, NULL),
(9, '12345', '2025-09-26', 'i', 'aesfas', '1', NULL, NULL),
(10, '12345', '2025-09-26', 's', 'sakit', '0', NULL, NULL),
(11, '12345', '2025-09-26', 'i', 'izin', '0', NULL, NULL),
(12, '12345', '2025-10-15', 'i', 'ingin makan', '2', NULL, NULL),
(13, '11111', '2025-10-16', 'i', 'ada acara di sekolah', '1', NULL, NULL),
(14, '11111', '2025-10-17', 'i', 'saya sakit', '0', NULL, NULL),
(16, '54321', '2025-10-02', 's', 'flue pak abis dari ujian makan', '2', NULL, 'Ah, Hadi, masalahmu sebenarnya bukan soal datanya sedikit atau banyak, tapi soal tinggi kontainer halaman. Saat konten sedikit, halaman otomatis pendek sehingga tidak ada scroll. Untuk membuat halaman tetap bisa di-scroll'),
(23, '54321', '2025-10-30', 'i', 'sadfasdf', '2', '54321-2025-10-30.png', 'ga jelas katanya sakit tapi fotonya tangggal kemarin haha kocak'),
(24, '54321', '2025-10-25', 's', 'gue sakit woeee', '1', '54321-2025-10-25.png', 'iyah cepet sembuh ya'),
(25, '54321', '2025-10-31', 'i', 'ada acara pemancingan', '0', NULL, NULL),
(27, '12224', '2025-10-20', 's', 'pusing', '0', NULL, NULL),
(28, '11111', '2025-10-21', 'i', 'mau ke sekolah', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_pkl` char(5) NOT NULL,
  `tgl_presensi` date DEFAULT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) DEFAULT NULL,
  `foto_out` varchar(255) DEFAULT NULL,
  `lokasi_in` text DEFAULT NULL,
  `lokasi_out` text DEFAULT NULL,
  `accept` char(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `id_pkl`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `accept`) VALUES
(46, '12345', '2025-08-31', '15:36:53', '15:37:43', '12345-2025-08-31-in.png', '12345-2025-08-31-out.png', '-6.2291968,106.807296', '-6.2291968,106.807296', '0'),
(47, '12345', '2025-09-02', '06:32:05', NULL, '12345-2025-09-02-in.png', NULL, '-6.2291968,106.807296', NULL, '0'),
(48, '12345', '2025-09-09', '21:01:41', NULL, '12345-2025-09-09-in.png', NULL, '-6.2291968,106.807296', NULL, '0'),
(49, '11111', '2025-09-09', '21:27:47', NULL, '11111-2025-09-09-in.png', NULL, '-6.2291968,106.807296', NULL, '0'),
(50, '12345', '2025-09-13', '13:47:20', '13:48:26', '12345-2025-09-13-in.png', '12345-2025-09-13-out.png', '-6.2291968,106.807296', '-6.2291968,106.807296', '0'),
(51, '11111', '2025-09-18', '20:21:46', '20:22:35', '11111-2025-09-18-in.png', '11111-2025-09-18-out.png', '-6.065245,106.542961', '-6.065245,106.542961', '0'),
(52, '54321', '2025-09-19', '22:14:28', '22:15:57', '54321-2025-09-19-in.png', '54321-2025-09-19-out.png', '-6.065663,106.542738', '-6.065663,106.542738', '0'),
(53, '12345', '2025-09-26', '22:25:02', NULL, '12345-2025-09-26-in.png', NULL, '-6.065663499999999,106.54273825000001', NULL, '0'),
(54, '12345', '2025-09-29', '11:01:33', '11:02:36', '12345-2025-09-29-in.png', '12345-2025-09-29-out.png', '-6.059094799303594,106.50602705207277', '-6.059075459688408,106.50596968450083', '0'),
(55, '11111', '2025-09-29', '12:09:18', '12:09:51', '11111-2025-09-29-in.png', '11111-2025-09-29-out.png', '-6.059052171018258,106.50592063799222', '-6.059065341862614,106.50596456211746', '0'),
(56, '12345', '2025-10-08', '22:51:59', '22:54:43', '12345-2025-10-08-in.png', '12345-2025-10-08-out.png', '-6.065566666666665,106.54278716666666', '-6.065663499999999,106.54273825000001', '0'),
(57, '11111', '2025-10-09', '06:13:29', '06:13:51', '11111-2025-10-09-in.png', '11111-2025-10-09-out.png', '-6.065663499999999,106.54273825000001', '-6.065663499999999,106.54273825000001', '2'),
(58, '12224', '2025-10-09', '06:19:15', '06:19:36', '12224-2025-10-09-in.png', '12224-2025-10-09-out.png', '-6.065524,106.5428125', '-6.065524,106.5428125', '0'),
(59, '54321', '2025-10-09', '06:20:37', '06:20:57', '54321-2025-10-09-in.png', '54321-2025-10-09-out.png', '-6.065663499999999,106.54273825000001', '-6.065663499999999,106.54273825000001', '0'),
(60, '11111', '2025-10-14', '21:24:49', NULL, '11111-2025-10-14-in.png', NULL, '-6.065663499999999,106.54273825000001', NULL, '0'),
(62, '54321', '2025-10-19', '19:18:26', '19:18:29', '54321-2025-10-19-in.png', '54321-2025-10-19-out.png', '-6.1773,106.843', '-6.1773,106.843', '2'),
(63, '43243', '2025-10-19', '19:22:16', '19:22:52', '43243-2025-10-19-in.png', '43243-2025-10-19-out.png', '-6.1773,106.843', '-6.1773,106.843', '1'),
(64, '11111', '2025-10-19', '23:18:59', '23:33:26', '11111-2025-10-19-in.png', '11111-2025-10-19-out.png', '-6.1773,106.843', '-6.1773,106.843', '1'),
(65, '12224', '2025-10-19', '23:40:39', '23:41:05', '12224-2025-10-19-in.png', '12224-2025-10-19-out.png', '-6.1773,106.843', '-6.1773,106.843', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_pkl` char(5) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `sekolah` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kode_dept` char(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_pkl`, `nama_lengkap`, `sekolah`, `no_hp`, `foto`, `kode_dept`, `password`, `remember_token`) VALUES
('11111', 'Hadi New', 'SMKN 5 KAB TANG', '0895360557765', NULL, 'NFY', '$2y$10$42gGxr2QmZe3YkxHUIMrDel9fgGKGNhEXofSUITCxe/6w.2EYqP2i', NULL),
('12224', 'indiati', 'ffsdsadga', 'dsfa', NULL, 'IS', '$2y$10$UxbWBJP7S7MhmndZmMHlLeWQjI/OgNgQI9FCuGRngDxajfDCL6yla', NULL),
('12345', 'HADI GANTENG', 'UNIV MAKASA', '0895360557765', NULL, 'ENG', '$2y$10$x89vaGICE6me2Nqp0P9dl.e.00oziqtFEjGHAi.ne4qnDCA2u92ci', NULL),
('43243', 'fasfas', 'fasdfsa', 'fasf', '43243.jpg', 'ENG', '$2y$10$MsywK66wCl3wquQ2mLdv/.tR3hkzKQhF.P5bRuNAvmW8sja7Xm5QO', NULL),
('54321', 'HADI PALING BARU', 'NPAM', '0895360557765', '54321.jpg', 'IS', '$2y$10$6uF0v9M4xEvGUyFMHcAkGeC2P1GSCg8Xm3jXQqBSzrprxX/cPR0pu', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`kode_dept`);

--
-- Indexes for table `konfigurasi_lokasi`
--
ALTER TABLE `konfigurasi_lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_pkl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konfigurasi_lokasi`
--
ALTER TABLE `konfigurasi_lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
