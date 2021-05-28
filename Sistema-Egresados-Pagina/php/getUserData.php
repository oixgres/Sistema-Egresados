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
$sql = "SELECT  Usuario.Nombres, Usuario.Apellidos, Usuario.Correo, Datos_Escolares.Correo_Inst, 
                Datos_Personales.Telefono, Ciudad.Nombre AS Ciudad, Estado.Nombre AS Estado,
                Datos_Laborales.Empleo, Datos_Laborales.Empresa, Datos_Laborales.Puesto, Datos_Laborales.Departamento
        FROM Usuario
        INNER JOIN Datos_Escolares  ON Usuario.idUsuario = Datos_Escolares.Usuario_idUsuario
        INNER JOIN Datos_Personales ON Usuario.idUsuario = Datos_Personales.Usuario_idUsuario
        INNER JOIN Ciudad           ON Datos_Personales.Ciudad_idCiudad = Ciudad.idCiudad
        INNER JOIN Estado           ON Datos_Personales.Estado_idEstado = Estado.idEstado
        INNER JOIN Datos_Laborales  ON Usuario.idUsuario = Datos_Laborales.Usuario_idUsuario
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
        'ciudad'                => $fila['Ciudad'],
        'estado'                => $fila['Estado'],
        'empleo'                => $fila['Empleo'],
        'empresa'               => $fila['Empresa'],
        'puesto'                => $fila['Puesto'],
        'departamento'          => $fila['Departamento']
    );
    $alcances = array("Universidad", "Campus", "Facultad", "Plan_Estudio");

    // iterar a traves de todos los alcances buscando encuestas
    for($i = 0; $i < 4; $i++) {
        $sql = "SELECT Encuestas_Pendientes.Encuesta_idEncuesta FROM Encuestas_Pendientes
                INNER JOIN Encuesta ON Encuestas_Pendientes.Encuesta_idEncuesta = Encuesta.idEncuesta
                INNER JOIN ${alcances[$i]} ON Encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
                INNER JOIN Datos_Escolares ON ${alcances[$i]}.id${alcances[$i]} = Datos_Escolares.${alcances[$i]}_id${alcances[$i]}
                INNER JOIN Usuario ON Datos_Escolares.Usuario_idUsuario = Usuario.idUsuario
                WHERE Usuario.idUsuario = ${idUsuario}";
        $resPendientes = mysqli_query($conn, $sql);
        $sql = "SELECT  Encuestas_Contestadas.Encuesta_idEncuesta FROM Encuestas_Contestadas
                INNER JOIN Encuesta ON Encuestas_Contestadas.Encuesta_idEncuesta = Encuesta.idEncuesta
                INNER JOIN ${alcances[$i]} ON Encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
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

