CREATE DATABASE  IF NOT EXISTS `horarios` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `horarios`;
-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: 127.0.0.1    Database: horarios
-- ------------------------------------------------------
-- Server version	5.6.23

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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `nControl` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `a_paterno` varchar(50) NOT NULL,
  `a_materno` varchar(50) DEFAULT NULL,
  `carrera` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `claveApi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`nControl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES ('i15120278','Zaira','Sandoval','Garcia','INF','zahyrasg09@gmail.com','$2y$10$zBCLHG6s.zQr8gtXlk5cR.GggTMolKIvryvjMONU6QW7VkMwkrVPO','b0655441b5987b9ba64d6b25692e2263'),('I15120290','Jovanni','Vazquez','Abrego','INF','i15120290@alumnos.itsur.edu.mx','$2y$10$aCn0LTOVLtwZ0ivqBIvj.ekAOqvyG0h9f8gjyYIg70IJKZcpliw5e','08fb3204426f910a7e9c1a77e029debc');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignaturas` (
  `clave_asig` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `creditos` int(11) DEFAULT NULL,
  `ht` int(11) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  PRIMARY KEY (`clave_asig`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaturas`
--

LOCK TABLES `asignaturas` WRITE;
/*!40000 ALTER TABLE `asignaturas` DISABLE KEYS */;
INSERT INTO `asignaturas` VALUES ('IFF-1019','Programación en ambiente cliente servidor',3,2,5),('IFF-1026','Tópicos de bases de datos',3,2,5),('IFF-2020','Inteligencia',3,3,2),('IFF-2121','Auditoria',3,5,0),('TIF-1402','Cómputo en la nube',3,2,5);
/*!40000 ALTER TABLE `asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dias`
--

DROP TABLE IF EXISTS `dias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dias` (
  `clave_dia` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`clave_dia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias`
--

LOCK TABLES `dias` WRITE;
/*!40000 ALTER TABLE `dias` DISABLE KEYS */;
/*!40000 ALTER TABLE `dias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos` (
  `clave_grupo` varchar(10) NOT NULL,
  `alumno` varchar(10) NOT NULL,
  `asignatura` varchar(10) NOT NULL,
  KEY `fk_alumno_asignatura` (`alumno`),
  KEY `fk_asingatura_alumno` (`asignatura`),
  CONSTRAINT `fk_alumno_asignatura` FOREIGN KEY (`alumno`) REFERENCES `alumnos` (`nControl`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_asingatura_alumno` FOREIGN KEY (`asignatura`) REFERENCES `asignaturas` (`clave_asig`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES ('CN2019','i15120278','TIF-1402'),('PACS2019','i15120278','IFF-1019'),('TOPBD2019','I15120290','IFF-1026'),('AU3456','i15120278','IFF-2121'),('IN892','i15120278','IFF-2020'),('CN2019','I15120290','TIF-1402'),('CN2019','I15120290','TIF-1402');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horas`
--

DROP TABLE IF EXISTS `horas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horas` (
  `clave_horas` int(11) NOT NULL AUTO_INCREMENT,
  `hora` time NOT NULL,
  `asignatura` varchar(10) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  PRIMARY KEY (`clave_horas`),
  KEY `fk_asignatura_dia` (`asignatura`),
  KEY `fk_dia_asignatura` (`dia`),
  CONSTRAINT `fk_asignatura_dia` FOREIGN KEY (`asignatura`) REFERENCES `asignaturas` (`clave_asig`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dia_asignatura` FOREIGN KEY (`dia`) REFERENCES `dias` (`clave_dia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horas`
--

LOCK TABLES `horas` WRITE;
/*!40000 ALTER TABLE `horas` DISABLE KEYS */;
/*!40000 ALTER TABLE `horas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-06 13:08:57
