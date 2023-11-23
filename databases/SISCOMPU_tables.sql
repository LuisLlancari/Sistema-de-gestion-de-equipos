CREATE DATABASE SISCOMPU;
USE SISCOMPU;

CREATE TABLE usuarios(
	idusuario 		INT PRIMARY KEY AUTO_INCREMENT,
    nombres			VARCHAR(40) 	NOT NULL,
    apellidos		VARCHAR(45) 	NOT NULL,
    rol				VARCHAR(20)		NOT NULL,
	claveacceso		VARCHAR(60) 	NOT NULL,
	email			VARCHAR(60)		NOT NULL,
    avatar			VARCHAR(200)	NULL,
    codigo			CHAR(6)			NULL,
    create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT uk_email_usu UNIQUE(email)
)ENGINE = INNODB;

CREATE TABLE marcas(
	idmarca			INT PRIMARY KEY AUTO_INCREMENT,
    marca			VARCHAR(45) 		NOT NULL,
	create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT	uk_marca_marc UNIQUE(marca)
)ENGINE = INNODB;

CREATE TABLE categorias
(
	idcategoria 		INT PRIMARY KEY AUTO_INCREMENT,
    categoria			VARCHAR(45) 		NOT NULL,
	create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT uk_categoria_cat UNIQUE(categoria)
)ENGINE = INNODB;

CREATE TABLE equipos
(
		idequipo			INT PRIMARY KEY AUTO_INCREMENT,
		idcategoria			INT 			NOT NULL,
        idmarca				INT 			NOT NULL,
        idusuario			INT 			NOT NULL,
		descripcion			VARCHAR(45)		NOT NULL,
        modelo_equipo		VARCHAR(45) 	NOT NULL,
        numero_serie 		VARCHAR(45) 	NOT NULL,
        imagen				VARCHAR(200)	NULL,
        estado				CHAR(1)			NOT NULL DEFAULT '1',
		create_at			DATE			NOT NULL DEFAULT (NOW()),
		update_at			DATE			NULL,
		inactive_at			DATE			NULL,
        CONSTRAINT fk_idcategoria_prd	FOREIGN KEY(idcategoria) REFERENCES categorias(idcategoria),
        CONSTRAINT fk_idmarca_prd 		FOREIGN KEY(idmarca) 	 REFERENCES marcas(idmarca),
        CONSTRAINT fk_idusuario_prd 	FOREIGN KEY(idusuario) 	 REFERENCES usuarios(idusuario),
		CONSTRAINT	uk_numeroserie_prd UNIQUE(numero_serie)
) ENGINE = INNODB;

CREATE TABLE datasheet
(
	iddatasheet			INT PRIMARY KEY AUTO_INCREMENT,
	idequipo 			INT 		NOT NULL,
    clave		 		VARCHAR(45) NOT NULL,
    valor				VARCHAR(300) NOT  NULL,
	create_at			DATE			NOT NULL DEFAULT (NOW()),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
    CONSTRAINT fk_idequipo_dat 	FOREIGN KEY(idequipo)  REFERENCES equipos(idequipo),
    CONSTRAINT uk_idequipoclave UNIQUE	(idequipo,clave)
)ENGINE = INNODB;

CREATE TABLE sectores
(
	idsector			INT PRIMARY KEY AUTO_INCREMENT,
	sector				VARCHAR(45)		NOT NULL,
	create_at			DATE			NOT NULL DEFAULT (NOW()),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL
)ENGINE = INNODB;

CREATE TABLE sectores_detalle
(
	idmantenimiento_sector				INT PRIMARY KEY AUTO_INCREMENT,
    idsector						INT 	NOT NULL,
    idequipo						INT 	NOT NULL,
    idusuario						INT		NOT NULL,
    fecha_inicio					DATE	NOT NULL DEFAULT NOW(),
    fecha_fin						DATE 	NULL,
	create_at						DATE	NOT NULL DEFAULT (NOW()),
	update_at						DATE	NULL,
	inactive_at						DATE	NULL,
	CONSTRAINT fk_idsector_sect FOREIGN KEY(idsector)  REFERENCES sectores(idsector),
	CONSTRAINT fk_idequipo_sect FOREIGN KEY(idequipo)  REFERENCES equipos(idequipo),
	CONSTRAINT fk_idusuario_sect FOREIGN KEY(idusuario) REFERENCES usuarios(idusuario)
)ENGINE = INNODB;

CREATE TABLE cronogramas
(
	idcronograma		INT PRIMARY KEY AUTO_INCREMENT,
    idequipo			INT 	NOT NULL,
    tipo_mantenimiento	VARCHAR(45) 	NOT NULL,
    estado				VARCHAR(10) 	NOT NULL DEFAULT 'pendiente',
    fecha_programada	DATETIME		NOT NULL,
	create_at			DATE			NOT NULL DEFAULT (NOW()),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
    CONSTRAINT 	fk_idequipo_cro FOREIGN KEY(idequipo) REFERENCES equipos(idequipo)
)ENGINE = INNODB;

CREATE TABLE mantenimiento
(
	idmantenimiento 		INT PRIMARY KEY AUTO_INCREMENT,
	idusuario				INT		NOT NULL,
    idcronograma	 	  	INT 	NOT NULL,
    descripcion	 			VARCHAR(300) 	NOT NULL,
	create_at			DATE			NOT NULL DEFAULT (NOW()),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
	CONSTRAINT fk_idusuario_man FOREIGN KEY(idusuario) REFERENCES usuarios(idusuario),
	CONSTRAINT fk_idcronograma_man FOREIGN KEY(idcronograma) REFERENCES cronogramas(idcronograma),
    CONSTRAINT uk_idcronogram_man UNIQUE(idusuario,idcronograma)
)ENGINE = INNODB;

/*DROP TABLE IF EXISTS sectores;
CREATE TABLE sectores
(
	idsector			INT PRIMARY KEY AUTO_INCREMENT,
     sector				VARCHAR(45)		NOT NULL,
	create_at			DATE			NOT NULL DEFAULT (NOW()),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL
)ENGINE = INNODB;

DROP TABLE IF EXISTS sectores_detalle;
CREATE TABLE sectores_detalle
(
	idmantenimiento_sector			INT PRIMARY KEY AUTO_INCREMENT,
    idsector						INT 	NOT NULL,
    idequipo						INT 	NOT NULL,
    idusuario						INT		NOT NULL,
    fecha_inicio					DATE	NOT NULL DEFAULT (NOW()),
    fecha_fin						DATE 	NULL,
	create_at						DATE	NOT NULL DEFAULT (NOW()),
	update_at						DATE	NULL,
	inactive_at						DATE	NULL,
	CONSTRAINT fk_idsector_sect 	FOREIGN KEY(idsector)  REFERENCES sectores(idsector),
	CONSTRAINT fk_idequipo_sect 	FOREIGN KEY(idequipo)  REFERENCES equipos(idequipo),
	CONSTRAINT fk_idusuario_sect FOREIGN KEY(idusuario) REFERENCES usuarios(idusuario)
)ENGINE = INNODB;
*/

/*
DROP TABLE IF EXISTS ;
CREATE TABLE ()ENGINE = INNODB;
*/
