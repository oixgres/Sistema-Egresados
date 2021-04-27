<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta : INT
 *	nombre : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta o nombre
 *  -2 : No existe el idEncuesta en la base de datos
 *	-3 : Error en la consulta
*/

if(isset($_POST['idEncuesta']) && isset($_POST['nombre'])) {
    $idEncuesta = $_POST['idEncuesta'];
    $nombre = $_POST['nombre'];
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

$sql = "UPDATE Encuesta SET Nombre = '$nombre' WHERE idEncuesta = $idEncuesta";
if(mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();