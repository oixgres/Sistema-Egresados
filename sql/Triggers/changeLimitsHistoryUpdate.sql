DROP TRIGGER IF EXISTS changeLimitsHistoryUpdate;

DELIMITER $$ 
CREATE TRIGGER changeLimitsHistoryUpdate
AFTER UPDATE ON Historial_Laboral
FOR EACH ROW
BEGIN
  UPDATE Usuario
  SET Actualizaciones=Actualizaciones - 1
  WHERE idUsuario = NEW.Usuario_idUsuario;
END$$

