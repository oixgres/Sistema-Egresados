<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 *
 * Devuelve:
 * 	0 : Operacion exitosa
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe pregunta o usuario
 *  -3 : Error al eliminar
*/
/*
if (!isset($_POST['idUsuario'])){
    echo -1;
    $conn->close();
    exit();
} else {
    $idUsuario = $_POST['idUsuario'];
}
*/
$idUsuario = $_POST['idUsuario'];

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = {$idUsuario}";
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "DELETE FROM Usuario WHERE idUsuario = {$idUsuario}";
if (mysqli_query($conn, $sql)) {
    echo mysqli_insert_id($conn);
} else {
    echo -3;
}

$conn->close();