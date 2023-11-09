-- ------------------------------------------------------------
-- ---------------- EJECUCIONES -------------------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;
select * from datasheet;
-- 2°: Limpiando las tablas 
DELETE FROM datasheet;
ALTER TABLE datasheet AUTO_INCREMENT 1;

CALL spu_usuarios_login('adriana@gmail.com');
CALL spu_usuarios_registrar
('Adriana', 'Durand Buenamarca', 'Administrador', 'SENATI123', 'adriana@gmail.com', NULL);
CALL spu_categorias_registrar('Computadoras');
CALL spu_listar_categorias;
CALL spu_equipos_registrar(1, 2, 1, 'proyector_00022743719', '2455SKSKK00TYCCOD00SKSUksk', null);
CALL spu_insertar_marca('EPSON');
CALL spu_equipos_listar;
CALL spu_listar_marca; 
CALL spu_insertar_sectores(1, 1, 'Secretaría', '2023-08-23', NULL);
CALL spu_listar_sectores;
CALL spu_datasheet_registrar(1,'Color', 'Blanco');
CALL spu_datasheet_listar;