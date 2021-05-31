<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta    : INT
 *
 * Devuelve numero de usuarios:
 *
 *  (JSON)
 *   total      : asignados a la encuesta
 *	 contestado : que ya contestaron la encuesta
 *   pendiente  : que faltan de contestar la encuesta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta
 *  -2 : No existe el idEncuesta en la base de datos
 *  -3 : Error en consulta
*/

if(isset($_POST['idEncuesta'])) {
    $idEncuesta = $_POST['idEncuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idEncuesta FROM Encuesta WHERE idEncuesta = ${idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT COUNT(Encuestas_Pendientes.Usuario_idUsuario) AS pendiente
        FROM Encuestas_Pendientes
        WHERE Encuestas_Pendientes.Encuesta_idEncuesta = ${idEncuesta}
        GROUP BY Encuestas_Pendientes.Encuesta_idEncuesta";


$res = mysqli_query($conn, $sql);
$pendiente = mysqli_fetch_array($res)['pendiente'];

$sql = "SELECT COUNT(Encuestas_Contestadas.Usuario_idUsuario) AS contestado
        FROM Encuestas_Contestadas
        WHERE Encuestas_Contestadas.Encuesta_idEncuesta = ${idEncuesta}
        GROUP BY Encuestas_Contestadas.Encuesta_idEncuesta";
$res = mysqli_query($conn, $sql);
$contestado = mysqli_fetch_array($res)['contestado'];

$json = array('total' => $pendiente+$contestado,
              'contestado' => $contestado,
              'pendiente' => $pendiente);
/*
 *	JSON Ejemplo:
 *	   string(44) "{"total":9,"contestado":"2","pendiente":"7"}"
*/

if(!empty($json)) {
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 			    //retornar el json al frontend
} else {
    echo -3;
}
$conn->close();