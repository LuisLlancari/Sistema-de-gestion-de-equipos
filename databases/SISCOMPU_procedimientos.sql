
USE SISCOMPU;
-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados USUARIOS -------------------------------
-- -------------------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_usuarios_recuperar(IN _email VARCHAR(60))
BEGIN
	SELECT * FROM usuarios 
	WHERE 
		email = _email AND
		inactive_at IS NULL;
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
   SELECT idusuario FROM usuarios WHERE idusuario = _idusuario;
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
DELIMITER $$
CREATE PROCEDURE spu_listar_detalleSectores(IN _idsector INT)
BEGIN
    SELECT DET.idmantenimiento_sector,
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

DELIMITER $$
CREATE PROCEDURE spu_insertar_sector
(
    IN _sector		VARCHAR(45)
)
BEGIN
	INSERT INTO sectores
    (sector)
    VALUES 
    (_sector);
	SELECT @@last_insert_id 'idsector';
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_activarSector(IN _idsector INT, IN _activar INT)
BEGIN
    IF _activar = 1 THEN
        -- Activar el sector
        UPDATE sectores
        SET inactive_at = NULL
        WHERE idsector = _idsector;
    ELSE
        -- Desactivar el sector
        UPDATE sectores
        SET inactive_at = NOW()
        WHERE idsector = _idsector;
    END IF;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_obtenerCNsectores()
BEGIN
    SELECT 
        s.idsector,
        s.sector AS Nombre_Sector,
        COUNT(sd.idsector) AS Cantidad_Guardados
    FROM
        sectores s
    LEFT JOIN
        sectores_detalle sd ON s.idsector = sd.idsector AND sd.fecha_fin IS NULL AND sd.inactive_at IS NULL
    WHERE 
        s.inactive_at IS NULL
    GROUP BY
        s.idsector;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_equipos_registrar_sector
(
	IN _idcategoria		INT,
    IN _idmarca			INT,
    IN _idusuario 		INT,
    IN _descripcion		VARCHAR(45),
    IN _modelo_equipo 	VARCHAR(45),
    IN _numero_serie	VARCHAR(45),
    IN _imagen			VARCHAR(200),
    IN _idsector       	INT
)
BEGIN
	INSERT INTO equipos
    (idcategoria, idmarca, idusuario, descripcion, modelo_equipo, numero_serie, imagen)
    VALUES
    (_idcategoria, _idmarca, _idusuario, _descripcion, _modelo_equipo, _numero_serie, NULLIF(_imagen, ''));
    
	SELECT @@last_insert_id 'idequipo' INTO @equipoid;
    
    INSERT INTO sectores_detalle(idsector, idequipo, idusuario)
	VALUES(_idsector, @equipoid, _idusuario);
    
	SELECT @@last_insert_id 'idmantenimiento_sector';
    
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_mover_equipo(
IN _idmantenimiento_sector INT,
IN _idsector 		INT,
IN _idusuario       INT
)
BEGIN
	SELECT idequipo INTO @equipoid from sectores_detalle 
	where idmantenimiento_sector = _idmantenimiento_sector;
    
	INSERT INTO sectores_detalle(idsector,idequipo,idusuario)
	VALUES (_idsector ,@equipoid,_idusuario);
    
	UPDATE sectores_detalle 
	SET inactive_at = now(),
		fecha_fin = now()
        Where idmantenimiento_sector = _idmantenimiento_sector;
	
	SELECT @@last_insert_id 'idmantenimiento_sector';
END $$
DELIMITER ;

-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados EQUIPOS -----------------------------
-- -------------------------------------------------------------------------------------

-- VISTA EQUIPOS
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

DELIMITER $$
CREATE PROCEDURE spu_equipos_listar()
BEGIN
	SELECT * FROM vws_equipos;
END $$
DELIMITER ;

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

DELIMITER $$
CREATE PROCEDURE spu_equipos_obtener(in _idequipo INT)
BEGIN
	SELECT * FROM vws_equipos
	WHERE
		idequipo = _idequipo;
END $$
DELIMITER ;

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

DELIMITER $$
CREATE PROCEDURE spu_datasheet_listar(IN _idequipo INT)
BEGIN
	SELECT * FROM vw_datasheet
    WHERE idequipo = _idequipo
    ORDER BY clave;
END$$
DELIMITER ;

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
		cro.idequipo =_idequipo AND cro.inactive_at IS NULL
	LIMIT 1;
