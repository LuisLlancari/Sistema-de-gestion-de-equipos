
USE SISCOMPU;
-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados USUARIOS -------------------------------
-- -------------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS spu_usuarios_recuperar;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_recuperar(IN _email VARCHAR(60))
BEGIN
	SELECT * FROM usuarios 
	WHERE 
		email = _email AND
		inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_usuarios_generar_clave;
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

DROP PROCEDURE IF EXISTS spu_usuarios_verificar;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_verificar(IN _idusuario INT)
BEGIN
	SELECT idusuario, codigo FROM usuarios
		WHERE idusuario = _idusuario;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_canbiar_contraseña;
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

DROP PROCEDURE IF EXISTS spu_usuarios_login;
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

DROP PROCEDURE IF EXISTS spu_usuarios_registrar;
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

DROP PROCEDURE IF EXISTS spu_usuarios_listar;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT idusuario, nombres, apellidos, rol, email, avatar FROM usuarios
		WHERE inactive_at IS NULL;
END $$
DELIMITER ;
	
DROP PROCEDURE IF EXISTS spu_usuarios_obtener_id;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_obtener_id(IN _idusuario INT)
BEGIN
	SELECT idusuario, apellidos, nombres, rol, email, avatar FROM usuarios
		WHERE idusuario = _idusuario AND inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_usuarios_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_usuarios_eliminar(IN _idusuario INT)
BEGIN 
	UPDATE usuarios
    SET inactive_at = NOW()
		WHERE idusuario = _idusuario;
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS spu_usuario_modificar;
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

-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados CATEGORIAS ----------------------------
-- -------------------------------------------------------------------------------------


DROP PROCEDURE IF EXISTS spu_listar_categorias;
DELIMITER $$
CREATE PROCEDURE spu_listar_categorias()
BEGIN
	SELECT idcategoria, categoria
    FROM categorias
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_categorias_registrar;
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

DROP PROCEDURE IF EXISTS spu_listar_marca;
DELIMITER $$
CREATE PROCEDURE spu_listar_marca()
BEGIN
	SELECT idmarca, marca
    FROM marcas
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_insertar_marca;
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


DROP PROCEDURE IF EXISTS spu_listar_detalleSectores;
DELIMITER $$
CREATE PROCEDURE spu_listar_detalleSectores(IN _idsector INT)
BEGIN
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
      AND DET.idsector = _idsector;
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS spu_insertar_sector;
DELIMITER $$
CREATE PROCEDURE spu_insertar_sector
(
    IN _idsector	INT,
    IN _sector		VARCHAR(45)
)
BEGIN
	INSERT INTO sectores
    (idsector,sector)
    VALUES 
    (_idsector,_sector);
END $$
DELIMITER ;
/*DROP PROCEDURE IF EXISTS spu_insertar_sectores;
DELIMITER $$
CREATE PROCEDURE spu_insertar_sectores
(
    IN _i	INT,
    IN _idusuario	INT,
    IN _nombre		VARCHAR(45)
)
BEGIN
	INSERT INTO sectores(sector)
    VALUES(_sector);
	SELECT @@last_insert_id 'idsector';
END $$
DELIMITER ;
*/
DROP PROCEDURE IF EXISTS spu_MANsector_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_sector_eliminar(IN _idmantenimiento_sector INT)
BEGIN 
	UPDATE MAN_sectores
    SET inactive_at = NOW()
		WHERE idmantenimiento_sector = _idmantenimiento_sector;
END $$
DELIMITER ;

/*DELIMITER $$
CREATE PROCEDURE spu_obtenerporID(IN id_sector INT)
BEGIN
    SELECT DET.idmantenimiento_sector,
    SEC.sector,
	CAT.categoria,
    MAR.marca,
	EQUI.modelo_equipo,
    EQUI.numero_serie,
    DET.fecha_inicio,
	DET.fecha_fin
    FROM sectores_detalle DET
    INNER JOIN sectores SEC ON SEC.idsector = DET.idsector
	INNER JOIN equipos EQUI ON EQUI.idequipo = DET.idequipo
	INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
    INNER JOIN marcas MAR ON MAR.idmarca = EQUI.idmarca
    WHERE DET.inactive_at IS NULL;
END $$
DELIMITER ;*/

DELIMITER $$
CREATE PROCEDURE spu_obtenerCNsectores()
BEGIN
	-- Selecciona los nombre y los cuenta
    SELECT 
		s.idsector,
        s.sector AS Nombre_Sector,
        COUNT(sd.idsector) AS Cantidad_Guardados
    FROM
        sectores s
	-- Con detalle sectores estoy haciendo el conteo
    LEFT JOIN
        sectores_detalle sd ON s.idsector = sd.idsector
    GROUP BY
        s.idsector;
END $$
DELIMITER ;





-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados EQUIPOS -----------------------------
-- -------------------------------------------------------------------------------------

-- VISTA EQUIPOS
DROP VIEW IF EXISTS vws_equipos;
CREATE VIEW vws_equipos
AS
	SELECT EQUI.idequipo,
    CAT.idcategoria,
    CAT.categoria,
    MAR.idmarca,
    MAR.marca,
    EQUI.descripcion,
    EQUI.modelo_equipo,
    EQUI.numero_serie,
    EQUI.imagen,
    SDE.idsector,
    SEC.sector,
	EQUI.estado,
    /*CASE EQUI.estado
		WHEN '0' THEN 'inactivo'
        WHEN '1' THEN 'activo'
        WHEN '2' THEN 'mantenimiento'
	END AS estado,*/
	USU.nombres
    FROM equipos EQUI
    INNER JOIN sectores_detalle SDE ON SDE.idequipo = EQUI.idequipo
    INNER JOIN sectores AS SEC ON SEC.idsector = SDE.idsector
    INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
    INNER JOIN marcas MAR ON MAR.idmarca = EQUI.idmarca
    INNER JOIN usuarios USU ON USU.idusuario = EQUI.idusuario
	WHERE 
		EQUI.inactive_at IS NULL AND
        SDE.inactive_at IS NULL
	ORDER BY EQUI.numero_serie;
    
