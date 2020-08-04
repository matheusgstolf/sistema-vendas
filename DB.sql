/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.11-MariaDB : Database - teste_multiplier
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`teste_multiplier` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `teste_multiplier`;

/*Table structure for table `cad_categorias` */

DROP TABLE IF EXISTS `cad_categorias`;

CREATE TABLE `cad_categorias` (
  `cod_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cad_categorias` */

insert  into `cad_categorias`(`cod_categoria`,`nom_categoria`) values 
(11,'NOTEBOOK'),
(12,'SSD'),
(13,'HARDWARE'),
(14,'SOFTWARE'),
(16,'SERVIDORES'),
(17,'NAS'),
(18,'DVDR'),
(19,'CAMERAS'),
(20,'TESTE'),
(21,'DFS');

/*Table structure for table `cad_fabricantes` */

DROP TABLE IF EXISTS `cad_fabricantes`;

CREATE TABLE `cad_fabricantes` (
  `cod_fabricante` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fabricante` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_fabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cad_fabricantes` */

insert  into `cad_fabricantes`(`cod_fabricante`,`nom_fabricante`) values 
(7,'ACER'),
(8,'Western Digital'),
(9,'CRUCIAL'),
(10,'HP'),
(11,'SANDISK'),
(12,'Dell'),
(13,'SANDISK'),
(14,'ASUS'),
(15,'INTEL'),
(16,'CORSAIR');

/*Table structure for table `cad_gerenciadorid` */

DROP TABLE IF EXISTS `cad_gerenciadorid`;

CREATE TABLE `cad_gerenciadorid` (
  `cod_sequencial` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sequencial` varchar(30) NOT NULL,
  `num_sequencial` int(100) NOT NULL DEFAULT 0,
  `dat_alteracao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cod_sequencial`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cad_gerenciadorid` */

insert  into `cad_gerenciadorid`(`cod_sequencial`,`nom_sequencial`,`num_sequencial`,`dat_alteracao`) values 
(1,'num_venda',26,'2020-07-30 19:06:47');

/*Table structure for table `cad_produtos` */

DROP TABLE IF EXISTS `cad_produtos`;

CREATE TABLE `cad_produtos` (
  `cod_reduzido` int(11) NOT NULL AUTO_INCREMENT,
  `cod_barra` decimal(14,0) DEFAULT NULL,
  `nom_produto` varchar(30) NOT NULL,
  `flg_status` char(1) NOT NULL DEFAULT 'A',
  `cod_categoria` int(11) NOT NULL,
  `cod_fabricante` int(11) NOT NULL,
  `cod_ncm` varchar(15) DEFAULT NULL,
  `cod_cest` varchar(7) DEFAULT NULL,
  `qtd_estoque` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_reduzido`),
  KEY `fk_categoria` (`cod_categoria`),
  KEY `fk_fabricantes` (`cod_fabricante`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`cod_categoria`) REFERENCES `cad_categorias` (`cod_categoria`),
  CONSTRAINT `fk_fabricantes` FOREIGN KEY (`cod_fabricante`) REFERENCES `cad_fabricantes` (`cod_fabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cad_produtos` */

insert  into `cad_produtos`(`cod_reduzido`,`cod_barra`,`nom_produto`,`flg_status`,`cod_categoria`,`cod_fabricante`,`cod_ncm`,`cod_cest`,`qtd_estoque`) values 
(13,0,'Acer Aspire Nitro 5','A',11,7,'8471.30.12','0',80),
(14,0,'SSD WD Green 240GB','A',12,8,'8471.30.12','0',98),
(15,0,'SSD CRUCIAL BX500','A',12,9,'1','1',92),
(16,0,'SSD HP 240GB','A',13,10,'8471.30.12','0',100),
(17,0,'HP Proliant ML310e','A',16,10,'8471.30.12','0',1),
(18,0,'HP Proliant ML30 Gen9','A',16,10,'8471.30.12','0',-2),
(19,0,'SSD SANDISK 120GB','A',13,11,'8471.30.12','0',100),
(20,4952878668,'CRUCIAL BALLISTIX SPORT 8GB DD','A',13,9,'8471.30.12','0',100),
(21,4712900997958,'PLACA MÃE TUF B360M-GAMING/BR','A',13,14,'8471.30.12','0',100),
(22,5032037150354,'INTEL CORE I5 9400F','A',13,15,'8471.30.12','0',100),
(23,8435910840170,'CORSAIR CX550W 80PLUS BRONZE','A',13,16,'8471.30.12','0',100);

/*Table structure for table `venda_item` */

DROP TABLE IF EXISTS `venda_item`;

CREATE TABLE `venda_item` (
  `num_venda` int(100) NOT NULL,
  `cod_reduzido` int(11) NOT NULL,
  `qtd_produto` int(10) NOT NULL,
  `vlr_unitario` decimal(12,2) NOT NULL,
  `perc_desconto` decimal(6,2) DEFAULT NULL,
  `vlr_desconto` float NOT NULL,
  `vlr_liquido` decimal(12,2) NOT NULL,
  `vlr_total` decimal(12,2) NOT NULL,
  `flg_excluido` char(1) DEFAULT NULL,
  KEY `fk_produto` (`cod_reduzido`),
  CONSTRAINT `fk_produto` FOREIGN KEY (`cod_reduzido`) REFERENCES `cad_produtos` (`cod_reduzido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `venda_item` */

insert  into `venda_item`(`num_venda`,`cod_reduzido`,`qtd_produto`,`vlr_unitario`,`perc_desconto`,`vlr_desconto`,`vlr_liquido`,`vlr_total`,`flg_excluido`) values 
(0,13,1,5700.00,5.00,285,-10545.00,5415.00,NULL),
(0,13,1,5700.00,5.50,313.5,-12169.50,5386.50,NULL),
(1,15,1,1.00,1.00,0.01,1.00,0.99,'S'),
(2,13,1,500.00,0.00,0,500.00,500.00,'S'),
(2,15,5,120.00,10.00,12,105.60,540.00,'S'),
(3,15,1,10.01,10.01,1.002,9.01,9.01,'S'),
(3,15,5,199.99,13.50,26.9986,172.99,864.96,'S'),
(3,15,5,199.99,13.50,26.9986,172.99,864.96,'S'),
(4,13,1,5.80,5.50,0.319,5.48,5.48,'S'),
(5,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(6,13,1,5.00,5.00,0.25,4.75,4.75,'S'),
(7,14,1,100.00,10.00,10,90.00,90.00,'S'),
(8,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(9,13,1,5700.00,50.00,2850,2850.00,2850.00,'S'),
(10,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(10,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(10,14,1,1.00,1.00,0.01,0.99,0.99,'S'),
(10,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(10,15,1,1.00,1.00,0.01,0.99,0.99,'S'),
(10,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(11,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(11,15,1,1.00,1.00,0.01,0.99,0.99,'S'),
(11,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(12,15,1,1.00,1.00,0.01,0.99,0.99,'S'),
(13,18,5,5000.00,15.00,750,4250.00,21250.00,NULL),
(14,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(15,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(15,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(16,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(17,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(18,18,1,1.00,1.00,0.01,0.99,0.99,NULL),
(19,18,1,1.00,1.00,0.01,0.99,0.99,NULL),
(20,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(21,13,1,1.00,1.00,0.01,0.99,0.99,'S'),
(22,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(23,18,1,1.00,1.00,0.01,0.99,0.99,'S'),
(24,13,1,1.00,1.00,0.01,0.99,0.99,NULL),
(25,18,1,5000.00,10.00,500,4500.00,4500.00,'S');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
