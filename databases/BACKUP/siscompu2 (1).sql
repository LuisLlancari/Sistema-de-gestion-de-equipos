-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2023 a las 18:29:10
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
-- Base de datos: `siscompu2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_canbiar_contraseña` (IN `_idusuario` INT, IN `_claveacceso` VARCHAR(60))   BEGIN
	UPDATE usuarios
		SET claveacceso = _claveacceso,
			codigo 		= null
			WHERE idusuario = _idusuario;
		SELECT idusuario FROm usuarios
			WHERE idusuario = _idusuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_categorias_registrar` (IN `_categoria` VARCHAR(45))   BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_listar` ()   BEGIN
	SELECT
		cro.idcronograma,
        equ.modelo_equipo,
        equ.numero_serie,
        cro.tipo_mantenimiento,
        cro.estado,
        cro.fecha_programada,
        man.descripcion
    FROM cronogramas as cro
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
	left JOIN mantenimiento as man on man.idcronograma=cro.idcronograma

    WHERE
		cro.inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_listar_id` (IN `_idequipo` INT)   BEGIN
	SELECT
		cro.idcronograma,
        equ.modelo_equipo,
        equ.numero_serie,
        cro.tipo_mantenimiento,
        cro.estado,
        cro.fecha_programada
    FROM cronogramas as cro
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
    WHERE
		cro.idequipo =_idequipo AND cro.inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_modificar` (IN `_idcronograma` INT, IN `_tipo_mantenimiento` VARCHAR(45), IN `_estado` VARCHAR(10), IN `_fecha_programada` DATETIME, IN `_comentario` VARCHAR(300), IN `_idusuario` INT)   BEGIN
	UPDATE cronogramas SET
		tipo_mantenimiento 	= _tipo_mantenimiento,
		estado 				= _estado,
		fecha_programada 	=_fecha_programada
	WHERE
		idcronograma = _idcronograma;
        
 
	IF _estado = 'completado' THEN
		
			INSERT INTO mantenimiento (idusuario, idcronograma, descripcion)
			VALUES (_idusuario, _idcronograma, _comentario);
            
            UPDATE cronogramas SET 
				inactive_at = now()
					WHERE idcronograma = _idcronograma;
	END IF;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_registrar` (IN `_numero_serie` VARCHAR(45), IN `_tipo_mantenimiento` VARCHAR(45), IN `_fecha_programada` DATETIME)   BEGIN
	SELECT idequipo INTO @equipoid from equipos Where numero_serie = _numero_serie;
	
	INSERT INTO cronogramas
		(idequipo,tipo_mantenimiento,fecha_programada)
		VALUES
        (@equipoid,_tipo_mantenimiento,_fecha_programada);
        
        SELECT @@last_insert_id 'idcronograma';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronograma_eliminar` (IN `_idcronograma` INT)   BEGIN
	UPDATE cronogramas SET
		inactive_at = now()
			where idcronograma = _idcronograma;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronograma_grafico` (IN `_fecha_inicio` DATE, IN `_fecha_fin` DATE)   BEGIN
	 
SELECT
count(1) as 'cantidad_tipo',
cro.estado
FROM cronogramas as cro
INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
left JOIN mantenimiento as man on man.idcronograma=cro.idcronograma
WHERE cro.inactive_at IS NULL and cro.estado!=''
AND cro.create_at between _fecha_inicio and _fecha_fin
group by cro.estado;
     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_eliminar` (IN `_iddatasheet` INT)   BEGIN
	UPDATE datasheet SET
		inactive_at = now()
	WHERE
		iddatasheet = _iddatasheet;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_listar` (IN `_idequipo` INT)   BEGIN
	SELECT * FROM vw_datasheet
    WHERE idequipo = _idequipo
    ORDER BY clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_modificar` (IN `_iddatasheet` INT, IN `_idequipo` INT, IN `_clave` VARCHAR(45), IN `_valor` VARCHAR(300))   BEGIN
	UPDATE datasheet SET
		idequipo 	= _idequipo,
		clave 		= _clave,
		valor		= _valor,
        update_at 	= now()
	WHERE
		iddatasheet = _iddatasheet;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_registrar` (IN `_idequipo` INT, IN `_clave` VARCHAR(45), IN `_valor` VARCHAR(300))   BEGIN
    DECLARE cantidad INT;
	DECLARE estadoExist DATE;
    
    SELECT COUNT(*) INTO cantidad
    FROM datasheet
	WHERE 
		idequipo 	= _idequipo AND
		clave		= _clave
	ORDER BY create_at asc
	LIMIT 1;
    
    IF cantidad > 0
		THEN
			-- verificamos si existe la clave
			SELECT inactive_at INTO estadoExist
			FROM datasheet 
			WHERE 
				idequipo 	= _idequipo AND
				clave		= _clave
			ORDER BY create_at asc
            LIMIT 1;
	
				IF estadoExist IS NOT NULL 
					THEN
						INSERT INTO datasheet
						(idequipo, clave, valor)
						VALUES
						(_idequipo, _clave, _valor);
						SELECT @@last_insert_id 'iddatasheet';
				ELSE
					SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe un registro';
				END IF;
ELSE 
		INSERT INTO datasheet
		(idequipo, clave, valor)
		VALUES
		(_idequipo, _clave, _valor);
		SELECT @@last_insert_id 'iddatasheet';
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_listar` ()   BEGIN
	SELECT * FROM vws_equipos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_listar_categoria` (IN `_idcategoria` INT)   BEGIN
	IF _idcategoria = 0 THEN
		SELECT * FROM vws_equipos;
	ELSE 
		SELECT * FROM vws_equipos
		WHERE
			idcategoria = _idcategoria;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_modificar` (IN `_idequipo` INT, IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_descripcion` VARCHAR(45), IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200), IN `_estado` CHAR(1))   BEGIN

	UPDATE equipos SET
		idcategoria 	= _idcategoria,
		idmarca			= _idmarca,
		idusuario		= _idusuario,
        descripcion		= _descripcion,
		modelo_equipo	= _modelo_equipo,
		numero_serie	= _numero_serie,
		imagen			= _imagen,
        estado			= _estado,
        update_at       = now()

	WHERE 
		idequipo = _idequipo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_obtener` (IN `_idequipo` INT)   BEGIN
	SELECT * FROM vws_equipos
	WHERE
		idequipo = _idequipo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_registrar` (IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_descripcion` VARCHAR(45), IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200), IN `_estado` CHAR(1))   BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen, estado)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _descripcion, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''), _estado);
	SELECT @@last_insert_id 'idequipo';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_registrar_sector` (IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_descripcion` VARCHAR(45), IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200), IN `_idsector` INT)   BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _descripcion, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''));
    
	SELECT @@last_insert_id 'idequipo' INTO @equipoid;
    
    INSERT INTO sectores_detalle(idsector, idequipo, idusuario)
	VALUES(_idsector, @equipoid, _idusuario);
    
	SELECT @@last_insert_id 'idmantenimiento_sector';
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_estadistica_equiposCategoria` ()   BEGIN
	SELECT COUNT(*) AS 'cantidad',
		CAT.categoria
    FROM equipos AS EQUI
	INNER JOIN categorias AS CAT ON CAT.idcategoria = EQUI.idcategoria
	WHERE
		EQUI.inactive_at IS NULL
	GROUP BY categoria
	ORDER BY categoria;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_estadistica_equiposporEstado` ()   BEGIN
	SELECT 
		COUNT(*) AS 'cantidad',
        CASE estado
			WHEN '0' THEN 'Inactivo'
            WHEN '1' THEN 'Activo'
            WHEN '2' THEN 'Mantenimiento'
		END AS estado
    FROM equipos
    WHERE
		inactive_at IS NULL
	GROUP BY estado
	ORDER BY descripcion ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_estadistica_equiposSector` ()   BEGIN
	SELECT COUNT(*) AS 'equipos',
		SEC.sector
    FROM sectores_detalle AS SED
    INNER JOIN sectores AS SEC ON SEC.idsector = SED.idsector
    WHERE
		SED.inactive_at IS NULL
	GROUP BY SEC.sector
	ORDER BY SEC.sector; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_insertar_marca` (IN `_marca` VARCHAR(45))   BEGIN
	INSERT INTO marcas
    (marca)
    VALUES 
    (_marca);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_insertar_sector` (IN `_sector` VARCHAR(45))   BEGIN
	INSERT INTO sectores
    (sector)
    VALUES 
    (_sector);
	SELECT @@last_insert_id 'idsector';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_categorias` ()   BEGIN
	SELECT idcategoria, categoria
    FROM categorias
    WHERE inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_detalleSectores` (IN `_idsector` INT)   BEGIN
    SELECT DET.iddeatlle_sector,
		SEC.sector,
        CAT.categoria,
        MAR.marca,
        EQUI.modelo_equipo,
        EQUI.numero_serie,
        USU.nombres,
        USU.apellidos,
        DET.fecha_inicio,
        DET.fecha_fin
    FROM sectores_detalle DET
    INNER JOIN sectores SEC ON SEC.idsector = DET.idsector
    INNER JOIN equipos EQUI ON EQUI.idequipo = DET.idequipo
    INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
	INNER JOIN marcas MAR ON MAR.idmarca = EQUI.idmarca
    INNER JOIN usuarios USU ON USU.idusuario = DET.idusuario
    WHERE DET.inactive_at IS NULL
      AND DET.idsector = 7;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_MANsectores` ()   BEGIN
	SELECT MANSEC.idmantenimiento_sector,
    SEC.sector,
	CAT.categoria,
    EQUI.numero_serie,
    USU.nombres,
    MANSEC.fecha_inicio,
	MANSEC.fecha_fin
    FROM MAN_sectores MANSEC
    INNER JOIN sectores SEC ON SEC.idsector = MANSEC.idsector
	INNER JOIN equipos EQUI ON EQUI.idequipo = MANSEC.idequipo
	INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
	INNER JOIN usuarios USU ON USU.idusuario = MANSEC.idusuario
    WHERE MANSEC.inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_mantenimiento_porID` (IN `_idmantenimiento` INT)   BEGIN
    SELECT 
        idmantenimiento,
        idusuario,
        idcronograma,
        descripcion,
        create_at,
        update_at,
        inactive_at
    FROM mantenimiento
    WHERE idmantenimiento = _idmantenimiento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_marca` ()   BEGIN
	SELECT idmarca, marca
    FROM marcas
    WHERE inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_sectores` ()   BEGIN
	SELECT idsector, sector
    FROM sectores
    WHERE inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_eliminar` (IN `_idmantenimiento` INT)   BEGIN
	UPDATE mantenimiento SET
		inactive_at = now();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_grafico` (IN `_fecha_inicio` DATE, IN `_fecha_fin` DATE)   BEGIN
SELECT
count(1) as 'cantidad_tipo',
cro.tipo_mantenimiento
FROM cronogramas as cro
INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
left JOIN mantenimiento as man on man.idcronograma=cro.idcronograma
WHERE cro.inactive_at IS NULL and cro.tipo_mantenimiento!=''
 AND man.create_at between _fecha_inicio and _fecha_fin
group by cro.tipo_mantenimiento;
     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_listar` ()   BEGIN
		SELECT
			man.idcronograma,
			man.idusuario,
			usu.nombres,
            cat.categoria,
			mar.marca,
			equ.modelo_equipo as 'equipo',
			cro.fecha_programada as 'fecha_del_mantenimiento',
			equ.numero_serie,
			cro.tipo_mantenimiento,
			man.descripcion
		FROM mantenimiento as man
		INNER JOIN usuarios as usu on usu.idusuario = man.idusuario
		INNER JOIN cronogramas as cro ON cro.idcronograma = man.idcronograma
		INNER JOIN equipos as equ on equ.idequipo = cro.idequipo 
		INNER JOIN marcas AS mar ON mar.idmarca = equ.idmarca
		INNER JOIN categorias AS cat ON cat.idcategoria = equ.idcategoria
    WHERE
		man.inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_modificar` (IN `_idmantenmimiento` INT, IN `_idusuario` INT, IN `_idcronograma` INT, IN `_descripcion` VARCHAR(300))   BEGIN
	UPDATE mantenimiento SET
		idusuario	 = _idusuario,
		idcronograma =_idcronograma,
		descripcion  =_descripcion		
	WHERE
		idmantenimiento = _idmantenmimiento	;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_registrar` (IN `_idusuario` INT, IN `_idcronograma` INT, IN `_descripcion` VARCHAR(300))   BEGIN
	INSERT INTO mantenimiento 
		(idusuario,idcronograma,descripcion)
        VALUES
        (_idusuario,_idcronograma,_descripcion);
        
	SELECT @@last_insert_id 'idmantenimiento';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mover_equipo` (IN `_iddetalle_sector` INT, IN `_idsector` INT, IN `_idusuario` INT)   BEGIN
	SELECT idequipo INTO @equipoid from sectores_detalle 
	where idmantenimiento_sector = _iddetalle_sector;
    
	INSERT INTO sectores_detalle(idsector,idequipo,idusuario)
	VALUES (_idsector ,@equipoid,_idusuario);
    
	UPDATE sectores_detalle 
	SET inactive_at = now(),
		fecha_fin = now()
        Where idmantenimiento_sector = _iddetalle_sector;
	
	SELECT @@last_insert_id 'idmantenimiento_sector';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_obtenerCNsectores` ()   BEGIN
    SELECT 
        s.idsector,
        s.sector AS Nombre_Sector,
        COUNT(sd.idsector) AS Cantidad_Guardados
    FROM
        sectores s
    LEFT JOIN
        sectores_detalle sd ON s.idsector = sd.idsector AND sd.fecha_fin IS NULL
    WHERE s.inactive_at IS NULL
    GROUP BY
        s.idsector;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_sector_eliminar` (IN `_idsector` INT)   BEGIN 
	UPDATE sectores
    SET inactive_at = NOW()
		WHERE idsector = _idsector;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_eliminar` (IN `_idusuario` INT)   BEGIN 
	UPDATE usuarios
    SET inactive_at = NOW()
		WHERE idusuario = _idusuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_generar_clave` (IN `_idusuario` INT, IN `_codigo` CHAR(6))   BEGIN
	UPDATE usuarios
		SET codigo = _codigo
			WHERE idusuario = _idusuario;
            SELECT idusuario FROm usuarios
			WHERE idusuario = _idusuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_listar` ()   BEGIN
	SELECT idusuario, nombres, apellidos, rol, email, avatar FROM usuarios
		WHERE inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_login` (IN `_email` VARCHAR(60))   BEGIN
    SELECT
        USU.idusuario,
        USU.apellidos,
        USU.nombres,
        USU.email,
        USU.claveacceso,
        USU.rol,
        USU.avatar
    FROM usuarios AS USU
    WHERE USU.email = _email AND USU.inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_obtener` (IN `_idusuario` INT)   BEGIN
	SELECT * FROM usuarios
	WHERE 
		idusuario = _idusuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_obtener_id` (IN `_idusuario` INT)   BEGIN
	SELECT idusuario, apellidos, nombres, rol, email, avatar FROM usuarios
		WHERE idusuario = _idusuario AND inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_recuperar` (IN `_email` VARCHAR(60))   BEGIN
	SELECT * FROM usuarios 
	WHERE 
		email = _email AND
		inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_registrar` (IN `_nombres` VARCHAR(40), IN `_apellidos` VARCHAR(45), IN `_rol` VARCHAR(20), IN `_claveacceso` VARCHAR(60), IN `_email` VARCHAR(60), IN `_avatar` VARCHAR(200))   BEGIN
	INSERT INTO usuarios
    (nombres, apellidos, rol, claveacceso, email, avatar)
    VALUES
    (_nombres, _apellidos, _rol, _claveacceso, _email, NULLIF(_avatar, ''));
	SELECT @@last_insert_id 'idusuario';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_verificar` (IN `_idusuario` INT)   BEGIN
	SELECT idusuario, codigo FROM usuarios
		WHERE idusuario = _idusuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuario_modificar` (IN `_idusuario` INT, IN `_nombres` VARCHAR(40), IN `_apellidos` VARCHAR(45), IN `_rol` VARCHAR(20), IN `_email` VARCHAR(60), IN `_avatar` VARCHAR(200))   BEGIN
	UPDATE usuarios SET
		idusuario	= _idusuario,
		nombres  	= _nombres,
        apellidos 	= _apellidos,
        rol 		= _rol,
        email		= _email,
        avatar 		= _avatar,
        update_at   = now()
	WHERE
		idusuario 	= _idusuario;
	
    SELECT idusuario FROM usuarios 
        WHERE idusuario = _idusuario;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(45) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `categoria`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'Laptops', '2023-11-20', NULL, NULL),
(2, 'Computadoras de Escritorio', '2023-11-20', NULL, NULL),
(3, 'Tablets', '2023-11-20', NULL, NULL),
(4, 'Monitores', '2023-11-20', NULL, NULL),
(5, 'Teclados', '2023-11-20', NULL, NULL),
(6, 'Mouse', '2023-11-20', NULL, NULL),
(7, 'Impresoras', '2023-11-20', NULL, NULL),
(8, 'Almacenamiento', '2023-11-20', NULL, NULL),
(9, 'Componentes de PC', '2023-11-20', NULL, NULL),
(10, 'Software', '2023-11-20', NULL, NULL),
(11, 'Accesorios', '2023-11-20', NULL, NULL),
(12, 'Redes', '2023-11-20', NULL, NULL),
(13, 'Audio', '2023-11-20', NULL, NULL),
(14, 'Proyectores', '2023-11-20', NULL, NULL),
(15, 'Energía', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronogramas`
--

