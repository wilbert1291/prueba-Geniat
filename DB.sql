-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: prueba_geniat
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblpublicaciones`
--

DROP TABLE IF EXISTS `tblpublicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpublicaciones` (
  `idPublicacion` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `borrado` int(11) NOT NULL,
  PRIMARY KEY (`idPublicacion`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `tblpublicaciones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tblusuarios` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpublicaciones`
--

LOCK TABLES `tblpublicaciones` WRITE;
/*!40000 ALTER TABLE `tblpublicaciones` DISABLE KEYS */;
INSERT INTO `tblpublicaciones` VALUES (1,'Hola mundo actualizado','Descripcion actualizada','2022-08-27 18:33:56',1,0),(2,'Hola mundo actualizado','Descripcion actualizada','2022-08-27 18:35:43',1,1);
/*!40000 ALTER TABLE `tblpublicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblroles`
--

DROP TABLE IF EXISTS `tblroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblroles` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionRol` varchar(50) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblroles`
--

LOCK TABLES `tblroles` WRITE;
/*!40000 ALTER TABLE `tblroles` DISABLE KEYS */;
INSERT INTO `tblroles` VALUES (1,'Rol básico'),(2,'Rol medio'),(3,'Rol medio alto'),(4,'Rol alto medio'),(5,'Rol alto');
/*!40000 ALTER TABLE `tblroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusuarios`
--

DROP TABLE IF EXISTS `tblusuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblusuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `idRol` int(11) NOT NULL,
  `tokenJWT` varchar(256) DEFAULT NULL,
  `creacionToken` varchar(100) DEFAULT NULL,
  `expiracionToken` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idRol` (`idRol`),
  CONSTRAINT `tblusuarios_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `tblroles` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusuarios`
--

LOCK TABLES `tblusuarios` WRITE;
/*!40000 ALTER TABLE `tblusuarios` DISABLE KEYS */;
INSERT INTO `tblusuarios` VALUES (1,'Wilbert Eduardo','Villegas Gutierrez','wilbert1291@gmail.com','e10adc3949ba59abbe56e057f20f883e',5,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjE2NjgyMDgsImV4cCI6MTY2MTY2ODIyMywiZGF0YSI6eyJpZCI6IjEiLCJlbWFpbCI6IndpbGJlcnQxMjkxQGdtYWlsLmNvbSIsInJvbCI6IjUifX0.mDOph0-A4Onp0nIS7W5tpT3argQ0m13w1OLm877hWP4','1661668208','1661668223');
/*!40000 ALTER TABLE `tblusuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-28  2:29:45
