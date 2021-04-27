<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta
 *  -2 : No existe el idEncuesta en la base de datos
 *	-3 : Error en la consulta
*/

if(isset($_POST['idEncuesta'])) {
    $idEncuesta = $_POST['idEncuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idEncuesta FROM Encuesta WHERE idEncuesta = '$idEncuesta'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "DELETE FROM Encuesta WHERE idEncuesta = '$idEncuesta'";
if(mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();