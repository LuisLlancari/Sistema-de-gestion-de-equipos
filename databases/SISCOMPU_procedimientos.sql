
USE SISCOMPU;
-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados USUARIOS -------------------------------
-- -------------------------------------------------------------------------------------
select * from usuarios;

DROP PROCEDURE IF EXISTS spu_usuarios_login;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_recuperar(IN _email VARCHAR(60))
BEGIN
	SELECT idusuario, email
		FROM usuarios WHERE email = _email AND inactive_at IS NULL;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_generar_clave(IN _idusuario INT, IN _codigo CHAR(6))
BEGIN
	UPDATE usuarios
		SET codigo = _codigo
			WHERE idusuario = _idusuario;
            SELECT idusuario FROm usuarios
			WHERE idusuario = _idusuario;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_usuarios_verificar(IN _idusuario INT)
BEGIN
	SELECT idusuario, codigo FROM usuarios
		WHERE idusuario = _idusuario;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_canbiar_contraseña(IN _idusuario INT,IN _claveacceso VARCHAR(60))
BEGIN
	UPDATE usuarios
		SET claveacceso = _claveacceso,
			codigo 		= null
			WHERE idusuario = _idusuario;
		SELECT idusuario FROm usuarios
			WHERE idusuario = _idusuario;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_login(IN _email VARCHAR(60))
BEGIN
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
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar
(
	IN _nombres	VARCHAR(40),
    IN _apellidos VARCHAR(45),
    IN _rol VARCHAR(20),
    IN _claveacceso VARCHAR(60),
    IN _email	VARCHAR(60),
    IN _avatar	VARCHAR(200)
)
BEGIN
	INSERT INTO usuarios
    (nombres, apellidos, rol, claveacceso, email, avatar)
    VALUES
    (_nombres, _apellidos, _rol, _claveacceso, _email, NULLIF(_avatar, ''));
	SELECT @@last_insert_id 'idusuario';
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT idusuario, nombres, apellidos, rol, email, avatar FROM usuarios
		WHERE inactive_at IS NULL;
END $$
DELIMITER ;
	
    
DELIMITER $$
CREATE PROCEDURE spu_usuarios_obtener_id(IN _idusuario INT)
BEGIN
	SELECT idusuario, apellidos, nombres, rol, email, avatar FROM usuarios
		WHERE idusuario = _idusuario AND inactive_at IS NULL;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_eliminar(IN _idusuario INT)
BEGIN 
	UPDATE usuarios
    SET inactive_at = NOW()
		WHERE idusuario = _idusuario;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_usuario_modificar
(
	IN _idusuario		INT,
	IN _nombres			VARCHAR(40),
    IN _apellidos		VARCHAR(45),
    IN _rol        		VARCHAR(20),
    IN _email			VARCHAR(60),
	IN _avatar       	VARCHAR(200)
)
BEGIN
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
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_usuarios_obtener;
DELIMITER $$
CREATE PROCEDURE  spu_usuarios_obtener(in _idusuario INT)
BEGIN
	SELECT * FROM usuarios
	WHERE 
		idusuario = _idusuario;
END $$
DELIMITER ;
DROP PROCEDURE IF EXISTS spu_usuarios_obtener;
DELIMITER $$
CREATE PROCEDURE  spu_usuarios_obtener(in _idusuario INT)
BEGIN
	SELECT * FROM usuarios
	WHERE 
		idusuario = _idusuario;
END $$
DELIMITER ;
-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados CATEGORIAS ----------------------------
-- -------------------------------------------------------------------------------------
select * from categorias;

DELIMITER $$
CREATE PROCEDURE spu_listar_categorias()
BEGIN
	SELECT idcategoria, categoria
    FROM categorias
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_categorias_registrar(
	IN _categoria VARCHAR(45)
)
BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END $$
DELIMITER ;

-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados MARCAS -----------------------------
-- -------------------------------------------------------------------------------------
select * from marcas;

DELIMITER $$
CREATE PROCEDURE spu_listar_marca()
BEGIN
	SELECT idmarca, marca
    FROM marcas
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_insertar_marca
(
	IN _marca VARCHAR(45)
)
BEGIN
	INSERT INTO marcas
    (marca)
    VALUES 
    (_marca);
END $$
DELIMITER ;


-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados SECTORES -----------------------------
-- -------------------------------------------------------------------------------------
select * from sectores;

DELIMITER $$
CREATE PROCEDURE spu_listar_sectores()
BEGIN
	SELECT SEC.idsector,
    SEC.nombre,
    EQUI.numero_serie,
    USU.nombres,
    SEC.fecha_inicio,
    SEC.fecha_fin
    FROM sectores SEC
    INNER JOIN equipos EQUI ON EQUI.idequipo = SEC.idequipo
    INNER JOIN usuarios USU ON USU.idusuario = SEC.idusuario
    WHERE SEC.inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_insertar_sectores
