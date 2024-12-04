-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 04:45 AM
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
-- Database: `pajak_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `elektronik`
--

CREATE TABLE `elektronik` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL,
  `nama_pemakai` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `tanggal_pemeliharaan` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_pemeliharaan` varchar(255) DEFAULT NULL,
  `foto_barang` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `keterangan_kerusakan` varchar(100) DEFAULT NULL,
  `biaya_pemeliharaan` decimal(10,2) DEFAULT NULL,
  `harga_pembelian` decimal(15,2) DEFAULT NULL,
  `tahun_pembelian` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `bast` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elektronik`
--

INSERT INTO `elektronik` (`id`, `jenis_barang`, `nama_pemakai`, `no_telepon`, `merk`, `serial_number`, `kondisi`, `tanggal_pemeliharaan`, `keterangan`, `bukti_pemeliharaan`, `foto_barang`, `nama_barang`, `keterangan_kerusakan`, `biaya_pemeliharaan`, `harga_pembelian`, `tahun_pembelian`, `alamat`, `nip`, `bast`) VALUES
(13, 'drone', 'aaaa', '90909090', 'dji', '8s8s88s8', 'normal', NULL, NULL, NULL, NULL, 'drone dji', NULL, NULL, 220000.00, '2020', 'lalalalla', '9s99s9s', NULL),
(14, 'hshhshs', 'rrrr', 'jjjehhh', 'jsjhsh', 'eejjjj', 'normal', NULL, NULL, NULL, 'uploads/1733199477_foto_WhatsApp Image 2024-09-02 at 21.47.40_8c1592b9 1.png', 'eejjjj', NULL, NULL, 12000.00, '2020', 'dsfgssh', 'jjjjjj', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history_nopol`
--

