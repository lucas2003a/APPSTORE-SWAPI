USE appstore;


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
DELIMITER ; 

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
DELIMITER ;

drop procedure if exists spu_productos_registrar;
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
        
        select @@last_insert_id 'idproducto';
END $$
DELIMITER ;

drop procedure if exists spu_categorias_listar;
DELIMITER $$
CREATE PROCEDURE spu_categorias_listar()
BEGIN
	SELECT * FROM categorias
	WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_categorias_registrar(
	IN _categoria 	VARCHAR(30)
)
BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END $$
DELIMITER ;

drop procedure if exists spu_products_eliminar;
delimiter $$
create procedure spu_products_eliminar(in _idproducto int)
begin 
	update productos set
		inactive_at = now()
        where 
			idproducto = _idproducto;
end $$
delimiter ;