-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 11:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `aktifitas` text NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_pelaksanaan` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
  `kategori` int(11) NOT NULL,
  `idpelanggan` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idadmin` (`adminid`),
  KEY `idkategorijdwl` (`kategori`),
  KEY `idplgn` (`idpelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_jadwal`
--

DROP TABLE IF EXISTS `kategori_jadwal`;
CREATE TABLE IF NOT EXISTS `kategori_jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_komplain`
--

DROP TABLE IF EXISTS `kategori_komplain`;
CREATE TABLE IF NOT EXISTS `kategori_komplain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komplain`
--

DROP TABLE IF EXISTS `komplain`;
CREATE TABLE IF NOT EXISTS `komplain` (
  `idkomplain` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `komplain` varchar(500) NOT NULL,
  `solusi` text NOT NULL,
  `idkategori` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idkomplain`),
  KEY `kategori1` (`idkategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_records`
--

DROP TABLE IF EXISTS `kpi_records`;
CREATE TABLE IF NOT EXISTS `kpi_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `adminkpiid` (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT 1,
  `nama` text NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merk_produk`
--

DROP TABLE IF EXISTS `merk_produk`;
CREATE TABLE IF NOT EXISTS `merk_produk` (
  `id` int(11) NOT NULL,
  `merk` text DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

DROP TABLE IF EXISTS `metode_pembayaran`;
CREATE TABLE IF NOT EXISTS `metode_pembayaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_metode` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isi_notif` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `notifuserid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `idpelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `namapelanggan` varchar(100) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `telp` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `prioritas` text NOT NULL DEFAULT 'Basic',
  PRIMARY KEY (`idpelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE IF NOT EXISTS `produk` (
  `idproduk` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(50) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `tipe_item` varchar(10) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga_pokok` decimal(65,0) NOT NULL,
  `harga_jual` decimal(65,0) NOT NULL,
  `keterangan` varchar(1000) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idproduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `idtransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idpelanggan` int(11) NOT NULL,
  `idmetode` bigint(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `totaltransaksi` bigint(20) NOT NULL,
  `pesan` text DEFAULT NULL,
  PRIMARY KEY (`idtransaksi`),
  KEY `idpelanggan` (`idpelanggan`),
  KEY `transaksi_ibfk_3` (`idmetode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

DROP TABLE IF EXISTS `transaksi_detail`;
CREATE TABLE IF NOT EXISTS `transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtransaksi` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `totalharga` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksiid` (`idtransaksi`),
  KEY `produkid` (`idproduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `idadmin` FOREIGN KEY (`adminid`) REFERENCES `login` (`iduser`),
  ADD CONSTRAINT `idkategorijdwl` FOREIGN KEY (`kategori`) REFERENCES `kategori_jadwal` (`id`),
  ADD CONSTRAINT `idplgn` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`);

--
-- Constraints for table `komplain`
--
ALTER TABLE `komplain`
  ADD CONSTRAINT `kategori1` FOREIGN KEY (`idkategori`) REFERENCES `kategori_komplain` (`id`);

--
-- Constraints for table `kpi_records`
--
ALTER TABLE `kpi_records`
  ADD CONSTRAINT `adminkpiid` FOREIGN KEY (`adminid`) REFERENCES `login` (`iduser`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifuserid` FOREIGN KEY (`userid`) REFERENCES `login` (`iduser`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`idmetode`) REFERENCES `metode_pembayaran` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `produkid` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`),
  ADD CONSTRAINT `transaksiid` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`idtransaksi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
