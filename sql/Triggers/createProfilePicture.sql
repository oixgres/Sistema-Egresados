DROP TRIGGER IF EXISTS createProfilePicture;

DELIMITER $$

CREATE TRIGGER createProfilePicture
AFTER INSERT ON Usuario
FOR EACH ROW
BEGIN 
    INSERT INTO Foto_Perfil
    (Usuario_idUsuario, Direccion)
    VALUES (NEW.idUsuario, '../img/profile.jpg');
END $$