END $$
DELIMITER ;

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
        cro.fecha_programada,
        man.descripcion
    FROM cronogramas as cro
    INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
	left JOIN mantenimiento as man on man.idcronograma=cro.idcronograma

    WHERE
		cro.inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_cronogramas_registrar
(
	in _numero_serie		VARCHAR(45),
    in _tipo_mantenimiento 	VARCHAR(45),
    in _fecha_programada 	DATETIME
)
BEGIN
	SELECT idequipo INTO @equipoid from equipos Where numero_serie = _numero_serie;
	
	INSERT INTO cronogramas
		(idequipo,tipo_mantenimiento,fecha_programada)
		VALUES
        (@equipoid,_tipo_mantenimiento,_fecha_programada);
        
        SELECT @@last_insert_id 'idcronograma';
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_cronogramas_modificar
(
	in _idcronograma		INT,
    in _tipo_mantenimiento 	VARCHAR(45),
    in _estado				VARCHAR(10),
    in _fecha_programada 	DATETIME,
	in _comentario			VARCHAR(300),
    in _idusuario 			INT
)
BEGIN
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
        
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_cronograma_eliminar(in _idcronograma INT)
BEGIN
	UPDATE cronogramas SET
		inactive_at = now()
			where idcronograma = _idcronograma;
END $$
DELIMITER ;
-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados MANTENIMIENTO --------------------------
-- -------------------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_listar_informe()
BEGIN
		SELECT
			man.idmantenimiento,
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
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_listar(
in _idmarca INT,
in _idcategoria INT,
in _fechainicio VARCHAR(20),
in _fechafin VARCHAR(20)
)
BEGIN
		SELECT
			man.idmantenimiento,
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
    (_idmarca =0 || mar.idmarca=_idmarca) AND
    (_idcategoria =0 || cat.idcategoria=_idcategoria)AND
    (cro.fecha_programada BETWEEN IF(_fechainicio = '', '1000-01-01', _fechainicio) AND IF(_fechafin = '', '9999-12-31', _fechafin)) AND
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
        
	SELECT @@last_insert_id 'idmantenimiento';
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_modificar
(
	in _idmantenimiento	INT,
    in _descripcion			VARCHAR(300)
)
BEGIN
	UPDATE mantenimiento SET
		descripcion  =_descripcion		
	WHERE
		idmantenimiento = _idmantenimiento	;
        
	select idmantenimiento where idmantenimiento = _idmantenimiento;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_eliminar(in _idmantenimiento INT)
BEGIN
	UPDATE mantenimiento SET
		inactive_at = now();
END $$

-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados SECTORES -----------------------------
-- -------------------------------------------------------------------------------------

DELIMITER $$
CREATE PROCEDURE spu_listar_sectores()
BEGIN
	SELECT idsector, sector
    FROM sectores
    WHERE inactive_at IS NULL;
END $$
DELIMITER ;

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

-- GRAFICOS
DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_grafico
(
    in _fecha_inicio 	date,
	in _fecha_fin 	date
)
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_cronograma_grafico
(
    in _fecha_inicio 	date,
	in _fecha_fin 	date
)
BEGIN
	 
SELECT
count(1) as 'cantidad_tipo',
cro.estado
FROM cronogramas as cro
INNER JOIN equipos as equ on equ.idequipo = cro.idequipo
left JOIN mantenimiento as man on man.idcronograma=cro.idcronograma
WHERE cro.inactive_at IS NULL and cro.estado!=''
AND cro.create_at between _fecha_inicio and _fecha_fin
group by cro.estado;
     
END $$
DELIMITER ;

-- --------------------------------------------------------------------------------------------------------------------------
-- -----------------------------------------  CONSULTAS ESTADÍSTICAS  -------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------
-- ESTADOS DE LOS EQUPOS
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

-- CATEGORIAS POR EQUIPO
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

-- EQUIPOS POR SECTORES
DELIMITER $$
CREATE PROCEDURE spu_estadistica_equiposSector()
BEGIN
	SELECT COUNT(*) AS 'equipos',
		SEC.sector
    FROM sectores_detalle AS SED
    INNER JOIN sectores AS SEC ON SEC.idsector = SED.idsector
    WHERE
		SED.inactive_at IS NULL
	GROUP BY SEC.sector
	ORDER BY SEC.sector; 
END $$
DELIMITER ;
