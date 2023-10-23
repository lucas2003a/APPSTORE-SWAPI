CREATE DATABASE appstore;
USE appstore;

CREATE TABLE categorias (
	idcategoria INT PRIMARY KEY AUTO_INCREMENT,
	categoria 	VARCHAR(30)	NOT NULL,
	create_at 	DATETIME		DEFAULT NOW(),
	update_at	DATETIME		NULL,
	inactive_at	CHAR(1)		NULL
)ENGINE = INNODB;


CREATE TABLE productos(
	idproducto	INT PRIMARY KEY AUTO_INCREMENT,
	idcategoria INT 				NOT NULL,
	descripcion VARCHAR(150)	NOT NULL,
	precio		FLOAT(7,2)		NOT NULL,
	garantia		VARCHAR(100)	NOT NULL,
	fotografia	VARCHAR(100)	NULL,
	create_at 	DATETIME		DEFAULT NOW(),
	update_at	DATETIME			NULL,
	inactive_at	CHAR(1)		 	NULL,
	CONSTRAINT fk_idcategoria FOREIGN KEY (idcategoria) REFERENCES categorias(idcategoria)
)ENGINE = INNODB;

SELECT * FROM categorias
SELECT * FROM productos

INSERT INTO categorias(categoria) VALUES
	('Computadoras'),
	('Telefonos Moviles'),
	('Monitores'),
	('Accesorios'),
	('Perifericos');

INSERT INTO productos(idcategoria, descripcion, precio, garantia) VALUES
	(1,'Laptop HP Pavilon',2500,'12 meses'),
	(2,'iPhone 13 Pro',3500,'24 meses'),
	(3,'Monitor LG 27',1000,'12 meses'),
	(4,'Auricular Sony',250,'12 meses'),
	(5,'Impresora a Epson',1500,'18 meses');


DELIMITER $$
CREATE PROCEDURE spu_productos_listar ()
BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON cat.idcategoria = pro.idcategoria
	WHERE pro.inactive_at IS NULL;
END $$

DELIMITER $$
CREATE PROCEDURE spu_productos_buscar (IN idproducto INT)
BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON pro.idcategoria = cat.idcategoria
	WHERE pro.idproducto = idproducto;
END $$

CALL spu_productos_listar;
CALL spu_productos_buscar(1);


DELIMITER $$
CREATE PROCEDURE spu_productos_registrar
(
	IN _idcategoria	INT,
	IN _descripcion 	VARCHAR(150),
	IN _precio			FLOAT(7,2),
	IN _garantia		VARCHAR(100),
	IN _fotografia		VARCHAR(100)
)
BEGIN
	INSERT INTO productos
		(idcategoria, descripcion, precio, garantia, fotografia)
		VALUES
		(_idcategoria, _descripcion, _precio, _garantia, NULLIF(_fotografia, ''));
END $$

CALL spu_productos_registrar(1,'Laptop Lenovo i7',4500,'12 meses', '')


DELIMITER $$
CREATE PROCEDURE spu_categorias_listar()
BEGIN
	SELECT categoria FROM categorias
	WHERE inactive_at IS NULL;
END $$

DELIMITER $$
CREATE PROCEDURE spu_categorias_registrar(
	IN _categoria 	VARCHAR(30)
)
BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END $$

CALL spu_categorias_registrar("Laptop");
CALL spu_categorias_listar

