truncate table datos_laborales;

INSERT INTO datos_laborales VALUES
							('1', 
							 '1', 
                             '1', 
                             'Desarrollador de firmware', 
                             'Dethlock', 
                             'full stack developer',
                             'Software',
                             'omar.montoya@dethlock.com',
                             'Sistemas',
                             'React.js, Boostrap 4',
                             'Desarrollar software mamalon');

INSERT INTO datos_laborales VALUES
							('2', 
							 '1', 
                             '1', 
                             'Desarrollador de Patas', 
                             'Dethlock', 
                             'full stack developer',
                             'Software',
                             'omar.montoya@dethlock.com',
                             'Sistemas',
                             'React.js, Boostrap 4',
                             'Desarrollar software mamalon');
                             
INSERT INTO datos_laborales VALUES
							('3', 
							 '1', 
                             '1', 
                             'Desarrollador de Hentai', 
                             'Dethlock', 
                             'full stack developer',
                             'Software',
                             'omar.montoya@dethlock.com',
                             'Sistemas',
                             'React.js, Boostrap 4',
                             'Desarrollar software mamalon');
                             
 SELECT * FROM usuario 
 INNER JOIN datos_laborales ON usuario.idUsuario = datos_laborales.Usuario_idUsuario;
 