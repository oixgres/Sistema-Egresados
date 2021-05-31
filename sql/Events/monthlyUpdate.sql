CREATE EVENT IF NOT EXISTS monthlyUpdate
ON SCHEDULE EVERY 1 MONTH
DO BEGIN 
  SELECT Actualizaciones
  FROM Usuario
  WHERE Actualizaciones < 3