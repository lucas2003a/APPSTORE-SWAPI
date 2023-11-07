USE appstore;

INSERT INTO categorias(categoria) VALUES
	('Computadoras'),
	('Telefonos Moviles'),
	('Monitores'),
	('Accesorios'),
	('Perifericos');
    
SELECT * FROM categorias;

INSERT INTO productos(idcategoria, descripcion, precio, garantia) VALUES
	(1,'Laptop HP Pavilon',2500,'12 meses'),
	(2,'iPhone 13 Pro',3500,'24 meses'),
	(3,'Monitor LG 27',1000,'12 meses'),
	(4,'Auricular Sony',250,'12 meses'),
	(5,'Impresora a Epson',1500,'18 meses');
    
SELECT * FROM productos;
update productos set inactive_at = null;
delete from productos; 
alter table productos auto_increment = 1;



CALL spu_productos_listar();
CALL spu_productos_registrar(3,'Laptop Lenovo i6',4500,'04 meses', '');
call spu_products_eliminar();
CALL spu_productos_buscar(1);

CALL spu_categorias_registrar("Laptop");
CALL spu_categorias_listar();

insert into nacionalidades
	(nombrepais,nombrecorto)
	values
    ('Afganistán','AFG'),
('Åland','ALA'),
('Albania','ALB'),
('Alemania','DEU'),
('Andorra','AND'),
('Angola','AGO'),
('Anguila','AIA'),
('Antártida','ATA'),
('Antigua y Barbuda','ATG'),
('Arabia Saudita','SAU'),
('Argelia','DZA'),
('Argentina','ARG'),
('Armenia','ARM'),
('Aruba','ABW'),
('Australia','AUS'),
('Austria','AUT'),
('Azerbaiyán','AZE'),
('Bahamas','BHS'),
('Bangladés','BGD'),
('Barbados','BRB'),
('Baréin','BHR'),
('Bélgica','BEL'),
('Belice','BLZ'),
('Benín','BEN'),
('Bermudas','BMU'),
('Bielorrusia','BLR'),
('Bolivia','BOL'),
('Bonaire, San Eustaquio y Saba','BES'),
('Bosnia y Herzegovina','BIH'),
('Botsuana','BWA'),
('Brasil','BRA'),
('Brunéi','BRN'),
('Bulgaria','BGR'),
('Burkina Faso','BFA'),
('Burundi','BDI'),
('Bután','BTN'),
('Cabo Verde','CPV'),
('Camboya','KHM'),
('Camerún','CMR'),
('Canadá','CAN'),
('Catar','QAT'),
('Chad','TCD'),
('Chile','CHL'),
('China','CHN'),
('Chipre','CYP'),
('Colombia','COL'),
('Comoras','COM'),
('Corea del Norte','PRK'),
('Corea del Sur','KOR'),
('Costa de Marfil','CIV'),
('Costa Rica','CRI'),
('Croacia','HRV'),
('Cuba','CUB'),
('Curazao','CUW'),
('Dinamarca','DNK'),
('Dominica','DMA'),
('Ecuador','ECU'),
('Egipto','EGY'),
('El Salvador','SLV'),
('Emiratos Árabes Unidos','ARE'),
('Eritrea','ERI'),
('Eslovaquia','SVK'),
('Eslovenia','SVN'),
('España','ESP'),
('Estados Unidos','USA'),
('Estonia','EST'),
('Etiopía','ETH'),
('Filipinas','PHL'),
('Finlandia','FIN'),
('Fiyi','FJI'),
('Francia','FRA'),
('Gabón','GAB'),
('Gambia','GMB'),
('Georgia','GEO'),
('Ghana','GHA'),
('Gibraltar','GIB'),
('Granada','GRD'),
('Grecia','GRC'),
('Groenlandia','GRL'),
('Guadalupe','GLP'),
('Guam','GUM'),
('Guatemala','GTM'),
('Guayana Francesa','GUF'),
('Guernsey','GGY'),
('Guinea','GIN'),
('Guinea-Bisáu','GNB'),
('Guinea Ecuatorial','GNQ'),
('Guyana','GUY'),
('Haití','HTI'),
('Honduras','HND'),
('Hong Kong','HKG'),
('Hungría','HUN'),
('India','IND'),
('Indonesia','IDN'),
('Irak','IRQ'),
('Irán','IRN'),
('Irlanda','IRL'),
('Isla Bouvet','BVT'),
('Isla de Man','IMN'),
('Isla de Navidad','CXR'),
('Islandia','ISL'),
('Islas Caimán','CYM'),
('Islas Cocos','CCK'),
('Islas Cook','COK'),
('Islas Feroe','FRO'),
('Islas Georgias del Sur y Sandwich del Sur','SGS'),
('Islas Heard y McDonald','HMD'),
('Islas Malvinas','FLK'),
('Islas Marianas del Norte','MNP'),
('Islas Marshall','MHL'),
('Islas Pitcairn','PCN'),
('Islas Salomón','SLB'),
('Islas Turcas y Caicos','TCA'),
('Islas Ultramarinas Menores de los Estados Unidos','UMI'),
('Islas Vírgenes Británicas','VGB'),
('Islas Vírgenes de los Estados Unidos','VIR'),
('Israel','ISR'),
('Italia','ITA'),
('Jamaica','JAM'),
('Japón','JPN'),
('Jersey','JEY'),
('Jordania','JOR'),
('Kazajistán','KAZ'),
('Kenia','KEN'),
('Kirguistán','KGZ'),
('Kiribati','KIR'),
('Kuwait','KWT'),
('Laos','LAO'),
('Lesoto','LSO'),
('Letonia','LVA'),
('Líbano','LBN'),
('Liberia','LBR'),
('Libia','LBY'),
('Liechtenstein','LIE'),
('Lituania','LTU'),
('Luxemburgo','LUX'),
('Macao','MAC'),
('Macedonia del Norte','MKD'),
('Madagascar','MDG'),
('Malasia','MYS'),
('Malaui','MWI'),
('Maldivas','MDV'),
('Malí','MLI'),
('Malta','MLT'),
('Marruecos','MAR'),
('Martinica','MTQ'),
('Mauricio','MUS'),
('Mauritania','MRT'),
('Mayotte','MYT'),
('México','MEX'),
('Micronesia','FSM'),
('Moldavia','MDA'),
('Mónaco','MCO'),
('Mongolia','MNG'),
('Montenegro','MNE'),
('Montserrat','MSR'),
('Mozambique','MOZ'),
('Birmania','MMR'),
('Namibia','NAM'),
('Nauru','NRU'),
('Nepal','NPL'),
('Nicaragua','NIC'),
('Níger','NER'),
('Nigeria','NGA'),
('Niue','NIU'),
('Isla Norfolk','NFK'),
('Noruega','NOR'),
('Nueva Caledonia','NCL'),
('Nueva Zelanda','NZL'),
('Omán','OMN'),
('Países Bajos','NLD'),
('Pakistán','PAK'),
('Palaos','PLW'),
('Palestina','PSE'),
('Panamá','PAN'),
('Papúa Nueva Guinea','PNG'),
('Paraguay','PRY'),
('Perú','PER'),
('Polinesia Francesa','PYF'),
('Polonia','POL'),
('Portugal','PRT'),
('Puerto Rico','PRI'),
('Reino Unido','GBR'),
('República Árabe Saharaui Democrática','ESH'),
('República Centroafricana','CAF'),
('República Checa','CZE'),
('República del Congo','COG'),
('República Democrática del Congo','COD'),
('República Dominicana','DOM'),
('Reunión','REU'),
('Ruanda','RWA'),
('Rumania','ROU'),
('Rusia','RUS'),
('Samoa','WSM'),
('Samoa Americana','ASM'),
('San Bartolomé','BLM'),
('San Cristóbal y Nieves','KNA'),
('San Marino','SMR'),
('San Martín','MAF'),
('San Pedro y Miquelón','SPM'),
('San Vicente y las Granadinas','VCT'),
('Santa Elena, Ascensión y Tristán de Acuña','SHN'),
('Santa Lucía','LCA'),
('Santo Tomé y Príncipe','STP'),
('Senegal','SEN'),
('Serbia','SRB'),
('Seychelles','SYC'),
('Sierra Leona','SLE'),
('Singapur','SGP'),
('San Martín','SXM'),
('Siria','SYR'),
('Somalia','SOM'),
('Sri Lanka','LKA'),
('Suazilandia','SWZ'),
('Sudáfrica','ZAF'),
('Sudán','SDN'),
('Sudán del Sur','SSD'),
('Suecia','SWE'),
('Suiza','CHE'),
('Surinam','SUR'),
('Svalbard y Jan Mayen','SJM'),
('Tailandia','THA'),
('Taiwán (República de China)','TWN'),
('Tanzania','TZA'),
('Tayikistán','TJK'),
('Territorio Británico del Océano Índico','IOT'),
('Tierras Australes y Antárticas Francesas','ATF'),
('Timor Oriental','TLS'),
('Togo','TGO'),
('Tokelau','TKL'),
('Tonga','TON'),
('Trinidad y Tobago','TTO'),
('Túnez','TUN'),
('Turkmenistán','TKM'),
('Turquía','TUR'),
('Tuvalu','TUV'),
('Ucrania','UKR'),
('Uganda','UGA'),
('Uruguay','URY'),
('Uzbekistán','UZB'),
('Vanuatu','VUT'),
('Ciudad del Vaticano','VAT'),
('Venezuela','VEN'),
('Vietnam','VNM'),
('Wallis y Futuna','WLF'),
('Yemen','YEM'),
('Yibuti','DJI'),
('Zambia','ZMB'),
('Zimbabue','ZWE');