(
    IN _idequipo	INT,
    IN _idusuario	INT,
    IN _nombre		VARCHAR(45),
    IN _fecha_inicio DATE,
    IN _fecha_fin	DATE
)
BEGIN
	INSERT INTO sectores
    (idequipo, idusuario, nombre, fecha_inicio, fecha_fin)
    VALUES 
    (_idequipo, _idusuario, _nombre, _fecha_inicio, NULLIF(_fecha_fin, ''));
END $$
DELIMITER ;


-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados EQUIPOS -----------------------------
-- -------------------------------------------------------------------------------------
select * from equipos;
-- VISTA EQUIPOS
DROP VIEW IF EXISTS vws_equipos;
CREATE VIEW vws_equipos
AS
	SELECT EQUI.idequipo,
    CAT.idcategoria,
    CAT.categoria,
    MAR.idmarca,
    MAR.marca,
    EQUI.modelo_equipo,
    EQUI.numero_serie,
    EQUI.imagen,
	USU.nombres
    FROM equipos EQUI
    INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
    INNER JOIN marcas MAR ON MAR.idmarca = EQUI.idmarca
    INNER JOIN usuarios USU ON USU.idusuario = EQUI.idusuario
	WHERE EQUI.inactive_at IS NULL;
    
DELIMITER $$
CREATE PROCEDURE spu_equipos_registrar
(
	IN _idcategoria		INT,
    IN _idmarca			INT,
    IN _idusuario 		INT,
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200)
)
BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, modelo_equipo, numero_serie, imagen)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''));
	SELECT @@last_insert_id 'idequipo';
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS spu_equipos_listar;
DROP PROCEDURE IF EXISTS spu_equipos_listar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_listar()
BEGIN
	SELECT * FROM vws_equipos;
	SELECT * FROM vws_equipos;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_equipos_listar_categoria;
DELIMITER $$
CREATE PROCEDURE spu_equipos_listar_categoria(IN _idcategoria INT)
BEGIN
	IF _idcategoria = 0 THEN
		SELECT * FROM vws_equipos;
	ELSE 
		SELECT * FROM vws_equipos
		WHERE
			idcategoria = _idcategoria;
	END IF;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_equipos_modificar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_modificar
(
	IN _idequipo		INT,
    IN _idcategoria		INT,
    IN _idmarca			INT,
    IN _idusuario 		INT,
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200)
)
BEGIN
	UPDATE equipos SET
		idcategoria 	= _idcategoria,
		idmarca			= _idmarca,
		idusuario		= _idusuario,
		modelo_equipo	= _modelo_equipo,
		numero_serie	= _numero_serie,
		imagen			= _imagen,
        update_at		= now()
	WHERE 
		idequipo = _idequipo;
END $$
DELIMTTER ;

DELIMITER $$
CREATE PROCEDURE spu_equipos_eliminar(IN _idequipo INT)
BEGIN 
	UPDATE equipos
    SET inactive_at = NOW()
		WHERE idequipo = _idequipo;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_equipos_obtener;
DELIMITER $$
CREATE PROCEDURE spu_equipos_obtener(in _idequipo INT)
BEGIN
	SELECT * FROM vws_equipos
	WHERE
		idequipo = _idequipo;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_datasheet_modificar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_modificar
(
	IN _iddatasheet INT,
    IN _idequipo INT,
    IN _clave VARCHAR(45),
    IN _valor VARCHAR(300)
)
BEGIN
	UPDATE datasheet SET
		idequipo 	= _idequipo,
		clave 		= _clave,
		valor		= _valor,
        update_at 	= now()
	WHERE
		iddatasheet = _iddatasheet;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_equipos_modificar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_modificar
(
	IN _idequipo		INT,
    IN _idcategoria		INT,
    IN _idmarca			INT,
    IN _idusuario 		INT,
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200)
)
BEGIN

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
END $$
DELIMTTER ;



-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados DATASHEET -----------------------------
-- -------------------------------------------------------------------------------------
select * from datasheet;
-- VISTA DATASHEET
DROP VIEW IF EXISTS vw_datasheet;
CREATE VIEW vw_datasheet
AS
	SELECT 
    DSH.iddatasheet,
    DSH.idequipo,
-- VISTA DATASHEET
DROP VIEW IF EXISTS vw_datasheet;
CREATE VIEW vw_datasheet
AS
	SELECT 
    DSH.iddatasheet,
    DSH.idequipo,
    EQUI.numero_serie,
    DSH.clave,
    DSH.valor,
    DSH.inactive_at
    DSH.valor,
    DSH.inactive_at
    FROM datasheet DSH
    INNER JOIN equipos EQUI ON EQUI.idequipo = DSH.idequipo
	WHERE DSH.inactive_at IS NULL;
--

DROP PROCEDURE IF EXISTS spu_datasheet_listar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_listar(IN _idequipo INT)
BEGIN
	SELECT * FROM vw_datasheet
    WHERE idequipo = _idequipo
    ORDER BY clave;
	WHERE DSH.inactive_at IS NULL;
