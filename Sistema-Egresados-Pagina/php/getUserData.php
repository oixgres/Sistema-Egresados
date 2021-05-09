<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 *
 * Devuelve:
 * 	Los siguientes datos de usuario:
 *
 *  (JSON)
 *	nombres                 : VARCHAR(45)
 *	apellidos               : VARCHAR(45)
 *	correo                  : VARCHAR(45)
 *	correo_institucional    : VARCHAR(45)
 *	telefono                : VARCHAR(45)
 *	ciudad                  : VARCHAR(45)
 *	estado                  : VARCHAR(45)
 *	empleo                  : VARCHAR(45)
 *	empresa                 : VARCHAR(45)
 *	puesto                  : VARCHAR(45)
 *	departamento            : VARCHAR(45)
 *	encuestasPendientes     : VARCHAR(45)
 *	encuestasContestadas    : VARCHAR(45)
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe pregunta o usuario
 *  -3 : Error en consulta de datos de usuario
*/

if (!isset($_POST['idUsuario'])){
    echo -1;
    $conn->close();
    exit();
}

$idUsuario = $_POST['idUsuario'];
$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";  // confirmar que existe idUsuario
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

// sql para obtener datos basicos del usuario
$sql = "SELECT  Usuario.Nombres, Usuario.Apellidos, Usuario.Correo, datos_escolares.Correo_Inst, 
                datos_personales.Telefono, ciudad.Nombre AS ciudad, estado.Nombre AS estado,
                datos_laborales.Empleo, datos_laborales.Empresa, datos_laborales.Puesto, datos_laborales.Departamento
        FROM Usuario
        INNER JOIN datos_escolares  ON usuario.idUsuario = datos_escolares.Usuario_idUsuario
        INNER JOIN datos_personales ON usuario.idUsuario = datos_personales.Usuario_idUsuario
        INNER JOIN ciudad           ON datos_personales.Ciudad_idCiudad = ciudad.idCiudad
        INNER JOIN estado           ON datos_personales.Estado_idEstado = estado.idEstado
        INNER JOIN datos_laborales  ON usuario.idUsuario = datos_laborales.Usuario_idUsuario
        WHERE idUsuario = ${idUsuario}";

$resDatos = mysqli_query($conn, $sql);
if (gettype($resDatos) != "boolean") {
    $fila = mysqli_fetch_array($resDatos);
    $json = array(                                  // almacenar datos de usuaro en json
        'nombres'               => $fila['Nombres'],
        'apellidos'             => $fila['Apellidos'],
        'correo'                => $fila['Correo'],
        'correo_institucional'  => $fila['Correo_Inst'],
        'telefono'              => $fila['Telefono'],
        'ciudad'                => $fila['ciudad'],
        'estado'                => $fila['estado'],
        'empleo'                => $fila['Empleo'],
        'empresa'               => $fila['Empresa'],
        'puesto'                => $fila['Puesto'],
        'departamento'          => $fila['Departamento']
    );
    $alcances = array("Universidad", "Campus", "Facultad", "Plan_Estudio");

    // iterar a traves de todos los alcances buscando encuestas
    for($i = 0; $i < 4; $i++) {
        $sql = "SELECT encuestas_pendientes.Encuesta_idEncuesta FROM encuestas_pendientes
                INNER JOIN encuesta ON encuestas_pendientes.Encuesta_idEncuesta = encuesta.idEncuesta
                INNER JOIN ${alcances[$i]} ON encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
                INNER JOIN Datos_Escolares ON ${alcances[$i]}.id${alcances[$i]} = Datos_Escolares.${alcances[$i]}_id${alcances[$i]}
                INNER JOIN Usuario ON Datos_Escolares.Usuario_idUsuario = Usuario.idUsuario
                WHERE Usuario.idUsuario = ${idUsuario}";
        $resPendientes = mysqli_query($conn, $sql);
        $sql = "SELECT  encuestas_contestadas.Encuesta_idEncuesta FROM encuestas_contestadas
                INNER JOIN encuesta ON encuestas_contestadas.Encuesta_idEncuesta = encuesta.idEncuesta
                INNER JOIN ${alcances[$i]} ON encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
                INNER JOIN Datos_Escolares ON ${alcances[$i]}.id${alcances[$i]} = Datos_Escolares.${alcances[$i]}_id${alcances[$i]}
                INNER JOIN Usuario ON Datos_Escolares.Usuario_idUsuario = Usuario.idUsuario
                WHERE Usuario.idUsuario = ${idUsuario}";
        $resContestadas = mysqli_query($conn, $sql);

        if(gettype($resPendientes) != "boolean") {              // si se encuentran encuestas pendientes, agregar
            while ($fila = mysqli_fetch_array($resPendientes)) {
                $json['encuestasPendientes']  [] = $fila['Encuesta_idEncuesta'];
            }
        }
        if (gettype($resContestadas) != "boolean") {            // si se encuentran encuestas contestadas, agregar
            while ($fila = mysqli_fetch_array($resContestadas)) {
                $json['encuestasContestadas']  [] = $fila['Encuesta_idEncuesta'];
            }
        }
    }

    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -3;
}

$conn->close();

