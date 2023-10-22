
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



