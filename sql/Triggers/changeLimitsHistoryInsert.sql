DROP TRIGGER IF EXISTS changeLimitsHistoryInsert;

DELIMITER $$ 
CREATE TRIGGER changeLimitsHistoryInsert
AFTER INSERT ON Historial_Laboral
FOR EACH ROW
BEGIN
  UPDATE Usuario
  SET Actualizaciones=Actualizaciones - 1
  WHERE idUsuario = NEW.Usuario_idUsuario;
END $$