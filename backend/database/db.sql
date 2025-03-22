-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: db
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
  `ma_hoa_don` int NOT NULL,
  `ma_nuoc_hoa` int NOT NULL,
  `so_luong_mua` int DEFAULT NULL,
  PRIMARY KEY (`ma_hoa_don`,`ma_nuoc_hoa`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`ma_hoa_don`) REFERENCES `hoadon` (`ma_hoa_don`),
  CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitiethoadon`
--

LOCK TABLES `chitiethoadon` WRITE;
/*!40000 ALTER TABLE `chitiethoadon` DISABLE KEYS */;
INSERT INTO `chitiethoadon` VALUES (1,1,2),(2,2,1);
/*!40000 ALTER TABLE `chitiethoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diachi`
--

DROP TABLE IF EXISTS `diachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diachi` (
  `ma_dia_chi` int NOT NULL,
  `ma_khach_hang` int DEFAULT NULL,
  `ten_nguoi_nhan` varchar(255) DEFAULT NULL,
  `so_dien_thoai_nguoi_nhan` varchar(50) DEFAULT NULL,
  `dia_chi_giao_hang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_dia_chi`),
  KEY `ma_khach_hang` (`ma_khach_hang`),
  CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diachi`
--

LOCK TABLES `diachi` WRITE;
/*!40000 ALTER TABLE `diachi` DISABLE KEYS */;
INSERT INTO `diachi` VALUES (1,1,'Nguyen Van A','0123456789','Hà Nội'),(2,2,'Tran Thi B','0987654321','TP HCM'),(3,3,'Le Van C','0934567890','Đà Nẵng'),(4,4,'Pham Minh D','0912345678','Hải Phòng'),(5,5,'Hoang Hoa E','0976543210','Cần Thơ');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dungtich`
--

LOCK TABLES `dungtich` WRITE;
/*!40000 ALTER TABLE `dungtich` DISABLE KEYS */;
INSERT INTO `dungtich` VALUES (1,50),(2,75),(3,100),(4,125),(5,150),(6,200),(7,250),(8,500),(9,750),(10,1000);
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
  PRIMARY KEY (`ma_dung_tich`,`ma_nuoc_hoa`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `dungtich_nuochoa_ibfk_1` FOREIGN KEY (`ma_dung_tich`) REFERENCES `dungtich` (`ma_dung_tich`),
  CONSTRAINT `dungtich_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dungtich_nuochoa`
--

LOCK TABLES `dungtich_nuochoa` WRITE;
/*!40000 ALTER TABLE `dungtich_nuochoa` DISABLE KEYS */;
INSERT INTO `dungtich_nuochoa` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10);
/*!40000 ALTER TABLE `dungtich_nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoadon` (
  `ma_hoa_don` int NOT NULL,
  `ma_khach_hang` int DEFAULT NULL,
  `ma_dia_chi` int DEFAULT NULL,
  `thoi_gian` datetime DEFAULT NULL,
  `tong_tien` double DEFAULT NULL,
  `trang_thai_don_hang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_hoa_don`),
  KEY `ma_khach_hang` (`ma_khach_hang`),
  KEY `ma_dia_chi` (`ma_dia_chi`),
  CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khachhang` (`ma_khach_hang`),
  CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`ma_dia_chi`) REFERENCES `diachi` (`ma_dia_chi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoadon`
--

LOCK TABLES `hoadon` WRITE;
/*!40000 ALTER TABLE `hoadon` DISABLE KEYS */;
INSERT INTO `hoadon` VALUES (1,1,3,'2025-03-15 11:42:41',5000000,'Đã giao'),(2,2,2,'2025-03-15 11:42:41',2300000,'Chờ xác nhận');
/*!40000 ALTER TABLE `hoadon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khachhang` (
  `ma_khach_hang` int NOT NULL,
  `ten_khach_hang` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `trang_thai_tai_khoan` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ma_khach_hang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khachhang`
--

LOCK TABLES `khachhang` WRITE;
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
INSERT INTO `khachhang` VALUES (1,'Nguyen Van A','a@gmail.com','nguyenvana','pass123',1),(2,'Tran Thi B','b@gmail.com','tranthib','pass123',1),(3,'Le Van C','c@gmail.com','levanc','pass123',1),(4,'Pham Minh D','d@gmail.com','phamminhd','pass123',1),(5,'Hoang Hoa E','e@gmail.com','hoanghoae','pass123',1),(6,'Dang Thi F','f@gmail.com','dangthif','pass123',1),(7,'Vu Huu G','g@gmail.com','vuhuug','pass123',1),(8,'Bui Van H','h@gmail.com','buivanh','pass123',1),(9,'Ly Kieu I','i@gmail.com','lykieui','pass123',1),(10,'Do Anh J','j@gmail.com','doanhj','pass123',1);
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
  `nong_do` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_nong_do`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nongdo`
--

LOCK TABLES `nongdo` WRITE;
/*!40000 ALTER TABLE `nongdo` DISABLE KEYS */;
INSERT INTO `nongdo` VALUES (1,'Eau de Toilette'),(2,'Eau de Parfum'),(3,'Parfum'),(4,'Eau Fraîche'),(5,'Cologne'),(6,'Extrait de Parfum'),(7,'Body Mist'),(8,'Hair Mist'),(9,'Solid Perfume'),(10,'Oil Perfume');
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
  CONSTRAINT `nongdo_nuochoa_ibfk_1` FOREIGN KEY (`ma_nong_do`) REFERENCES `nongdo` (`ma_nong_do`),
  CONSTRAINT `nongdo_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nongdo_nuochoa`
--

LOCK TABLES `nongdo_nuochoa` WRITE;
/*!40000 ALTER TABLE `nongdo_nuochoa` DISABLE KEYS */;
INSERT INTO `nongdo_nuochoa` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10);
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
  `not_huong` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_not_huong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nothuong`
--

LOCK TABLES `nothuong` WRITE;
/*!40000 ALTER TABLE `nothuong` DISABLE KEYS */;
INSERT INTO `nothuong` VALUES (1,'Cam Bergamot'),(2,'Hoa Oải Hương'),(3,'Gỗ Đàn Hương'),(4,'Xạ Hương'),(5,'Hương Thảo'),(6,'Vani'),(7,'Quế'),(8,'Táo Xanh'),(9,'Bạc Hà'),(10,'Hổ Phách');
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
  `loai` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ma_not_huong`,`ma_nuoc_hoa`),
  KEY `ma_nuoc_hoa` (`ma_nuoc_hoa`),
  CONSTRAINT `nothuong_nuochoa_ibfk_1` FOREIGN KEY (`ma_not_huong`) REFERENCES `nothuong` (`ma_not_huong`),
  CONSTRAINT `nothuong_nuochoa_ibfk_2` FOREIGN KEY (`ma_nuoc_hoa`) REFERENCES `nuochoa` (`ma_nuoc_hoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nothuong_nuochoa`
--

LOCK TABLES `nothuong_nuochoa` WRITE;
/*!40000 ALTER TABLE `nothuong_nuochoa` DISABLE KEYS */;
INSERT INTO `nothuong_nuochoa` VALUES (1,1,'Hương đầu'),(2,2,'Hương giữa'),(3,3,'Hương cuối'),(4,4,'Hương đầu'),(5,5,'Hương giữa'),(6,6,'Hương cuối'),(7,7,'Hương đầu'),(8,8,'Hương giữa'),(9,9,'Hương cuối'),(10,10,'Hương đầu');
/*!40000 ALTER TABLE `nothuong_nuochoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nuochoa`
--

DROP TABLE IF EXISTS `nuochoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nuochoa` (
  `ma_nuoc_hoa` int NOT NULL,
  `ten_nuoc_hoa` varchar(255) DEFAULT NULL,
  `gioi_tinh` varchar(30) DEFAULT NULL,
  `gia_ban` double DEFAULT NULL,
  `tinh_trang` tinyint(1) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text,
  `ma_thuong_hieu` int DEFAULT NULL,
  PRIMARY KEY (`ma_nuoc_hoa`),
  KEY `ma_thuong_hieu` (`ma_thuong_hieu`),
  CONSTRAINT `nuochoa_ibfk_1` FOREIGN KEY (`ma_thuong_hieu`) REFERENCES `thuonghieu` (`ma_thuong_hieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nuochoa`
--

LOCK TABLES `nuochoa` WRITE;
/*!40000 ALTER TABLE `nuochoa` DISABLE KEYS */;
INSERT INTO `nuochoa` VALUES (1,'Bleu de Chanel','Nam',2500000,1,'bleu.jpg','Hương gỗ mạnh mẽ nam tính.',1),(2,'Sauvage Dior','Nam',2300000,1,'sauvage.jpg','Hương cam chanh tươi mát.',2),(3,'Gucci Guilty','Nữ',2800000,1,'guilty.jpg','Hương hoa cỏ sang trọng.',3),(4,'Eros Versace','Nam',2700000,1,'eros.jpg','Hương bạc hà, chanh tươi.',4),(5,'Oud Wood','Unisex',3500000,1,'oudwood.jpg','Hương gỗ trầm ấm áp.',5),(6,'My Burberry','Nữ',2600000,1,'myburberry.jpg','Hương hoa cỏ nhẹ nhàng.',6),(7,'CK One','Unisex',1900000,1,'ckone.jpg','Hương cam bergamot tươi mát.',7),(8,'YSL Libre','Nữ',3100000,1,'libre.jpg','Hương lavender và vani ngọt ngào.',8),(9,'Acqua di Gio','Nam',2200000,1,'acquadigio.jpg','Hương biển mát lạnh.',9),(10,'Boss Bottled','Nam',2400000,1,'bossbottled.jpg','Hương táo và quế ấm áp.',10);
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
  `ten_thuong_hieu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ma_thuong_hieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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

-- Dump completed on 2025-03-15 11:47:56
