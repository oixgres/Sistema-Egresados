<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT
 * 	password  : VARCHAR(45)
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario o contraseña
 *  -2 : No existe el idUsuario en la base de datos
 *	-3 : Error en la consulta
*/

if(isset($_POST['idUsuario']) && isset($_POST['password'])) {
    $idUsuario = $_POST['idUsuario'];
    $password = $_POST['password'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "UPDATE Usuario SET Password = '${password}' WHERE idUsuario = ${idUsuario}";
if(mysqli_query($conn, $sql)) {
    echo 0;
} else {
    echo -3;
}

$conn->close();