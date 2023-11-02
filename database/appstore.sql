
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

drop table if exists roles;
create table roles
(
	idrol		int primary key auto_increment,
    rol			varchar(30)		not null,
	create_at		datetime				not null 	default now(),
    update_at		date				null,
    inactive_at		date				null,
    constraint uk_rol_roles unique(rol)
)engine = innodb;

drop table if exists nacionalidades;
create table nacionalidades
(
	idnacionalidad		int primary key auto_increment,
    nombrepais			varchar(60)  	not null,
    nombrecorto			char(3)			not null,
	create_at		datetime				not null 	default now(),
    update_at		date				null,
    inactive_at		date				null,
    constraint uk_nombrepais_nac unique(nombrepais,nombrecorto)
)engine = innodb;

drop table if exists usuarios;
create table usuarios
(
	idusuario		int 				primary key 	auto_increment,
    avatar			varchar(100)		null,
    idrol			int 				not null,
    idnacionalidad	int					not null,
    apellidos		varchar(40) 		not null,
    nombres			varchar(40)			not null,
    email			varchar(60)			not null,
    claveacceso		varchar(60)			not null,
    create_at		date			not null 	default now(),
    update_at		date				null,
    inactive_at		date				null,
	constraint fk_idrol_usu	foreign key(idrol) references roles(idrol),
    constraint fk_idnacionalida_usu	foreign key(idnacionalidad) references nacionalidades(idnacionalidad)
)engine = innodb;

drop table if exists datasheet;
create table datasheet
(
	idespecificacion		int 		primary key auto_increment,
    idproducto			int			not null,
    clave				varchar(50) not null,
    valor				varchar(300) not null,
	create_at			date				not null 	default now(),
    update_at			date				null,
    inactive_at			date				null,
    constraint fk_idproducto_data foreign key(idproducto) references productos(idproducto),
    constraint uk_valor_data unique(clave)
)engine = innodb;

drop table if exists galeria;
create table galeria
(
	idgaleria			int primary key auto_increment,
    idproducto			int					not null,
    rutafoto			varchar(250)		not null,
	create_at			date				not null 	default now(),
    update_at			date				null,
    inactive_at			date				null,
    constraint fk_idproducto_gal foreign key(idproducto) references productos(idproducto)
)engine = innodb;