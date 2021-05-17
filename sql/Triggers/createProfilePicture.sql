-- DELIMITER !!
-- CREATE TRIGGER activateUser
-- BEFORE DELETE ON Claves_Confirmacion
-- FOR EACH ROW
-- BEGIN
--   UPDATE Usuario
--   SET Estatus='ACTIVO'
--   WHERE idUsuario=OLD.Usuario_idUsuario;
-- END;!!

DELIMITER !!
CREATE TRIGGER createProfilePicture
AFTER INSERT ON Usuario
FOR EACH ROW
BEGIN 
    INSERT INTO Foto_Perfil
    (Usuario_idUsuario)
    VALUES (NEW.idUsuario);
END;!!

