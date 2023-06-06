-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2022 at 12:10 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlthuchanh`
--

-- --------------------------------------------------------

--
-- Table structure for table `detai`
--

DROP TABLE IF EXISTS `detai`;
CREATE TABLE IF NOT EXISTS `detai` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `tendetai` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `soluongsv` tinyint(4) NOT NULL,
  `soluongtoida` tinyint(4) NOT NULL,
  `thu` tinyint(4) NOT NULL,
  `magv` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `magv` (`magv`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `detai`
--

INSERT INTO `detai` (`id`, `tendetai`, `soluongsv`, `soluongtoida`, `thu`, `magv`) VALUES
(1, 'Quản lý cà phê', 1, 4, 2, 'gv01'),
(3, 'Quản lý thư viện', 0, 4, 4, 'gv02'),
(5, 'Quản lý ký túc xá', 0, 2, 4, 'gv01'),
(6, 'Quản lý nhà trọ', 0, 4, 5, 'gv01'),
(7, 'Quản lý kho', 0, 4, 7, 'gv01'),
(8, 'Quản lý khách sạn', 0, 2, 5, 'gv01'),
(9, 'Quản lý nhà sách', 0, 4, 3, 'gv01');

-- --------------------------------------------------------

--
-- Table structure for table `dsdk`
--

DROP TABLE IF EXISTS `dsdk`;
CREATE TABLE IF NOT EXISTS `dsdk` (
  `masv` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`masv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dsdk`
--

INSERT INTO `dsdk` (`masv`, `hoten`) VALUES
('4251050001', 'Phạm Tài'),
('4251050002', 'Lê Văn Tấn'),
('4251050003', 'Nguyễn Hòa Lan'),
('4251050004', 'Nguyễn Tín');

-- --------------------------------------------------------

--
-- Table structure for table `giangvien`
--

DROP TABLE IF EXISTS `giangvien`;
CREATE TABLE IF NOT EXISTS `giangvien` (
  `magv` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `matkhau` text COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` tinyint(1) NOT NULL,
  `quequan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`magv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `giangvien`
--

INSERT INTO `giangvien` (`magv`, `matkhau`, `hoten`, `ngaysinh`, `gioitinh`, `quequan`, `email`) VALUES
('gv01', 'gv', 'Nguyễn Văn C', '1986-01-04', 0, 'Khánh Hòa', 'vana@gmail.com'),
('gv02', 'gv', 'Nguyễn Văn B', '1986-01-04', 0, 'Quảng Ngãi', 'vanb@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

DROP TABLE IF EXISTS `sinhvien`;
CREATE TABLE IF NOT EXISTS `sinhvien` (
  `masv` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `matkhau` text COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lop` text COLLATE utf8_unicode_ci NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` tinyint(1) NOT NULL,
  `quequan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`masv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`masv`, `matkhau`, `hoten`, `lop`, `ngaysinh`, `gioitinh`, `quequan`, `email`) VALUES
('4251050001', 'tai', 'Phạm Tài', 'CNTT K42C', '2001-06-29', 0, 'Quy Nhơn', 'taipham1@gmail.com'),
('4251050002', 'tai', 'Lê Văn Tấn', 'CNTT K42A', '2001-12-12', 0, 'Bình Định', 'phamtai2961@gmail.com'),
('4251050003', 'tai', 'Nguyễn Hùng', 'CNTT K42A', '2001-12-12', 1, 'Bình Định', 'lan@gmail.com'),
('4251050203', 'tai', 'Nguyễn Hòa Lan', 'CNTT K42A', '2001-12-12', 1, 'Bình Định', 'lan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `thuchanh`
--

DROP TABLE IF EXISTS `thuchanh`;
CREATE TABLE IF NOT EXISTS `thuchanh` (
  `id` mediumint(9) NOT NULL,
  `masv` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nopbai` text COLLATE utf8_unicode_ci,
  `nhanxet` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`masv`),
  KEY `masv` (`masv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thuchanh`
--

INSERT INTO `thuchanh` (`id`, `masv`, `nopbai`, `nhanxet`) VALUES
(1, '4251050203', NULL, '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detai`
--
ALTER TABLE `detai`
  ADD CONSTRAINT `detai_ibfk_1` FOREIGN KEY (`magv`) REFERENCES `giangvien` (`magv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thuchanh`
--
ALTER TABLE `thuchanh`
  ADD CONSTRAINT `thuchanh_ibfk_1` FOREIGN KEY (`id`) REFERENCES `detai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thuchanh_ibfk_2` FOREIGN KEY (`masv`) REFERENCES `sinhvien` (`masv`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
