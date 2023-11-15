-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2023 a las 23:29:46
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_modificar` (IN `_idequipo` INT, IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200))   BEGIN

	UPDATE equipos SET
		idcategoria 	= _idcategoria,
		idmarca			= _idmarca,
		idusuario		= _idusuario,
		modelo_equipo	= _modelo_equipo,
		numero_serie	= _numero_serie,
		imagen			= _imagen,
        update_at       = now()

	WHERE 
		idequipo = _idequipo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_equipos_registrar` (IN `_idcategoria` INT, IN `_idmarca` INT, IN `_idusuario` INT, IN `_modelo_equipo` VARCHAR(45), IN `_numero_serie` VARCHAR(45), IN `_imagen` VARCHAR(200))   BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''));
	SELECT @@last_insert_id 'idequipo';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_insertar_marca` (IN `_marca` VARCHAR(45))   BEGIN
	INSERT INTO marcas
    (marca)
    VALUES 
    (_marca);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_listar_marca` ()   BEGIN
	SELECT idmarca, marca
    FROM marcas
    WHERE inactive_at IS NULL;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_mantenimiento_registrar` (IN `_idusuario` INT, IN `_idcronograma` INT, IN `_descripcion` VARCHAR(300))   BEGIN
	INSERT INTO matenimiento 
		(idusuario,idcronograma,descripcion)
        VALUES
        (_idusuario,_idcronograma,_descripcion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_matenimiento_listar` ()   BEGIN
	SELECT
		man.idusuario,
        usu.
        cro.tipo_mantenimiento,
        equ.numero_serie,
        man.descripcion
    FROM mantenimiento as man
    INNER JOIN usuarios as usu on usu.idusuario = man.idusuario
    INNER JOIN cronograma as cro ON cro.idcronograma = man.idcronograma
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo 
    WHERE
		man.inactie_at IS NULL;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_obtener_id` (IN `_idusuario` INT)   BEGIN
	SELECT idusuario, apellidos, nombres, rol, email, avatar FROM usuarios
		WHERE idusuario = _idusuario AND inactive_at IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_usuarios_recuperar` (IN `_email` VARCHAR(60))   BEGIN
	SELECT idusuario, email
		FROM usuarios WHERE email = _email AND inactive_at IS NULL;
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
(1, 'Laptops', '2023-11-15', NULL, NULL),
(2, 'Computadoras', '2023-11-15', NULL, NULL);

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
(3, 1, 'color', 'marron\r\n', '2023-11-15', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `idequipo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idmarca` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `modelo_equipo` varchar(45) NOT NULL,
  `numero_serie` varchar(45) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  `inactive_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`idequipo`, `idcategoria`, `idmarca`, `idusuario`, `modelo_equipo`, `numero_serie`, `imagen`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 2, 2, 2, '0', '0', '111111111', '2023-11-15', '2023-11-15', NULL),
(3, 2, 2, 2, 'nuevo', '11112', 'b2eb0e3b4bc49bfa0ed33f466c026b6ad1e07c99.jpg', '2023-11-15', '2023-11-15', NULL),
(5, 2, 2, 1, 'nuevo', '4564', 'efc9337a71a1b923b4a4517c1319821f8cab39da.jpg', '2023-11-15', NULL, NULL),
(6, 2, 2, 1, 'modelo', '789456', 'c4c7b0dbe3ea6d59c6f399de8e99c0ed10cafec0.jpg', '2023-11-15', NULL, NULL),
(7, 2, 2, 1, 'NUEVA EPSON', '111111', '5cfb7d57dfce6feb61a7588d21f4dae3872986cf.jpg', '2023-11-15', '2023-11-15', NULL),
(8, 1, 1, 2, 'MODELO 3', '963852741', '1e8a54c2a4987cf8cd6a3a2336c2cece80b26a34.jpg', '2023-11-15', NULL, NULL),
(9, 2, 2, 1, 'mdelo 3 ', 'modelo 3 ', '3d88505c1f2d9944c66a892af24c98e83480618f.jpg', '2023-11-15', NULL, NULL),
(11, 2, 2, 1, 'mdelo 3 ', 'modelo 5', 'cb22b3ff2381eaa9cdf77f66b015b47a67a57c3c.jpg', '2023-11-15', NULL, NULL),
(13, 1, 1, 2, 'mdeo de thunder', '74185245', '0dc641f198baf8a03d49f1b7c8b679e6b9b1000d.jpg', '2023-11-15', '2023-11-15', NULL);

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
-- Estructura de tabla para la tabla `man_sectores`
--

CREATE TABLE `man_sectores` (
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

--
-- Volcado de datos para la tabla `man_sectores`
--

INSERT INTO `man_sectores` (`idmantenimiento_sector`, `idsector`, `idequipo`, `idusuario`, `fecha_inicio`, `fecha_fin`, `create_at`, `update_at`, `inactive_at`) VALUES
(4, 1, 1, 1, '2023-12-12', NULL, '2023-11-15', NULL, NULL);

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
(1, 'EPSON', '2023-11-15', NULL, NULL),
(2, 'SONY', '2023-11-15', NULL, NULL);

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

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`idsector`, `sector`, `create_at`, `update_at`, `inactive_at`) VALUES
(1, 'psicología', '2023-11-15', NULL, NULL),
(2, 'secretaría', '2023-11-15', NULL, NULL),
(3, 'aula de profesores', '2023-11-15', NULL, NULL);

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
(1, 'Adrianita', 'Durand Buenamarca', 'ADMIN', '$2y$10$75lA.B0Xsqf12p96E/myo.MJG3EylGhH92ENeFKMcQ2Ysjk//FmHm', 'adriana@gmail.com', '452cac3b55a86acf6d87907b0608670de2788d3b.jpg', NULL, '2023-11-09', '2023-11-15', NULL),
(2, 'Lucas Alfredo', 'Atuncar valerio', 'ADMIN', '$2y$10$t9Pl8P6iY7RtcBLK20fkL.hNO4eOwvD2gGHlaw6f.P8AOvs3XY2Vq', 'lucasatuncar1@gmail.com', '9a778ded0bbc5e59ec3d35dff25d7aeb561a51fa.jpg', NULL, '2023-11-15', '2023-11-15', NULL);

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
,`modelo_equipo` varchar(45)
,`numero_serie` varchar(45)
,`imagen` varchar(200)
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vws_equipos`  AS SELECT `equi`.`idequipo` AS `idequipo`, `cat`.`idcategoria` AS `idcategoria`, `cat`.`categoria` AS `categoria`, `mar`.`idmarca` AS `idmarca`, `mar`.`marca` AS `marca`, `equi`.`modelo_equipo` AS `modelo_equipo`, `equi`.`numero_serie` AS `numero_serie`, `equi`.`imagen` AS `imagen`, `usu`.`nombres` AS `nombres` FROM (((`equipos` `equi` join `categorias` `cat` on(`cat`.`idcategoria` = `equi`.`idcategoria`)) join `marcas` `mar` on(`mar`.`idmarca` = `equi`.`idmarca`)) join `usuarios` `usu` on(`usu`.`idusuario` = `equi`.`idusuario`)) WHERE `equi`.`inactive_at` is null ;

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
-- Indices de la tabla `man_sectores`
--
ALTER TABLE `man_sectores`
  ADD PRIMARY KEY (`idmantenimiento_sector`),
  ADD KEY `fk_idsector_sect` (`idsector`),
  ADD KEY `fk_idequipo_sect` (`idequipo`),
  ADD KEY `fk_idusuario_sect` (`idusuario`);

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
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cronogramas`
--
ALTER TABLE `cronogramas`
  MODIFY `idcronograma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datasheet`
--
ALTER TABLE `datasheet`
  MODIFY `iddatasheet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `idequipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `idmantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `man_sectores`
--
ALTER TABLE `man_sectores`
  MODIFY `idmantenimiento_sector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `idsector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Filtros para la tabla `man_sectores`
--
ALTER TABLE `man_sectores`
  ADD CONSTRAINT `fk_idequipo_sect` FOREIGN KEY (`idequipo`) REFERENCES `equipos` (`idequipo`),
  ADD CONSTRAINT `fk_idsector_sect` FOREIGN KEY (`idsector`) REFERENCES `sectores` (`idsector`),
  ADD CONSTRAINT `fk_idusuario_sect` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
