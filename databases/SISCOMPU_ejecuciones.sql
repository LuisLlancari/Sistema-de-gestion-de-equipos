-- ------------------------------------------------------------
-- ---------------- EJECUCIONES -------------------------------
-- ------------------------------------------------------------
USE SISCOMPU;
select * from usuarios;
CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_usuarios_registrar('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL);
CALL spu_mantenimiento_listar();
CALL spu_mantenimiento_registrar();
CALL spu_mantenimiento_modificar();
CALL spu_mantenimiento_eliminar();

update usuarios set claveacceso = '$2y$10$zziCmhmflAJcT8r3MhgJA.wtjgk.VMfK5UCoPBdW109cvhtfcS5rm' where idusuario = 1;