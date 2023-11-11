

-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados USUARIOS -------------------------------
-- -------------------------------------------------------------------------------------
select * from usuarios;

DELIMITER $$
CREATE PROCEDURE spu_usuarios_login(IN _email VARCHAR(60))
BEGIN
    SELECT
        USU.idusuario,
        USU.apellidos,
        USU.nombres,
        USU.email,
        USU.claveacceso,
        USU.rol
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
	SELECT * FROM usuarios
		WHERE inactive_at IS NULL;
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
	IN _claveacceso     VARCHAR(80),
    IN _email			VARCHAR(60),
	IN _avatar       	VARCHAR(200)
)
BEGIN
	UPDATE usuarios SET
		idusuario	= _idusuario,
		nombres  	= _nombres,
        apellidos 	= _apellidos,
        rol 		= _rol,
        claveacceso = _claveacceso,
        email		= _email,
        avatar 		= _avatar,
        update_at   = now()
	WHERE
		idusuario 	= _idusuario;
	
    SELECT idusuario FROM usuarios 
        WHERE idusuario = _idusuario;
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


DELIMITER $$
CREATE PROCEDURE spu_equipos_listar()
BEGIN
	SELECT EQUI.idequipo,
    CAT.categoria,
    MAR.marca,
    USU.nombres,
    EQUI.modelo_equipo,
    EQUI.numero_serie,
    EQUI.imagen
    FROM equipos EQUI
    INNER JOIN categorias CAT ON CAT.idcategoria = EQUI.idcategoria
    INNER JOIN marcas MAR ON MAR.idmarca = EQUI.idmarca
    INNER JOIN usuarios USU ON USU.idusuario = EQUI.idusuario
    WHERE EQUI.inactive_at IS NULL;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_equipos_eliminar(IN id_equipo INT)
BEGIN 
	UPDATE equipos
    SET inactive_at = NOW()
		WHERE idequipo = _idequipo;
END $$
DELIMITER ;


-- -------------------------------------------------------------------------------------
-- ------------------ Procedimientos Almacenados DATASHEET -----------------------------
-- -------------------------------------------------------------------------------------
select * from datasheet;

DELIMITER $$
CREATE PROCEDURE spu_datasheet_listar()
BEGIN
	SELECT DSH.iddatasheet,
    EQUI.numero_serie,
    DSH.clave,
    DSH.valor
    FROM datasheet DSH
    INNER JOIN equipos EQUI ON EQUI.idequipo = DSH.idequipo
    WHERE DSH.inactive_at IS NULL;
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
	INSERT INTO datasheet
    (idequipo, clave, valor)
    VALUES
    (_idequipo, _clave, _valor);
    SELECT @@last_insert_id 'iddatasheet';
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
CREATE PROCEDURE spu_mantenimiento_registrar
(
	in _idusuario 	INT,
    in _idcronograma INT,
    in _descripcion  VARCHAR(300)
)
BEGIN
	INSERT INTO matenimiento 
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
	UPDATE mantenimiento SET
		idusuario	 = _idusuario,
		idcronograma =_idcronograma,
		descripcion  =_descripcion		
	WHERE
		idmantenimiento = _idmantenmimiento	;
BEGIN
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS spu_mantenimiento_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_mantenimiento_eliminar(in _idmantenimiento INT)
BEGIN
	UPDATE mantenimiento SET
		inactive_at = now();
END $$