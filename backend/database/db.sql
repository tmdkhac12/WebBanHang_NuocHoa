-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 02:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
create DATABASE web_nuochoa;
USE web_nuochoa;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_nuochoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `ma_nuoc_hoa` int(11) NOT NULL,
  `ma_hoa_don` int(11) NOT NULL,
  `so_luong_mua` int(11) DEFAULT NULL,
  `ma_dung_tich` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`ma_nuoc_hoa`, `ma_hoa_don`, `so_luong_mua`, `ma_dung_tich`) VALUES
(2, 1, 1, 6),
(5, 2, 2, 6),
(1, 3, 1, 6),
(4, 3, 3, 6),
(7, 3, 1, 6),
(1, 3, 1, 9),
(1, 4, 3, 6),
(10, 5, 1, 6),
(3, 6, 2, 6),
(6, 7, 4, 6),
(4, 8, 1, 6),
(9, 9, 2, 6),
(5, 10, 4, 6),
(8, 10, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `diachi`
--

CREATE TABLE `diachi` (
  `ma_dia_chi` int(11) NOT NULL,
  `ma_khach_hang` int(11) DEFAULT NULL,
  `ten_nguoi_nhan` varchar(255) DEFAULT NULL,
  `so_dien_thoai_nguoi_nhan` varchar(20) DEFAULT NULL,
  `dia_chi_giao_hang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diachi`
--

INSERT INTO `diachi` (`ma_dia_chi`, `ma_khach_hang`, `ten_nguoi_nhan`, `so_dien_thoai_nguoi_nhan`, `dia_chi_giao_hang`) VALUES
(1, 7, 'Nguyễn Thị Mai', '0912345678', '456 Đường Trần Hưng Đạo, Quận 5, TP.HCM'),
(2, 3, 'Lê Văn Bình', '0908765432', '789 Phố Huế, Quận Hai Bà Trưng, Hà Nội'),
(3, 1, 'Phạm Thị Hồng', '0987654321', '12 Đường Trần Phú, Thành phố Nha Trang, Khánh Hòa'),
(4, 10, 'Trần Văn Dũng', '0911222333', '34 Phạm Văn Đồng, Quận Cầu Giấy, Hà Nội'),
(5, 5, 'Vũ Thị Lan', '0933445566', '56 Đường 3/2, Quận 10, TP.HCM'),
(6, 2, 'Hoàng Văn Hoà', '0977555333', '78 Đường Lê Duẩn, Quận Hải Châu, Đà Nẵng'),
(7, 7, 'Đỗ Thị Thu', '0966888777', '90 Phố Trần Nhân Tông, Quận Hai Bà Trưng, Hà Nội'),
(8, 8, 'Bùi Văn Hùng', '0944332211', '123 Đường Bạch Đằng, Quận Bình Thạnh, TP.HCM'),
(9, 4, 'Trịnh Thị Nga', '0955221144', '45 Đường Phan Đình Phùng, Quận Ba Đình, Hà Nội'),
(10, 1, 'Phan Văn Sơn', '0922113344', '67 Đường Nguyễn Văn Cừ, Quận Long Biên, Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `dungtich`
--

CREATE TABLE `dungtich` (
  `ma_dung_tich` int(11) NOT NULL,
  `dung_tich` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dungtich`
--

INSERT INTO `dungtich` (`ma_dung_tich`, `dung_tich`) VALUES
(1, 5),
(2, 10),
(3, 15),
(4, 20),
(5, 30),
(6, 50),
(7, 75),
(8, 90),
(9, 100),
(10, 125),
(11, 150),
(12, 200);

-- --------------------------------------------------------

--
-- Table structure for table `dungtich_nuochoa`
--

CREATE TABLE `dungtich_nuochoa` (
  `ma_dung_tich` int(11) NOT NULL,
  `ma_nuoc_hoa` int(11) NOT NULL,
  `gia_ban` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dungtich_nuochoa`
--

INSERT INTO `dungtich_nuochoa` (`ma_dung_tich`, `ma_nuoc_hoa`, `gia_ban`) VALUES
(6, 1, 2500000),
(6, 2, 2300000),
(6, 3, 2800000),
(6, 4, 2700000),
(6, 5, 3500000),
(6, 6, 2600000),
(6, 7, 1900000),
(6, 8, 3100000),
(6, 9, 2200000),
(6, 10, 2400000),
(9, 1, 5750000);

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `ma_hoa_don` int(11) NOT NULL,
  `ma_khach_hang` int(11) DEFAULT NULL,
  `ma_dia_chi` int(11) DEFAULT NULL,
  `thoi_gian` datetime DEFAULT NULL,
  `tong_tien` double DEFAULT NULL,
  `trang_thai_don_hang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`ma_hoa_don`, `ma_khach_hang`, `ma_dia_chi`, `thoi_gian`, `tong_tien`, `trang_thai_don_hang`) VALUES
(1, 7, 1, '2025-03-05 09:20:00', 2300000, 'Đang xử lý'),
(2, 3, 2, '2025-03-15 14:45:00', 8000000, 'Đã giao'),
(3, 1, 3, '2025-03-20 11:30:00', 18250000, 'Đã hủy'),
(4, 10, 4, '2025-03-25 16:10:00', 2500000, 'Đã giao'),
(5, 5, 5, '2025-03-30 10:00:00', 2400000, 'Đang xử lý'),
(6, 2, 6, '2025-04-02 12:20:00', 5600000, 'Đã hủy'),
(7, 7, 7, '2025-04-05 18:00:00', 10400000, 'Đang xử lý'),
(8, 8, 8, '2025-04-08 13:15:00', 2700000, 'Đã giao'),
(9, 4, 9, '2025-04-10 15:40:00', 4400000, 'Đã hủy'),
(10, 1, 10, '2025-04-11 17:25:00', 17100000, 'Đã giao');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `ma_khach_hang` int(11) NOT NULL,
  `ten_khach_hang` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `trang_thai_tai_khoan` tinyint(1) DEFAULT NULL,
  `quyen_han` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`ma_khach_hang`, `ten_khach_hang`, `email`, `username`, `password`, `trang_thai_tai_khoan`,`quyen_han`) VALUES
(1, 'Nguyen Van A', 'a@gmail.com', 'nguyenvana', 'pass123', 1,'admin'),
(2, 'Tran Thi B', 'b@gmail.com', 'tranthib', 'pass123', 1 , 'user'),
(3, 'Le Van C', 'c@gmail.com', 'levanc', 'pass123', 1 ,'user'),
(4, 'Pham Minh D', 'd@gmail.com', 'phamminhd', 'pass123', 1 , 'user'),
(5, 'Hoang Hoa E', 'e@gmail.com', 'hoanghoae', 'pass123', 1 ,'user'),
(6, 'Dang Thi F', 'f@gmail.com', 'dangthif', 'pass123', 1 , 'user'),
(7, 'Vu Huu G', 'g@gmail.com', 'vuhuug', 'pass123', 1 , 'user'),
(8, 'Bui Van H', 'h@gmail.com', 'buivanh', 'pass123', 1, 'user'),
(9, 'Ly Kieu I', 'i@gmail.com', 'lykieui', 'pass123', 1 , 'user'),
(10, 'Do Anh J', 'j@gmail.com', 'doanhj', 'pass123', 1 , 'user'),
(11, 'Nguyễn Khắc Khổ', 'khoquet12@gmail.com', 'choco', 'bi', 1, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `nongdo`
--

CREATE TABLE `nongdo` (
  `ma_nong_do` int(11) NOT NULL,
  `nong_do` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nongdo`
--

INSERT INTO `nongdo` (`ma_nong_do`, `nong_do`) VALUES
(1, 'Parfum'),
(2, 'EDP'),
(3, 'EDT'),
(4, 'EDC'),
(5, 'Eau Fraîche'),
(6, 'Aftershave'),
(7, 'Perfume Oil');

-- --------------------------------------------------------

--
-- Table structure for table `nongdo_nuochoa`
--

CREATE TABLE `nongdo_nuochoa` (
  `ma_nong_do` int(11) NOT NULL,
  `ma_nuoc_hoa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nongdo_nuochoa`
--

INSERT INTO `nongdo_nuochoa` (`ma_nong_do`, `ma_nuoc_hoa`) VALUES
(1, 4),
(2, 1),
(2, 3),
(2, 6),
(3, 2),
(3, 5),
(3, 7),
(7, 8),
(7, 9),
(7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `nothuong`
--

CREATE TABLE `nothuong` (
  `ma_not_huong` int(11) NOT NULL,
  `not_huong` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nothuong`
--

INSERT INTO `nothuong` (`ma_not_huong`, `not_huong`) VALUES
(1, 'Hoa Hồng'),
(2, 'Hoa Nhài'),
(3, 'Hoa Oải Hương'),
(4, 'Hoa Ly'),
(5, 'Hoa Violet'),
(6, 'Hoa Mẫu Đơn'),
(7, 'Hoa Lan'),
(8, 'Hoa Dành Dành'),
(9, 'Hoa Mộc Lan'),
(10, 'Hoa Lan Nam Phi'),
(11, 'Táo'),
(12, 'Lê'),
(13, 'Đào'),
(14, 'Mâm Xôi Đen'),
(15, 'Mâm Xôi Đỏ'),
(16, 'Dâu Tây'),
(17, 'Anh Đào'),
(18, 'Dứa'),
(19, 'Dừa'),
(20, 'Dưa Gang'),
(21, 'Chanh'),
(22, 'Cam'),
(23, 'Cam Bergamot'),
(24, 'Bưởi'),
(25, 'Quýt'),
(26, 'Gỗ Đàn Hương'),
(27, 'Gỗ Tuyết Tùng'),
(28, 'Hoắc Hương'),
(29, 'Cỏ Hương Bài'),
(30, 'Trầm Hương'),
(31, 'Quế'),
(32, 'Đinh Hương'),
(33, 'Bạch Đậu Khấu'),
(34, 'Gừng'),
(35, 'Nhục Đậu Khấu'),
(36, 'Vani'),
(37, 'Đậu Tonka'),
(38, 'Muối Biển'),
(39, 'Hương Biển'),
(40, 'Hương Ozone'),
(41, 'Hương Aldehyde'),
(42, 'Xạ Hương'),
(43, 'Long Diên Hương'),
(44, 'Cầy Hương'),
(45, 'Da Thuộc'),
(46, 'Rêu Sồi'),
(47, 'Húng Quế'),
(48, 'Xô Thơm'),
(49, 'Cỏ Xạ Hương'),
(50, 'Bạc Hà');

-- --------------------------------------------------------

--
-- Table structure for table `nothuong_nuochoa`
--

CREATE TABLE `nothuong_nuochoa` (
  `ma_not_huong` int(11) NOT NULL,
  `ma_nuoc_hoa` int(11) NOT NULL,
  `loai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nothuong_nuochoa`
--

INSERT INTO `nothuong_nuochoa` (`ma_not_huong`, `ma_nuoc_hoa`, `loai`) VALUES
(1, 1, 'Hương giữa'),
(1, 3, 'Hương giữa'),
(1, 6, 'Hương giữa'),
(1, 9, 'Hương đầu'),
(1, 10, 'Hương giữa'),
(2, 1, 'Hương giữa'),
(2, 3, 'Hương đầu'),
(2, 6, 'Hương giữa'),
(2, 9, 'Hương đầu'),
(2, 10, 'Hương giữa'),
(3, 1, 'Hương giữa'),
(3, 2, 'Hương giữa'),
(3, 3, 'Hương đầu'),
(3, 6, 'Hương đầu'),
(3, 9, 'Hương giữa'),
(4, 3, 'Hương giữa'),
(4, 9, 'Hương giữa'),
(5, 3, 'Hương cuối'),
(6, 3, 'Hương cuối'),
(10, 4, 'Hương giữa'),
(11, 5, 'Hương đầu'),
(11, 8, 'Hương đầu'),
(11, 10, 'Hương đầu'),
(12, 8, 'Hương cuối'),
(12, 10, 'Hương đầu'),
(13, 8, 'Hương đầu'),
(16, 8, 'Hương giữa'),
(17, 5, 'Hương giữa'),
(17, 8, 'Hương giữa'),
(18, 8, 'Hương cuối'),
(21, 1, 'Hương đầu'),
(21, 5, 'Hương đầu'),
(23, 1, 'Hương đầu'),
(23, 2, 'Hương đầu'),
(23, 4, 'Hương đầu'),
(23, 6, 'Hương đầu'),
(26, 1, 'Hương cuối'),
(26, 2, 'Hương cuối'),
(26, 7, 'Hương cuối'),
(26, 9, 'Hương cuối'),
(26, 10, 'Hương cuối'),
(27, 2, 'Hương cuối'),
(27, 5, 'Hương cuối'),
(27, 6, 'Hương cuối'),
(28, 7, 'Hương giữa'),
(29, 7, 'Hương giữa'),
(30, 1, 'Hương cuối'),
(30, 4, 'Hương cuối'),
(30, 7, 'Hương cuối'),
(30, 9, 'Hương cuối'),
(30, 10, 'Hương cuối'),
(31, 7, 'Hương đầu'),
(32, 2, 'Hương đầu'),
(32, 4, 'Hương đầu'),
(32, 7, 'Hương đầu'),
(34, 2, 'Hương giữa'),
(36, 1, 'Hương cuối'),
(36, 4, 'Hương cuối'),
(36, 5, 'Hương cuối'),
(36, 6, 'Hương cuối'),
(37, 5, 'Hương giữa'),
(41, 1, 'Hương đầu'),
(43, 4, 'Hương giữa');

-- --------------------------------------------------------

--
-- Table structure for table `nuochoa`
--

CREATE TABLE `nuochoa` (
  `ma_nuoc_hoa` int(11) NOT NULL,
  `ten_nuoc_hoa` varchar(255) DEFAULT NULL,
  `gioi_tinh` varchar(30) DEFAULT NULL,
  `tinh_trang` tinyint(1) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `ma_thuong_hieu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nuochoa`
--

INSERT INTO `nuochoa` (`ma_nuoc_hoa`, `ten_nuoc_hoa`, `gioi_tinh`, `tinh_trang`, `hinh_anh`, `mo_ta`, `ma_thuong_hieu`) VALUES
(1, 'Bleu de Chanel', 'Nam', 1, 'bleu.jpg', 'Hương gỗ mạnh mẽ nam tính.', 1),
(2, 'Sauvage Dior', 'Nam', 1, 'sauvage.jpg', 'Hương cam chanh tươi mát.', 2),
(3, 'Gucci Guilty', 'Nữ', 1, 'guilty.jpg', 'Hương hoa cỏ sang trọng.', 3),
(4, 'Eros Versace', 'Nam', 1, 'eros.jpg', 'Hương bạc hà, chanh tươi.', 4),
(5, 'Oud Wood', 'Unisex', 1, 'oudwood.jpg', 'Hương gỗ trầm ấm áp.', 5),
(6, 'My Burberry', 'Nữ', 1, 'myburberry.jpg', 'Hương hoa cỏ nhẹ nhàng.', 6),
(7, 'CK One', 'Unisex', 1, 'ckone.jpg', 'Hương cam bergamot tươi mát.', 7),
(8, 'YSL Libre', 'Nữ', 1, 'libre.jpg', 'Hương lavender và vani ngọt ngào.', 8),
(9, 'Acqua di Gio', 'Nam', 1, 'acquadigio.jpg', 'Hương biển mát lạnh.', 9),
(10, 'Boss Bottled', 'Nam', 1, 'bossbottled.jpg', 'Hương táo và quế ấm áp.', 10);

-- --------------------------------------------------------

--
-- Table structure for table `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `ma_thuong_hieu` int(11) NOT NULL,
  `ten_thuong_hieu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thuonghieu`
--

INSERT INTO `thuonghieu` (`ma_thuong_hieu`, `ten_thuong_hieu`) VALUES
(1, 'Chanel'),
(2, 'Dior'),
(3, 'Gucci'),
(4, 'Versace'),
(5, 'Tom Ford'),
(6, 'Burberry'),
(7, 'Calvin Klein'),
(8, 'Yves Saint Laurent'),
(9, 'Armani'),
(10, 'Hugo Boss');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`ma_hoa_don`,`ma_dung_tich`,`ma_nuoc_hoa`),
  ADD KEY `ma_hoa_don` (`ma_hoa_don`),
  ADD KEY `fk_cthd_dungtich` (`ma_nuoc_hoa`,`ma_dung_tich`);

--
-- Indexes for table `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`ma_dia_chi`),
  ADD KEY `ma_khach_hang` (`ma_khach_hang`);

--
-- Indexes for table `dungtich`
--
ALTER TABLE `dungtich`
  ADD PRIMARY KEY (`ma_dung_tich`);

--
-- Indexes for table `dungtich_nuochoa`
--
ALTER TABLE `dungtich_nuochoa`
  ADD PRIMARY KEY (`ma_dung_tich`,`ma_nuoc_hoa`),
  ADD KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`ma_hoa_don`),
  ADD KEY `ma_khach_hang` (`ma_khach_hang`),
  ADD KEY `ma_dia_chi` (`ma_dia_chi`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ma_khach_hang`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `nongdo`
--
ALTER TABLE `nongdo`
  ADD PRIMARY KEY (`ma_nong_do`);

--
-- Indexes for table `nongdo_nuochoa`
--
ALTER TABLE `nongdo_nuochoa`
  ADD PRIMARY KEY (`ma_nong_do`,`ma_nuoc_hoa`),
  ADD KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`);

--
-- Indexes for table `nothuong`
--
ALTER TABLE `nothuong`
  ADD PRIMARY KEY (`ma_not_huong`);

--
-- Indexes for table `nothuong_nuochoa`
--
ALTER TABLE `nothuong_nuochoa`
  ADD PRIMARY KEY (`ma_not_huong`,`ma_nuoc_hoa`),
  ADD KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`);

--
-- Indexes for table `nuochoa`
--
ALTER TABLE `nuochoa`
  ADD PRIMARY KEY (`ma_nuoc_hoa`),
  ADD KEY `ma_thuong_hieu` (`ma_thuong_hieu`);

--
-- Indexes for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`ma_thuong_hieu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ma_khach_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nuochoa`
--
ALTER TABLE `nuochoa`
  MODIFY `ma_nuoc_hoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`ma_hoa_don`) REFERENCES `hoadon` (`ma_hoa_don`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cthd_dungtich` FOREIGN KEY (`ma_nuoc_hoa`,`ma_dung_tich`) REFERENCES `dungtich_nuochoa` (`ma_nuoc_hoa`, `ma_dung_tich`) ON DELETE CASCADE;

-- Constraints for table `diachi`
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE;

-- Constraints for table `dungtich_nuochoa`
ALTER TABLE `dungtich_nuochoa`
  ADD CONSTRAINT `dungtich_nuochoa_ibfk_1` FOREIGN KEY (`ma_dung_tich`) REFERENCES `dungtich` (`ma_dung_tich`) ON DELETE CASCADE,
  ADD CONSTRAINT `dungtich_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE;

-- Constraints for table `hoadon`
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`ma_dia_chi`) REFERENCES `diachi` (`ma_dia_chi`) ON DELETE CASCADE,
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE;

-- Constraints for table `nongdo_nuochoa`
ALTER TABLE `nongdo_nuochoa`
  ADD CONSTRAINT `nongdo_nuochoa_ibfk_1` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE,
  ADD CONSTRAINT `nongdo_nuochoa_ibfk_2` FOREIGN KEY (`ma_nong_do`) REFERENCES `nongdo` (`ma_nong_do`) ON DELETE CASCADE;

-- Constraints for table `nothuong_nuochoa`
ALTER TABLE `nothuong_nuochoa`
  ADD CONSTRAINT `nothuong_nuochoa_ibfk_1` FOREIGN KEY (`ma_not_huong`) REFERENCES `nothuong` (`ma_not_huong`) ON DELETE CASCADE,
  ADD CONSTRAINT `nothuong_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE;

-- Constraints for table `nuochoa`
ALTER TABLE `nuochoa`
  ADD CONSTRAINT `nuochoa_ibfk_1` FOREIGN KEY (`ma_thuong_hieu`) REFERENCES `thuonghieu` (`ma_thuong_hieu`) ON DELETE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
