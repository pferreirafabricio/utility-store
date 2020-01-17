CREATE DATABASE  IF NOT EXISTS `lojaferramentas` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lojaferramentas`;
-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: lojaferramentas
-- ------------------------------------------------------
-- Server version	5.7.28-log

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
-- Table structure for table `tblcaixa`
--

DROP TABLE IF EXISTS `tblcaixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcaixa` (
  `idCaixa` int(5) NOT NULL AUTO_INCREMENT,
  `dataCaixa` datetime NOT NULL,
  `nomeFuncionario` varchar(60) NOT NULL,
  `idPedido` varchar(45) NOT NULL,
  `nomeUsuario` varchar(60) NOT NULL,
  PRIMARY KEY (`idCaixa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcaixa`
--

LOCK TABLES `tblcaixa` WRITE;
/*!40000 ALTER TABLE `tblcaixa` DISABLE KEYS */;
INSERT INTO `tblcaixa` VALUES (1,'2019-11-21 22:47:00','FabrÃ­cio Pinto','34','fabreco');
/*!40000 ALTER TABLE `tblcaixa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcarrinho`
--

DROP TABLE IF EXISTS `tblcarrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcarrinho` (
  `idUsuario` varchar(60) NOT NULL,
  `idProduto` int(5) NOT NULL,
  `quantidadeProduto` int(11) NOT NULL,
  `precoProduto` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcarrinho`
--

LOCK TABLES `tblcarrinho` WRITE;
/*!40000 ALTER TABLE `tblcarrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblcarrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldetpedido`
--

DROP TABLE IF EXISTS `tbldetpedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbldetpedido` (
  `idPedido` int(5) NOT NULL,
  `idProduto` int(5) NOT NULL,
  `quantidadeComprada` int(11) NOT NULL,
  `valorTotal` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idPedido`,`idProduto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldetpedido`
--

LOCK TABLES `tbldetpedido` WRITE;
/*!40000 ALTER TABLE `tbldetpedido` DISABLE KEYS */;
INSERT INTO `tbldetpedido` VALUES (50,1,1,20.00),(50,2,1,40.00);
/*!40000 ALTER TABLE `tbldetpedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfornecedores`
--

DROP TABLE IF EXISTS `tblfornecedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblfornecedores` (
  `idFornecedor` int(5) NOT NULL AUTO_INCREMENT,
  `cnpjFornecedor` int(11) NOT NULL,
  `nomeFornecedor` varchar(60) NOT NULL,
  PRIMARY KEY (`idFornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfornecedores`
--

LOCK TABLES `tblfornecedores` WRITE;
/*!40000 ALTER TABLE `tblfornecedores` DISABLE KEYS */;
INSERT INTO `tblfornecedores` VALUES (1,321,'A empresa do MB'),(2,321,'Aonde o Sol nÃ£o Bate');
/*!40000 ALTER TABLE `tblfornecedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpedidos`
--

DROP TABLE IF EXISTS `tblpedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpedidos` (
  `idPedido` int(5) NOT NULL AUTO_INCREMENT,
  `idUsuarioPedido` varchar(60) NOT NULL,
  `statusPedido` varchar(10) NOT NULL,
  `dataHoraPedido` datetime DEFAULT NULL,
  PRIMARY KEY (`idPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpedidos`
--

LOCK TABLES `tblpedidos` WRITE;
/*!40000 ALTER TABLE `tblpedidos` DISABLE KEYS */;
INSERT INTO `tblpedidos` VALUES (50,'fabreco','Fechado','2019-11-21 20:31:00');
/*!40000 ALTER TABLE `tblpedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpessoas`
--

DROP TABLE IF EXISTS `tblpessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpessoas` (
  `idPessoa` int(5) NOT NULL AUTO_INCREMENT,
  `cpfPessoa` int(11) NOT NULL,
  `nomePessoa` varchar(60) NOT NULL,
  `dtNascPessoa` date NOT NULL,
  `tipoPessoa` varchar(1) NOT NULL,
  PRIMARY KEY (`idPessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpessoas`
--

LOCK TABLES `tblpessoas` WRITE;
/*!40000 ALTER TABLE `tblpessoas` DISABLE KEYS */;
INSERT INTO `tblpessoas` VALUES (28,123,'Fabricio','2001-08-29','f'),(29,321,'Erik','2001-08-29','f'),(30,987,'Andrey','2002-10-08','c');
/*!40000 ALTER TABLE `tblpessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblprodfornec`
--

DROP TABLE IF EXISTS `tblprodfornec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblprodfornec` (
  `idProdFornec` int(5) NOT NULL AUTO_INCREMENT,
  `idProduto` int(5) NOT NULL,
  `idFornecedor` int(5) NOT NULL,
  PRIMARY KEY (`idProdFornec`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblprodfornec`
--

LOCK TABLES `tblprodfornec` WRITE;
/*!40000 ALTER TABLE `tblprodfornec` DISABLE KEYS */;
INSERT INTO `tblprodfornec` VALUES (1,17,1);
/*!40000 ALTER TABLE `tblprodfornec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblprodutos`
--

DROP TABLE IF EXISTS `tblprodutos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblprodutos` (
  `idProduto` int(5) NOT NULL AUTO_INCREMENT,
  `valorProduto` decimal(5,2) NOT NULL,
  `nomeProduto` varchar(60) NOT NULL,
  `quantidadeProduto` int(11) NOT NULL,
  PRIMARY KEY (`idProduto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblprodutos`
--

LOCK TABLES `tblprodutos` WRITE;
/*!40000 ALTER TABLE `tblprodutos` DISABLE KEYS */;
INSERT INTO `tblprodutos` VALUES (1,20.00,'Martelo',4),(2,40.00,'Serrote',4),(3,300.00,'Maquita do Beto',6),(4,20.00,'Alicate',10),(5,10.00,'Chave de Fenda',15),(6,30.00,'Enxada',4);
/*!40000 ALTER TABLE `tblprodutos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusuario`
--

DROP TABLE IF EXISTS `tblusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblusuario` (
  `idUsuario` int(5) NOT NULL AUTO_INCREMENT,
  `idPessoa` int(5) NOT NULL,
  `nomeUsuario` varchar(60) NOT NULL,
  `senhaUsuario` varchar(50) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusuario`
--

LOCK TABLES `tblusuario` WRITE;
/*!40000 ALTER TABLE `tblusuario` DISABLE KEYS */;
INSERT INTO `tblusuario` VALUES (13,28,'fabreco','fabreco'),(14,29,'erikosa','erikosa'),(15,30,'andrey','andrey');
/*!40000 ALTER TABLE `tblusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'lojaferramentas'
--

--
-- Dumping routines for database 'lojaferramentas'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-22  8:12:49