CREATE TABLE `history_nopol` (
  `tanggal_perubahan` date NOT NULL DEFAULT current_timestamp(),
  `nopol` varchar(50) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `pemakai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_nopol`
--

INSERT INTO `history_nopol` (`tanggal_perubahan`, `nopol`, `id_kendaraan`, `pemakai`) VALUES
('2024-12-03', '00AA0000', 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history_pemakai`
--

CREATE TABLE `history_pemakai` (
  `id` int(11) NOT NULL,
  `pemakai_lama` varchar(255) DEFAULT NULL,
  `pemakai_baru` varchar(255) DEFAULT NULL,
  `tanggal_perubahan` datetime DEFAULT current_timestamp(),
  `user_perubah` varchar(255) DEFAULT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_pemakai`
--

INSERT INTO `history_pemakai` (`id`, `pemakai_lama`, `pemakai_baru`, `tanggal_perubahan`, `user_perubah`, `id_kendaraan`, `action`, `pengguna`) VALUES
(5, 'YANTOoa', NULL, '2024-12-03 12:35:30', NULL, 19, 'Update Pemakai', 'a'),
(6, 'YANTOoa', 'YA', '2024-12-03 12:37:37', NULL, 19, 'Update Pemakai', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `history_pemakai_elektronik`
--

CREATE TABLE `history_pemakai_elektronik` (
  `id` int(11) NOT NULL,
  `pemakai_lama` varchar(255) DEFAULT NULL,
  `pemakai_baru` varchar(255) DEFAULT NULL,
  `tanggal_perubahan` datetime DEFAULT current_timestamp(),
  `user_perubah` varchar(255) DEFAULT NULL,
  `id_elektronik` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `pengguna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_pemakai_elektronik`
--

INSERT INTO `history_pemakai_elektronik` (`id`, `pemakai_lama`, `pemakai_baru`, `tanggal_perubahan`, `user_perubah`, `id_elektronik`, `action`, `pengguna`) VALUES
(1, 'rob', 'robana', '2024-12-02 07:01:47', NULL, 11, 'Update Pemakai', 'a'),
(2, NULL, 'robana', '2024-12-03 11:09:01', NULL, 11, 'Update Pemakai', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `history_perbaikan_elektronik`
--

CREATE TABLE `history_perbaikan_elektronik` (
  `id_elektronik` int(11) NOT NULL,
  `kondisi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `biaya` decimal(15,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nip` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_perbaikan_elektronik`
--

INSERT INTO `history_perbaikan_elektronik` (`id_elektronik`, `kondisi`, `tanggal`, `biaya`, `keterangan`, `bukti_pembayaran`, `pengguna`, `created_at`, `nip`, `nama_barang`) VALUES
(11, 'uhouhuh', '2024-11-01', 20000.00, 'hhuuuuo', NULL, 'rob', '2024-12-01 21:47:12', NULL, NULL),
(11, 'uhouhuh', '2024-11-01', 20000.00, 'hhuuuuo', NULL, 'rob', '2024-12-01 21:48:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history_perbaikan_kendaraan`
--

CREATE TABLE `history_perbaikan_kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `kondisi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `biaya` decimal(15,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_kendaraan` varchar(50) DEFAULT NULL,
  `plat` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_perbaikan_kendaraan`
--

INSERT INTO `history_perbaikan_kendaraan` (`id_kendaraan`, `kondisi`, `tanggal`, `biaya`, `keterangan`, `bukti_pembayaran`, `pengguna`, `created_at`, `nama_kendaraan`, `plat`, `nip`) VALUES
(13, ';mamkak', '2024-11-30', 100.00, ';;kkaaa', NULL, 'deka', '2024-11-30 21:58:09', NULL, NULL, NULL),
(13, 'lmlkmlmlkmkl', '2024-11-30', 100.00, ';alalla', NULL, 'deka', '2024-11-30 22:02:13', NULL, NULL, NULL),
(13, 'kkkkjkjhhk', '2024-12-02', 100.00, '', NULL, 'dekaaaa', '2024-12-02 03:33:30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `pemakai` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `no_plat` varchar(10) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `tahun_pembuatan` int(11) DEFAULT NULL,
  `harga_pembelian` decimal(15,2) DEFAULT NULL,
  `tenggat_stnk` date DEFAULT NULL,
  `tenggat_nopol` date DEFAULT NULL,
  `foto_kendaraan` varchar(255) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_pemeliharaan` date DEFAULT NULL,
  `biaya_pemeliharaan` decimal(10,2) DEFAULT NULL,
  `kondisi` text DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status_pemeliharaan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `bast` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `tahun_pembelian` varchar(10) DEFAULT NULL,
  `foto_stnk` varchar(255) DEFAULT NULL,
  `foto_bpkb` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `pemakai`, `no_telepon`, `no_plat`, `merk`, `tipe`, `tahun_pembuatan`, `harga_pembelian`, `tenggat_stnk`, `tenggat_nopol`, `foto_kendaraan`, `bukti_pembayaran`, `tanggal_pemeliharaan`, `biaya_pemeliharaan`, `kondisi`, `bukti`, `status_pemeliharaan`, `keterangan`, `alamat`, `bast`, `nip`, `tahun_pembelian`, `foto_stnk`, `foto_bpkb`) VALUES
(19, 'YA', '987897', '999ss', '987987', 'Motor', 987987, 97987.00, '2024-01-01', '2024-01-01', 'uploads/1733199362_IMG_25r34.JPG', 'uploads/1730689944_bukti_Screenshot (35).png', '2024-11-28', 1000000.00, 'Mobil Mengalami Kebakaran', NULL, 'Normal', 'aaaaa', 'dgdhffjkfkfkf', 'uploads/1733199362_lamaran kerja_untuk_barista.pdf.pdf', '839300303', '2020', 'uploads/1733199362_IMG_2474.JPG', 'uploads/1733199362_IMG_2475.JPG'),
(20, 'hjbj', 'hjbwjhb', 'jhbsjhb', 'jhsbjhwb', 'Motor', 9878, 8798.00, '0000-00-00', '0888-08-07', 'uploads/1730689997_foto_Screenshot (36).png', 'uploads/1730689997_bukti_Screenshot (35).png', '2024-11-30', 10000.00, 'mususus', NULL, 'Normal', 'hahasss', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'jjjjj', '0987777', 'j67788jj', 'aaa', 'Motor', 2018, 876666.00, '0000-00-00', '2024-11-22', 'uploads/1730768645_foto_Screenshot (35).png', NULL, '2024-11-29', 222999.00, 'assaasjosa', NULL, 'Normal', 'snjasja', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'UUS', '09090909', '87s7s8', 'HND', 'Motor', 2022, 288882.00, '2010-12-11', '2024-12-25', NULL, NULL, '2024-12-01', NULL, 'sndlkasnkdas', NULL, 'Perbaikan', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'UUS', '09090909', '87s7s8', 'HND', 'Motor', 2022, 288882.00, '0000-00-00', '2024-12-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'kiis', '0802828', '778ss', 'KOBRA', 'Motor', 2011, 200002.00, '0000-00-00', '2016-12-06', NULL, NULL, NULL, NULL, NULL, NULL, 'Normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'suparjo', '88008080', '88UUBG', 'HONDA', 'Motor', 2020, 20000000.00, '2025-12-02', '2026-12-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dusun ngarogsari', NULL, '788887888', '0000-00-00', NULL, NULL),
(27, 'poo', '090909', '022', 'IISS', 'MOTOR', 2020, 99900.00, '2025-12-10', '2025-01-15', NULL, NULL, NULL, NULL, NULL, NULL, 'Normal', NULL, 'aaaaaa', NULL, '9901', '2011', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_histori`
--

CREATE TABLE `log_histori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_tabel` varchar(255) DEFAULT NULL,
  `id_data` int(11) DEFAULT NULL,
  `aksi` varchar(50) DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_histori`
--

INSERT INTO `log_histori` (`id`, `nama_tabel`, `id_data`, `aksi`, `data_lama`, `data_baru`, `pengguna`, `tanggal`) VALUES
(126, 'elektronik', 4, 'Tambah Data', NULL, 'nama peminjam = yanto\n no telepon = 098098\n merk laptop = sus\n serial number = 098\n kondisi = baik baik saja\n tanggal peminjaman = 2024-10-26\n tanggal pengembalian = 2024-10-27\n status peminjaman = Dipinjam', 'admin@gmail.com', '2024-10-26 08:44:17'),
(127, 'kendaraan', 15, 'Tambah Data', NULL, 'Pemakai = YANTO\nNo Telepon = 0989890\nMerk = mio\nNo Plat = 098098\nTipe = Motor\nTahun Pembuatan = 2009\nHarga Pembelian = 90898\nHarga Pajak = 9809\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-10-26 09:12:58'),
(128, 'kendaraan', 16, 'Tambah Data', NULL, 'Pemakai = anam\nNo Telepon = 0851562555\nMerk = supra\nNo Plat = h98877\nTipe = Motor\nTahun Pembuatan = 2010\nHarga Pembelian = 1670000\nHarga Pajak = 200000\nStatus Pajak = Belum Lunas\nTenggat Pajak = 2024-10-22', 'admin@gmail.com', '2024-10-26 23:40:06'),
(129, 'elektronik', 5, 'Tambah Data', NULL, 'nama peminjam = rob\n no telepon = 0851562555\n merk laptop = asus\n serial number = 09987yyy\n kondisi = baik\n tanggal peminjaman = 2024-10-27\n tanggal pengembalian = 2024-10-30\n status peminjaman = Dipinjam', 'admin@gmail.com', '2024-10-26 23:41:09'),
(130, 'elektronik', 6, 'Tambah Data', NULL, 'nama peminjam = rob\n no telepon = 08955555\n merk laptop = asus\n serial number = 1234444\n kondisi = jjhhhhh\n tanggal peminjaman = 2024-10-26\n tanggal pengembalian = 2024-10-31\n status peminjaman = Dipinjam', 'admin@gmail.com', '2024-10-26 23:59:16'),
(131, 'elektronik', 7, 'Tambah Data', NULL, 'nama peminjam = ria\n no telepon = 99998888\n merk laptop = jjjkkk\n serial number = 1234444\n kondisi = ggggggg\n tanggal peminjaman = 2024-10-27\n tanggal pengembalian = 2024-10-30\n status peminjaman = Dipinjam', 'admin@gmail.com', '2024-10-27 00:01:19'),
(132, 'elektronik', 1, 'Tambah Data', NULL, 'Nama Peminjam = ria\nNo Telepon = 098776655\nMerk = asus\nSerial Number = 09988777\nKondisi = baik\nTanggal Peminjaman = 2024-10-11\nTanggal Pengembalian = 2024-10-29\nStatus Peminjaman = Dikembalikan', 'admin@gmail.com', '2024-10-29 01:15:25'),
(133, 'elektronik', 2, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = ria\nNo Telepon = 0988777\nMerk = aaa\nSerial Number = 1234444\nKondisi = hhhhh\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-10-29\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = baikkkkk\nKeterangan = ggggg', 'admin@gmail.com', '2024-10-29 02:03:23'),
(134, 'elektronik', 3, 'Tambah Data', NULL, 'Jenis Barang = kamera\nNama Peminjam = riarobb\nNo Telepon = 08955555\nMerk = aaa\nSerial Number = 09imjhjuu\nKondisi = fffff\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-10-31\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = ggggbb\nKeterangan = ddddd', 'admin@gmail.com', '2024-10-29 02:08:27'),
(135, 'elektronik', 4, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = yanto\nNo Telepon = 2334444ffgg\nMerk = aaaa\nSerial Number = ff333\nKondisi = fffff\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-11-07\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = ddddd\nKeterangan = ffffff', 'admin@gmail.com', '2024-10-29 02:14:11'),
(136, 'elektronik', 5, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = anam\nNo Telepon = 0851562555\nMerk = dddd\nSerial Number = 09987yyy\nKondisi = bjjj\nTanggal Peminjaman = 2024-10-01\nTanggal Pengembalian = 2024-11-09\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = bbbb\nKeterangan = hhhhhh', 'admin@gmail.com', '2024-10-29 02:19:38'),
(137, 'elektronik', 3, 'Edit Data', '3\nkamera\nriarobb\n08955555\naaa\n09imjhjuu\nfffff\n2024-10-29\n2024-10-31\nDipinjam\nggggbb\nddddd\nuploads/1730167707_bukti_Screenshot (44).png\nuploads/1730167707_foto_Screenshot (62).png', 'Jenis Barang = kamera\nNama Peminjam = riarobb\nNo Telepon = 08955555\nMerk = aaa\nSerial Number = 09imjhjuu\nKondisi = fffff\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-10-31\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = ggggbb\nKeterangan = ddddd', 'admin@gmail.com', '2024-10-29 02:24:37'),
(138, 'elektronik', 3, 'Edit Data', '3\nkamera\nriarobb\n08955555\naaa\n09imjhjuu\nfffff\n2024-10-29\n2024-10-31\nDipinjam\nggggbb\nddddd\nuploads/1730167707_bukti_Screenshot (44).png\nuploads/1730167707_foto_Screenshot (62).png', 'Jenis Barang = kamera\nNama Peminjam = riarobb\nNo Telepon = 08955555\nMerk = bbbbb\nSerial Number = 09imjhjuu\nKondisi = fffff\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-10-31\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = ggggbb\nKeterangan = ddddd', 'admin@gmail.com', '2024-10-29 03:02:29'),
(139, 'elektronik', 5, 'Hapus Data', 'nama peminjam = anam\nno telepon = 0851562555\nmerk laptop = \nserial number = 09987yyy\nkondisi = bjjj\ntanggal peminjaman = 2024-10-01\ntanggal pengembalian = 2024-11-09\nstatus peminjaman = Dipinjam', NULL, 'admin@gmail.com', '2024-10-29 08:36:38'),
(140, 'elektronik', 6, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = ria\nNo Telepon = 08955555\nMerk = supra\nSerial Number = 1234444\nKondisi = kskksk\nTanggal Peminjaman = 2024-10-29\nTanggal Pengembalian = 2024-10-29\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = bbbb\nKeterangan = ', 'admin@gmail.com', '2024-10-29 08:38:54'),
(141, 'elektronik', 6, 'Hapus Data', 'nama peminjam = ria\nno telepon = 08955555\nmerk laptop = \nserial number = 1234444\nkondisi = kskksk\ntanggal peminjaman = 2024-10-29\ntanggal pengembalian = 2024-10-29\nstatus peminjaman = Dipinjam', NULL, 'admin@gmail.com', '2024-10-29 08:39:01'),
(142, 'elektronik', 7, 'Tambah Data', NULL, 'Jenis Barang = motor\nNama Peminjam = ria\nNo Telepon = 08955555\nMerk = aaaa\nSerial Number = 1234444\nKondisi = kskksk\nTanggal Peminjaman = 2025-02-01\nTanggal Pengembalian = 2026-02-02\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = \nKeterangan = ', 'admin@gmail.com', '2024-10-29 08:40:28'),
(143, 'elektronik', 7, 'Hapus Data', 'nama peminjam = ria\nno telepon = 08955555\nmerk = aaaa\nserial number = 1234444\nkondisi = kskksk\ntanggal peminjaman = 2025-02-01\ntanggal pengembalian = 2026-02-02\nstatus peminjaman = Dipinjam', NULL, 'admin@gmail.com', '2024-10-29 08:40:39'),
(144, 'elektronik', 8, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = riarobb\nNo Telepon = uiyweghu\nMerk = ssss\nSerial Number = 098\nKondisi = bjjj\nTanggal Peminjaman = 2026-02-02\nTanggal Pengembalian = 2024-02-02\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = \nKeterangan = ', 'admin@gmail.com', '2024-10-29 08:47:52'),
(145, 'elektronik', 9, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = rio\nNo Telepon = 0851562555\nMerk = aaa\nSerial Number = i9998777\nKondisi = cbcbcbb\nTanggal Peminjaman = 2024-10-30\nTanggal Pengembalian = 2024-11-07\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = sssssss\nKeterangan = bbsbndnndn', 'admin@gmail.com', '2024-10-30 01:10:00'),
(146, 'kendaraan', 17, 'Tambah Data', NULL, 'Pemakai = joni\nNo Telepon = 0851562555\nMerk = supra\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2111\nHarga Pembelian = 1500000\nHarga Pajak = 30000\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-17', 'admin@gmail.com', '2024-10-30 01:26:30'),
(147, 'kendaraan', 3, 'Edit Data', '3\nria\n09887766\nb98760\nsupra\nMobil\n2021\n1670000.00\n2019.00\nLunas\n2024-10-23\nuploads/1729921169_foto_Screenshot (43).png\nuploads/1729921169_bukti_Screenshot (70).png', 'Pemakai = ria\nNo Telepon = 09887766\nMerk = supra\nNo Plat = b98760aaaa\nTipe = Mobil\nTahun Pembuatan = 2021\nHarga Pembelian = 1670000.00\nHarga Pajak = 2019.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-23', 'admin@gmail.com', '2024-10-30 01:59:12'),
(148, 'kendaraan', 11, 'Edit Data', '11\njoni\n90908\n09809\n90809\nMotor\n9809\n890809.00\n9809.00\nLunas\n2024-10-26\n\n', 'Pemakai = joni\nNo Telepon = 90908\nMerk = 90809\nNo Plat = 09809\nTipe = Motor\nTahun Pembuatan = 9809\nHarga Pembelian = 890809.00\nHarga Pajak = 9809.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-10-30 03:31:45'),
(149, 'kendaraan', 11, 'Edit Data', '11\njoni\n90908\n09809\n90809\nMotor\n9809\n890809.00\n9809.00\nLunas\n2024-10-26\n\nuploads/1730259105_Screenshot (36).png', 'Pemakai = joni\nNo Telepon = 90908\nMerk = 90809\nNo Plat = 09809\nTipe = Motor\nTahun Pembuatan = 9809\nHarga Pembelian = 890809.00\nHarga Pajak = 9809.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-10-30 03:32:02'),
(150, 'kendaraan', 11, 'Hapus Data', 'pemakai = joni\nno telepon = 90908\nmerk = 90809\nno plat = 09809\ntipe = Motor\ntahun pembuatan = 9809\nharga pembelian = 890809.00\nharga pajak = 9809.00\nstatus pajak = Lunas\ntenggat pajak = 2024-10-26', NULL, 'admin@gmail.com', '2024-10-30 04:45:32'),
(151, 'pemeliharaan_elektronik', 16, 'Hapus Data', 'Nama Perangkat = aaaa\nMerk = iikkm\nTipe = sssss\nTanggal Pemeliharaan = 2024-10-29\nDeskripsi = \nBiaya Pemeliharaan = 200000.00\nTeknisi = sssss\nNama Pengguna = hhhhhh\nNo Telepon Pengguna = 19900000\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-10-30 04:56:32'),
(152, 'kendaraan', 15, 'Hapus Data', 'pemakai = YANTO\nno telepon = 0989890\nmerk = mio\nno plat = 098098\ntipe = Motor\ntahun pembuatan = 2009\nharga pembelian = 90898.00\nharga pajak = 9809.00\nstatus pajak = Lunas\ntenggat pajak = 2024-10-26', NULL, 'admin@gmail.com', '2024-10-30 04:57:11'),
(153, 'pemeliharaan_elektronik', 17, 'Hapus Data', 'Nama Perangkat = aaaa\nMerk = iikkm\nTipe = sssss\nTanggal Pemeliharaan = 2024-10-29\nDeskripsi = baik\nBiaya Pemeliharaan = 200000.00\nTeknisi = sssss\nNama Pengguna = hhhhhh\nNo Telepon Pengguna = 19900000\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-10-30 05:02:45'),
(154, 'pemeliharaan_elektronik', 22, 'Hapus Data', 'Nama Perangkat = nnnn\nMerk = supra\nTipe = nnnnn\nTanggal Pemeliharaan = 2024-10-31\nDeskripsi = baik\nBiaya Pemeliharaan = 120000.00\nTeknisi = jjjjj\nNama Pengguna = kkkkk\nNo Telepon Pengguna = 000000988\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-11-04 01:29:36'),
(155, 'kendaraan', 16, 'Hapus Data', 'pemakai = anam\nno telepon = 0851562555\nmerk = supra\nno plat = h98877\ntipe = Motor\ntahun pembuatan = 2010\nharga pembelian = 1670000.00\nharga pajak = 200000.00\nstatus pajak = Belum Lunas\ntenggat pajak = 2024-10-22', NULL, 'admin@gmail.com', '2024-11-04 01:29:49'),
(156, 'pemeliharaan_elektronik', 18, 'Hapus Data', 'Nama Perangkat = aaaa\nMerk = iikkm\nTipe = sssss\nTanggal Pemeliharaan = 2024-10-29\nDeskripsi = baik\nBiaya Pemeliharaan = 200000.00\nTeknisi = sssss\nNama Pengguna = hhhhhh\nNo Telepon Pengguna = 19900000\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-11-04 02:33:58'),
(157, 'pemeliharaan_kendaraan', 11, 'Hapus Data', 'Nama Pemelihara = ggggg\nNo Telepon = 1223344\nJenis Kendaraan = mobil\nPlat Nomor = h689ko\nKondisi Sebelum = hhjjkk\nKondisi Setelah = ffffgggg\nTanggal Pemeliharaan = 2024-10-26\nBiaya Pemeliharaan = 200000.00\nStatus Pemeliharaan = Dalam Proses\nKeterangan = ffffffff', NULL, 'admin@gmail.com', '2024-11-04 02:49:29'),
(158, 'pemeliharaan_kendaraan', 17, 'Hapus Data', 'Nama Pemelihara = rio\nNo Telepon = 08955555\nJenis Kendaraan = mobil\nPlat Nomor = h689ko\nKondisi Sebelum = hshhshh\nKondisi Setelah = jsjsjsjj\nTanggal Pemeliharaan = 2024-11-29\nBiaya Pemeliharaan = 1233444.00\nStatus Pemeliharaan = Selesai\nKeterangan = sgsgsggs', NULL, 'admin@gmail.com', '2024-11-04 02:53:00'),
(159, 'kendaraan', 18, 'Tambah Data', NULL, 'Pemakai = sandi\nNo Telepon = 0851562555\nMerk = sss\nNo Plat = ssss\nTipe = Motor\nTahun Pembuatan = 2111\nHarga Pembelian = 12334\nHarga Pajak = 12333\nStatus Pajak = Lunas\nTenggat Pajak = 2024-11-08', 'admin@gmail.com', '2024-11-04 03:04:34'),
(160, 'kendaraan', 19, 'Tambah Data', NULL, 'Pemakai = YANTO\nNo Telepon = 987897\nMerk = 987987\nNo Plat = 798798\nTipe = Motor\nTahun Pembuatan = 987987\nHarga Pembelian = 97987\nHarga Pajak = 798798\nStatus Pajak = Lunas\nTenggat Pajak = 0008-08-09', 'admin@gmail.com', '2024-11-04 03:12:24'),
(161, 'kendaraan', 20, 'Tambah Data', NULL, 'Pemakai = hjbj\nNo Telepon = hjbwjhb\nMerk = jhsbjhwb\nNo Plat = jhbsjhb\nTipe = Motor\nTahun Pembuatan = 9878\nHarga Pembelian = 8798\nHarga Pajak = 87987\nStatus Pajak = Lunas\nTenggat Pajak = 0888-08-07', 'admin@gmail.com', '2024-11-04 03:13:17'),
(162, 'kendaraan', 21, 'Tambah Data', NULL, 'Pemakai = jjjjj\nNo Telepon = 0987777\nMerk = aaa\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2018\nHarga Pembelian = 876666\nHarga Pajak = 160000\nStatus Pajak = Lunas\nTenggat Pajak = 2024-11-22', 'admin@gmail.com', '2024-11-05 01:04:05'),
(163, 'elektronik', 10, 'Tambah Data', NULL, 'Jenis Barang = laptop\nNama Peminjam = ffffff\nNo Telepon = 0987377\nMerk = fffff\nSerial Number = 2324455\nKondisi = fffff\nTanggal Peminjaman = 2024-11-01\nTanggal Pengembalian = 2024-11-04\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = fffff\nKeterangan = fffff', 'admin@gmail.com', '2024-11-05 01:19:12'),
(164, 'kendaraan', 13, 'Edit Data', '13\nmega\n98098\n09890\n9809\nMotor\n9090\n9898908.00\n98098.00\nLunas\n2024-10-26\n\n', 'Pemakai = megaaaa\nNo Telepon = 98098\nMerk = 9809\nNo Plat = 09890\nTipe = Motor\nTahun Pembuatan = 9090\nHarga Pembelian = 9898908.00\nHarga Pajak = 98098.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-11-05 01:22:54'),
(165, 'kendaraan', 18, 'Hapus Data', 'pemakai = sandi\nno telepon = 0851562555\nmerk = sss\nno plat = ssss\ntipe = Motor\ntahun pembuatan = 2111\nharga pembelian = 12334.00\nharga pajak = 12333.00\nstatus pajak = Lunas\ntenggat pajak = 2024-11-08', NULL, 'admin@gmail.com', '2024-11-05 01:23:15'),
(166, 'kendaraan', 22, 'Tambah Data', NULL, 'Pemakai = ffff\nNo Telepon = 09998888\nMerk = supra\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2111\nHarga Pembelian = 13000\nHarga Pajak = 160000\nStatus Pajak = Lunas\nTenggat Pajak = 2024-11-01', 'admin@gmail.com', '2024-11-05 01:24:07'),
(167, 'elektronik', 10, 'Hapus Data', 'nama peminjam = ffffff\nno telepon = 0987377\nmerk = fffff\nserial number = 2324455\nkondisi = fffff\ntanggal peminjaman = 2024-11-01\ntanggal pengembalian = 2024-11-04\nstatus peminjaman = Dipinjam', NULL, 'admin@gmail.com', '2024-11-05 01:24:28'),
(168, 'elektronik', 9, 'Edit Data', '9\nlaptop\nrio\n0851562555\naaa\ni9998777\ncbcbcbb\n2024-10-30\n2024-11-07\nDipinjam\nsssssss\nbbsbndnndn\nuploads/1730250600_bukti_Screenshot (35).png\nuploads/1730250600_foto_Screenshot (42).png', 'Jenis Barang = laptop\nNama Peminjam = ri\nNo Telepon = 0851562555\nMerk = aaa\nSerial Number = i9998777\nKondisi = cbcbcbb\nTanggal Peminjaman = 2024-10-30\nTanggal Pengembalian = 2024-11-07\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = sssssss\nKeterangan = bbsbndnndn', 'admin@gmail.com', '2024-11-05 01:24:41'),
(169, 'elektronik', 11, 'Tambah Data', NULL, 'Jenis Barang = kamera\nNama Peminjam = rob\nNo Telepon = 0988777\nMerk = aaa\nSerial Number = 09imjhjuu\nKondisi = baik\nTanggal Peminjaman = 2024-11-01\nTanggal Pengembalian = 2024-11-05\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = sssssss\nKeterangan = ggggg', 'admin@gmail.com', '2024-11-05 01:25:39'),
(170, 'pemeliharaan_elektronik', 23, 'Tambah Data', NULL, 'Nama Perangkat = aaaa\nMerk = iu\nTipe = hjb\nDeskripsi = hjb\nTanggal Pemeliharaan = 0008-08-08\nBiaya Pemeliharaan = 987987\nTeknisi = uihiu\nNama Pengguna = iuhiu\nNo Telepon Pengguna = 897\nStatus = Selesai', 'admin@gmail.com', '2024-11-05 01:44:26'),
(171, 'elektronik', 8, 'Edit Data', '8\nlaptop\nriarobb\nuiyweghu\nssss\n098\nbjjj\n2026-02-02\n2024-02-02\nDipinjam\n\n\n\n', 'Jenis Barang = laptop\nNama Peminjam = riarobb\nNo Telepon = uiyweghu\nMerk = ssss\nSerial Number = 098\nKondisi = bjjjjjjjjjjjj\nTanggal Peminjaman = 2026-02-02\nTanggal Pengembalian = 2024-02-02\nStatus Peminjaman = Dipinjam\nKondisi Saat Pengembalian = \nKeterangan = ', 'admin@gmail.com', '2024-11-05 02:01:49'),
(172, 'kendaraan', 13, 'Edit Data', '13\nmegaaaa\n98098\n09890\n9809\nMotor\n9090\n9898908.00\n98098.00\nLunas\n2024-10-26\n\n', 'Pemakai = megaaaa\nNo Telepon = 98098\nMerk = 980999999\nNo Plat = 09890\nTipe = Motor\nTahun Pembuatan = 9090\nHarga Pembelian = 9898908.00\nHarga Pajak = 98098.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-11-05 02:02:06'),
(173, 'pemeliharaan_elektronik', 24, 'Tambah Data', NULL, 'Nama Perangkat = laptop\nMerk = sus\nTipe = 667\nDeskripsi = baik\nTanggal Pemeliharaan = 99999-08-09\nBiaya Pemeliharaan = 8987987\nTeknisi = siso\nNama Pengguna = siuk\nNo Telepon Pengguna = 9879879879\nStatus = Selesai', 'admin@gmail.com', '2024-11-05 02:34:50'),
(174, 'pemeliharaan_kendaraan', 24, 'Tambah Pemeliharaan', NULL, 'Nama Pemelihara = yanti\nNo Telepon = 879\nJenis Kendaraan = mio\nPlat Nomor = 9879\nKondisi Sebelum = iuhu\nKondisi Setelah = uhuh\nTanggal Pemeliharaan = 4444-07-05\nBiaya Pemeliharaan = 6756576\nKeterangan = ytvyt\nStatus Pemeliharaan = Selesai', 'admin@gmail.com', '2024-11-05 02:57:35'),
(175, 'pemeliharaan_kendaraan', 25, 'Tambah Pemeliharaan', NULL, 'Nama Pemelihara = hjjj\nNo Telepon = 08955555\nJenis Kendaraan = mobil\nPlat Nomor = h689ko\nKondisi Sebelum = sssss\nKondisi Setelah = aaaa\nTanggal Pemeliharaan = 2024-11-05\nBiaya Pemeliharaan = 200000\nKeterangan = aaaa\nStatus Pemeliharaan = Selesai', 'admin@gmail.com', '2024-11-05 02:59:46'),
(176, 'pemeliharaan_kendaraan', 23, 'Hapus Data', 'Nama Pemelihara = yanti\nNo Telepon = 879\nJenis Kendaraan = mio\nPlat Nomor = 9879\nKondisi Sebelum = iuhu\nKondisi Setelah = uhuh\nTanggal Pemeliharaan = 4444-07-05\nBiaya Pemeliharaan = 6756576.00\nStatus Pemeliharaan = Selesai\nKeterangan = ytvyt', NULL, 'admin@gmail.com', '2024-11-05 03:00:23'),
(177, 'pemeliharaan_kendaraan', 22, 'Edit Data', '22\nyanto\n8979798\nmio\n9887\nuu\nuu\n7777-08-09\n78687687.00\nnnsns\nScreenshot (36).png\nSelesai', 'Nama Pemelihara = to\nNo Telepon = 8979798\nJenis Kendaraan = mio\nPlat Nomor = 9887\nKondisi Sebelum = uu\nKondisi Setelah = uu\nTanggal Pemeliharaan = 7777-08-09\nBiaya Pemeliharaan = 78687687.00\nKeterangan = nnsns\nStatus Pemeliharaan = selesai', 'admin@gmail.com', '2024-11-05 03:05:08'),
(178, 'pemeliharaan_elektronik', 10, 'Hapus Data', 'Nama Perangkat = erv\nMerk = dddd\nTipe = evre\nTanggal Pemeliharaan = 2024-10-26\nDeskripsi = ddddd\nBiaya Pemeliharaan = 1200012.00\nTeknisi = wwww\nNama Pengguna = aaaaa\nNo Telepon Pengguna = 5557777\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-11-05 03:17:42'),
(179, 'pemeliharaan_elektronik', 25, 'Tambah Data', NULL, 'Nama Perangkat = uhuy\nMerk = llllll\nTipe = kkkk\nDeskripsi = lllllkkk\nTanggal Pemeliharaan = 2024-11-05\nBiaya Pemeliharaan = 120000\nTeknisi = jjjjj\nNama Pengguna = kkkk\nNo Telepon Pengguna = kkkkkk\nStatus = Selesai', 'admin@gmail.com', '2024-11-05 03:19:58'),
(180, 'pemeliharaan_kendaraan', 21, 'Edit Data', '21\nyan\n8979798\nmio\n9887\nuu\nuu\n7777-08-09\n78687687.00\nnnsns\nScreenshot (36).png\nSelesai', 'Nama Pemelihara = yannnnn\nNo Telepon = 8979798\nJenis Kendaraan = mio\nPlat Nomor = 9887\nKondisi Sebelum = uu\nKondisi Setelah = uu\nTanggal Pemeliharaan = 7777-08-09\nBiaya Pemeliharaan = 78687687.00\nKeterangan = nnsns\nStatus Pemeliharaan = selesai', 'admin@gmail.com', '2024-11-05 03:26:48'),
(181, 'elektronik', 8, 'Hapus Data', 'nama peminjam = riarobb\nno telepon = uiyweghu\nmerk = ssss\nserial number = 098\nkondisi = bjjjjjjjjjjjj\ntanggal peminjaman = 2026-02-02\ntanggal pengembalian = 2024-02-02\nstatus peminjaman = Dipinjam', NULL, 'aa', '2024-11-13 03:13:06'),
(182, 'elektronik', 9, 'Hapus Data', 'nama peminjam = ri\nno telepon = 0851562555\nmerk = aaa\nserial number = i9998777\nkondisi = cbcbcbb\ntanggal peminjaman = 2024-10-30\ntanggal pengembalian = 2024-11-07\nstatus peminjaman = Dipinjam', NULL, 'aa', '2024-11-13 05:14:57'),
(183, 'kendaraan', 22, 'Hapus Data', 'pemakai = ffff\nno telepon = 09998888\nmerk = supra\nno plat = j67788jj\ntipe = Motor\ntahun pembuatan = 2111\nharga pembelian = 13000.00\nharga pajak = 160000.00\nstatus pajak = Lunas\ntenggat pajak = 2024-11-01', NULL, 'aa', '2024-11-28 05:52:07'),
(184, 'kendaraan', 13, 'Edit Data', '13\nmegaaaa\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\nLunas\n2024-10-26\n\n', 'Pemakai = megaaaa\nNo Telepon = 98098\nMerk = 980999999\nNo Plat = 09890\nTipe = Motor\nTahun Pembuatan = 9090\nHarga Pembelian = 9898908.00\nHarga Pajak = 98098.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-12-26', 'aa', '2024-11-28 06:01:03'),
(185, 'kendaraan', 14, 'Edit Data', '14\nYANTO\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nLunas\n2024-10-26\n\n', 'Pemakai = santi\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Lunas\nTenggat Pajak = 2024-10-26', 'aa', '2024-11-28 06:10:20'),
(186, 'kendaraan', 13, 'Edit Data', '13\nmasa\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\nLunas\n2024-12-26\n\n', 'Pemakai = masam\nNo Telepon = 98098\nMerk = 980999999\nNo Plat = 09890\nTipe = Motor\nTahun Pembuatan = 9090\nHarga Pembelian = 9898908.00\nHarga Pajak = 98098.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-12-26', 'aa', '2024-11-28 06:28:49'),
(187, 'kendaraan', 13, 'Edit Data', '13\nmasam\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\nAktif\n2024-12-26\n\n', 'Pemakai = masa\nNo Telepon = 98098\nMerk = 980999999\nNo Plat = 09890\nTipe = Motor\nTahun Pembuatan = 9090\nHarga Pembelian = 9898908.00\nHarga Pajak = 98098.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-12-26', 'aa', '2024-11-28 06:37:23'),
(188, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-28\n\n\n\nPerbaikan\n\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-28\nBiaya Pemeliharaan = 100\nKeterangan = ajja\nStatus Pemeliharaan = ', 'aa', '2024-11-29 00:03:01'),
(189, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-28\n100.00\naaa\n\nPerbaikan\n0\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-28\nBiaya Pemeliharaan = 100.00\nKeterangan = hahha\nStatus Pemeliharaan = ', 'aa', '2024-11-29 00:03:19'),
(190, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-28\n100.00\naaa\n\nPerbaikan\n0\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-28\nBiaya Pemeliharaan = 100.00\nKeterangan = nnjjj\nStatus Pemeliharaan = ', 'aa', '2024-11-29 00:07:25'),
(191, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-28\n100.00\naaa\n\nPerbaikan\nnnjjj\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-28\nBiaya Pemeliharaan = 100.00\nKeterangan = nnjjj\nStatus Pemeliharaan = ', 'aa', '2024-11-29 00:10:54'),
(192, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-29\n100.00\naaa\n\nPerbaikan\nhaha\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-29\nBiaya Pemeliharaan = 100.00\nKeterangan = haha\nStatus Pemeliharaan = Normal', 'aa', '2024-11-29 00:42:28'),
(193, 'pemeliharaan_kendaraan', 20, 'Edit Data', '20\nhjbj\nhjbwjhb\njhbsjhb\njhsbjhwb\nMotor\n9878\n8798.00\n87987.00\n0000-00-00\n0888-08-07\nuploads/1730689997_foto_Screenshot (36).png\nuploads/1730689997_bukti_Screenshot (35).png\n2024-11-29\n\n\n\nPerbaikan\nhaha\n', 'Nama Pemelihara = hjbj\nNo Telepon = hjbwjhb\nJenis Kendaraan = Motor\nPlat Nomor = jhbsjhb\nKondisi Sebelum = rusak parah\nTanggal Pemeliharaan = 2024-11-29\nBiaya Pemeliharaan = 10000\nKeterangan = hahasss\nStatus Pemeliharaan = Normal', 'aa', '2024-11-29 00:44:45'),
(194, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9090\n9898908.00\n98098.00\n0000-00-00\n0020-02-07\n\n\n2024-11-29\n100.00\naaa\n\nPerbaikan\nhahhaaa\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-29\nBiaya Pemeliharaan = 100.00\nKeterangan = hahhaaa\nStatus Pemeliharaan = Normal', 'aa', '2024-11-29 00:45:59'),
(195, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9020\n9898908.00\n2024-12-03\n2024-12-26\n\n\n2024-11-30\n100.00\naaa\n\nPerbaikan\nhhggdgfgg', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 100.00\nKeterangan = hhggdgfgg\nStatus Pemeliharaan = Normal', 'a', '2024-11-30 19:50:36'),
(196, 'kendaraan', 17, 'Hapus Data', 'pemakai = joni\nno telepon = 0851562555\nmerk = supra\nno plat = j67788jj\ntipe = Motor\ntahun pembuatan = 2111\nharga pembelian = 1500000.00\nharga pajak = \nstatus pajak = \ntenggat pajak = ', NULL, 'a', '2024-11-30 20:14:11'),
(197, 'pemeliharaan_kendaraan', 20, 'Edit Data', '20\nhjbj\nhjbwjhb\njhbsjhb\njhsbjhwb\nMotor\n9878\n8798.00\n0000-00-00\n0888-08-07\nuploads/1730689997_foto_Screenshot (36).png\nuploads/1730689997_bukti_Screenshot (35).png\n2024-11-30\n10000.00\nhahahhaah\n\nPerbaikan\nhahasss', 'Nama Pemelihara = hjbj\nNo Telepon = hjbwjhb\nJenis Kendaraan = Motor\nPlat Nomor = jhbsjhb\nKondisi Sebelum = hahahhaah\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 10000.00\nKeterangan = hahasss\nStatus Pemeliharaan = Normal', 'a', '2024-11-30 20:45:37'),
(198, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9020\n9898908.00\n2025-12-03\n2029-12-26\n\n\n2024-11-30\n100.00\naaa\n\nPerbaikan\nmotor meledak duarr', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = aaa\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 100.00\nKeterangan = motor meledak duarr\nStatus Pemeliharaan = Normal', 'a', '2024-11-30 20:47:57'),
(199, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9020\n9898908.00\n2025-12-03\n2029-12-26\n\n\n2024-11-30\n100.00\nuarr\n\nPerbaikan\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = uarr\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 100.00\nKeterangan = \nStatus Pemeliharaan = Normal', 'a', '2024-11-30 20:48:40'),
(200, 'pemeliharaan_kendaraan', 20, 'Edit Data', '20\nhjbj\nhjbwjhb\njhbsjhb\njhsbjhwb\nMotor\n9878\n8798.00\n0000-00-00\n0888-08-07\nuploads/1730689997_foto_Screenshot (36).png\nuploads/1730689997_bukti_Screenshot (35).png\n2024-11-30\n10000.00\nmususus\n\nPerbaikan\nhahasss', 'Nama Pemelihara = hjbj\nNo Telepon = hjbwjhb\nJenis Kendaraan = Motor\nPlat Nomor = jhbsjhb\nKondisi Sebelum = mususus\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 10000.00\nKeterangan = hahasss\nStatus Pemeliharaan = Normal', 'a', '2024-11-30 20:48:49'),
(201, 'pemeliharaan_kendaraan', 13, 'Edit Data', '13\ndeka\n98098\n09890\n980999999\nMotor\n9020\n9898908.00\n2025-12-03\n2029-12-26\n\n\n2024-11-30\n100.00\nmotor terbelah gergaji\n\nPerbaikan\n', 'Nama Pemelihara = deka\nNo Telepon = 98098\nJenis Kendaraan = Motor\nPlat Nomor = 09890\nKondisi Sebelum = motor terbelah gergaji\nTanggal Pemeliharaan = 2024-11-30\nBiaya Pemeliharaan = 100.00\nKeterangan = \nStatus Pemeliharaan = Normal', 'a', '2024-11-30 20:49:23');

--
-- Triggers `log_histori`
--
DELIMITER $$
CREATE TRIGGER `hapus_log_lama` BEFORE INSERT ON `log_histori` FOR EACH ROW BEGIN
    DECLARE total_log INT;
    DECLARE id_tua INT;

    -- Hitung jumlah log
    SELECT COUNT(*) INTO total_log FROM log_histori;

    -- Jika jumlah log lebih dari 100, hapus log tertua
    IF total_log > 100 THEN
        -- Cari ID tertua yang ingin dihapus
        SELECT id INTO id_tua 
        FROM log_histori 
        ORDER BY tanggal ASC 
        LIMIT 1;
        
        -- Hapus log tertua
        DELETE FROM log_histori WHERE id = id_tua;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pemeliharaan_elektronik`
--

CREATE TABLE `pemeliharaan_elektronik` (
  `id` int(11) NOT NULL,
  `nama_perangkat` varchar(255) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `tanggal_pemeliharaan` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `biaya_pemeliharaan` decimal(10,2) DEFAULT NULL,
  `teknisi` varchar(100) DEFAULT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `no_telepon_pengguna` varchar(15) DEFAULT NULL,
  `status` enum('Selesai','Dalam Proses','Dibatalkan') DEFAULT 'Dalam Proses',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `bukti_pemeliharaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemeliharaan_elektronik`
--

INSERT INTO `pemeliharaan_elektronik` (`id`, `nama_perangkat`, `merk`, `tipe`, `tanggal_pemeliharaan`, `deskripsi`, `biaya_pemeliharaan`, `teknisi`, `nama_pengguna`, `no_telepon_pengguna`, `status`, `bukti_pembayaran`, `catatan`, `bukti_pemeliharaan`) VALUES
(12, 'laptop', 'dddd', 'bbbbb', '2024-10-10', 'baik', 123444.00, 'rio', 'ria', '1233889999', 'Selesai', 'uploads/1729054017_WhatsApp.jpg', NULL, NULL),
(13, 'laptopaaaa', 'aaa', 'aaaa', '2024-10-27', 'baik', 90000000.00, 'aaa', 'ri', '20000000000', 'Selesai', 'uploads/1729986488_WhatsApp.jpg', NULL, NULL),
(23, 'aaaa', 'iu', 'hjb', '0008-08-08', 'hjb', 987987.00, 'uihiu', 'iuhiu', '897', 'Selesai', NULL, NULL, 'uploads/1730771066_bukti_Screenshot (36).png'),
(24, 'laptop', 'sus', '667', '0000-00-00', 'baik', 8987987.00, 'siso', 'siuk', '9879879879', 'Selesai', NULL, NULL, NULL),
(25, 'bbbbb', 'llllll', 'kkkk', '2024-11-05', 'baik', 120000.00, 'jjjjj', 'kkkk', 'kkkkkk', 'Selesai', NULL, NULL, 'uploads/1730776798_bukti_Screenshot (33).png');

-- --------------------------------------------------------

--
-- Table structure for table `pemeliharaan_kendaraan`
--

CREATE TABLE `pemeliharaan_kendaraan` (
  `id` int(11) NOT NULL,
  `nama_pemelihara` varchar(255) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `jenis_kendaraan` varchar(50) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `kondisi_sebelum` text NOT NULL,
  `kondisi_setelah` text NOT NULL,
  `tanggal_pemeliharaan` date NOT NULL,
  `biaya_pemeliharaan` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti` varchar(255) NOT NULL,
  `status_pemeliharaan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemeliharaan_kendaraan`
--

INSERT INTO `pemeliharaan_kendaraan` (`id`, `nama_pemelihara`, `no_telepon`, `jenis_kendaraan`, `plat_nomor`, `kondisi_sebelum`, `kondisi_setelah`, `tanggal_pemeliharaan`, `biaya_pemeliharaan`, `keterangan`, `bukti`, `status_pemeliharaan`) VALUES
(12, 'kkkkhhggghhhh', '112222', 'mobil', 'b212fzi', 'ppppp', 'ddddd', '2024-10-16', 12222.00, 'ssss', 'foto.jpg', 'Selesai'),
(18, 'riojjjjjjjh', '08955555', 'mobil', 'h689ko', 'bbbbb', 'kkkkkk', '2024-11-01', 200000.00, 'jjjjjj', 'Screenshot (34).png', 'Selesai'),
(19, 'oooojjjjiiiiiuuuu', '0851562555', 'mobil', '0099999', 'kkkkkk', 'jjjjj', '2024-11-05', 120000.00, 'jjjjjj', 'Screenshot (36).png', 'Selesai'),
(20, 'siuk', 'u8u8', 'mi', '9878', 'h', 'kj', '0009-08-08', 879889.00, 'hinlk', 'Screenshot (35).png', 'Selesai'),
(21, 'yannnnn', '8979798', 'mio', '9887', 'uu', 'uu', '7777-08-09', 78687687.00, 'nnsns', 'Screenshot (36).png', 'selesai'),
(22, 'to', '8979798', 'mio', '9887', 'uu', 'uu', '7777-08-09', 78687687.00, 'nnsns', 'Screenshot (36).png', 'selesai'),
(24, 'yanti', '879', 'mio', '9879', 'iuhu', 'uhuh', '4444-07-05', 6756576.00, 'ytvyt', './uploads/1730775455_bukti_Screenshot (35).png', 'Selesai'),
(25, 'hjjj', '08955555', 'mobil', 'h689ko', 'sssss', 'aaaa', '2024-11-05', 200000.00, 'aaaa', './uploads/1730775586_bukti_Screenshot (70).png', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(2, 'admin@gmail.com', 'admin', '$2y$10$hVSvpLYAyirFtJDvLB0rLeOTXwf7zhqMRb7GxtfXs4TFOwKeWUcZe'),
(3, 'aa', 'aaa', '$2y$10$CH2f9dKwTNqeYv1SJP2gIuBMkLheY.HbJ8BkjZ3JgmX5BfCBjphsC'),
(4, 'aa', 'aa', '$2y$10$./JuC3V7EoJ2dYnRx9HQzuzSVbZxnbq1IFILOdAr4JSRg2Vgn5jpq'),
(5, 'ria', 'ria123', '$2y$10$RZ1D.gjxa8KaHPCZFXeTD.2GiW9Ta01jltdUHwAR2AuaA1lBoPAc2'),
(6, 'a', 'a', '$2y$10$4JLftsD5cCuhb3QGTnwJW.FpErFxO/d9q5QNlsDlJk10Ds5nzFv.K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `elektronik`
--
ALTER TABLE `elektronik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_pemakai`
--
ALTER TABLE `history_pemakai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kendaraan` (`id_kendaraan`);

--
-- Indexes for table `history_pemakai_elektronik`
--
ALTER TABLE `history_pemakai_elektronik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_histori`
--
ALTER TABLE `log_histori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemeliharaan_elektronik`
--
ALTER TABLE `pemeliharaan_elektronik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemeliharaan_kendaraan`
--
ALTER TABLE `pemeliharaan_kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `elektronik`
--
ALTER TABLE `elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `history_pemakai`
--
ALTER TABLE `history_pemakai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `history_pemakai_elektronik`
--
ALTER TABLE `history_pemakai_elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `log_histori`
--
ALTER TABLE `log_histori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `pemeliharaan_elektronik`
--
ALTER TABLE `pemeliharaan_elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pemeliharaan_kendaraan`
--
ALTER TABLE `pemeliharaan_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_pemakai`
--
ALTER TABLE `history_pemakai`
  ADD CONSTRAINT `fk_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
