
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
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT * FROM usuarios;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_usuarios_eliminar(IN id_usuario INT)
BEGIN 
	UPDATE usuarios
    SET inactive_at = NOW()
		WHERE idusurio = _idusuario;
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