call spu_nacionalidad_listar();

insert into roles(rol)
			values
            ('ADMIN'),
            ('INV');
insert into roles(rol)value("ASIST");

call spu_roles_listar();

call spu_usuarios_listar();

call spu_usuarios_registrar('','1',4,'Manuel Jesús','Cardenas Mateo','carma@gmail.com','123');
call spu_usuarios_eliminar('1');
call spu_usuarios_modificar(2,'','1',4,'Lucas Alfredo','Atuncar Valerio','lucasatuncar1@gmail.com','922634773');
select * from usuarios;

update usuarios set email= 'carma@gmail.com' where idusuario = '3';

create table roles;
alter table roles auto_increment = 1;

call spu_galeria_listar();

select * from productos;
update productos set fotografia = '28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg' where idproducto = '1';

call spu_products_actualizar(2,3,'Laptop Lenovo i8',4500.00,'10 meses','');

-- clave 123
update usuarios set email ='lucas@gmail.com';
update usuarios set claveacceso = '$2y$10$e.utwy1/hS4KJdeF.F.VGuJ3/9CJCoqq5Ot.2f8gXYEp.9rjt0Ata';
select * from productos;
select * from usuarios;

select * from usuarios;
call spu_set_password(4,'987654');


update usuarios set email = 'lucasatuncar1@gmail.com' where idusuario = '2';
update roles set rol = 'ADMIN' where idrol = '1';
insert into roles(rol)value('ASIST');

call spu_products_categoria('0');

call spu_productos_listar();
call spu_productos_obtener('1');

select * from datasheet;
call spu_datasheet_registrar(3,'n','n1');
call spu_datasheet_listar('2');
call spu_datasheet_actualizar(1,1,'aa','a1');

select * from galeria;
call spu_galeria_registrar(5,'f24.jpg');
call spu_galeria_listar('2'); 
call spu_galeria_actualizar(6,1,'28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg');

select * from datasheet where idproducto = '1';
select * from galeria where idproducto = '1';


call spu_datasheet_listar2('2');
call spu_usuarios_login('lucasatuncar1@gmail.com');

call spu_codigos_registrar(2,'123455');
call spu_codigos_obtener('lucasatuncar1@gmail.com');
call spu_codigos_eliminar('1');
select * from usuarios;
update codigos set inactive_at = null;
