-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 03, 2023 at 02:23 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pinjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `ask`
--

CREATE TABLE `ask` (
  `id_ask` int(11) NOT NULL,
  `nama_asker` varchar(64) NOT NULL,
  `judul_ask` varchar(64) NOT NULL,
  `isi_ask` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ask`
--

INSERT INTO `ask` (`id_ask`, `nama_asker`, `judul_ask`, `isi_ask`) VALUES
(6, 'Marzuki', 'Tidak punya WhatsApp', 'setelah mengajukan peminjaman, sistem mengarahkan ke whatsapp, bagaimana user yang tidak punya whatsapp min?');

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `id_help` int(11) NOT NULL,
  `judul` varchar(64) NOT NULL,
  `isi` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id_help`, `judul`, `isi`) VALUES
(1, 'Bagaimana cara mendaftar?', 'Dengan mengklik tombol \'mendaftar\' pada halaman login, kemudian tunggu hingga status pengguna diterima oleh Administrator'),
(2, 'Mengapa sistem menampilkan pesan user belum aktif?', 'Setelah selesai mendaftar harap menunggu konfirmasi dari Administrator untuk menerima anda sebagai pengguna baru');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_peminjaman` int(3) NOT NULL,
  `status_jadwal` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_peminjaman`, `status_jadwal`) VALUES
(1, 2, 3),
(2, 2, 3),
(3, 3, 3),
(4, 4, 3),
(5, 7, 3),
(6, 8, 3),
(7, 9, 3),
(8, 10, 3),
(9, 11, 3),
(11, 13, 3),
(12, 14, 3),
(13, 15, 3),
(14, 16, 3),
(15, 17, 3),
(16, 18, 3),
(17, 19, 3),
(18, 18, 3),
(19, 19, 1),
(20, 20, 3),
(21, 18, 3),
(22, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(4) NOT NULL,
  `id_user` int(3) NOT NULL,
  `id_perangkat` int(3) NOT NULL,
  `jam_mulai` time NOT NULL,
  `tgl` date NOT NULL,
  `jam_berakhir` time NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(32) NOT NULL,
  `status_peminjaman` int(1) NOT NULL,
  `denda` varchar(50) DEFAULT NULL,
  `ket_admin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_perangkat`, `jam_mulai`, `tgl`, `jam_berakhir`, `tanggal`, `keterangan`, `status_peminjaman`, `denda`, `ket_admin`) VALUES
(4, 3, 2, '11:47:00', '2023-09-16', '13:47:00', '2023-09-16', 'Seminar', 1, NULL, NULL),
(7, 3, 1, '13:10:00', '2023-09-16', '15:10:00', '2023-09-17', 'Tugas', 2, NULL, NULL),
(9, 3, 1, '13:24:00', '2023-09-16', '15:24:00', '2023-09-16', 'Tugas', 1, NULL, NULL),
(10, 3, 1, '13:35:00', '2023-09-16', '09:35:00', '2023-09-16', 'Tugas', 1, NULL, NULL),
(11, 21, 2, '13:38:00', '2023-09-16', '15:38:00', '2023-09-16', 'Tugas', 1, NULL, NULL),
(14, 3, 1, '13:54:00', '2023-09-16', '10:54:00', '2023-09-16', 'Tugas', 2, NULL, NULL),
(13, 3, 1, '13:50:00', '2023-09-16', '10:50:00', '2023-09-16', 'Tugas', 2, NULL, NULL),
(15, 3, 1, '13:55:00', '2023-09-16', '13:57:00', '2023-09-16', 'Tugas', 2, NULL, NULL),
(16, 3, 2, '14:01:00', '2023-09-16', '14:17:00', '2023-09-16', 'Tugas', 2, '100000', 'rusak'),
(17, 3, 2, '19:49:00', '2023-09-16', '19:52:00', '2023-09-16', 'Tugas', 1, NULL, NULL),
(18, 3, 2, '19:55:00', '2023-09-16', '21:55:00', '2023-09-16', 'Tugas', 2, NULL, NULL),
(20, 26, 1, '18:00:00', '2023-10-03', '20:57:00', '2023-10-03', 'Tugas', 2, NULL, NULL),
(22, 26, 1, '00:00:00', '2023-10-03', '00:00:00', '2023-10-07', 'Praktik', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_perangkat` int(1) NOT NULL,
  `perangkat` varchar(10) NOT NULL,
  `merk` varchar(25) NOT NULL,
  `stok` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status_perangkat` enum('Dipakai','Nganggur') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_perangkat`, `perangkat`, `merk`, `stok`, `image`, `status_perangkat`) VALUES
(1, 'Monitor', 'Acer', 17, '5e1382570d24e.png', 'Nganggur'),
(2, 'Mouse', 'logitech', 3, '5e14771323e46.png', 'Nganggur'),
(3, 'Keyboard', 'logitech', 0, '5e13825fac4bd.png', 'Nganggur');

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE `site` (
  `id_site` int(1) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`id_site`, `icon`, `logo`, `title`) VALUES
(1, '5e14758da49b31.png', '6505a6a8f3355.jpg', 'SISTEM PEMINJAMAN KOMPONEN KOMPUTER ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(3) NOT NULL,
  `nama_lengkap` varchar(32) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `level` enum('Admin','Peminjam') NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `bio`, `username`, `password`, `nip`, `no_telp`, `level`, `image`, `status`) VALUES
(1, 'Admin', 'Ini bio admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '11753101951', '82286062083', 'Admin', '5e139bcf64e1e.jpg', 1),
(3, 'Marzuki', '', 'marzuki', '7c222fb2927d828af22f592134e8932480637c0d', '11751019201', '', 'Peminjam', '', 1),
(21, 'Fahri Susaini', '', 'fahri', '5b18bb6641ef208740515238db03e90c0b68a521', '1175301941', '', 'Peminjam', '', 1),
(25, 'Nur Yulia Yeti', '', 'yulia', '4c0860f68178047c8bc26678dc37953bd57220f4', '11753101952', '', 'Peminjam', '', 1),
(23, 'Yosie Juniarti', '', 'yosie', 'ffdd66ef02126a5f7eaf0455eddaeb1fcc9f1d2a', '1182429372198421', '', 'Peminjam', '', 1),
(24, 'Darwin', '', 'darwin', '34dc8e1804c0a14aeb717e91af443219be617042', '11753101953', '', 'Peminjam', '', 1),
(26, 'Tes', '', 'tes', '7c222fb2927d828af22f592134e8932480637c0d', '1231231231', '', 'Peminjam', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ask`
--
ALTER TABLE `ask`
  ADD PRIMARY KEY (`id_ask`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`id_help`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_perangkat`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id_site`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ask`
--
ALTER TABLE `ask`
  MODIFY `id_ask` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `id_help` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_perangkat` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
  MODIFY `id_site` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
