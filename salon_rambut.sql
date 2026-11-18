-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2026 pada 06.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salon_rambut`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` bigint(20) UNSIGNED NOT NULL,
  `id_transaksi` bigint(20) UNSIGNED NOT NULL,
  `id_layanan` int(10) UNSIGNED NOT NULL,
  `harga_layanan` decimal(12,2) NOT NULL,
  `nama_layanan_snapshot` varchar(100) DEFAULT NULL,
  `kategori_snapshot` varchar(20) DEFAULT NULL,
  `durasi_snapshot` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_layanan`, `harga_layanan`, `nama_layanan_snapshot`, `kategori_snapshot`, `durasi_snapshot`) VALUES
(1, 1, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(2, 2, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(3, 3, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(4, 4, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(5, 5, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(6, 6, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(7, 7, 4, 120000.00, 'Coloring', 'Rambut', 120),
(8, 8, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(9, 9, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(10, 10, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(11, 11, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(12, 12, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(13, 13, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(14, 14, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(15, 15, 4, 120000.00, 'Coloring', 'Rambut', 120),
(16, 16, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(17, 17, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(18, 18, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(19, 19, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(20, 20, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(21, 21, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(22, 22, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(23, 23, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(24, 24, 4, 120000.00, 'Coloring', 'Rambut', 120),
(25, 25, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(26, 26, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(27, 27, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(28, 28, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(29, 29, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(30, 30, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(31, 31, 4, 120000.00, 'Coloring', 'Rambut', 120),
(32, 32, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(33, 33, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(34, 34, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(35, 35, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(36, 36, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(37, 37, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(38, 38, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(39, 39, 4, 120000.00, 'Coloring', 'Rambut', 120),
(40, 40, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(41, 41, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(42, 42, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(43, 43, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(44, 44, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(45, 45, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(46, 46, 4, 120000.00, 'Coloring', 'Rambut', 120),
(47, 47, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(48, 48, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(49, 49, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(50, 50, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(51, 51, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(52, 52, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(53, 53, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(54, 54, 4, 120000.00, 'Coloring', 'Rambut', 120),
(55, 55, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(56, 56, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(57, 57, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(58, 58, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(59, 59, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(60, 60, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(61, 61, 4, 120000.00, 'Coloring', 'Rambut', 120),
(62, 62, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(63, 63, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(64, 64, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(65, 65, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(66, 66, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(67, 67, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(68, 68, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(69, 69, 4, 120000.00, 'Coloring', 'Rambut', 120),
(70, 70, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(71, 71, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(72, 72, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(73, 73, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(74, 74, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(75, 75, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(76, 76, 4, 120000.00, 'Coloring', 'Rambut', 120),
(77, 77, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(78, 78, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(79, 79, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(80, 80, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(81, 81, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(82, 82, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(83, 83, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(84, 84, 4, 120000.00, 'Coloring', 'Rambut', 120),
(85, 85, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(86, 86, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(87, 87, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(128, 88, 4, 120000.00, 'Coloring', 'Rambut', 120),
(129, 89, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(130, 90, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(131, 91, 4, 120000.00, 'Coloring', 'Rambut', 120),
(132, 92, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(133, 93, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(134, 94, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(135, 95, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(136, 96, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(137, 97, 4, 120000.00, 'Coloring', 'Rambut', 120),
(138, 98, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(139, 99, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(140, 100, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(141, 101, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(142, 102, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(143, 103, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(144, 104, 4, 120000.00, 'Coloring', 'Rambut', 120),
(145, 105, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(146, 106, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(147, 107, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(148, 108, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(149, 109, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(150, 110, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(151, 111, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(152, 112, 4, 120000.00, 'Coloring', 'Rambut', 120),
(153, 113, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(154, 114, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(155, 115, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(156, 116, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(157, 117, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(158, 118, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(159, 119, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(160, 120, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(161, 121, 4, 120000.00, 'Coloring', 'Rambut', 120),
(162, 122, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(163, 123, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(164, 124, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(165, 125, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(166, 126, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(167, 127, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(168, 128, 4, 120000.00, 'Coloring', 'Rambut', 120),
(169, 129, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(170, 130, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(171, 131, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(172, 132, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(173, 133, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(174, 134, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(175, 135, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(176, 136, 4, 120000.00, 'Coloring', 'Rambut', 120),
(177, 137, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(178, 138, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(179, 139, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(180, 140, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(181, 141, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(182, 142, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(183, 143, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(184, 144, 4, 120000.00, 'Coloring', 'Rambut', 120),
(185, 145, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(186, 146, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(187, 147, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(188, 148, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(189, 149, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(190, 150, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(191, 151, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(192, 152, 4, 120000.00, 'Coloring', 'Rambut', 120),
(193, 153, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(194, 154, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(195, 155, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(196, 156, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(197, 157, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(198, 158, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(199, 159, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(200, 160, 4, 120000.00, 'Coloring', 'Rambut', 120),
(201, 161, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(202, 162, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(203, 163, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(204, 164, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(205, 165, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(206, 166, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(207, 167, 6, 75000.00, 'Hair Mask', 'Perawatan', 60),
(208, 168, 4, 120000.00, 'Coloring', 'Rambut', 120),
(209, 169, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(210, 170, 1, 30000.00, 'Potong Rambut Pria', 'Rambut', 30),
(211, 171, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(212, 172, 2, 50000.00, 'Potong Rambut Wanita', 'Rambut', 45),
(213, 173, 7, 200000.00, 'Smoothing', 'Perawatan', 180),
(214, 174, 4, 120000.00, 'Coloring', 'Rambut', 120),
(215, 175, 5, 60000.00, 'Creambath', 'Perawatan', 60),
(216, 175, 6, 75000.00, 'Hair Mask', 'Perawatan', 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(10) UNSIGNED NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `kategori` enum('Rambut','Perawatan') NOT NULL,
  `durasi` int(10) UNSIGNED NOT NULL,
  `harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `kategori`, `durasi`, `harga`, `created_at`) VALUES
