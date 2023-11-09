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

DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT * FROM usuarios;
END $$

