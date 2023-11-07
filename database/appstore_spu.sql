USE appstore;

drop view if exists vw_productos_lista;
create view vw_productos_lista 
as
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia,
    pro.create_at
	FROM productos pro
	INNER JOIN categorias cat ON cat.idcategoria = pro.idcategoria
	WHERE pro.inactive_at IS NULL;

drop procedure if exists spu_productos_listar;
DELIMITER $$
CREATE PROCEDURE spu_productos_listar()
BEGIN 
	SELECT * from vw_productos_lista; 
END $$
DELIMITER ; 

drop procedure if exists spu_productos_obtener;
DELIMITER $$
CREATE PROCEDURE spu_productos_obtener(in _idproducto int)
BEGIN 
	SELECT * from vw_productos_lista
    where
		idproducto = _idproducto; 
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

drop procedure if exists spu_products_actualizar;
delimiter $$
create procedure spu_products_actualizar
(
	IN _idproducto		INT,
	IN _idcategoria		INT,
	IN _descripcion 	VARCHAR(150),
	IN _precio			FLOAT(7,2),
	IN _garantia		VARCHAR(100),
	IN _fotografia		VARCHAR(100)
)
begin 
	update productos set
		idcategoria = _idcategoria,
		descripcion = _descripcion,
		precio 		= _precio,
		garantia	= _garantia,
		fotografia	= nullif(_fotografia,'')
    where
		idproducto = _idproducto;	
end $$
delimter ;

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
        usu.nombres,
        usu.telefono
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
        in _claveacceso		varchar(60),
        in _telefono 		char(9)
)
begin
	insert into usuarios
		(avatar,idrol,idnacionalidad,apellidos,nombres,email,claveacceso,telefono)
        values
        (nullif(_avatar,''),_idrol,_idnacionalidad,_apellidos,_nombres,_email,_claveacceso,_telefono);
        
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
    in _email			varchar(60),
    in _telefono		char(9)
    
)
begin
	update usuarios set		
		avatar 			= nullif(_avatar,''),			
		idrol			= _idrol,		
		idnacionalidad 	= _idnacionalidad,
		apellidos 		= _apellidos,
		nombres 		= _nombres,		
		email			= _email,			
		telefono		= _telefono
	where
		idusuario = _idusuario;
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

drop procedure if exists spu_set_password;
delimiter $$
create procedure spu_set_password
(
	in _idusuario	int,
    in _claveacceso varchar(60)
)
begin
	update usuarios set
		claveacceso = _claveacceso
	where
		idusuario = _idusuario;
end $$
delimiter ;

drop procedure if exists spu_products_categoria;
delimiter $$
create procedure spu_products_categoria(in _idcategoria int)
begin 
	if _idcategoria = '0'then
    select * from productos
    order by create_at desc
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

drop procedure if exists spu_datasheet_listar;
delimiter $$
create procedure spu_datasheet_listar(in _idproducto int)
begin
	select 
		dat.idespecificacion,
        pro.descripcion,
        dat.clave,
        dat.valor
    from datasheet as dat
    inner join productos as pro on pro.idproducto = dat.idproducto
    where
		dat.idproducto = _idproducto and
		dat.inactive_at is null;
end $$
delimiter ;


drop procedure if exists spu_datasheet_registrar;
delimiter $$
create procedure spu_datasheet_registrar
(
    in _idproducto			int,
    in _clave				varchar(50),
    in _valor				varchar(300)
)
begin 
	insert into datasheet
		(idproducto,clave,valor)
        values
        (_idproducto,_clave,_valor);
end $$
delimiter ;

drop procedure if exists spu_datasheet_actualizar;
delimiter $$
create procedure spu_datasheet_actualizar
(
	in _idespecificacion	int,
    in _idproducto			int,
    in _clave				varchar(50),
    in _valor				varchar(300)
)
begin
	update datasheet set
		idproducto = _idproducto,
		clave	   = _clave,
		valor 	   =_valor
	where
		idespecificacion = _idespecificacion;
