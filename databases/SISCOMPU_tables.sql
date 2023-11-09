CREATE DATABASE SISCOMPU;
USE SISCOMPU;

DROP TABLE  IF EXISTS usuarios;
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

DROP TABLE IF EXISTS marcas; 
CREATE TABLE marcas(
	idmarca			INT PRIMARY KEY AUTO_INCREMENT,
    marca			VARCHAR(45) 		NOT NULL,
	create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT	uk_marca_marc UNIQUE(marca)
)ENGINE = INNODB;

DROP TABLE IF EXISTS categorias; 
CREATE TABLE categorias
(
	idcategoria 		INT PRIMARY KEY AUTO_INCREMENT,
    categoria			VARCHAR(45) 		NOT NULL,
	create_at		DATE			NOT NULL DEFAULT NOW(),
    update_at		DATE			NULL,
    inactive_at		DATE			NULL,
    CONSTRAINT uk_categoria_cat UNIQUE(categoria)
)ENGINE = INNODB;

DROP TABLE IF EXISTS equipos; 
CREATE TABLE equipos
(
		idequipo			INT PRIMARY KEY AUTO_INCREMENT,
		idcategoria			INT 			NOT NULL,
        idmarca				INT 			NOT NULL,
        idusuario			INT 			NOT NULL,
        modelo_equipo		VARCHAR(45) 	NOT NULL,
        numero_serie 		VARCHAR(200) 	NOT NULL,
        imagen				VARCHAR(200)	NULL,
		create_at		DATE			NOT NULL DEFAULT NOW(),
		update_at		DATE			NULL,
		inactive_at		DATE			NULL,
        CONSTRAINT fk_idcategoria_prd	FOREIGN KEY(idcategoria) REFERENCES categorias(idcategoria),
        CONSTRAINT fk_idmarca_prd 		FOREIGN KEY(idmarca) 	 REFERENCES marcas(idmarca),
        CONSTRAINT fk_idusuario_prd 	FOREIGN KEY(idusuario) 	 REFERENCES usuarios(idusuario),
		CONSTRAINT	uk_numeroserie_prd UNIQUE(numero_serie)
) ENGINE = INNODB;

DROP TABLE IF EXISTS datasheet;
CREATE TABLE datasheet
(
	iddatasheet			INT PRIMARY KEY AUTO_INCREMENT,
	idequipo 			INT 		NOT NULL,
    clave		 		VARCHAR(45) NOT NULL,
    valor				VARCHAR(300) NOT  NULL,
	create_at			DATE			NOT NULL DEFAULT NOW(),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
    CONSTRAINT fk_idequipo_dat 	FOREIGN KEY(idequipo)  REFERENCES equipos(idequipo),
    CONSTRAINT uk_idequipoclave UNIQUE	(idequipo,clave)
)ENGINE = INNODB;

DROP TABLE IF EXISTS sectores;
CREATE TABLE sectores
(
	idsector			INT PRIMARY KEY AUTO_INCREMENT,
    idequipo			INT 	NOT NULL,
    idusuario			INT		NOT NULL,
    nombre				VARCHAR(45) 	NOT NULL,
    fecha_inicio		DATE			NOT NULL,
    fecha_fin			DATE 			NULL,
	create_at			DATE			NOT NULL DEFAULT NOW(),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
	CONSTRAINT fk_idequipo_sect 	FOREIGN KEY(idequipo)  REFERENCES equipos(idequipo),
	CONSTRAINT fk_idusuario_sect FOREIGN KEY(idusuario) REFERENCES usuarios(idusuario)
)ENGINE = INNODB;

DROP TABLE IF EXISTS cronogramas;
CREATE TABLE cronogramas
(
	idcronograma		INT PRIMARY KEY AUTO_INCREMENT,
    idequipo			INT 	NOT NULL,
    tipo_matenimiento	VARCHAR(45) 	NOT NULL,
    estado				VARCHAR(10) 	NOT NULL,
    fecha_programada	DATETIME		NOT NULL,
	create_at			DATE			NOT NULL DEFAULT NOW(),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
    CONSTRAINT 	fk_idequipo_cro FOREIGN KEY(idequipo) REFERENCES equipos(idequipo)
)ENGINE = INNODB;

DROP TABLE IF EXISTS matenimiento;
CREATE TABLE matenimiento
(
	idmantenimiento 		INT PRIMARY KEY AUTO_INCREMENT,
	idusuario				INT		NOT NULL,
    idcronograma	 	  	INT 	NOT NULL,
    descripcion	 			VARCHAR(300) 	NOT NULL,
	create_at			DATE			NOT NULL DEFAULT NOW(),
	update_at			DATE			NULL,
	inactive_at			DATE			NULL,
	CONSTRAINT fk_idusuario_man FOREIGN KEY(idusuario) REFERENCES usuarios(idusuario),
	CONSTRAINT fk_idcronograma_man FOREIGN KEY(idcronograma) REFERENCES cronogramas(idcronograma),
    CONSTRAINT uk_idcronogram_man UNIQUE(idusuario,idcronograma)
)ENGINE = INNODB;


/*
DROP TABLE IF EXISTS ;
CREATE TABLE ()ENGINE = INNODB;
*/
