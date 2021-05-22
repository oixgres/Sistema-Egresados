<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 * 	idEncuesta : INT
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario o idEncuesta
 *  -2 : No existe el idUsuario o idEncuesta en la base de datos
 *	-3 : Error en consultas para insertar y borrar
*/

if(!isset($_POST['idUsuario']) || !isset($_POST['idEncuesta'])) {
    echo -1;
    $conn->close();
    exit();
} else {
    $idUsuario = $_POST['idUsuario'];
    $idEncuesta = $_POST['idEncuesta'];
}

$sqlUsuario = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";
$resUsuario = mysqli_query($conn, $sqlUsuario);

$sqlEncuesta = "SELECT idEncuesta, Nombre FROM Encuesta WHERE idEncuesta = ${idEncuesta}";
$resEncuesta = mysqli_query($conn, $sqlEncuesta);

if ($resUsuario->num_rows == 0 || $resEncuesta->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$nombre = mysqli_fetch_array($resEncuesta)['Nombre'];
$sqlInsert = "INSERT INTO Encuestas_Contestadas(Encuesta_idEncuesta, Nombre, Usuario_idUsuario)
              VALUES(${idEncuesta}, '${nombre}', ${idUsuario})";
$sqlDelete = "DELETE FROM Encuestas_Pendientes WHERE Encuesta_idEncuesta = ${idEncuesta} AND Usuario_idUsuario = ${idUsuario}";

if (!mysqli_query($conn, $sqlInsert) || !mysqli_query($conn, $sqlDelete)) {
    echo -3;
} else {
    echo 0;
}

$conn->close();