--

DROP PROCEDURE IF EXISTS spu_datasheet_listar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_listar(IN _idequipo INT)
BEGIN
	SELECT * FROM vw_datasheet
    WHERE idequipo = _idequipo
    ORDER BY clave;
END$$
DELIMITER ;

CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_datasheet_listar`(IN _idequipo INT)
BEGIN
	SELECT * FROM vw_datasheet
    WHERE idequipo = _idequipo
    ORDER BY clave;
END

DELIMITER $$
CREATE PROCEDURE spu_datasheet_registrar
(
	IN _idequipo INT,
    IN _clave VARCHAR(45),
    IN _valor VARCHAR(300)
)
BEGIN
	INSERT INTO datasheet
    (idequipo, clave, valor)
    VALUES
    (_idequipo, _clave, _valor);
    SELECT @@last_insert_id 'iddatasheet';
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_datasheet_modificar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_modificar
(
	IN _iddatasheet INT,
    IN _idequipo INT,
    IN _clave VARCHAR(45),
    IN _valor VARCHAR(300)
)
BEGIN
	UPDATE datasheet SET
		idequipo 	= _idequipo,
		clave 		= _clave,
		valor		= _valor,
        update_at 	= now()
	WHERE
		iddatasheet = _iddatasheet;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_datasheet_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_eliminar(IN _iddatasheet INT)
BEGIN
	UPDATE datasheet SET
		inactive_at = now()
	WHERE
		iddatasheet = _iddatasheet;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_datasheet_modificar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_modificar
(
	IN _iddatasheet INT,
    IN _idequipo INT,
    IN _clave VARCHAR(45),
    IN _valor VARCHAR(300)
)
BEGIN
	UPDATE datasheet SET
		idequipo 	= _idequipo,
		clave 		= _clave,
		valor		= _valor,
        update_at 	= now()
	WHERE
		iddatasheet = _iddatasheet;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_datasheet_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_eliminar(IN _iddatasheet INT)
BEGIN
	UPDATE datasheet SET
		inactive_at = now()
	WHERE
		iddatasheet = _iddatasheet;
END $$
DELIMITER ;

-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados CRONOGRAMAS --------------------------
-- -------------------------------------------------------------------------------------

DROP PROCEDURE IF EXISTS spu_cronogramas_listar;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_listar()
BEGIN
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
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_cronogramas_registrar;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_registrar
(
	in _idequipo			INT,
    in _tipo_mantenimiento 	VARCHAR(45),
    in _estado				VARCHAR(10),
    in _fecha_programada 	DATETIME
)
BEGIN
	INSERT INTO cronogramas
		(idequipo,tipo_mantenimiento,estado,fecha_programada)
		VALUES
        (_idequipo,_tipo_mantenimiento,_estado,_fecha_programada);
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_cronogramas_modificar;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_modificar
(
	in _idcronograma		INT,
	in _idequipo			INT,
    in _tipo_mantenimiento 	VARCHAR(45),
    in _estado				VARCHAR(10),
    in _fecha_programada 	DATETIME
)
BEGIN
	UPDATE cronogramas SET
		idequipo 			= _idequipo,			
		tipo_mantenimiento 	= _tipo_mantenimiento,
		estado 				= _estado,
		fecha_programada 	=_fecha_programada
	WHERE
		idcronograma = _idcronograma;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_cronograma_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_cronograma_eliminar(in _idcronograma INT)
BEGIN
	UPDATE cronogramas SET
		inactive_at = now();
END $$
DELIMITER ;


/*
DROP PROCEDURE IF EXISTS;
DELIMITER $$
CREATE PROCEDURE()
BEGIN
END $$
DELIMITER ;
*/

-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados MANTENIMIENTO --------------------------
-- -------------------------------------------------------------------------------------
-- FALTA INSERTAR DATOS
DROP PROCEDURE IF EXISTS spu_mantenimiento_listar;
DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_listar()
BEGIN
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
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_listar_mantenimiento_porID(IN _idmantenimiento INT)
BEGIN
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
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_registrar
(
	in _idusuario 	INT,
    in _idcronograma INT,
    in _descripcion  VARCHAR(300)
)
BEGIN
	INSERT INTO mantenimiento 
		(idusuario,idcronograma,descripcion)
        VALUES
        (_idusuario,_idcronograma,_descripcion);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_modificar
(
	in _idmantenmimiento	INT,
    in _idusuario			INT,
    in _idcronograma        INT,
    in _descripcion			VARCHAR(300)
)
BEGIN
	UPDATE mantenimiento SET
		idusuario	 = _idusuario,
		idcronograma =_idcronograma,
		descripcion  =_descripcion		
	WHERE
		idmantenimiento = _idmantenmimiento	;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_mantenimiento_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_eliminar(in _idmantenimiento INT)
BEGIN
	UPDATE mantenimiento SET
		inactive_at = now();
END $$