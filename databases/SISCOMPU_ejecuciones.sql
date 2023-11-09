-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;

CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_usuarios_registrar('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL)
