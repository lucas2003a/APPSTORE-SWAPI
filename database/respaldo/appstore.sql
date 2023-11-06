-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2023 a las 17:25:07
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appstore`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_categorias_listar` ()   BEGIN
	SELECT * FROM categorias
	WHERE inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_categorias_registrar` (IN `_categoria` VARCHAR(30))   BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_codigos_eliminar` (IN `_idusuario` INT)   begin
	update usuarios set 
		codigo = null
	where 
		idusuario = _idusuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_codigos_obtener` (IN `_campocriterio` VARCHAR(60))   begin
	select 
		idusuario,
		apellidos,
		nombres,
        email,
        telefono
    from usuarios 
    where 
		email =_campocriterio or telefono = _campocriterio and 
        inactive_at is null;
        
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_codigos_registrar` (IN `_idusuario` INT, IN `_codigo` CHAR(6))   begin
	update usuarios set
		codigo = _codigo
    where 
		idusuario = _idusuario;
        
	select codigo from usuarios
    where idusuario = _idusuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_actualizar` (IN `_idespecificacion` INT, IN `_idproducto` INT, IN `_clave` VARCHAR(50), IN `_valor` VARCHAR(300))   begin
	update datasheet set
		idproducto = _idproducto,
		clave	   = _clave,
		valor 	   =_valor
	where
		idespecificacion = _idespecificacion;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_listar` (IN `_idproducto` INT)   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_listar2` (IN `_idproducto` INT)   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_registrar` (IN `_idproducto` INT, IN `_clave` VARCHAR(50), IN `_valor` VARCHAR(300))   begin 
	insert into datasheet
		(idproducto,clave,valor)
        values
        (_idproducto,_clave,_valor);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_galeria_actualizar` (IN `_idgaleria` INT, IN `_idproducto` INT, IN `_rutafoto` VARCHAR(250))   begin 
	update galeria set
		idproducto = _idproducto,
		rutafoto   = _rutafoto
	where
		idgaleria  = _idgaleria;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_galeria_listar` (IN `_idproducto` INT)   begin
	select
		gal.idgaleria,
        pro.descripcion,
        gal.rutafoto
    from galeria as gal
    inner join	productos as pro on pro.idproducto = gal.idproducto
    where
		gal.idproducto = _idproducto and
		gal.inactive_at is null;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_galeria_listar2` (IN `_idproducto` INT)   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_galeria_registrar` (IN `_idproducto` INT, IN `_rutafoto` VARCHAR(250))   begin 
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_nacionalidad_listar` ()   begin
	select 
		idnacionalidad,
        nombrepais,
        nombrecorto
        from nacionalidades
    where
		inactive_at is null;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_buscar` (IN `idproducto` INT)   BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON pro.idcategoria = cat.idcategoria
	WHERE pro.idproducto = idproducto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_listar` ()   BEGIN 
	SELECT * from vw_productos_lista; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_obtener` (IN `_idproducto` INT)   BEGIN 
	SELECT * from vw_productos_lista
    where
		idproducto = _idproducto; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_productos_registrar` (IN `_idcategoria` INT, IN `_descripcion` VARCHAR(150), IN `_precio` FLOAT(7,2), IN `_garantia` VARCHAR(100), IN `_fotografia` VARCHAR(100))   BEGIN
	INSERT INTO productos
		(idcategoria, descripcion, precio, garantia, fotografia)
		VALUES
		(_idcategoria, _descripcion, _precio, _garantia, NULLIF(_fotografia, ''));
        
        select @@last_insert_id 'idproducto';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_products_actualizar` (IN `_idproducto` INT, IN `_idcategoria` INT, IN `_descripcion` VARCHAR(150), IN `_precio` FLOAT(7,2), IN `_garantia` VARCHAR(100), IN `_fotografia` VARCHAR(100))   begin 
	update productos set
		idcategoria = _idcategoria,
		descripcion = _descripcion,
		precio 		= _precio,
		garantia	= _garantia,
		fotografia	= nullif(_fotografia,'')
    where
		idproducto = _idproducto;	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_products_categoria` (IN `_idcategoria` INT)   begin 
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_products_eliminar` (IN `_idproducto` INT)   begin 
	update productos set
		inactive_at = now()
        where 
			idproducto = _idproducto;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_roles_listar` ()   begin
	select 
		idrol,
		rol
	from roles
	where
		inactive_at is null;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_eliminar` (IN `_idusuario` INT)   begin
	update usuarios set
		inactive_at = now()
	where
		idusuario = _idusuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_listar` ()   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_login` (IN `_email` VARCHAR(60))   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_modificar` (IN `_idusuario` INT, IN `_avatar` VARCHAR(100), IN `_idrol` INT, IN `_idnacionalidad` INT, IN `_apellidos` VARCHAR(40), IN `_nombres` VARCHAR(40), IN `_email` VARCHAR(60), IN `_telefono` CHAR(9))   begin
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
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_registrar` (IN `_avatar` VARCHAR(100), IN `_idrol` INT, IN `_idnacionalidad` INT, IN `_apellidos` VARCHAR(40), IN `_nombres` VARCHAR(40), IN `_email` VARCHAR(60), IN `_claveacceso` VARCHAR(60))   begin
	insert into usuarios
		(avatar,idrol,idnacionalidad,apellidos,nombres,email,claveacceso)
        values
        (nullif(_avatar,''),_idrol,_idnacionalidad,_apellidos,_nombres,_email,_claveacceso);
        
        select @@last_insert_id 'idusuario';
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `inactive_at` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `categoria`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'Computadoras', '2023-10-27 20:13:36', NULL, NULL),
(2, 'Telefonos Moviles', '2023-10-27 20:13:36', NULL, NULL),
(3, 'Monitores', '2023-10-27 20:13:36', NULL, NULL),
(4, 'Accesorios', '2023-10-27 20:13:36', NULL, NULL),
(5, 'Perifericos', '2023-10-27 20:13:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datasheet`
--

CREATE TABLE `datasheet` (
  `idespecificacion` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `valor` varchar(300) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datasheet`
--

INSERT INTO `datasheet` (`idespecificacion`, `idproducto`, `clave`, `valor`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 1, 'aa', 'a1', '2023-10-27', NULL, NULL),
(2, 1, 'b', 'b1', '2023-10-27', NULL, NULL),
(3, 1, 'c', 'c1', '2023-10-27', NULL, NULL),
(4, 1, 'd', 'd1', '2023-10-27', NULL, NULL),
(5, 1, 'e', 'e1', '2023-10-27', NULL, NULL),
(6, 1, 'f', 'f1', '2023-10-27', NULL, NULL),
(8, 2, 'g', 'g1', '2023-10-27', NULL, NULL),
(10, 2, 'h', 'h1', '2023-10-27', NULL, NULL),
(11, 2, 'i', 'i1', '2023-10-27', NULL, NULL),
(12, 2, 'j', 'j1', '2023-10-27', NULL, NULL),
(13, 3, 'k', 'k1', '2023-10-27', NULL, NULL),
(15, 3, 'l', 'l1', '2023-10-27', NULL, NULL),
(16, 3, 'm', 'm1', '2023-10-27', NULL, NULL),
(17, 3, 'n', 'n1', '2023-10-27', NULL, NULL),
(18, 1, 'nuevaclave', 'nuevo valor', '2023-11-01', NULL, NULL),
(20, 1, 'nueva', 'nuevo valor', '2023-11-01', NULL, NULL),
(21, 1, 'clave de web', 'valor de web', '2023-11-01', NULL, NULL),
(22, 2, 'clave de web3', 'valor de web3', '2023-11-01', NULL, NULL),
(24, 4, 'clave de web4', 'valor 34', '2023-11-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `idgaleria` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `rutafoto` varchar(250) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`idgaleria`, `idproducto`, `rutafoto`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 1, '496b47e0f026694559525f86ce0f15c5ab71d6ea.jpg', '2023-10-27', NULL, NULL),
(2, 1, '496b47e0f026694559525f86ce0f15c5ab71d6ea.jpg', '2023-10-27', NULL, NULL),
(3, 1, '28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg', '2023-10-27', NULL, NULL),
(4, 1, '45db674a859d78f5945b88747ade303e692ab10f.jpg', '2023-10-27', NULL, NULL),
(5, 1, '1927d9d3ab83f62ec8d0aa8944805dbd0c99c7f1.jpg', '2023-10-27', NULL, NULL),
(6, 1, '28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg', '2023-10-27', NULL, NULL),
(7, 2, 'f67.jpg', '2023-10-27', NULL, NULL),
(8, 2, 'f8.jpg', '2023-10-27', NULL, NULL),
(9, 2, 'f.jpg', '2023-10-27', NULL, NULL),
(10, 2, 'f9.jpg', '2023-10-27', NULL, NULL),
(11, 2, 'f10.jpg', '2023-10-27', NULL, NULL),
(12, 2, 'f11.jpg', '2023-10-27', NULL, NULL),
(13, 2, 'f12.jpg', '2023-10-27', NULL, NULL),
(14, 3, 'f13.jpg', '2023-10-27', NULL, NULL),
(15, 3, 'f14.jpg', '2023-10-27', NULL, NULL),
(16, 3, 'f15.jpg', '2023-10-27', NULL, NULL),
(17, 3, 'f16.jpg', '2023-10-27', NULL, NULL),
(18, 3, 'f17.jpg', '2023-10-27', NULL, NULL),
(19, 3, 'f18.jpg', '2023-10-27', NULL, NULL),
(20, 4, 'f19.jpg', '2023-10-28', NULL, NULL),
(21, 4, 'f20.jpg', '2023-10-28', NULL, NULL),
(22, 4, 'f21.jpg', '2023-10-28', NULL, NULL),
(23, 5, 'f22.jpg', '2023-10-28', NULL, NULL),
(24, 5, 'f23.jpg', '2023-10-28', NULL, NULL),
(25, 4, '57a56315082c73a8decd1844f689dc18dfaead4f.jpg', '2023-11-02', NULL, NULL),
(26, 4, 'd46e2de8a21bbc1b45461cd6d7dc9e9d88aeb3e7.jpg', '2023-11-02', NULL, NULL),
(27, 4, 'f912ce6148878140b55146a5f9b7c0b10a083831.jpg', '2023-11-02', NULL, NULL),
(28, 4, '12d042c2daeb43ba50e51664c20b6387303d4a5b.jpg', '2023-11-02', NULL, NULL),
(29, 4, '4a134e73a585bee53f1c48f9acf7a788227aa03d.jpg', '2023-11-02', NULL, NULL),
(30, 4, 'ae1b86a51717e52377bb4a87882ac0f812e6fe83.jpg', '2023-11-02', NULL, NULL),
(31, 4, 'Array', '2023-11-02', NULL, NULL),
(32, 3, '5a86e3803282b6c0720853eb11c67b8b241178be.jpg', '2023-11-02', NULL, NULL),
(33, 3, 'e8ac77adc6487b0deace6d717430f463cb4db676.jpg', '2023-11-02', NULL, NULL),
(34, 3, '874de01ddef1af4d809c2a66c95aee78e2cb6169.jpg', '2023-11-02', NULL, NULL),
(35, 5, 'Array', '2023-11-02', NULL, NULL),
(36, 5, 'Array', '2023-11-02', NULL, NULL),
(37, 5, '8870e3fd9d515654d21e9fa12aaf63d2a06ae79c.jpg', '2023-11-02', NULL, NULL),
(38, 5, '7be713674cc8d81ed61b17226e5c615c2ef18984.jpg', '2023-11-02', NULL, NULL),
(39, 5, 'c96359fc94c00b860796c971c3ee5be73ebc8f58.jpg', '2023-11-02', NULL, NULL),
(40, 5, '002e24fc6c6d4f14e22eefd67be7bd5182637b26.jpg', '2023-11-02', NULL, NULL),
(41, 5, '8100b04f612d3a8afd822b1e063d94b513c3ee70.jpg', '2023-11-02', NULL, NULL),
(42, 5, 'fc688f0b318bc5bafb6165fd8317a3570f624549.jpg', '2023-11-02', NULL, NULL),
(43, 2, 'e2c6ee99883cd8cfb9d734586a417e46f0bb131a.jpg', '2023-11-02', NULL, NULL),
(44, 2, 'c09c5f044382d8084158ab77589540aca8c3b24f.jpg', '2023-11-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidades`
--

CREATE TABLE `nacionalidades` (
  `idnacionalidad` int(11) NOT NULL,
  `nombrepais` varchar(60) NOT NULL,
  `nombrecorto` char(3) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nacionalidades`
--

INSERT INTO `nacionalidades` (`idnacionalidad`, `nombrepais`, `nombrecorto`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'Afganistán', 'AFG', '2023-10-27', NULL, NULL),
(2, 'Åland', 'ALA', '2023-10-27', NULL, NULL),
(3, 'Albania', 'ALB', '2023-10-27', NULL, NULL),
(4, 'Alemania', 'DEU', '2023-10-27', NULL, NULL),
(5, 'Andorra', 'AND', '2023-10-27', NULL, NULL),
(6, 'Angola', 'AGO', '2023-10-27', NULL, NULL),
(7, 'Anguila', 'AIA', '2023-10-27', NULL, NULL),
(8, 'Antártida', 'ATA', '2023-10-27', NULL, NULL),
(9, 'Antigua y Barbuda', 'ATG', '2023-10-27', NULL, NULL),
(10, 'Arabia Saudita', 'SAU', '2023-10-27', NULL, NULL),
(11, 'Argelia', 'DZA', '2023-10-27', NULL, NULL),
(12, 'Argentina', 'ARG', '2023-10-27', NULL, NULL),
(13, 'Armenia', 'ARM', '2023-10-27', NULL, NULL),
(14, 'Aruba', 'ABW', '2023-10-27', NULL, NULL),
(15, 'Australia', 'AUS', '2023-10-27', NULL, NULL),
(16, 'Austria', 'AUT', '2023-10-27', NULL, NULL),
(17, 'Azerbaiyán', 'AZE', '2023-10-27', NULL, NULL),
(18, 'Bahamas', 'BHS', '2023-10-27', NULL, NULL),
(19, 'Bangladés', 'BGD', '2023-10-27', NULL, NULL),
(20, 'Barbados', 'BRB', '2023-10-27', NULL, NULL),
(21, 'Baréin', 'BHR', '2023-10-27', NULL, NULL),
(22, 'Bélgica', 'BEL', '2023-10-27', NULL, NULL),
(23, 'Belice', 'BLZ', '2023-10-27', NULL, NULL),
(24, 'Benín', 'BEN', '2023-10-27', NULL, NULL),
(25, 'Bermudas', 'BMU', '2023-10-27', NULL, NULL),
(26, 'Bielorrusia', 'BLR', '2023-10-27', NULL, NULL),
(27, 'Bolivia', 'BOL', '2023-10-27', NULL, NULL),
(28, 'Bonaire, San Eustaquio y Saba', 'BES', '2023-10-27', NULL, NULL),
(29, 'Bosnia y Herzegovina', 'BIH', '2023-10-27', NULL, NULL),
(30, 'Botsuana', 'BWA', '2023-10-27', NULL, NULL),
(31, 'Brasil', 'BRA', '2023-10-27', NULL, NULL),
(32, 'Brunéi', 'BRN', '2023-10-27', NULL, NULL),
(33, 'Bulgaria', 'BGR', '2023-10-27', NULL, NULL),
(34, 'Burkina Faso', 'BFA', '2023-10-27', NULL, NULL),
(35, 'Burundi', 'BDI', '2023-10-27', NULL, NULL),
(36, 'Bután', 'BTN', '2023-10-27', NULL, NULL),
(37, 'Cabo Verde', 'CPV', '2023-10-27', NULL, NULL),
(38, 'Camboya', 'KHM', '2023-10-27', NULL, NULL),
(39, 'Camerún', 'CMR', '2023-10-27', NULL, NULL),
(40, 'Canadá', 'CAN', '2023-10-27', NULL, NULL),
(41, 'Catar', 'QAT', '2023-10-27', NULL, NULL),
(42, 'Chad', 'TCD', '2023-10-27', NULL, NULL),
(43, 'Chile', 'CHL', '2023-10-27', NULL, NULL),
(44, 'China', 'CHN', '2023-10-27', NULL, NULL),
(45, 'Chipre', 'CYP', '2023-10-27', NULL, NULL),
(46, 'Colombia', 'COL', '2023-10-27', NULL, NULL),
(47, 'Comoras', 'COM', '2023-10-27', NULL, NULL),
(48, 'Corea del Norte', 'PRK', '2023-10-27', NULL, NULL),
(49, 'Corea del Sur', 'KOR', '2023-10-27', NULL, NULL),
(50, 'Costa de Marfil', 'CIV', '2023-10-27', NULL, NULL),
(51, 'Costa Rica', 'CRI', '2023-10-27', NULL, NULL),
(52, 'Croacia', 'HRV', '2023-10-27', NULL, NULL),
(53, 'Cuba', 'CUB', '2023-10-27', NULL, NULL),
(54, 'Curazao', 'CUW', '2023-10-27', NULL, NULL),
(55, 'Dinamarca', 'DNK', '2023-10-27', NULL, NULL),
(56, 'Dominica', 'DMA', '2023-10-27', NULL, NULL),
(57, 'Ecuador', 'ECU', '2023-10-27', NULL, NULL),
(58, 'Egipto', 'EGY', '2023-10-27', NULL, NULL),
(59, 'El Salvador', 'SLV', '2023-10-27', NULL, NULL),
(60, 'Emiratos Árabes Unidos', 'ARE', '2023-10-27', NULL, NULL),
(61, 'Eritrea', 'ERI', '2023-10-27', NULL, NULL),
(62, 'Eslovaquia', 'SVK', '2023-10-27', NULL, NULL),
(63, 'Eslovenia', 'SVN', '2023-10-27', NULL, NULL),
(64, 'España', 'ESP', '2023-10-27', NULL, NULL),
(65, 'Estados Unidos', 'USA', '2023-10-27', NULL, NULL),
(66, 'Estonia', 'EST', '2023-10-27', NULL, NULL),
(67, 'Etiopía', 'ETH', '2023-10-27', NULL, NULL),
(68, 'Filipinas', 'PHL', '2023-10-27', NULL, NULL),
(69, 'Finlandia', 'FIN', '2023-10-27', NULL, NULL),
(70, 'Fiyi', 'FJI', '2023-10-27', NULL, NULL),
(71, 'Francia', 'FRA', '2023-10-27', NULL, NULL),
(72, 'Gabón', 'GAB', '2023-10-27', NULL, NULL),
(73, 'Gambia', 'GMB', '2023-10-27', NULL, NULL),
(74, 'Georgia', 'GEO', '2023-10-27', NULL, NULL),
(75, 'Ghana', 'GHA', '2023-10-27', NULL, NULL),
(76, 'Gibraltar', 'GIB', '2023-10-27', NULL, NULL),
(77, 'Granada', 'GRD', '2023-10-27', NULL, NULL),
(78, 'Grecia', 'GRC', '2023-10-27', NULL, NULL),
(79, 'Groenlandia', 'GRL', '2023-10-27', NULL, NULL),
(80, 'Guadalupe', 'GLP', '2023-10-27', NULL, NULL),
(81, 'Guam', 'GUM', '2023-10-27', NULL, NULL),
(82, 'Guatemala', 'GTM', '2023-10-27', NULL, NULL),
(83, 'Guayana Francesa', 'GUF', '2023-10-27', NULL, NULL),
(84, 'Guernsey', 'GGY', '2023-10-27', NULL, NULL),
(85, 'Guinea', 'GIN', '2023-10-27', NULL, NULL),
(86, 'Guinea-Bisáu', 'GNB', '2023-10-27', NULL, NULL),
(87, 'Guinea Ecuatorial', 'GNQ', '2023-10-27', NULL, NULL),
(88, 'Guyana', 'GUY', '2023-10-27', NULL, NULL),
(89, 'Haití', 'HTI', '2023-10-27', NULL, NULL),
(90, 'Honduras', 'HND', '2023-10-27', NULL, NULL),
(91, 'Hong Kong', 'HKG', '2023-10-27', NULL, NULL),
(92, 'Hungría', 'HUN', '2023-10-27', NULL, NULL),
(93, 'India', 'IND', '2023-10-27', NULL, NULL),
(94, 'Indonesia', 'IDN', '2023-10-27', NULL, NULL),
(95, 'Irak', 'IRQ', '2023-10-27', NULL, NULL),
(96, 'Irán', 'IRN', '2023-10-27', NULL, NULL),
(97, 'Irlanda', 'IRL', '2023-10-27', NULL, NULL),
(98, 'Isla Bouvet', 'BVT', '2023-10-27', NULL, NULL),
(99, 'Isla de Man', 'IMN', '2023-10-27', NULL, NULL),
(100, 'Isla de Navidad', 'CXR', '2023-10-27', NULL, NULL),
(101, 'Islandia', 'ISL', '2023-10-27', NULL, NULL),
(102, 'Islas Caimán', 'CYM', '2023-10-27', NULL, NULL),
(103, 'Islas Cocos', 'CCK', '2023-10-27', NULL, NULL),
(104, 'Islas Cook', 'COK', '2023-10-27', NULL, NULL),
(105, 'Islas Feroe', 'FRO', '2023-10-27', NULL, NULL),
(106, 'Islas Georgias del Sur y Sandwich del Sur', 'SGS', '2023-10-27', NULL, NULL),
(107, 'Islas Heard y McDonald', 'HMD', '2023-10-27', NULL, NULL),
(108, 'Islas Malvinas', 'FLK', '2023-10-27', NULL, NULL),
(109, 'Islas Marianas del Norte', 'MNP', '2023-10-27', NULL, NULL),
(110, 'Islas Marshall', 'MHL', '2023-10-27', NULL, NULL),
(111, 'Islas Pitcairn', 'PCN', '2023-10-27', NULL, NULL),
(112, 'Islas Salomón', 'SLB', '2023-10-27', NULL, NULL),
(113, 'Islas Turcas y Caicos', 'TCA', '2023-10-27', NULL, NULL),
(114, 'Islas Ultramarinas Menores de los Estados Unidos', 'UMI', '2023-10-27', NULL, NULL),
(115, 'Islas Vírgenes Británicas', 'VGB', '2023-10-27', NULL, NULL),
(116, 'Islas Vírgenes de los Estados Unidos', 'VIR', '2023-10-27', NULL, NULL),
(117, 'Israel', 'ISR', '2023-10-27', NULL, NULL),
(118, 'Italia', 'ITA', '2023-10-27', NULL, NULL),
(119, 'Jamaica', 'JAM', '2023-10-27', NULL, NULL),
(120, 'Japón', 'JPN', '2023-10-27', NULL, NULL),
(121, 'Jersey', 'JEY', '2023-10-27', NULL, NULL),
(122, 'Jordania', 'JOR', '2023-10-27', NULL, NULL),
(123, 'Kazajistán', 'KAZ', '2023-10-27', NULL, NULL),
(124, 'Kenia', 'KEN', '2023-10-27', NULL, NULL),
(125, 'Kirguistán', 'KGZ', '2023-10-27', NULL, NULL),
(126, 'Kiribati', 'KIR', '2023-10-27', NULL, NULL),
(127, 'Kuwait', 'KWT', '2023-10-27', NULL, NULL),
(128, 'Laos', 'LAO', '2023-10-27', NULL, NULL),
(129, 'Lesoto', 'LSO', '2023-10-27', NULL, NULL),
(130, 'Letonia', 'LVA', '2023-10-27', NULL, NULL),
(131, 'Líbano', 'LBN', '2023-10-27', NULL, NULL),
(132, 'Liberia', 'LBR', '2023-10-27', NULL, NULL),
(133, 'Libia', 'LBY', '2023-10-27', NULL, NULL),
(134, 'Liechtenstein', 'LIE', '2023-10-27', NULL, NULL),
(135, 'Lituania', 'LTU', '2023-10-27', NULL, NULL),
(136, 'Luxemburgo', 'LUX', '2023-10-27', NULL, NULL),
(137, 'Macao', 'MAC', '2023-10-27', NULL, NULL),
(138, 'Macedonia del Norte', 'MKD', '2023-10-27', NULL, NULL),
(139, 'Madagascar', 'MDG', '2023-10-27', NULL, NULL),
(140, 'Malasia', 'MYS', '2023-10-27', NULL, NULL),
(141, 'Malaui', 'MWI', '2023-10-27', NULL, NULL),
(142, 'Maldivas', 'MDV', '2023-10-27', NULL, NULL),
(143, 'Malí', 'MLI', '2023-10-27', NULL, NULL),
(144, 'Malta', 'MLT', '2023-10-27', NULL, NULL),
(145, 'Marruecos', 'MAR', '2023-10-27', NULL, NULL),
(146, 'Martinica', 'MTQ', '2023-10-27', NULL, NULL),
(147, 'Mauricio', 'MUS', '2023-10-27', NULL, NULL),
(148, 'Mauritania', 'MRT', '2023-10-27', NULL, NULL),
(149, 'Mayotte', 'MYT', '2023-10-27', NULL, NULL),
(150, 'México', 'MEX', '2023-10-27', NULL, NULL),
(151, 'Micronesia', 'FSM', '2023-10-27', NULL, NULL),
(152, 'Moldavia', 'MDA', '2023-10-27', NULL, NULL),
(153, 'Mónaco', 'MCO', '2023-10-27', NULL, NULL),
(154, 'Mongolia', 'MNG', '2023-10-27', NULL, NULL),
(155, 'Montenegro', 'MNE', '2023-10-27', NULL, NULL),
(156, 'Montserrat', 'MSR', '2023-10-27', NULL, NULL),
(157, 'Mozambique', 'MOZ', '2023-10-27', NULL, NULL),
(158, 'Birmania', 'MMR', '2023-10-27', NULL, NULL),
(159, 'Namibia', 'NAM', '2023-10-27', NULL, NULL),
(160, 'Nauru', 'NRU', '2023-10-27', NULL, NULL),
(161, 'Nepal', 'NPL', '2023-10-27', NULL, NULL),
(162, 'Nicaragua', 'NIC', '2023-10-27', NULL, NULL),
(163, 'Níger', 'NER', '2023-10-27', NULL, NULL),
(164, 'Nigeria', 'NGA', '2023-10-27', NULL, NULL),
(165, 'Niue', 'NIU', '2023-10-27', NULL, NULL),
(166, 'Isla Norfolk', 'NFK', '2023-10-27', NULL, NULL),
(167, 'Noruega', 'NOR', '2023-10-27', NULL, NULL),
(168, 'Nueva Caledonia', 'NCL', '2023-10-27', NULL, NULL),
(169, 'Nueva Zelanda', 'NZL', '2023-10-27', NULL, NULL),
(170, 'Omán', 'OMN', '2023-10-27', NULL, NULL),
(171, 'Países Bajos', 'NLD', '2023-10-27', NULL, NULL),
(172, 'Pakistán', 'PAK', '2023-10-27', NULL, NULL),
(173, 'Palaos', 'PLW', '2023-10-27', NULL, NULL),
(174, 'Palestina', 'PSE', '2023-10-27', NULL, NULL),
(175, 'Panamá', 'PAN', '2023-10-27', NULL, NULL),
(176, 'Papúa Nueva Guinea', 'PNG', '2023-10-27', NULL, NULL),
(177, 'Paraguay', 'PRY', '2023-10-27', NULL, NULL),
(178, 'Perú', 'PER', '2023-10-27', NULL, NULL),
(179, 'Polinesia Francesa', 'PYF', '2023-10-27', NULL, NULL),
(180, 'Polonia', 'POL', '2023-10-27', NULL, NULL),
(181, 'Portugal', 'PRT', '2023-10-27', NULL, NULL),
(182, 'Puerto Rico', 'PRI', '2023-10-27', NULL, NULL),
(183, 'Reino Unido', 'GBR', '2023-10-27', NULL, NULL),
(184, 'República Árabe Saharaui Democrática', 'ESH', '2023-10-27', NULL, NULL),
(185, 'República Centroafricana', 'CAF', '2023-10-27', NULL, NULL),
(186, 'República Checa', 'CZE', '2023-10-27', NULL, NULL),
(187, 'República del Congo', 'COG', '2023-10-27', NULL, NULL),
(188, 'República Democrática del Congo', 'COD', '2023-10-27', NULL, NULL),
(189, 'República Dominicana', 'DOM', '2023-10-27', NULL, NULL),
(190, 'Reunión', 'REU', '2023-10-27', NULL, NULL),
(191, 'Ruanda', 'RWA', '2023-10-27', NULL, NULL),
(192, 'Rumania', 'ROU', '2023-10-27', NULL, NULL),
(193, 'Rusia', 'RUS', '2023-10-27', NULL, NULL),
(194, 'Samoa', 'WSM', '2023-10-27', NULL, NULL),
(195, 'Samoa Americana', 'ASM', '2023-10-27', NULL, NULL),
(196, 'San Bartolomé', 'BLM', '2023-10-27', NULL, NULL),
(197, 'San Cristóbal y Nieves', 'KNA', '2023-10-27', NULL, NULL),
(198, 'San Marino', 'SMR', '2023-10-27', NULL, NULL),
(199, 'San Martín', 'MAF', '2023-10-27', NULL, NULL),
(200, 'San Pedro y Miquelón', 'SPM', '2023-10-27', NULL, NULL),
(201, 'San Vicente y las Granadinas', 'VCT', '2023-10-27', NULL, NULL),
(202, 'Santa Elena, Ascensión y Tristán de Acuña', 'SHN', '2023-10-27', NULL, NULL),
(203, 'Santa Lucía', 'LCA', '2023-10-27', NULL, NULL),
(204, 'Santo Tomé y Príncipe', 'STP', '2023-10-27', NULL, NULL),
(205, 'Senegal', 'SEN', '2023-10-27', NULL, NULL),
(206, 'Serbia', 'SRB', '2023-10-27', NULL, NULL),
(207, 'Seychelles', 'SYC', '2023-10-27', NULL, NULL),
(208, 'Sierra Leona', 'SLE', '2023-10-27', NULL, NULL),
(209, 'Singapur', 'SGP', '2023-10-27', NULL, NULL),
(210, 'San Martín', 'SXM', '2023-10-27', NULL, NULL),
(211, 'Siria', 'SYR', '2023-10-27', NULL, NULL),
(212, 'Somalia', 'SOM', '2023-10-27', NULL, NULL),
(213, 'Sri Lanka', 'LKA', '2023-10-27', NULL, NULL),
(214, 'Suazilandia', 'SWZ', '2023-10-27', NULL, NULL),
(215, 'Sudáfrica', 'ZAF', '2023-10-27', NULL, NULL),
(216, 'Sudán', 'SDN', '2023-10-27', NULL, NULL),
(217, 'Sudán del Sur', 'SSD', '2023-10-27', NULL, NULL),
(218, 'Suecia', 'SWE', '2023-10-27', NULL, NULL),
(219, 'Suiza', 'CHE', '2023-10-27', NULL, NULL),
(220, 'Surinam', 'SUR', '2023-10-27', NULL, NULL),
(221, 'Svalbard y Jan Mayen', 'SJM', '2023-10-27', NULL, NULL),
(222, 'Tailandia', 'THA', '2023-10-27', NULL, NULL),
(223, 'Taiwán (República de China)', 'TWN', '2023-10-27', NULL, NULL),
(224, 'Tanzania', 'TZA', '2023-10-27', NULL, NULL),
(225, 'Tayikistán', 'TJK', '2023-10-27', NULL, NULL),
(226, 'Territorio Británico del Océano Índico', 'IOT', '2023-10-27', NULL, NULL),
(227, 'Tierras Australes y Antárticas Francesas', 'ATF', '2023-10-27', NULL, NULL),
(228, 'Timor Oriental', 'TLS', '2023-10-27', NULL, NULL),
(229, 'Togo', 'TGO', '2023-10-27', NULL, NULL),
(230, 'Tokelau', 'TKL', '2023-10-27', NULL, NULL),
(231, 'Tonga', 'TON', '2023-10-27', NULL, NULL),
(232, 'Trinidad y Tobago', 'TTO', '2023-10-27', NULL, NULL),
(233, 'Túnez', 'TUN', '2023-10-27', NULL, NULL),
(234, 'Turkmenistán', 'TKM', '2023-10-27', NULL, NULL),
(235, 'Turquía', 'TUR', '2023-10-27', NULL, NULL),
(236, 'Tuvalu', 'TUV', '2023-10-27', NULL, NULL),
(237, 'Ucrania', 'UKR', '2023-10-27', NULL, NULL),
(238, 'Uganda', 'UGA', '2023-10-27', NULL, NULL),
(239, 'Uruguay', 'URY', '2023-10-27', NULL, NULL),
(240, 'Uzbekistán', 'UZB', '2023-10-27', NULL, NULL),
(241, 'Vanuatu', 'VUT', '2023-10-27', NULL, NULL),
(242, 'Ciudad del Vaticano', 'VAT', '2023-10-27', NULL, NULL),
(243, 'Venezuela', 'VEN', '2023-10-27', NULL, NULL),
(244, 'Vietnam', 'VNM', '2023-10-27', NULL, NULL),
(245, 'Wallis y Futuna', 'WLF', '2023-10-27', NULL, NULL),
(246, 'Yemen', 'YEM', '2023-10-27', NULL, NULL),
(247, 'Yibuti', 'DJI', '2023-10-27', NULL, NULL),
(248, 'Zambia', 'ZMB', '2023-10-27', NULL, NULL),
(249, 'Zimbabue', 'ZWE', '2023-10-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` float(7,2) NOT NULL,
  `garantia` varchar(100) NOT NULL,
  `fotografia` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `inactive_at` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `idcategoria`, `descripcion`, `precio`, `garantia`, `fotografia`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 3, 'Laptop Lenovo i9', 4500.00, '12 meses', '28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg', '2023-10-27 20:13:37', NULL, NULL),
(2, 3, 'Laptop Lenovo i8', 4500.00, '10 meses', NULL, '2023-10-27 22:44:17', NULL, NULL),
(3, 3, 'Laptop Lenovo i97', 4500.00, '11 meses', NULL, '2023-10-27 22:44:25', NULL, NULL),
(4, 3, 'Laptop Lenovo i6', 4500.00, '04 meses', NULL, '2023-10-27 22:44:34', NULL, NULL),
(5, 3, 'Monitor Gamer OLED UltraGear™ WQHD 0.03 ms (GtG), 240Hz de 44.5\'\'', 500.00, '10', '496b47e0f026694559525f86ce0f15c5ab71d6ea.jpg', '2023-10-28 01:24:46', NULL, NULL),
(6, 3, 'MONITOR LED 27\" LG 27MP60G-B 1920x1080 HDMI DP VGA 1MS/75HZ/FREESYNC', 450.00, '11', 'a757c298739872a24e5b08cd5454fc5b18cd3b6d.jpg', '2023-10-28 01:28:51', NULL, NULL),
(7, 1, 'Computadora Intel 3.50Ghz, 8GB RAM DDR4, Disco 250GB SSD, Monitor HD 18.5”, Teclado y mouse', 300.00, '08', '374fd4a5fd3ef6d01cfd1ba194acb0d553afa9d1.jpg', '2023-10-28 01:29:48', NULL, NULL),
(8, 1, 'Computadora Intel 3.50Ghz, 8GB RAM DDR4, Disco 250GB SSD, Monitor HD 18.5”, Teclado y mouse', 459.00, '07', '45db674a859d78f5945b88747ade303e692ab10f.jpg', '2023-10-28 01:31:05', NULL, NULL),
(9, 4, 'Mouse Logitech G203 RGB LIGHTSYNC con 6 botones para juegos', 200.00, '05', '4b2b8277ed49a34372cdcf43f1c468c337524ec3.jpg', '2023-10-28 01:32:20', NULL, NULL),
(10, 4, 'Logitech M170/M171 Wireless Mouse - Comfort and Mobility', 250.00, '08', '28670d018c81c75aa22b3ed1699beee4b1c1f174.jpg', '2023-10-28 01:33:09', NULL, NULL),
(11, 5, 'Audífonos inalámbricos para mujer Play It Again | Cyzone - Cyzone Perú', 300.00, '06', '1927d9d3ab83f62ec8d0aa8944805dbd0c99c7f1.jpg', '2023-10-28 01:35:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `rol`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'ADMIN', '2023-10-27', NULL, NULL),
(2, 'INV', '2023-10-27', NULL, NULL),
(3, 'ASIST', '2023-10-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `idrol` int(11) NOT NULL,
  `idnacionalidad` int(11) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `claveacceso` varchar(60) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL,
  `telefono` char(9) DEFAULT NULL,
  `codigo` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `avatar`, `idrol`, `idnacionalidad`, `apellidos`, `nombres`, `email`, `claveacceso`, `create_at`, `update_at`, `inactive_at`, `telefono`, `codigo`) VALUES
(1, NULL, 3, 1, 'Pacheco Janampa', 'Joseph Tadeo', 'joshep@gmail.com', '$2y$10$e.utwy1/hS4KJdeF.F.VGuJ3/9CJCoqq5Ot.2f8gXYEp.9rjt0Ata', '2023-10-27', NULL, NULL, NULL, NULL),
(2, NULL, 1, 4, 'Lucas Alfredo', 'Atuncar Valerio', 'lucasatuncar1@gmail.com', '$2y$10$e.utwy1/hS4KJdeF.F.VGuJ3/9CJCoqq5Ot.2f8gXYEp.9rjt0Ata', '2023-10-27', NULL, NULL, '922634773', '598700'),
(3, NULL, 1, 4, 'Manuel Jesús', 'Cardenas Mateo', 'carma@gmail.com', '$2y$10$e.utwy1/hS4KJdeF.F.VGuJ3/9CJCoqq5Ot.2f8gXYEp.9rjt0Ata', '2023-11-01', NULL, NULL, NULL, NULL),
(4, NULL, 1, 4, 'Manuel Jesús', 'Cardenas Mateo', 'carma@gmail.com', '123', '2023-11-05', NULL, NULL, NULL, NULL),
(5, NULL, 1, 4, 'Manuel Jesús', 'Cardenas Mateo', 'carma@gmail.com', '123', '2023-11-05', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_productos_lista`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_productos_lista` (
`idproducto` int(11)
,`categoria` varchar(30)
,`descripcion` varchar(150)
,`precio` float(7,2)
,`garantia` varchar(100)
,`fotografia` varchar(100)
,`create_at` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_productos_lista`
--
DROP TABLE IF EXISTS `vw_productos_lista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_productos_lista`  AS SELECT `pro`.`idproducto` AS `idproducto`, `cat`.`categoria` AS `categoria`, `pro`.`descripcion` AS `descripcion`, `pro`.`precio` AS `precio`, `pro`.`garantia` AS `garantia`, `pro`.`fotografia` AS `fotografia`, `pro`.`create_at` AS `create_at` FROM (`productos` `pro` join `categorias` `cat` on(`cat`.`idcategoria` = `pro`.`idcategoria`)) WHERE `pro`.`inactive_at` is null ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  ADD PRIMARY KEY (`idespecificacion`),
  ADD UNIQUE KEY `uk_valor_data` (`clave`),
  ADD KEY `fk_idproducto_data` (`idproducto`);

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`idgaleria`),
  ADD KEY `fk_idproducto_gal` (`idproducto`);

--
-- Indices de la tabla `nacionalidades`
--
ALTER TABLE `nacionalidades`
  ADD PRIMARY KEY (`idnacionalidad`),
  ADD UNIQUE KEY `uk_nombrepais_nac` (`nombrepais`,`nombrecorto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_idcategoria` (`idcategoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `uk_rol_roles` (`rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_idrol_usu` (`idrol`),
  ADD KEY `fk_idnacionalida_usu` (`idnacionalidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  MODIFY `idespecificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
  MODIFY `idgaleria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `nacionalidades`
--
ALTER TABLE `nacionalidades`
  MODIFY `idnacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datasheet`
--
ALTER TABLE `datasheet`
  ADD CONSTRAINT `fk_idproducto_data` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`);

--
-- Filtros para la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `fk_idproducto_gal` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_idnacionalida_usu` FOREIGN KEY (`idnacionalidad`) REFERENCES `nacionalidades` (`idnacionalidad`),
  ADD CONSTRAINT `fk_idrol_usu` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