DROP PROCEDURE IF EXISTS spu_equipos_registrar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_registrar
(
	IN _idcategoria		INT,
    IN _idmarca			INT,
    IN _idusuario 		INT,
    IN _descripcion		VARCHAR(45),
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200),
    IN _estado			CHAR(1)
)
BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen, estado)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _descripcion, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''), _estado);
	SELECT @@last_insert_id 'idequipo';
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS spu_equipos_listar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_listar()
BEGIN
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


DROP PROCEDURE IF EXISTS spu_equipos_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_equipos_obtener(in _idequipo INT)
BEGIN
	SELECT * FROM vws_equipos
	WHERE
		idequipo = _idequipo;
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
    IN _descripcion		VARCHAR(45),
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200),
    IN _estado			CHAR(1)
)
BEGIN

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
END $$
DELIMITER ;



-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados DATASHEET -----------------------------
-- -------------------------------------------------------------------------------------

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
END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS spu_datasheet_registrar;
DELIMITER $$
CREATE PROCEDURE spu_datasheet_registrar
(
	IN _idequipo INT,
    IN _clave VARCHAR(45),
    IN _valor VARCHAR(300)
)
BEGIN
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

DROP PROCEDURE IF EXISTS spu_cronogramas_listar_id;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_listar_id(IN _idequipo INT)
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
		cro.idequipo =_idequipo AND cro.inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_cronogramas_listar;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_listar_id(IN _idequipo INT)
BEGIN
	SELECT
		equ.idequipo,
		cro.idcronograma,
        equ.modelo_equipo,
        equ.numero_serie,
        cro.tipo_mantenimiento,
        cro.estado,
        cro.fecha_programada
    FROM cronogramas cro
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
    WHERE
		equ.idequipo = _idequipo AND cro.inactive_at IS NULL;
END $$
DELIMITER ;



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
	in _numero_serie		VARCHAR(45),
    in _tipo_mantenimiento 	VARCHAR(45),
    in _estado				VARCHAR(10),
    in _fecha_programada 	DATETIME
)
BEGIN
	SELECT idequipo INTO @equipoid from equipos Where numero_serie = _numero_serie;
	
	INSERT INTO cronogramas
		(idequipo,tipo_mantenimiento,estado,fecha_programada)
		VALUES
        (@equipoid,_tipo_mantenimiento,_estado,_fecha_programada);
        
        SELECT @@last_insert_id 'idcronograma';
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_cronogramas_modificar;
DELIMITER $$
CREATE PROCEDURE spu_cronogramas_modificar
(
	in _idcronograma		INT,
    in _tipo_mantenimiento 	VARCHAR(45),
    in _estado				VARCHAR(10),
    in _fecha_programada 	DATETIME
)
BEGIN
	UPDATE cronogramas SET
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
		inactive_at = now()
			where idcronograma = _idcronograma;
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
        cro.fecha_programada as 'fecha_del_mantenimiento',
        equ.numero_serie,
        cro.tipo_mantenimiento,
        man.descripcion
    FROM mantenimiento as man
    INNER JOIN usuarios as usu on usu.idusuario = man.idusuario
    INNER JOIN cronogramas as cro ON cro.idcronograma = man.idcronograma
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo 
    WHERE
		man.inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_listar_mantenimiento_porID;
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

DROP PROCEDURE IF EXISTS spu_mantenimiento_registrar;
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
        
	SELECT @@last_insert_id 'idmantenimiento';
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_mantenimiento_modificar;
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

-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados SECTORES -----------------------------
-- -------------------------------------------------------------------------------------

DROP PROCEDURE spu_listar_sectores;
DELIMITER $$
CREATE PROCEDURE spu_listar_sectores()
BEGIN
	SELECT idsector, sector
    FROM sectores
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_listar_MANsectores;
DELIMITER $$
CREATE PROCEDURE spu_listar_MANsectores()
BEGIN
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
END $$
DELIMITER ;

-- --------------------------------------------------------------------------------------------------------------------------
-- -----------------------------------------  CONSULTAS ESTADÍSTICAS  -------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------
select * from equipos;
-- ESTADOS DE LOS EQUPOS
DROP PROCEDURE IF EXISTS spu_estadistica_equiposporEstado;
DELIMITER $$
CREATE PROCEDURE spu_estadistica_equiposporEstado()
BEGIN
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
END $$
DELIMITER ;

-- CATEGORIAS POR QUIPO
DROP PROCEDURE IF EXISTS spu_estadistica_equiposCategoria;
DELIMITER $$
CREATE PROCEDURE spu_estadistica_equiposCategoria()
BEGIN
	SELECT COUNT(*) AS 'cantidad',
		CAT.categoria
    FROM equipos AS EQUI
	INNER JOIN categorias AS CAT ON CAT.idcategoria = EQUI.idcategoria
	WHERE
		EQUI.inactive_at IS NULL
	GROUP BY categoria
	ORDER BY categoria;
END $$
DELIMITER ;
