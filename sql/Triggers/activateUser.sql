DELIMITER !!
CREATE TRIGGER activateUser
BEFORE DELETE ON Claves_Confirmacion
FOR EACH ROW
BEGIN
  UPDATE Usuario
  SET Estatus='ACTIVO'
  WHERE idUsuario=OLD.Usuario_idUsuario;
END;!!
