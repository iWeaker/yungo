-- MariaDB dump 10.19  Distrib 10.5.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: yungo
-- ------------------------------------------------------
-- Server version	10.5.11-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_client` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_client` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (23,'Alejandro Bringas','iweaker4you@gmail.com','6861096448'),(25,'Alejasdk','asdasd@asdasd','686109'),(26,'Paul Nieblas','paulN2012@gmail.com','6645963251'),(27,'Mario Benson','xxx@you.com','123123124'),(28,'Vivian Long','qwerty@me.com','135797531'),(29,'Alexis Gutierrez','gutierrezAle@email.com','6861096448'),(30,'Gustavo Martinez','tavoR7@red7.com.net','6862584679'),(31,'Saul Hernandez','osunasaul98@live.com','6862829507'),(32,'Eliazar Blanco Ochoa','ebo@gmail.ar','4748314329'),(33,'Emiliano Gaytan','emiYungo@yungo.mx','9991234567'),(34,'Evo Morales Pinochet','emp@callofduty.org.bo','5623145870'),(35,'Jose Hernandez Dominguez','jhd780301@outlook.com','6863412756'),(36,'Alejandro PHP8','php@gmail.com','6861096448');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_comment` tinyint(1) NOT NULL,
  `created_at_comment` datetime NOT NULL,
  `fk_ticket_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F54B3FC011599042` (`fk_ticket_id`),
  CONSTRAINT `FK_F54B3FC011599042` FOREIGN KEY (`fk_ticket_id`) REFERENCES `ticket` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientes_id` int(11) NOT NULL,
  `name_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_zone_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F384BE95FBC3AF09` (`clientes_id`),
  KEY `FK_F384BE956F030287` (`fk_zone_id`),
  CONSTRAINT `FK_F384BE956F030287` FOREIGN KEY (`fk_zone_id`) REFERENCES `sitios` (`id`),
  CONSTRAINT `FK_F384BE95FBC3AF09` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES (26,23,'Av Vallecitos #3394 Real del Rio',24),(29,25,'Av Vallecitos #3394 Real del Rio',24),(30,23,'Calle Vallecitos',1088),(31,36,'calle rio norte #2148',1088);
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210708125459','2021-07-08 05:55:06',29),('DoctrineMigrations\\Version20210708174630','2021-07-08 10:46:54',93),('DoctrineMigrations\\Version20210710172837','2021-07-13 09:55:45',98);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac_inventory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_inventory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_inventory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_inventory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (6,'C1:C2:C3:C4:C5:C9','PowerBeam2','TP-LINK','Radio'),(7,'B1:B2:B3:B4:B5:B6','B23','Ubiquiti','Router'),(8,'C1:C2:C3:C4:C5:C6','LiteBeam','Ubiquiti','Omni'),(9,'A1:A2:A3:A4:A5:A6','X','Mercury','Septorial'),(10,'C3:F4:A1:C3:B2:C4','LiteBeam','Ubiquiti','Radio'),(11,'C1:C3:D3:F1:A5:B2','BMC-045','TP-LINK','Router'),(12,'3D:F2:C9:A6:B3:4F','TP-8','Mercusys','Router');
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paquete`
--

DROP TABLE IF EXISTS `paquete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_packet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity_packet` int(11) NOT NULL,
  `price_packet` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paquete`
--

LOCK TABLES `paquete` WRITE;
/*!40000 ALTER TABLE `paquete` DISABLE KEYS */;
INSERT INTO `paquete` VALUES (1,'Elemental10/10',10,349),(2,'Estandar20/20',20,499),(3,'Optimo30/30',30,599),(4,'Invicto50/50',50,899),(5,'Absoluto100/100',100,1399);
/*!40000 ALTER TABLE `paquete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_address_id` int(11) NOT NULL,
  `fk_packet_id` int(11) DEFAULT NULL,
  `fk_inventary_id` int(11) DEFAULT NULL,
  `ip_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CB86F22A1239C430` (`fk_inventary_id`),
  UNIQUE KEY `UNIQ_CB86F22A9F50DAFC` (`fk_inventary_id`),
  KEY `IDX_CB86F22A5D965E6` (`fk_address_id`),
  KEY `FK_CB86F22A9F50DAFB` (`fk_packet_id`),
  CONSTRAINT `FK_CB86F22A1239C430` FOREIGN KEY (`fk_inventary_id`) REFERENCES `inventario` (`id`),
  CONSTRAINT `FK_CB86F22A5D965E6` FOREIGN KEY (`fk_address_id`) REFERENCES `direccion` (`id`),
  CONSTRAINT `FK_CB86F22A9F50DAFB` FOREIGN KEY (`fk_packet_id`) REFERENCES `paquete` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (18,26,1,NULL,'172.168.1.1'),(20,29,1,NULL,'172.168.1.18'),(21,26,2,NULL,'172.168.1.4'),(22,31,3,NULL,'172.150.150.150');
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sitios`
--

DROP TABLE IF EXISTS `sitios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sitios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1089 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sitios`
--

LOCK TABLES `sitios` WRITE;
/*!40000 ALTER TABLE `sitios` DISABLE KEYS */;
INSERT INTO `sitios` VALUES (8,'Alcala'),(12,'Santo Domingo'),(20,'Bosques del Sol'),(24,'Alamitos'),(28,'Villa del Cedro'),(1088,'Aries');
/*!40000 ALTER TABLE `sitios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ticket` datetime NOT NULL,
  `desc_ticket` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_ticket` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_97A0ADA378B2BEB1` (`fk_client_id`),
  KEY `IDX_97A0ADA3ED5CA9E6` (`service_id`),
  CONSTRAINT `FK_97A0ADA378B2BEB1` FOREIGN KEY (`fk_client_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_97A0ADA3ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `servicio` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (10,'Ancho de banda','2021-07-30 19:23:36','Tiene problemas de internet','Abierto',23,18),(11,'Bloqueo de Paginas','2021-08-02 10:28:24','Dice que no se le conecta a paginas concretas','Abierto',25,20),(20,'Cobertura','2021-08-02 11:12:01','Se mio solo','Nuevo',23,18),(21,'Otros','2021-08-02 11:13:52','asd','Nuevo',23,18),(22,'Cobertura','2021-08-02 11:54:13','Tiene poco alcance bala bla','Abierto',23,18);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-02 12:11:24