end $$
delimiter ;


drop procedure if exists spu_galeria_listar;
delimiter $$
create procedure spu_galeria_listar(in _idproducto int) 
begin
	select
		gal.idgaleria,
        pro.descripcion,
        gal.rutafoto
    from galeria as gal
    inner join	productos as pro on pro.idproducto = gal.idproducto
    where
		gal.idproducto = _idproducto and
		gal.inactive_at is null;
end $$
delimiter ; 

drop procedure if exists spu_galeria_registrar;
delimiter $$
create procedure spu_galeria_registrar
(
	in _idproducto		int,
    in _rutafoto		varchar(250)
)
begin 
	declare count_foto int;
    
    select count(*) into count_foto
    from galeria
    where 
		idproducto = _idproducto;
	
    if count_foto <= 9 then
    
	insert into galeria
		(idproducto,rutafoto)
        values
        (_idproducto,_rutafoto);
        
	else
    
    signal 	sqlstate '45000'
    set message_text = 'solo se puede ingresar 2 fotos';
    
    end if;
end $$
delimiter ;

drop procedure if exists spu_galeria_actualizar;
delimiter $$
create procedure spu_galeria_actualizar
(
	in _idgaleria		int,
	in _idproducto		int,
    in _rutafoto		varchar(250)
)
begin 
	update galeria set
		idproducto = _idproducto,
		rutafoto   = _rutafoto
	where
		idgaleria  = _idgaleria;
end $$
delimiter ;

-- prueba de consulta 


drop procedure if exists spu_galeria_listar2;
delimiter $$
create procedure spu_galeria_listar2(in _idproducto int)
begin
	-- Crear una tabla temporal para almacenar los resultados
    create temporary table tmp_galeria_result (
        idgaleria int,
        idproducto int,
        descripcion varchar(255),
        rutafoto varchar(255)
    );
    
    -- Insertar los resultados en la tabla temporal
	insert into tmp_galeria_result
	select
		gal.idgaleria,
        gal.idproducto,
        pro.descripcion,
        gal.rutafoto
    from galeria as gal
    inner join productos as pro on pro.idproducto = gal.idproducto
    where
		pro.idproducto = _idproducto and
		gal.inactive_at is null;
end $$
delimiter ; 

call spu_galeria_listar2('3');

drop procedure if exists spu_datasheet_listar2;
delimiter $$
create procedure spu_datasheet_listar2(in _idproducto int)
begin
	select 
		dat.idespecificacion,
        dat.idproducto,
        pro.descripcion,
        dat.clave,
        dat.valor
    from datasheet as dat
    inner join productos as pro on pro.idproducto = dat.idproducto
    where
		dat.idproducto = _idproducto and
		dat.inactive_at is null;
        
    
	call spu_galeria_listar2(_idproducto);
    
    select *from tmp_galeria_result;
end $$
delimiter ;

drop procedure if exists spu_usuariosEmail_get;
delimiter $$
create procedure spu_usuariosEmail_get(in _email varchar(60))
begin
	select 
		idusuario,
		apellidos,
		nombres,
        email,
        telefono
    from usuarios 
    where 
		email =_campocriterio and 
        inactive_at is null;
        
end $$
delimiter ;

drop procedure if exists spu_codigos_registrar;
delimiter $$
create procedure spu_codigos_registrar
(
	in _idusuario	int,
    in _codigo		char(6)
)
begin
	update usuarios set
		codigo = _codigo
    where 
		idusuario = _idusuario;
        
	select codigo from usuarios
    where idusuario = _idusuario;
end $$
delimiter ;

drop procedure if exists spu_codigos_eliminar;
delimiter $$
create procedure spu_codigos_eliminar(in _idusuario int)
begin
	update usuarios set 
		codigo = null
	where 
		idusuario = _idusuario;
end $$
delimiter ;

