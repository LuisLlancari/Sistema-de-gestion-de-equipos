-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2023 a las 10:15:04
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
-- Base de datos: `siscompu`
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
        cro.fecha_programada
    FROM cronogramas as cro
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_modificar` (IN `_idcronograma` INT, IN `_idequipo` INT, IN `_tipo_mantenimiento` VARCHAR(45), IN `_estado` VARCHAR(10), IN `_fecha_programada` DATETIME)   BEGIN
	UPDATE cronogramas SET
		idequipo 			= _idequipo,			
		tipo_mantenimiento 	= _tipo_mantenimiento,
		estado 				= _estado,
		fecha_programada 	=_fecha_programada
	WHERE
		idcronograma = _idcronograma;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronogramas_registrar` (IN `_idequipo` INT, IN `_tipo_mantenimiento` VARCHAR(45), IN `_estado` VARCHAR(10), IN `_fecha_programada` DATETIME)   BEGIN
	INSERT INTO cronogramas
		(idequipo,tipo_mantenimiento,estado,fecha_programada)
		VALUES
        (_idequipo,_tipo_mantenimiento,_estado,_fecha_programada);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_cronograma_eliminar` (IN `_idcronograma` INT)   BEGIN
	UPDATE cronogramas SET
		inactive_at = now();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_eliminar` (IN `_iddatasheet` INT)   BEGIN
	delete from datasheet
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
	INSERT INTO datasheet
    (idequipo, clave, valor)
    VALUES
    (_idequipo, _clave, _valor);
    SELECT @@last_insert_id 'iddatasheet';
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_modificar` (IN `_idequipo` INT, IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_descripcion` INT, IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200), IN `_estado` CHAR(1))   BEGIN

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_insertar_marca` (IN `_marca` VARCHAR(45))   BEGIN
	INSERT INTO marcas
    (marca)
    VALUES 
    (_marca);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_insertar_sectores` (IN `_idsector` INT, IN `_sector` VARCHAR(45))   BEGIN
	INSERT INTO sectores
    (idsector,sector)
    VALUES 
    (_idsector,_sector);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_categorias` ()   BEGIN
	SELECT idcategoria, categoria
    FROM categorias
    WHERE inactive_at IS NULL;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_MANsector_eliminar` (IN `_idmantenimiento_sector` INT)   BEGIN 
	UPDATE MAN_sectores
    SET inactive_at = NOW()
		WHERE idmantenimiento_sector = _idmantenimiento_sector;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_eliminar` (IN `_idmantenimiento` INT)   BEGIN
	UPDATE mantenimiento SET
		inactive_at = now();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_listar` ()   BEGIN
	SELECT
		man.idusuario,
        usu.nombres,
        cro.tipo_mantenimiento,
        equ.numero_serie,
        man.descripcion
    FROM mantenimiento as man
    INNER JOIN usuarios as usu on usu.idusuario = man.idusuario
    INNER JOIN cronogramas as cro ON cro.idcronograma = man.idcronograma
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo 
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
(1, 'Pantallas', '2023-11-16', NULL, NULL),
(2, 'Ordenadores', '2023-11-16', NULL, NULL),
(3, 'Computadoras', '2023-11-16', NULL, NULL),
(4, 'Laptops', '2023-11-16', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronogramas`
--

CREATE TABLE `cronogramas` (
  `idcronograma` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `tipo_mantenimiento` varchar(45) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `fecha_programada` datetime NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 1, 'DESCRIPCIÓN', '120', '2023-11-17', '2023-11-17', NULL),
(8, 1, 'color', 'gris', '2023-11-17', NULL, NULL);

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
(1, 1, 1, 1, 'descripcion1', 'Equipo Nuevo Modelo', 'J11111111', NULL, '1', '2023-11-17', NULL, NULL),
(3, 1, 1, 1, 'descripcion1', 'Equipo Nuevo Modelo', 'J11111112', NULL, '', '2023-11-17', NULL, NULL);

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
(1, 'Asus', '2023-11-16', NULL, NULL),
(2, 'lenovo', '2023-11-16', NULL, NULL),
(3, 'SONY', '2023-11-16', NULL, NULL),
(4, 'EPSON', '2023-11-16', NULL, NULL);

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
  `idmantenimiento_sector` int(11) NOT NULL,
  `idsector` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
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
(1, 'Adriana', 'Durand Buenamarca', 'ADMIN', '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm', 'adriana@gmailcom', '48df68a6285bc0de5738cc91d24c275b45327294.jpg', NULL, '2023-11-16', '2023-11-16', NULL),
(3, 'Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL, NULL, '2023-11-16', NULL, NULL);

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
,`estado` varchar(13)
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vws_equipos`  AS SELECT `equi`.`idequipo` AS `idequipo`, `cat`.`idcategoria` AS `idcategoria`, `cat`.`categoria` AS `categoria`, `mar`.`idmarca` AS `idmarca`, `mar`.`marca` AS `marca`, `equi`.`descripcion` AS `descripcion`, `equi`.`modelo_equipo` AS `modelo_equipo`, `equi`.`numero_serie` AS `numero_serie`, `equi`.`imagen` AS `imagen`, CASE `equi`.`estado` WHEN '0' THEN 'inactivo' WHEN '1' THEN 'activo' WHEN '3' THEN 'mantenimiento' END AS `estado`, `usu`.`nombres` AS `nombres` FROM (((`equipos` `equi` join `categorias` `cat` on(`cat`.`idcategoria` = `equi`.`idcategoria`)) join `marcas` `mar` on(`mar`.`idmarca` = `equi`.`idmarca`)) join `usuarios` `usu` on(`usu`.`idusuario` = `equi`.`idusuario`)) WHERE `equi`.`inactive_at` is null ;

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
  ADD PRIMARY KEY (`idmantenimiento_sector`),
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
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cronogramas`
--
ALTER TABLE `cronogramas`
  MODIFY `idcronograma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  MODIFY `iddatasheet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `idequipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `idmantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `idsector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sectores_detalle`
--
ALTER TABLE `sectores_detalle`
  MODIFY `idmantenimiento_sector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
