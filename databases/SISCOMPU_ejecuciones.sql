-- ------------------------------------------------------------
-- ------------ EJECUCIONES DE CONSULTA -----------------------
-- ------------------------------------------------------------
-- 1°: Uso DB
USE SISCOMPU;
select * from equipos;
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

-- ------------------------------------------------------------
-- ----------------- INSERCIÓN DE DATOS -----------------------
-- ------------------------------------------------------------
INSERT INTO usuarios(nombres, apellidos, rol, claveacceso, email) VALUES
('Lucas', 'Atuncar Valerio', 'Administrador', '123', 'lucas@gmail.com'),
('Luis', 'Llancari Vicerrel', 'Administrador', '234', 'luis@gmail.com'),
('Jhovana', 'Andrade Córdova', 'Invitado', '567', 'jhovana@gmail.com'),
('Sofia', 'Valdez Galvez', 'Invitado', '000', 'sofia@gmail.com');

INSERT INTO marcas(marca) VALUES
	('Lenovo'),
    ('HP'),
    ('Samsung');
    
INSERT INTO categorias(categoria)VALUES
	('Laptops'),
    ('Monitores'),
    ('Mouse'),
    ('Teclados');

INSERT INTO equipos(idcategoria, idmarca, idusuario, modelo_equipo, numero_serie)VALUES
	(1, 3, 3, 'ModeloJJSAJE84Y4', 'J_394_EHDYU7jus777'),
    (3, 1, 3, 'ModeloSUS7799', 'DAJDJWE_088789432'),
    (1, 3, 6, 'ModeloP99S9S', 'SIDU4944_0000333'),
    (2, 2, 4, 'Modelopspslso99', 'JSHEJ_283_383_9333');

