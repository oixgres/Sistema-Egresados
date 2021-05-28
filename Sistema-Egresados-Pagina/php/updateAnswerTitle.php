<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idRespuesta : INT
 *	respuesta   : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idRespuesta o respuesta
 *  -2 : No existe el idPregunta en la base de datos
 *	-3 : Error en la consulta
*/

if(isset($_POST['idRespuesta']) && isset($_POST['respuesta'])) {
    $idRespuesta = $_POST['idRespuesta'];
    $respuesta = $_POST['respuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idRespuesta FROM Respuesta WHERE idRespuesta = ${idRespuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "UPDATE Respuesta SET Respuesta.Respuesta = '${respuesta}' WHERE idRespuesta = ${idRespuesta}";
if(mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();