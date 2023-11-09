-- -------------------------------------------------------------------------------------
-- ---------------- Procedimientos Alamacenados USUARIOS -------------------------------
-- -------------------------------------------------------------------------------------
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

DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar
(
	IN _nombres	VARCHAR(40),
    IN _apellidos	VARCHAR(45),
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

/*DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT * FROM usuarios;
END $$*/

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

DROP PROCEDURE IF EXISTS spu_mantenimiento_registrar;
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

DROP PROCEDURE IF EXISTS spu_mantenimiento_modificar;
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

