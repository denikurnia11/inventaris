-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2021 at 01:50 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris2`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jml_barang` int(11) NOT NULL,
  `tgl_perolehan` date NOT NULL,
  `harga` int(25) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama_barang`, `jml_barang`, `tgl_perolehan`, `harga`, `foto`, `deskripsi`) VALUES
(5, 1, 'Barang Ghaib', 2, '2021-11-22', 2400000, '1637559787_43e4dc4bbf1923ffd2fe.jpg', 'Barang ghaib, sulit dicari');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Peralatan');

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `id_peminjam` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_peminjam` varchar(255) NOT NULL,
  `nama_instansi` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `status` enum('pending','disetujui','ditolak','batal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`id_peminjam`, `id_user`, `nama_peminjam`, `nama_instansi`, `no_hp`, `status`) VALUES
(1, 1, 'Siti Napi\'ah', 'ULM', '08969876234', 'disetujui'),
(2, 2, 'Udin Gambut', 'Bajak Laut Topi Jerami', '089691786852', 'disetujui'),
(4, 2, 'Ujang', 'Bajak Laut Topi Jerami', '089691786852', 'batal'),
(5, 2, 'Ujang', 'Bajak Laut Topi Jerami', '089691786852', 'batal'),
(6, 2, 'Ujang', 'Bajak Laut Topi Jerami', '089691786852', 'batal'),
(7, 2, 'Ujang', 'Bajak Laut Topi Jerami', '0896917856852', 'pending'),
(8, 2, 'Udin Gambut', 'Bajak Laut Topi Jerami', '089691786242', 'batal'),
(9, 2, 'Udin Gambut', 'Bajak Laut Topi Jerami', '0896917856852', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_barang`
--

CREATE TABLE `peminjaman_barang` (
  `id_peminjaman` int(11) NOT NULL,
  `id_peminjam` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jml_barang` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `tgl_permohonan` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `keperluan` varchar(255) NOT NULL,
  `status` enum('pending','dipinjam','selesai','batal') NOT NULL,
  `surat_peminjaman` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman_barang`
--

INSERT INTO `peminjaman_barang` (`id_peminjaman`, `id_peminjam`, `id_barang`, `jml_barang`, `tgl_pinjam`, `tgl_kembali`, `tgl_permohonan`, `tgl_selesai`, `keperluan`, `status`, `surat_peminjaman`) VALUES
(2, 4, 5, 2, '2021-12-01', '2021-12-06', '2021-12-01', NULL, 'Minjem doang bentaran', 'batal', '1638345125_9c6b4670bd12a8079a51.pdf'),
(3, 5, 5, 2, '2021-12-01', '2021-12-15', '2021-12-01', NULL, 'Minjem doang bentaran', 'batal', '1638345887_7fbf90dfd1f816baa596.pdf'),
(4, 6, 5, 2, '2021-12-01', '2021-12-09', '2021-12-01', NULL, 'Minjem doang bentaran', 'batal', '1638346524_8ec7bed03cadeb890f7c.pdf'),
(5, 7, 5, 2, '2021-12-01', '2021-12-08', '2021-12-01', NULL, 'Minjem doang bentaran', 'pending', '1638346668_85ff5df533e2d6fc61ae.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_ruang`
--

CREATE TABLE `peminjaman_ruang` (
  `id_peminjaman` int(11) NOT NULL,
  `id_peminjam` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `tgl_permohonan` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `keperluan` varchar(255) NOT NULL,
  `status` enum('pending','dipinjam','selesai','batal') NOT NULL,
  `surat_peminjaman` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman_ruang`
--

INSERT INTO `peminjaman_ruang` (`id_peminjaman`, `id_peminjam`, `id_ruangan`, `tgl_pinjam`, `tgl_kembali`, `tgl_permohonan`, `tgl_selesai`, `keperluan`, `status`, `surat_peminjaman`) VALUES
(1, 1, 1, '2021-11-24', '2021-11-27', '2021-11-23', '2021-11-27', 'Minjem doang bentaran', 'selesai', 'surat_palsu.pdf'),
(2, 2, 1, '2021-11-29', '2021-12-03', '2021-11-27', '2021-11-28', 'Minjem doang bentaran', 'selesai', '1638060945_ec346a10ee4f1fc928c3.pdf'),
(3, 8, 1, '2021-12-01', '2021-12-09', '2021-12-01', NULL, 'Minjem doang bentaran', 'batal', '1638348916_bd95580f83c2e5f248fc.pdf'),
(4, 9, 1, '2021-12-01', '2021-12-15', '2021-12-01', '2021-12-01', 'Minjem doang bentaran', 'selesai', '1638349008_85c33df20e4fcdc7a475.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `status` enum('tersedia','tidak tersedia','','') NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas`, `status`, `deskripsi`) VALUES
(1, 'Ruang Umum', 100, 'tersedia', 'Ruang normal untuk umum');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `email`, `username`, `password`, `role`) VALUES
(1, 'Siti Napi\'ah', 'sitinapiah06@gmail.com', 'sitina123', 'd164b39e9ec43f65376629da9ccf41780775f656', 'admin'),
(2, 'Dwa Meizadewa', 'infamous0192@gmail.com', 'infamous0192', 'd164b39e9ec43f65376629da9ccf41780775f656', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `barang_ibfk_1` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`id_peminjam`),
  ADD KEY `peminjam_ibfk_1` (`id_user`);

--
-- Indexes for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_barang_ibfk_1` (`id_barang`),
  ADD KEY `peminjaman_barang_ibfk_2` (`id_peminjam`);

--
-- Indexes for table `peminjaman_ruang`
--
ALTER TABLE `peminjaman_ruang`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_ruang_ibfk_1` (`id_peminjam`),
  ADD KEY `peminjaman_ruang_ibfk_2` (`id_ruangan`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `id_peminjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman_ruang`
--
ALTER TABLE `peminjaman_ruang`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `peminjam_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  ADD CONSTRAINT `peminjaman_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_barang_ibfk_2` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjam` (`id_peminjam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman_ruang`
--
ALTER TABLE `peminjaman_ruang`
  ADD CONSTRAINT `peminjaman_ruang_ibfk_1` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjam` (`id_peminjam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ruang_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
