/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.28-MariaDB : Database - appstore
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`appstore` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `appstore`;

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(30) NOT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `inactive_at` char(1) DEFAULT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categorias` */

insert  into `categorias`(`idcategoria`,`categoria`,`create_at`,`update_at`,`inactive_at`) values 
(1,'Computadoras','2023-10-04 17:19:21',NULL,NULL),
(2,'Telefonos Moviles','2023-10-04 17:19:21',NULL,NULL),
(3,'Monitores','2023-10-04 17:19:21',NULL,NULL),
(4,'Accesorios','2023-10-04 17:19:21',NULL,NULL),
(5,'Perifericos','2023-10-04 17:19:21',NULL,NULL),
(6,'Laptop','2023-10-04 17:26:20',NULL,NULL),
(7,'thunder client','2023-10-04 17:33:08',NULL,NULL),
(8,'Test Android','2023-10-05 07:57:40',NULL,NULL),
(9,'thunder client2','2023-10-05 08:57:11',NULL,NULL),
(10,'Android','2023-10-05 08:57:34',NULL,NULL);

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` float(7,2) NOT NULL,
  `garantia` varchar(100) NOT NULL,
  `fotografia` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `inactive_at` char(1) DEFAULT NULL,
  PRIMARY KEY (`idproducto`),
  KEY `fk_idcategoria` (`idcategoria`),
  CONSTRAINT `fk_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `productos` */

insert  into `productos`(`idproducto`,`idcategoria`,`descripcion`,`precio`,`garantia`,`fotografia`,`create_at`,`update_at`,`inactive_at`) values 
(1,1,'Laptop HP Pavilon',2500.00,'12 meses',NULL,'2023-10-04 17:19:24',NULL,NULL),
(2,2,'iPhone 13 Pro',3500.00,'24 meses',NULL,'2023-10-04 17:19:24',NULL,NULL),
(3,3,'Monitor LG 27',1000.00,'12 meses',NULL,'2023-10-04 17:19:24',NULL,NULL),
(4,4,'Auricular Sony',250.00,'12 meses',NULL,'2023-10-04 17:19:24',NULL,NULL),
(5,5,'Impresora a Epson',1500.00,'18 meses',NULL,'2023-10-04 17:19:24',NULL,NULL),
(6,1,'Test',10.00,'10',NULL,'2023-10-05 07:52:26',NULL,NULL);

/* Procedure structure for procedure `spu_categorias_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_categorias_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_categorias_listar`()
begin
	select categoria from categorias
	where inactive_at is null;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_categorias_registrar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_categorias_registrar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_categorias_registrar`(
	in _categoria 	VARCHAR(30)
)
begin
	insert into categorias (categoria) values (_categoria);
end */$$
DELIMITER ;

/* Procedure structure for procedure `spu_productos_buscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_productos_buscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_buscar`(in idproducto int)
BEGIN 
	SELECT pro.idproducto, cat.categoria, pro.descripcion, pro.precio, pro.garantia, pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON pro.idcategoria = cat.idcategoria
	where pro.idproducto = idproducto;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_productos_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_productos_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_listar`()
BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON cat.idcategoria = pro.idcategoria
	where pro.inactive_at is null;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_productos_registrar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_productos_registrar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_registrar`(
	in _idcategoria	int,
	in _descripcion 	varchar(150),
	in _precio			float(7,2),
	in _garantia		varchar(100),
	in _fotografia		varchar(100)
)
Begin
	insert into productos
		(idcategoria, descripcion, precio, garantia, fotografia)
		values
		(_idcategoria, _descripcion, _precio, _garantia, nullif(_fotografia, ''));
end */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
