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



CALL spu_productos_listar();
CALL spu_productos_registrar(1,'Laptop Lenovo i9',4500,'12 meses', '');
call spu_products_eliminar();
CALL spu_productos_buscar(1);

CALL spu_categorias_registrar("Laptop");
CALL spu_categorias_listar();