CREATE TABLE `cronogramas` (
  `idcronograma` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `tipo_mantenimiento` varchar(45) NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'pendiente',
  `fecha_programada` datetime NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cronogramas`
--

INSERT INTO `cronogramas` (`idcronograma`, `idequipo`, `tipo_mantenimiento`, `estado`, `fecha_programada`, `create_at`, `update_at`, `inactive_at`) VALUES
(5, 61, 'Preventivo', 'pendiente', '2023-11-20 00:00:00', '2023-11-20', NULL, NULL),
(6, 62, 'Mantenimiento', 'en curso', '2023-11-18 00:00:00', '2023-11-20', NULL, NULL),
(7, 62, 'Mantenimiento', 'Realizado', '2023-08-10 00:00:00', '2023-11-20', NULL, NULL),
(8, 62, 'Mantenimiento', 'Cancelado', '2023-10-12 00:00:00', '2023-11-20', NULL, NULL),
(9, 61, 'Mantenimiento preventivo', 'pendiente', '2023-12-05 08:00:00', '2023-11-20', NULL, NULL),
(10, 61, 'Mantenimiento correctivo', 'en proceso', '2023-12-10 10:30:00', '2023-11-20', NULL, NULL),
(11, 61, 'Mantenimiento predictivo', 'pendiente', '2023-12-15 14:45:00', '2023-11-20', NULL, NULL),
(12, 62, 'Mantenimiento correctivo', 'pendiente', '2023-12-08 09:15:00', '2023-11-20', NULL, NULL),
(13, 62, 'Mantenimiento preventivo', 'en proceso', '2023-12-12 11:00:00', '2023-11-20', NULL, NULL),
(14, 62, 'Mantenimiento predictivo', 'en proceso', '2023-12-18 16:20:00', '2023-11-20', NULL, NULL),
(15, 63, 'Mantenimiento predictivo', 'pendiente', '2023-12-06 07:45:00', '2023-11-20', NULL, NULL),
(16, 63, 'Mantenimiento preventivo', 'en proceso', '2023-12-11 10:00:00', '2023-11-20', NULL, NULL),
(17, 63, 'Mantenimiento correctivo', 'pendiente', '2023-12-16 12:30:00', '2023-11-20', NULL, NULL),
(18, 64, 'Mantenimiento correctivo', 'pendiente', '2023-12-09 08:30:00', '2023-11-20', NULL, NULL),
(19, 64, 'Mantenimiento predictivo', 'en proceso', '2023-12-13 09:45:00', '2023-11-20', NULL, NULL),
(20, 64, 'Mantenimiento preventivo', 'pendiente', '2023-12-19 11:15:00', '2023-11-20', NULL, NULL),
(21, 65, 'Mantenimiento predictivo', 'en proceso', '2023-12-07 10:00:00', '2023-11-20', NULL, NULL),
(22, 65, 'Mantenimiento correctivo', 'en proceso', '2023-12-14 12:00:00', '2023-11-20', NULL, NULL),
(23, 65, 'Mantenimiento preventivo', 'pendiente', '2023-12-17 14:00:00', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datasheet`
--

CREATE TABLE `datasheet` (
  `iddatasheet` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `valor` varchar(300) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datasheet`
--

INSERT INTO `datasheet` (`iddatasheet`, `idequipo`, `clave`, `valor`, `create_at`, `update_at`, `inactive_at`) VALUES
(11, 61, 'RAM', '8GB DDR4', '2023-11-20', NULL, NULL),
(12, 61, 'Almacenamiento', '256GB SSD', '2023-11-20', NULL, NULL),
(13, 61, 'Sistema Operativo', 'Windows 10', '2023-11-20', NULL, NULL),
(14, 61, 'Procesador', 'Intel Core i5', '2023-11-20', NULL, NULL),
(15, 61, 'Pantalla', '14\" FHD', '2023-11-20', NULL, NULL),
(16, 61, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0', '2023-11-20', NULL, NULL),
(17, 61, 'Puertos', 'USB-C, HDMI, USB 3.0', '2023-11-20', NULL, NULL),
(18, 61, 'Batería', 'Hasta 8 horas de duración', '2023-11-20', NULL, NULL),
(19, 61, 'Tarjeta Gráfica', 'Intel UHD Graphics', '2023-11-20', NULL, NULL),
(20, 61, 'Color', 'Plata', '2023-11-20', NULL, NULL),
(21, 62, 'RAM', '8GB DDR4', '2023-11-20', NULL, NULL),
(22, 62, 'Almacenamiento', '256GB SSD', '2023-11-20', NULL, NULL),
(23, 62, 'Sistema Operativo', 'Windows 10', '2023-11-20', NULL, NULL),
(24, 62, 'Procesador', 'Intel Core i5', '2023-11-20', NULL, NULL),
(25, 62, 'Pantalla', '14\" FHD', '2023-11-20', NULL, NULL),
(26, 62, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0', '2023-11-20', NULL, NULL),
(27, 62, 'Puertos', 'USB-C, HDMI, USB 3.0', '2023-11-20', NULL, NULL),
(28, 62, 'Batería', 'Hasta 8 horas de duración', '2023-11-20', NULL, NULL),
(29, 62, 'Tarjeta Gráfica', 'Intel UHD Graphics', '2023-11-20', NULL, NULL),
(30, 62, 'Color', 'Plata', '2023-11-20', NULL, NULL),
(31, 63, 'RAM', '8GB DDR4', '2023-11-20', NULL, NULL),
(32, 63, 'Almacenamiento', '256GB SSD', '2023-11-20', NULL, NULL),
(33, 63, 'Sistema Operativo', 'Windows 10', '2023-11-20', NULL, NULL),
(34, 63, 'Procesador', 'Intel Core i5', '2023-11-20', NULL, NULL),
(35, 63, 'Pantalla', '14\" FHD', '2023-11-20', NULL, NULL),
(36, 63, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0', '2023-11-20', NULL, NULL),
(37, 63, 'Puertos', 'USB-C, HDMI, USB 3.0', '2023-11-20', NULL, NULL),
(38, 63, 'Batería', 'Hasta 8 horas de duración', '2023-11-20', NULL, NULL),
(39, 63, 'Tarjeta Gráfica', 'Intel UHD Graphics', '2023-11-20', NULL, NULL),
(40, 63, 'Color', 'Plata', '2023-11-20', NULL, NULL),
(41, 64, 'RAM', '8GB DDR4', '2023-11-20', NULL, NULL),
(42, 64, 'Almacenamiento', '256GB SSD', '2023-11-20', NULL, NULL),
(43, 64, 'Sistema Operativo', 'Windows 10', '2023-11-20', NULL, NULL),
(44, 64, 'Procesador', 'Intel Core i5', '2023-11-20', NULL, NULL),
(45, 64, 'Pantalla', '14\" FHD', '2023-11-20', NULL, NULL),
(46, 64, 'Conectividad', 'Wi-Fi 6, Bluetooth 5.0', '2023-11-20', NULL, NULL),
(47, 64, 'Puertos', 'USB-C, HDMI, USB 3.0', '2023-11-20', NULL, NULL),
(48, 64, 'Batería', 'Hasta 8 horas de duración', '2023-11-20', NULL, NULL),
(49, 64, 'Tarjeta Gráfica', 'Intel UHD Graphics', '2023-11-20', NULL, NULL),
(50, 64, 'Color', 'Plata', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `idequipo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idmarca` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `modelo_equipo` varchar(45) NOT NULL,
  `numero_serie` varchar(45) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`idequipo`, `idcategoria`, `idmarca`, `idusuario`, `descripcion`, `modelo_equipo`, `numero_serie`, `imagen`, `estado`, `create_at`, `update_at`, `inactive_at`) VALUES
(61, 1, 3, 1, 'Laptop HP EliteBook', 'EliteBook 840 G7', 'NS123456789', NULL, '1', '2023-11-20', NULL, NULL),
(62, 2, 1, 1, 'PC de Escritorio Dell OptiPlex', 'OptiPlex 5080', 'NS987654321', NULL, '1', '2023-11-20', NULL, NULL),
(63, 3, 2, 3, 'Tablet Apple iPad Pro', 'iPad Pro 12.9\"', 'NS456789123', NULL, '1', '2023-11-20', NULL, NULL),
(64, 4, 4, 1, 'Laptop Lenovo ThinkPad', 'ThinkPad X1 Carbon', 'NS654321987', NULL, '1', '2023-11-20', NULL, NULL),
(65, 5, 5, 1, 'PC Gamer Asus ROG', 'ROG Strix G15', 'NS789456123', NULL, '1', '2023-11-20', NULL, NULL),
(66, 6, 6, 3, 'Laptop Acer Aspire', 'Aspire 5', 'NS321654987', NULL, '1', '2023-11-20', NULL, NULL),
(67, 7, 7, 1, 'Surface Pro Microsoft', 'Surface Pro 7', 'NS741852963', NULL, '1', '2023-11-20', NULL, NULL),
(68, 8, 8, 1, 'Smartphone Samsung Galaxy S21', 'Galaxy S21 Ultra', 'NS369258147', NULL, '1', '2023-11-20', NULL, NULL),
(69, 9, 9, 3, 'Laptop Sony VAIO', 'VAIO S', 'NS852147963', NULL, '1', '2023-11-20', NULL, NULL),
(70, 10, 10, 3, 'Laptop Toshiba Satellite', 'Satellite Pro', 'NS147258369', NULL, '1', '2023-11-20', NULL, NULL),
(71, 11, 11, 3, 'Procesador Intel Core i9', 'Core i9-11900K', 'NS963852741', NULL, '1', '2023-11-20', NULL, NULL),
(72, 12, 12, 3, 'Procesador AMD Ryzen 7', 'Ryzen 7 5800X', 'NS258369147', NULL, '1', '2023-11-20', NULL, NULL),
(73, 13, 13, 1, 'Tarjeta Gráfica Nvidia GeForce RTX 3080', 'RTX 3080', 'NS456123789', NULL, '1', '2023-11-20', NULL, NULL),
(74, 14, 14, 1, 'Teclado Mecánico Logitech', 'Logitech G Pro X', 'NS123789456', NULL, '1', '2023-11-20', NULL, NULL),
(75, 15, 15, 3, 'Memoria RAM Corsair Vengeance', 'Vengeance LPX', 'NS789654123', NULL, '1', '2023-11-20', NULL, NULL),
(85, 1, 3, 3, 'Laptop HP EliteBook 2', 'EliteBook 840 G8', 'NS111111111', NULL, '1', '2023-11-20', NULL, NULL),
(86, 2, 1, 3, 'PC de Escritorio Dell OptiPlex 2', 'OptiPlex 5090', 'NS222222222', NULL, '1', '2023-11-20', NULL, NULL),
(87, 3, 2, 1, 'Tablet Apple iPad Pro 2', 'iPad Pro 11\"', 'NS333333333', NULL, '1', '2023-11-20', NULL, NULL),
(88, 4, 3, 3, 'Laptop HP EliteBook 3', 'EliteBook 840 G9', 'NS444444444', NULL, '1', '2023-11-20', NULL, NULL),
(89, 5, 1, 3, 'PC de Escritorio Dell OptiPlex 3', 'OptiPlex 5100', 'NS555555555', NULL, '1', '2023-11-20', NULL, NULL),
(90, 6, 2, 1, 'Tablet Apple iPad Pro 3', 'iPad Pro 10.5\"', 'NS666666666', NULL, '1', '2023-11-20', NULL, NULL),
(91, 13, 3, 3, 'Laptop HP EliteBook 4', 'EliteBook 840 G10', 'NS777777777', NULL, '1', '2023-11-20', NULL, NULL),
(92, 14, 1, 3, 'PC de Escritorio Dell OptiPlex 4', 'OptiPlex 5110', 'NS888888888', NULL, '1', '2023-11-20', NULL, NULL),
(93, 15, 2, 1, 'Tablet Apple iPad Pro 4', 'iPad Pro 10\"', 'NS999999999', NULL, '1', '2023-11-20', NULL, NULL),
(94, 4, 2, 1, 'Teclado Mecánico Logitech', 'Logitech G Pro X', 'NS123789450', NULL, '1', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `idmantenimiento` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcronograma` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`idmantenimiento`, `idusuario`, `idcronograma`, `descripcion`, `create_at`, `update_at`, `inactive_at`) VALUES
(7, 1, 5, 'sin problemas', '2023-11-20', NULL, NULL),
(8, 1, 6, 'con problemas', '2023-11-20', NULL, NULL),
(9, 1, 7, 'algo raro paso', '2023-11-20', NULL, NULL),
(50, 1, 8, 'Cambio de filtros y aceite', '2023-11-20', NULL, NULL),
(51, 2, 9, 'Revisión general de la maquinaria', '2023-11-20', NULL, NULL),
(52, 2, 10, 'Calibración de sensores y controles', '2023-11-20', NULL, NULL),
(53, 1, 11, 'Inspección de componentes críticos', '2023-11-20', NULL, NULL),
(54, 1, 12, 'Alineación y balanceo de equipos', '2023-11-20', NULL, NULL),
(55, 2, 13, 'Mantenimiento preventivo programado', '2023-11-20', NULL, NULL),
(56, 2, 14, 'Reparación de circuitos electrónicos', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idmarca` int(11) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idmarca`, `marca`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'HP', '2023-11-20', NULL, NULL),
(2, 'Dell', '2023-11-20', NULL, NULL),
(3, 'Apple', '2023-11-20', NULL, NULL),
(4, 'Lenovo', '2023-11-20', NULL, NULL),
(5, 'Asus', '2023-11-20', NULL, NULL),
(6, 'Acer', '2023-11-20', NULL, NULL),
(7, 'Microsoft', '2023-11-20', NULL, NULL),
(8, 'Samsung', '2023-11-20', NULL, NULL),
(9, 'Sony', '2023-11-20', NULL, NULL),
(10, 'Toshiba', '2023-11-20', NULL, NULL),
(11, 'Intel', '2023-11-20', NULL, NULL),
(12, 'AMD', '2023-11-20', NULL, NULL),
(13, 'Nvidia', '2023-11-20', NULL, NULL),
(14, 'Logitech', '2023-11-20', NULL, NULL),
(15, 'Corsair', '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `idsector` int(11) NOT NULL,
  `sector` varchar(45) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores_detalle`
--

CREATE TABLE `sectores_detalle` (
  `iddeatlle_sector` int(11) NOT NULL,
  `idsector` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` date DEFAULT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `claveacceso` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `codigo` char(6) DEFAULT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombres`, `apellidos`, `rol`, `claveacceso`, `email`, `avatar`, `codigo`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'Jose', 'Alcantara', 'ADMINISTRADOR', 'SENATI123', 'jose@gmail.com', NULL, NULL, '2023-11-20', NULL, NULL),
(2, 'Adriana', 'Durand Buenamarca', 'ADMINISTRADOR', 'SENATI123', 'adriana@gmail.com', NULL, NULL, '2023-11-20', NULL, NULL),
(3, 'Adrian', 'Durand Buenamarca', 'Administrador', '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm', 'adrian@gmail.com', NULL, NULL, '2023-11-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vws_equipos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vws_equipos` (
`idequipo` int(11)
,`idcategoria` int(11)
,`categoria` varchar(45)
,`idmarca` int(11)
,`marca` varchar(45)
,`descripcion` varchar(45)
,`modelo_equipo` varchar(45)
,`numero_serie` varchar(45)
,`imagen` varchar(200)
,`idsector` int(11)
,`sector` varchar(45)
,`estado` char(1)
,`nombres` varchar(40)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_datasheet`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_datasheet` (
`iddatasheet` int(11)
,`idequipo` int(11)
,`numero_serie` varchar(45)
,`clave` varchar(45)
,`valor` varchar(300)
,`inactive_at` date
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vws_equipos`
--
DROP TABLE IF EXISTS `vws_equipos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vws_equipos`  AS SELECT `equi`.`idequipo` AS `idequipo`, `cat`.`idcategoria` AS `idcategoria`, `cat`.`categoria` AS `categoria`, `mar`.`idmarca` AS `idmarca`, `mar`.`marca` AS `marca`, `equi`.`descripcion` AS `descripcion`, `equi`.`modelo_equipo` AS `modelo_equipo`, `equi`.`numero_serie` AS `numero_serie`, `equi`.`imagen` AS `imagen`, `sde`.`idsector` AS `idsector`, `sec`.`sector` AS `sector`, `equi`.`estado` AS `estado`, `usu`.`nombres` AS `nombres` FROM (((((`equipos` `equi` join `sectores_detalle` `sde` on(`sde`.`idequipo` = `equi`.`idequipo`)) join `sectores` `sec` on(`sec`.`idsector` = `sde`.`idsector`)) join `categorias` `cat` on(`cat`.`idcategoria` = `equi`.`idcategoria`)) join `marcas` `mar` on(`mar`.`idmarca` = `equi`.`idmarca`)) join `usuarios` `usu` on(`usu`.`idusuario` = `equi`.`idusuario`)) WHERE `equi`.`inactive_at` is null AND `sde`.`inactive_at` is null ORDER BY `equi`.`numero_serie` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_datasheet`
--
DROP TABLE IF EXISTS `vw_datasheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_datasheet`  AS SELECT `dsh`.`iddatasheet` AS `iddatasheet`, `dsh`.`idequipo` AS `idequipo`, `equi`.`numero_serie` AS `numero_serie`, `dsh`.`clave` AS `clave`, `dsh`.`valor` AS `valor`, `dsh`.`inactive_at` AS `inactive_at` FROM (`datasheet` `dsh` join `equipos` `equi` on(`equi`.`idequipo` = `dsh`.`idequipo`)) WHERE `dsh`.`inactive_at` is null ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `uk_categoria_cat` (`categoria`);

--
-- Indices de la tabla `cronogramas`
--
ALTER TABLE `cronogramas`
  ADD PRIMARY KEY (`idcronograma`),
  ADD KEY `fk_idequipo_cro` (`idequipo`);

--
-- Indices de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  ADD PRIMARY KEY (`iddatasheet`),
  ADD UNIQUE KEY `uk_idequipoclave` (`idequipo`,`clave`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`idequipo`),
  ADD UNIQUE KEY `uk_numeroserie_prd` (`numero_serie`),
  ADD KEY `fk_idcategoria_prd` (`idcategoria`),
  ADD KEY `fk_idmarca_prd` (`idmarca`),
  ADD KEY `fk_idusuario_prd` (`idusuario`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`idmantenimiento`),
  ADD UNIQUE KEY `uk_idcronogram_man` (`idusuario`,`idcronograma`),
  ADD KEY `fk_idcronograma_man` (`idcronograma`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idmarca`),
  ADD UNIQUE KEY `uk_marca_marc` (`marca`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`idsector`);

--
-- Indices de la tabla `sectores_detalle`
--
ALTER TABLE `sectores_detalle`
  ADD PRIMARY KEY (`iddeatlle_sector`),
  ADD KEY `fk_idsector_sect` (`idsector`),
  ADD KEY `fk_idequipo_sect` (`idequipo`),
  ADD KEY `fk_idusuario_sect` (`idusuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `uk_email_usu` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cronogramas`
--
ALTER TABLE `cronogramas`
  MODIFY `idcronograma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  MODIFY `iddatasheet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `idequipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `idmantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `idsector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sectores_detalle`
--
ALTER TABLE `sectores_detalle`
  MODIFY `iddeatlle_sector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cronogramas`
--
ALTER TABLE `cronogramas`
  ADD CONSTRAINT `fk_idequipo_cro` FOREIGN KEY (`idequipo`) REFERENCES `equipos` (`idequipo`);

--
-- Filtros para la tabla `datasheet`
--
ALTER TABLE `datasheet`
  ADD CONSTRAINT `fk_idequipo_dat` FOREIGN KEY (`idequipo`) REFERENCES `equipos` (`idequipo`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `fk_idcategoria_prd` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`),
  ADD CONSTRAINT `fk_idmarca_prd` FOREIGN KEY (`idmarca`) REFERENCES `marcas` (`idmarca`),
  ADD CONSTRAINT `fk_idusuario_prd` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `fk_idcronograma_man` FOREIGN KEY (`idcronograma`) REFERENCES `cronogramas` (`idcronograma`),
  ADD CONSTRAINT `fk_idusuario_man` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `sectores_detalle`
--
ALTER TABLE `sectores_detalle`
  ADD CONSTRAINT `fk_idequipo_sect` FOREIGN KEY (`idequipo`) REFERENCES `equipos` (`idequipo`),
  ADD CONSTRAINT `fk_idsector_sect` FOREIGN KEY (`idsector`) REFERENCES `sectores` (`idsector`),
  ADD CONSTRAINT `fk_idusuario_sect` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
