DROP EVENT IF EXISTS monthlyUpdate;

DELIMITER $$

CREATE EVENT IF NOT EXISTS monthlyUpdate
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN 
  UPDATE Usuario
  SET Actualizaciones=3
  WHERE Actualizaciones < 3;
END $$