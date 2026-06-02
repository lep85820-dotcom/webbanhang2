-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: banhang
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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Điện thoại','Các loại điện thoại thông minh','2026-05-26 02:33:33'),(2,'Laptop','Máy tính xách tay các loại','2026-05-26 02:33:33'),(3,'Phụ kiện','Phụ kiện công nghệ','2026-05-26 02:33:33');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,1,2,1,1200000.00),(2,2,2,1,1200000.00),(3,3,2,2,1200000.00),(4,4,12,1,500000.00),(5,5,12,1,500000.00),(6,6,12,1,500000.00),(7,7,12,1,500000.00),(8,8,12,1,500000.00),(9,9,12,1,500000.00),(10,10,12,1,500000.00),(11,11,13,1,500000.00),(12,12,13,1,500000.00);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'lê xuân triều ','0327459949','thủ đức ',1200000.00,'pending','2026-05-26 02:22:27'),(2,'lê xuân tri','0327459949','dong nai ',1200000.00,'pending','2026-05-26 02:26:14'),(3,'lê xuân tri','0327459949','qưeqwe',2400000.00,'pending','2026-05-26 02:33:49'),(4,'lê xuân triều','0327459949','thủ đức',500000.00,'pending','2026-05-26 03:03:13'),(5,'lê xuân triều','0327459949','thủ đức',500000.00,'pending','2026-05-26 03:03:13'),(6,'lê xuân triều','0327459949','qư',500000.00,'pending','2026-05-26 03:26:35'),(7,'lê xuân triều','0327459949','11',500000.00,'pending','2026-05-26 03:30:05'),(8,'lê xuân triều','0327459949','qư',500000.00,'pending','2026-05-26 03:34:52'),(9,'lê xuân triều','0327459949','qư',500000.00,'pending','2026-05-26 03:34:58'),(10,'lê xuân triều','0327459949','qư',500000.00,'pending','2026-05-26 03:35:03'),(11,'lê xuân triều','0327459949','thủ đức',500000.00,'cancelled','2026-05-26 03:37:45'),(12,'lê xuân triều','0327459949','2133213',500000.00,'pending','2026-05-26 03:39:00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(15,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'iphone   11','a2132',1200000.00,'uploads/190199224599-lio_r5tmvejlwtemyuii.webp',1,'2026-05-26 02:22:00'),(4,'iPhone 15 Pro Max 256GB','Điện thoại thông minh cao cấp nhất của Apple với khung viền Titan nhẹ và bền bỉ.',1000000.00,'uploads/10.webp',1,'2026-05-26 02:36:51'),(5,'Samsung Galaxy S24 Ultra','Flagship mới nhất từ Samsung với các tính năng Galaxy AI thông minh đột phá.',1000000.00,'uploads/9.webp',1,'2026-05-26 02:36:51'),(6,'Google Pixel 8 Pro','Điện thoại thuần Android với hệ thống camera AI đỉnh cao và mượt mà nhất.',1000000.00,'uploads/OIP.webp',1,'2026-05-26 02:36:51'),(7,'Xiaomi 14 Ultra','Siêu phẩm camera hợp tác với Leica mang lại chất lượng ảnh chụp nghệ thuật.',1000000.00,'uploads/d36105f6de5a716a1c0737352c2827be.webp',1,'2026-05-26 02:36:51'),(8,'MacBook Pro M3 14 inch','Dòng máy tính xách tay chuyên nghiệp của Apple với hiệu năng cực khủng của chip M3.',2000000.00,'uploads/7.webp',2,'2026-05-26 02:36:51'),(9,'Dell XPS 13 Plus','Ultrabook chạy Windows sang trọng bậc nhất với màn hình tràn viền vô cực OLED.',2000000.00,'uploads/6.webp',2,'2026-05-26 02:36:51'),(10,'ASUS ROG Zephyrus G14','Laptop gaming mỏng nhẹ, mạnh mẽ bậc nhất phục vụ hoàn hảo cả chơi game và làm việc.',2000000.00,'uploads/5.webp',2,'2026-05-26 02:36:51'),(11,'Lenovo ThinkPad X1 Carbon','Laptop doanh nhân huyền thoại với độ bền chuẩn quân đội và bàn phím gõ êm nhất.',2000000.00,'uploads/4.jfif',2,'2026-05-26 02:36:51'),(12,'Tai nghe AirPods Pro 2','Tai nghe true wireless chống ồn chủ động tốt nhất hiện nay của Apple.',500000.00,'uploads/3.webp',3,'2026-05-26 02:36:51'),(13,'Bàn phím cơ Keychron K2 V2','Bàn phím cơ không dây nhỏ gọn, tương thích hoàn hảo cho cả Mac và Windows.',500000.00,'uploads/2.jfif',3,'2026-05-26 02:36:51'),(14,'Chuột Logitech MX Master 3S','Chuột công thái học cao cấp hỗ trợ cuộn siêu nhanh và kết nối đa thiết bị.',500000.00,'uploads/1.jpg',3,'2026-05-26 02:36:51');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-26 10:47:35

