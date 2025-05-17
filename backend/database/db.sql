-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: web_nuochoa
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chitiethoadon`
--

DROP TABLE IF EXISTS `chitiethoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitiethoadon` (
  `ma_nuoc_hoa` int NOT NULL,
  `ma_hoa_don` int NOT NULL,
  `so_luong_mua` int DEFAULT NULL,
  `ma_dung_tich` int NOT NULL,
  `gia_ban` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ma_hoa_don`,`ma_dung_tich`,`ma_nuoc_hoa`),
  KEY `ma_hoa_don` (`ma_hoa_don`),
  KEY `fk_cthd_dungtich` (`ma_nuoc_hoa`,`ma_dung_tich`),
  CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`ma_hoa_don`) REFERENCES `hoadon` (`ma_hoa_don`) ON DELETE CASCADE,
  CONSTRAINT `fk_cthd_dungtich` FOREIGN KEY (`ma_nuoc_hoa`, `ma_dung_tich`) REFERENCES `dungtich_nuochoa` (`ma_nuoc_hoa`, `ma_dung_tich`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitiethoadon`
--

LOCK TABLES `chitiethoadon` WRITE;
/*!40000 ALTER TABLE `chitiethoadon` DISABLE KEYS */;
INSERT INTO `chitiethoadon` VALUES (2,1,1,6,2300000.00),(5,2,2,6,3500000.00),(1,3,1,6,1300000.00),(4,3,3,6,2700000.00),(7,3,1,6,1900000.00),(1,3,1,9,1300000.00),(1,4,3,6,1300000.00),(10,5,1,6,2400000.00),(3,6,2,6,2800000.00),(6,7,4,6,2600000.00),(4,8,1,6,2700000.00),(9,9,2,6,2200000.00),(5,10,4,6,3500000.00),(8,10,1,6,3100000.00),(7,11,1,6,1900000.00),(2,12,1,6,2300000.00),(9,12,2,6,2200000.00),(4,14,1,6,2700000.00),(6,14,1,6,2600000.00),(3,15,2,6,2800000.00),(4,16,2,6,2700000.00);
/*!40000 ALTER TABLE `chitiethoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diachi`
--

DROP TABLE IF EXISTS `diachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diachi` (
  `ma_dia_chi` int NOT NULL AUTO_INCREMENT,
  `ma_khach_hang` int DEFAULT NULL,
  `ten_nguoi_nhan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `so_dien_thoai_nguoi_nhan` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dia_chi_giao_hang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_dia_chi`),
  KEY `ma_khach_hang` (`ma_khach_hang`),
  CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diachi`
--

LOCK TABLES `diachi` WRITE;
/*!40000 ALTER TABLE `diachi` DISABLE KEYS */;
INSERT INTO `diachi` VALUES (1,7,'Nguyễn Thị Mai','0912345678','456 Đường Trần Hưng Đạo, Quận 5, TP.HCM'),(2,3,'Lê Văn Bình','0908765432','789 Phố Huế, Quận Hai Bà Trưng, Hà Nội'),(3,1,'Phạm Thị Hồng','0987654321','12 Đường Trần Phú, Thành phố Nha Trang, Khánh Hòa'),(4,10,'Trần Văn Dũng','0911222333','34 Phạm Văn Đồng, Quận Cầu Giấy, Hà Nội'),(5,5,'Vũ Thị Lan','0933445566','56 Đường 3/2, Quận 10, TP.HCM'),(6,2,'Hoàng Văn Hoà','0977555333','78 Đường Lê Duẩn, Quận Hải Châu, Hải Phòng'),(7,7,'Đỗ Thị Thu','0966888777','90 Phố Trần Nhân Tông, Quận Hai Bà Trưng, Hà Nội'),(8,8,'Bùi Văn Hùng','0944332211','123 Đường Bạch Đằng, Quận Bình Thạnh, TP.HCM'),(9,4,'Trịnh Thị Nga','0955221144','45 Đường Phan Đình Phùng, Quận Ba Đình, Hà Nội'),(10,1,'Phan Văn Sơn','0922113344','67 Đường Nguyễn Văn Cừ, Quận Long Biên, Hà Nội'),(13,11,'aa aa','0988337662','102 ADV P3 Quan 6'),(14,1,'pham Cong','0111111111','daklak'),(15,3,'Hoang Anh','0333444555','Hà Nội'),(16,10,'Van Pham','0888111222','Ha Noi'),(17,10,'Cong  Pham','0222333111','Binh Thuan'),(18,10,'Pham Hoang','0222333112','Tan Phu');
/*!40000 ALTER TABLE `diachi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dungtich`
--

DROP TABLE IF EXISTS `dungtich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dungtich` (
  `ma_dung_tich` int NOT NULL,
  `dung_tich` double DEFAULT NULL,
  PRIMARY KEY (`ma_dung_tich`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dungtich`
--

LOCK TABLES `dungtich` WRITE;
/*!40000 ALTER TABLE `dungtich` DISABLE KEYS */;
INSERT INTO `dungtich` VALUES (1,5),(2,10),(3,15),(4,20),(5,30),(6,50),(7,75),(8,90),(9,100),(10,125),(11,150),(12,200);
/*!40000 ALTER TABLE `dungtich` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dungtich_nuochoa`
--

DROP TABLE IF EXISTS `dungtich_nuochoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dungtich_nuochoa` (
  `ma_dung_tich` int NOT NULL,
  `ma_nuoc_hoa` int NOT NULL,
  `gia_ban` double DEFAULT NULL,
  PRIMARY KEY (`ma_dung_tich`,`ma_nuoc_hoa`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `dungtich_nuochoa_ibfk_1` FOREIGN KEY (`ma_dung_tich`) REFERENCES `dungtich` (`ma_dung_tich`) ON DELETE CASCADE,
  CONSTRAINT `dungtich_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dungtich_nuochoa`
--

LOCK TABLES `dungtich_nuochoa` WRITE;
/*!40000 ALTER TABLE `dungtich_nuochoa` DISABLE KEYS */;
INSERT INTO `dungtich_nuochoa` VALUES (6,1,1300000),(6,2,2300000),(6,3,2800000),(6,4,2700000),(6,5,3500000),(6,6,2600000),(6,7,1900000),(6,8,3100000),(6,9,2200000),(6,10,2400000),(6,11,2000000),(9,1,1300000);
/*!40000 ALTER TABLE `dungtich_nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoadon` (
  `ma_hoa_don` int NOT NULL AUTO_INCREMENT,
  `ma_khach_hang` int DEFAULT NULL,
  `ma_dia_chi` int DEFAULT NULL,
  `thoi_gian` datetime DEFAULT NULL,
  `tong_tien` double DEFAULT NULL,
  `trang_thai_don_hang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_hoa_don`),
  KEY `ma_khach_hang` (`ma_khach_hang`),
  KEY `ma_dia_chi` (`ma_dia_chi`),
  CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`ma_dia_chi`) REFERENCES `diachi` (`ma_dia_chi`) ON DELETE CASCADE,
  CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoadon`
--

LOCK TABLES `hoadon` WRITE;
/*!40000 ALTER TABLE `hoadon` DISABLE KEYS */;
INSERT INTO `hoadon` VALUES (1,7,1,'2025-03-05 09:20:00',2300000,'Đang xử lý'),(2,3,2,'2025-03-15 14:45:00',7000000,'Đã giao'),(3,1,3,'2025-03-20 11:30:00',12600000,'Đã hủy'),(4,10,4,'2025-03-25 16:10:00',3900000,'Đã giao'),(5,5,5,'2025-03-30 10:00:00',2400000,'Đang xử lý'),(6,2,6,'2025-04-02 12:20:00',5600000,'Đã giao'),(7,7,7,'2025-04-05 18:00:00',10400000,'Đang xử lý'),(8,8,8,'2025-04-08 13:15:00',2700000,'Đã giao'),(9,4,9,'2025-04-10 15:40:00',4400000,'Đã hủy'),(10,1,10,'2025-04-11 17:25:00',17100000,'Đã giao'),(11,11,13,'2025-05-16 19:41:37',1900000,'Đang xử lý'),(12,1,14,'2025-05-17 00:10:20',6700000,'Đang xử lý'),(14,10,16,'2025-05-17 02:09:23',5300000,'Đã hủy'),(15,10,17,'2025-05-17 02:20:20',5600000,'Đang xử lý'),(16,10,18,'2025-05-17 02:55:21',5400000,'Đang xử lý');
/*!40000 ALTER TABLE `hoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khachhang` (
  `ma_khach_hang` int NOT NULL AUTO_INCREMENT,
  `ten_khach_hang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trang_thai_tai_khoan` tinyint(1) DEFAULT NULL,
  `quyen_han` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_khach_hang`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khachhang`
--

LOCK TABLES `khachhang` WRITE;
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
INSERT INTO `khachhang` VALUES (1,'Nguyen Van A','a@gmail.com','nguyenvana','pass123',1,'user'),(2,'Tran Thi B','b@gmail.com','tranthib','pass123',1,'user'),(3,'Le Van C','c@gmail.com','levanc','pass123',1,'user'),(4,'Pham Minh D','d@gmail.com','phamminhd','pass123',1,'user'),(5,'Hoang Hoa E','e@gmail.com','hoanghoae','pass123',1,'user'),(6,'Dang Thi F','f@gmail.com','dangthif','pass123',1,'user'),(7,'Vu Huu G','g@gmail.com','vuhuug','pass123',1,'user'),(8,'Bui Van H','h@gmail.com','buivanh','pass123',1,'user'),(9,'Ly Kieu I','i@gmail.com','lykieui','pass123',1,'user'),(10,'Do Anh J','j@gmail.com','doanhj','pass123',1,'user'),(11,'Nguyễn Khắc Khổ','khoquet12@gmail.com','choco','bi',1,'admin');
/*!40000 ALTER TABLE `khachhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nongdo`
--

DROP TABLE IF EXISTS `nongdo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nongdo` (
  `ma_nong_do` int NOT NULL,
  `nong_do` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_nong_do`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nongdo`
--

LOCK TABLES `nongdo` WRITE;
/*!40000 ALTER TABLE `nongdo` DISABLE KEYS */;
INSERT INTO `nongdo` VALUES (1,'Parfum'),(2,'EDP'),(3,'EDT'),(4,'EDC'),(5,'Eau Fraîche'),(6,'Aftershave'),(7,'Perfume Oil');
/*!40000 ALTER TABLE `nongdo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nongdo_nuochoa`
--

DROP TABLE IF EXISTS `nongdo_nuochoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nongdo_nuochoa` (
  `ma_nong_do` int NOT NULL,
  `ma_nuoc_hoa` int NOT NULL,
  PRIMARY KEY (`ma_nong_do`,`ma_nuoc_hoa`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `nongdo_nuochoa_ibfk_1` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE,
  CONSTRAINT `nongdo_nuochoa_ibfk_2` FOREIGN KEY (`ma_nong_do`) REFERENCES `nongdo` (`ma_nong_do`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nongdo_nuochoa`
--

LOCK TABLES `nongdo_nuochoa` WRITE;
/*!40000 ALTER TABLE `nongdo_nuochoa` DISABLE KEYS */;
INSERT INTO `nongdo_nuochoa` VALUES (2,1),(3,2),(2,3),(1,4),(3,5),(2,6),(3,7),(7,8),(7,9),(7,10),(2,11);
/*!40000 ALTER TABLE `nongdo_nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nothuong`
--

DROP TABLE IF EXISTS `nothuong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nothuong` (
  `ma_not_huong` int NOT NULL,
  `not_huong` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_not_huong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nothuong`
--

LOCK TABLES `nothuong` WRITE;
/*!40000 ALTER TABLE `nothuong` DISABLE KEYS */;
INSERT INTO `nothuong` VALUES (1,'Hoa Hồng'),(2,'Hoa Nhài'),(3,'Hoa Oải Hương'),(4,'Hoa Ly'),(5,'Hoa Violet'),(6,'Hoa Mẫu Đơn'),(7,'Hoa Lan'),(8,'Hoa Dành Dành'),(9,'Hoa Mộc Lan'),(10,'Hoa Lan Nam Phi'),(11,'Táo'),(12,'Lê'),(13,'Đào'),(14,'Mâm Xôi Đen'),(15,'Mâm Xôi Đỏ'),(16,'Dâu Tây'),(17,'Anh Đào'),(18,'Dứa'),(19,'Dừa'),(20,'Dưa Gang'),(21,'Chanh'),(22,'Cam'),(23,'Cam Bergamot'),(24,'Bưởi'),(25,'Quýt'),(26,'Gỗ Đàn Hương'),(27,'Gỗ Tuyết Tùng'),(28,'Hoắc Hương'),(29,'Cỏ Hương Bài'),(30,'Trầm Hương'),(31,'Quế'),(32,'Đinh Hương'),(33,'Bạch Đậu Khấu'),(34,'Gừng'),(35,'Nhục Đậu Khấu'),(36,'Vani'),(37,'Đậu Tonka'),(38,'Muối Biển'),(39,'Hương Biển'),(40,'Hương Ozone'),(41,'Hương Aldehyde'),(42,'Xạ Hương'),(43,'Long Diên Hương'),(44,'Cầy Hương'),(45,'Da Thuộc'),(46,'Rêu Sồi'),(47,'Húng Quế'),(48,'Xô Thơm'),(49,'Cỏ Xạ Hương'),(50,'Bạc Hà');
/*!40000 ALTER TABLE `nothuong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nothuong_nuochoa`
--

DROP TABLE IF EXISTS `nothuong_nuochoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nothuong_nuochoa` (
  `ma_not_huong` int NOT NULL,
  `ma_nuoc_hoa` int NOT NULL,
  `loai` varchar(50) COLLATE utf8mb4_general_ci not null,
  PRIMARY KEY (`ma_not_huong`,`ma_nuoc_hoa` , `loai`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `nothuong_nuochoa_ibfk_1` FOREIGN KEY (`ma_not_huong`) REFERENCES `nothuong` (`ma_not_huong`) ON DELETE CASCADE,
  CONSTRAINT `nothuong_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nothuong_nuochoa`
--

LOCK TABLES `nothuong_nuochoa` WRITE;
/*!40000 ALTER TABLE `nothuong_nuochoa` DISABLE KEYS */;
INSERT INTO `nothuong_nuochoa` VALUES (1,1,'Hương giữa'),(1,3,'Hương giữa'),(1,6,'Hương giữa'),(1,9,'Hương đầu'),(1,10,'Hương giữa'),(2,1,'Hương giữa'),(2,3,'Hương đầu'),(2,6,'Hương giữa'),(2,9,'Hương đầu'),(2,10,'Hương giữa'),(3,1,'Hương giữa'),(3,2,'Hương giữa'),(3,3,'Hương đầu'),(3,6,'Hương đầu'),(3,9,'Hương giữa'),(4,3,'Hương giữa'),(4,9,'Hương giữa'),(5,3,'Hương cuối'),(6,3,'Hương cuối'),(10,4,'Hương giữa'),(11,5,'Hương đầu'),(11,8,'Hương đầu'),(11,10,'Hương đầu'),(12,8,'Hương cuối'),(12,10,'Hương đầu'),(13,8,'Hương đầu'),(16,8,'Hương giữa'),(17,5,'Hương giữa'),(17,8,'Hương giữa'),(18,8,'Hương cuối'),(21,1,'Hương đầu'),(21,5,'Hương đầu'),(23,1,'Hương đầu'),(23,2,'Hương đầu'),(23,4,'Hương đầu'),(23,6,'Hương đầu'),(24,1,'Hương đầu'),(26,1,'Hương cuối'),(26,2,'Hương cuối'),(26,7,'Hương cuối'),(26,9,'Hương cuối'),(26,10,'Hương cuối'),(27,2,'Hương cuối'),(27,5,'Hương cuối'),(27,6,'Hương cuối'),(28,7,'Hương giữa'),(29,7,'Hương giữa'),(30,1,'Hương cuối'),(30,4,'Hương cuối'),(30,7,'Hương cuối'),(30,9,'Hương cuối'),(30,10,'Hương cuối'),(31,7,'Hương đầu'),(32,2,'Hương đầu'),(32,4,'Hương đầu'),(32,7,'Hương đầu'),(34,2,'Hương giữa'),(36,1,'Hương cuối'),(36,4,'Hương cuối'),(36,5,'Hương cuối'),(36,6,'Hương cuối'),(37,5,'Hương giữa'),(41,1,'Hương đầu'),(43,4,'Hương giữa');
/*!40000 ALTER TABLE `nothuong_nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nuochoa`
--

DROP TABLE IF EXISTS `nuochoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nuochoa` (
  `ma_nuoc_hoa` int NOT NULL AUTO_INCREMENT,
  `ten_nuoc_hoa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gioi_tinh` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tinh_trang` tinyint(1) DEFAULT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_general_ci,
  `ma_thuong_hieu` int DEFAULT NULL,
  PRIMARY KEY (`ma_nuoc_hoa`),
  KEY `ma_thuong_hieu` (`ma_thuong_hieu`),
  CONSTRAINT `nuochoa_ibfk_1` FOREIGN KEY (`ma_thuong_hieu`) REFERENCES `thuonghieu` (`ma_thuong_hieu`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nuochoa`
--

LOCK TABLES `nuochoa` WRITE;
/*!40000 ALTER TABLE `nuochoa` DISABLE KEYS */;
INSERT INTO `nuochoa` VALUES (1,'Bleu de Chanel','Nam',1,'bleu.jpg','Hương gỗ mạnh mẽ nam tính.',1),(2,'Sauvage Dior','Nam',1,'sauvage.jpg','Hương cam chanh tươi mát.',2),(3,'Gucci Guilty','Nữ',1,'guilty.jpg','Hương hoa cỏ sang trọng.',3),(4,'Eros Versace','Nam',1,'eros.jpg','Hương bạc hà, chanh tươi.',4),(5,'Oud Wood','Unisex',1,'oudwood.jpg','Hương gỗ trầm ấm áp.',5),(6,'My Burberry','Nữ',1,'myburberry.jpg','Hương hoa cỏ nhẹ nhàng.',6),(7,'CK One','Unisex',1,'ckone.jpg','Hương cam bergamot tươi mát.',7),(8,'YSL Libre','Nữ',1,'libre.jpg','Hương lavender và vani ngọt ngào.',8),(9,'Acqua di Gio','Nam',1,'acquadigio.jpg','Hương biển mát lạnh.',9),(10,'Boss Bottled','Nam',1,'bossbottled.jpg','Hương táo và quế ấm áp.',10),(11,'Another 13','Unisex',1,'logo.jpg','',2);
/*!40000 ALTER TABLE `nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thuonghieu` (
  `ma_thuong_hieu` int NOT NULL,
  `ten_thuong_hieu` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ma_thuong_hieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thuonghieu`
--

LOCK TABLES `thuonghieu` WRITE;
/*!40000 ALTER TABLE `thuonghieu` DISABLE KEYS */;
INSERT INTO `thuonghieu` VALUES (1,'Chanel'),(2,'Dior'),(3,'Gucci'),(4,'Versace'),(5,'Tom Ford'),(6,'Burberry'),(7,'Calvin Klein'),(8,'Yves Saint Laurent'),(9,'Armani'),(10,'Hugo Boss');
/*!40000 ALTER TABLE `thuonghieu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-17  6:12:43
