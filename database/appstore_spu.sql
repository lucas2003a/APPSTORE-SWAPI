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

drop procedure if exists spu_roles_listar;
delimiter $$
create procedure spu_roles_listar()
begin
	select 
		idrol,
		rol
	from roles
	where
		inactive_at is null;
end $$
delimiter ;

drop procedure if exists spu_nacionalidad_listar;
delimiter $$
create procedure spu_nacionalidad_listar()
begin
	select 
		idnacionalidad,
        nombrepais,
        nombrecorto
        from nacionalidades
    where
		inactive_at is null;
end $$
delimiter ;

drop procedure if exists spu_usuarios_listar;
delimiter $$
create procedure spu_usuarios_listar()
begin
	select
		usu.idusuario,
        usu.avatar,
        rl.rol,
        nac.nombrepais,
        usu.apellidos,
        usu.nombres
	from usuarios as usu
    inner join roles as rl on rl.idrol = usu.idrol
    inner join nacionalidades as nac on nac.idnacionalidad = usu.idnacionalidad
    where
		usu.inactive_at is null;
end $$
delimiter ;

drop procedure if exists spu_usuarios_registrar;
delimiter $$
create procedure spu_usuarios_registrar
(
		in _avatar		varchar(100),
        in _idrol		int,
        in _idnacionalidad	int,
        in _apellidos		varchar(40),
        in _nombres			varchar(40),
        in _email			varchar(60),
        in _claveacceso		varchar(60)
)
begin
	insert into usuarios
		(avatar,idrol,idnacionalidad,apellidos,nombres,email,claveacceso)
        values
        (nullif(_avatar,''),_idrol,_idnacionalidad,_apellidos,_nombres,_email,_claveacceso);
        
        select @@last_insert_id 'idusuario';
end $$
delimiter ;

drop procedure if exists spu_usuarios_modificar;
delimiter $$
create procedure spu_usuarios_modificar
(
	in _idusuario 		int,
    in _avatar			varchar(100),
    in _idrol			int,
    in _idnacionalidad	int,
    in _apellidos		varchar(40),
    in _nombres			varchar(40),
    in _email			varchar(60)
    
)
begin
end $$
delimiter ;

drop procedure if exists spu_usuarios_eliminar;
delimiter $$
create procedure spu_usuarios_eliminar(in _idusuario int)
begin
	update usuarios set
		inactive_at = now()
	where
		idusuario = _idusuario;
end $$
delimiter ;

drop procedure if exists spu_usuarios_login;
delimiter $$
create procedure spu_usuarios_login(in _email varchar(60))
begin
	select
		usu.idusuario,
        usu.avatar,
        rl.rol,
        nac.nombrepais,
        usu.apellidos,
        usu.nombres,
        usu.email,
        usu.claveacceso
	from usuarios as usu
    inner join roles as rl on rl.idrol = usu.idrol
    inner join nacionalidades as nac on nac.idnacionalidad= usu.idnacionalidad
    where	
		usu.email = _email and
        usu.inactive_at is null;
end $$
delimiter ;



drop procedure if exists spu_products_categoria;
delimiter $$
create procedure spu_products_categoria(in _idcategoria int)
begin 
	if _idcategoria = '0'then
    select * from productos
    limit 12;
    else
    	select * from productos
		where
		inactive_at is null
        and idcategoria = _idcategoria
		order by create_at desc
		limit 12;
	end if;
end $$
delimiter ;

select * from productos;
call spu_products_oferta();
call spu_products_categoria('1');

-- clave 123
update usuarios set email ='lucas@gmail.com';
update usuarios set claveacceso = '$2y$10$e.utwy1/hS4KJdeF.F.VGuJ3/9CJCoqq5Ot.2f8gXYEp.9rjt0Ata';
select * from productos;
select * from roles;
update roles set rol = 'ADMIN' where idrol = '1';
insert into roles(rol)value('ASIST');


call spu_usuarios_login('lucasatuncar1@gmail.com');
