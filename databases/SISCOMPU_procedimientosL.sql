USE SISCOMPU;

DROP PROCEDURE IF EXISTS spu_cronograma_eliminar;
DELIMITER $$
CREATE PROCEDURE spu_cronograma_eliminar(in _idcronograma INT)
BEGIN
	UPDATE cronogramas SET
		inactive_at = now();
END $$
DELIMITER ;