<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 *
 * Devuelve:
 * 	Los registros laborales registrados del usuario:
 *
 *  (JSON)
 *      idHistorial             : INT
 *	    empleo                  : VARCHAR(45)
 *	    empresa                 : VARCHAR(45)
 *	    puesto                  : VARCHAR(45)
 *	    categoria               : VARCHAR(45)
 *	    correo                  : VARCHAR(45)
 *	    departamento            : VARCHAR(45)
 *	    actividades             : VARCHAR(45)
 *	    fechaInicio             : DATE
 *	    fechaFinal              : DATE
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe usuario
 *  -3 : No existen registros de historial
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

// consulta para obtener historial laboral
$sql = "SELECT idHistorial_Laboral, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades, Inicio, Fin
        FROM historial_laboral
        INNER JOIN usuario on historial_laboral.Usuario_idUsuario = usuario.idUsuario
        WHERE idUsuario = ${idUsuario}";
$res = mysqli_query($conn, $sql);

if (gettype($res) != "boolean" && $res->num_rows != 0) {       // si existen registros de historial
    $json = array();

    while($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'idHistorial' => $fila['idHistorial_Laboral'],
            'empleo' => $fila['Empleo'],
            'empresa' => $fila['Empresa'],
            'puesto' => $fila['Puesto'],
            'categoria' => $fila['Categoria'],
            'correo' => $fila['Correo_Emp'],
            'departamento' => $fila['Departamento'],
            'tecnologias' => $fila['Tecnologias'],
            'actividades' => $fila['Actividades'],
            'fechaInicio' => $fila['Inicio'],
            'fechaFinal' => $fila['Fin']
        );
    }

    $jsonString = json_encode($json);    //convertir el json a cadena
    echo $jsonString;                    //retornar el json al frontend
} else {
    echo -3;            // no existe historial
}

$conn->close();