(1, 'Potong Rambut Pria', 'Rambut', 30, 30000.00, '2026-10-19 14:43:11'),
(2, 'Potong Rambut Wanita', 'Rambut', 45, 50000.00, '2026-10-19 14:43:11'),
(3, 'Hair Styling', 'Rambut', 45, 50000.00, '2026-10-19 14:43:11'),
(4, 'Coloring', 'Rambut', 120, 120000.00, '2026-10-19 14:43:11'),
(5, 'Creambath', 'Perawatan', 60, 60000.00, '2026-10-19 14:43:11'),
(6, 'Hair Mask', 'Perawatan', 60, 75000.00, '2026-10-19 14:43:11'),
(7, 'Smoothing', 'Perawatan', 180, 200000.00, '2026-10-19 14:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Admin Salon', 'admin', '$2y$12$4MXhb/MQu6oC1n8bim9tT.anSKxmEqIOZ6z2qt6aKk7j7dBRJIQ2K', '2026-10-19 14:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` bigint(20) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED NOT NULL,
  `no_transaksi` varchar(40) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `total_biaya` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pengguna`, `no_transaksi`, `tanggal_transaksi`, `nama_pelanggan`, `total_biaya`, `created_at`) VALUES
(1, 1, 'TRX-20260501-001', '2026-05-01 09:30:00', 'Budi Santoso', 30000.00, '2026-10-19 14:43:12'),
(2, 1, 'TRX-20260502-002', '2026-05-02 10:15:00', 'Siti Rahma', 60000.00, '2026-10-19 14:43:12'),
(3, 1, 'TRX-20260503-003', '2026-05-03 11:00:00', 'Andi Pratama', 50000.00, '2026-10-19 14:43:12'),
(4, 1, 'TRX-20260504-004', '2026-05-04 13:20:00', 'Dewi Lestari', 200000.00, '2026-10-19 14:43:12'),
(5, 1, 'TRX-20260505-005', '2026-05-05 14:00:00', 'Rian Hidayat', 30000.00, '2026-10-19 14:43:12'),
(6, 1, 'TRX-20260506-006', '2026-05-06 15:30:00', 'Maya Puspita', 75000.00, '2026-10-19 14:43:12'),
(7, 1, 'TRX-20260508-007', '2026-05-08 10:00:00', 'Joko Susilo', 120000.00, '2026-10-19 14:43:12'),
(8, 1, 'TRX-20260510-008', '2026-05-10 11:30:00', 'Fitri Handayani', 50000.00, '2026-10-19 14:43:12'),
(9, 1, 'TRX-20260512-009', '2026-05-12 13:00:00', 'Ahmad Fauzi', 30000.00, '2026-10-19 14:43:12'),
(10, 1, 'TRX-20260514-010', '2026-05-14 16:00:00', 'Siska Amelia', 60000.00, '2026-10-19 14:43:12'),
(11, 1, 'TRX-20260515-011', '2026-05-15 09:45:00', 'Doni Setiawan', 30000.00, '2026-10-19 14:43:12'),
(12, 1, 'TRX-20260518-012', '2026-05-18 11:15:00', 'Rina Marlina', 200000.00, '2026-10-19 14:43:12'),
(13, 1, 'TRX-20260520-013', '2026-05-20 14:30:00', 'Eko Prasetyo', 50000.00, '2026-10-19 14:43:12'),
(14, 1, 'TRX-20260522-014', '2026-05-22 15:00:00', 'Wahyudi', 30000.00, '2026-10-19 14:43:12'),
(15, 1, 'TRX-20260525-015', '2026-05-25 10:30:00', 'Sri Wahyuni', 120000.00, '2026-10-19 14:43:12'),
(16, 1, 'TRX-20260528-016', '2026-05-28 13:45:00', 'Arief Budiman', 75000.00, '2026-10-19 14:43:12'),
(17, 1, 'TRX-20260530-017', '2026-05-30 16:20:00', 'Mega Lestari', 50000.00, '2026-10-19 14:43:12'),
(18, 1, 'TRX-20260601-001', '2026-06-01 09:15:00', 'Hendra Wijaya', 30000.00, '2026-10-19 14:43:12'),
(19, 1, 'TRX-20260602-002', '2026-06-02 10:30:00', 'Ratna Sari', 60000.00, '2026-10-19 14:43:12'),
(20, 1, 'TRX-20260604-003', '2026-06-04 11:45:00', 'Agus Setiawan', 50000.00, '2026-10-19 14:43:12'),
(21, 1, 'TRX-20260605-004', '2026-06-05 13:00:00', 'Yuni Astuti', 200000.00, '2026-10-19 14:43:12'),
(22, 1, 'TRX-20260607-005', '2026-06-07 14:15:00', 'Bambang Pamungkas', 30000.00, '2026-10-19 14:43:12'),
(23, 1, 'TRX-20260609-006', '2026-06-09 15:30:00', 'Lestari Indah', 75000.00, '2026-10-19 14:43:12'),
(24, 1, 'TRX-20260611-007', '2026-06-11 10:00:00', 'Fajar Nugroho', 120000.00, '2026-10-19 14:43:12'),
(25, 1, 'TRX-20260613-008', '2026-06-13 11:20:00', 'Nining Widya', 50000.00, '2026-10-19 14:43:12'),
(26, 1, 'TRX-20260615-009', '2026-06-15 13:10:00', 'Gilang Ramadhan', 30000.00, '2026-10-19 14:43:12'),
(27, 1, 'TRX-20260618-010', '2026-06-18 14:40:00', 'Tika Pertiwi', 60000.00, '2026-10-19 14:43:12'),
(28, 1, 'TRX-20260620-011', '2026-06-20 09:30:00', 'Dedi Mulyadi', 30000.00, '2026-10-19 14:43:12'),
(29, 1, 'TRX-20260622-012', '2026-06-22 11:00:00', 'Siska Wulandari', 200000.00, '2026-10-19 14:43:12'),
(30, 1, 'TRX-20260625-013', '2026-06-25 13:30:00', 'Rahmat Hidayat', 50000.00, '2026-10-19 14:43:12'),
(31, 1, 'TRX-20260627-014', '2026-06-27 15:00:00', 'Indah Permata', 120000.00, '2026-10-19 14:43:12'),
(32, 1, 'TRX-20260629-015', '2026-06-29 16:15:00', 'Yoga Pratama', 75000.00, '2026-10-19 14:43:12'),
(33, 1, 'TRX-20260701-001', '2026-07-01 09:00:00', 'Zainal Arifin', 30000.00, '2026-10-19 14:43:12'),
(34, 1, 'TRX-20260703-002', '2026-07-03 10:20:00', 'Kartika Putri', 60000.00, '2026-10-19 14:43:12'),
(35, 1, 'TRX-20260705-003', '2026-07-05 11:15:00', 'Bayu Saputra', 50000.00, '2026-10-19 14:43:12'),
(36, 1, 'TRX-20260706-004', '2026-07-06 13:40:00', 'Anita Rahmawati', 200000.00, '2026-10-19 14:43:12'),
(37, 1, 'TRX-20260708-005', '2026-07-08 14:30:00', 'Dimas Anggara', 30000.00, '2026-10-19 14:43:12'),
(38, 1, 'TRX-20260710-006', '2026-07-10 15:20:00', 'Putri Diana', 75000.00, '2026-10-19 14:43:12'),
(39, 1, 'TRX-20260712-007', '2026-07-12 10:10:00', 'Reza Rahadian', 120000.00, '2026-10-19 14:43:12'),
(40, 1, 'TRX-20260715-008', '2026-07-15 11:30:00', 'Rini Sukaesih', 50000.00, '2026-10-19 14:43:12'),
(41, 1, 'TRX-20260718-009', '2026-07-18 13:20:00', 'Heri Susanto', 30000.00, '2026-10-19 14:43:12'),
(42, 1, 'TRX-20260720-010', '2026-07-20 14:50:00', 'Vina Panduwinata', 60000.00, '2026-10-19 14:43:12'),
(43, 1, 'TRX-20260722-011', '2026-07-22 09:40:00', 'Taufik Hidayat', 30000.00, '2026-10-19 14:43:12'),
(44, 1, 'TRX-20260724-012', '2026-07-24 11:15:00', 'Desi Ratnasari', 200000.00, '2026-10-19 14:43:12'),
(45, 1, 'TRX-20260726-013', '2026-07-26 13:30:00', 'Irfan Bachdim', 50000.00, '2026-10-19 14:43:12'),
(46, 1, 'TRX-20260728-014', '2026-07-28 15:00:00', 'Nia Ramadhani', 120000.00, '2026-10-19 14:43:12'),
(47, 1, 'TRX-20260730-015', '2026-07-30 16:30:00', 'Gading Marten', 75000.00, '2026-10-19 14:43:12'),
(48, 1, 'TRX-20260801-001', '2026-08-01 09:30:00', 'Raffi Ahmad', 30000.00, '2026-10-19 14:43:12'),
(49, 1, 'TRX-20260803-002', '2026-08-03 10:00:00', 'Nagita Slavina', 60000.00, '2026-10-19 14:43:12'),
(50, 1, 'TRX-20260805-003', '2026-08-05 11:20:00', 'Baim Wong', 50000.00, '2026-10-19 14:43:12'),
(51, 1, 'TRX-20260806-004', '2026-08-06 13:00:00', 'Paula Verhoeven', 200000.00, '2026-10-19 14:43:12'),
(52, 1, 'TRX-20260808-005', '2026-08-08 14:10:00', 'Deddy Corbuzier', 30000.00, '2026-10-19 14:43:12'),
(53, 1, 'TRX-20260810-006', '2026-08-10 15:30:00', 'Sabrina Chairunnisa', 75000.00, '2026-10-19 14:43:12'),
(54, 1, 'TRX-20260812-007', '2026-08-12 10:15:00', 'Andre Taulany', 120000.00, '2026-10-19 14:43:12'),
(55, 1, 'TRX-20260815-008', '2026-08-15 11:40:00', 'Sule Prikitiw', 50000.00, '2026-10-19 14:43:12'),
(56, 1, 'TRX-20260818-009', '2026-08-18 13:20:00', 'Marshel Widianto', 30000.00, '2026-10-19 14:43:12'),
(57, 1, 'TRX-20260820-010', '2026-08-20 14:50:00', 'Celine Evangelista', 60000.00, '2026-10-19 14:43:12'),
(58, 1, 'TRX-20260822-011', '2026-08-22 09:20:00', 'Ruben Onsu', 30000.00, '2026-10-19 14:43:12'),
(59, 1, 'TRX-20260824-012', '2026-08-24 11:00:00', 'Sarwendah', 200000.00, '2026-10-19 14:43:12'),
(60, 1, 'TRX-20260826-013', '2026-08-26 13:15:00', 'Ivan Gunawan', 50000.00, '2026-10-19 14:43:12'),
(61, 1, 'TRX-20260828-014', '2026-08-28 15:00:00', 'Ayu Ting Ting', 120000.00, '2026-10-19 14:43:12'),
(62, 1, 'TRX-20260830-015', '2026-08-30 16:30:00', 'Wendy Cagur', 75000.00, '2026-10-19 14:43:12'),
(63, 1, 'TRX-20260901-001', '2026-09-01 09:15:00', 'Gilang Dirga', 30000.00, '2026-10-19 14:43:12'),
(64, 1, 'TRX-20260903-002', '2026-09-03 10:30:00', 'Adiezty Fersa', 60000.00, '2026-10-19 14:43:12'),
(65, 1, 'TRX-20260905-003', '2026-09-05 11:45:00', 'Vincent Rompies', 50000.00, '2026-10-19 14:43:12'),
(66, 1, 'TRX-20260906-004', '2026-09-06 13:20:00', 'Desta Mahendra', 200000.00, '2026-10-19 14:43:12'),
(67, 1, 'TRX-20260908-005', '2026-09-08 14:00:00', 'Enzy Storia', 30000.00, '2026-10-19 14:43:12'),
(68, 1, 'TRX-20260910-006', '2026-09-10 15:15:00', 'Hesti Purwadinata', 75000.00, '2026-10-19 14:43:12'),
(69, 1, 'TRX-20260912-007', '2026-09-12 10:00:00', 'Boy William', 120000.00, '2026-10-19 14:43:12'),
(70, 1, 'TRX-20260915-008', '2026-09-15 11:30:00', 'Sheryl Sheinafia', 50000.00, '2026-10-19 14:43:12'),
(71, 1, 'TRX-20260918-009', '2026-09-18 13:10:00', 'Iqbaal Ramadhan', 30000.00, '2026-10-19 14:43:12'),
(72, 1, 'TRX-20260920-010', '2026-09-20 14:40:00', 'Vanesha Prescilla', 60000.00, '2026-10-19 14:43:12'),
(73, 1, 'TRX-20260922-011', '2026-09-22 09:30:00', 'Angga Yunanda', 30000.00, '2026-10-19 14:43:12'),
(74, 1, 'TRX-20260924-012', '2026-09-24 11:15:00', 'Shenina Cinnamon', 200000.00, '2026-10-19 14:43:12'),
(75, 1, 'TRX-20260926-013', '2026-09-26 13:30:00', 'Jefri Nichol', 50000.00, '2026-10-19 14:43:12'),
(76, 1, 'TRX-20260928-014', '2026-09-28 15:00:00', 'Caitlin Halderman', 120000.00, '2026-10-19 14:43:12'),
(77, 1, 'TRX-20260930-015', '2026-09-30 16:20:00', 'Bryan Domani', 75000.00, '2026-10-19 14:43:12'),
(78, 1, 'TRX-20261001-001', '2026-10-01 09:00:00', 'Mawar de Jongh', 30000.00, '2026-10-19 14:43:12'),
(79, 1, 'TRX-20261003-002', '2026-10-03 10:15:00', 'Arbani Yasiz', 60000.00, '2026-10-19 14:43:12'),
(80, 1, 'TRX-20261005-003', '2026-10-05 11:30:00', 'Yasamin Jasem', 50000.00, '2026-10-19 14:43:12'),
(81, 1, 'TRX-20261006-004', '2026-10-06 13:00:00', 'Baskara Mahendra', 200000.00, '2026-10-19 14:43:12'),
(82, 1, 'TRX-20261008-005', '2026-10-08 14:20:00', 'Sherina Munaf', 30000.00, '2026-10-19 14:43:12'),
(83, 1, 'TRX-20261010-006', '2026-10-10 15:10:00', 'Derby Romero', 75000.00, '2026-10-19 14:43:12'),
(84, 1, 'TRX-20261012-007', '2026-10-12 10:30:00', 'Reza Rahadian', 120000.00, '2026-10-19 14:43:12'),
(85, 1, 'TRX-20261014-008', '2026-10-14 11:45:00', 'Marsha Timothy', 50000.00, '2026-10-19 14:43:12'),
(86, 1, 'TRX-20261016-009', '2026-10-16 13:15:00', 'Vino G. Bastian', 30000.00, '2026-10-19 14:43:12'),
(87, 1, 'TRX-20261018-010', '2026-10-18 14:30:00', 'Pevita Pearce', 60000.00, '2026-10-19 14:43:12'),
(88, 1, 'TRX-20261020-103334-8353', '2026-10-20 10:33:34', 'asa', 120000.00, '2026-10-20 03:33:34'),
(89, 1, 'TRX-20260501-101', '2026-05-01 10:00:00', 'Citra Kirana', 50000.00, '2026-10-21 10:00:00'),
(90, 1, 'TRX-20260503-102', '2026-05-03 11:30:00', 'Rezky Aditya', 30000.00, '2026-10-21 10:00:00'),
(91, 1, 'TRX-20260505-103', '2026-05-05 13:00:00', 'Naysilla Mirdad', 120000.00, '2026-10-21 10:00:00'),
(92, 1, 'TRX-20260507-104', '2026-05-07 14:15:00', 'Dude Harlino', 60000.00, '2026-10-21 10:00:00'),
(93, 1, 'TRX-20260510-105', '2026-05-10 15:30:00', 'Alyssa Soebandono', 75000.00, '2026-10-21 10:00:00'),
(94, 1, 'TRX-20260512-106', '2026-05-12 10:20:00', 'Teuku Wisnu', 200000.00, '2026-10-21 10:00:00'),
(95, 1, 'TRX-20260515-107', '2026-05-15 11:00:00', 'Shireen Sungkar', 50000.00, '2026-10-21 10:00:00'),
(96, 1, 'TRX-20260518-108', '2026-05-18 13:40:00', 'Zaskia Sungkar', 30000.00, '2026-10-21 10:00:00'),
(97, 1, 'TRX-20260520-109', '2026-05-20 14:20:00', 'Irwansyah', 120000.00, '2026-10-21 10:00:00'),
(98, 1, 'TRX-20260522-110', '2026-05-22 16:00:00', 'Laudya Cynthia', 60000.00, '2026-10-21 10:00:00'),
(99, 1, 'TRX-20260525-111', '2026-05-25 09:30:00', 'Chico Jericho', 75000.00, '2026-10-21 10:00:00'),
(100, 1, 'TRX-20260528-112', '2026-05-28 11:15:00', 'Putri Marino', 200000.00, '2026-10-21 10:00:00'),
(101, 1, 'TRX-20260530-113', '2026-05-30 13:50:00', 'Reza Nangin', 50000.00, '2026-10-21 10:00:00'),
(102, 1, 'TRX-20260602-114', '2026-06-02 10:00:00', 'Jovial da Lopez', 30000.00, '2026-10-21 10:00:00'),
(103, 1, 'TRX-20260604-115', '2026-06-04 11:30:00', 'Andovi da Lopez', 60000.00, '2026-10-21 10:00:00'),
(104, 1, 'TRX-20260606-116', '2026-06-06 13:15:00', 'Gita Savitri', 120000.00, '2026-10-21 10:00:00'),
(105, 1, 'TRX-20260608-117', '2026-06-08 14:00:00', 'Paul Partohap', 50000.00, '2026-10-21 10:00:00'),
(106, 1, 'TRX-20260610-118', '2026-06-10 15:20:00', 'Jerome Polin', 30000.00, '2026-10-21 10:00:00'),
(107, 1, 'TRX-20260612-119', '2026-06-12 10:45:00', 'Waseda Boys', 75000.00, '2026-10-21 10:00:00'),
(108, 1, 'TRX-20260615-120', '2026-06-15 11:10:00', 'Felicya Angelista', 200000.00, '2026-10-21 10:00:00'),
(109, 1, 'TRX-20260618-121', '2026-06-18 13:30:00', 'Immanuel Caesar', 50000.00, '2026-10-21 10:00:00'),
(110, 1, 'TRX-20260620-122', '2026-06-20 14:50:00', 'Natasha Wilona', 60000.00, '2026-10-21 10:00:00'),
(111, 1, 'TRX-20260622-123', '2026-06-22 09:20:00', 'Verrell Bramasta', 30000.00, '2026-10-21 10:00:00'),
(112, 1, 'TRX-20260625-124', '2026-06-25 11:00:00', 'Rizky Billar', 120000.00, '2026-10-21 10:00:00'),
(113, 1, 'TRX-20260628-125', '2026-06-28 13:15:00', 'Lesti Kejora', 75000.00, '2026-10-21 10:00:00'),
(114, 1, 'TRX-20260630-126', '2026-06-30 15:40:00', 'Atta Halilintar', 50000.00, '2026-10-21 10:00:00'),
(115, 1, 'TRX-20260702-127', '2026-07-02 09:30:00', 'Aurelie Moeremans', 30000.00, '2026-10-21 10:00:00'),
(116, 1, 'TRX-20260704-128', '2026-07-04 10:15:00', 'Aurelia Hermansyah', 60000.00, '2026-10-21 10:00:00'),
(117, 1, 'TRX-20260706-129', '2026-07-06 11:45:00', 'Anang Hermansyah', 50000.00, '2026-10-21 10:00:00'),
(118, 1, 'TRX-20260708-130', '2026-07-08 13:20:00', 'Ashanty', 200000.00, '2026-10-21 10:00:00'),
(119, 1, 'TRX-20260710-131', '2026-07-10 14:00:00', 'Kris Dayanti', 30000.00, '2026-10-21 10:00:00'),
(120, 1, 'TRX-20260712-132', '2026-07-12 15:10:00', 'Raul Lemos', 75000.00, '2026-10-21 10:00:00'),
(121, 1, 'TRX-20260715-133', '2026-07-15 10:00:00', 'Thariq Halilintar', 120000.00, '2026-10-21 10:00:00'),
(122, 1, 'TRX-20260717-134', '2026-07-17 11:30:00', 'Aaliyah Massaid', 50000.00, '2026-10-21 10:00:00'),
(123, 1, 'TRX-20260719-135', '2026-07-19 13:00:00', 'El Rumi', 30000.00, '2026-10-21 10:00:00'),
(124, 1, 'TRX-20260722-136', '2026-07-22 14:20:00', 'Al Ghazali', 60000.00, '2026-10-21 10:00:00'),
(125, 1, 'TRX-20260725-137', '2026-07-25 15:45:00', 'Dul Jaelani', 30000.00, '2026-10-21 10:00:00'),
(126, 1, 'TRX-20260728-138', '2026-07-28 10:30:00', 'Tissa Biani', 200000.00, '2026-10-21 10:00:00'),
(127, 1, 'TRX-20260730-139', '2026-07-30 13:15:00', 'Syifa Hadju', 50000.00, '2026-10-21 10:00:00'),
(128, 1, 'TRX-20260802-140', '2026-08-02 09:15:00', 'Rizky Nazar', 120000.00, '2026-10-21 10:00:00'),
(129, 1, 'TRX-20260804-141', '2026-08-04 10:30:00', 'Megan Domani', 75000.00, '2026-10-21 10:00:00'),
(130, 1, 'TRX-20260806-142', '2026-08-06 11:00:00', 'Jerome Kurnia', 30000.00, '2026-10-21 10:00:00'),
(131, 1, 'TRX-20260808-143', '2026-08-08 13:20:00', 'Putri Marino', 60000.00, '2026-10-21 10:00:00'),
(132, 1, 'TRX-20260810-144', '2026-08-10 14:40:00', 'Angga Dwimas', 50000.00, '2026-10-21 10:00:00'),
(133, 1, 'TRX-20260812-145', '2026-08-12 15:30:00', 'Yasmin Napper', 200000.00, '2026-10-21 10:00:00'),
(134, 1, 'TRX-20260815-146', '2026-08-15 09:45:00', 'Giorgino Abraham', 30000.00, '2026-10-21 10:00:00'),
(135, 1, 'TRX-20260818-147', '2026-08-18 11:15:00', 'Cut Syifa', 75000.00, '2026-10-21 10:00:00'),
(136, 1, 'TRX-20260820-148', '2026-08-20 13:00:00', 'Rachquel Nesia', 120000.00, '2026-10-21 10:00:00'),
(137, 1, 'TRX-20260822-149', '2026-08-22 14:25:00', 'Fero Walandouw', 50000.00, '2026-10-21 10:00:00'),
(138, 1, 'TRX-20260825-150', '2026-08-25 15:00:00', 'Susan Sameh', 30000.00, '2026-10-21 10:00:00'),
(139, 1, 'TRX-20260828-151', '2026-08-28 10:10:00', 'Arifin Putra', 60000.00, '2026-10-21 10:00:00'),
(140, 1, 'TRX-20260830-152', '2026-08-30 11:30:00', 'Hannah Al Rashid', 50000.00, '2026-10-21 10:00:00'),
(141, 1, 'TRX-20260902-153', '2026-09-02 10:00:00', 'Abimana Aryasatya', 200000.00, '2026-10-21 10:00:00'),
(142, 1, 'TRX-20260904-154', '2026-09-04 11:15:00', 'Luna Maya', 30000.00, '2026-10-21 10:00:00'),
(143, 1, 'TRX-20260906-155', '2026-09-06 13:30:00', 'Maxime Bouttier', 75000.00, '2026-10-21 10:00:00'),
(144, 1, 'TRX-20260908-156', '2026-09-08 14:20:00', 'Dian Sastrowardoyo', 120000.00, '2026-10-21 10:00:00'),
(145, 1, 'TRX-20260910-157', '2026-09-10 15:00:00', 'Indraguna Sutowo', 50000.00, '2026-10-21 10:00:00'),
(146, 1, 'TRX-20260913-158', '2026-09-13 09:30:00', 'Nicholas Saputra', 30000.00, '2026-10-21 10:00:00'),
(147, 1, 'TRX-20260915-159', '2026-09-15 10:45:00', 'Ladya Cheryl', 60000.00, '2026-10-21 10:00:00'),
(148, 1, 'TRX-20260917-160', '2026-09-17 11:20:00', 'Reza Rahadian', 50000.00, '2026-10-21 10:00:00'),
(149, 1, 'TRX-20260920-161', '2026-09-20 13:10:00', 'Marsha Timothy', 200000.00, '2026-10-21 10:00:00'),
(150, 1, 'TRX-20260922-162', '2026-09-22 14:30:00', 'Vino G. Bastian', 30000.00, '2026-10-21 10:00:00'),
(151, 1, 'TRX-20260925-163', '2026-09-25 15:15:00', 'Tora Sudiro', 75000.00, '2026-10-21 10:00:00'),
(152, 1, 'TRX-20260928-164', '2026-09-28 10:00:00', 'Mieke Amalia', 120000.00, '2026-10-21 10:00:00'),
(153, 1, 'TRX-20260930-165', '2026-09-30 11:40:00', 'Ringgo Agus', 50000.00, '2026-10-21 10:00:00'),
(154, 1, 'TRX-20261001-166', '2026-10-01 09:00:00', 'Sabai Morscheck', 30000.00, '2026-10-21 10:00:00'),
(155, 1, 'TRX-20261002-167', '2026-10-02 10:15:00', 'Joe Taslim', 60000.00, '2026-10-21 10:00:00'),
(156, 1, 'TRX-20261003-168', '2026-10-03 11:30:00', 'Julie Estelle', 50000.00, '2026-10-21 10:00:00'),
(157, 1, 'TRX-20261004-169', '2026-10-04 13:00:00', 'Iko Uwais', 200000.00, '2026-10-21 10:00:00'),
(158, 1, 'TRX-20261005-170', '2026-10-05 14:10:00', 'Audy Item', 30000.00, '2026-10-21 10:00:00'),
(159, 1, 'TRX-20261006-171', '2026-10-06 15:20:00', 'Yayan Ruhian', 75000.00, '2026-10-21 10:00:00'),
(160, 1, 'TRX-20261007-172', '2026-10-07 10:00:00', 'Cecep Arif Rahman', 120000.00, '2026-10-21 10:00:00'),
(161, 1, 'TRX-20261008-173', '2026-10-08 11:00:00', 'Dwi Sasono', 50000.00, '2026-10-21 10:00:00'),
(162, 1, 'TRX-20261009-174', '2026-10-09 13:15:00', 'Widi Mulia', 30000.00, '2026-10-21 10:00:00'),
(163, 1, 'TRX-20261010-175', '2026-10-10 14:30:00', 'GAC Group', 60000.00, '2026-10-21 10:00:00'),
(164, 1, 'TRX-20261011-176', '2026-10-11 15:45:00', 'Raisa Andriana', 50000.00, '2026-10-21 10:00:00'),
(165, 1, 'TRX-20261012-177', '2026-10-12 09:30:00', 'Hamish Daud', 200000.00, '2026-10-21 10:00:00'),
(166, 1, 'TRX-20261013-178', '2026-10-13 10:45:00', 'Isyana Sarasvati', 30000.00, '2026-10-21 10:00:00'),
(167, 1, 'TRX-20261014-179', '2026-10-14 11:20:00', 'Rayhan Madran', 75000.00, '2026-10-21 10:00:00'),
(168, 1, 'TRX-20261015-180', '2026-10-15 13:00:00', 'Tulus', 120000.00, '2026-10-21 10:00:00'),
(169, 1, 'TRX-20261016-181', '2026-10-16 14:15:00', 'Judika', 50000.00, '2026-10-21 10:00:00'),
(170, 1, 'TRX-20261017-182', '2026-10-17 15:00:00', 'Duma Riris', 30000.00, '2026-10-21 10:00:00'),
(171, 1, 'TRX-20261018-183', '2026-10-18 10:10:00', 'Bunga Citra Lestari', 60000.00, '2026-10-21 10:00:00'),
(172, 1, 'TRX-20261019-184', '2026-10-19 11:30:00', 'Tiko Aryawardhana', 50000.00, '2026-10-21 10:00:00'),
(173, 1, 'TRX-20261020-185', '2026-10-20 13:40:00', 'Afgan Syahreza', 200000.00, '2026-10-21 10:00:00'),
(174, 1, 'TRX-20261021-186', '2026-10-21 09:15:00', 'Maudy Ayunda', 120000.00, '2026-10-21 10:00:00'),
(175, 1, 'TRX-20261021-111625-2695', '2026-10-21 11:16:25', 'imam', 135000.00, '2026-10-21 04:16:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `idx_detail_transaksi` (`id_transaksi`),
  ADD KEY `idx_detail_layanan` (`id_layanan`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`),
  ADD KEY `idx_layanan_kategori` (`kategori`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `no_transaksi` (`no_transaksi`),
  ADD KEY `idx_transaksi_tanggal` (`tanggal_transaksi`),
  ADD KEY `idx_transaksi_pelanggan` (`nama_pelanggan`),
  ADD KEY `fk_transaksi_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`),
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
